<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taller El Señor de los Tornillos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-800">
    <header class="flex items-center justify-between px-8 py-4 bg-white shadow">
        <h1 class="text-xl font-bold">El Señor de los Tornillos</h1>
        <nav class="flex gap-4">
            @auth
                <a href="{{ route('dashboard') }}">Ir al panel</a>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-white bg-blue-600 rounded">Registrarse</a>
            @endauth
        </nav>
    </header>
    <main class="px-8 py-24 text-center">
        <h2 class="text-4xl font-bold">Tu taller de confianza</h2>
        <p class="mt-4 text-lg">Aquí va la descripción de los servicios.</p>
    </main>
</body>
</html>