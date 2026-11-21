@props(['monthlyRepairCounts'])

<div class="rounded-2xl border border-gray-200 bg-white px-5 pb-5 pt-5 dark:border-gray-800 dark:bg-gray-900 sm:px-6 sm:pt-6">
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Reparaciones por mes
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Reparaciones según su fecha de inicio, este año
        </p>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div
            id="chartThree"
            class="-ml-4 min-w-[700px] pl-2 xl:min-w-full"
            data-monthly-repair-counts='@json($monthlyRepairCounts)'
        ></div>
    </div>
</div>