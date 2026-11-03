@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Detalle del vehículo" />

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    {{ $vehicle->brand }} {{ $vehicle->model }}
                </h2>

                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('vehicles.edit', $vehicle) }}"
                        class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        Editar
                    </a>

                    <a
                        href="{{ route('vehicles.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                    >
                        Volver
                    </a>
                </div>
            </div>

            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Placa</dt>
                    <dd class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $vehicle->license_plate }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Cliente</dt>
                    <dd class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $vehicle->customer?->name ?? 'Sin cliente asignado' }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Marca</dt>
                    <dd class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $vehicle->brand }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Modelo</dt>
                    <dd class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $vehicle->model }}
                    </dd>
                </div>

                <div>
                    <dt class="text-sm text-gray-500 dark:text-gray-400">Año</dt>
                    <dd class="mt-1 font-medium text-gray-800 dark:text-white/90">
                        {{ $vehicle->year ?: 'No registrado' }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white/90">
                Reparaciones
            </h2>

            @if ($vehicle->repairs->isEmpty())
                <p class="py-6 text-sm text-gray-500 dark:text-gray-400">
                    Este vehículo aún no tiene reparaciones registradas.
                </p>
            @else
                <div class="max-w-full overflow-x-auto custom-scrollbar">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <th class="py-3 text-start">
                                    <span class="font-medium text-gray-500 text-theme-xs">Fecha</span>
                                </th>
                                <th class="px-4 py-3 text-start">
                                    <span class="font-medium text-gray-500 text-theme-xs">Estado</span>
                                </th>
                                <th class="px-4 py-3 text-start">
                                    <span class="font-medium text-gray-500 text-theme-xs">Descripción</span>
                                </th>
                                <th class="py-3 text-end">
                                    <span class="font-medium text-gray-500 text-theme-xs">Costo</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($vehicle->repairs as $repair)
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td class="whitespace-nowrap py-3 text-gray-600 text-theme-sm dark:text-gray-400">
                                        {{ $repair->date?->format('d/m/Y') }}
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 text-gray-600 text-theme-sm dark:text-gray-400">
                                        {{ $repair->status }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 text-theme-sm dark:text-gray-400">
                                        {{ $repair->job_description }}
                                    </td>
                                    <td class="whitespace-nowrap py-3 text-end text-gray-600 text-theme-sm dark:text-gray-400">
                                        {{ $repair->total_cost }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection