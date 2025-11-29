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


    <div class="cart-content">

        <!-- LISTA DE PRODUCTOS -->
        <div class="cart-items">

            <!-- VIDEOJUEGOS -->
            @if(!empty($cart))
            <div class="cart-section-header">
                <i class="fas fa-gamepad"></i>
                <h2>Videojuegos</h2>
            </div>
            @endif

            @foreach($cart as $id => $item)

            <div class="cart-card">

                <div class="image-box">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">

                    @if($item['discount'] > 0)
                    <span class="discount-tag">-{{ $item['discount'] }}%</span>
                    @endif
                </div>

                <div class="info-box">
                    <span class="category-tag">Videojuego</span>

                    <h3 class="game-title">{{ $item['title'] }}</h3>

                    <div class="tag-list">
                        <span class="tag">RPG</span>
                        <span class="tag">Acción</span>
                        <span class="tag">PC</span>
                    </div>

                    <!-- Cantidad -->
                    <div class="quantity-section">
                        <span class="quantity-label">Cantidad:</span>
                        <div class="quantity-controls">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" class="qty-btn" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                            <span class="quantity-value">{{ $item['quantity'] }}</span>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" class="qty-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="price-box">

                        @if($item['discount'] > 0)
                        <span class="old-price">S/.{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        @endif

                        <span class="new-price">S/.{{ number_format($item['final_price'] * $item['quantity'], 2) }}</span>
                        @if($item['quantity'] > 1)
                        <span class="unit-price">S/.{{ number_format($item['final_price'], 2) }} c/u</span>
                        @endif
                    </div>

                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="delete-form">
                        @csrf
                        <button type="submit" class="delete-btn">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>

                </div>

            </div>

            @endforeach

            <!-- ITEMS DEL MARKETPLACE -->
            @if(!empty($cartItems))
            <div class="cart-section-header" style="margin-top: 2rem;">
                <i class="fas fa-shopping-bag"></i>
                <h2>Items del Marketplace</h2>
            </div>
            @endif

            @foreach($cartItems as $id => $item)

            <div class="cart-card">

                <div class="image-box">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">

                    <span class="rarity-tag rarity-{{ strtolower($item['rarity']) }}">
                        {{ ucfirst($item['rarity']) }}
                    </span>
                </div>

                <div class="info-box">
                    <span class="category-tag category-item">{{ ucfirst($item['type']) }}</span>

                    <h3 class="game-title">{{ $item['name'] }}</h3>

                    <!-- Cantidad -->
                    <div class="quantity-section">
                        <span class="quantity-label">Cantidad:</span>
                        <div class="quantity-controls">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="decrease">
                                <input type="hidden" name="type" value="item">
                                <button type="submit" class="qty-btn" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                            <span class="quantity-value">{{ $item['quantity'] }}</span>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="quantity-form" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="increase">
                                <input type="hidden" name="type" value="item">
                                <button type="submit" class="qty-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="price-box">
                        <span class="new-price">S/.{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        @if($item['quantity'] > 1)
                        <span class="unit-price">S/.{{ number_format($item['price'], 2) }} c/u</span>
                        @endif
                    </div>

                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="delete-form">
                        @csrf
                        <input type="hidden" name="type" value="item">
                        <button type="submit" class="delete-btn">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>

                </div>

            </div>

            @endforeach

        </div>

        <!-- RESUMEN DEL PEDIDO -->
        <div class="summary-box">

            <h2 class="summary-title">
                <i class="fas fa-receipt"></i>
                Resumen del pedido
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
                Total
                <strong>${{ number_format($total, 2) }}</strong>
            </div>

            <div class="summary-save">
                <i class="fas fa-badge-check"></i>
                ¡Ahorras S/.{{ number_format($discount_total, 2) }} en esta compra!
            </div>

            <a href="#" class="pay-btn">
                <i class="fas fa-credit-card"></i>
                Proceder al pago
                <i class="fas fa-arrow-right"></i>
            </a>

        </div>

    </div>

</div>

@endsection