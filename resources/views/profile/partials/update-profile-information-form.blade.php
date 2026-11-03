<section
    x-data="{
        photoPreview: @js(
            $user->profile_photo_path
                ? asset('storage/' . $user->profile_photo_path)
                : asset('images/user/owner.png')
        ),
        previewPhoto(event) {
            const file = event.target.files[0];

            if (!file) return;

            if (this.photoPreview.startsWith('blob:')) {
                URL.revokeObjectURL(this.photoPreview);
            }

            this.photoPreview = URL.createObjectURL(file);
        }
    }"
>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            Mi perfil
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Actualiza tu foto y nombre.
        </p>
    </div>

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >
        @csrf
        @method('PATCH')

        <div>
            <p class="mb-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                Foto de perfil
            </p>

            <div class="flex items-center gap-4">
                <label
                    for="photo"
                    title="Cambiar foto de perfil"
                    class="group relative block h-24 w-24 shrink-0 cursor-pointer rounded-full"
                >
                    <input
                        id="photo"
                        name="photo"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="sr-only"
                        aria-label="Seleccionar foto de perfil"
                        @change="previewPhoto($event)"
                    >

                    <img
                        :src="photoPreview"
                        alt="Foto de perfil"
                        class="h-24 w-24 rounded-full border border-gray-200 object-cover dark:border-gray-700"
                    >

                    <span class="absolute inset-0 flex items-center justify-center rounded-full bg-black/0 text-white transition group-hover:bg-black/40">
                        <svg
                            class="h-7 w-7 opacity-0 transition group-hover:opacity-100"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 8a2 2 0 0 1 2-2h1.2l1.1-1.5h5.4L14.8 6H18a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8Z"
                            />
                            <circle cx="12" cy="12.5" r="3" />
                        </svg>
                    </span>
                </label>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Haz clic en la foto para cambiarla.<br>
                    JPG, PNG o WebP; máximo 5 MB.
                </p>
            </div>

            @error('photo')
                <p class="mt-2 text-sm text-error-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label
                for="name"
                class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400"
            >
                Nombre
            </label>

            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name', $user->name) }}"
                required
                autocomplete="name"
                class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
            >

            @error('name')
                <p class="mt-2 text-sm text-error-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white shadow-theme-xs transition hover:bg-brand-600"
            >
                Guardar cambios
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-sm font-medium text-success-600 dark:text-success-400">
                    Cambios guardados.
                </span>
            @endif
        </div>
    </form>
</section>