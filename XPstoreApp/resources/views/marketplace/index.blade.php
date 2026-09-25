@extends('layouts.app')

@section('title', 'Marketplace')

@push('styles')
@vite(['resources/css/marketplace/index.css'])
@endpush

@push('scripts')
@vite(['resources/js/wishlist/toggle.js'])
@endpush


@section('content')

<div class="container">

    <h1 class="page-title">Marketplace</h1>
    <p class="page-subtitle">Compra skins, armas, ítems y contenido exclusivo.</p>

    <div class="market-grid">

        @foreach ($items as $item)

        <div class="market-card">

            {{-- LINK AL DETALLE --}}
            <a href="{{ route('marketplace.show', $item) }}" class="market-link">

                {{-- IMAGEN --}}
                <img src="{{ $item->image }}" alt="{{ $item->title }}">

                {{-- TÍTULO --}}
                <p class="market-title">{{ $item->title }}</p>

                {{-- RAREZA + TIPO --}}
                <p class="market-meta">
                    {{ ucfirst($item->rarity) }} • {{ ucfirst($item->type) }}
                </p>

                {{-- PRECIO --}}
                <p class="market-price">
                    S/.{{ number_format($item->price, 2) }}
                </p>
            </a>

            <button class="wishlist-btn"
                data-id="{{ $item->id }}"
                data-type="{{ App\Models\MarketItem::class }}">
                <i class="fas fa-heart"></i>
            </button>



            {{-- BOTÓN AGREGAR --}}
            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="market_item">
                <button class="btn-add-market">Agregar</button>
            </form>

        </div>

        @endforeach

    </div>

</div>

@endsection