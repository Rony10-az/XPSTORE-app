@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Resumen general de la tienda')

@section('content')
<div class="dashboard-grid">
    <!-- Estadísticas de Ventas -->
    <div class="stats-row">
        <div class="stat-card stat-primary" style="animation-delay: 0s;">
            <div class="stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $salesToday }}</h3>
                <p class="stat-label">Ventas Hoy</p>
            </div>
        </div>

        <div class="stat-card stat-success" style="animation-delay: 0.1s;">
            <div class="stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $salesWeek }}</h3>
                <p class="stat-label">Ventas esta Semana</p>
            </div>
        </div>

        <div class="stat-card stat-info" style="animation-delay: 0.2s;">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $salesMonth }}</h3>
                <p class="stat-label">Ventas este Mes</p>
            </div>
        </div>

        <div class="stat-card stat-warning" style="animation-delay: 0.3s;">
            <div class="stat-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-value">{{ $totalCodesSold }}</h3>
                <p class="stat-label">Códigos Vendidos</p>
            </div>
        </div>
    </div>

    <!-- Productos más vendidos y Stock bajo -->
    <div class="content-row">
        <!-- Productos más vendidos -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-fire"></i>
                    Productos más vendidos
                </h2>
            </div>
            <div class="card-body">
                @if($topProducts->count() > 0)
                    <div class="products-list">
                        @foreach($topProducts as $product)
                        <div class="product-item">
                            <div class="product-info">
                                <div class="product-name">{{ $product->title }}</div>
                                <div class="product-platform">
                                    {{ is_array($product->platform) ? implode(', ', $product->platform) : $product->platform }}
                                </div>
                            </div>
                            <div class="product-stats">
                                <span class="sales-badge">{{ $product->sales_count }} ventas</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <p>No hay ventas registradas aún</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stock bajo -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Stock Bajo
                </h2>
            </div>
            <div class="card-body">
                @if($lowStock->count() > 0)
                    <div class="stock-list">
                        @foreach($lowStock as $item)
                        <div class="stock-item">
                            <div class="stock-info">
                                <div class="stock-name">{{ $item->title }}</div>
                                <div class="stock-platform">
                                    {{ is_array($item->platform) ? implode(', ', $item->platform) : $item->platform }}
                                </div>
                            </div>
                            <div class="stock-badge {{ $item->stock <= 3 ? 'critical' : 'warning' }}">
                                {{ $item->stock }} unidades
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>Todo el stock está en buen nivel</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Usuarios nuevos y Reseñas pendientes -->
    <div class="content-row">
        <!-- Usuarios nuevos -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-plus"></i>
                    Usuarios Nuevos (últimos 7 días)
                </h2>
            </div>
            <div class="card-body">
                @if($newUsers->count() > 0)
                    <div class="users-list">
                        @foreach($newUsers as $user)
                        <div class="user-item">
                            <div class="user-avatar">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="user-info">
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                            <div class="user-date">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <p>No hay usuarios nuevos en los últimos 7 días</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reseñas pendientes -->
        <div class="dashboard-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-clock"></i>
                    Reseñas Pendientes de Moderación
                </h2>
                @if($pendingReviews->count() > 0)
                    <a href="{{ route('admin.reviews.index') }}" class="view-all-link">Ver todas</a>
                @endif
            </div>
            <div class="card-body">
                @if($pendingReviews->count() > 0)
                    <div class="reviews-list">
                        @foreach($pendingReviews as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-user">
                                    <strong>{{ $review->user->name }}</strong>
                                    <span class="review-game">{{ $review->videoGame->title }}</span>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="review-content">
                                <strong>{{ $review->title }}</strong>
                                <p>{{ Str::limit($review->content, 100) }}</p>
                            </div>
                            <div class="review-date">
                                {{ $review->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <p>No hay reseñas pendientes de moderación</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-grid {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Estadísticas */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    position: relative;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 1rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 20px 40px -12px rgba(147, 51, 234, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
    animation: fadeIn 0.6s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--primary-color));
    background-size: 200% 100%;
    animation: gradientShift 3s ease infinite;
    z-index: 1;
}

@keyframes gradientShift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 25px 50px -15px rgba(147, 51, 234, 0.35),
                0 0 0 1px rgba(168, 85, 247, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.1);
}

.stat-card.stat-primary {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --primary-rgb: 102, 126, 234;
    --secondary-rgb: 118, 75, 162;
}

.stat-card.stat-success {
    --primary-color: #56ab2f;
    --secondary-color: #a8e063;
    --primary-rgb: 86, 171, 47;
    --secondary-rgb: 168, 224, 99;
}

.stat-card.stat-info {
    --primary-color: #3494e6;
    --secondary-color: #ec6ead;
    --primary-rgb: 52, 148, 230;
    --secondary-rgb: 236, 110, 173;
}

.stat-card.stat-warning {
    --primary-color: #f093fb;
    --secondary-color: #f5576c;
    --primary-rgb: 240, 147, 251;
    --secondary-rgb: 245, 87, 108;
}

.stat-icon {
    position: relative;
    z-index: 2;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    width: 60px;
    height: 60px;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 6px 15px rgba(var(--primary-rgb), 0.4),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    transform: scale(1.05) rotate(5deg);
    box-shadow: 0 8px 20px rgba(var(--primary-rgb), 0.5);
}

.stat-content {
    position: relative;
    z-index: 2;
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #ffffff;
    letter-spacing: -0.02em;
    line-height: 1;
}

.stat-label {
    font-size: 0.875rem;
    margin: 0.4rem 0 0;
    color: #9ca3af;
    font-weight: 500;
    letter-spacing: 0.02em;
}

/* Contenido */
.content-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.dashboard-card {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #f1f5f9;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-title i {
    color: #8b5cf6;
}

.view-all-link {
    color: #a78bfa;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s;
}

.view-all-link:hover {
    color: #c4b5fd;
}

.card-body {
    padding: 1.5rem;
    max-height: 400px;
    overflow-y: auto;
}

.card-body::-webkit-scrollbar {
    width: 6px;
}

.card-body::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb {
    background: rgba(139, 92, 246, 0.5);
    border-radius: 3px;
}

.card-body::-webkit-scrollbar-thumb:hover {
    background: rgba(139, 92, 246, 0.7);
}

/* Productos */
.products-list,
.stock-list,
.users-list,
.reviews-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.product-item,
.stock-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    transition: all 0.3s;
}

