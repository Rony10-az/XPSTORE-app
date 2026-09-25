@extends('layouts.admin')

@section('title', 'Gestión de Reseñas - XP Store')
@section('subtitle', 'Modera comentarios y calificaciones de la comunidad')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-star-half-alt"></i> Gestión de Reseñas</h1>
            <p class="admin-subtitle">Revisa, filtra y elimina reseñas con baja calidad o reportes.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-primary">
            <i class="fas fa-users"></i> Usuarios Logeados
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-comments"></i></div>
            </div>
            <h3 class="stat-number counter" data-target="{{ $metrics['total'] }}">0</h3>
            <p class="stat-label">Total reseñas</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
            </div>
            <h3 class="stat-number counter-decimal" data-target="{{ $metrics['avg_rating'] }}">0</h3>
            <p class="stat-label">Rating promedio</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-flag"></i></div>
            </div>
            <h3 class="stat-number counter" data-target="{{ $metrics['low_ratings'] }}">0</h3>
            <p class="stat-label">Con rating ≤ 2</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <h3 class="stat-number counter" data-target="{{ $metrics['verified_purchases'] }}">0</h3>
            <p class="stat-label">Compras verificadas</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
            </div>
            <h3 class="stat-number">
                <span class="counter" data-target="{{ $metrics['users_with_reviews'] }}">0</span>/<span class="counter" data-target="{{ $metrics['total_users'] }}">0</span>
            </h3>
            <p class="stat-label">Usuarios con reseñas</p>
        </div>
    </div>

    @if($statusFilter ?? false)
        <div class="filter-active-banner">
            <div class="filter-info">
                <i class="fas fa-filter"></i>
                <span>Mostrando reseñas:
                    <strong>
                        @if($statusFilter == 'pendiente')
                            Pendientes
                        @elseif($statusFilter == 'aprobada')
                            Aprobadas
                        @elseif($statusFilter == 'rechazada')
                            Rechazadas
                        @endif
                    </strong>
                </span>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="btn-clear-filter">
                <i class="fas fa-times"></i> Limpiar filtro
            </a>
        </div>
    @endif

    <form class="crud-toolbar" method="GET" action="{{ route('admin.reviews.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar por nombre o correo de usuario...">
            </div>
        </div>
        <div class="toolbar-right">
            @if($statusFilter ?? false)
                <input type="hidden" name="status" value="{{ $statusFilter }}">
            @endif
            <button type="submit" class="btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <div class="crud-table-container">
        <table class="crud-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Reseñas</th>
                    <th>Verificado</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="text-center">#{{ $user->id }}</td>
                        <td>
                            <div class="user-info">
                                <p class="user-name">{{ $user->name }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="user-email">{{ $user->email }}</p>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-primary" style="font-size: 1rem; padding: 8px 12px;">
                                <i class="fas fa-comments"></i> {{ $user->game_reviews_count }}
                            </span>
                        </td>
                        <td class="text-center">
                            @php
                                $hasVerifiedPurchase = $user->gameReviews->where('is_verified_purchase', true)->count() > 0;
                            @endphp
                            @if($hasVerifiedPurchase)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Sí
                                </span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap; justify-content: center;">
                                <a href="{{ route('admin.reviews.user.show', $user->id) }}" class="btn-review-action btn-view-review" title="Ver todas las reseñas">
                                    <i class="fas fa-eye"></i> Ver reseñas
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay usuarios con reseñas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $users->links('vendor.pagination.admin') }}
    </div>
</div>

