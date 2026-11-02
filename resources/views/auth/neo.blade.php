<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticate</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css">
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>
<body>
    <div class="bg-circle bg1"></div>
    <div class="bg-circle bg2"></div>
    <div class="bg-circle bg3"></div>

    <div class="auth-wrapper">
        <div class="auth-card {{ $flipped ? 'flipped' : '' }}" id="authCard">

            {{-- LOGIN --}}
            <div class="form-panel login-panel">
                <div class="logo"><i class="fa-solid fa-lock"></i></div>
                <h1>Bienvenido</h1>
                <p class="subtitle">Inicia sesión para continuar</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="email" id="loginEmail" name="email" placeholder=" "
                               value="{{ $flipped ? '' : old('email') }}" autocomplete="username" required>
                        <label for="loginEmail">Correo electrónico</label>
                        @unless($flipped)
                            @error('email') <small class="error-msg">{{ $message }}</small> @enderror
                        @endunless
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="password" id="loginPassword" name="password" placeholder=" "
                               autocomplete="current-password" required>
                        <label for="loginPassword">Contraseña</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        @unless($flipped)
                            @error('password') <small class="error-msg">{{ $message }}</small> @enderror
                        @endunless
                    </div>

                    <div class="options">
                        <label class="checkbox">
                            <input type="checkbox" name="remember"> Recordarme
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>

                    <button type="submit" class="main-btn">INICIAR SESIÓN</button>
                </form>

                <div class="switch-area">
                    <span>¿No tienes cuenta?</span>
                    <button type="button" class="switch-circle" onclick="flipCard()">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>

            {{-- REGISTRO --}}
            <div class="form-panel signup-panel">
                <div class="logo"><i class="fa-solid fa-user"></i></div>
                <h1>Crear cuenta</h1>
                <p class="subtitle">Empieza tu camino con nosotros</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="text" id="signupName" name="name" placeholder=" "
                               value="{{ $flipped ? old('name') : '' }}" autocomplete="name" required>
                        <label for="signupName">Nombre completo</label>
                        @if($flipped)
                            @error('name') <small class="error-msg">{{ $message }}</small> @enderror
                        @endif
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="email" id="signupEmail" name="email" placeholder=" "
                               value="{{ $flipped ? old('email') : '' }}" autocomplete="username" required>
                        <label for="signupEmail">Correo electrónico</label>
                        @if($flipped)
                            @error('email') <small class="error-msg">{{ $message }}</small> @enderror
                        @endif
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="password" id="signupPassword" name="password" placeholder=" "
                               autocomplete="new-password" required>
                        <label for="signupPassword">Contraseña</label>
                        <button type="button" class="password-toggle" onclick="togglePassword('signupPassword', this)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        @if($flipped)
                            @error('password') <small class="error-msg">{{ $message }}</small> @enderror
                        @endif
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="password" id="confirmPassword" name="password_confirmation" placeholder=" "
                               autocomplete="new-password" required>
                        <label for="confirmPassword">Confirmar contraseña</label>
                    </div>

                    <button type="submit" class="main-btn">CREAR CUENTA</button>
                </form>

                <div class="switch-area">
                    <span>¿Ya tienes cuenta?</span>
                    <button type="button" class="switch-circle" onclick="flipCard()">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>