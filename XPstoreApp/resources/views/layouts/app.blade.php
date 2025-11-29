<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'XP Store')</title>

    @vite(['resources/css/User/dashboard.css', 'resources/js/dashboard.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <div class="stars-background"></div>

    @include('components.header')


    <div id="toast-container"></div>



    <main class="main-content">
        @yield('content')
    </main>
    @include('components.footer')

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.classList.add('toast');

            toast.innerHTML = `
            <i class="fas fa-check-circle"></i>
            ${message}
        `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3500);
        }
    </script>
    @if(session('success'))
    <script>
        showToast("{{ session('success') }}");
    </script>
    @endif

    @if(session('error'))
    <script>
        showToast("{{ session('error') }}", "error");
    </script>
    @endif

    <script>
        // Manejar agregar al carrito con AJAX (videojuegos e items)
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartForms = document.querySelectorAll('.add-to-cart-form');
            const addItemForms = document.querySelectorAll('.add-item-to-cart-form');

            addToCartForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;
                    const button = this.querySelector('.add-cart-btn');
                    const originalText = button.innerHTML;

                    // Deshabilitar botón y mostrar loading
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Actualizar contador del carrito
                                updateCartCount(data.cartCount);

                                // Mostrar toast de éxito
                                showToast(data.message || 'Producto agregado al carrito');

                                // Restaurar botón
                                button.innerHTML = '<i class="fas fa-check"></i> Agregado';
                                setTimeout(() => {
                                    button.innerHTML = originalText;
                                    button.disabled = false;
                                }, 2000);
                            } else {
                                showToast(data.message || 'Error al agregar al carrito', 'error');
                                button.innerHTML = originalText;
                                button.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Error al agregar al carrito', 'error');
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                });
            });

            // Manejar agregar items al carrito
            addItemForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = this.action;
                    const button = this.querySelector('.btn-add-cart');
                    const originalText = button.innerHTML;

                    // Deshabilitar botón y mostrar loading
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Agregando...';

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Actualizar contador del carrito
                                updateCartCount(data.cartCount);

                                // Mostrar toast de éxito
                                showToast(data.message || 'Item agregado al carrito');

                                // Restaurar botón
                                button.innerHTML = '<i class="fas fa-check"></i> Agregado';
                                setTimeout(() => {
                                    button.innerHTML = originalText;
                                    button.disabled = false;
                                }, 2000);
                            } else {
                                showToast(data.message || 'Error al agregar al carrito', 'error');
                                button.innerHTML = originalText;
                                button.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Error al agregar al carrito', 'error');
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                });
            });
        });

        // Función para actualizar el contador del carrito
        function updateCartCount(count) {
            const cartCountElement = document.getElementById('cartCount');
            const cartIcon = document.getElementById('cartIcon');

            if (count > 0) {
                if (cartCountElement) {
                    cartCountElement.textContent = count;
                } else {
                    // Crear el badge si no existe
                    const badge = document.createElement('span');
                    badge.className = 'cart-count';
                    badge.id = 'cartCount';
                    badge.textContent = count;
                    cartIcon.appendChild(badge);
                }
            } else {
                // Remover el badge si el carrito está vacío
                if (cartCountElement) {
                    cartCountElement.remove();
                }
            }
        }
    </script>

</body>

</html>