@extends('layouts.app')

@section('title', $item->title)

@push('styles')
<style>
    /* CONTENEDOR GENERAL */
    .item-container {
        display: flex;
        gap: 40px;
        margin-top: 40px;
        color: white;
        flex-wrap: wrap;
        align-items: flex-start;
    }

    /* IMAGEN */
    .item-image-box img {
        width: 380px;
        height: 380px;
        object-fit: cover;
        border-radius: 12px;
        background: #0f172a;
        border: 2px solid #334155;
    }

    /* INFORMACIÓN */
    .item-info {
        max-width: 520px;
        flex: 1;
    }

    .item-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 4px;
        color: #e2e8f0;
    }

    .item-meta {
        font-size: 14px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 14px;
    }

    .item-price {
        font-size: 26px;
        font-weight: 800;
        margin: 15px 0 18px;
        color: #22c55e;
    }

    .item-description {
        color: #cbd5e1;
        line-height: 1.5;
    }

    /* ATRIBUTOS */
    .item-attributes {
        margin-top: 24px;
        padding: 18px;
        background: #1e293b;
        border-radius: 12px;
        border: 1px solid #334155;
    }

    .item-attributes h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .item-attributes p {
        margin: 4px 0;
        color: #e2e8f0;
    }

    /* BOTÓN COMPRAR */
    .buy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 28px;
        margin-top: 24px;
        background: #3b82f6;
        color: white;
        font-size: 17px;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        transition: background 0.15s ease;
        will-change: background;
    }

    .buy-btn:hover {
        background: #2563eb;
    }
</style>
@endpush

@section('content')

<div class="container item-container">

    <!-- Imagen -->
    <div class="item-image-box">
        <img src="{{ $image }}" alt="item">
    </div>

    <!-- Información -->
    <div class="item-info">

        <h1 class="item-title">{{ $item->title }}</h1>

        <p class="item-meta">
            Rareza: <strong>{{ ucfirst($item->rarity) }}</strong> •
            Tipo: <strong>{{ ucfirst($item->type) }}</strong>
        </p>

        <p class="item-price">
            ${{ number_format($item->price, 2) }}
        </p>

        <p class="item-description">{{ $item->description }}</p>

        <!-- Atributos -->
        @if(!empty($attributes) && is_array($attributes))
        <div class="item-attributes">
            <h3>Atributos</h3>
            @foreach($attributes as $key => $value)
            <p>
                <strong>{{ ucfirst($key) }}:</strong>
                {{ is_array($value) ? implode(', ', $value) : $value }}
            </p>
            @endforeach
        </div>
        @endif


        <!-- Botón Comprar -->
        <a href="{{ route('cart.add', ['id' => $item->id]) }}" class="buy-btn">
            Comprar
        </a>

    </div>

</div>

@endsection