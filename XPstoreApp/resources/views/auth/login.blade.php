@extends('layouts.auth')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="login-container">
    <div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
        <!-- Fondo animado con gradiente mejorado -->
        <div class="absolute inset-0 bg-linear-gradient-to-br from-slate-950 via-purple-950 to-slate-950">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(147,51,234,0.15),transparent_50%)]"></div>

            <!-- Orbes de luz animados -->
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
        </div>

        <!-- Partículas flotantes mejoradas -->
        <div class="particles-container" id="particles-container"></div>



        <!-- Contenedor principal con logo lateral -->
        <div class="w-full max-w-6xl mx-auto grid lg:grid-cols-2 gap-8 items-center relative z-10">
            <!-- Logo y animaciones laterales - Desktop -->
            <div class="hidden lg:flex flex-col items-center justify-center space-y-8 p-8 logo-section">
                <!-- Logo grande animado -->
                <div class="logo-animation">
                    <div class="logo-glow"></div>
                    <div class="logo-container">
                        <div class="logo">
                            <div class="logo-text">XP STORE</div>
                            <div class="logo-sparkle"></div>
                        </div>
                    </div>
                </div>

                <!-- Texto de bienvenida -->
                <div class="welcome-text">
                    <h1 class="text-5xl text-white">
                        Bienvenido a <span class="brand-gradient">XP STORE</span>
                    </h1>
                    <p class="text-xl text-gray-300 max-w-md">
                        Tu tienda gamer definitiva. Miles de juegos, skins exclusivos y códigos de streaming te esperan.
                    </p>
                </div>

                <!-- Features animados -->
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

            <!-- Formulario de login -->
            <div class="w-full max-w-md mx-auto">
                <!-- Saludo Animado - Solo mobile -->
                <div class="mobile-greeting lg:hidden">
                    <div class="flex justify-center mb-4">
                        <div class="logo">
                            <div class="logo-text">XP STORE</div>
                            <div class="logo-sparkle"></div>
                        </div>
                    </div>

                    <div class="greeting-container">
                        <div class="greeting-card greeting-active">
                            <div class="greeting-icon">🎮</div>
                            <span class="greeting-text">¡Listo para jugar!</span>
                        </div>
                    </div>
                </div>

                <div class="login-card">
                    <!-- Borde superior brillante animado -->
                    <div class="card-glow-border"></div>

                    <div class="card-header">
                        <div class="flex items-center space-x-4 ">
                            <div class="header-icon">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="card-title">Iniciar Sesión</h2>
                                <p class="card-description">Accede a tu cuenta de gamer</p>
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

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf

                            <!-- Email -->
                            <div class="input-group">
                                <label for="email" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <polyline points="22,6 12,13 2,6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
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

                            <!-- Password -->
                            <div class="input-group">
                                <label for="password" class="input-label">
                                    <svg class="label-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Contraseña
                                </label>
                                <div class="input-container">
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        placeholder="••••••••"
                                        class="form-input password-input"
                                        required />
                                    <button type="button" class="password-toggle">
                                        <svg class="eye-icon eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <circle cx="12" cy="12" r="3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg class="eye-icon eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <line x1="1" y1="1" x2="23" y2="23" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Botón de Login -->
                            <button type="submit" class="login-button" id="login-button">
                                <div class="button-shine"></div>
                                <svg class="button-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="button-text">Iniciar Sesión</span>
                            </button>

                            <!-- Link a registro -->
                            <div class="register-link">
                                <p class="link-text">
                                    ¿Nuevo en XP STORE?
                                    <a href="{{ route('register') }}" class="link-button">
                                        Crea tu cuenta aquí
                                    </a>
                                </p>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div id="toast-container" class="toast-container"></div>

@vite(['resources/css/login.css', 'resources/js/login.js'])
@endsection