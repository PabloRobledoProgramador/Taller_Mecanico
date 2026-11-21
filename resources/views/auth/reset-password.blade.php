<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
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
                <div class="logo"><i class="fa-solid fa-lock"></i></div>
                <h1>Nueva contraseña</h1>
                <p class="subtitle">Elige una contraseña nueva para tu cuenta</p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="email" id="resetEmail" name="email" placeholder=" "
                               value="{{ old('email', $request->email) }}" autocomplete="username" required autofocus>
                        <label for="resetEmail">Correo electrónico</label>
                        @error('email') <small class="error-msg">{{ $message }}</small> @enderror
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="password" id="resetPassword" name="password" placeholder=" "
                               autocomplete="new-password" required>
                        <label for="resetPassword">Nueva contraseña</label>
                        @error('password') <small class="error-msg">{{ $message }}</small> @enderror
                    </div>

                    <div class="input-group">
                        <div class="electric-glow"></div>
                        <div class="electric-border"></div>
                        <input type="password" id="resetPasswordConfirmation" name="password_confirmation" placeholder=" "
                               autocomplete="new-password" required>
                        <label for="resetPasswordConfirmation">Confirmar contraseña</label>
                        @error('password_confirmation') <small class="error-msg">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="main-btn">RESTABLECER CONTRASEÑA</button>
                </form>

                <div class="switch-area">
                    <span>¿Volver al inicio?</span>
                    <a href="{{ route('login') }}" class="switch-circle">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
