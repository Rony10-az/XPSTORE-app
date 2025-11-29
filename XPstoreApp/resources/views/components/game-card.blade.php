@props([
'game',
])

@php
// Normalizar género a array
$genres = is_array($game->genre)
? $game->genre
: json_decode($game->genre ?? '[]', true);
$genres = $genres ?? [];

// Normalizar plataformas
$platforms = is_array($game->platform)
? $game->platform
: json_decode($game->platform ?? '[]', true);
$platforms = $platforms ?? [];
@endphp

<div class="eneba-card">

    {{-- Imagen --}}
    <div class="card-image">
        <pre>

</pre>

        <img src="{{ $game->image }}" alt="{{ $game->title }}">



        {{-- Descuento --}}
        @if($game->discount > 0)
        <div class="discount-badge">
            -{{ $game->discount }}%
        </div>
        @endif

        {{-- Rating --}}
        <div class="rating-badge">
            <i class="fas fa-star"></i>
            {{ number_format($game->rating, 1) }}
        </div>

        {{-- Botón "Ver Detalles" --}}
        <a href="{{ route('game.show', $game->id) }}"
            class="details-button">
            <i class="fas fa-eye"></i>
            Ver Detalles
        </a>
    </div>

    {{-- Contenido --}}
    <div class="card-content">

        {{-- Título --}}
        <h3 class="game-title">{{ $game->title }}</h3>

        {{-- Descripción --}}
        <p class="game-description">{{ Str::limit($game->description, 90) }}</p>

        {{-- Géneros --}}
        <div class="game-tags">
            @foreach(array_slice($genres, 0, 3) as $tag)
            <span class="tag">{{ $tag }}</span>
            @endforeach
        </div>

        {{-- Plataformas --}}
        <div class="platform-tags">
            @foreach(array_slice($platforms, 0, 2) as $platform)
            <span class="platform">{{ $platform }}</span>
            @endforeach
        </div>

        {{-- Precio --}}
        <div class="game-price">
            @if($game->discount > 0)
            <span class="old-price">${{ number_format($game->price, 2) }}</span>
            <span class="new-price">
                ${{ number_format($game->price * (1 - $game->discount/100), 2) }}
            </span>
            @else
            <span class="new-price">${{ number_format($game->price, 2) }}</span>
            @endif
        </div>

        {{-- Botón agregar --}}
        <form action="{{ route('cart.add', $game->id) }}" method="POST" class="add-to-cart-form">
            @csrf
            <button type="submit" class="add-cart-btn">
                <i class="fas fa-shopping-cart"></i>
                Agregar
            </button>
        </form>


    </div>

</div>