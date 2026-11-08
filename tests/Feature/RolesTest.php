<?php

use App\Enums\Role;
use App\Models\User;
use App\Notifications\RoleChangedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

test('un usuario que se registra queda como mecanico', function () {
    $this->post('/register', [
        'name' => 'Nuevo',
        'email' => 'nuevo@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    expect(User::where('email', 'nuevo@example.com')->first()->role)->toBe(Role::Mecanico);
});

test('no se puede asignar el rol por mass assignment', function () {
    $user = User::create([
        'name' => 'X', 'email' => 'x@example.com', 'password' => 'password', 'role' => 'admin',
    ]);

    expect($user->fresh()->role)->toBe(Role::Mecanico);
});

test('el middleware role deja pasar solo a los roles permitidos', function () {
    Route::middleware(['web', 'auth', 'role:admin'])->get('/solo-admin', fn () => 'ok');

    $this->actingAs(User::factory()->mecanico()->create())->get('/solo-admin')->assertForbidden();
    $this->actingAs(User::factory()->admin()->create())->get('/solo-admin')->assertOk();
});

test('cambiar el rol notifica por correo y base de datos', function () {
    Notification::fake();
    $user = User::factory()->mecanico()->create();

    $user->changeRole(Role::Admin);

    expect($user->fresh()->role)->toBe(Role::Admin);
    Notification::assertSentTo($user, RoleChangedNotification::class, function ($n, $channels) {
        return $channels === ['database', 'mail'];
    });
});

test('las notificaciones se pueden marcar como leidas', function () {
    $user = User::factory()->create();
    $user->notify(new RoleChangedNotification(Role::Admin));

    $this->actingAs($user)->post('/notifications/read-all')->assertRedirect();

    expect($user->unreadNotifications()->count())->toBe(0);
});

test('el mecanico entra al taller pero no a usuarios', function () {
    $mecanico = User::factory()->mecanico()->create();

    $this->actingAs($mecanico)->get('/customers')->assertOk();
    $this->actingAs($mecanico)->get('/users')->assertForbidden();
});

test('el login lleva directo al dashboard sin pedir verificar el correo', function () {
    $user = User::factory()->unverified()->create();

    $this->post('/login', ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('dashboard', absolute: false));

    $this->actingAs($user)->get('/dashboard')->assertOk();
});

test('el admin puede crear un usuario con rol', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->post('/users', [
        'name' => 'Pedro',
        'email' => 'pedro@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'mecanico',
    ])->assertRedirect(route('users.index'));

    expect(User::where('email', 'pedro@example.com')->first()->role)->toBe(Role::Mecanico);
});

test('el admin no puede cambiarse su propio rol', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)->put("/users/{$admin->id}", [
        'name' => $admin->name,
        'email' => $admin->email,
        'role' => 'mecanico',
    ]);

    expect($admin->fresh()->role)->toBe(Role::Admin);
});
