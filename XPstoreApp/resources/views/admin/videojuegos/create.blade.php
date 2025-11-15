@extends('layouts.admin')

@section('title', 'Crear Videojuego - XP Store')

@vite(['resources/css/create.css', 'resources/js/create.js'])

@section('content')
<div class="admin-container">
    {{-- Header --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-plus"></i> Crear Nuevo Videojuego</h1>
            <p class="admin-subtitle">Agrega un nuevo juego al catálogo de XP Store</p>
        </div>
        <a href="{{ route('admin.videojuegos.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Listado
        </a>
    </div>

    {{-- Formulario --}}
    <div class="form-container">
        <form action="{{ route('admin.videojuegos.store') }}" method="POST" enctype="multipart/form-data" class="crud-form">
            @csrf

            {{-- Información Básica --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Información Básica
                </h3>

                <div class="form-grid">
                    {{-- Título --}}
                    <div class="form-group">
                        <label for="title" class="form-label">Título del Juego *</label>
                        <input type="text" id="title" name="title" class="form-input"
                            value="{{ old('title') }}" required>
                        @error('title')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Desarrollador --}}
                    <div class="form-group">
                        <label for="developer" class="form-label">Desarrollador *</label>
                        <input type="text" id="developer" name="developer" class="form-input"
                            value="{{ old('developer') }}" required>
                        @error('developer')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Publicador --}}
                    <div class="form-group">
                        <label for="publisher" class="form-label">Publicador *</label>
                        <input type="text" id="publisher" name="publisher" class="form-input"
                            value="{{ old('publisher') }}" required>
                        @error('publisher')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Fecha de Lanzamiento --}}
                    <div class="form-group">
                        <label for="release_date" class="form-label">Fecha de Lanzamiento *</label>
                        <input type="date" id="release_date" name="release_date" class="form-input"
                            value="{{ old('release_date') }}" required>
                        @error('release_date')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Precios y Stock --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-tag"></i>
                    Precios y Stock
                </h3>

                <div class="form-grid">
                    {{-- Precio --}}
                    <div class="form-group">
                        <label for="price" class="form-label">Precio ($) *</label>
                        <input type="number" id="price" name="price" class="form-input"
                            step="0.01" min="0" value="{{ old('price') }}" required>
                        @error('price')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Descuento --}}
                    <div class="form-group">
                        <label for="discount" class="form-label">Descuento (%)</label>
                        <input type="number" id="discount" name="discount" class="form-input"
                            step="1" min="0" max="100" value="{{ old('discount', 0) }}">
                        @error('discount')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="form-group">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" id="stock" name="stock" class="form-input"
                            min="0" value="{{ old('stock', 0) }}" required>
                        @error('stock')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Rating --}}
                    <div class="form-group">
                        <label for="rating" class="form-label">Rating (0-5)</label>
                        <input type="number" id="rating" name="rating" class="form-input"
                            step="0.1" min="0" max="5" value="{{ old('rating', 0) }}">
                        @error('rating')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Categorías --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-tags"></i>
                    Categorías
                </h3>

                <div class="form-grid">
                    {{-- Géneros --}}
                    <div class="form-group">
                        <label class="form-label">Géneros *</label>
                        <div class="checkbox-grid">
                            @php
                            $genres = [
                            'Acción', 'Aventura', 'RPG', 'Estrategia', 'Deportes',
                            'Carreras', 'Shooter', 'Lucha', 'Simulación', 'Indie',
                            'Terror', 'Multijugador', 'Mundo Abierto', 'Fantasia',
                            'Ciencia Ficción', 'Battle Royale', 'MMORPG'
                            ];
                            @endphp
                            @foreach($genres as $genre)
                            <label class="checkbox-label">
                                <input type="checkbox" name="genre[]" value="{{ $genre }}"
                                    {{ in_array($genre, old('genre', [])) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                {{ $genre }}
                            </label>
                            @endforeach
                        </div>
                        @error('genre')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Plataformas --}}
                    <div class="form-group">
                        <label class="form-label">Plataformas *</label>
                        <div class="checkbox-grid">
                            @php
                            $platforms = [
                            'PC', 'PlayStation 5', 'Xbox Series X/S', 'Nintendo Switch',
                            'PlayStation 4', 'Xbox One', 'Mobile', 'VR', 'Cloud Gaming'
                            ];
                            @endphp
                            @foreach($platforms as $platform)
                            <label class="checkbox-label">
                                <input type="checkbox" name="platform[]" value="{{ $platform }}"
                                    {{ in_array($platform, old('platform', [])) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                {{ $platform }}
                            </label>
                            @endforeach
                        </div>
                        @error('platform')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Imágenes --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-images"></i>
                    Imágenes del Juego
                </h3>

                <div class="form-group">
                    <label for="images" class="form-label">Imágenes (Múltiples)</label>
                    <div class="file-upload">
                        <input type="file" id="images" name="images[]" multiple
                            accept="image/jpeg,image/png,image/jpg,image/gif" class="file-input">
                        <label for="images" class="file-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Seleccionar imágenes</span>
                        </label>
                        <div id="image-preview" class="image-preview"></div>
                    </div>
                    @error('images.*')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Descripción y Requisitos --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Descripción y Detalles
                </h3>

                <div class="form-grid">
                    {{-- Descripción --}}
                    <div class="form-group full-width">
                        <label for="description" class="form-label">Descripción *</label>
                        <textarea id="description" name="description" class="form-textarea"
                            rows="6" required>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Requisitos del Sistema --}}
                    <div class="form-group full-width">
                        <label for="requirements" class="form-label">Requisitos del Sistema (JSON)</label>
                        <textarea id="requirements" name="requirements" class="form-textarea"
                            rows="4" placeholder='{"mínimos": {"OS": "Windows 10", "RAM": "8GB"}, "recomendados": {"OS": "Windows 11", "RAM": "16GB"}}'>{{ old('requirements') }}</textarea>
                        @error('requirements')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Opciones Adicionales --}}
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-cog"></i>
                    Opciones Adicionales
                </h3>

                <div class="form-options">
                    <label class="option-label">
                        <input type="checkbox" name="featured" value="1"
                            {{ old('featured') ? 'checked' : '' }}>
                        <span class="option-checkbox"></span>
                        <div class="option-content">
                            <strong>Destacado</strong>
                            <span>Mostrar este juego en secciones destacadas</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="history.back()">
                    <i class="fas fa-times"></i>
                    Cancelar
                </button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i>
                    Crear Videojuego
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview de imágenes
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        const files = e.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement('div');
                img.className = 'preview-image';
                img.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <span>${file.name}</span>
            `;
                preview.appendChild(img);
            }

            reader.readAsDataURL(file);
        }
    });

    // Validación de formulario
    document.querySelector('.crud-form').addEventListener('submit', function(e) {
        const price = document.getElementById('price').value;
        const discount = document.getElementById('discount').value;

        if (price < 0) {
            e.preventDefault();
            alert('El precio no puede ser negativo');
            return false;
        }

        if (discount < 0 || discount > 100) {
            e.preventDefault();
            alert('El descuento debe estar entre 0 y 100');
            return false;
        }
    });
</script>
@endpush