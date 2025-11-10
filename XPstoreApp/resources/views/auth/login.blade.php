@extends('layouts.app')

@section('content')
    {{-- Formulario de login: email y contraseña --}}
    <h2>Iniciar sesión</h2>

    @if($errors->any())
        <div style="color:#b91c1c;margin-bottom:12px">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div style="margin-bottom:8px">
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
        </div>

        <div style="margin-bottom:8px">
            <label>Contraseña</label><br>
            <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
        </div>

        <div>
            <button type="submit" class="btn">Ingresar</button>
        </div>
    </form>

    <p style="margin-top:12px">No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
@endsection
