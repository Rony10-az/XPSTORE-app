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