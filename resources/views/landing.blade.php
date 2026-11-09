<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>El Señor de los Tornillos</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/landing.css', 'resources/js/landing.js'])
</head>
<body>
    @php
        $modulos = [
            ['01', 'Gestión de Usuarios', 'Administra usuarios y permisos del sistema.', 'M8 6.5h10M8 11.5h10M8 16.5h6M4 6.5h.01M4 11.5h.01M4 16.5h.01'],
            ['02', 'Control de Vehículos', 'Crea, edita y elimina registros de vehículos.', 'm4 8 8-4 8 4v9l-8 4-8-4V8Zm0 0 8 4m8-4-8 4m0 9v-9m-4-6 8 4'],
            ['03', 'Servicio de Reparaciones', 'Planifica y gestiona el proceso de reparación de vehículos.', 'M12 7v5l3 2m6-2a9 9 0 1 1-3-6.7M18 2v4h4'],
            ['04', 'Calendario', 'Ay papá. Hasta calendario le metimos', 'M3 3v18h18V3H3Zm0 0 9 9 9-9M3 21v-6h18v6H3Z'],
        ];
    @endphp

    <main>
        <header class="site-header">
            <a class="brand" href="{{ url('/') }}" aria-label="El Señor de los Tornillos, inicio">
                <img class="brand-mark" src="{{ asset('favicon.svg') }}" alt="">
                <span class="brand-name">El Señor <span>de los Tornillos</span></span>
            </a>

            <nav class="main-nav" aria-label="Navegación principal">
                <a href="#CRUDS">CRUDS</a>
                <a href="#Extra">Extra</a>
            </nav>

            <div class="header-actions">
                @auth
                    <a class="button button-small" href="{{ route('dashboard') }}">
                        Ir al panel
                        <x-arrow-icon />
                    </a>
                @else
                    <a class="login-link" href="{{ route('login') }}">Iniciar sesión</a>
                @endauth
            </div>
        </header>

        <section class="video-story" data-video-story>
            <div class="video-stage">
                <video
                    class="hero-video"
                    data-hero-video
                    data-src="{{ asset('videos/carro.mp4') }}"
                    muted
                    playsinline
                ></video>
                <div class="video-shade"></div>
                <div class="hero-grid"></div>

                <div class="hero-content">
                    <div class="eyebrow">
                        <span class="status-dot"></span>
                        Taller Mecánico para Pros
                    </div>
                    <h1>
                        El Mejor Taller
                        <br>
                        <span>del Mundo</span>
                    </h1>
                    <p>
                        Papi. Un privilegio que estés aquí. Estás ante el mejor taller del universo intelestar intergaláctico
                    </p>
                    <div class="hero-actions">
                        <a class="button" href="{{ route('login') }}">
                            Entrar al taller
                            <x-arrow-icon />
                        </a>
                        <a class="text-link" href="#CRUDS">Ver Funcionalidades</a>
                    </div>
                </div>

                <div class="scroll-cue" aria-hidden="true">
                    <span>Desliza para explorar</span>
                    <div class="scroll-line"><i></i></div>
                </div>

                <div class="workshop-id" aria-hidden="true">
                    <span>EST. 2024</span>
                    <span>ÁREA DE PERSONAL</span>
                </div>
            </div>
        </section>

        <section class="tools-section" id="CRUDS">
            <div class="section-heading">
                <div>
                    <span class="kicker">CRUDS</span>
                    <h2>Funcionalidades del Sistema</h2>
                </div>
                <p>
                    Una vista sencilla de lo que le metimos a este proyecto tan bello.
                </p>
            </div>

            <div class="module-grid">
                @foreach ($modulos as [$numero, $titulo, $texto, $icono])
                    <article class="module-card">
                        <div class="module-card-top">
                            <span>{{ $numero }}</span>
                            <div class="module-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="{{ $icono }}" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <h3>{{ $titulo }}</h3>
                        <p>{{ $texto }}</p>
                        <div class="card-rule"></div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="workflow" id="Extra">
            <div class="workflow-copy">
                <span class="kicker kicker-dark">Sin complicaciones</span>
                <h2>Funcionalidades Adicionales pa Meterle Duro</h2>
                <p>
                    Una pequeña muestra de lo incluido en el MVP
                </p>
                <a class="outline-link" href="{{ route('login') }}">
                    Acceder a mi turno
                    <x-arrow-icon />
                </a>
            </div>

            <div class="workflow-steps">
                <div class="step">
                    <span>01</span>
                    <div>
                        <h3>Exportación de PDFs</h3>
                        <p>Genera informes detallados en formato PDF para compartir con clientes o para archivar.</p>
                    </div>
                </div>
                <div class="step">
                    <span>02</span>
                    <div>
                        <h3>Administración de Perfil de Usuarios</h3>
                        <p>Administra los perfiles de los usuarios, pudiendo subir imágenes y vainas</p>
                    </div>
                </div>
                <div class="step">
                    <span>03</span>
                    <div>
                        <h3>Modo Oscuro</h3>
                        <p>Si la vista le fastidia, le metimos a la funcionalidad de modo oscuro</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="access-section" id="acceso">
            <x-brand-mark class="access-mark" />
            <span class="kicker">Acceso exclusivo para personal</span>
            <h2>¿Listo para empezar el turno?</h2>
            <p>Entra con tus credenciales o pide tu acceso al responsable del taller.</p>
            <div class="access-actions">
                <a class="button button-light" href="{{ route('login') }}">
                    Iniciar sesión
                    <x-arrow-icon />
                </a>
            </div>
        </section>

        <footer>
            <a class="brand footer-brand" href="{{ url('/') }}">
                <img class="brand-mark" src="{{ asset('favicon.svg') }}" alt="">
                <span class="brand-name">El Señor <span>de los Tornillos</span></span>
            </a>
            <p>Herramientas para los que hacen el trabajo.</p>
            <span>Uso interno · {{ date('Y') }}</span>
        </footer>
    </main>
</body>
</html>