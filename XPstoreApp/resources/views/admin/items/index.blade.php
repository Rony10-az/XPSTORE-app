@extends('layouts.admin')

@section('title', 'Marketplace de Ítems - XP Store')
@section('subtitle', 'Gestiona los ítems de tu marketplace')

@section('content')
<div class="admin-container">
    {{-- Header --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-boxes"></i> Marketplace de Ítems</h1>
            <p class="admin-subtitle">Administra skins, armas, emotes y más</p>
        </div>
        <a href="{{ route('admin.items.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Nuevo Ítem
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
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ $items->total() }}</h3>
            <p class="stat-label">Total Ítems</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\Item::where('stock', '>', 0)->count() }}</h3>
            <p class="stat-label">En Stock</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-crown"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\Item::where('rarity', 'legendario')->count() }}</h3>
            <p class="stat-label">Legendarios</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <h3 class="stat-number">{{ \App\Models\Item::sum('sales_count') }}</h3>
            <p class="stat-label">Ventas Totales</p>
        </div>
    </div>

    {{-- Herramientas de Búsqueda y Filtros --}}
    <form class="crud-toolbar" method="GET" action="{{ route('admin.items.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="type">
                <option value="">Todos los tipos</option>
                @foreach($types as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="rarity">
                <option value="">Todas las rarezas</option>
                @foreach($rarities as $rarity)
                    <option value="{{ $rarity }}" {{ request('rarity') == $rarity ? 'selected' : '' }}>
                        {{ ucfirst($rarity) }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="status">
                <option value="">Todos los estados</option>
                <option value="stock" {{ request('status') == 'stock' ? 'selected' : '' }}>En Stock</option>
                <option value="out" {{ request('status') == 'out' ? 'selected' : '' }}>Sin Stock</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activos</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivos</option>
            </select>

            <select class="filter-select" name="sort">
                <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Más Recientes</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre (A-Z)</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Precio (Menor)</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Precio (Mayor)</option>
                <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stock</option>
                <option value="sales" {{ request('sort') == 'sales' ? 'selected' : '' }}>Más Vendidos</option>
            </select>

            <button type="submit" class="btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>

            @if(request()->hasAny(['search', 'type', 'rarity', 'status', 'sort']))
                <a href="{{ route('admin.items.index') }}" class="btn-secondary">
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
                    <th>Ítem</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Rareza</th>
                    <th>Stock</th>
                    <th>Ventas</th>
                    <th>Estado</th>
                    <th width="140">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="text-center">#{{ $item->id }}</td>
                    <td>
                        <div class="game-info">
                            @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="game-thumb">
                            @else
                            <div class="game-thumb placeholder">
                                <i class="fas {{ $item->type_icon }}"></i>
                            </div>
                            @endif
                            <div class="game-details">
                                <strong>{{ $item->name }}</strong>
                                @if($item->description)
                                    <span class="game-developer">{{ \Illuminate\Support\Str::limit($item->description, 40) }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-secondary">
                            <i class="fas {{ $item->type_icon }}"></i> {{ ucfirst($item->type) }}
                        </span>
                    </td>
                    <td>
                        <span class="price-normal">S/.{{ number_format($item->price, 2) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $item->rarity_color }}">
                            {{ ucfirst($item->rarity) }}
                        </span>
                    </td>
                    <td>
                        <div class="stock-display">
                            <span class="stock-count {{ $item->stock > 0 ? 'has-stock' : 'no-stock' }}">
                                {{ $item->stock }}
                            </span>
                            @if($item->stock > 0)
                            <div class="progress">
                                <div class="progress-bar stock-progress" style="width: {{ min(100, ($item->stock / 50) * 100) }}%"></div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="sales-count">{{ number_format($item->sales_count) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $item->is_active ? 'success' : 'danger' }}">
                            {{ $item->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.items.show', $item->id) }}" class="btn-action btn-view" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn-action btn-edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar este ítem? Esta acción no se puede deshacer.');">
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
                            <i class="fas fa-boxes"></i>
                            <h4>No hay ítems</h4>
                            <p>
                                @if(request()->hasAny(['search', 'type', 'rarity', 'status']))
                                    No se encontraron resultados con los filtros aplicados.
                                @else
                                    Comienza agregando tu primer ítem al marketplace.
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
    @if($items->hasPages())
    <div class="pagination-wrapper">
        <ul class="pagination">
            @if($items->onFirstPage())
            <li class="disabled">&laquo;</li>
            @else
            <li><a href="{{ $items->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
            @if ($page == $items->currentPage())
            <li class="active"><span>{{ $page }}</span></li>
            @else
            <li><a href="{{ $url }}">{{ $page }}</a></li>
            @endif
            @endforeach

            @if($items->hasMorePages())
            <li><a href="{{ $items->nextPageUrl() }}">&raquo;</a></li>
            @else
            <li class="disabled">&raquo;</li>
            @endif
        </ul>
    </div>
    @endif
</div>

<style>
.sales-count {
    color: #10b981;
    font-weight: 600;
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
</style>
@endsection
