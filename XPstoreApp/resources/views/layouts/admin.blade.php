<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - XP Store')</title>

    {{-- Vite para CSS/JS del admin --}}
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="logo-text">
                        <span class="logo-xp">XP</span>
                        <span class="logo-store">ADMIN</span>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                    <div class="nav-item-content">
                        <i class="fas fa-chart-line"></i>
                        <div class="nav-text">
                            <span class="nav-title">Dashboard</span>
                            <span class="nav-subtitle">Panel Principal</span>
                        </div>
                    </div>
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('videojuegos.index') }}" class="nav-item {{ request()->routeIs('videojuegos.*') ? 'active' : '' }}">
                    <div class="nav-item-content">
                        <i class="fas fa-gamepad"></i>
                        <div class="nav-text">
                            <span class="nav-title">Catálogo</span>
                            <span class="nav-subtitle">Videojuegos</span>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.items.index') }}" class="nav-item {{ request()->routeIs('admin.items.*') ? 'active' : '' }}">
                    <div class="nav-item-content">
                        <i class="fas fa-boxes"></i>
                        <div class="nav-text">
                            <span class="nav-title">Marketplace</span>
                            <span class="nav-subtitle">Ítems</span>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.gamecodes.index') }}" class="nav-item {{ request()->routeIs('admin.gamecodes.*') ? 'active' : '' }}">
                    <div class="nav-item-content">
                        <i class="fas fa-ticket-alt"></i>
                        <div class="nav-text">
                            <span class="nav-title">Códigos de Juegos</span>
                            <span class="nav-subtitle">Códigos</span>
                        </div>
                    </div>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <div class="nav-item-content">
                        <i class="fas fa-star-half-alt"></i>
                        <div class="nav-text">
                            <span class="nav-title">Comunidad Gamers</span>
                            <span class="nav-subtitle">Reseñas</span>
                        </div>
                    </div>
                </a>

                <div class="nav-divider"></div>

                <a href="{{ route('logout') }}" class="nav-item nav-item-simple" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="page-hero">
                    <div class="hero-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="hero-text">
                        <p class="hero-kicker">Panel XP</p>
                        <h1>@yield('title')</h1>
                        <p class="hero-subtitle">@yield('subtitle', 'Administra XP Store desde aquí')</p>
                    </div>
                </div>

                <!-- Admin Profile Menu -->
                <div class="admin-user-menu">
                    <div class="admin-profile-trigger">
                        <div class="admin-avatar">
                            @php
                                $avatar = auth()->user()->avatar ?? null;
                                if ($avatar) {
                                    $avatarUrl = \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://', 'data:image'])
                                        ? $avatar
                                        : asset('storage/' . ltrim($avatar, '/'));
                                }
                            @endphp
                            @if($avatar ?? false)
                            <img src="{{ $avatarUrl }}" alt="{{ auth()->user()->name }}">
                            @else
                            <i class="fas fa-user-shield"></i>
                            @endif
                        </div>
                        <div class="admin-info">
                            <span class="admin-name">{{ auth()->user()->name }}</span>
                            <span class="admin-role">Administrador</span>
                        </div>
                        <i class="fas fa-chevron-down admin-dropdown-icon"></i>

                        <!-- Dropdown Menu -->
                        <div class="admin-dropdown">
                            <a href="{{ route('admin.profile.index') }}" class="admin-dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Mi Perfil</span>
                            </a>
                            <a href="{{ route('dashboard.user') }}" class="admin-dropdown-item">
                                <i class="fas fa-home"></i>
                                <span>Vista de Usuario</span>
                            </a>
                            <div class="admin-dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="admin-dropdown-item admin-logout" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </div>
                    </div>
                </div>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
