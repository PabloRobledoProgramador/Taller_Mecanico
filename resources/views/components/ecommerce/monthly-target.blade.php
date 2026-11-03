@props(['monthlyTarget', 'completedThisMonth', 'completedToday', 'monthlyProgress'])

    <div class="rounded-2xl border border-gray-200 bg-gray-100">
        <div class="shadow-default rounded-2xl bg-white px-5 pb-11 pt-5 sm:px-6 sm:pt-6">
            <div class="flex justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Objetivo Mensual
                    </h3>
                    <p class="mt-1 text-theme-sm text-gray-500">
                        Resultados
                    </p>
                </div>
                <!-- Dropdown Menu -->
                <x-common.dropdown-menu />
                <!-- End Dropdown Menu -->

            </div>
            <div class="relative max-h-[195px]">
                {{-- Chart --}}
                <div id="chartTwo" data-progress="{{ $monthlyProgress }}" class="h-full"></div>
                <span class="absolute left-1/2 top-[85%] -translate-x-1/2 -translate-y-[85%] rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-600">{{ number_format($monthlyProgress, 0) }}%</span>
            </div>
                <p class="mx-auto mt-1.5 w-full max-w-[380px] text-center text-sm text-gray-500 dark:text-gray-400 sm:text-base">
                    Este mes has completado reparaciones por valor de
                    <span class="font-semibold text-gray-800 dark:text-white/90">
                        COP ${{ number_format($completedThisMonth, 0, ',', '.') }}
                    </span>.
                    La meta mensual es COP ${{ number_format($monthlyTarget, 0, ',', '.') }}.
                </p>
        </div>

        <div class="grid grid-cols-3 gap-3 px-4 py-4 sm:gap-5 sm:px-6">
        <div class="text-center">
            <p class="mb-1 text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Meta mensual
            </p>
            <p class="text-sm font-semibold text-gray-800 dark:text-white/90 sm:text-base">
                COP ${{ number_format($monthlyTarget, 0, ',', '.') }}
            </p>
        </div>

        <div class="border-s border-gray-200 ps-3 text-center dark:border-gray-700 sm:ps-5">
            <p class="mb-1 text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Completado este mes
            </p>
            <p class="text-sm font-semibold text-gray-800 dark:text-white/90 sm:text-base">
                COP ${{ number_format($completedThisMonth, 0, ',', '.') }}
            </p>
        </div>

        <div class="border-s border-gray-200 ps-3 text-center dark:border-gray-700 sm:ps-5">
            <p class="mb-1 text-theme-xs text-gray-500 dark:text-gray-400 sm:text-sm">
                Completado hoy
            </p>
            <p class="text-sm font-semibold text-gray-800 dark:text-white/90 sm:text-base">
                COP ${{ number_format($completedToday, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

