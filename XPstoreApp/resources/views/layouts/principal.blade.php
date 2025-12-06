<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>XP Store - Marketplace de Videojuegos</title>

    @vite(['resources/css/home.css', 'resources/js/home.js'])

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

                <!-- Auth Buttons -->
                @guest
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Registrarse
                    </a>
                </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="nav-bar">
        <div class="container">
            <a href="{{ route('home') }}" class="nav-link active">Catálogo</a>
            <a href="#" class="nav-link">Marketplace</a>
            <a href="#" class="nav-link">Códigos</a>
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
                        <span class="price">S/.249.99</span>
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