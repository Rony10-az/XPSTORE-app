@extends('layouts.admin')

@section('title', 'Usuarios y Comentarios - XP Store')
@section('subtitle', 'Gestiona usuarios y modera sus comentarios')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-users"></i> Usuarios y Comentarios</h1>
            <p class="admin-subtitle">Gestiona usuarios y modera sus comentarios en tiempo real.</p>
        </div>
        <a href="{{ route('admin.reviews.index') }}" class="btn-primary">
            <i class="fas fa-arrow-left"></i> Volver a Reseñas
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $metrics['total'] }}</h3>
            <p class="stat-label">Total Usuarios</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $metrics['admins'] }}</h3>
            <p class="stat-label">Administradores</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-user-lock"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $metrics['blocked'] }}</h3>
            <p class="stat-label">Bloqueados</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $metrics['recent'] }}</h3>
            <p class="stat-label">Altas últimos 7 días</p>
        </div>
    </div>

    <form class="crud-toolbar user-toolbar" method="GET" action="{{ route('admin.users.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar nombre o email...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="role">
                <option value="">Todos los roles</option>
                <option value="admin" @selected($role === 'admin')>Admins</option>
                <option value="user" @selected($role === 'user')>Usuarios</option>
            </select>
            <select class="filter-select" name="status">
                <option value="">Todos los estados</option>
                <option value="active" @selected($status === 'active')>Activos</option>
                <option value="blocked" @selected($status === 'blocked')>Bloqueados</option>
                <option value="pending" @selected($status === 'pending')>Pendientes</option>
            </select>
            <select class="filter-select" name="sort">
                <option value="recent" @selected($sort === 'recent')>Más recientes</option>
                <option value="last_login" @selected($sort === 'last_login')>Último acceso</option>
            </select>
            <button type="submit" class="btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </div>
    </form>

    <div class="users-comments-container">
        @forelse($users as $user)
            <div class="user-comment-card">
                <div class="user-card-header">
                    <div class="user-info">
                        @php
                            $avatar = $user->avatar ?? null;
                            if ($avatar) {
                                $avatarUrl = \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://', 'data:image'])
                                    ? $avatar
                                    : asset('storage/' . ltrim($avatar, '/'));
                            }
                            $initial = strtoupper(mb_substr($user->name, 0, 1));
                        @endphp
                        <div class="user-avatar">
                            @if($avatar ?? false)
                                <img src="{{ $avatarUrl }}" alt="{{ $user->name }}">
                            @else
                                {{ $initial }}
                            @endif
                        </div>
                        <div class="user-details">
                            <h3>{{ $user->name }}</h3>
                            <p class="user-email">{{ $user->email }}</p>
                            <div class="user-meta">
                                <span class="badge badge-{{ $user->role === 'admin' ? 'info' : 'secondary' }}">{{ ucfirst($user->role) }}</span>
                                @php
                                    $statusClass = [
                                        'active' => 'badge-success',
                                        'blocked' => 'badge-danger',
                                        'pending' => 'badge-warning',
                                    ][$user->status] ?? 'badge-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ ucfirst($user->status) }}</span>
                                <span class="badge badge-light">
                                    <i class="fas fa-comments"></i> {{ $user->reviews->count() }} comentarios
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="user-actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit" title="Editar usuario">
                            <i class="fas fa-user-edit"></i>
                        </a>
                        @if($user->reviews->count() > 0)
                            <button class="btn-action btn-view toggle-comments" data-user-id="{{ $user->id }}">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        @endif
                    </div>
                </div>

                @if($user->reviews->count() > 0)
                    <div class="comments-list" id="comments-{{ $user->id }}" style="display: none;">
                        @foreach($user->reviews as $review)
                            <div class="comment-item {{ $review->is_blocked ? 'blocked' : '' }}">
                                <div class="comment-header">
                                    <div class="comment-meta">
                                        <span class="game-name">
                                            <i class="fas fa-gamepad"></i>
                                            {{ $review->videoGame->title ?? 'Juego eliminado' }}
                                        </span>
                                        <span class="comment-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'filled' : '' }}"></i>
                                            @endfor
                                            {{ $review->rating }}/5
                                        </span>
                                        <span class="comment-date">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if($review->is_blocked)
                                        <span class="badge badge-danger">
                                            <i class="fas fa-ban"></i> Bloqueado
                                        </span>
                                    @endif
                                </div>

                                <div class="comment-content">
                                    <h4>{{ $review->title }}</h4>
                                    <p>{{ $review->content }}</p>
                                </div>

                                @if($review->warning_message)
                                    <div class="warning-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Advertencia:</strong> {{ $review->warning_message }}
                                    </div>
                                @endif

                                <div class="comment-moderation">
                                    <div class="sentiment-selector">
                                        <label>Sentimiento:</label>
                                        <form action="{{ route('admin.reviews.sentiment', $review) }}" method="POST" class="inline-form">
                                            @csrf
                                            <select name="sentiment" onchange="this.form.submit()" class="sentiment-select {{ $review->sentiment }}">
                                                <option value="">Sin clasificar</option>
                                                <option value="bueno" @selected($review->sentiment === 'bueno')>Bueno</option>
                                                <option value="medio" @selected($review->sentiment === 'medio')>Medio</option>
                                                <option value="malo" @selected($review->sentiment === 'malo')>Malo</option>
                                            </select>
                                        </form>
                                    </div>

                                    <div class="moderation-actions">
                                        <button class="btn-warning btn-sm" onclick="toggleWarningForm({{ $review->id }})">
                                            <i class="fas fa-exclamation-circle"></i> Advertencia
                                        </button>

                                        <form action="{{ route('admin.reviews.toggleBlock', $review) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @if($review->is_blocked)
                                                <button type="submit" class="btn-success btn-sm">
                                                    <i class="fas fa-check"></i> Desbloquear
                                                </button>
                                            @else
                                                <button type="submit" class="btn-danger btn-sm">
                                                    <i class="fas fa-ban"></i> Bloquear
                                                </button>
                                            @endif
                                        </form>

                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar este comentario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="warning-form" id="warning-form-{{ $review->id }}" style="display: none;">
                                    <form action="{{ route('admin.reviews.warning', $review) }}" method="POST">
                                        @csrf
                                        <textarea name="warning_message" rows="3" placeholder="Escribe el mensaje de advertencia..." required>{{ $review->warning_message }}</textarea>
                                        <div class="form-actions">
                                            <button type="submit" class="btn-primary btn-sm">
                                                <i class="fas fa-save"></i> Guardar Advertencia
                                            </button>
                                            <button type="button" class="btn-secondary btn-sm" onclick="toggleWarningForm({{ $review->id }})">
                                                Cancelar
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @if($review->moderated_at)
                                    <div class="moderation-info">
                                        <i class="fas fa-info-circle"></i>
                                        Moderado por {{ $review->moderator->name ?? 'Admin' }} el {{ $review->moderated_at->format('d/m/Y H:i') }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-users"></i>
                <h4>No hay usuarios registrados</h4>
                <p>Cuando se registren aparecerán aquí para gestionarlos.</p>
            </div>
        @endforelse
    </div>

    @if($users->hasPages())
    <div class="pagination-wrapper">
        <ul class="pagination">
            @if($users->onFirstPage())
            <li class="disabled">&laquo;</li>
            @else
            <li><a href="{{ $users->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
            <li class="active"><span>{{ $page }}</span></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            @if($users->hasMorePages())
            <li><a href="{{ $users->nextPageUrl() }}">&raquo;</a></li>
            @else
            <li class="disabled">&raquo;</li>
            @endif
        </ul>
    </div>
    @endif
</div>

<style>
.users-comments-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-top: 2rem;
}

