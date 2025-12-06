@extends('layouts.admin')

@section('title', 'Detalle del Código - XP Store')
@section('subtitle', 'Información completa del código de activación')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-ticket-alt"></i> {{ $gamecode->code }}</h1>
            <p class="admin-subtitle">Detalles completos del código</p>
        </div>
        <div class="admin-actions">
            <a href="{{ route('admin.gamecodes.edit', $gamecode) }}" class="btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.gamecodes.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="details-grid">
        {{-- Información Básica --}}
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <h3>Información Básica</h3>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="label">ID:</span>
                    <span class="value">#{{ $gamecode->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Código:</span>
                    <span class="value"><code>{{ $gamecode->code }}</code></span>
                </div>
                <div class="detail-row">
                    <span class="label">Estado:</span>
                    <span class="value">
                        <span class="badge badge-{{ $gamecode->statusColor }}">
                            @if($gamecode->status === 'disponible')
                                <i class="fas fa-check"></i> Disponible
                            @elseif($gamecode->status === 'usado')
                                <i class="fas fa-ban"></i> Usado
                            @else
                                <i class="fas fa-clock"></i> Vencido
                            @endif
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Lote:</span>
                    <span class="value">{{ $gamecode->batch ?? 'Sin lote' }}</span>
                </div>
            </div>
        </div>

        {{-- Información del Videojuego --}}
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-gamepad"></i>
                <h3>Videojuego</h3>
            </div>
            <div class="card-body">
                @if($gamecode->videoGame)
                    <div class="detail-row">
                        <span class="label">Título:</span>
                        <span class="value">{{ $gamecode->videoGame->title }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Precio:</span>
                        <span class="value">S/. {{ number_format($gamecode->videoGame->price, 2) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Plataforma:</span>
                        <span class="value">{{ $gamecode->videoGame->platform }}</span>
                    </div>
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('admin.videojuegos.show', $gamecode->videoGame) }}" class="btn-link">
                            <i class="fas fa-eye"></i> Ver videojuego
                        </a>
                    </div>
                @else
                    <p class="text-muted">No hay videojuego asociado</p>
                @endif
            </div>
        </div>

        {{-- Información de Uso --}}
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-user-check"></i>
                <h3>Información de Uso</h3>
            </div>
            <div class="card-body">
                @if($gamecode->status === 'usado' && $gamecode->user)
                    <div class="detail-row">
                        <span class="label">Usuario:</span>
                        <span class="value">{{ $gamecode->user->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Email:</span>
                        <span class="value">{{ $gamecode->user->email }}</span>
                    </div>
                    @if($gamecode->used_at)
                    <div class="detail-row">
                        <span class="label">Fecha de uso:</span>
                        <span class="value">{{ $gamecode->used_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                    @endif
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('admin.users.show', $gamecode->user) }}" class="btn-link">
                            <i class="fas fa-user"></i> Ver usuario
                        </a>
                    </div>
                @else
                    <p class="text-muted">Este código aún no ha sido usado</p>
                @endif
            </div>
        </div>

        {{-- Fechas --}}
        <div class="detail-card">
            <div class="card-header">
                <i class="fas fa-calendar"></i>
                <h3>Fechas</h3>
            </div>
            <div class="card-body">
                <div class="detail-row">
                    <span class="label">Creado:</span>
                    <span class="value">{{ $gamecode->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Actualizado:</span>
                    <span class="value">{{ $gamecode->updated_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @if($gamecode->used_at)
                <div class="detail-row">
                    <span class="label">Usado:</span>
                    <span class="value">{{ $gamecode->used_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Acciones --}}
    <div class="action-panel">
        <h3><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
        <div class="action-buttons">
            @if($gamecode->status === 'disponible')
                <form action="{{ route('admin.gamecodes.markUsed', $gamecode) }}" method="POST" onsubmit="return confirm('¿Marcar este código como usado?');">
                    @csrf
                    <button type="submit" class="btn-warning">
                        <i class="fas fa-ban"></i> Marcar como Usado
                    </button>
                </form>
                <form action="{{ route('admin.gamecodes.markExpired', $gamecode) }}" method="POST" onsubmit="return confirm('¿Marcar este código como vencido?');">
                    @csrf
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-clock"></i> Marcar como Vencido
                    </button>
                </form>
            @endif
            <form action="{{ route('admin.gamecodes.destroy', $gamecode) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este código? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i> Eliminar Código
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-card {
    background: #1a1d29;
    border-radius: 12px;
    border: 1px solid #2a2d3a;
    overflow: hidden;
}

.card-header {
    background: #0f172a;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #2a2d3a;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header i {
    color: #8b5cf6;
    font-size: 1.2rem;
}

.card-header h3 {
    margin: 0;
    font-size: 1rem;
    color: #cbd5e1;
    font-weight: 600;
}

.card-body {
    padding: 1.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #2a2d3a;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-row .label {
    color: #8b92a7;
    font-size: 0.9rem;
    font-weight: 500;
}

.detail-row .value {
    color: #cbd5e1;
    font-size: 0.95rem;
    font-weight: 500;
    text-align: right;
}

.detail-row code {
    background: #0f172a;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-family: 'Courier New', monospace;
    color: #8b5cf6;
}

.text-muted {
    color: #64748b;
    font-style: italic;
}

.btn-link {
    color: #8b5cf6;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.btn-link:hover {
    color: #a78bfa;
    text-decoration: underline;
}

.action-panel {
    background: #1a1d29;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #2a2d3a;
}

.action-panel h3 {
    margin: 0 0 1rem 0;
    font-size: 1rem;
    color: #cbd5e1;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.action-panel i {
    color: #8b5cf6;
}

.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.btn-warning {
    background: #f59e0b;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-danger {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.95rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-danger:hover {
    background: #dc2626;
}
</style>
@endsection
