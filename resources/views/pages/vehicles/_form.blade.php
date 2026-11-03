<div>
    <label for="customer_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Cliente
    </label>

    <select
        id="customer_id"
        name="customer_id"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        <option value="">Selecciona un cliente</option>

        @foreach ($customers as $customer)
            <option
                value="{{ $customer->id }}"
                @selected((string) old('customer_id', $vehicle->customer_id) === (string) $customer->id)
            >
                {{ $customer->name }}
            </option>
        @endforeach
    </select>

    @error('customer_id')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="license_plate" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Placa
    </label>

    <input
        id="license_plate"
        name="license_plate"
        type="text"
        value="{{ old('license_plate', $vehicle->license_plate) }}"
        required
        maxlength="255"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('license_plate')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="brand" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Marca
    </label>

    <input
        id="brand"
        name="brand"
        type="text"
        value="{{ old('brand', $vehicle->brand) }}"
        required
        maxlength="255"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('brand')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="model" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Modelo
    </label>

    <input
        id="model"
        name="model"
        type="text"
        value="{{ old('model', $vehicle->model) }}"
        required
        maxlength="255"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('model')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="year" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Año
    </label>

    <input
        id="year"
        name="year"
        type="number"
        value="{{ old('year', $vehicle->year) }}"
        min="1886"
        max="{{ now()->year + 1 }}"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('year')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>