.user-comment-card {
    background: #1a1d29;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #2a2d3a;
}

.user-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    background: #20232e;
    border-bottom: 1px solid #2a2d3a;
}

.user-info {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex: 1;
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    color: white;
    overflow: hidden;
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-details h3 {
    margin: 0;
    font-size: 1.2rem;
    color: #fff;
}

.user-email {
    margin: 0.25rem 0;
    color: #8b92a7;
    font-size: 0.9rem;
}

.user-meta {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.user-actions {
    display: flex;
    gap: 0.5rem;
}

.toggle-comments {
    transition: transform 0.3s;
}

.toggle-comments.active {
    transform: rotate(180deg);
}

.comments-list {
    padding: 1rem;
    background: #1a1d29;
}

.comment-item {
    background: #20232e;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    border: 1px solid #2a2d3a;
}

.comment-item.blocked {
    border-color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.comment-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    align-items: center;
}

.game-name {
    color: #667eea;
    font-weight: 600;
}

.comment-rating {
    color: #ffc107;
}

.comment-rating .fa-star.filled {
    color: #ffc107;
}

.comment-rating .fa-star:not(.filled) {
    color: #4a4d5a;
}

.comment-date {
    color: #8b92a7;
    font-size: 0.9rem;
}

.comment-content h4 {
    margin: 0 0 0.5rem 0;
    color: #fff;
    font-size: 1.1rem;
}

.comment-content p {
    margin: 0;
    color: #b8beca;
    line-height: 1.6;
}

.warning-message {
    background: rgba(255, 193, 7, 0.1);
    border-left: 3px solid #ffc107;
    padding: 0.75rem 1rem;
    margin-top: 1rem;
    border-radius: 4px;
    color: #ffc107;
}

.comment-moderation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #2a2d3a;
    flex-wrap: wrap;
    gap: 1rem;
}

.sentiment-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sentiment-selector label {
    color: #8b92a7;
    font-size: 0.9rem;
}

.sentiment-select {
    background: #2a2d3a;
    color: #fff;
    border: 1px solid #3a3d4a;
    padding: 0.5rem;
    border-radius: 6px;
    font-size: 0.9rem;
}

.sentiment-select.bueno {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.1);
}

.sentiment-select.medio {
    border-color: #ffc107;
    background: rgba(255, 193, 7, 0.1);
}

.sentiment-select.malo {
    border-color: #dc3545;
    background: rgba(220, 53, 69, 0.1);
}

.moderation-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}

.warning-form {
    margin-top: 1rem;
    padding: 1rem;
    background: rgba(255, 193, 7, 0.05);
    border-radius: 6px;
}

.warning-form textarea {
    width: 100%;
    background: #2a2d3a;
    color: #fff;
    border: 1px solid #3a3d4a;
    padding: 0.75rem;
    border-radius: 6px;
    font-family: inherit;
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.moderation-info {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #2a2d3a;
    color: #8b92a7;
    font-size: 0.85rem;
}

.inline-form {
    display: inline;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #8b92a7;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state h4 {
    color: #fff;
    margin-bottom: 0.5rem;
}
</style>

<script>
document.querySelectorAll('.toggle-comments').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.dataset.userId;
        const commentsList = document.getElementById('comments-' + userId);

        if (commentsList.style.display === 'none') {
            commentsList.style.display = 'block';
            this.classList.add('active');
        } else {
            commentsList.style.display = 'none';
            this.classList.remove('active');
        }
    });
});

function toggleWarningForm(reviewId) {
    const form = document.getElementById('warning-form-' + reviewId);
    if (form.style.display === 'none') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection
