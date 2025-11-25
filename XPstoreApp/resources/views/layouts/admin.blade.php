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
                {{-- Ajusté los enlaces para que resalten activos según la ruta. --}}
                <a href="{{ route('dashboard.admin') }}" class="nav-item {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                </a>
                <a href="{{ route('videojuegos.index') }}" class="nav-item {{ request()->routeIs('videojuegos.*') ? 'active' : '' }}">
                    <i class="fas fa-gamepad"></i>
                    Gestión de Juegos
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Gestión de Usuarios
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-ticket-alt"></i>
                    Gestión de Códigos
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
