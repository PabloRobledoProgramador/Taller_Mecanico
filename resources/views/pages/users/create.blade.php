@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Nuevo usuario" />

    <div class="space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
            <h2 class="mb-6 text-lg font-semibold text-gray-800 dark:text-white/90">
                Registrar usuario
            </h2>

            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                @include('pages.users._form', ['isEditing' => false])

                <div class="flex items-center gap-3">
                    <button
                        type="submit"
                        class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600"
                    >
                        Registrar usuario
                    </button>

                    <a
                        href="{{ route('users.index') }}"
                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-white/[0.03]"
                    >
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection