@extends('layouts.admin')

@section('title', 'Detalle de Usuario - XP Store')

@section('content')
<div class="admin-container">
    {{-- Organicé este detalle para ver rápido el estado de la cuenta. --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-id-card"></i> Perfil de {{ $user->name }}</h1>
            <p class="admin-subtitle">Resumen completo del usuario y su estado.</p>
        </div>
        <div class="action-buttons">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-primary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="user-detail-grid">
        <div class="detail-card">
            <div class="detail-header">
                <div class="user-avatar lg">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                <div>
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
            <div class="detail-body">
                <div class="detail-row">
                    <span class="label">Rol</span>
                    <span class="value"><span class="badge badge-info">{{ ucfirst($user->role) }}</span></span>
                </div>
                <div class="detail-row">
                    <span class="label">Estado</span>
                    @php
                        $statusClass = [
                            'active' => 'badge-success',
                            'blocked' => 'badge-danger',
                            'pending' => 'badge-warning',
                        ][$user->status] ?? 'badge-secondary';
                    @endphp
                    <span class="value"><span class="badge {{ $statusClass }}">{{ ucfirst($user->status) }}</span></span>
                </div>
                <div class="detail-row">
                    <span class="label">Verificación</span>
                    <span class="value">
                        @if($user->email_verified_at)
                        <span class="badge badge-success">Email verificado</span>
                        @else
                        <span class="badge badge-warning">Pendiente</span>
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Registrado</span>
                    {{-- De nuevo uso optional() por si algún usuario legacy no tiene timestamps. --}}
                    <span class="value">{{ optional($user->created_at)->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Último acceso</span>
                    <span class="value">{{ optional($user->last_login_at)->format('d/m/Y H:i') ?? '—' }}</span>
                </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <h3>Acciones rápidas</h3>
                <p>Editar o eliminar la cuenta.</p>
            </div>
            <div class="detail-body actions-stack">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-primary w-100">
                    <i class="fas fa-edit"></i> Editar usuario
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form w-100">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger w-100">
                        <i class="fas fa-trash"></i> Eliminar usuario
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
