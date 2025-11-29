@extends('layouts.app')

@section('title', 'Dashboard - XP Store')

@section('content')
<div class="container">

    <!-- Hero Section - Carrusel de Juegos Destacados -->
    @if($featuredGames->isNotEmpty())
    <section class="hero-section" id="heroCarousel">
        @foreach($featuredGames as $index => $game)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
            <div class="hero-background">
                <img src="{{ $game->image }}" alt="{{ $game->title }}">
                <div class="hero-overlay"></div>
            </div>

            <div class="hero-content">
                <span class="badge-destacado"><i class="fas fa-bolt"></i> Destacado</span>
                <h1 class="hero-title">{{ $game->title }}</h1>
                <p class="hero-description">{{ Str::limit($game->description ?? 'Descubre este increíble juego', 120) }}</p>

                <div class="hero-tags">
                    @foreach(array_slice($game->genres ?? [], 0, 3) as $genre)
                    <span class="tag">{{ $genre }}</span>
                    @endforeach
                </div>

                <div class="hero-price">
                    @if($game->discount > 0)
                    <span class="old-price">S/.{{ number_format($game->price, 2) }}</span>
                    <span class="price">S/.{{ number_format($game->price * (1 - $game->discount/100), 2) }}</span>
                    <span class="discount-badge">-{{ $game->discount }}%</span>
                    @else
                    <span class="price">S/.{{ number_format($game->price, 2) }}</span>
                    @endif
                </div>

                <div class="hero-actions">
                    <a href="{{ route('game.show', $game->id) }}" class="btn-primary">Ver Detalles</a>
                    <form action="{{ route('cart.add', $game->id) }}" method="POST" class="add-to-cart-form" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-secondary">Agregar al Carrito</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Controles del carrusel -->
        @if($featuredGames->count() > 1)
        <div class="carousel-controls">
            <button class="carousel-btn prev" onclick="changeSlide(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="carousel-indicators">
                @foreach($featuredGames as $index => $game)
                <span class="indicator {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></span>
                @endforeach
            </div>
            <button class="carousel-btn next" onclick="changeSlide(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        @endif
    </section>
    @endif


    <!-- Catálogo Completo de Videojuegos -->
    <section class="games-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-gamepad"></i>
            </div>
            <div class="section-title-group">
                <h2 class="section-title">Catálogo de Videojuegos 🎮</h2>
                <p class="section-subtitle">Todos nuestros títulos disponibles</p>
            </div>
            <a href="{{ route('store.index') }}" class="section-link">
                Ver tienda completa
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="games-grid" id="catalogGames">
            @forelse($allGames as $juego)
            <x-game-card :game="$juego" />
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

        <!-- Paginación -->
        @if($allGames->hasPages())
        <div style="margin-top: 2rem;">
            {{ $allGames->links('vendor.pagination.admin') }}
        </div>
        @endif
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Carrusel de juegos destacados
    let currentSlide = 0;
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.indicator');
    const totalSlides = slides.length;
    let autoPlayInterval;

    function showSlide(index) {
        // Ocultar todas las slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });

        // Desactivar todos los indicadores
        indicators.forEach(indicator => {
            indicator.classList.remove('active');
        });

        // Normalizar el índice (circular)
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }

        // Mostrar la slide actual
        slides[currentSlide].classList.add('active');
        if (indicators[currentSlide]) {
            indicators[currentSlide].classList.add('active');
        }
    }

    function changeSlide(direction) {
        showSlide(currentSlide + direction);
        resetAutoPlay();
    }

    function goToSlide(index) {
        showSlide(index);
        resetAutoPlay();
    }

    function autoPlay() {
        autoPlayInterval = setInterval(() => {
            showSlide(currentSlide + 1);
        }, 5000); // Cambia cada 5 segundos
    }

    function resetAutoPlay() {
        clearInterval(autoPlayInterval);
        autoPlay();
    }

    // Iniciar auto-play si hay más de una slide
    if (totalSlides > 1) {
        autoPlay();

        // Pausar auto-play al pasar el mouse sobre el hero
        const heroSection = document.getElementById('heroCarousel');
        if (heroSection) {
            heroSection.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });

            heroSection.addEventListener('mouseleave', () => {
                autoPlay();
            });
        }
    }
</script>
@endpush