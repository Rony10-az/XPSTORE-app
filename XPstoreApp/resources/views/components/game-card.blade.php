<div class="eneba-card">


    {{-- DESCUENTO --}}
    @if($game->discount > 0)
    <div class="discount-badge">
        -{{ $game->discount }}%
    </div>
    @endif

    {{-- IMAGEN --}}
    <div class="card-image">
        <img src="{{ $game->image }}" alt="{{ $game->title }}">

        {{-- BOTÓN VER DETALLES --}}
        <a href="{{ route('game.show', $game->id) }}" class="details-button">
            <i class="fas fa-eye"></i> Ver Detalles
        </a>

        {{-- RATING --}}
        <div class="rating-badge">
            <i class="fas fa-star"></i> {{ number_format($game->rating, 1) }}
        </div>
    </div>

    <div class="card-content">

        {{-- TÍTULO --}}
        <h3 class="game-title">{{ $game->title }}</h3>

        {{-- DESCRIPCIÓN --}}
        <p class="game-description">
            {{ $game->description ?? 'Sin descripción disponible.' }}
        </p>

        @php
        $genres = is_array($game->genre)
        ? $game->genre
        : explode(',', $game->genre ?? '');
        @endphp

        <div class="game-tags">
            @foreach($genres as $tag)
            <span class="tag">{{ trim($tag) }}</span>
            @endforeach
        </div>

        @php

        $platforms = is_array($game->platform) ? $game->platform : [];
        @endphp


        <div class="platform-tags">
            @foreach($platforms as $platform)
            <span class="platform">{{ $platform }}</span>
            @endforeach
        </div>



        {{-- PRECIO --}}
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

        <div class="bottom-row">
            <form action="{{ route('cart.add', $game->id) }}" method="POST">
                @csrf
                <button type="submit" class="add-cart-btn">
                    <i class="fas fa-shopping-cart"></i> Agregar
                </button>
            </form>
        </div>




    </div>
</div>