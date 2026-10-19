<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css">
    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>
<body>
    <div class="bg-circle bg1"></div>
    <div class="bg-circle bg2"></div>
    <div class="bg-circle bg3"></div>

    <div class="auth-wrapper">
        <div class="auth-card compact">
            <div class="form-panel">
                <div class="logo"><i class="fa-solid fa-key"></i></div>
                <h1>¿Olvidaste tu contraseña?</h1>
                <p class="subtitle">Escribe tu correo y te enviaremos un enlace para restablecerla</p>

                @if (session('status'))
                    <div class="status-msg">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="email" id="forgotEmail" name="email" placeholder=" "
                               value="{{ old('email') }}" autocomplete="username" required autofocus>
                        <label for="forgotEmail">Correo electrónico</label>
                        @error('email') <small class="error-msg">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="main-btn">ENVIAR ENLACE</button>
                </form>

                <div class="switch-area">
                    <span>¿Ya la recordaste?</span>
                    <a href="{{ route('login') }}" class="switch-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>