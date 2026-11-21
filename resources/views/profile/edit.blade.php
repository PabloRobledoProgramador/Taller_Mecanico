@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Mi perfil" />

    <div class="mx-auto max-w-3xl">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-theme-xs sm:p-6 dark:border-gray-800 dark:bg-gray-900">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
@endsection