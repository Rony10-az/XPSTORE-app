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
                <div class="auth-buttons">
                    <a href="{{ route('login') }}" class="btn-login"> <!-- ← route('login') -->
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn-register">
                        <i class="fas fa-user-plus"></i>
                        Registrarse
                    </a>
                </div>
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
                    <!-- Game Card 1 -->
                    <div class="game-card">
                        <div class="game-image">
                            <img src="https://images.unsplash.com/photo-1552820728-8b83bb6b773f?w=400&h=250&fit=crop" alt="Game 1">
                            <div class="discount-badge">-10%</div>
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
                            <h3 class="game-title">Cyber Warriors 2077</h3>
                            <p class="game-description">Adéntrate en una ciudad cyberpunk llena de acción</p>
                            <div class="game-tags">
                                <span class="tag-small">Acción</span>
                                <span class="tag-small">RPG</span>
                            </div>
                            <div class="game-footer">
                                <div class="price-group">
                                    <span class="price-old">$59.99</span>
                                    <span class="price-new">$53.99</span>
                                </div>
                                <button class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Game Card 2 -->
                    <div class="game-card">
                        <div class="game-image">
                            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&h=250&fit=crop" alt="Game 2">
                            <div class="discount-badge featured">-20%</div>
                            <div class="featured-badge">Destacado</div>
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
                            <h3 class="game-title">Fantasy Legends Online</h3>
                            <p class="game-description">MMORPG épico con mundos fantásticos por descubrir</p>
                            <div class="game-tags">
                                <span class="tag-small">MMORPG</span>
                                <span class="tag-small">Fantasía</span>
                            </div>
                            <div class="game-footer">
                                <div class="price-group">
                                    <span class="price-old">$49.99</span>
                                    <span class="price-new">$39.99</span>
                                </div>
                                <button class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Game Card 3 -->
                    <div class="game-card">
                        <div class="game-image">
                            <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?w=400&h=250&fit=crop" alt="Game 3">
                            <div class="discount-badge">-15%</div>
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
                            <h3 class="game-title">Racing Xtreme</h3>
                            <p class="game-description">Carreras de alta velocidad con gráficos realistas</p>
                            <div class="game-tags">
                                <span class="tag-small">Carreras</span>
                                <span class="tag-small">Deportes</span>
                            </div>
                            <div class="game-footer">
                                <div class="price-group">
                                    <span class="price-old">$44.99</span>
                                    <span class="price-new">$38.24</span>
                                </div>
                                <button class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>


</body>

</html>