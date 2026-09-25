@extends('layouts.admin')

@section('title', 'Detalle de Reseña - XP Store')
@section('subtitle', 'Ver información completa y historial de moderación')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-file-alt"></i> Detalle de Reseña #{{ $review->id }}</h1>
            <p class="admin-subtitle">Información completa de la reseña y su historial de moderación</p>
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

    <div class="content-grid">
        {{-- COLUMNA IZQUIERDA: DATOS DE LA RESEÑA --}}
        <div class="review-details-card">
            <div class="card-header">
                <h3><i class="fas fa-comment-alt"></i> Datos de la Reseña</h3>
            </div>

            <div class="card-body">
                <div class="detail-row">
                    <span class="detail-label">Usuario:</span>
                    <span class="detail-value">
                        {{ $review->user->name }}
                        <small style="color: #888;">({{ $review->user->email }})</small>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Juego:</span>
                    <span class="detail-value">{{ $review->videoGame->title }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Calificación:</span>
                    <span class="detail-value">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star" style="color: #ffc107;"></i>
                            @else
                                <i class="far fa-star" style="color: #888;"></i>
                            @endif
                        @endfor
                        <strong>({{ $review->rating }}/5)</strong>
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Comentario:</span>
                </div>
                <div class="comment-box">
                    {{ $review->comment }}
                </div>

                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span class="detail-value">
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
                    </span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Compra verificada:</span>
                    <span class="detail-value">
                        @if($review->is_verified_purchase)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i> Sí
                            </span>
                        @else
                            <span class="badge badge-secondary">No</span>
                        @endif
                    </span>
                </div>

                @if($review->rejection_reason)
                <div class="detail-row">
                    <span class="detail-label">Motivo de rechazo:</span>
                    <span class="detail-value">
                        <span class="badge badge-danger">
                            {{ \App\Models\GameReview::getRejectionReasons()[$review->rejection_reason] ?? $review->rejection_reason }}
                        </span>
                    </span>
                </div>
                @endif

                @if($review->moderation_note)
                <div class="detail-row">
                    <span class="detail-label">Nota de moderación:</span>
                </div>
                <div class="comment-box" style="background: #2a3142;">
                    {{ $review->moderation_note }}
                </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Fecha de creación:</span>
                    <span class="detail-value">{{ $review->created_at->format('d/m/Y H:i:s') }}</span>
                </div>

                @if($review->moderated_at)
                <div class="detail-row">
                    <span class="detail-label">Fecha de moderación:</span>
                    <span class="detail-value">{{ $review->moderated_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @endif

                @if($review->moderator)
                <div class="detail-row">
                    <span class="detail-label">Moderado por:</span>
                    <span class="detail-value">{{ $review->moderator->name }}</span>
                </div>
                @endif
            </div>

            {{-- ACCIONES RÁPIDAS --}}
            <div class="card-footer">
                <h4 style="margin-bottom: 15px;">Acciones rápidas</h4>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @if($review->status !== 'pendiente')
                    <form method="POST" action="{{ route('admin.reviews.pending', $review->id) }}">
                        @csrf
                        <button type="submit" class="btn-pending" onclick="return confirm('¿Marcar esta reseña como pendiente?')">
                            <i class="fas fa-clock"></i> Pendiente
                        </button>
                    </form>
                    @endif

                    @if($review->status !== 'aprobada')
                    <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}">
                        @csrf
                        <button type="submit" class="btn-success" onclick="return confirm('¿Aprobar esta reseña?')">
                            <i class="fas fa-check"></i> Aprobar
                        </button>
                    </form>
                    @endif

                    @if($review->status !== 'rechazada')
                    <button type="button" class="btn-warning" onclick="openRejectModal({{ $review->id }})">
                        <i class="fas fa-ban"></i> Rechazar
                    </button>
                    @endif

                    <form method="POST" action="{{ route('admin.reviews.destroy', $review->id) }}" onsubmit="return confirm('¿Eliminar permanentemente esta reseña?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: HISTORIAL DE MODERACIÓN --}}
        <div class="history-card">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Historial de Moderación</h3>
            </div>

            <div class="card-body">
                @if($review->moderationHistory->count() > 0)
                    <div class="timeline">
                        @foreach($review->moderationHistory->sortByDesc('created_at') as $history)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <strong>{{ $history->admin->name }}</strong>
                                    <span class="timeline-action">
                                        {{ \App\Models\ReviewModerationHistory::getActionLabels()[$history->action] ?? $history->action }}
                                    </span>
                                </div>

                                <div class="timeline-meta">
                                    <i class="far fa-clock"></i>
                                    {{ $history->created_at->format('d/m/Y H:i:s') }}
                                    <small>({{ $history->created_at->diffForHumans() }})</small>
                                </div>

                                @if($history->previous_status || $history->new_status)
                                <div class="timeline-status">
                                    Estado:
                                    @if($history->previous_status)
                                        <span class="badge badge-secondary">{{ ucfirst($history->previous_status) }}</span>
                                    @endif
                                    <i class="fas fa-arrow-right" style="margin: 0 5px;"></i>
                                    @if($history->new_status)
                                        <span class="badge badge-{{ $history->new_status === 'aprobada' ? 'success' : ($history->new_status === 'rechazada' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($history->new_status) }}
                                        </span>
                                    @endif
                                </div>
                                @endif

                                @if($history->rejection_reason)
                                <div class="timeline-reason">
                                    <strong>Motivo:</strong>
                                    {{ \App\Models\ReviewModerationHistory::getRejectionReasons()[$history->rejection_reason] ?? $history->rejection_reason }}
                                </div>
                                @endif

                                @if($history->note)
                                <div class="timeline-note">
                                    <i class="fas fa-sticky-note"></i>
                                    {{ $history->note }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-history">
                        <i class="fas fa-history"></i>
                        <p>No hay historial de moderación</p>
                        <small>Esta reseña aún no ha sido moderada</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MODAL PARA RECHAZAR RESEÑA (igual que en index) --}}
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
.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-top: 25px;
}

