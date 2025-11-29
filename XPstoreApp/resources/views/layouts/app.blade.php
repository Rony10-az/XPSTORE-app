<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'XP Store')</title>
    <script>
        window.showToast = function(message, type = 'success') {

            let container = document.getElementById('toast-container');

            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.style.cssText = `
            position: fixed;
            top: 25px;
            right: 25px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
        `;
                document.body.appendChild(container);
            }


            const colors = {
                success: 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
                error: 'linear-gradient(135deg, #ef4444, #dc2626)',
                info: 'linear-gradient(135deg, #3b82f6, #1d4ed8)',
                warning: 'linear-gradient(135deg, #f59e0b, #d97706)'
            };

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
        <span style="font-weight: 700;">${message}</span>
    `;

            // Estilos nuevos
            toast.style.cssText = `
        background: ${colors[type]};
        padding: 14px 20px;
        color: white;
        border-radius: 14px;
        font-size: 0.95rem;
        font-weight: 600;
        box-shadow: 0 0 25px rgba(139, 92, 246, 0.7);
        backdrop-filter: blur(12px);
        border: 2px solid rgba(255,255,255,0.15);

        animation: toastSlideIn 0.45s cubic-bezier(.25,.8,.25,1) forwards;

        max-width: 280px;
        letter-spacing: 0.3px;
    `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = "toastSlideOut 0.4s ease forwards";
                setTimeout(() => toast.remove(), 350);
            }, 3000);
        };

        if (!document.querySelector('#toast-styles')) {
            const style = document.createElement('style');
            style.id = 'toast-styles';
            style.textContent = `
        @keyframes toastSlideIn {
            from { transform: translateX(120%) scale(.9); opacity: 0; }
            to   { transform: translateX(0) scale(1); opacity: 1; }
        }
        @keyframes toastSlideOut {
            from { transform: translateX(0) scale(1); opacity: 1; }
            to   { transform: translateX(120%) scale(.9); opacity: 0; }
        }
    `;

            document.head.appendChild(style);
        }
    </script>

    @vite(['resources/css/User/dashboard.css',
    'resources/js/User/dashboard.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')
</head>

<body>
    <div class="stars-background"></div>

    @include('components.header')


    <div id="toast-container"></div>



    <script>
        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');

            toast.className = 'toast';
            toast.innerText = message;

            container.appendChild(toast);

            // eliminar después de 3 segundos
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }
    </script>



    <main class="main-content">
        @yield('content')
    </main>
    @include('components.footer')

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

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



</body>

</html>