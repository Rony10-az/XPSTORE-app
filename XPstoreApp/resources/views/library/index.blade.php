@extends('layouts.app')

@section('title', 'Mis Juegos')

@push('styles')
@vite(['resources/css/library/library.css', 'resources/js/library/library.js'])
@endpush

@section('content')
<div class="page-wrapper">

    <div class="library-header">
        <h1 class="title">
            <i class="fas fa-book"></i> Mi Biblioteca
            <span class="badge-count">{{ count($libraryItems) }}</span>
        </h1>
        <p class="subtitle">Todos tus juegos, ítems y códigos en un solo lugar</p>
    </div>

    @php
        $videoGameCount = $libraryItems->filter(fn($p) => $p->videoGame !== null)->count();
        $marketCount = $libraryItems->filter(fn($p) => $p->marketItem !== null)->count();
        $streamingCount = $libraryItems->filter(fn($p) => $p->streamingCode !== null)->count();
        $reviewedCount = $libraryItems->filter(fn($p) => $p->video_game_id && in_array($p->video_game_id, $reviewedGameIds))->count();
    @endphp

    <div class="library-filters">
        <button class="filter-btn active" data-filter="all">
            <i class="fas fa-th"></i> Todos <span class="count">{{ count($libraryItems) }}</span>
        </button>
        <button class="filter-btn" data-filter="Videojuego">
            <i class="fas fa-gamepad"></i> Videojuegos <span class="count">{{ $videoGameCount }}</span>
        </button>
        <button class="filter-btn" data-filter="Marketplace">
            <i class="fas fa-shopping-bag"></i> Marketplace <span class="count">{{ $marketCount }}</span>
        </button>
        <button class="filter-btn" data-filter="Streaming">
            <i class="fas fa-tv"></i> Streaming <span class="count">{{ $streamingCount }}</span>
        </button>
        <button class="filter-btn" data-filter="Comentado">
            <i class="fas fa-comment"></i> Comentados <span class="count">{{ $reviewedCount }}</span>
        </button>
    </div>

    <div class="library-search">
        <input type="text" placeholder="Buscar en mi biblioteca..." id="searchLibrary">
    </div>

    <div class="library-grid">

        @foreach ($libraryItems as $purchase)

        @php
        // Determinar el modelo asociado
        $item = $purchase->videoGame
        ?? $purchase->marketItem
        ?? $purchase->streamingCode;

        // Si no hay item, saltar
        if (!$item) continue;

        // Determinar tipo
        if ($purchase->videoGame) {
            $type = 'Videojuego';
        } elseif ($purchase->marketItem) {
            $type = 'Marketplace';
        } elseif ($purchase->streamingCode) {
            $type = 'Streaming';
        } else {
            $type = 'Desconocido';
        }

        // Resolver imagen
        if ($purchase->videoGame) {
            $image = $item->main_image ?? 'https://via.placeholder.com/400x400?text=Sin+Imagen';
        } elseif ($purchase->marketItem) {
            $image = $item->image ?? 'https://via.placeholder.com/400x400?text=Marketplace';
        } elseif ($purchase->streamingCode) {
            $image = $item->image ?? 'https://via.placeholder.com/400x400?text=Streaming';
        } else {
            $image = 'https://via.placeholder.com/400x400?text=Sin+Imagen';
        }

        // Título del ítem (varía según tipo)
        if ($purchase->videoGame) {
            $title = $item->title ?? 'Sin título';
        } elseif ($purchase->marketItem) {
            $title = $item->title ?? 'Ítem sin nombre';
        } elseif ($purchase->streamingCode) {
            $title = ($item->service ?? 'Servicio') . ' - ' . ($item->duration ?? 'Duración desconocida');
        } else {
            $title = 'Sin título';
        }

        // Verificar si el juego ha sido comentado
        $hasReview = $purchase->video_game_id && in_array($purchase->video_game_id, $reviewedGameIds);
        @endphp

        <div class="library-card" data-type="{{ $type }}" data-title="{{ strtolower($title) }}" data-reviewed="{{ $hasReview ? 'true' : 'false' }}">

            {{-- Imagen --}}
            <div class="library-image">
                <img src="{{ $image }}" alt="{{ $title }}">
                <span class="badge-active">{{ $type }}</span>
                @if($hasReview)
                    <span class="badge-reviewed" title="Has comentado este juego">
                        <i class="fas fa-comment"></i>
                    </span>
                @endif
            </div>

            {{-- Contenido --}}
            <div class="library-content">

                {{-- Título --}}
                <h2 class="game-title">{{ $title }}</h2>

                {{-- Fecha --}}
                <p class="date">
                    <i class="far fa-calendar-alt"></i>
                    Comprado el {{ $purchase->created_at->format('d \d\e F \d\e\l Y') }}
                </p>

                {{-- Tags (solo videojuegos) --}}
                @if($purchase->videoGame && is_array($item->genre))
                <div class="tags">
                    @foreach($item->genre as $tag)
                    <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Códigos de activación --}}
                @if(isset($purchase->activation_codes) && count($purchase->activation_codes) > 0)
                <div class="code-box">
                    <label>
                        Código{{ count($purchase->activation_codes) > 1 ? 's' : '' }} de activación
                        @if(count($purchase->activation_codes) > 1)
                            <span class="code-count-badge">{{ count($purchase->activation_codes) }} copias</span>
                        @endif
                    </label>

                    @foreach($purchase->activation_codes as $index => $code)
                    <div class="code-row">
                        @if(count($purchase->activation_codes) > 1)
                            <span class="code-number">#{{ $index + 1 }}</span>
                        @endif
                        <input type="text" value="{{ $code }}" readonly class="code-input">
                        <button class="copy-btn" data-code="{{ $code }}">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Plataformas (solo videojuegos) --}}
                @if($purchase->videoGame && is_array($item->platforms))
                <div class="platforms">
                    <label>Disponible en:</label>
                    <div class="platform-list">
                        @foreach($item->platforms as $p)
                        <span class="platform">{{ $p }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($purchase->videoGame)
                <a href="{{ route('library.game.review', $purchase->videoGame->id) }}" class="details-btn">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
                @elseif($purchase->marketItem)
                <a href="{{ route('marketplace.show', $purchase->marketItem->id) }}" class="details-btn">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
                @elseif($purchase->streamingCode)
                <a href="{{ route('streaming.show', $purchase->streamingCode->id) }}" class="details-btn">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
                @else
                <a href="#" class="details-btn disabled">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
                @endif
            </div>

        </div>

        @endforeach

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== FILTROS POR TIPO ==========
    const filterButtons = document.querySelectorAll('.filter-btn');
    const libraryCards = document.querySelectorAll('.library-card');
    const searchInput = document.getElementById('searchLibrary');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover active de todos los botones
            filterButtons.forEach(b => b.classList.remove('active'));

            // Agregar active al botón clickeado
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            libraryCards.forEach(card => {
                const cardType = card.getAttribute('data-type');
                const hasReview = card.getAttribute('data-reviewed') === 'true';

                if (filter === 'all') {
                    card.style.display = '';
                } else if (filter === 'Comentado') {
                    // Mostrar solo los juegos que tienen reseña
                    card.style.display = hasReview ? '' : 'none';
                } else if (cardType === filter) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });

            // Aplicar búsqueda después del filtro
            if (searchInput.value.trim() !== '') {
                searchLibrary();
            }
        });
    });

    // ========== BÚSQUEDA ==========
    searchInput.addEventListener('input', searchLibrary);

    function searchLibrary() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const activeFilter = document.querySelector('.filter-btn.active').getAttribute('data-filter');

        libraryCards.forEach(card => {
            const title = card.getAttribute('data-title');
            const cardType = card.getAttribute('data-type');
            const hasReview = card.getAttribute('data-reviewed') === 'true';

            const matchesSearch = title.includes(searchTerm);
            let matchesFilter = false;

            if (activeFilter === 'all') {
                matchesFilter = true;
            } else if (activeFilter === 'Comentado') {
                matchesFilter = hasReview;
            } else {
                matchesFilter = cardType === activeFilter;
            }

            if (matchesSearch && matchesFilter) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // ========== COPIAR CÓDIGO ==========
    const copyButtons = document.querySelectorAll('.copy-btn');

    copyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const code = this.getAttribute('data-code');

            // Copiar al portapapeles
            navigator.clipboard.writeText(code).then(() => {
                const icon = this.querySelector('i');
                const originalClass = icon.className;

                // Cambiar ícono a check
                icon.className = 'fas fa-check';
                this.style.background = '#10b981';

                // Restaurar después de 2 segundos
                setTimeout(() => {
                    icon.className = originalClass;
                    this.style.background = '';
                }, 2000);
            }).catch(err => {
                console.error('Error al copiar:', err);
            });
        });
    });
});
</script>
@endpush