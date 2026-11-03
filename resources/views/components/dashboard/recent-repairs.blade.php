@props(['repairs'])

<div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 dark:border-gray-800 dark:bg-gray-900 sm:px-6">
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                Reparaciones recientes
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Últimos trabajos registrados en el taller
            </p>
        </div>

        <a
            href="{{ route('repairs.index') }}"
            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300"
        >
            Ver todas
        </a>
    </div>

    @if ($repairs->isEmpty())
        <div class="border-t border-gray-100 py-8 text-center dark:border-gray-800">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Todavía no hay reparaciones registradas.
            </p>
        </div>
    @else
        <div class="max-w-full overflow-x-auto custom-scrollbar">
            <table class="min-w-full">
                <thead>
                    <tr class="border-t border-gray-100 dark:border-gray-800">
                        <th class="py-3 text-start text-xs font-medium text-gray-500">Vehículo</th>
                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500">Cliente</th>
                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500">Fecha</th>
                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500">Estado</th>
                        <th class="px-4 py-3 text-start text-xs font-medium text-gray-500">Mecánico</th>
                        <th class="px-4 py-3 text-end text-xs font-medium text-gray-500">Costo</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($repairs as $repair)
                        @php
                            $statusLabel = match ($repair->status) {
                                'en_taller' => 'En taller',
                                'en_proceso' => 'En proceso',
                                'completada' => 'Completada',
                                'cancelada' => 'Cancelada',
                                default => $repair->status,
                            };

                            $statusClass = match ($repair->status) {
                                'completada' => 'bg-success-50 text-success-600 dark:bg-success-500/10 dark:text-success-400',
                                'en_proceso' => 'bg-warning-50 text-warning-600 dark:bg-warning-500/10 dark:text-warning-400',
                                'cancelada' => 'bg-error-50 text-error-600 dark:bg-error-500/10 dark:text-error-400',
                                default => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300',
                            };
                        @endphp

                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <td class="whitespace-nowrap py-3">
                                <a
                                    href="{{ route('repairs.edit', $repair) }}"
                                    class="text-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
                                >
                                    {{ $repair->vehicle?->license_plate ?? 'Vehículo no disponible' }}
                                </a>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $repair->vehicle?->brand }} {{ $repair->vehicle?->model }}
                                </p>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $repair->vehicle?->customer?->name ?? 'Sin cliente' }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $repair->date?->format('d/m/Y') }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3">
                                <span class="rounded-full px-2 py-1 text-xs font-medium {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $repair->mechanic?->name ?? 'Sin asignar' }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 text-end text-sm text-gray-600 dark:text-gray-400">
                                ${{ number_format((float) $repair->total_cost, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>