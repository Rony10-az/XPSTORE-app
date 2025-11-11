@extends('layouts.auth')

@section('title', 'Registrarse')

@section('content')
{{-- Formulario de registro: nombre, email y contraseña (confirmada) --}}
<h2>Registro</h2>

@if($errors->any())
<div style="color:#b91c1c;margin-bottom:12px">
    <ul>
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <div style="margin-bottom:8px">
        <label>Nombre</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
    </div>

    <div style="margin-bottom:8px">
        <label>Email</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
    </div>

    <div style="margin-bottom:8px">
        <label>Contraseña</label><br>
        <input type="password" name="password" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
    </div>

    <div style="margin-bottom:8px">
        <label>Confirmar contraseña</label><br>
        <input type="password" name="password_confirmation" required style="width:100%;padding:8px;border:1px solid #d1d5db;border-radius:6px">
    </div>

    <div>
        <button type="submit" class="btn">Crear cuenta</button>
    </div>
</form>

<p style="margin-top:12px">Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
@endsection