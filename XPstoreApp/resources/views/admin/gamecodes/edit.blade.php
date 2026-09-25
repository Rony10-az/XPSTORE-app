@extends('layouts.admin')

@section('title', 'Editar Código - XP Store')
@section('subtitle', 'Modifica la información del código de activación')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-edit"></i> Editar Código</h1>
            <p class="admin-subtitle">{{ $gamecode->code }}</p>
        </div>
        <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.gamecodes.update', $gamecode) }}" method="POST" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="video_game_id">Videojuego *</label>
                <select name="video_game_id" id="video_game_id" class="form-control" required>
                    <option value="">Selecciona un videojuego</option>
                    @foreach($videoGames as $game)
                        <option value="{{ $game->id }}" {{ old('video_game_id', $gamecode->video_game_id) == $game->id ? 'selected' : '' }}>
                            {{ $game->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="code">Código *</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', $gamecode->code) }}" required>
            </div>

            <div class="form-group">
                <label for="status">Estado *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="disponible" {{ old('status', $gamecode->status) === 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="usado" {{ old('status', $gamecode->status) === 'usado' ? 'selected' : '' }}>Usado</option>
                    <option value="vencido" {{ old('status', $gamecode->status) === 'vencido' ? 'selected' : '' }}>Vencido</option>
                </select>
            </div>

            <div class="form-group">
                <label for="batch">Lote (opcional)</label>
                <input type="text" id="batch" name="batch" class="form-control" value="{{ old('batch', $gamecode->batch) }}" placeholder="Nombre del lote">
            </div>
        </div>

        @if($gamecode->user_id)
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Información del uso</strong>
                <p>Este código fue usado por: <strong>{{ $gamecode->user->name ?? 'Usuario desconocido' }}</strong></p>
                @if($gamecode->used_at)
                <p>Fecha de uso: {{ $gamecode->used_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>
        </div>
        @endif

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Actualizar Código
            </button>
            <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<style>
.form-container {
    background: #1a1d29;
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid #2a2d3a;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: #cbd5e1;
    font-weight: 500;
    font-size: 0.95rem;
}

.form-control {
    background: #0f172a;
    border: 1px solid #3a3d4a;
    color: #fff;
    padding: 0.75rem;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #8b5cf6;
    background: #1a1d29;
}

.form-control::placeholder {
    color: #64748b;
}

select.form-control {
    cursor: pointer;
}

.info-box {
    background: #0f172a;
    border: 1px solid #3a3d4a;
    border-left: 3px solid #8b5cf6;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}

.info-box i {
    color: #8b5cf6;
    font-size: 1.2rem;
    margin-top: 0.2rem;
}

.info-box strong {
    color: #cbd5e1;
    display: block;
    margin-bottom: 0.5rem;
}

.info-box p {
    color: #8b92a7;
    font-size: 0.9rem;
    margin: 0.25rem 0;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #2a2d3a;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-secondary);
    border: 1px solid rgba(255, 255, 255, 0.15);
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.25);
    color: white;
}
</style>
@endsection
