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

    <style>
        :root {
            --primary-purple: #8b5cf6;
            --primary-blue: #3b82f6;
            --dark-bg: #0f172a;
            --dark-secondary: #1e293b;
            --dark-tertiary: #334155;
            --text-primary: #ffffff;
            --text-secondary: #cbd5e1;
            --accent-orange: #f97316;
            --accent-red: #ef4444;
            --accent-green: #10b981;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--dark-bg);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .admin-layout {
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 280px;
            background: var(--dark-secondary);
            border-right: 1px solid var(--dark-tertiary);
            padding: 2rem 0;
        }

        .sidebar-header {
            padding: 0 2rem 2rem 2rem;
            border-bottom: 1px solid var(--dark-tertiary);
            margin-bottom: 1rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-xp {
            font-size: 1.25rem;
            font-weight: 900;
            color: var(--text-primary);
        }

        .logo-store {
            font-size: 0.65rem;
            color: var(--text-secondary);
            font-weight: 600;
        }

        /* Navigation */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(139, 92, 246, 0.1);
            color: var(--text-primary);
        }

        .nav-item.active {
            border-left: 3px solid var(--primary-purple);
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            overflow-y: auto;
        }

        .admin-header {
            background: var(--dark-secondary);
            border-bottom: 1px solid var(--dark-tertiary);
            padding: 1.5rem 2rem;
        }

        .admin-content {
            padding: 2rem;
        }
    </style>
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
                <a href="{{ route('dashboard.admin') }}" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.videojuegos.index') }}" class="nav-item active">
                    <i class="fas fa-gamepad"></i>
                    Gestión de Juegos
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i>
                    Gestión de Usuarios
                </a>
                <a href="{{ route('admin.gamecodes.index') }}" class="nav-item">
                    <i class="fas fa-ticket-alt"></i>
                    Gestión de Códigos
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1>@yield('title')</h1>
            </header>

            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>