.product-item:hover,
.stock-item:hover {
    background: rgba(139, 92, 246, 0.1);
    border-color: rgba(139, 92, 246, 0.3);
}

.product-info,
.stock-info {
    flex: 1;
}

.product-name,
.stock-name {
    font-weight: 600;
    color: #e2e8f0;
    margin-bottom: 0.25rem;
}

.product-platform,
.stock-platform {
    font-size: 0.85rem;
    color: #94a3b8;
}

.sales-badge {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.stock-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.stock-badge.warning {
    background: #fef3c7;
    color: #d97706;
}

.stock-badge.critical {
    background: #fee2e2;
    color: #dc2626;
}

/* Usuarios */
.user-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    transition: all 0.3s;
}

.user-item:hover {
    background: rgba(139, 92, 246, 0.1);
    border-color: rgba(139, 92, 246, 0.3);
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-info {
    flex: 1;
}

.user-name {
    font-weight: 600;
    color: #e2e8f0;
    margin-bottom: 0.25rem;
}

.user-email {
    font-size: 0.85rem;
    color: #94a3b8;
}

.user-date {
    font-size: 0.85rem;
    color: #cbd5e1;
}

/* Reseñas */
.review-item {
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.05);
    border-radius: 8px;
    transition: all 0.3s;
    border-left: 4px solid #8b5cf6;
}

.review-item:hover {
    background: rgba(139, 92, 246, 0.1);
    border-color: rgba(139, 92, 246, 0.3);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.review-user {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.review-user strong {
    color: #e2e8f0;
}

.review-game {
    font-size: 0.85rem;
    color: #94a3b8;
}

.review-rating {
    display: flex;
    gap: 0.25rem;
}

.review-rating i {
    color: #d1d5db;
    font-size: 0.9rem;
}

.review-rating i.filled {
    color: #fbbf24;
}

.review-content {
    margin-bottom: 0.5rem;
}

.review-content strong {
    color: #e2e8f0;
    display: block;
    margin-bottom: 0.5rem;
}

.review-content p {
    color: #cbd5e1;
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.5;
}

.review-date {
    font-size: 0.8rem;
    color: #94a3b8;
    text-align: right;
}

/* Estado vacío */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #64748b;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.3;
    color: #475569;
}

.empty-state p {
    margin: 0;
    font-size: 0.95rem;
    color: #94a3b8;
}
</style>
@endsection
