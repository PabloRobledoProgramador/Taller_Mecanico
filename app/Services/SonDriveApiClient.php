<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use UnexpectedValueException;

class SonDriveApiClient
{
    public function vehicles(): array
    {
        $response = $this->request()
            ->withToken($this->token())
            ->get($this->endpoint('api/Vehiculo'))
            ->throw();

        $vehicles = $response->json();

        if (! is_array($vehicles) || ! array_is_list($vehicles)) {
            throw new UnexpectedValueException('SonDrive devolvió una lista de vehículos con formato inválido.');
        }

        return array_map(fn (array $vehicle) => [
            'id' => $this->field($vehicle, 'id', 'Id'),
            'name' => $this->field($vehicle, 'nombreVehiculo', 'NombreVehiculo'),
            'plate' => $this->field($vehicle, 'placa', 'Placa'),
            'model' => $this->field($vehicle, 'modelo', 'Modelo'),
            'model_year' => $this->field($vehicle, 'annoModelo', 'AnnoModelo'),
            'type' => $this->field($vehicle, 'tipo', 'Tipo'),
            'status' => $this->field($vehicle, 'estado', 'Estado'),
            'mileage' => $this->field($vehicle, 'kilometraje', 'Kilometraje'),
            'idUsuario' => $this->field($vehicle, 'idUsuario', 'IdUsuario'),
        ], $vehicles);
    }

    public function vehicle(int $id): array
    {
        $response = $this->request()
            ->withToken($this->token())
            ->get($this->endpoint("api/Vehiculo/{$id}"))
            ->throw();

        $vehicle = $response->json();

        if (! is_array($vehicle)) {
            throw new UnexpectedValueException('SonDrive devolvió un vehículo con formato inválido.');
        }

        return [
            'id' => $this->field($vehicle, 'id', 'Id'),
            'idUsuario' => $this->field($vehicle, 'idUsuario', 'IdUsuario'),
            'placa' => $this->field($vehicle, 'placa', 'Placa'),
            'modelo' => $this->field($vehicle, 'modelo', 'Modelo'),
            'annoModelo' => $this->field($vehicle, 'annoModelo', 'AnnoModelo'),
            'tipo' => $this->field($vehicle, 'tipo', 'Tipo'),
            'kilometraje' => $this->field($vehicle, 'kilometraje', 'Kilometraje'),
            'fechaUltimoServicio' => $this->field($vehicle, 'fechaUltimoServicio', 'FechaUltimoServicio'),
            'vencimientoSoat' => $this->nestedField($vehicle, 'soat', 'Soat', 'vencimiento', 'Vencimiento'),
            'vencimientoTecnomecanica' => $this->nestedField($vehicle, 'tecnomecanica', 'Tecnomecanica', 'vencimiento', 'Vencimiento'),
            'vencimientoLicencia' => $this->nestedField($vehicle, 'licencia', 'Licencia', 'vencimiento', 'Vencimiento'),
        ];
    }

    public function createVehicle(array $vehicle): void
    {
        $this->request()
            ->withToken($this->token())
            ->post($this->endpoint('api/Vehiculo'), $vehicle)
            ->throw();
    }

    public function updateVehicle(int $id, array $vehicle): void
    {
        $this->request()
            ->withToken($this->token())
            ->put($this->endpoint("api/Vehiculo/{$id}"), $vehicle)
            ->throw();
    }

    public function deleteVehicle(int $id): void
    {
        $this->request()
            ->withToken($this->token())
            ->delete($this->endpoint("api/Vehiculo/{$id}"))
            ->throw();
    }

    private function token(): string
    {
        $baseUrl = (string) config('services.sondrive.base_url');
        $email = (string) config('services.sondrive.email');
        $password = (string) config('services.sondrive.password');

        if ($baseUrl === '' || $email === '' || $password === '') {
            throw new InvalidArgumentException('La integración con SonDrive no está configurada.');
        }

        $cacheKey = 'sondrive.token.'.hash('sha256', $baseUrl."\0".$email."\0".$password);
        $cachedToken = Cache::get($cacheKey);

        if (is_string($cachedToken) && $cachedToken !== '') {
            return $cachedToken;
        }

        $response = $this->request()
            ->post($this->endpoint('api/Autenticacion/iniciar-sesion'), [
                'correo' => $email,
                'clave' => $password,
            ])
            ->throw();

        $token = $response->json('token');
        $expiresAt = $response->json('expiracion');

        if (! is_string($token) || $token === '' || ! is_string($expiresAt) || $expiresAt === '') {
            throw new UnexpectedValueException('SonDrive devolvió una respuesta de autenticación inválida.');
        }

        $cacheUntil = Carbon::parse($expiresAt)->subMinute();

        if ($cacheUntil->isPast()) {
            throw new UnexpectedValueException('SonDrive devolvió un token vencido o próximo a vencer.');
        }

        Cache::put($cacheKey, $token, $cacheUntil);

        return $token;
    }

    private function request(): PendingRequest
    {
        return Http::acceptJson()
            ->asJson()
            ->timeout(15);
    }

    private function endpoint(string $path): string
    {
        return rtrim((string) config('services.sondrive.base_url'), '/').'/'.ltrim($path, '/');
    }

    private function field(array $vehicle, string $camelCase, string $pascalCase): mixed
    {
        return $vehicle[$camelCase] ?? $vehicle[$pascalCase] ?? null;
    }

    private function nestedField(
        array $vehicle,
        string $camelCase,
        string $pascalCase,
        string $nestedCamelCase,
        string $nestedPascalCase
    ): mixed {
        $document = $this->field($vehicle, $camelCase, $pascalCase);

        return is_array($document)
            ? $this->field($document, $nestedCamelCase, $nestedPascalCase)
            : null;
    }
}
