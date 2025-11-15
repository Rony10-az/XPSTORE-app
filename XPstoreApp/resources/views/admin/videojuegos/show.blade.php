@extends('layouts.admin')

@section('title', $videojuego->title . ' - XP Store')

@vite(['resources/css/show.css'])

@section('content')
<div class="show-container">
    {{-- Header --}}
    <div class="show-header">
        <div class="show-title">
            <h1>{{ $videojuego->title }}</h1>
            <p class="show-subtitle">Detalles completos del videojuego</p>
            <div class="show-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>Lanzamiento: {{ $videojuego->release_date->format('d/m/Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-code-branch"></i>
                    <span>ID: #{{ $videojuego->id }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-sync-alt"></i>
                    <span>Actualizado: {{ $videojuego->updated_at->format('d/m/Y') }}</span>
                </div>
                @if($videojuego->featured)
                <div class="featured-badge">
                    <i class="fas fa-star"></i>
                    Destacado
                </div>
                @endif
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.videojuegos.edit', $videojuego->id) }}" class="btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.videojuegos.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    {{-- Layout Principal --}}
    <div class="show-layout">
        {{-- Columna Principal --}}
        <div class="main-content">
            {{-- Carousel de Imágenes --}}
            @if(!empty($videojuego->images))
            <div class="image-carousel">
                <div class="carousel-main">
                    <img id="main-image" src="{{ asset('storage/' . $videojuego->images[0]) }}"
                        alt="{{ $videojuego->title }}" data-current="0">
                </div>
                <div class="carousel-thumbnails">
                    @foreach($videojuego->images as $index => $image)
                    <div class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                        data-image="{{ asset('storage/' . $image) }}"
                        data-index="{{ $index }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Miniatura {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Descripción --}}
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Descripción
                </h2>
                <div class="description-content">
                    {!! nl2br(e($videojuego->description)) !!}
                </div>
            </div>

            {{-- Especificaciones --}}
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Especificaciones
                </h2>
                <div class="specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">Desarrollador</span>
                        <span class="spec-value">{{ $videojuego->developer }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Publicador</span>
                        <span class="spec-value">{{ $videojuego->publisher }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Fecha de Lanzamiento</span>
                        <span class="spec-value">{{ $videojuego->release_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Rating</span>
                        <span class="spec-value">{{ number_format($videojuego->rating, 1) }}/5.0</span>
                    </div>
                </div>
            </div>

            {{-- Requisitos del Sistema --}}
            @if($videojuego->requirements)
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-cog"></i>
                    Requisitos del Sistema
                </h2>
                <div class="requirements-grid">
                    @if(isset($videojuego->requirements['minimos']))
                    <div class="requirement-category">
                        <h4><i class="fas fa-desktop"></i> Mínimos</h4>
                        <div class="requirement-list">
                            @foreach($videojuego->requirements['minimos'] as $requirement => $value)
                            <div class="requirement-item">
                                <span class="requirement-name">{{ ucfirst($requirement) }}</span>
                                <span class="requirement-spec">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(isset($videojuego->requirements['recomendados']))
                    <div class="requirement-category">
                        <h4><i class="fas fa-rocket"></i> Recomendados</h4>
                        <div class="requirement-list">
                            @foreach($videojuego->requirements['recomendados'] as $requirement => $value)
                            <div class="requirement-item">
                                <span class="requirement-name">{{ ucfirst($requirement) }}</span>
                                <span class="requirement-spec">{{ $value }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- Reseñas --}}
            <div class="reviews-section">
                <h2 class="section-title">
                    <i class="fas fa-star"></i>
                    Reseñas y Calificaciones
                </h2>

                <div class="reviews-summary">
                    <div class="average-rating">
                        <div class="rating-large">{{ number_format($videojuego->rating, 1) }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $videojuego->rating ? 'star' : 'star-empty' }}"></i>
                                @endfor
                        </div>
                        <div class="rating-max">de 5.0</div>
                    </div>

                    <div class="rating-distribution">
                        @for($rating = 5; $rating >= 1; $rating--)
                        <div class="rating-bar">
                            <span class="bar-label">{{ $rating }}</span>
                            <div class="bar-container">
                                <div class="bar-fill"></div>
                            </div>
                            <span class=" bar-count">({{ rand(10, 50) }})</span>
                        </div>
                        @endfor
                    </div>
                </div>

                {{-- Lista de Reseñas (Ejemplo) --}}
                <div class="reviews-list">
                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">JD</div>
                                <div>
                                    <div class="reviewer-name">Juan Díaz</div>
                                    <div class="review-date">15 Mar 2024</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= 5 ? 'star' : 'star-empty' }}"></i>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <div class="review-content">
                            "Increíble juego! La historia es envolvente y los gráficos son espectaculares.
                            Definitivamente una de las mejores experiencias gaming del año."
                        </div>
                    </div>

                    <div class="review-item">
                        <div class="review-header">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">MG</div>
                                <div>
                                    <div class="reviewer-name">María González</div>
                                    <div class="review-date">10 Mar 2024</div>
                                </div>
                            </div>
                            <div class="review-rating">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= 4 ? 'star' : 'star-empty' }}"></i>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <div class="review-content">
                            "Muy buen juego, aunque algunos bugs afectan la experiencia.
                            Espero que los parchen pronto. Por lo demás, excelente."
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="sidebar">
            {{-- Card de Compra --}}
            <div class="purchase-card">
                <div class="price-section">
                    @if($videojuego->discount > 0)
                    <div class="current-price">
                        ${{ number_format($videojuego->price - ($videojuego->price * $videojuego->discount / 100), 2) }}
                        <span class="original-price">${{ number_format($videojuego->price, 2) }}</span>
                        <span class="discount-badge">-{{ $videojuego->discount }}%</span>
                    </div>
                    @else
                    <div class="current-price">
                        ${{ number_format($videojuego->price, 2) }}
                    </div>
                    @endif
                </div>

                <div class="stock-info {{ $videojuego->stock > 10 ? 'in-stock' : ($videojuego->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                    <i class="fas {{ $videojuego->stock > 10 ? 'fa-check-circle' : ($videojuego->stock > 0 ? 'fa-exclamation-triangle' : 'fa-times-circle') }}"></i>
                    <span>
                        @if($videojuego->stock > 10)
                        En stock ({{ $videojuego->stock }} unidades)
                        @elseif($videojuego->stock > 0)
                        Stock bajo ({{ $videojuego->stock }} unidades)
                        @else
                        Sin stock
                        @endif
                    </span>
                </div>

                <div class="rating-section">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= floor($videojuego->rating) ? 'star' : ($i <= $videojuego->rating ? 'star-half' : 'star-empty') }}"></i>
                            @endfor
                    </div>
                    <div class="rating-value">{{ number_format($videojuego->rating, 1) }}</div>
                    <div class="rating-count">({{ rand(100, 500) }} reseñas)</div>
                </div>

                <div class="purchase-actions">
                    @if($videojuego->stock > 0)
                    <button class="btn-add-cart">
                        <i class="fas fa-shopping-cart"></i>
                        Agregar al Carrito
                    </button>
                    @else
                    <button class="btn-add-cart" disabled>
                        <i class="fas fa-times"></i>
                        No Disponible
                    </button>
                    @endif

                    <button class="btn-wishlist">
                        <i class="fas fa-heart"></i>
                        Agregar a Wishlist
                    </button>
                </div>

                <div class="game-features">
                    <h4>Características</h4>
                    <ul>
                        <li><i class="fas fa-check"></i> Descarga digital instantánea</li>
                        <li><i class="fas fa-check"></i> Garantía de reembolso 30 días</li>
                        <li><i class="fas fa-check"></i> Soporte técnico 24/7</li>
                        <li><i class="fas fa-check"></i> Actualizaciones gratuitas</li>
                    </ul>
                </div>
            </div>

            {{-- Plataformas --}}
            <div class="platform-info">
                <h3 class="section-title">
                    <i class="fas fa-gamepad"></i>
                    Plataformas
                </h3>
                <div class="platform-tags">
                    @if(is_array($videojuego->platform))
                    @foreach($videojuego->platform as $platform)
                    <span class="platform-tag">
                        <i class="fas fa-check"></i>
                        {{ $platform }}
                    </span>
                    @endforeach
                    @else
                    <span class="platform-tag">
                        <i class="fas fa-check"></i>
                        {{ $videojuego->platform }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Géneros --}}
            <div class="genres-section">
                <h3 class="section-title">
                    <i class="fas fa-tags"></i>
                    Géneros
                </h3>
                <div class="genre-tags">
                    @if(is_array($videojuego->genre))
                    @foreach($videojuego->genre as $genre)
                    <span class="genre-tag">{{ $genre }}</span>
                    @endforeach
                    @else
                    <span class="genre-tag">{{ $videojuego->genre }}</span>
                    @endif
                </div>
            </div>

            {{-- Información de Desarrollador --}}
            <div class="game-info-section">
                <h3 class="section-title">
                    <i class="fas fa-building"></i>
                    Información del Desarrollador
                </h3>
                <div class="specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">Desarrollador</span>
                        <span class="spec-value">{{ $videojuego->developer }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Publicador</span>
                        <span class="spec-value">{{ $videojuego->publisher }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Fecha de Lanzamiento</span>
                        <span class="spec-value">{{ $videojuego->release_date->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Carousel de imágenes
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('main-image');

        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const imageSrc = this.getAttribute('data-image');
                const imageIndex = this.getAttribute('data-index');

                // Actualizar imagen principal
                mainImage.src = imageSrc;
                mainImage.setAttribute('data-current', imageIndex);

                // Actualizar thumbnails activos
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Auto-rotación del carousel cada 5 segundos
        let currentIndex = 0;
        setInterval(() => {
            if (thumbnails.length > 0) {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                thumbnails[currentIndex].click();
            }
        }, 5000);
    });

    // Animación de contador para rating
    function animateCounter(element, target, duration) {
        let start = 0;
        const increment = target / (duration / 16);

        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target.toFixed(1);
                clearInterval(timer);
            } else {
                element.textContent = start.toFixed(1);
            }
        }, 16);
    }

    // Iniciar animaciones cuando la página carga
    window.addEventListener('load', function() {
        const ratingElements = document.querySelectorAll('.rating-large, .rating-value');
        ratingElements.forEach(element => {
            const target = parseFloat(element.textContent);
            animateCounter(element, target, 1000);
        });
    });
</script>
@endpush