@props(['monthlyIncome'])

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">
            Valor de reparaciones por mes
        </h3>

        <x-common.dropdown-menu />
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div
            id="chartOne"
            class="-ml-5 h-full min-w-[690px] pl-2 xl:min-w-full"
            data-monthly-income='@json($monthlyIncome)'
        ></div>
    </div>
</div>
