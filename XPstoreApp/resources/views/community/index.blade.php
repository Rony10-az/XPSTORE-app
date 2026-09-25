@extends('layouts.app')

@push('styles')
@vite(['resources/css/community/community.css'])
@endpush

@section('content')



{{-- HERO --}}
<div class="community-hero">
    <h1>Comunidad Gamer</h1>
    <p>Comparte tus experiencias, descubre jugadores y forma parte de la comunidad.</p>

    <div class="community-stats">
        <div class="stat">
            <span class="num counter" data-target="1234">0</span>
            <span>Usuarios activos</span>
        </div>

        <div class="stat">
            <span class="num counter" data-target="5678">0</span>
            <span>Reseñas</span>
        </div>

        <div class="stat">
            <span class="num counter" data-target="820">0</span>
            <span>Posts/mes</span>
        </div>
    </div>
</div>


{{-- CONTENIDO PRINCIPAL --}}
<div class="community-layout">

    {{-- COLUMNA IZQUIERDA → FEED --}}
    <div class="community-main">

        {{-- TABS DE FILTROS --}}
        <div class="community-tabs">
            <a href="{{ route('community.index') }}"
                class="tab active">Reseñas de la Comunidad</a>
        </div>

        {{-- RESEÑAS DE JUEGOS --}}
        <div class="feed-container">
            @forelse($gameReviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="review-user-info">
                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}"
                             alt="{{ $review->user->name }}"
                             class="user-avatar">
                        <div>
                            <h4 class="user-name">{{ $review->user->name }}</h4>
                            <p class="review-meta">
                                <span class="game-title">{{ $review->videoGame->title ?? 'Juego no disponible' }}</span>
                                <span class="review-date">• {{ $review->created_at->diffForHumans() }}</span>
                            </p>
                        </div>
                    </div>
                    @if($review->is_verified_purchase)
                    <span class="verified-badge">
                        <i class="fas fa-check-circle"></i> Compra Verificada
                    </span>
                    @endif
                </div>

                <div class="review-rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span class="rating-text">{{ $review->rating }}/5</span>
                </div>

                <div class="review-comment">
                    {{ $review->comment }}
                </div>

                @if($review->videoGame && $review->videoGame->images)
                <div class="review-game-image">
                    <img src="{{ is_array($review->videoGame->images) ? $review->videoGame->images[0] : json_decode($review->videoGame->images)[0] }}"
                         alt="{{ $review->videoGame->title }}"
                         style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-top: 15px;">
                </div>
                @endif
            </div>
            @empty
            <p class="empty-message">No hay reseñas de juegos todavía.</p>
            @endforelse
        </div>

    </div>


    {{-- COLUMNA DERECHA → SIDEBAR --}}
    <aside class="community-sidebar">

        {{-- JUEGOS POPULARES --}}
        <div class="sidebar-card">
            <h3 class="sidebar-title">🎮 Juegos populares</h3>

            <ul class="sidebar-list">
                @foreach ($popularGames as $game)
                <li>
                    <i class="fas fa-fire"></i> {{ $game->title }}
                </li>
                @endforeach
            </ul>

        </div>

        {{-- USUARIOS DESTACADOS --}}
        <div class="sidebar-card">
            <h3 class="sidebar-title">🏆 Jugadores Destacados</h3>

            <div class="user-badges">
                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=12" alt="">
                    <span>JuanXP</span>
                </div>

                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=23" alt="">
                    <span>LeyendaRPG</span>
                </div>

                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=34" alt="">
                    <span>FireNova</span>
                </div>
            </div>
        </div>

    </aside>

</div>

@endsection

@push('scripts')
<script>
// ========================================
// CONTADOR ANIMADO PARA ESTADÍSTICAS
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // Velocidad de la animación (más bajo = más rápido)

    const animateCounter = (counter) => {
        const target = +counter.getAttribute('data-target');
        const increment = target / speed;
        let count = 0;

        const updateCount = () => {
            count += increment;

            if (count < target) {
                // Formatear con comas si es mayor a 999
                counter.textContent = Math.ceil(count).toLocaleString('en-US');
                requestAnimationFrame(updateCount);
            } else {
                counter.textContent = target.toLocaleString('en-US');
            }
        };

        updateCount();
    };

    // Usar Intersection Observer para animar cuando sea visible
    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target); // Solo animar una vez
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        observer.observe(counter);
    });
});
</script>
@endpush