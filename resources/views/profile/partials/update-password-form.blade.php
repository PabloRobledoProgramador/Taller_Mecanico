<section
    x-data="{
        photoPreview: @js($user->profile_photo_path
            ? asset('storage/' . $user->profile_photo_path)
            : asset('images/user/owner.png'))
    }"
>
    <div class="mb-6 border-b border-gray-100 pb-5 dark:border-gray-800">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            {{ __('Información del perfil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('Actualiza tu foto, nombre y correo electrónico.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
            <img
                :src="photoPreview"
                alt="{{ __('Foto de perfil') }}"
                class="h-24 w-24 rounded-full border border-gray-200 object-cover dark:border-gray-700"
            >

            <div>
                <p class="mb-1 text-sm font-medium text-gray-800 dark:text-white/90">
                    {{ __('Tu foto de perfil') }}
                </p>
                <p id="photo-help" class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('JPG, PNG o WebP. Tamaño máximo: 5 MB.') }}
                </p>

                <input
                    id="photo"
                    name="photo"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="sr-only"
                    aria-describedby="photo-help"
                    @change="if ($event.target.files.length) photoPreview = URL.createObjectURL($event.target.files[0])"
                >
                <label
                    for="photo"
                    class="inline-flex cursor-pointer items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
                >
                    {{ __('Seleccionar imagen') }}
                </label>
                @error('photo')
                    <p class="mt-2 text-sm text-error-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                {{ __('Nombre') }}
            </label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autocomplete="name"
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
            @error('name')
                <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                {{ __('Correo electrónico') }}
            </label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >
            @error('email')
                <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                {{ __('Guardar cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-sm font-medium text-success-600 dark:text-success-400">
                    {{ __('Cambios guardados.') }}
                </span>
            @endif
        </div>
    </form>
</section>