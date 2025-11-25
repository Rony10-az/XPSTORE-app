@extends('layouts.admin')

@section('title', 'Nuevo Game Code - XP Store')

@vite(['resources/css/show.css'])

@section('content')
<div class="show-container">
    {{-- Header --}}
    <div class="show-header">
        <div class="show-title">
            <h1>Crear Código</h1>
            <p class="show-subtitle">Asocia un nuevo código a un videojuego</p>
        </div>
    </div>

    {{-- Contenido principal --}}
    <div class="show-layout">
        <div class="main-content">
            <div class="game-info-section">
                <form action="{{ route('admin.gamecodes.store') }}" method="POST">
                    @csrf

                    {{-- Selección de Videojuego --}}
                    <div class="form-group">
                        <label for="video_game_id">Videojuego</label>
                        <select name="video_game_id" id="video_game_id" required>
                            <option value="">Selecciona un videojuego</option>
                            @foreach($videoGames as $game)
                            <option value="{{ $game->id }}">{{ $game->title }}</option>
                            @endforeach
                        </select>
                        @error('video_game_id')
                        <p
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Input de Código --}}
                    <div class="form-group">
                        <label for="code">Código</label>
                        <input type="text" name="code" id="code" required placeholder="Ej: ABCD-1234-EFGH" value="{{ old('code') }}">
                        @error('code')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="form-actions" style="margin-top: 1rem;">
                        <button type="submit" class="btn-primary">Crear Código</button>
                        <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection