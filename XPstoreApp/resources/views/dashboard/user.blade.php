@extends('layouts.app')

@section('title', 'Dashboard - XP Store')

@section('content')
<div class="container">

    <!-- Botón de filtros vertical -->
    <button class="filters-btn-vertical" id="filtersToggle">
        <i class="fas fa-sliders-h"></i>
        <span class="filters-text">FILTROS</span>
    </button>

    <!-- ====================== -->
    <!--      HERO CAROUSEL     -->
    <!-- ====================== -->
    <section class="hero-section">
        <div class="hero-background">
            <img src="https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp" alt="">
            <div class="hero-overlay"></div>
        </div>

        <div class="hero-content">
            <span class="badge-destacado"><i class="fas fa-bolt"></i> Destacado</span>

            <h1 class="hero-title">God Of War Ragnarok</h1>
            <p class="hero-description">Embárcate en una aventura épica...</p>

            <div class="hero-tags">
                <span class="tag">Aventura</span>
                <span class="tag">Acción</span>
                <span class="tag">Exploración</span>
            </div>

            <div class="hero-price">
                <span class="price">$59.99</span>
            </div>

            <div class="hero-actions">

                <!-- BOTÓN VER DETALLES (DINÁMICO) -->
                <a id="hero-details-btn" href="#" class="btn-primary">
                    Ver Detalles
                </a>

                <!-- BOTÓN AGREGAR AL CARRITO (DINÁMICO) -->
                <form id="hero-cart-form" action="" method="POST">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        Agregar al Carrito
                    </button>
                </form>

            </div>
        </div>

        <!-- Indicadores del Carrusel -->
        <div class="carousel-indicators">
            <div class="indicator active"></div>
            <div class="indicator"></div>
            <div class="indicator"></div>
            <div class="indicator"></div>
        </div>

    </section>
    @endif

    <!-- ====================== -->
    <!--   JUEGOS POPULARES     -->
    <!-- ====================== -->
    <section class="games-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-gamepad"></i>
            </div>

            <div class="section-title-group">
                <h2 class="section-title">Catálogo de Videojuegos 🎮</h2>
                <p class="section-subtitle">Todos nuestros títulos disponibles</p>
            </div>

            <a href="#" class="section-link">
                Ver todos
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>

        <div class="games-grid" id="popularGames">
            @forelse($popularGames as $juego)
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
    </section>
    <!-- ====================== -->
    <!--     MEJORES OFERTAS    -->
    <!-- ====================== -->
    <section class="games-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-bolt"></i>
            </div>

            <div class="section-title-group">
                <h2 class="section-title">Mejores Ofertas ⚡</h2>
                <p class="section-subtitle">Juegos con los mayores descuentos</p>
            </div>
        </div>

        <div class="games-grid">
            @foreach($bestOffers as $game)
            <x-game-card :game="$game" />
            @endforeach
        </div>
    </section>



    <!-- ====================== -->
    <!--     MEJOR VALORADOS    -->
    <!-- ====================== -->
    <section class="games-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-star"></i>
            </div>

            <div class="section-title-group">
                <h2 class="section-title">Mejor Valorados ⭐</h2>
                <p class="section-subtitle">Los favoritos de la comunidad</p>
            </div>
        </div>

        <div class="games-grid">
            @foreach($topRated as $game)
            <x-game-card :game="$game" />
            @endforeach
        </div>
    </section>



    <!-- ====================== -->
    <!--     TODO EL CATÁLOGO   -->
    <!-- ====================== -->
    <section class="games-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-th"></i>
            </div>

            <div class="section-title-group">
                <h2 class="section-title">Todo el Catálogo 🎮</h2>
                <p class="section-subtitle">Explora todos los títulos disponibles</p>
            </div>
        </div>

        <div class="games-grid">
            @foreach($allGames as $game)
            <x-game-card :game="$game" />
            @endforeach
        </div>
    </section>


    <!-- BOTÓN FLOTANTE -->
    <div class="community-float-btn" id="openCommunity">
        <i class="fas fa-comment-alt"></i>
        <span class="status-dot"></span>
    </div>

    <!-- PANEL DE COMUNIDAD -->
    <div class="community-card" id="communityPanel">

        <div class="community-header">
            <div class="community-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="community-title">Comunidad Gamer</h3>
        </div>

        <p class="community-text">
            Únete, comparte reseñas, descubre nuevos juegos y conecta con otros gamers.
        </p>

        <ul class="community-benefits">
            <li><i class="fas fa-check-circle"></i> +1,234 usuarios activos</li>
            <li><i class="fas fa-check-circle"></i> +5,678 reseñas compartidas</li>
        </ul>

        <a href="{{ route('community.index') }}" class="community-btn">
            Ir a la Comunidad
        </a>

    </div>

