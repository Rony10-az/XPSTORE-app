@extends('layouts.admin')

@section('title', 'Editar Game Code - XP Store')

@vite(['resources/css/show.css'])

@section('content')
<div class="show-container">
    <div class="show-header">
        <div class="show-title">
            <h1>Editar Código</h1>
            <p class="show-subtitle">Modifica un código existente</p>
        </div>
    </div>

    <div class="show-layout">
        <div class="main-content">
            <div class="game-info-section">
                <form action="{{ route('admin.gamecodes.update', $gamecode->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="video_game_id">Videojuego</label>
                        <select name="video_game_id" id="video_game_id" required>
                            @foreach($videoGames as $game)
                            <option value="{{ $game->id }}" {{ $game->id == $gamecode->video_game_id ? 'selected' : '' }}>
                                {{ $game->title }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="code">Código</label>
                        <input type="text" name="code" id="code" value="{{ $gamecode->code }}" required>
                    </div>

                    <button type="submit" class="btn-primary">Actualizar Código</button>
                    <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection