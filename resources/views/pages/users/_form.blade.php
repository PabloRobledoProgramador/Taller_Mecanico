<div>
    <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Nombre
    </label>

    <input
        id="name"
        name="name"
        type="text"
        value="{{ old('name', $user->name) }}"
        required
        maxlength="255"
        autocomplete="name"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('name')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Correo electrónico
    </label>

    <input
        id="email"
        name="email"
        type="email"
        value="{{ old('email', $user->email) }}"
        required
        maxlength="255"
        autocomplete="email"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @error('email')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="role" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Rol
    </label>

    <select
        id="role"
        name="role"
        required
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        @foreach (\App\Enums\Role::cases() as $role)
            <option
                value="{{ $role->value }}"
                @selected(old('role', $user->role?->value ?? 'cliente') === $role->value)
            >
                {{ $role->label() }}
            </option>
        @endforeach
    </select>

    @error('role')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        {{ $isEditing ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
    </label>

    <input
        id="password"
        name="password"
        type="password"
        autocomplete="new-password"
        @if (!$isEditing) required @endif
        minlength="8"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >

    @if ($isEditing)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Déjala vacía si no quieres cambiar la contraseña.
        </p>
    @endif

    @error('password')
        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Confirmar contraseña
    </label>

    <input
        id="password_confirmation"
        name="password_confirmation"
        type="password"
        autocomplete="new-password"
        @if (!$isEditing) required @endif
        minlength="8"
        class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
</div>
