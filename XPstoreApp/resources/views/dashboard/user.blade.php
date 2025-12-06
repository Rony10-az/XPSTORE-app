@extends('layouts.app')

@section('title', 'Dashboard - XP Store')

@section('content')
<div class="container">

    <!-- Botón de filtros vertical -->
    <button class="filters-btn-vertical" id="filtersToggle">
        <i class="fas fa-sliders-h"></i>
        <span class="filters-text">FILTROS</span>
    </button>

    <!-- Panel de filtros -->
    <div class="filters-panel" id="filtersPanel">
        <div class="filters-header">
            <h3><i class="fas fa-filter"></i> Filtros</h3>
            <button class="filters-close" id="filtersClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="filters-content">
            <!-- Filtro por Género -->
            <div class="filter-group">
                <h4>Género</h4>
                <div class="filter-options scrollable">
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="accion" class="filter-checkbox">
                        <span>Acción</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="aventura" class="filter-checkbox">
                        <span>Aventura</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="rpg" class="filter-checkbox">
                        <span>RPG</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="estrategia" class="filter-checkbox">
                        <span>Estrategia</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="deportes" class="filter-checkbox">
                        <span>Deportes</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="carreras" class="filter-checkbox">
                        <span>Carreras</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="shooter" class="filter-checkbox">
                        <span>Shooter</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="lucha" class="filter-checkbox">
                        <span>Lucha</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="simulacion" class="filter-checkbox">
                        <span>Simulación</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="indie" class="filter-checkbox">
                        <span>Indie</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="terror" class="filter-checkbox">
                        <span>Terror</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="multijugador" class="filter-checkbox">
                        <span>Multijugador</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="mundo abierto" class="filter-checkbox">
                        <span>Mundo Abierto</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="fantasia" class="filter-checkbox">
                        <span>Fantasía</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="ciencia ficcion" class="filter-checkbox">
                        <span>Ciencia Ficción</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="battle royale" class="filter-checkbox">
                        <span>Battle Royale</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="genre" value="mmorpg" class="filter-checkbox">
                        <span>MMORPG</span>
                    </label>
                </div>
            </div>

            <!-- Filtro por Plataforma -->
            <div class="filter-group">
                <h4>Plataforma</h4>
                <div class="filter-options scrollable">
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="pc" class="filter-checkbox">
                        <span>PC</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="playstation 5" class="filter-checkbox">
                        <span>PlayStation 5</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="xbox series x/s" class="filter-checkbox">
                        <span>Xbox Series X/S</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="nintendo switch" class="filter-checkbox">
                        <span>Nintendo Switch</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="playstation 4" class="filter-checkbox">
                        <span>PlayStation 4</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="xbox one" class="filter-checkbox">
                        <span>Xbox One</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="mobile" class="filter-checkbox">
                        <span>Mobile</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="vr" class="filter-checkbox">
                        <span>VR</span>
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="platform" value="cloud gaming" class="filter-checkbox">
                        <span>Cloud Gaming</span>
                    </label>
                </div>
            </div>

            <!-- Filtro por Popularidad -->
            <div class="filter-group">
                <h4>Popularidad</h4>
                <select name="popularity" id="popularityFilter" class="filter-select">
                    <option value="">Todas</option>
                    <option value="high">Alta (4+ estrellas)</option>
                    <option value="medium">Media (3-4 estrellas)</option>
                    <option value="low">Baja (< 3 estrellas)</option>
                </select>
            </div>

            <!-- Filtro por Estado -->
            <div class="filter-group">
                <h4>Disponibilidad</h4>
                <select name="stock" id="stockFilter" class="filter-select">
                    <option value="">Todos</option>
                    <option value="available">En Stock</option>
                    <option value="low">Stock Bajo (< 5)</option>
                </select>
            </div>

            <!-- Filtro por Descuento -->
            <div class="filter-group">
                <h4>Descuentos</h4>
                <label class="filter-option">
                    <input type="checkbox" name="discount" value="on_sale" id="discountFilter" class="filter-checkbox">
                    <span>Solo con descuento</span>
                </label>
            </div>

            <!-- Botones de acción -->
            <div class="filter-actions">
                <button class="btn-apply-filters" id="applyFilters">
                    <i class="fas fa-check"></i> Aplicar Filtros
                </button>
                <button class="btn-clear-filters" id="clearFilters">
                    <i class="fas fa-redo"></i> Limpiar
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay para cerrar el panel -->
    <div class="filters-overlay" id="filtersOverlay"></div>

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
                <span class="price">S/.59.99</span>
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

        // ========== FILTROS ==========
        const filtersToggle = document.getElementById('filtersToggle');
        const filtersPanel = document.getElementById('filtersPanel');
        const filtersClose = document.getElementById('filtersClose');
        const filtersOverlay = document.getElementById('filtersOverlay');
        const applyFilters = document.getElementById('applyFilters');
        const clearFilters = document.getElementById('clearFilters');

        // Abrir panel
        filtersToggle.addEventListener('click', () => {
            filtersPanel.classList.add('active');
            filtersOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Cerrar panel
        const closePanel = () => {
            filtersPanel.classList.remove('active');
            filtersOverlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        filtersClose.addEventListener('click', closePanel);
        filtersOverlay.addEventListener('click', closePanel);

        // Aplicar filtros
        applyFilters.addEventListener('click', () => {
            applyGameFilters();
            closePanel();
        });

        // Limpiar filtros
        clearFilters.addEventListener('click', () => {
            document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('popularityFilter').value = '';
            document.getElementById('stockFilter').value = '';
            applyGameFilters();
        });

        // Función para filtrar juegos
        function applyGameFilters() {
            const selectedGenres = Array.from(document.querySelectorAll('input[name="genre"]:checked')).map(cb => cb.value.toLowerCase().trim());
            const selectedPlatforms = Array.from(document.querySelectorAll('input[name="platform"]:checked')).map(cb => cb.value.toLowerCase().trim());
            const popularity = document.getElementById('popularityFilter').value;
            const stock = document.getElementById('stockFilter').value;
            const onlyDiscount = document.getElementById('discountFilter').checked;

            const gameCards = document.querySelectorAll('.eneba-card');

            gameCards.forEach(card => {
                let show = true;

                // Filtro por género - busca en los tags de la card
                if (selectedGenres.length > 0) {
                    // Buscar todos los posibles contenedores de géneros
                    const cardTags = Array.from(card.querySelectorAll('.game-tags .tag, .tag'))
                        .map(tag => tag.textContent.toLowerCase().trim())
                        .filter(tag => tag.length > 0);

                    // Debe coincidir con al menos uno de los géneros seleccionados
                    show = selectedGenres.some(genre => {
                        const normalizedGenre = genre.replace(/\s+/g, '').replace(/[áàäâ]/g, 'a').replace(/[éèëê]/g, 'e').replace(/[íìïî]/g, 'i').replace(/[óòöô]/g, 'o').replace(/[úùüû]/g, 'u');

                        return cardTags.some(tag => {
                            const normalizedTag = tag.replace(/\s+/g, '').replace(/[áàäâ]/g, 'a').replace(/[éèëê]/g, 'e').replace(/[íìïî]/g, 'i').replace(/[óòöô]/g, 'o').replace(/[úùüû]/g, 'u');

                            // Comparar sin espacios ni acentos
                            return normalizedTag === normalizedGenre ||
                                   normalizedTag.includes(normalizedGenre) ||
                                   normalizedGenre.includes(normalizedTag);
                        });
                    });
                }

                // Filtro por plataforma - busca en los platform-tags de la card
                if (show && selectedPlatforms.length > 0) {
                    // Buscar todos los posibles contenedores de plataformas
                    const cardPlatforms = Array.from(card.querySelectorAll('.platform-tags .platform, .platform'))
                        .map(p => p.textContent.toLowerCase().trim())
                        .filter(p => p.length > 0);

                    // Debe coincidir con al menos una de las plataformas seleccionadas
                    show = selectedPlatforms.some(platform => {
                        const normalizedPlatform = platform.replace(/\s+/g, '').replace(/\//g, '');

                        return cardPlatforms.some(cp => {
                            const normalizedCardPlatform = cp.replace(/\s+/g, '').replace(/\//g, '');

                            return normalizedCardPlatform === normalizedPlatform ||
                                   normalizedCardPlatform.includes(normalizedPlatform) ||
                                   normalizedPlatform.includes(normalizedCardPlatform);
                        });
                    });
                }

                // Filtro por popularidad (rating)
                if (show && popularity) {
                    const ratingElement = card.querySelector('.rating-badge');
                    if (ratingElement) {
                        const ratingText = ratingElement.textContent.trim();
                        const rating = parseFloat(ratingText.replace(/[^\d.]/g, ''));

                        if (popularity === 'high' && rating < 4) show = false;
                        if (popularity === 'medium' && (rating < 3 || rating >= 4)) show = false;
                        if (popularity === 'low' && rating >= 3) show = false;
                    } else if (popularity !== '') {
                        // Si no tiene rating y se filtra por popularidad, ocultar
                        show = false;
                    }
                }

                // Filtro por stock
                if (show && stock) {
                    const stockBadge = card.querySelector('.stock-badge');
                    if (stockBadge) {
                        const stockText = stockBadge.textContent;
                        const stockNum = parseInt(stockText.match(/\d+/)?.[0] || 0);

                        if (stock === 'available' && stockNum === 0) show = false;
                        if (stock === 'low' && stockNum >= 5) show = false;
                    } else if (stock === 'available') {
                        // Si no tiene badge de stock, asumimos que no está disponible
                        show = false;
                    }
                }

                // Filtro por descuento
                if (show && onlyDiscount) {
                    const discountBadge = card.querySelector('.discount-badge');
                    if (!discountBadge) show = false;
                }

                card.style.display = show ? '' : 'none';
            });
        }

        const heroSection = document.querySelector('.hero-section');
        if (!heroSection) return;

        // === TUS JUEGOS DEL CARRUSEL (AHORA CON ID PARA FUNCIONAR) ===
        const heroGames = [{
                id: 1,
                title: 'God Of War Ragnarok',
                description: 'Embárcate en una aventura épica en un mundo lleno de mitología nórdica.',
                image: 'https://wallpapers.com/images/high/kratos-in-cave-god-of-war-ragnarok-hmaawiodgr64ldzm.webp',
                tags: ['Aventura', 'Acción', 'Exploración'],
                price: 'S/.59.99'
            },
            {
                id: 5,
                title: 'Grand Theft Auto V',
                description: 'Explora Los Santos, una ciudad llena de acción y crimen.',
                image: 'https://wallpapers.com/images/high/4k-gta-5-franklin-looking-at-city-at-night-bq6nlp808hn0xoi5.webp',
                tags: ['Acción', 'Aventura', 'Mundo Abierto'],
                price: 'S/.19.99'
            },
            {
                id: 3,
                title: 'Marvel’s Spider-Man 2',
                description: 'Balancea por Nueva York y enfréntate a nuevos villanos.',
                image: 'https://wallpapers.com/images/high/spider-man-ps4-4k-i5ssgd6fq17lrz7i.webp',
                tags: ['Acción', 'Aventura', 'Superhéroes'],
                price: 'S/.59.49'
            },
            {
                id: 4,
                title: 'Horizon Zero Dawn',
                description: 'Explora un mundo dominado por criaturas mecánicas.',
                image: 'https://wallpapers.com/images/high/horizon-zero-dawn-nighttime-screenshot-yft9z5fm7kbaymmg.webp',
                tags: ['Aventura', 'Acción', 'Mundo Abierto'],
                price: 'S/.39.99'
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