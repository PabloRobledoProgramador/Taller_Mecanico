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
        <div class="auth-card compact" id="authCard">

            {{-- LOGIN --}}
            <div class="form-panel">
                <div class="logo"><i class="fa-solid fa-lock"></i></div>
                <h1>Bienvenido</h1>
                <p class="subtitle">Inicia sesión para continuar</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="email" id="loginEmail" name="email" placeholder=" "
                               value="{{ old('email') }}" autocomplete="username" required>
                        <label for="loginEmail">Correo electrónico</label>
                        @error('email') <small class="error-msg">{{ $message }}</small> @enderror
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
                        @error('password') <small class="error-msg">{{ $message }}</small> @enderror
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
            </div>
        </div>
    </div>
</body>
</html>