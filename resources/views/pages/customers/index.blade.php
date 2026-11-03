@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Clientes" />

    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-4 pb-3 pt-4 sm:px-6 dark:border-gray-800 dark:bg-gray-900">
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                    Registrados
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $customers->total() }} en total
                </p>
            </div>

            <a
                href="{{ route('customers.create') }}"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-white/[0.03]"
            >
                Nuevo cliente
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

        @if ($customers->isEmpty())
            <div class="border-t border-gray-100 py-10 text-center dark:border-gray-800">
                <p class="font-medium text-gray-800 dark:text-white/90">
                    Aún no hay clientes
                </p>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Registra uno para que aparezca en esta lista.
                </p>
            </div>
        @else
            <div class="max-w-full overflow-x-auto custom-scrollbar">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-t border-gray-100 dark:border-gray-800">
                            <th class="py-3 text-start">
                                <span class="font-medium text-gray-500 text-theme-xs">Cliente</span>
                            </th>
                            <th class="px-4 py-3 text-start">
                                <span class="font-medium text-gray-500 text-theme-xs">Teléfono</span>
                            </th>
                            <th class="px-4 py-3 text-start">
                                <span class="font-medium text-gray-500 text-theme-xs">Estado</span>
                            </th>
                            <th class="py-3 text-end">
                                <span class="font-medium text-gray-500 text-theme-xs">Acción</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($customers as $customer)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="whitespace-nowrap py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-sm font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                                {{ $customer->name }}
                                            </p>
                                            <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                                {{ $customer->email ?: 'Sin correo registrado' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    <span class="text-gray-500 text-theme-sm dark:text-gray-400">
                                        {{ $customer->phone ?: 'Sin teléfono' }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3">
                                    @if ($customer->active)
                                        <span class="rounded-full bg-success-50 px-2 py-0.5 text-theme-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">
                                            Activo
                                        </span>
                                    @else
                                        <span class="rounded-full bg-gray-100 px-2 py-0.5 text-theme-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap py-3 text-end">
                                    <div class="flex items-center justify-end gap-3">
                                        <a
                                            href="{{ route('customers.edit', $customer) }}"
                                            class="text-theme-sm font-medium text-brand-600 hover:text-brand-700 dark:text-brand-400"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('customers.destroy', $customer) }}"
                                            onsubmit="return confirm('¿Seguro que quieres eliminar este cliente? Esta acción no se puede deshacer.')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                aria-label="Eliminar cliente {{ $customer->name }}"
                                                title="Eliminar cliente"
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
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100 py-4 dark:border-gray-800">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection