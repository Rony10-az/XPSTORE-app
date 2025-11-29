@extends('layouts.auth')

@section('title', 'Crear Cuenta - XP Store')

@section('content')
<div class="register-container">
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Fondo animado -->
        <div class="absolute inset-0 bg-linear-gradient-to-br from-slate-950 via-purple-950 to-slate-950">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(147,51,234,0.15),transparent_50%)]"></div>
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>

        <!-- Partículas -->
        <div class="particles-container" id="particles"></div>

        <!-- Grid principal -->
        <div class="grid-container lg:grid-cols-2">
            <!-- Hero -->
            <div class="logo-section">
                <div class="logo-animation">
                    <div class="logo-glow"></div>
                    <div class="logo-container">
                        <div class="logo">
                            <div class="logo-text">XP STORE</div>
                            <div class="logo-sparkle"></div>
                        </div>
                    </div>
                </div>

                <div class="welcome-text">
                    <h1 class="text-5xl text-white">Únete a <span class="brand-gradient">XP STORE</span></h1>
                    <p class="text-xl text-gray-300 max-w-md">
                        Crea tu cuenta y desbloquea miles de juegos, skins exclusivos y códigos de streaming.
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-card feature-purple">
                        <div class="feature-icon">🎮</div>
                        <p class="feature-text">Miles de juegos</p>
                    </div>
                    <div class="feature-card feature-pink">
                        <div class="feature-icon">✨</div>
                        <p class="feature-text">Skins exclusivos</p>
                    </div>
                    <div class="feature-card feature-blue">
                        <div class="feature-icon">🛡️</div>
                        <p class="feature-text">Compra segura</p>
                    </div>
                    <div class="feature-card feature-yellow">
                        <div class="feature-icon">🏆</div>
                        <p class="feature-text">Rewards diarios</p>
                    </div>
                </div>
            </div>

            <!-- Formulario -->
            <div class="form-section">
                <!-- Mobile logo -->
                <div class="mobile-greeting lg:hidden">
                    <div class="flex justify-center mb-4">
                        <div class="logo">
                            <div class="logo-text">XP STORE</div>
                            <div class="logo-sparkle"></div>
                        </div>
                    </div>
                </div>

                <div class="register-card">
                    <div class="card-glow-border"></div>

                    <div class="card-header">
                        <div class="flex items-center space-x-4">
                            <div class="header-icon">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title">Crear Cuenta</h2>
                                <p class="card-description">Únete a la comunidad gamer</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        @if($errors->any())
                        <div class="error-container">
                            <ul>
                                @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="register-form">
                            @csrf

                            <!-- Nombre -->
                            <div class="input-group">
                                <label for="name" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Nombre Completo
                                </label>
                                <div class="input-container">
                                    <input
                                        id="name"
                                        type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        placeholder="Tu nombre completo"
                                        class="form-input"
                                        required
                                        autofocus />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="input-group">
                                <label for="email" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                    Correo Electrónico
                                </label>
                                <div class="input-container">
                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="gamer@xpstore.com"
                                        class="form-input"
                                        required />
                                </div>
                            </div>

                            <!-- Contraseña -->
                            <div class="input-group">
                                <label for="password" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Contraseña
                                </label>
                                <div class="input-container">
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="********"
                                        class="form-input password-input"
                                        required />
                                    <button type="button" class="password-toggle">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirmar -->
                            <div class="input-group">
                                <label for="password_confirmation" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                    Confirmar Contraseña
                                </label>
                                <div class="input-container">
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        placeholder="********"
                                        class="form-input password-input"
                                        required />
                                    <button type="button" class="password-toggle">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                            <line x1="1" y1="1" x2="23" y2="23" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Términos -->
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="terms" id="terms" required>
                                    <span class="checkmark"></span>
                                    <span>Acepto los</span>
                                    <a href="#" class="link">Términos y Condiciones</a>
                                    <span>y la</span>
                                    <a href="#" class="link">Política de Privacidad</a>
                                </label>
                            </div>

                            <!-- Newsletter -->
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="newsletter" id="newsletter" checked>
                                    <span class="checkmark"></span>
                                    Quiero recibir noticias y ofertas exclusivas
                                </label>
                            </div>

                            <!-- Botón -->
                            <button type="submit" class="register-button" id="register-button">
                                <div class="button-shine"></div>
                                <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <span class="button-text">Crear Cuenta</span>
                            </button>
                        </form>

                        <div class="login-link">
                            <p class="link-text">
                                ¿Ya tienes una cuenta?
                                <a href="{{ route('login') }}" class="link-button">Inicia sesión aquí</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast-container" class="toast-container"></div>

@vite(['resources/css/register.css', 'resources/js/register.js'])
@endsection
