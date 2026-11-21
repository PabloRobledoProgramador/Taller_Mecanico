@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Usuarios" />

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Registrados
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $users->count() }} en total
                </p>
            </div>

            <a
                href="{{ route('users.create') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
            >
                Nuevo usuario
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-success-50 px-4 py-3 text-sm text-success-700 dark:bg-success-500/10 dark:text-success-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-lg bg-error-50 px-4 py-3 text-sm text-error-700 dark:bg-error-500/10 dark:text-error-400">
                {{ session('error') }}
            </div>
        @endif

        @if ($users->isEmpty())
            <div class="border-t border-gray-100 py-10 text-center dark:border-gray-800">
                <p class="font-medium text-gray-800 dark:text-white/90">
                    Aún no hay usuarios
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Registra uno para que aparezca en esta lista.
                </p>
            </div>
        @else
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table id="usersTable" class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <th class="py-3 text-start">
                                <span class="font-medium text-gray-500 text-theme-xs">Nombre</span>
                            </th>
                            <th class="px-4 py-3 text-start">
                                <span class="font-medium text-gray-500 text-theme-xs">Correo electrónico</span>
                            </th>
                            <th class="py-3 text-end">
                                <span class="font-medium text-gray-500 text-theme-xs">Acciones</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="whitespace-nowrap py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-sm font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>

                                        <span class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 text-gray-500 text-theme-sm dark:text-gray-400">
                                    {{ $user->email }}
                                </td>

                                <td class="whitespace-nowrap py-3 text-end">
                                    <div class="flex items-center justify-end gap-3">
                                        <a
                                            href="{{ route('users.edit', $user) }}"
                                            class="text-theme-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
                                        >
                                            Editar
                                        </a>

                                        @if (auth()->id() !== $user->id)
                                            <form
                                                method="POST"
                                                action="{{ route('users.destroy', $user) }}"
                                                onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    aria-label="Eliminar usuario {{ $user->name }}"
                                                    title="Eliminar usuario"
                                                    class="inline-flex items-center justify-center rounded-lg p-2 text-error-500 hover:bg-error-50 hover:text-error-600 dark:hover:bg-error-500/10"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        viewBox="0 0 24 24"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        aria-hidden="true"
                                                    >
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6V4h8v2" />
                                                        <path d="m19 6-1 14H6L5 6" />
                                                        <path d="M10 11v5M14 11v5" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const table = document.querySelector('#usersTable');

                if (table && window.DataTable) {
                    new DataTable(table, {
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        order: [[0, 'asc']],
                        columnDefs: [
                            {
                                targets: -1,
                                orderable: false,
                                searchable: false,
                            },
                        ],
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/2.2.2/i18n/es-ES.json',
                        },
                    });
                }
            });
        </script>
    @endpush
@endsection