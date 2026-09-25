<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - XP Store</title>

    @vite(['resources/css/user/dashboard.css', 'resources/js/dashboard.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body>
    <!-- Animacion de Estrellas -->
    <div class="stars-background"></div>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">

                <!-- Logo -->
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="logo-text">
                        <span class="logo-xp">XP</span>
                        <span class="logo-store">STORE</span>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Busca juegos, recargas y más">
                </div>

                <!-- User Menu -->
                <div class="user-menu">

                    <!-- Carrito de Compras -->
                    <div class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">3</span>
                    </div>

                    <!-- Notificaciones -->
                    <div class="messages-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">5</span>
                    </div>

                    <!-- Perfil -->
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <span class="user-name">
                            {{ auth()->check() ? auth()->user()->name : 'Usuario' }}
                        </span>

                        <i class="fas fa-chevron-down"></i>

                        <!-- Dropdown -->
                        <div class="user-dropdown">
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                Mi Perfil
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-shopping-bag"></i>
                                Mis Compras
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-heart"></i>
                                Wishlist
                            </a>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-cog"></i>
                                Configuración
                            </a>

                            <!-- Solo para admins -->
                            @if(auth()->check() && auth()->user()->role === 'admin')
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item admin-item">
                                <i class="fas fa-crown"></i>
                                Panel Admin
                            </a>
                            @endif

                            <div class="dropdown-divider"></div>

                            <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Cerrar Sesión
                                </button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <nav class="nav-bar">
        <div class="container">

            <a href="#" class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                Catálogo
            </a>

            <a href="#" class="nav-link">Marketplace</a>
            <a href="#" class="nav-link">Códigos</a>

            <!-- Admin -->
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('videojuegos.index') }}"
                class="nav-link admin-nav {{ request()->routeIs('videojuegos.*') ? 'active' : '' }}">
                <i class="fas fa-crown"></i>
                Administrador
            </a>
            @endif

        </div>
    </nav>

    <!-- contenido principal -->
    <main class="main-content">
        <div class="container">

            <!-- boton de filtros vertical -->
            <button class="filters-btn-vertical">
                <i class="fas fa-sliders-h"></i>
                <span class="filters-text">FILTROS</span>
            </button>

            <!-- Hero Section -->
            <section class="hero-section">
                <div class="hero-background">
                    <img src="https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp" alt="Space Explorer Chronicles">
                    <div class="hero-overlay"></div>
                </div>

                <div class="hero-content">
                    <span class="badge-destacado">
                        <i class="fas fa-bolt"></i>
                        Destacado
                    </span>

                    <h1 class="hero-title">God Of War Ragnarok</h1>

                    <p class="hero-description">
                        Embárcate en una aventura épica en un mundo lleno de mitología nórdica y criaturas legendarias.
                    </p>

                    <div class="hero-tags">
                        <span class="tag">Aventura</span>
                        <span class="tag">Acción</span>
                        <span class="tag">Exploración</span>
                    </div>

                    <div class="hero-price">
                        <span class="price">$249.99</span>
                    </div>

                    <div class="hero-actions">
                        <button class="btn-primary">
                            Ver Detalles
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn-secondary">
                            Agregar al Carrito
                        </button>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <span class="indicator"></span>
                    <span class="indicator active"></span>
                    <span class="indicator"></span>
                    <span class="indicator"></span>
                </div>
            </section>

            

        </div>
    </main>

</body>

</html>