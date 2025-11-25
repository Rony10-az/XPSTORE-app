@extends('layouts.admin')

@section('title', 'Eliminar Videojuego - XP Store')

@vite(['resources/css/destroy.css'])

@section('content')
<div class="delete-container">
    <div class="delete-card">
        <!-- Header -->
        <div class="delete-header">
            <div class="warning-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="delete-title">Eliminar Videojuego</h1>
            <p class="delete-subtitle">Esta acción no se puede deshacer</p>
        </div>

        <!-- Información del Juego -->
        <div class="game-preview">
            <div class="game-image">
                <img src="{{ $videojuego->images ? asset('storage/' . $videojuego->images[0]) : 'https://via.placeholder.com/400x200?text=Sin+Imagen' }}"
                    alt="{{ $videojuego->title }}">
            </div>
            <div class="game-details">
                <h3 class="game-title">{{ $videojuego->title }}</h3>
                <div class="game-info">
                    <div class="info-item">
                        <span class="info-label">Desarrollador:</span>
                        <span class="info-value">{{ $videojuego->developer }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Publicador:</span>
                        <span class="info-value">{{ $videojuego->publisher }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Fecha de Lanzamiento:</span>
                        <span class="info-value">{{ $videojuego->release_date->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Precio:</span>
                        <span class="info-value">${{ number_format($videojuego->price, 2) }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Stock:</span>
                        <span class="info-value">{{ $videojuego->stock }} unidades</span>
                    </div>
                </div>

                <!-- Estadísticas del Juego -->
                <div class="game-stats">
                    <div class="stat">
                        <span class="stat-number">{{ $videojuego->rating }}</span>
                        <span class="stat-label">Rating</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">{{ $salesCount ?? 0 }}</span>
                        <span class="stat-label">Ventas</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">{{ $reviewsCount ?? 0 }}</span>
                        <span class="stat-label">Reseñas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Advertencias -->
        <div class="warning-section">
            <h4 class="warning-title">
                <i class="fas fa-radiation"></i>
                Advertencias Importantes
            </h4>
            <ul class="warning-list">
                <li class="warning-item">
                    <i class="fas fa-times-circle"></i>
                    <span>Todas las imágenes del juego serán eliminadas permanentemente</span>
                </li>
                <li class="warning-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Las estadísticas de ventas asociadas se perderán</span>
                </li>
                <li class="warning-item">
                    <i class="fas fa-comments"></i>
                    <span>Todas las reseñas y calificaciones serán eliminadas</span>
                </li>
                <li class="warning-item">
                    <i class="fas fa-database"></i>
                    <span>Esta acción afectará los reportes y análisis del sistema</span>
                </li>
                @if($activeOrders > 0)
                <li class="warning-item critical">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>
                        <strong>CRÍTICO:</strong> Hay {{ $activeOrders }} pedidos activos que incluyen este juego
                    </span>
                </li>
                @endif
            </ul>
        </div>

        <!-- Confirmación -->
        <div class="confirmation-section">
            <div class="confirmation-checkbox">
                <input type="checkbox" id="confirmDelete" class="confirm-checkbox">
                <label for="confirmDelete" class="confirm-label">
                    <span class="checkmark"></span>
                    Entiendo que esta acción es permanente y no se puede deshacer
                </label>
            </div>

            <div class="type-confirmation">
                <label for="typeConfirm" class="type-label">
                    Escribe "<strong>ELIMINAR {{ strtoupper($videojuego->title) }}</strong>" para confirmar:
                </label>
                <input type="text" id="typeConfirm" class="type-input" placeholder="Escribe aquí para confirmar...">
                <div class="input-match">
                    <i class="fas fa-check" id="matchIcon"></i>
                    <span id="matchText">Coincidencia requerida</span>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="action-buttons">
            <a href="{{ route('admin.videojuegos.show', $videojuego->id) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Volver a Detalles
            </a>

            <div class="danger-actions">
                <a href="{{ route('admin.videojuegos.edit', $videojuego->id) }}" class="btn-warning">
                    <i class="fas fa-edit"></i>
                    Editar en Lugar de Eliminar
                </a>

                <form action="{{ route('admin.videojuegos.destroy', $videojuego->id) }}" method="POST" id="deleteForm" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger" id="deleteButton" disabled>
                        <i class="fas fa-trash"></i>
                        Eliminar Permanentemente
                    </button>
                </form>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="additional-info">
            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div class="info-content">
                    <h5>¿Necesitas ayuda?</h5>
                    <p>Si no estás seguro sobre eliminar este juego, considera:</p>
                    <ul>
                        <li>Desactivarlo temporalmente en lugar de eliminarlo</li>
                        <li>Reducir el stock a 0 en lugar de eliminar</li>
                        <li>Contactar al administrador del sistema</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmCheckbox = document.getElementById('confirmDelete');
        const typeInput = document.getElementById('typeConfirm');
        const deleteButton = document.getElementById('deleteButton');
        const matchIcon = document.getElementById('matchIcon');
        const matchText = document.getElementById('matchText');
        const requiredText = 'ELIMINAR {{ strtoupper($videojuego->title) }}';

        function validateConfirmation() {
            const checkboxChecked = confirmCheckbox.checked;
            const textMatches = typeInput.value.trim().toUpperCase() === requiredText.toUpperCase();

            if (textMatches) {
                matchIcon.className = 'fas fa-check';
                matchIcon.style.color = '#10b981';
                matchText.textContent = 'Coincidencia correcta';
                matchText.style.color = '#10b981';
            } else {
                matchIcon.className = 'fas fa-times';
                matchIcon.style.color = '#ef4444';
                matchText.textContent = 'Coincidencia requerida';
                matchText.style.color = '#ef4444';
            }

            deleteButton.disabled = !(checkboxChecked && textMatches);
        }

        confirmCheckbox.addEventListener('change', validateConfirmation);
        typeInput.addEventListener('input', validateConfirmation);

        // Confirmación final antes de enviar
        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            if (!confirm('¿ESTÁS ABSOLUTAMENTE SEGURO? Esta acción eliminará permanentemente "{{ $videojuego->title }}" y todos sus datos asociados.')) {
                e.preventDefault();
                return false;
            }

            // Mostrar loading state
            deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Eliminando...';
            deleteButton.disabled = true;
        });

        // Efecto de escritura para el placeholder
        let placeholderText = 'Escribe "' + requiredText + '" para confirmar...';
        let i = 0;

        function typeWriter() {
            if (i < placeholderText.length) {
                typeInput.setAttribute('placeholder', placeholderText.substring(0, i + 1));
                i++;
                setTimeout(typeWriter, 50);
            }
        }

        // Iniciar efecto después de un delay
        setTimeout(typeWriter, 1000);
    });
</script>
@endpush