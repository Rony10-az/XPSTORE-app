<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - XP Store</title>

    @vite(['resources/css/dashboard.css', 'resources/js/dashboard.js'])

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

                    <!-- Mensajes/Notificaciones -->
                    <div class="messages-icon">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">5</span>
                    </div>

                    <!-- Perfil de Usuario -->
                    <div class="user-profile">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="user-name">
                            {{ auth()->check() ? auth()->user()->name : 'Usuario' }}
                        </span>
                        <i class="fas fa-chevron-down"></i>

                        <!-- Dropdown Menu -->
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

                            <!-- Opción de Administrador (solo para admins) -->
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
            <a href="#" class="nav-link {{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">Catálogo</a>
            <a href="#" class="nav-link">Marketplace</a>
            <a href="#" class="nav-link">Códigos</a>

            <!-- Opción de Administrador simplificada -->
            @if(auth()->check() && auth()->user()->role === 'admin')
            <a href="{{ route('admin.videojuegos.index') }}" class="nav-link admin-nav {{ request()->routeIs('admin.*') ? 'active' : '' }}">
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

            <!-- Mejores Ofertas Section -->
            <section class="offers-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-percent"></i>
                    </div>
                    <div class="section-title-group">
                        <h2 class="section-title">Mejores Ofertas 🔥</h2>
                        <p class="section-subtitle">Aprovecha estos descuentos increíbles</p>
                    </div>
                </div>

                <div class="games-grid">
                    @forelse($videojuegos as $juego)
                    <div class="game-card">
                        <div class="game-image">
                            <img src="{{ $juego->imagen ? asset('img/videojuegos/' . $juego->imagen) : 'https://via.placeholder.com/400x250' }}" alt="{{ $juego->titulo }}">

                            @if($juego->descuento > 0)
                            <div class="discount-badge">-{{ $juego->descuento }}%</div>
                            @endif

                            @if($juego->featured)
                            <div class="featured-badge">Destacado</div>
                            @endif

                            <button class="wishlist-btn">
                                <i class="far fa-heart"></i>
                            </button>

                            <div class="game-overlay">
                                <button class="btn-view-details">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </button>
                            </div>
                        </div>

                        <div class="game-info">
                            <h3 class="game-title">{{ $juego->titulo }}</h3>
                            <p class="game-description">{{ $juego->descripcion ?? 'Descripción no disponible' }}</p>

                            <div class="game-tags">
                                @foreach($juego->generos_array ?? [] as $g)
                                <span class="tag-small">{{ $g }}</span>
                                @endforeach
                            </div>

                            <div class="game-footer">
                                <div class="price-group">
                                    @if($juego->descuento > 0)
                                    <span class="price-old">${{ number_format($juego->precio, 2) }}</span>
                                    <span class="price-new">${{ number_format($juego->precio_con_descuento, 2) }}</span>
                                    @else
                                    <span class="price-new">${{ number_format($juego->precio, 2) }}</span>
                                    @endif
                                </div>

                                <button class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <h3>No hay videojuegos registrados</h3>
                        <p>Comienza agregando tu primer videojuego al catálogo</p>
                        <a href="{{ route('admin.videojuegos.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Crear Primer Juego
                        </a>
                    </div>
                    @endforelse
                </div>
            </section>

        </div>
    </main>

</body>

</html>