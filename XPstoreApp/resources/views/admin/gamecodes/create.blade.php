@extends('layouts.admin')

@section('title', 'Generar Códigos - XP Store')
@section('subtitle', 'Crea códigos de activación individuales o por lotes')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-plus-circle"></i> Generar Códigos</h1>
            <p class="admin-subtitle">Crea códigos de forma manual o automática para tus videojuegos</p>
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

    <form action="{{ route('admin.gamecodes.store') }}" method="POST" class="form-container">
        @csrf

        {{-- Selección de Videojuego --}}
        <div class="form-group">
            <label for="video_game_id">Videojuego *</label>
            <select name="video_game_id" id="video_game_id" class="form-control" required>
                <option value="">Selecciona un videojuego</option>
                @foreach($videoGames as $game)
                    <option value="{{ $game->id }}" {{ old('video_game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->title }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Modo de Generación --}}
        <div class="form-group">
            <label>Modo de Generación *</label>
            <div class="radio-group">
                <label class="radio-option">
                    <input type="radio" name="generation_mode" value="single" {{ old('generation_mode', 'single') === 'single' ? 'checked' : '' }} onchange="toggleGenerationMode()">
                    <span>
                        <i class="fas fa-ticket-alt"></i>
                        <strong>Código Individual</strong>
                        <small>Genera un solo código</small>
                    </span>
                </label>
                <label class="radio-option">
                    <input type="radio" name="generation_mode" value="batch" {{ old('generation_mode') === 'batch' ? 'checked' : '' }} onchange="toggleGenerationMode()">
                    <span>
                        <i class="fas fa-layer-group"></i>
                        <strong>Lote de Códigos</strong>
                        <small>Genera múltiples códigos automáticamente</small>
                    </span>
                </label>
            </div>
        </div>

        {{-- Campos para modo Individual --}}
        <div id="single-mode" class="generation-mode-fields">
            <div class="form-group">
                <label for="code">Código (opcional)</label>
                <input type="text" id="code" name="code" class="form-control" value="{{ old('code') }}" placeholder="Deja vacío para generar automáticamente">
                <small class="form-text">Si no especificas un código, se generará uno aleatorio.</small>
            </div>
        </div>

        {{-- Campos para modo Lote --}}
        <div id="batch-mode" class="generation-mode-fields" style="display: none;">
            <div class="form-grid">
                <div class="form-group">
                    <label for="quantity">Cantidad de Códigos *</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="500" value="{{ old('quantity', 10) }}">
                    <small class="form-text">Máximo 500 códigos por lote</small>
                </div>

                <div class="form-group">
                    <label for="batch_name">Nombre del Lote (opcional)</label>
                    <input type="text" id="batch_name" name="batch_name" class="form-control" value="{{ old('batch_name') }}" placeholder="Ej: PROMO-NAVIDAD-2025">
                    <small class="form-text">Se generará automáticamente si no especificas uno</small>
                </div>
            </div>
        </div>

        {{-- Nombre de Lote opcional para modo individual también --}}
        <div id="single-batch-field" class="form-group">
            <label for="batch_name_single">Lote (opcional)</label>
            <input type="text" id="batch_name_single" name="batch_name" class="form-control" value="{{ old('batch_name') }}" placeholder="Para agrupar códigos relacionados">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-check"></i> Generar Códigos
            </button>
            <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function toggleGenerationMode() {
    const mode = document.querySelector('input[name="generation_mode"]:checked').value;
    const singleMode = document.getElementById('single-mode');
    const batchMode = document.getElementById('batch-mode');
    const singleBatchField = document.getElementById('single-batch-field');

    if (mode === 'single') {
        singleMode.style.display = 'block';
        batchMode.style.display = 'none';
        singleBatchField.style.display = 'block';

        // Desactivar validación de campos batch
        document.getElementById('quantity').removeAttribute('required');
        document.getElementById('code').removeAttribute('required');
    } else {
        singleMode.style.display = 'none';
        batchMode.style.display = 'block';
        singleBatchField.style.display = 'none';

        // Activar validación para cantidad
        document.getElementById('quantity').setAttribute('required', 'required');
        document.getElementById('code').value = '';
    }
}

// Inicializar al cargar
document.addEventListener('DOMContentLoaded', toggleGenerationMode);
</script>

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
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
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

.form-text {
    color: #8b92a7;
    font-size: 0.85rem;
}

.radio-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.radio-option {
    background: #0f172a;
    border: 2px solid #3a3d4a;
    border-radius: 8px;
    padding: 1rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.radio-option:hover {
    border-color: #8b5cf6;
    background: #1a1d29;
}

.radio-option input[type="radio"] {
    margin-top: 0.25rem;
    cursor: pointer;
}

.radio-option input[type="radio"]:checked ~ span {
    color: #8b5cf6;
}

.radio-option span {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    color: #cbd5e1;
}

.radio-option i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
}

.radio-option strong {
    display: block;
    font-size: 0.95rem;
}

.radio-option small {
    color: #8b92a7;
    font-size: 0.85rem;
}

.generation-mode-fields {
    padding: 1rem;
    background: #0f172a;
    border-radius: 8px;
    border: 1px solid #2a2d3a;
    margin-bottom: 1.5rem;
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
