{{-- resources/views/admin/videojuegos/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Catálogo de Videojuegos - XP Store')
@section('subtitle', 'Gestiona el catálogo completo de tu tienda')

@section('content')
<div class="admin-container">
    {{-- Header --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-gamepad"></i> Catálogo de Videojuegos</h1>
            <p class="admin-subtitle">Administra el catálogo completo de XP Store</p>
        </div>
        <a href="{{ route('videojuegos.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Nuevo Videojuego
        </a>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Estadísticas --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $videojuegos->total() }}</h3>
            <p class="stat-label">Total Videojuegos</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\VideoGame::where('stock', '>', 0)->count() }}</h3>
            <p class="stat-label">En Stock</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\VideoGame::where('featured', true)->count() }}</h3>
            <p class="stat-label">Destacados</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\VideoGame::where('discount', '>', 0)->count() }}</h3>
            <p class="stat-label">Con Descuento</p>
        </div>
    </div>

    {{-- Herramientas de Búsqueda y Filtros --}}
    <form class="crud-toolbar" method="GET" action="{{ route('videojuegos.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre, desarrollador o publisher...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="platform">
                <option value="">Todas las plataformas</option>
                @foreach($platforms as $platform)
                <option value="{{ $platform }}" {{ request('platform') == $platform ? 'selected' : '' }}>
                    {{ $platform }}
                </option>
                @endforeach
            </select>

            <select class="filter-select" name="genre">
                <option value="">Todos los géneros</option>
                @foreach($genres as $genre)
                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>
                    {{ $genre }}
                </option>
                @endforeach
            </select>

            <select class="filter-select" name="status">
                <option value="">Todos los estados</option>
                <option value="stock" {{ request('status') == 'stock' ? 'selected' : '' }}>En Stock</option>
                <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Sin Stock</option>
                <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Destacados</option>
                <option value="discount" {{ request('status') == 'discount' ? 'selected' : '' }}>Con Descuento</option>
            </select>

            <select class="filter-select" name="sort">
                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Más Recientes</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre (A-Z)</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio (Menor)</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio (Mayor)</option>
                <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Popularidad</option>
                <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock</option>
            </select>

            <button type="submit" class="btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>

            @if(request()->hasAny(['search', 'platform', 'genre', 'status', 'sort']))
            <a href="{{ route('videojuegos.index') }}" class="btn-secondary">
                <i class="fas fa-times"></i> Limpiar
            </a>
            @endif
        </div>
    </form>

    {{-- Tabla --}}
    <div class="crud-table-container">
        <table class="crud-table">
            <thead>
                <tr>
                    <th width="60">ID</th>
                    <th>Videojuego</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Géneros</th>
                    <th>Plataformas</th>
                    <th>Popularidad</th>
                    <th>Estado</th>
                    <th width="140">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videojuegos as $juego)
                <tr>
                    <td class="text-center">#{{ $juego->id }}</td>
                    <td>
                        <div class="game-info">
                            @php
                            $img = $juego->images[0] ?? null;
                            @endphp

                            @if($img)
                            @if(Str::startsWith($img, ['http://', 'https://']))
                            <img src="{{ $img }}" alt="{{ $juego->title }}" class="game-thumb">
                            @else
                            <img src="{{ asset($img) }}" alt="{{ $juego->title }}" class="game-thumb">
                            @endif
                            @else
                            <div class="game-thumb placeholder">
                                <i class="fas fa-gamepad"></i>
                            </div>
                            @endif

                            <div class="game-thumb placeholder">
                                <i class="fas fa-gamepad"></i>
                            </div>

                            <div class="game-details">
                                <strong>{{ $juego->title }}</strong>
                                <span class="game-developer">{{ $juego->developer }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($juego->discount > 0)
                        <div class="price-discounted">
                            <span class="price-old">S/.{{ number_format($juego->price, 2) }}</span>
                            <span class="price-new">S/.{{ number_format($juego->price_after_discount, 2) }}</span>
                            <span class="badge badge-danger">-{{ $juego->discount }}%</span>
                        </div>
                        @else
                        <span class="price-normal">S/.{{ number_format($juego->price, 2) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="stock-display">
                            <span class="stock-count {{ $juego->stock > 0 ? 'has-stock' : 'no-stock' }}">
                                {{ $juego->stock }}
                            </span>
                            @if($juego->stock > 0)
                            <div class="progress">
                                <div class="progress-bar stock-progress"></div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="tags-scrollable">
                            @if(!empty($juego->genre))
                            @foreach($juego->genre as $genero)
                            <span class="badge badge-primary">{{ $genero }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="tags-scrollable">
                            @if(!empty($juego->platform))
                            @foreach($juego->platform as $plataforma)
                            <span class="badge badge-info">{{ $plataforma }}</span>
                            @endforeach
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="popularity-display">
                            <i class="fas fa-fire"></i>
                            <span>{{ number_format($juego->popularity) }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="status-badges">
                            @if($juego->featured)
                            <span class="badge badge-warning">
                                <i class="fas fa-star"></i> Destacado
                            </span>
                            @endif
                            <span class="badge badge-{{ $juego->stock > 0 ? 'success' : 'danger' }}">
                                {{ $juego->stock > 0 ? 'En Stock' : 'Sin Stock' }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('videojuegos.show', $juego->id) }}" class="btn-action btn-view" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('videojuegos.edit', $juego->id) }}" class="btn-action btn-edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('videojuegos.destroy', $juego->id) }}" method="POST" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar este videojuego? Esta acción no se puede deshacer.');">
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
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="fas fa-gamepad"></i>
                            <h4>No hay videojuegos</h4>
                            <p>
                                @if(request()->hasAny(['search', 'platform', 'genre', 'status']))
                                No se encontraron resultados con los filtros aplicados.
                                @else
                                Comienza agregando tu primer videojuego al catálogo.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($videojuegos->hasPages())
    <div class="pagination-wrapper">
        <ul class="pagination">
            @if($videojuegos->onFirstPage())
            <li class="disabled">&laquo;</li>
            @else
            <li><a href="{{ $videojuegos->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @foreach ($videojuegos->getUrlRange(1, $videojuegos->lastPage()) as $page => $url)
            @if ($page == $videojuegos->currentPage())
            <li class="active"><span>{{ $page }}</span></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            @if($videojuegos->hasMorePages())
            <li><a href="{{ $videojuegos->nextPageUrl() }}">&raquo;</a></li>
            @else
            <li class="disabled">&raquo;</li>
            @endif
        </ul>
    </div>
    @endif
</div>

<style>
    .popularity-display {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: #f97316;
        font-weight: 600;
    }

    .popularity-display i {
        color: #f97316;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-secondary);
        border: 1px solid rgba(255, 255, 255, 0.15);
        padding: 0.6rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.25);
        color: white;
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

    /* Contenedor con scroll para géneros y plataformas */
    .tags-scrollable {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        max-height: 100px;
        overflow-y: auto;
        padding: 0.25rem;
        align-items: flex-start;
    }

    .tags-scrollable .badge {
        font-size: 0.7rem;
        padding: 0.25rem 0.55rem;
        white-space: nowrap;
        margin: 0;
        flex-shrink: 0;
        width: fit-content;
    }

    /* Scrollbar personalizado para tags */
    .tags-scrollable::-webkit-scrollbar {
        width: 6px;
    }

    .tags-scrollable::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 3px;
    }

    .tags-scrollable::-webkit-scrollbar-thumb {
        background: rgba(139, 92, 246, 0.5);
        border-radius: 3px;
    }

    .tags-scrollable::-webkit-scrollbar-thumb:hover {
        background: rgba(139, 92, 246, 0.7);
    }

    /* Para Firefox */
    .tags-scrollable {
        scrollbar-width: thin;
        scrollbar-color: rgba(139, 92, 246, 0.5) rgba(255, 255, 255, 0.05);
    }
</style>
@endsection