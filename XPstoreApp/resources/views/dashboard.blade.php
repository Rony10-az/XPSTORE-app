@extends('layouts.app')

@section('content')
    {{-- Página protegida que muestra información mínima del usuario autenticado --}}
    <h2>Dashboard</h2>

    <p>Bienvenido, {{ session('user.name') ?? 'Usuario' }}!</p>

    <p style="margin-top:12px">Email: {{ session('user.email') ?? '-' }}</p>

    <p style="margin-top:12px">Esta ruta está protegida (demo en memoria).</p>
@endsection
