@extends('layouts.app')

@section('title', 'Carrito de Compras')

@vite(['resources/css/cart/cart.css', 'resources/js/cart/cart.js'])

@section('content')

<div class="cart-page">

    <!-- HEADER DEL CARRITO -->
    <div class="cart-header">
        <div class="left">
            <h1 class="title">
                <i class="fas fa-shopping-basket"></i>
                Carrito de Compras
            </h1>
            <p class="description">Revisa tus productos antes de finalizar la compra</p>
        </div>
        <div class="badge-products">
            {{ collect($cart)->sum('quantity') }}
            producto{{ collect($cart)->sum('quantity') > 1 ? 's' : '' }}
        </div>


    </div>
    <div class="cart-content {{ count($cart) == 0 ? 'empty' : '' }}">


        <!-- CONDICIONAL PARA CARRITO VACÍO -->
        @if(count($cart) == 0)

        <div class="empty-cart">
            <div class="empty-message-box">
                <h2 class="empty-title">
                    <i class="fas fa-shopping-cart"></i> Tu carrito está vacío
                </h2>

                <p class="empty-sub">Agrega juegos a tu carrito para ver el resumen del pedido</p>

                <a href="{{ route('dashboard.user') }}" class="pay-btn">
                    <i class="fas fa-store"></i> Ir a la tienda
                </a>
            </div>
        </div>

        @else
        <!-- LISTA DE PRODUCTOS -->
        <div class="cart-items">

            @foreach($cart as $id => $item)
            <div class="cart-card">

                {{-- IMAGEN --}}
                <div class="image-box">
                    <img src="{{ $item['image'] ?? asset('images/default-game.jpg') }}"
                        alt="{{ $item['title'] }}">

                    @if($item['discount'] > 0)
                    <span class="discount-tag">-{{ $item['discount'] }}%</span>
                    @endif
                </div>

                <!-- INFORMACIÓN -->
                <div class="info-box">

                    <!-- CATEGORÍA -->
                    <span class="category-tag">Videojuego</span>

                    <!-- TÍTULO -->
                    <h3 class="game-title">{{ $item['title'] }}</h3>

                    <!-- TAGS DINÁMICAS (GÉNERO + PLATAFORMA) -->
                    <div class="tag-list">

                        <!-- GÉNEROS -->
                        @if(isset($item['genre']) && is_array($item['genre']) && count($item['genre']) > 0)
                        @foreach($item['genre'] as $g)
                        <span class="tag">{{ $g }}</span>
                        @endforeach
                        @else
                        <span class="tag">Sin género</span>
                        @endif

                        <!-- PLATAFORMAS -->
                        @if(isset($item['platform']) && is_array($item['platform'] ) && count($item['platform']) > 0)
                        @foreach($item['platform'] as $pf)
                        <span class="tag platform-tag">{{ $pf }}</span>
                        @endforeach
                        @endif

                    </div>

                    <!-- PRECIO -->
                    <div class="price-box">
                        @if($item['discount'] > 0)
                        <span class="old-price">${{ number_format($item['price'], 2) }}</span>
                        @endif

                        <span class="new-price">${{ number_format($item['final_price'], 2) }}</span>
                    </div>

                    <!-- ELIMINAR -->
                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="delete-form">
                        @csrf
                        <button type="submit" class="delete-btn">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>

                </div>

            </div>
            @endforeach

        </div>



        <!-- RESUMEN SOLO SI HAY PRODUCTOS -->
        <div class="summary-box">

            <h2 class="summary-title">
                <i class="fas fa-receipt"></i> Resumen del pedido
            </h2>

            <p class="summary-sub">Detalles de tu compra</p>

            <div class="summary-row">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="summary-row discount">
                <span><i class="fas fa-tags"></i> Descuentos</span>
                <span>- ${{ number_format($discount_total, 2) }}</span>
            </div>

            <div class="summary-total">
                Total <strong>${{ number_format($total, 2) }}</strong>
            </div>

            @if($discount_total > 0)
            <div class="summary-save">
                <i class="fas fa-badge-check"></i>
                ¡Ahorras ${{ number_format($discount_total, 2) }} en esta compra!
            </div>
            @endif

            <a href="{{ route('checkout.index') }}" class="pay-btn">
                <i class="fas fa-credit-card"></i> Proceder al pago
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

        @endif

    </div>

    @endsection