@extends('layouts.admin')

@section('title', 'Gestión de Códigos - XP Store')
@section('subtitle', 'Genera, filtra y controla los códigos de activación')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-ticket-alt"></i> Gestión de Códigos</h1>
            <p class="admin-subtitle">Revisa disponibilidad, crea lotes nuevos y depura códigos usados.</p>
        </div>
        <div class="admin-actions">
            <a href="{{ route('admin.gamecodes.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Generar códigos
            </a>
        </div>
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
                <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['total'] }}</h3>
            <p class="stat-label">Total códigos</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-unlock"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['disponibles'] }}</h3>
            <p class="stat-label">Disponibles</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['usados'] }}</h3>
            <p class="stat-label">Usados</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['vencidos'] }}</h3>
            <p class="stat-label">Vencidos</p>
        </div>
    </div>

    <form class="crud-toolbar" method="GET" action="{{ route('admin.gamecodes.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar código o videojuego...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="video_game_id">
                <option value="">Todos los juegos</option>
                @foreach($videoGames as $game)
                    <option value="{{ $game->id }}" @selected(request('video_game_id') == $game->id)>
                        {{ $game->title }}
                    </option>
                @endforeach
            </select>
            <select class="filter-select" name="status">
                <option value="">Todos</option>
                <option value="disponible" @selected(request('status') === 'disponible')>Disponibles</option>
                <option value="usado" @selected(request('status') === 'usado')>Usados</option>
                <option value="vencido" @selected(request('status') === 'vencido')>Vencidos</option>
            </select>
            <button type="submit" class="btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>
        </div>
    </form>

    <div class="crud-table-container">
        <table class="crud-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Código</th>
                    <th>Videojuego</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th width="180">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($codes as $code)
                    <tr>
                        <td class="text-center">#{{ $code->id }}</td>
                        <td><code>{{ $code->code }}</code></td>
                        <td>{{ $code->videoGame->title ?? 'Sin juego' }}</td>
                        <td>
                            <span class="badge badge-{{ $code->statusColor }}">
                                @if($code->status === 'disponible')
                                    <i class="fas fa-check"></i> Disponible
                                @elseif($code->status === 'usado')
                                    <i class="fas fa-ban"></i> Usado
                                @else
                                    <i class="fas fa-clock"></i> Vencido
                                @endif
                            </span>
                        </td>
                        <td>{{ optional($code->created_at)->format('d/m/Y') }}</td>
                        <td class="actions">
                            <div class="action-buttons">
                                <a href="{{ route('admin.gamecodes.show', $code) }}" class="btn-action btn-view" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.gamecodes.edit', $code) }}" class="btn-action btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gamecodes.destroy', $code) }}" method="POST" onsubmit="return confirm('¿Eliminar este código?');">
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
                        <td colspan="6" class="text-center">No hay códigos generados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $codes->links('vendor.pagination.admin') }}
    </div>
</div>
@endsection
