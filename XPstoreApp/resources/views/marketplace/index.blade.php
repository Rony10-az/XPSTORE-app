@extends('layouts.app')

@section('title', 'Marketplace - XP Store')

@section('content')
<div class="container">

    <!-- Hero Banner -->
    <section class="marketplace-hero">
        <div class="hero-content-wrapper">
            <div class="hero-text">
                <h1 class="hero-title">
                    ¡Encuentra tu próxima <span class="highlight">obsesión</span>
                </h1>
                <p class="hero-description">
                    Descubre items únicos, skins exclusivos y objetos raros para tus juegos favoritos.
                    Desde equipamiento legendario hasta customizaciones épicas, todo lo que necesitas
                    para destacar está aquí. ¡Explora nuestro marketplace y lleva tu experiencia gaming
                    al siguiente nivel!
                </p>
                <div class="hero-cta">
                    <a href="#items-section" class="btn-cta">
                        Explorar Ahora
                        <i class="fas fa-arrow-down"></i>
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="floating-icon icon-1">
                    <i class="fas fa-gem"></i>
                </div>
                <div class="floating-icon icon-2">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="floating-icon icon-3">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="floating-icon icon-4">
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Items Grid -->
    <section class="items-section" id="items-section">
        <div class="section-header">
            <div class="section-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="section-title-group">
                <h2 class="section-title">Todos los Items</h2>
                <p class="section-subtitle">{{ $items->total() }} items disponibles</p>
            </div>
        </div>

        <div class="items-grid">
            @forelse($items as $item)
            <div class="item-card">
                <!-- Imagen -->
                <div class="item-image">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}">

                    <!-- Rareza Badge -->
                    <div class="rarity-badge rarity-{{ strtolower($item->rarity) }}">
                        <i class="fas fa-gem"></i>
                        {{ ucfirst($item->rarity) }}
                    </div>

                    <!-- Tipo Badge -->
                    <div class="type-badge">
                        {{ ucfirst($item->type) }}
                    </div>
                </div>

                <!-- Contenido -->
                <div class="item-content">
                    <h3 class="item-name">{{ $item->name }}</h3>

                    <p class="item-description">{{ Str::limit($item->description, 80) }}</p>

                    <!-- Stock -->
                    <div class="item-stock">
                        @if($item->stock > 0)
                            <span class="stock-available">
                                <i class="fas fa-check-circle"></i>
                                {{ $item->stock }} disponibles
                            </span>
                        @else
                            <span class="stock-unavailable">
                                <i class="fas fa-times-circle"></i>
                                Sin stock
                            </span>
                        @endif
                    </div>

                    <!-- Precio -->
                    <div class="item-price">
                        <span class="price">S/.{{ number_format($item->price, 2) }}</span>
                    </div>

                    <!-- Acciones -->
                    <div class="item-actions">
                        <button class="btn-view-item">
                            <i class="fas fa-eye"></i>
                            Ver Detalles
                        </button>
                        @if($item->stock > 0)
                        <form action="{{ route('cart.add.item', $item->id) }}" method="POST" class="add-item-to-cart-form">
                            @csrf
                            <button type="submit" class="btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Agregar
                            </button>
                        </form>
                        @else
                        <button class="btn-add-cart" disabled>
                            <i class="fas fa-ban"></i>
                            Agotado
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-store-slash"></i>
                </div>
                <h3>No hay items disponibles</h3>
                <p>Pronto tendremos nuevos items para ti</p>
            </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($items->hasPages())
        <div style="margin-top: 2rem;">
            {{ $items->links('vendor.pagination.admin') }}
        </div>
        @endif
    </section>

</div>
@endsection

@push('styles')
<style>
/* Marketplace Hero Banner */
.marketplace-hero {
    margin: 2rem 0 4rem;
    padding: 4rem 3rem;
    background: linear-gradient(135deg, #6b46c1 0%, #553c9a 50%, #4c1d95 100%);
    border-radius: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(107, 70, 193, 0.4);
}

.marketplace-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background:
        radial-gradient(circle at 20% 50%, rgba(139, 92, 246, 0.3) 0%, transparent 50%),
        radial-gradient(circle at 80% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%);
    pointer-events: none;
}

.hero-content-wrapper {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: 3rem;
    align-items: center;
    position: relative;
    z-index: 1;
}

.hero-text {
    max-width: 700px;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    line-height: 1.2;
    color: #fff;
    margin: 0 0 1.5rem;
}

.hero-title .highlight {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
}

.hero-description {
    font-size: 1.15rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 2rem;
}

.hero-cta {
    margin-top: 2rem;
}

.btn-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1.25rem 2.5rem;
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #1f2937;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(251, 191, 36, 0.4);
}

.btn-cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(251, 191, 36, 0.6);
    background: linear-gradient(135deg, #fcd34d, #fbbf24);
}

/* Hero Visual - Floating Icons */
.hero-visual {
    position: relative;
    height: 300px;
}

.floating-icon {
    position: absolute;
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fbbf24;
    animation: float 3s ease-in-out infinite;
    border: 2px solid rgba(251, 191, 36, 0.3);
}

.icon-1 {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.icon-2 {
    top: 10%;
    right: 20%;
    animation-delay: 0.5s;
}

.icon-3 {
    bottom: 30%;
    left: 30%;
    animation-delay: 1s;
}

.icon-4 {
    bottom: 20%;
    right: 10%;
    animation-delay: 1.5s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* Items Section */
.items-section {
    margin-bottom: 4rem;
}

.items-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

/* Item Card */
.item-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.item-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    border-color: rgba(139, 92, 246, 0.5);
}

.item-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1));
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.item-card:hover .item-image img {
    transform: scale(1.1);
}

/* Rarity Badge */
.rarity-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
}

.rarity-legendario {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: #fff;
    box-shadow: 0 4px 15px rgba(251, 191, 36, 0.5);
}

.rarity-epico {
    background: linear-gradient(135deg, #a855f7, #7c3aed);
    color: #fff;
    box-shadow: 0 4px 15px rgba(168, 85, 247, 0.5);
}

.rarity-raro {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.5);
}

.rarity-comun {
    background: linear-gradient(135deg, #64748b, #475569);
    color: #fff;
}

/* Type Badge */
.type-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 0.5rem 1rem;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(10px);
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #fff;
}

/* Item Content */
.item-content {
    padding: 1.5rem;
}

.item-name {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.5rem;
    color: #fff;
}

.item-description {
    font-size: 0.9rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
    line-height: 1.5;
}

.item-stock {
    margin-bottom: 1rem;
}

.stock-available {
    color: var(--accent-green);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stock-unavailable {
    color: var(--accent-red);
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.item-price {
    margin-bottom: 1rem;
}

.item-price .price {
    font-size: 1.75rem;
    font-weight: 900;
    color: #4dffae;
}

/* Item Actions */
.item-actions {
    display: flex;
    gap: 0.5rem;
}

.add-item-to-cart-form {
    flex: 1;
    margin: 0;
}

.btn-view-item,
.btn-add-cart {
    flex: 1;
    width: 100%;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-view-item {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-view-item:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
}

.btn-add-cart {
    background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
    color: white;
}

.btn-add-cart:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(139, 92, 246, 0.5);
}

.btn-add-cart:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: rgba(255, 255, 255, 0.2);
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--text-secondary);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-content-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .hero-description {
        font-size: 1rem;
    }

    .hero-visual {
        height: 200px;
    }

    .floating-icon {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .marketplace-hero {
        padding: 2rem 1.5rem;
    }

    .items-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