{{-- MODAL PARA RECHAZAR RESEÑA --}}
<div id="rejectModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <div class="modal-header">
            <h3><i class="fas fa-ban"></i> Rechazar Reseña</h3>
            <button class="close-btn" onclick="closeRejectModal()">&times;</button>
        </div>

        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="rejection_reason">Motivo de rechazo *</label>
                    <select name="rejection_reason" id="rejection_reason" class="form-control" required>
                        <option value="">Selecciona un motivo...</option>
                        <option value="lenguaje_ofensivo">Lenguaje ofensivo</option>
                        <option value="spam">Spam</option>
                        <option value="contenido_no_relacionado">Contenido no relacionado</option>
                        <option value="insultos">Insultos</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="moderation_note">Nota de moderación (opcional)</label>
                    <textarea name="moderation_note" id="moderation_note" class="form-control" rows="3" placeholder="Agrega una nota explicando el motivo del rechazo..."></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeRejectModal()">Cancelar</button>
                <button type="submit" class="btn-danger">
                    <i class="fas fa-ban"></i> Rechazar Reseña
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Estilos mejorados para botones de reseñas */
.btn-review-action {
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    text-decoration: none;
}

.btn-view-review {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-view-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-approve-review {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white;
    font-weight: 600;
}

.btn-approve-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(56, 239, 125, 0.4);
}

.btn-reject-review {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    font-weight: 600;
}

.btn-reject-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
}

.btn-delete-review {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: #333;
    font-weight: 600;
}

.btn-delete-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(250, 112, 154, 0.4);
}

.modal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: #1e2430;
    border-radius: 12px;
    padding: 0;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #2a3142;
}

.modal-header h3 {
    margin: 0;
    color: #fff;
    font-size: 1.3rem;
}

.close-btn {
    background: none;
    border: none;
    color: #888;
    font-size: 2rem;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    line-height: 1;
}

.close-btn:hover {
    color: #fff;
}

.modal-body {
    padding: 25px;
}

.modal-footer {
    padding: 20px 25px;
    border-top: 1px solid #2a3142;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    color: #ccc;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 12px;
    background: #252c3d;
    border: 1px solid #363d52;
    border-radius: 8px;
    color: #fff;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #6c63ff;
}

/* Banner de filtro activo */
.filter-active-banner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(99, 102, 241, 0.15));
    border: 1px solid rgba(139, 92, 246, 0.3);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
}

.filter-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #e2e8f0;
    font-size: 0.95rem;
}

.filter-info i {
    color: #a78bfa;
    font-size: 1.1rem;
}

.filter-info strong {
    color: #c4b5fd;
    font-weight: 600;
}

.btn-clear-filter {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 8px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-clear-filter:hover {
    background: rgba(239, 68, 68, 0.3);
    border-color: rgba(239, 68, 68, 0.5);
    transform: translateY(-2px);
}
</style>

<script>
function openRejectModal(reviewId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/reviews/${reviewId}/reject`;
    modal.style.display = 'flex';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.style.display = 'none';
    document.getElementById('rejectForm').reset();
}

// Cerrar modal al hacer clic fuera
document.getElementById('rejectModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});

// ========================================
// CONTADOR ANIMADO PARA ESTADÍSTICAS
// ========================================
const counters = document.querySelectorAll('.counter, .counter-decimal');
const speed = 200; // Velocidad de la animación

const animateCounter = (counter) => {
    const target = +counter.getAttribute('data-target');
    const isDecimal = counter.classList.contains('counter-decimal');
    const increment = target / speed;
    let count = 0;

    const updateCount = () => {
        count += increment;

        if (count < target) {
            if (isDecimal) {
                counter.textContent = count.toFixed(1);
            } else {
                counter.textContent = Math.ceil(count);
            }
            requestAnimationFrame(updateCount);
        } else {
            if (isDecimal) {
                counter.textContent = target.toFixed(1);
            } else {
                counter.textContent = target;
            }
        }
    };

    updateCount();
};

// Usar Intersection Observer para animar cuando sea visible
const observerOptions = {
    threshold: 0.2,
    rootMargin: '0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target); // Solo animar una vez
        }
    });
}, observerOptions);

counters.forEach(counter => {
    observer.observe(counter);
});
</script>

@endsection
