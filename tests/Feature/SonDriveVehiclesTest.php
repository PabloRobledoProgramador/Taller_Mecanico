<?php

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'services.sondrive.base_url' => 'https://sondrive.test',
        'services.sondrive.email' => 'integration@example.test',
        'services.sondrive.password' => 'test-password',
    ]);

    Cache::flush();
});

it('allows administrators to view a limited vehicle list from SonDrive', function () {
    Http::fake([
        'sondrive.test/api/Autenticacion/iniciar-sesion' => Http::response([
            'token' => 'test-jwt-token',
            'expiracion' => now()->addHour()->toIso8601String(),
        ]),
        'sondrive.test/api/Vehiculo' => Http::response([[
            'id' => 7,
            'nombreVehiculo' => 'Van',
            'placa' => 'ABC123',
            'modelo' => 'Transit',
            'annoModelo' => '2024',
            'tipo' => 'Van',
            'estado' => 'Activo',
            'kilometraje' => 12000,
            'conductor' => 'Información privada',
            'fotoConductor' => 'private-photo.jpg',
        ]]),
    ]);

    $this->actingAs(User::factory()->admin()->create())
        ->get('/sondrive/vehicles')
        ->assertOk()
        ->assertSee('ABC123')
        ->assertSee('Transit')
        ->assertDontSee('Información privada')
        ->assertDontSee('private-photo.jpg');

    Http::assertSent(fn (Request $request) => $request->url() === 'https://sondrive.test/api/Vehiculo'
        && $request->hasHeader('Authorization', 'Bearer test-jwt-token'));
});

it('denies non-admin users access to SonDrive fleet data', function () {
    Http::fake();

    $this->actingAs(User::factory()->mecanico()->create())
        ->get('/sondrive/vehicles')
        ->assertForbidden();

    Http::assertNothingSent();
});

it('creates a vehicle through the SonDrive API', function () {
    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/api/Autenticacion/iniciar-sesion')) {
            return Http::response([
                'token' => 'test-jwt-token',
                'expiracion' => now()->addHour()->toIso8601String(),
            ]);
        }

        return Http::response(['id' => 28], 201);
    });

    $payload = sonDriveVehiclePayload();

    $this->actingAs(User::factory()->admin()->create())
        ->post('/sondrive/vehicles', $payload)
        ->assertRedirect('/sondrive/vehicles')
        ->assertSessionHas('status');

    Http::assertSent(fn (Request $request) => $request->method() === 'POST'
        && $request->url() === 'https://sondrive.test/api/Vehiculo'
        && $request->hasHeader('Authorization', 'Bearer test-jwt-token')
        && $request->data() === $payload);
});

it('loads a vehicle from SonDrive for editing without exposing driver details', function () {
    Http::fake([
        'sondrive.test/api/Autenticacion/iniciar-sesion' => Http::response([
            'token' => 'test-jwt-token',
            'expiracion' => now()->addHour()->toIso8601String(),
        ]),
        'sondrive.test/api/Vehiculo/7' => Http::response([
            'id' => 7,
            'idUsuario' => 4,
            'placa' => 'ABC 123',
            'modelo' => 'Transit',
            'annoModelo' => '2024',
            'tipo' => 'Van',
            'kilometraje' => 12000,
            'fechaUltimoServicio' => '2025-01-15T00:00:00',
            'conductor' => 'Información privada',
            'soat' => ['vencimiento' => '2026-07-01T00:00:00', 'diasRestantes' => 90],
            'tecnomecanica' => ['vencimiento' => '2026-08-01T00:00:00', 'diasRestantes' => 120],
            'licencia' => ['vencimiento' => '2026-09-01T00:00:00', 'diasRestantes' => 150],
        ]),
    ]);

    $this->actingAs(User::factory()->admin()->create())
        ->get('/sondrive/vehicles/7/edit')
        ->assertOk()
        ->assertSee('value="ABC 123"', false)
        ->assertSee('value="2026-07-01"', false)
        ->assertDontSee('Información privada');

    Http::assertSent(fn (Request $request) => $request->method() === 'GET'
        && $request->url() === 'https://sondrive.test/api/Vehiculo/7'
        && $request->hasHeader('Authorization', 'Bearer test-jwt-token'));
});

it('updates a vehicle through the SonDrive API', function () {
    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/api/Autenticacion/iniciar-sesion')) {
            return Http::response([
                'token' => 'test-jwt-token',
                'expiracion' => now()->addHour()->toIso8601String(),
            ]);
        }

        return Http::response(['id' => 7]);
    });

    $payload = sonDriveVehiclePayload();
    $payload['modelo'] = 'Transit actualizado';

    $this->actingAs(User::factory()->admin()->create())
        ->put('/sondrive/vehicles/7', $payload)
        ->assertRedirect('/sondrive/vehicles')
        ->assertSessionHas('status');

    Http::assertSent(fn (Request $request) => $request->method() === 'PUT'
        && $request->url() === 'https://sondrive.test/api/Vehiculo/7'
        && $request->hasHeader('Authorization', 'Bearer test-jwt-token')
        && $request->data() === $payload);
});

it('deletes a vehicle through the SonDrive API', function () {
    Http::fake(function (Request $request) {
        if (str_ends_with($request->url(), '/api/Autenticacion/iniciar-sesion')) {
            return Http::response([
                'token' => 'test-jwt-token',
                'expiracion' => now()->addHour()->toIso8601String(),
            ]);
        }

        return Http::response(null, 204);
    });

    $this->actingAs(User::factory()->admin()->create())
        ->delete('/sondrive/vehicles/7')
        ->assertRedirect('/sondrive/vehicles')
        ->assertSessionHas('status');

    Http::assertSent(fn (Request $request) => $request->method() === 'DELETE'
        && $request->url() === 'https://sondrive.test/api/Vehiculo/7'
        && $request->hasHeader('Authorization', 'Bearer test-jwt-token'));
});

it('validates vehicle data before making a SonDrive request', function () {
    Http::fake();

    $this->actingAs(User::factory()->admin()->create())
        ->post('/sondrive/vehicles', ['placa' => 'invalid'])
        ->assertSessionHasErrors(['idUsuario', 'placa', 'modelo', 'annoModelo', 'tipo', 'kilometraje']);

    Http::assertNothingSent();
});

it('denies non-admin users from changing SonDrive vehicles', function () {
    Http::fake();

    $this->actingAs(User::factory()->mecanico()->create())
        ->delete('/sondrive/vehicles/7')
        ->assertForbidden();

    Http::assertNothingSent();
});

function sonDriveVehiclePayload(): array
{
    return [
        'idUsuario' => 4,
        'placa' => 'ABC 123',
        'modelo' => 'Transit',
        'annoModelo' => (string) now()->year,
        'tipo' => 'Van',
        'kilometraje' => 12000,
        'fechaUltimoServicio' => '2025-01-15',
        'vencimientoSoat' => '2026-07-01',
        'vencimientoTecnomecanica' => '2026-08-01',
        'vencimientoLicencia' => '2026-09-01',
    ];
}
