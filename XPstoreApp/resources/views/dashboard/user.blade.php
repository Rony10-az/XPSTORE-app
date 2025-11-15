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
            <a href="{{ route('dashboard.user') }}" class="nav-link {{ request()->routeIs('dashboard.user') ? 'active' : '' }}">Catálogo</a>
            <a href="#" class="nav-link">Marketplace</a>
            <a href="#" class="nav-link">Códigos</a>
            <a href="#" class="nav-link">Mis Pedidos</a>
            <a href="#" class="nav-link">Wishlist</a>
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
                    <img src="https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp" alt="God of War Ragnarok">
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
                        {{-- Comentado hasta que tengas la variable $featuredGame --}}
                        {{-- @if(isset($featuredGame) && $featuredGame->discount > 0)
                        <span class="price-discount">-{{ $featuredGame->discount }}%</span>
                        @endif --}}
                    </div>

                    <div class="hero-actions">
                        <button class="btn-primary">
                            <i class="fas fa-shopping-cart"></i>
                            Comprar Ahora
                        </button>
                        <button class="btn-secondary">
                            <i class="fas fa-heart"></i>
                            Agregar a Wishlist
                        </button>
                    </div>

                    <div class="hero-meta">
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            <span>4.9/5 (2.4k reseñas)</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-download"></i>
                            <span>50GB</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>Multijugador</span>
                        </div>
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

            <!-- Sección de Juegos Populares -->
            <section class="games-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="section-title-group">
                        <h2 class="section-title">Juegos Populares 🔥</h2>
                        <p class="section-subtitle">Los más vendidos esta semana</p>
                    </div>
                    <a href="#" class="section-link">
                        Ver todos
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <div class="games-grid">
                    @forelse($popularGames ?? [] as $juego)
                    <div class="game-card">
                        <div class="game-image">
                            <img src="{{ $juego->images && count($juego->images) > 0 ? asset('storage/' . $juego->images[0]) : 'https://via.placeholder.com/400x250?text=Sin+Imagen' }}" alt="{{ $juego->title }}">

                            @if($juego->discount > 0)
                            <div class="discount-badge">-{{ $juego->discount }}%</div>
                            @endif

                            @if($juego->featured)
                            <div class="featured-badge">Destacado</div>
                            @endif

                            <button class="wishlist-btn" data-game-id="{{ $juego->id }}">
                                <i class="far fa-heart"></i>
                            </button>

                            <div class="game-overlay">
                                <button class="btn-view-details" data-game-id="{{ $juego->id }}">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </button>
                            </div>
                        </div>

                        <div class="game-info">
                            <h3 class="game-title">{{ $juego->title }}</h3>
                            <p class="game-developer">{{ $juego->developer }}</p>

                            <div class="game-tags">
                                @if(is_array($juego->genre))
                                @foreach(array_slice($juego->genre, 0, 3) as $genero)
                                <span class="tag-small">{{ $genero }}</span>
                                @endforeach
                                @else
                                <span class="tag-small">{{ $juego->genre ?? 'Sin género' }}</span>
                                @endif
                            </div>

                            <div class="game-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $juego->rating ? 'filled' : '' }}"></i>
                                        @endfor
                                </div>
                                <span class="rating-value">{{ number_format($juego->rating, 1) }}</span>
                            </div>

                            <div class="game-footer">
                                <div class="price-group">
                                    @if($juego->discount > 0)
                                    <span class="price-old">${{ number_format($juego->price, 2) }}</span>
                                    <span class="price-new">${{ number_format($juego->price - ($juego->price * $juego->discount / 100), 2) }}</span>
                                    @else
                                    <span class="price-new">${{ number_format($juego->price, 2) }}</span>
                                    @endif
                                </div>

                                <button class="btn-add-cart" data-game-id="{{ $juego->id }}">
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
                        <h3>No hay juegos disponibles</h3>
                        <p>Pronto tendremos nuevos títulos para ti</p>
                    </div>
                    @endforelse
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
                    <a href="#" class="section-link">
                        Ver todas
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <div class="games-grid">
                    @forelse($discountedGames ?? [] as $juego)
                    <div class="game-card featured">
                        <div class="game-image">
                            <img src="{{ $juego->images && count($juego->images) > 0 ? asset('storage/' . $juego->images[0]) : 'https://via.placeholder.com/400x250?text=Sin+Imagen' }}" alt="{{ $juego->title }}">

                            <div class="discount-badge large">-{{ $juego->discount }}%</div>

                            <button class="wishlist-btn" data-game-id="{{ $juego->id }}">
                                <i class="far fa-heart"></i>
                            </button>

                            <div class="game-overlay">
                                <button class="btn-view-details" data-game-id="{{ $juego->id }}">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </button>
                            </div>
                        </div>

                        <div class="game-info">
                            <h3 class="game-title">{{ $juego->title }}</h3>
                            <p class="game-developer">{{ $juego->developer }}</p>

                            <div class="game-tags">
                                @if(is_array($juego->genre))
                                @foreach(array_slice($juego->genre, 0, 2) as $genero)
                                <span class="tag-small">{{ $genero }}</span>
                                @endforeach
                                @else
                                <span class="tag-small">{{ $juego->genre ?? 'Sin género' }}</span>
                                @endif
                            </div>

                            <div class="game-footer">
                                <div class="price-group">
                                    <span class="price-old">${{ number_format($juego->price, 2) }}</span>
                                    <span class="price-new highlight">${{ number_format($juego->price - ($juego->price * $juego->discount / 100), 2) }}</span>
                                </div>

                                <button class="btn-add-cart" data-game-id="{{ $juego->id }}">
                                    <i class="fas fa-bolt"></i>
                                    Comprar
                                </button>
                            </div>

                            <div class="offer-timer">
                                <i class="fas fa-clock"></i>
                                <span>La oferta termina en 2d 15h 30m</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <h3>No hay ofertas disponibles</h3>
                        <p>Vuelve pronto para descubrir nuevas promociones</p>
                    </div>
                    @endforelse
                </div>
            </section>

            <!-- Sección de Nuevos Lanzamientos -->
            <section class="new-releases-section">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <div class="section-title-group">
                        <h2 class="section-title">Nuevos Lanzamientos 🚀</h2>
                        <p class="section-subtitle">Descubre los juegos más recientes</p>
                    </div>
                    <a href="#" class="section-link">
                        Ver todos
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>

                <div class="games-grid">
                    @forelse($newReleases ?? [] as $juego)
                    <div class="game-card new">
                        <div class="game-image">
                            <img src="{{ $juego->images && count($juego->images) > 0 ? asset('storage/' . $juego->images[0]) : 'https://via.placeholder.com/400x250?text=Sin+Imagen' }}" alt="{{ $juego->title }}">

                            <div class="new-badge">Nuevo</div>

                            <button class="wishlist-btn" data-game-id="{{ $juego->id }}">
                                <i class="far fa-heart"></i>
                            </button>

                            <div class="game-overlay">
                                <button class="btn-view-details" data-game-id="{{ $juego->id }}">
                                    <i class="fas fa-eye"></i>
                                    Ver Detalles
                                </button>
                            </div>
                        </div>

                        <div class="game-info">
                            <h3 class="game-title">{{ $juego->title }}</h3>
                            <p class="game-developer">{{ $juego->developer }}</p>

                            <div class="release-date">
                                <i class="fas fa-calendar-alt"></i>
                                {{ $juego->release_date->format('d M Y') }}
                            </div>

                            <div class="game-tags">
                                @if(is_array($juego->genre))
                                @foreach(array_slice($juego->genre, 0, 3) as $genero)
                                <span class="tag-small">{{ $genero }}</span>
                                @endforeach
                                @else
                                <span class="tag-small">{{ $juego->genre ?? 'Sin género' }}</span>
                                @endif
                            </div>

                            <div class="game-footer">
                                <div class="price-group">
                                    <span class="price-new">${{ number_format($juego->price, 2) }}</span>
                                </div>

                                <button class="btn-add-cart" data-game-id="{{ $juego->id }}">
                                    <i class="fas fa-shopping-cart"></i>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h3>No hay nuevos lanzamientos</h3>
                        <p>Estamos trabajando en traerte los mejores juegos</p>
                    </div>
                    @endforelse
                </div>
            </section>

        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="logo">
                        <div class="logo-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div class="logo-text">
                            <span class="logo-xp">XP</span>
                            <span class="logo-store">STORE</span>
                        </div>
                    </div>
                    <p class="footer-description">
                        Tu tienda de videojuegos favorita. Los mejores títulos a precios increíbles.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-discord"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <a href="{{ route('dashboard.user') }}">Catálogo</a>
                    <a href="#">Marketplace</a>
                    <a href="#">Códigos</a>
                    <a href="#">Mis Pedidos</a>
                </div>

                <div class="footer-section">
                    <h4>Soporte</h4>
                    <a href="#">Centro de Ayuda</a>
                    <a href="#">Contacto</a>
                    <a href="#">Política de Devoluciones</a>
                    <a href="#">Términos de Servicio</a>
                </div>

                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <p>Suscríbete para recibir ofertas exclusivas</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Tu email">
                        <button class="btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2024 XP Store. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Funcionalidad del dropdown del usuario
        document.addEventListener('DOMContentLoaded', function() {
            const userProfile = document.querySelector('.user-profile');
            const userDropdown = document.querySelector('.user-dropdown');

            if (userProfile && userDropdown) {
                userProfile.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('show');
                });

                // Cerrar dropdown al hacer click fuera
                document.addEventListener('click', function() {
                    userDropdown.classList.remove('show');
                });
            }

            // Wishlist functionality
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');
            wishlistButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const gameId = this.getAttribute('data-game-id');
                    const heartIcon = this.querySelector('i');

                    if (heartIcon) {
                        heartIcon.classList.toggle('far');
                        heartIcon.classList.toggle('fas');
                        heartIcon.classList.toggle('active');
                    }

                    // Aquí iría la llamada AJAX para agregar/remover de wishlist
                    console.log('Wishlist toggle for game:', gameId);
                });
            });

            // Add to cart functionality
            const addCartButtons = document.querySelectorAll('.btn-add-cart');
            addCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const gameId = this.getAttribute('data-game-id');

                    // Aquí iría la llamada AJAX para agregar al carrito
                    console.log('Add to cart game:', gameId);

                    // Actualizar contador del carrito
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        let currentCount = parseInt(cartCount.textContent) || 0;
                        cartCount.textContent = currentCount + 1;
                    }

                    // Efecto visual
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i> Agregado';
                    this.classList.add('added');

                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('added');
                    }, 2000);
                });
            });
        });
    </script>

</body>

</html>