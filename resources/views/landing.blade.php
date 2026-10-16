<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taller El Señor de los Tornillos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 text-gray-300">
    <header class="sticky top-0 z-50 flex h-20 items-center justify-between border-b border-white/5 bg-[#080b12] px-8">
        <h1 class="text-xl font-bold text-gray-300">El Señor de los Tornillos</h1>
        <nav class="flex gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary">Ir al panel</a>
            @else
                <a href="{{ route('login') }}" class="btn-ghost">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn-primary">Registrarse</a>
            @endauth
        </nav>
    </header>
<section data-scroll-video class="relative h-[200vh] bg-black">
    <div class="sticky top-20 mx-auto aspect-video h-[calc(100vh-5rem)] w-full overflow-hidden bg-black">
        <video
            class="h-full w-full object-cover opacity-60"
            data-src="{{ asset('videos/carro.mp4') }}"
            muted
            playsinline
        ></video>
    </div>
</section>
</body>
</html>