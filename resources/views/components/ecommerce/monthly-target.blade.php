@props(['monthlyTarget', 'completedThisMonth', 'completedToday', 'monthlyProgress'])

<div class="rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-800 dark:bg-gray-800">
    <div class="rounded-2xl bg-white px-5 pb-8 pt-5 shadow-theme-sm dark:bg-gray-900 sm:px-6 sm:pt-6">
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Objetivo mensual
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Progreso de reparaciones completadas
                </p>
            </div>
            <x-common.dropdown-menu />
        </div>

        <div class="relative mx-auto mt-4 max-w-sm">
            <div id="chartTwo" data-progress="{{ $monthlyProgress }}" class="h-full"></div>
            <span class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%] rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">
                {{ number_format($monthlyProgress, 0) }}%
            </span>
        </div>

        <p class="mx-auto mt-2 max-w-sm text-center text-sm text-gray-500 dark:text-gray-400">
            Este mes has completado reparaciones por valor de
            <span class="font-semibold text-gray-800 dark:text-white/90">
                ${{ number_format($completedThisMonth, 0, ',', '.') }}
            </span>.
            La meta mensual es ${{ number_format($monthlyTarget, 0, ',', '.') }}.
        </p>
    </div>

    <div class="grid grid-cols-3 divide-x divide-gray-200 px-2 py-4 dark:divide-gray-700 sm:px-4">
        <div class="min-w-0 px-1 text-center sm:px-3">
            <p class="mb-1 text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Meta mensual
            </p>
            <p class="text-xs font-semibold text-gray-800 dark:text-white/90 sm:text-sm">
                ${{ number_format($monthlyTarget, 0, ',', '.') }}
            </p>
        </div>

        <div class="min-w-0 px-1 text-center sm:px-3">
            <p class="mb-1 text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Completado este mes
            </p>
            <p class="text-xs font-semibold text-gray-800 dark:text-white/90 sm:text-sm">
                ${{ number_format($completedThisMonth, 0, ',', '.') }}
            </p>
        </div>

        <div class="min-w-0 px-1 text-center sm:px-3">
            <p class="mb-1 text-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Completado hoy
            </p>
            <p class="text-xs font-semibold text-gray-800 dark:text-white/90 sm:text-sm">
                ${{ number_format($completedToday, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>