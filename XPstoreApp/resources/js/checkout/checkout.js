<script>
    // Botón de PayPal
    if (document.getElementById('paypal-button-container')) {
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay',
                layout: 'horizontal'
            },

            // Monto del pedido
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: "{{ number_format($total, 2, '.', '') }}"
                        }
                    }]
                });
            },

            // Si el usuario paga correctamente
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {

                    // Enviar al backend Laravel (confirmación)
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
                        .then(data => {
                            window.location.href = "/dashboard/user";
                        });
                });
            }

        }).render('#paypal-button-container');
    }
</script>
