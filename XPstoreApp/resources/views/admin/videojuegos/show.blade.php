@extends('layouts.admin')

@section('title', $videojuego->title . ' - XP Store')

@vite(['resources/css/admin/Game/show.css'])

@section('content')
<div class="show-container">

    {{-- ================= HEADER ================= --}}
    <div class="show-header">
        <div class="show-title">
            <h1>{{ $videojuego->title }}</h1>
            <p class="show-subtitle">Detalles completos del videojuego</p>

            <div class="show-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar"></i> 
                    Lanzamiento: {{ \Carbon\Carbon::parse($videojuego->release_date)->format('d/m/Y') }}
                </div>
                <div class="meta-item">
                    <i class="fas fa-code-branch"></i> 
                    ID: #{{ $videojuego->id }}
                </div>
                <div class="meta-item">
                    <i class="fas fa-sync-alt"></i> 
                    Actualizado: {{ $videojuego->updated_at->format('d/m/Y') }}
                </div>

                @if($videojuego->featured)
                <div class="featured-badge">
                    <i class="fas fa-star"></i> Destacado
                </div>
                @endif
            </div>
        </div>

        <div class="header-actions">
            <a href="{{ route('admin.videojuegos.edit', $videojuego->id) }}" class="btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.videojuegos.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- ================= LAYOUT PRINCIPAL ================= --}}
    <div class="show-layout">

        {{-- ============ COLUMNA IZQUIERDA ============ --}}
        <div class="main-content">

            {{-- ================= CARRUSEL ================= --}}
            @if(!empty($videojuego->images) && is_array($videojuego->images))
            <div class="image-carousel">
                <div class="carousel-main">
                    <img id="main-image"
                        src="{{ asset('storage/' . $videojuego->images[0]) }}"
                        alt="{{ $videojuego->title }}"
                        data-current="0">
                </div>

                <div class="carousel-thumbnails">
                    @foreach($videojuego->images as $i => $image)
                    <div class="thumbnail {{ $i === 0 ? 'active' : '' }}"
                        data-image="{{ asset('storage/' . $image) }}"
                        data-index="{{ $i }}">
                        <img src="{{ asset('storage/' . $image) }}" alt="Imagen {{ $i + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="image-carousel">
                <div class="carousel-main no-image">
                    <i class="fas fa-gamepad"></i>
                    <p>Sin imágenes disponibles</p>
                </div>
            </div>
            @endif

            {{-- ================= DESCRIPCIÓN ================= --}}
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-file-alt"></i> Descripción
                </h2>
                <div class="description-content">
                    {!! nl2br(e($videojuego->description)) !!}
                </div>
            </div>

            {{-- ================= ESPECIFICACIONES ================= --}}
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle"></i> Especificaciones
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
                        <span class="spec-label">Lanzamiento</span>
                        <span class="spec-value">{{ \Carbon\Carbon::parse($videojuego->release_date)->format('d/m/Y') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Rating</span>
                        <span class="spec-value">{{ number_format($videojuego->rating, 1) }}/5</span>
                    </div>
                </div>
            </div>

            {{-- ================= REQUISITOS ================= --}}
            @if($videojuego->requirements && is_array($videojuego->requirements))
            <div class="game-info-section">
                <h2 class="section-title">
                    <i class="fas fa-cog"></i> Requisitos del Sistema
                </h2>

                <div class="requirements-grid">
                    {{-- Mínimos --}}
                    @if(isset($videojuego->requirements['minimos']) || isset($videojuego->requirements['mínimos']))
                    <div class="requirement-category">
                        <h4><i class="fas fa-desktop"></i> Mínimos</h4>
                        <div class="requirement-list">
                            @php
                                $minimos = $videojuego->requirements['minimos'] ?? $videojuego->requirements['mínimos'] ?? [];
                            @endphp
                            @foreach($minimos as $req => $val)
                            <div class="requirement-item">
                                <span class="requirement-name">{{ ucfirst($req) }}</span>
                                <span class="requirement-spec">{{ $val }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Recomendados --}}
                    @if(isset($videojuego->requirements['recomendados']))
                    <div class="requirement-category">
                        <h4><i class="fas fa-rocket"></i> Recomendados</h4>
                        <div class="requirement-list">
                            @foreach($videojuego->requirements['recomendados'] as $req => $val)
                            <div class="requirement-item">
                                <span class="requirement-name">{{ ucfirst($req) }}</span>
                                <span class="requirement-spec">{{ $val }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            {{-- ================= RESEÑAS ================= --}}
            <div class="reviews-section">
                <h2 class="section-title">
                    <i class="fas fa-star"></i> Reseñas
                </h2>

                <div class="reviews-summary">
                    <div class="average-rating">
                        <div class="rating-large">{{ number_format($videojuego->rating, 1) }}</div>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $videojuego->rating ? 'star' : 'star-empty' }}"></i>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Lista de reseñas --}}
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
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star star"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="review-content">
                            "Increíble juego! La historia es envolvente y los gráficos espectaculares."
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ COLUMNA DERECHA (SIDEBAR) ============ --}}
        <div class="sidebar">

            {{-- CARD DE COMPRA --}}
            <div class="purchase-card">
                <div class="price-section">
                    @if($videojuego->discount > 0)
                    <div class="price-container">
                        <span class="discount-badge">-{{ $videojuego->discount }}%</span>
                        <div class="price-info">
                            <span class="original-price">S/.{{ number_format($videojuego->price, 2) }}</span>
                            <span class="current-price">
                                S/.{{ number_format($videojuego->price * (1 - $videojuego->discount / 100), 2) }}
                            </span>
                        </div>
                    </div>
                    @else
                    <div class="current-price">S/.{{ number_format($videojuego->price, 2) }}</div>
                    @endif
                </div>

                <div class="stock-info {{ $videojuego->stock > 0 ? 'in-stock' : 'out-stock' }}">
                    <i class="fas {{ $videojuego->stock > 0 ? 'fa-check' : 'fa-times' }}"></i>
                    <span>
                        @if($videojuego->stock > 0)
                            {{ $videojuego->stock }} unidades disponibles
                        @else
                            Sin stock
                        @endif
                    </span>
                </div>

                <div class="purchase-actions">
                    <button class="btn-add-cart" {{ $videojuego->stock <= 0 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i> Agregar al Carrito
                    </button>
                    <button class="btn-wishlist">
                        <i class="fas fa-heart"></i> Wishlist
                    </button>
                </div>

                <div class="game-features">
                    <h4>Características</h4>
                    <ul>
                        <li><i class="fas fa-check"></i> Descarga digital instantánea</li>
                        <li><i class="fas fa-check"></i> Reembolso 30 días</li>
                        <li><i class="fas fa-check"></i> Soporte 24/7</li>
                    </ul>
                </div>
            </div>

            {{-- PLATAFORMAS --}}
            <div class="platform-info">
                <h3 class="section-title">
                    <i class="fas fa-gamepad"></i> Plataformas
                </h3>
                <div class="platform-tags">
                    @if(!empty($videojuego->platform) && is_array($videojuego->platform))
                        @foreach($videojuego->platform as $p)
                        <span class="platform-tag">
                            <i class="fas fa-check"></i> {{ $p }}
                        </span>
                        @endforeach
                    @else
                        <p class="no-data">Sin plataformas definidas</p>
                    @endif
                </div>
            </div>

            {{-- GÉNEROS --}}
            <div class="genres-section">
                <h3 class="section-title">
                    <i class="fas fa-tags"></i> Géneros
                </h3>
                <div class="genre-tags">
                    @if(!empty($videojuego->genre) && is_array($videojuego->genre))
                        @foreach($videojuego->genre as $g)
                        <span class="genre-tag">{{ $g }}</span>
                        @endforeach
                    @else
                        <p class="no-data">Sin géneros definidos</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Carrusel de imágenes
    document.addEventListener('DOMContentLoaded', () => {
        const thumbs = document.querySelectorAll('.thumbnail');
        const main = document.getElementById('main-image');

        if (thumbs.length && main) {
            thumbs.forEach(t => {
                t.addEventListener('click', function() {
                    main.src = this.dataset.image;
                    thumbs.forEach(x => x.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }
    });
</script>
@endpush