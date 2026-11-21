    <div
        class="relative"
        x-data="{
            isOpen: false,
            toggleDropdown() {
                this.isOpen = !this.isOpen;
            },
            closeDropdown() {
                this.isOpen = false;
            }
        }"
        @click.outside="closeDropdown()">

    <!-- User Trigger -->
    <button
        class="flex items-center text-gray-700 dark:text-gray-300"
        type="button"
        @click="toggleDropdown()"
    >
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3">
                <img
                src="{{ auth()->user()?->profile_photo_path
                    ? asset('storage/' . auth()->user()->profile_photo_path)
                    : asset('images/user/owner.png') }}"
                alt="Foto de perfil"
                class="h-full w-full object-cover"
                />
        </span>

        <span class="block mr-1 font-medium text-theme-sm rtl:mr-0 rtl:ml-1">{{ auth()->user()->name }}</span>

        <!-- Chevron Down Icon -->
        <svg
            :class="isOpen ? 'rotate-180' : ''"
            class="transition-transform duration-200 stroke-gray-500 group-hover:stroke-gray-700"
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M4.5 6.75L9 11.25L13.5 6.75"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute ltr:right-0 rtl:left-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800 p-3 shadow-theme-lg z-50"
        style="display: none;"
    >
        <!-- User Info -->
        <div class="border-b border-gray-200 pb-3 dark:border-gray-700">
            <span class="block font-medium text-gray-800 text-theme-sm dark:text-white">
                {{ auth()->user()->name }}
            </span>
            <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400">
                {{ auth()->user()->email }}
            </span>
        </div>

        <ul class="flex flex-col gap-1 border-b border-gray-200 py-3 dark:border-gray-700">
            <li>
                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                    <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 9a7 7 0 0 0-14 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Editar perfil
                </a>
            </li>
        </ul>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="mt-3 flex w-full items-center gap-3 rounded-lg px-3 py-2 text-left text-theme-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-200 dark:hover:bg-gray-700 dark:hover:text-white"
                @click="closeDropdown()"
            >
                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M10 17l5-5-5-5m5 5H3m9-9h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</div>
