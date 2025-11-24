@extends('layouts.app')

@section('title', 'Finalizar Compra')

@push('styles')
@vite(['resources/css/checkout/checkout.css'])
@endpush

@section('content')

<div class="checkout-top">
    <a href="{{ route('cart.index') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Volver al carrito
    </a>

    <h1 class="checkout-title">
        <i class="fas fa-credit-card"></i> Finalizar Compra
    </h1>
</div>

<form action="{{ route('checkout.confirm') }}" method="POST">
    @csrf

    <div class="checkout-layout">

        {{-- ===========================
            COLUMNA IZQUIERDA
        ============================ --}}
        <div class="checkout-left">

            {{-- MÉTODOS DE PAGO --}}
            <div class="payment-methods">
                <h3>Método de pago</h3>
                <p class="subtitle">Selecciona cómo deseas pagar</p>

                <label class="payment-option">
                    <input type="radio" name="payment_method" value="credit_card" checked>
                    <i class="fas fa-credit-card"></i>
                    <span>Tarjeta de crédito/débito</span>
                </label>

                <label class="payment-option">
                    <input type="radio" name="payment_method" value="paypal">
                    <i class="fab fa-paypal"></i>
                    <span>PayPal</span>
                </label>

                <label class="payment-option">
                    <input type="radio" name="payment_method" value="bank_transfer">
                    <i class="fas fa-university"></i>
                    <span>Transferencia bancaria</span>
                </label>
            </div>

            {{-- FORM TARJETA --}}
            <div id="credit_card-form" class="payment-form">
                <h4>Datos de la tarjeta</h4>
                <input type="text" name="card_number" placeholder="Número de tarjeta" required>

                <div style="display:flex; gap:15px;">
                    <input type="text" name="expiry_date" placeholder="MM/AA" required>
                    <input type="text" name="cvv" placeholder="CVV" required>
                </div>

                <input type="text" name="cardholder_name" placeholder="Nombre en la tarjeta" required>
            </div>

            {{-- FORM PAYPAL --}}
            <div id="paypal-form" class="payment-form" style="display:none;">
                <h4>Pagar con PayPal</h4>
                <p>Serás redirigido a PayPal para completar tu pago.</p>

                <div id="paypal-button-container"></div>
            </div>

            {{-- FORM TRANSFERENCIA --}}
            <div id="bank_transfer-form" class="payment-form" style="display:none;">
                <h4>Transferencia Bancaria</h4>
                <p>Número de Cuenta: 123-456-789</p>
                <p>CCI: 001234567890123456</p>
                <p>Banco XP Store</p>
            </div>

            {{-- BOTÓN FINAL --}}
            <button type="submit" class="pay-button">
                <i class="fas fa-lock"></i> Confirmar Pago
            </button>

        </div>

        {{-- ===========================
            COLUMNA DERECHA
        ============================ --}}
        <div class="checkout-right">

            {{-- PRODUCTOS --}}
            <div class="checkout-items">
                <h2 class="section-title">Tus Productos</h2>

                @foreach($cart as $item)
                <div class="checkout-item">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                    <div class="item-info">
                        <h3>{{ $item['title'] }}</h3>
                        <p>Cantidad: <strong>{{ $item['quantity'] }}</strong></p>
                        <p class="price">S/. {{ number_format($item['final_price'], 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- RESUMEN --}}
            <div class="checkout-summary">
                <h2 class="section-title">Resumen de Pago</h2>

                <div class="row">
                    <span>Subtotal</span>
                    <span>S/. {{ number_format($subtotal, 2) }}</span>
                </div>

                <div class="row discount-row">
                    <span>Descuentos</span>
                    <span>- S/. {{ number_format($discount_total, 2) }}</span>
                </div>

                <div class="total-row">
                    <strong>Total</strong>
                    <strong>S/. {{ number_format($total, 2) }}</strong>
                </div>
            </div>

        </div>

    </div>
</form>

{{-- ===========================
     JAVASCRIPT
=========================== --}}
<script>
    document.querySelectorAll('input[name="payment_method"]').forEach((elem) => {
        elem.addEventListener("change", function() {

            document.querySelectorAll(".payment-form").forEach(f => f.style.display = "none");

            const target = document.getElementById(`${this.value}-form`);
            if (target) target.style.display = "block";

            // Si se selecciona PayPal → renderiza el botón
            if (this.value === "paypal") {
                document.querySelector(".pay-button").style.display = "none";
                loadPayPalButton();
            } else {
                document.querySelector(".pay-button").style.display = "block";
            }

        });
    });

    document.getElementById("credit_card-form").style.display = "block";
</script>


{{-- SDK PAYPAL --}}
<script src="https://www.paypal.com/sdk/js?client-id=AYN_0PTYKWrmNbdDgJccslNOkRW0Nj3dYKpcIe6zFzhpGIjZUP-MehfJHLERsVWA2-tGWIWYggw-CE9t&currency=USD"></script>

<script>
    function loadPayPalButton() {

        document.getElementById("paypal-button-container").innerHTML = "";

        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },

            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{ number_format($total / 3.8, 2, '.', '') }}"
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {

                    fetch("{{ route('checkout.confirm') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                paypal_order_id: data.orderID,
                                payer: details.payer
                            })
                        })
                        .then(res => res.json())
                        .then(() => {
                            window.location.href = "{{ route('checkout.success') }}";

                        });
                });
            }

        }).render("#paypal-button-container");
    }
</script>


@endsection