@extends('layouts.admin')

@section('title', 'Gestión de Usuarios - XP Store')
@section('subtitle', 'Controla cuentas, roles y estados en tiempo real')

@section('content')
<div class="admin-container">
    {{-- Armé esta cabecera para mantener el mismo layout que la gestión de juegos. --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
            <p class="admin-subtitle">Controla cuentas registradas, roles y estados en tiempo real.</p>
        </div>
    </div>

    {{-- Alertas --}}
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

    {{-- Estadísticas --}}
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

    {{-- Herramientas --}}
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

    {{-- Tabla --}}
    <div class="crud-table-container">
        <table class="crud-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Registrado</th>
                    <th>Último acceso</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="text-center">#{{ $user->id }}</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</div>
                            <div class="user-details">
                                <strong>{{ $user->name }}</strong>
                                <div class="email-cell">
                                    {{-- Encapsulé el email para truncarlo y alinear mejor el badge. --}}
                                    <span class="email-text">{{ $user->email }}</span>
                                    @if($user->email_verified_at)
                                    <span class="badge badge-success">Verificado</span>
                                    @else
                                    <span class="badge badge-warning">Sin verificar</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        @php
                            $statusClass = [
                                'active' => 'badge-success',
                                'blocked' => 'badge-danger',
                                'pending' => 'badge-warning',
                            ][$user->status] ?? 'badge-secondary';
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ ucfirst($user->status) }}</span>
                    </td>
                    <td>
                        {{-- Usé optional() para evitar fallas si algún registro viejo no tiene timestamps. --}}
                        <span class="cell-muted">{{ optional($user->created_at)->format('d/m/Y H:i') ?? '—' }}</span>
                    </td>
                    <td>
                        <span class="cell-muted">{{ optional($user->last_login_at)->format('d/m/Y H:i') ?? '—' }}</span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-action btn-view" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h4>No hay usuarios registrados</h4>
                            <p>Cuando se registren aparecerán aquí para gestionarlos.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
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
@endsection