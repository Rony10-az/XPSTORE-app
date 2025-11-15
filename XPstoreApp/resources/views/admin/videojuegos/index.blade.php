{{-- resources/views/admin/videojuegos/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Gestión de Videojuegos - XP Store')

@section('content')
<div class="admin-container">
    {{-- Header --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-gamepad"></i> Gestión de Videojuegos</h1>
            <p class="admin-subtitle">Administra el catálogo completo de XP Store</p>
        </div>
        <a href="{{ route('admin.videojuegos.create') }}" class="btn-primary">
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
            <h3 class="stat-number">{{ $videojuegos->where('stock', '>', 0)->count() }}</h3>
            <p class="stat-label">En Stock</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $videojuegos->where('featured', true)->count() }}</h3>
            <p class="stat-label">Destacados</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-percent"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $videojuegos->where('discount', '>', 0)->count() }}</h3>
            <p class="stat-label">Con Descuento</p>
        </div>
    </div>

    {{-- Herramientas --}}
    <div class="crud-toolbar">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Buscar videojuegos...">
        </div>

        <select class="filter-select" id="statusFilter">
            <option value="">Todos los estados</option>
            <option value="stock">En Stock</option>
            <option value="out">Sin Stock</option>
            <option value="featured">Destacados</option>
            <option value="discount">Con Descuento</option>
        </select>
    </div>

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
                    <th>Rating</th>
                    <th>Estado</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($videojuegos as $juego)
                <tr>
                    <td class="text-center">#{{ $juego->id }}</td>
                    <td>
                        <div class="game-info">
                            @if(!empty($juego->images))
                            <img src="{{ asset('storage/' . $juego->images[0]) }}" alt="{{ $juego->title }}" class="game-thumb">
                            @else
                            <div class="game-thumb placeholder">
                                <i class="fas fa-gamepad"></i>
                            </div>
                            @endif
                            <div class="game-details">
                                <strong>{{ $juego->title }}</strong>
                                <span class="game-developer">{{ $juego->developer }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($juego->discount > 0)
                        <div class="price-discounted">
                            <span class="price-old">${{ number_format($juego->price, 2) }}</span>
                            <span class="price-new">${{ number_format($juego->price * (1 - $juego->discount/100), 2) }}</span>
                            <span class="badge badge-danger">-{{ $juego->discount }}%</span>
                        </div>
                        @else
                        <span class="price-normal">${{ number_format($juego->price, 2) }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="stock-display">
                            <span class="stock-count {{ $juego->stock > 0 ? 'has-stock' : 'no-stock' }}">
                                {{ $juego->stock }}
                            </span>
                            @if($juego->stock > 0)
                            <div class="progress">
                                <div class="progress-bar stock-progress" data-stock="{{ $juego->stock }}"></div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if(!empty($juego->genre))
                        @foreach(array_slice($juego->genre, 0, 2) as $genero)
                        <span class="badge badge-primary">{{ $genero }}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        @if(!empty($juego->platform))
                        @foreach(array_slice($juego->platform, 0, 2) as $plataforma)
                        <span class="badge badge-info">{{ $plataforma }}</span>
                        @endforeach
                        @endif
                    </td>
                    <td>
                        <div class="rating-display">
                            <i class="fas fa-star"></i>
                            <span>{{ number_format($juego->rating, 1) }}</span>
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
                            <a href="{{ route('admin.videojuegos.show', $juego->id) }}" class="btn-action btn-view" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.videojuegos.edit', $juego->id) }}" class="btn-action btn-edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.videojuegos.destroy', $juego->id) }}" method="POST" class="delete-form">
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
                            <h4>No hay videojuegos registrados</h4>
                            <p>Comienza agregando tu primer videojuego al catálogo</p>
                            <a href="{{ route('admin.videojuegos.create') }}" class="btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Juego
                            </a>
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
            {{-- Página anterior --}}
            @if($videojuegos->onFirstPage())
            <li class="disabled">&laquo;</li>
            @else
            <li><a href="{{ $videojuegos->previousPageUrl() }}">&laquo;</a></li>
            @endif

            {{-- Números de página --}}
            @foreach ($videojuegos->getUrlRange(1, $videojuegos->lastPage()) as $page => $url)
            @if ($page == $videojuegos->currentPage())
            <li class="active"><span>{{ $page }}</span></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            {{-- Página siguiente --}}
            @if($videojuegos->hasMorePages())
            <li><a href="{{ $videojuegos->nextPageUrl() }}">&raquo;</a></li>
            @else
            <li class="disabled">&raquo;</li>
            @endif
        </ul>
    </div>
    @endif

</div>
@endsection