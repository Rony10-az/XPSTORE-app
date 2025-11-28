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
            <h3 class="stat-number">{{ $metrics['available'] }}</h3>
            <p class="stat-label">Disponibles</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['used'] }}</h3>
            <p class="stat-label">Usados</p>
        </div>
    </div>

    <form class="crud-toolbar" method="GET" action="{{ route('admin.gamecodes.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar código o videojuego...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="video_game_id">
                <option value="">Todos los juegos</option>
                @foreach($videoGames as $game)
                    <option value="{{ $game->id }}" @selected(optional($videojuego)->id === $game->id)>
                        {{ $game->title }}
                    </option>
                @endforeach
            </select>
            <select class="filter-select" name="status">
                <option value="">Todos</option>
                <option value="available" @selected($status === 'available')>Disponibles</option>
                <option value="used" @selected($status === 'used')>Usados</option>
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
                            @if($code->used)
                                <span class="badge badge-danger"><i class="fas fa-ban"></i> Usado</span>
                            @else
                                <span class="badge badge-success"><i class="fas fa-check"></i> Disponible</span>
                            @endif
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
        {{ $codes->links() }}
    </div>
</div>
@endsection
