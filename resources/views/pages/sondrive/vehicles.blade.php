@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Flota SonDrive" />

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Vehículos de SonDrive
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ count($vehicles) }} vehículos en total
                </p>
            </div>
            <a
                href="{{ route('sondrive.vehicles.create') }}"
                class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
            >
                Crear vehículo
            </a>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-lg border border-success-200 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/10 dark:text-success-400">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('sondrive'))
            <div class="mb-4 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400">
                {{ $errors->first('sondrive') }}
            </div>
        @endif

        @if (count($vehicles) === 0)
            <div class="border-t border-gray-100 py-10 text-center dark:border-gray-800">
                <p class="font-medium text-gray-800 dark:text-white/90">
                    No hay vehículos para mostrar
                </p>
            </div>
        @else
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <th class="px-4 py-3 text-start"><span class="font-medium text-gray-500 text-theme-xs">Placa</span></th>
                            <th class="px-4 py-3 text-start"><span class="font-medium text-gray-500 text-theme-xs">Vehículo</span></th>
                            <th class="px-4 py-3 text-start"><span class="font-medium text-gray-500 text-theme-xs">Tipo</span></th>
                            <th class="px-4 py-3 text-start"><span class="font-medium text-gray-500 text-theme-xs">Estado</span></th>
                            <th class="px-4 py-3 text-end"><span class="font-medium text-gray-500 text-theme-xs">Kilometraje</span></th>
                            <th class="px-4 py-3 text-end"><span class="font-medium text-gray-500 text-theme-xs">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    {{ $vehicle['plate'] ?? 'Sin placa' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ trim(($vehicle['name'] ?? '').' '.($vehicle['model'] ?? '').' '.($vehicle['model_year'] ?? '')) ?: 'Sin descripción' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $vehicle['type'] ?? 'Sin tipo' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $vehicle['status'] ?? 'Sin estado' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-end text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ isset($vehicle['mileage']) ? number_format((int) $vehicle['mileage']) : 'No registrado' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-end text-theme-sm">
                                    <div class="flex items-center justify-end gap-3">
                                        <a
                                            href="{{ route('sondrive.vehicles.edit', $vehicle['id']) }}"
                                            class="font-medium text-brand-500 hover:text-brand-600"
                                        >
                                            Editar
                                        </a>
                                        <form
                                            method="POST"
                                            action="{{ route('sondrive.vehicles.destroy', $vehicle['id']) }}"
                                            onsubmit="return confirm('¿Eliminar este vehículo de SonDrive? Esta acción no se puede deshacer.');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-error-500 hover:text-error-600">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
