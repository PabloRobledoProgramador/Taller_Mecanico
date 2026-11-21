<?php

namespace App\Http\Controllers;

use App\Services\SonDriveApiClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use UnexpectedValueException;

class SonDriveVehicleController extends Controller
{
    public function index(SonDriveApiClient $sonDrive): View
    {
        try {
            $vehicles = $sonDrive->vehicles();
        } catch (ConnectionException $exception) {
            Log::warning('No fue posible conectar con la API de SonDrive.', [
                'exception' => $exception::class,
            ]);

            abort(502, 'No fue posible conectar con SonDrive. Intenta de nuevo más tarde.');
        } catch (RequestException $exception) {
            Log::warning('La API de SonDrive rechazó la consulta de vehículos.', [
                'status' => $exception->response->status(),
            ]);

            abort(502, 'SonDrive no pudo completar la consulta de vehículos.');
        } catch (UnexpectedValueException $exception) {
            Log::warning('La API de SonDrive devolvió una respuesta inválida.', [
                'exception' => $exception::class,
            ]);

            abort(502, 'SonDrive devolvió una respuesta que no se pudo procesar.');
        }

        return view('pages.sondrive.vehicles', [
            'vehicles' => $vehicles,
        ]);
    }

    public function create(): View
    {
        return view('pages.sondrive.vehicle-form', [
            'vehicle' => [],
            'editing' => false,
        ]);
    }

    public function store(Request $request, SonDriveApiClient $sonDrive): RedirectResponse
    {
        $vehicle = $this->validatedVehicle($request);

        try {
            $sonDrive->createVehicle($vehicle);
        } catch (ConnectionException|RequestException $exception) {
            return $this->apiFailure($exception);
        }

        return redirect()
            ->route('sondrive.vehicles.index')
            ->with('status', 'Vehículo creado correctamente en SonDrive.');
    }

    public function edit(int $vehicle, SonDriveApiClient $sonDrive): View|RedirectResponse
    {
        try {
            $vehicleData = $sonDrive->vehicle($vehicle);
        } catch (ConnectionException|RequestException $exception) {
            return $this->apiFailure($exception);
        } catch (UnexpectedValueException $exception) {
            Log::warning('SonDrive devolvió un vehículo con formato inválido.', [
                'exception' => $exception::class,
            ]);

            abort(502, 'SonDrive devolvió una respuesta que no se pudo procesar.');
        }

        return view('pages.sondrive.vehicle-form', [
            'vehicle' => $vehicleData,
            'editing' => true,
        ]);
    }

    public function update(Request $request, int $vehicle, SonDriveApiClient $sonDrive): RedirectResponse
    {
        $vehicleData = $this->validatedVehicle($request);

        try {
            $sonDrive->updateVehicle($vehicle, $vehicleData);
        } catch (ConnectionException|RequestException $exception) {
            return $this->apiFailure($exception);
        }

        return redirect()
            ->route('sondrive.vehicles.index')
            ->with('status', 'Vehículo actualizado correctamente en SonDrive.');
    }

    public function destroy(int $vehicle, SonDriveApiClient $sonDrive): RedirectResponse
    {
        try {
            $sonDrive->deleteVehicle($vehicle);
        } catch (ConnectionException|RequestException $exception) {
            return $this->apiFailure($exception);
        }

        return redirect()
            ->route('sondrive.vehicles.index')
            ->with('status', 'Vehículo eliminado de SonDrive.');
    }

    private function validatedVehicle(Request $request): array
    {
        $vehicle = $request->validate([
            'idUsuario' => ['required', 'integer', 'min:1'],
            'placa' => ['required', 'regex:/^[A-Za-z]{3}\s?\d{3}$/'],
            'modelo' => ['required', 'string', 'max:100'],
            'annoModelo' => ['required', 'digits:4', 'integer', 'between:1990,'.(now()->year + 1)],
            'tipo' => ['required', 'string', 'max:50'],
            'kilometraje' => ['required', 'integer', 'min:0'],
            'fechaUltimoServicio' => ['nullable', 'date', 'before_or_equal:today'],
            'vencimientoSoat' => ['required', 'date'],
            'vencimientoTecnomecanica' => ['required', 'date'],
            'vencimientoLicencia' => ['required', 'date'],
        ]);

        $vehicle['idUsuario'] = (int) $vehicle['idUsuario'];
        $vehicle['kilometraje'] = (int) $vehicle['kilometraje'];

        return $vehicle;
    }

    private function apiFailure(ConnectionException|RequestException $exception): RedirectResponse
    {
        if ($exception instanceof ConnectionException) {
            Log::warning('No fue posible conectar con la API de SonDrive.', [
                'exception' => $exception::class,
            ]);

            return back()
                ->withInput()
                ->withErrors(['sondrive' => 'No fue posible conectar con SonDrive. Intenta de nuevo más tarde.']);
        }

        $status = $exception->response->status();
        Log::warning('SonDrive rechazó una operación sobre vehículos.', [
            'status' => $status,
        ]);

        $remoteErrors = $exception->response->json('errors');

        if (is_array($remoteErrors)) {
            $errors = [];
            foreach ($remoteErrors as $field => $messages) {
                $field = lcfirst((string) $field);
                foreach ((array) $messages as $message) {
                    if (is_string($message)) {
                        $errors[$field][] = $message;
                    }
                }
            }

            if ($errors !== []) {
                $errors['sondrive'][] = implode(' ', array_merge(...array_values($errors)));

                return back()->withInput()->withErrors($errors);
            }
        }

        return back()
            ->withInput()
            ->withErrors(['sondrive' => "SonDrive rechazó la operación (HTTP {$status})."]);
    }
}