@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}

.review-details-card, .history-card {
    background: #1a1d29;
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    background: #252a3a;
    padding: 20px 25px;
    border-bottom: 2px solid #363b4e;
}

.card-header h3 {
    margin: 0;
    color: #fff;
    font-size: 1.2rem;
}

.card-body {
    padding: 25px;
}

.card-footer {
    padding: 20px 25px;
    border-top: 1px solid #363b4e;
    background: #252a3a;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #252a3a;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #888;
    font-weight: 500;
    flex-shrink: 0;
}

.detail-value {
    color: #fff;
    text-align: right;
    flex-grow: 1;
    margin-left: 15px;
}

.comment-box {
    background: #252a3a;
    padding: 15px;
    border-radius: 8px;
    color: #ccc;
    line-height: 1.6;
    margin-top: 10px;
    margin-bottom: 15px;
}

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #363b4e;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #6c63ff;
    border: 3px solid #1a1d29;
    z-index: 1;
}

.timeline-content {
    background: #252a3a;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #6c63ff;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.timeline-header strong {
    color: #fff;
}

.timeline-action {
    color: #6c63ff;
    font-weight: 600;
    font-size: 0.9rem;
}

.timeline-meta {
    color: #888;
    font-size: 0.85rem;
    margin-bottom: 10px;
}

.timeline-status {
    margin: 10px 0;
    color: #ccc;
}

.timeline-reason {
    margin: 10px 0;
    padding: 10px;
    background: #1a1d29;
    border-radius: 6px;
    color: #ccc;
}

.timeline-note {
    margin-top: 10px;
    padding: 10px;
    background: #1a1d29;
    border-radius: 6px;
    color: #aaa;
    font-style: italic;
}

.no-history {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}

.no-history i {
    font-size: 3rem;
    margin-bottom: 15px;
    opacity: 0.3;
}

/* Modal (igual que index) */
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

/* Botón Pendiente */
.btn-pending {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-pending:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
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
