@extends('layouts.admin')

@section('title', 'Reseñas de ' . $user->name . ' - XP Store')
@section('subtitle', 'Gestiona todas las reseñas de este usuario')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-user-edit"></i> Reseñas de {{ $user->name }}</h1>
            <p class="admin-subtitle">{{ $user->email }} - Total de reseñas: {{ $user->gameReviews->count() }}</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="reviews-grid">
        @forelse($user->gameReviews as $review)
        <div class="review-item-card">
            <div class="review-card-header">
                <div>
                    <h3 class="game-title">{{ $review->videoGame->title ?? 'Juego eliminado' }}</h3>
                    <span class="review-date">
                        <i class="far fa-clock"></i> {{ $review->created_at->format('d/m/Y H:i') }}
                    </span>
                </div>
                <div class="review-status">
                    @if($review->status === 'aprobada')
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle"></i> Aprobada
                        </span>
                    @elseif($review->status === 'rechazada')
                        <span class="badge badge-danger">
                            <i class="fas fa-times-circle"></i> Rechazada
                        </span>
                    @else
                        <span class="badge badge-warning">
                            <i class="fas fa-clock"></i> Pendiente
                        </span>
                    @endif
                </div>
            </div>

            <div class="review-card-body">
                <div class="review-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <strong>({{ $review->rating }}/5)</strong>
                </div>

                <p class="review-comment">{{ $review->comment }}</p>

                @if($review->is_verified_purchase)
                    <span class="badge badge-success">
                        <i class="fas fa-check-circle"></i> Compra verificada
                    </span>
                @endif

                @if($review->status === 'rechazada' && $review->rejection_reason)
                <div class="rejection-info">
                    <h4><i class="fas fa-exclamation-triangle"></i> Rechazada</h4>
                    <p><strong>Motivo:</strong> {{ \App\Models\GameReview::getRejectionReasons()[$review->rejection_reason] ?? $review->rejection_reason }}</p>
                    @if($review->moderation_note)
                        <p><strong>Nota:</strong> {{ $review->moderation_note }}</p>
                    @endif
                    @if($review->moderator)
                        <p class="moderator-info">
                            <i class="fas fa-user-shield"></i> Por {{ $review->moderator->name }}
                            el {{ $review->moderated_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                </div>
                @endif
            </div>

            <div class="review-card-footer">
                <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn-review-action btn-view-review" title="Ver historial completo">
                    <i class="fas fa-eye"></i> Ver historial
                </a>

                @if($review->status !== 'pendiente')
                <form method="POST" action="{{ route('admin.reviews.pending', $review->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-review-action btn-pending-review" title="Marcar como pendiente" onclick="return confirm('¿Marcar esta reseña como pendiente?')">
                        <i class="fas fa-clock"></i> Pendiente
                    </button>
                </form>
                @endif

                @if($review->status !== 'aprobada')
                <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-review-action btn-approve-review" title="Aprobar" onclick="return confirm('¿Aprobar esta reseña?')">
                        <i class="fas fa-check"></i> Aprobar
                    </button>
                </form>
                @endif

                @if($review->status !== 'rechazada')
                <button type="button" class="btn-review-action btn-reject-review" title="Rechazar" onclick="openRejectModal({{ $review->id }})">
                    <i class="fas fa-ban"></i> Rechazar
                </button>
                @endif

                <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" style="display: inline;" onsubmit="return confirm('¿Eliminar esta reseña permanentemente?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-review-action btn-delete-review" title="Eliminar">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="no-reviews">
            <i class="fas fa-comments"></i>
            <p>Este usuario no tiene reseñas</p>
        </div>
        @endforelse
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
.reviews-grid {
    display: grid;
    gap: 20px;
    margin-top: 25px;
}

.review-item-card {
    background: #1a1d29;
    border-radius: 12px;
    overflow: hidden;
    border-left: 4px solid #6c63ff;
}

.review-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    background: #252a3a;
    border-bottom: 1px solid #363b4e;
}

.game-title {
    margin: 0 0 8px 0;
    color: #fff;
    font-size: 1.2rem;
}

.review-date {
    color: #888;
    font-size: 0.9rem;
}

.review-card-body {
    padding: 25px;
}

.review-rating {
    color: #ffc107;
    font-size: 1.2rem;
    margin-bottom: 15px;
}

.review-rating strong {
    color: #fff;
    margin-left: 10px;
}

.review-comment {
    color: #ccc;
    line-height: 1.6;
    margin-bottom: 15px;
}

.rejection-info {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    border-radius: 8px;
    padding: 15px;
    margin-top: 15px;
}

.rejection-info h4 {
    color: #ff6b6b;
    margin: 0 0 10px 0;
    font-size: 1rem;
}

.rejection-info p {
    color: #ffb3b3;
    margin: 5px 0;
}

.moderator-info {
    color: #999;
    font-size: 0.85rem;
    margin-top: 10px;
}

.review-card-footer {
    padding: 20px 25px;
    background: #252a3a;
    border-top: 1px solid #363b4e;
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.no-reviews {
    text-align: center;
    padding: 80px 20px;
    color: #888;
}

.no-reviews i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.3;
}

/* Estilos de botones y modal (reutilizados del index) */
.btn-review-action {
    padding: 10px 16px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
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

.btn-pending-review {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
    font-weight: 600;
}

.btn-pending-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
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
</script>

@endsection
