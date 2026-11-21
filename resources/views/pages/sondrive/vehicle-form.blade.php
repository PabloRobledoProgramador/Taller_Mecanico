@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb :pageTitle="$editing ? 'Editar vehículo SonDrive' : 'Nuevo vehículo SonDrive'" />

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
            <h2 class="mb-2 text-lg font-semibold text-gray-800 dark:text-white/90">
                {{ $editing ? 'Editar vehículo' : 'Registrar vehículo' }}
            </h2>
            <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                Los cambios se guardarán directamente en SonDrive. El ID del conductor debe corresponder a un conductor activo de SonDrive.
            </p>

            @if ($errors->has('sondrive'))
                <div class="mb-5 rounded-lg border border-error-200 bg-error-50 px-4 py-3 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/10 dark:text-error-400">
                    {{ $errors->first('sondrive') }}
                </div>
            @endif

            <form
                method="POST"
                action="{{ $editing ? route('sondrive.vehicles.update', $vehicle['id']) : route('sondrive.vehicles.store') }}"
                class="space-y-5"
            >
                @csrf
                @if ($editing)
                    @method('PUT')
                @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="idUsuario" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            ID del conductor en SonDrive
                        </label>
                        <input
                            id="idUsuario"
                            name="idUsuario"
                            type="number"
                            min="1"
                            required
                            value="{{ old('idUsuario', $vehicle['idUsuario'] ?? '') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('idUsuario') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="placa" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Placa
                        </label>
                        <input
                            id="placa"
                            name="placa"
                            type="text"
                            required
                            maxlength="7"
                            placeholder="ABC 123"
                            value="{{ old('placa', $vehicle['placa'] ?? '') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('placa') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="modelo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Modelo
                        </label>
                        <input
                            id="modelo"
                            name="modelo"
                            type="text"
                            required
                            maxlength="100"
                            value="{{ old('modelo', $vehicle['modelo'] ?? '') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('modelo') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="annoModelo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Año del modelo
                        </label>
                        <input
                            id="annoModelo"
                            name="annoModelo"
                            type="number"
                            min="1990"
                            max="{{ now()->year + 1 }}"
                            required
                            value="{{ old('annoModelo', $vehicle['annoModelo'] ?? '') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('annoModelo') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tipo" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Tipo de vehículo
                        </label>
                        <input
                            id="tipo"
                            name="tipo"
                            type="text"
                            maxlength="50"
                            required
                            value="{{ old('tipo', $vehicle['tipo'] ?? '') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('tipo') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="kilometraje" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Kilometraje
                        </label>
                        <input
                            id="kilometraje"
                            name="kilometraje"
                            type="number"
                            min="0"
                            required
                            value="{{ old('kilometraje', $vehicle['kilometraje'] ?? '0') }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('kilometraje') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="fechaUltimoServicio" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Fecha del último servicio
                        </label>
                        <input
                            id="fechaUltimoServicio"
                            name="fechaUltimoServicio"
                            type="date"
                            max="{{ today()->toDateString() }}"
                            value="{{ old('fechaUltimoServicio', substr((string) ($vehicle['fechaUltimoServicio'] ?? ''), 0, 10)) }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('fechaUltimoServicio') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="vencimientoSoat" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Vencimiento del SOAT
                        </label>
                        <input
                            id="vencimientoSoat"
                            name="vencimientoSoat"
                            type="date"
                            required
                            value="{{ old('vencimientoSoat', substr((string) ($vehicle['vencimientoSoat'] ?? ''), 0, 10)) }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('vencimientoSoat') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="vencimientoTecnomecanica" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Vencimiento de la tecnomecánica
                        </label>
                        <input
                            id="vencimientoTecnomecanica"
                            name="vencimientoTecnomecanica"
                            type="date"
                            required
                            value="{{ old('vencimientoTecnomecanica', substr((string) ($vehicle['vencimientoTecnomecanica'] ?? ''), 0, 10)) }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('vencimientoTecnomecanica') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="vencimientoLicencia" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Vencimiento de la licencia
                        </label>
                        <input
                            id="vencimientoLicencia"
                            name="vencimientoLicencia"
                            type="date"
                            required
                            value="{{ old('vencimientoLicencia', substr((string) ($vehicle['vencimientoLicencia'] ?? ''), 0, 10)) }}"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
                        >
                        @error('vencimientoLicencia') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        {{ $editing ? 'Guardar cambios' : 'Crear vehículo' }}
                    </button>
                    <a
                        href="{{ route('sondrive.vehicles.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
