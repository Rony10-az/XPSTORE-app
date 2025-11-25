@extends('layouts.app')

@section('title', 'Dashboard - XP Store')

@section('content')
<div class="container">
    <!-- Botón de filtros vertical -->
    <button class="filters-btn-vertical" id="filtersToggle">
        <i class="fas fa-sliders-h"></i>
        <span class="filters-text">FILTROS</span>
    </button>


    <!-- Hero Section -->

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
                <span class="price">$249.99</span>
            </div>

            <div class="hero-actions">
                <button class="btn-primary">Ver Detalles</button>
                <button class="btn-secondary">Agregar al Carrito</button>
            </div>
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

    <!-- BOTÓN FLOTANTE -->
    <div class="community-float-btn" id="openCommunity">
        <i class="fas fa-comment-alt"></i>
        <span class="status-dot"></span>
    </div>

    <!-- PANEL DE COMUNIDAD (INICIALMENTE OCULTO) -->
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

@endpush