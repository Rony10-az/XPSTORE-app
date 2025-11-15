@extends('layouts.admin')

@section('title', 'Detalle Game Code - XP Store')

@vite(['resources/css/show.css'])

@section('content')
<div class="show-container">
    <div class="show-header">
        <div class="show-title">
            <h1>Código: {{ $gamecode->code }}</h1>
            <p class="show-subtitle">Detalles del código y su videojuego</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.gamecodes.edit', $gamecode->id) }}" class="btn-primary">Editar</a>
            <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">Volver</a>
        </div>
    </div>

    <div class="show-layout">
        <div class="main-content">
            <div class="game-info-section">
                <p><strong>ID:</strong> {{ $gamecode->id }}</p>
                <p><strong>Código:</strong> {{ $gamecode->code }}</p>
                <p><strong>Usado:</strong> {{ $gamecode->used ? 'Sí' : 'No' }}</p>
                <p><strong>Videojuego:</strong> {{ $gamecode->videoGame->title ?? '-' }}</p>
                <p><strong>Creado:</strong> {{ $gamecode->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $gamecode->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection