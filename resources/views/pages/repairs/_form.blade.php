<div>
    <label for="vehicle_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Vehículo
    </label>

    <select
        id="vehicle_id"
        name="vehicle_id"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        <option value="">Selecciona un vehículo</option>

        @foreach ($vehicles as $vehicle)
            <option
                value="{{ $vehicle->id }}"
                @selected((string) old('vehicle_id', $repair->vehicle_id) === (string) $vehicle->id)
            >
                {{ $vehicle->license_plate }} — {{ $vehicle->brand }} {{ $vehicle->model }}
                @if ($vehicle->customer)
                    ({{ $vehicle->customer->name }})
                @endif
            </option>
        @endforeach
    </select>

    @error('vehicle_id')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="mechanic_id" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Mecánico
    </label>

    <select
        id="mechanic_id"
        name="mechanic_id"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        <option value="">Sin asignar</option>

        @foreach ($mechanics as $mechanic)
            <option
                value="{{ $mechanic->id }}"
                @selected((string) old('mechanic_id', $repair->mechanic_id) === (string) $mechanic->id)
            >
                {{ $mechanic->name }}
            </option>
        @endforeach
    </select>

    @error('mechanic_id')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="starts_at" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Inicio
    </label>

    <input
        id="starts_at"
        name="starts_at"
        type="datetime-local"
        value="{{ old('starts_at', $repair->starts_at?->format('Y-m-d\\TH:i') ?? now()->format('Y-m-d\\TH:i')) }}"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('starts_at')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="ends_at" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Fin
    </label>

    <input
        id="ends_at"
        name="ends_at"
        type="datetime-local"
        value="{{ old('ends_at', $repair->ends_at?->format('Y-m-d\\TH:i') ?? now()->addHour()->format('Y-m-d\\TH:i')) }}"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('ends_at')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="status" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Estado
    </label>

    <select
        id="status"
        name="status"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        @foreach ($statusOptions as $value => $label)
            <option
                value="{{ $value }}"
                @selected(old('status', $repair->status ?? 'en_taller') === $value)
            >
                {{ $label }}
            </option>
        @endforeach
    </select>

    @error('status')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="job_description" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Descripción del trabajo
    </label>

    <textarea
        id="job_description"
        name="job_description"
        rows="4"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >{{ old('job_description', $repair->job_description) }}</textarea>

    @error('job_description')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="total_cost" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Costo total
    </label>

    <input
        id="total_cost"
        name="total_cost"
        type="number"
        min="0"
        max="99999999.99"
        step="0.01"
        value="{{ old('total_cost', $repair->total_cost ?? '0.00') }}"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('total_cost')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>