</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const heroSection = document.querySelector('.hero-section');
        if (!heroSection) return;

        // === TUS JUEGOS DEL CARRUSEL (AHORA CON ID PARA FUNCIONAR) ===
        const heroGames = [{
                id: 1,
                title: 'God Of War Ragnarok',
                description: 'Embárcate en una aventura épica en un mundo lleno de mitología nórdica.',
                image: 'https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp',
                tags: ['Aventura', 'Acción', 'Exploración'],
                price: '$59.99'
            },
            {
                id: 5,
                title: 'Grand Theft Auto V',
                description: 'Explora Los Santos, una ciudad llena de acción y crimen.',
                image: 'https://wallpapers.com/images/high/4k-gta-5-franklin-looking-at-city-at-night-bq6nlp808hn0xoi5.webp',
                tags: ['Acción', 'Aventura', 'Mundo Abierto'],
                price: '$19.99'
            },
            {
                id: 3,
                title: 'Marvel’s Spider-Man 2',
                description: 'Balancea por Nueva York y enfréntate a nuevos villanos.',
                image: 'https://wallpapers.com/images/high/spider-man-ps4-4k-i5ssgd6fq17lrz7i.webp',
                tags: ['Acción', 'Aventura', 'Superhéroes'],
                price: '$59.49'
            },
            {
                id: 4,
                title: 'Horizon Zero Dawn',
                description: 'Explora un mundo dominado por criaturas mecánicas.',
                image: 'https://wallpapers.com/images/high/horizon-zero-dawn-nighttime-screenshot-yft9z5fm7kbaymmg.webp',
                tags: ['Aventura', 'Acción', 'Mundo Abierto'],
                price: '$39.99'
            }
        ];

        const indicators = document.querySelectorAll('.indicator');
        let currentSlide = 0;

        function updateHero(index) {
            const hero = heroGames[index];

            const heroBackground = document.querySelector('.hero-background img');
            const heroTitle = document.querySelector('.hero-title');
            const heroDescription = document.querySelector('.hero-description');
            const heroTags = document.querySelector('.hero-tags');
            const heroPrice = document.querySelector('.price');

            const heroDetailsBtn = document.getElementById('hero-details-btn');
            const heroCartForm = document.getElementById('hero-cart-form');

            // Fade out
            heroSection.style.opacity = '0.7';

            setTimeout(() => {
                heroBackground.src = hero.image;
                heroTitle.textContent = hero.title;
                heroDescription.textContent = hero.description;
                heroPrice.textContent = hero.price;

                heroTags.innerHTML = hero.tags
                    .map(tag => `<span class="tag">${tag}</span>`)
                    .join('');

                // === ACTUALIZAR BOTONES ===
                heroDetailsBtn.href = `/juego/${hero.id}`;
                heroCartForm.action = `/cart/add/${hero.id}`;

                indicators.forEach((ind, i) => {
                    ind.classList.toggle('active', i === index);
                });

                heroSection.style.opacity = '1';
            }, 300);
        }

        // Auto-slide
        setInterval(() => {
            currentSlide = (currentSlide + 1) % heroGames.length;
            updateHero(currentSlide);
        }, 5000);

        // Click en indicadores
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentSlide = index;
                updateHero(index);
            });
        });
    });
</script>
@endpush