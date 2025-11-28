@extends('layouts.admin')

@section('title', 'Editar Ítem - XP Store')
@section('subtitle', 'Modifica la información del ítem')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-edit"></i> Editar Ítem</h1>
            <p class="admin-subtitle">{{ $item->name }}</p>
        </div>
        <a href="{{ route('admin.items.index') }}" class="btn-secondary">
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

    <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data" class="form-container">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nombre del Ítem *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
            </div>

            <div class="form-group">
                <label for="type">Tipo de Ítem *</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">Selecciona un tipo</option>
                    <option value="skin" {{ old('type', $item->type) == 'skin' ? 'selected' : '' }}>Skin</option>
                    <option value="arma" {{ old('type', $item->type) == 'arma' ? 'selected' : '' }}>Arma</option>
                    <option value="emote" {{ old('type', $item->type) == 'emote' ? 'selected' : '' }}>Emote</option>
                    <option value="moneda" {{ old('type', $item->type) == 'moneda' ? 'selected' : '' }}>Moneda</option>
                    <option value="pase" {{ old('type', $item->type) == 'pase' ? 'selected' : '' }}>Pase</option>
                    <option value="otro" {{ old('type', $item->type) == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price">Precio (S/.) *</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ old('price', $item->price) }}" required>
            </div>

            <div class="form-group">
                <label for="rarity">Rareza *</label>
                <select id="rarity" name="rarity" class="form-control" required>
                    <option value="">Selecciona la rareza</option>
                    <option value="común" {{ old('rarity', $item->rarity) == 'común' ? 'selected' : '' }}>Común</option>
                    <option value="poco común" {{ old('rarity', $item->rarity) == 'poco común' ? 'selected' : '' }}>Poco Común</option>
                    <option value="raro" {{ old('rarity', $item->rarity) == 'raro' ? 'selected' : '' }}>Raro</option>
                    <option value="épico" {{ old('rarity', $item->rarity) == 'épico' ? 'selected' : '' }}>Épico</option>
                    <option value="legendario" {{ old('rarity', $item->rarity) == 'legendario' ? 'selected' : '' }}>Legendario</option>
                </select>
            </div>

            <div class="form-group">
                <label for="stock">Stock *</label>
                <input type="number" id="stock" name="stock" class="form-control" min="0" value="{{ old('stock', $item->stock) }}" required>
            </div>

            <div class="form-group">
                <label for="image">Imagen</label>
                @if($item->image)
                    <div style="margin-bottom: 1rem;">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 200px; border-radius: 8px; border: 1px solid #3a3d4a;">
                        <p style="color: #8b92a7; font-size: 0.85rem; margin-top: 0.5rem;">Imagen actual. Sube una nueva para reemplazarla.</p>
                    </div>
                @endif
                <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <div id="image-preview" style="margin-top: 1rem; display: none;">
                    <img id="preview" style="max-width: 200px; border-radius: 8px; border: 1px solid #3a3d4a;">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_active" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                <span>Ítem Activo</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i> Actualizar Ítem
            </button>
            <a href="{{ route('admin.items.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('image-preview');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        previewContainer.style.display = 'none';
    }
}
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

textarea.form-control {
    resize: vertical;
    font-family: inherit;
}

select.form-control {
    cursor: pointer;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #cbd5e1;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
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
