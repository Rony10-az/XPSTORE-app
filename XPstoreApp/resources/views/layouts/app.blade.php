<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>XPStore</title>
    <style>
        /* minimal styling so views look ok without external frameworks */
        body{font-family:Arial,Helvetica,sans-serif;background:#f3f4f6;margin:0}
        .container{max-width:900px;margin:40px auto;padding:20px;background:white;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.06)}
        .header{display:flex;justify-content:space-between;align-items:center}
        a{color:#2563eb;text-decoration:none}
        .btn{background:#2563eb;color:white;padding:8px 14px;border-radius:6px;text-decoration:none}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>XPStore</h1>
            <div>
                @if(session('user'))
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button class="btn">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a> |
                    <a href="{{ route('register') }}">Registro</a>
                @endif
            </div>
        </div>

        <hr style="margin:12px 0">

        @if(session('success'))
            <div style="background:#ecfdf5;border:1px solid #bbf7d0;color:#065f46;padding:10px;border-radius:6px;margin-bottom:12px">{{ session('success') }}</div>
        @endif

        {{-- Contenido de la página --}}
        @yield('content')
    </div>
</body>
</html>
