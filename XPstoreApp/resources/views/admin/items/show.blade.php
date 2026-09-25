@extends('layouts.admin')

@section('title', 'Detalles del Ítem - XP Store')
@section('subtitle', 'Información completa del ítem')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-cube"></i> Detalles del Ítem</h1>
            <p class="admin-subtitle">Información completa</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.items.edit', $item) }}" class="btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('admin.items.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="details-container">
        <div class="details-grid">
            {{-- Imagen del Ítem --}}
            <div class="detail-card image-card">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="item-image">
                @else
                    <div class="item-image-placeholder">
                        <i class="fas {{ $item->type_icon }} fa-4x"></i>
                        <p>Sin imagen</p>
                    </div>
                @endif
            </div>

            {{-- Información Principal --}}
            <div class="detail-card">
                <h3 class="card-title">Información Principal</h3>
                <div class="detail-row">
                    <span class="detail-label">ID:</span>
                    <span class="detail-value">#{{ $item->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nombre:</span>
                    <span class="detail-value">{{ $item->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tipo:</span>
                    <span class="detail-value">
                        <span class="badge badge-secondary">
                            <i class="fas {{ $item->type_icon }}"></i> {{ ucfirst($item->type) }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Rareza:</span>
                    <span class="detail-value">
                        <span class="badge badge-{{ $item->rarity_color }}">
                            {{ ucfirst($item->rarity) }}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span class="detail-value">
                        <span class="badge badge-{{ $item->is_active ? 'success' : 'danger' }}">
                            {{ $item->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </span>
                </div>
            </div>

            {{-- Inventario y Ventas --}}
            <div class="detail-card">
                <h3 class="card-title">Inventario y Ventas</h3>
                <div class="detail-row">
                    <span class="detail-label">Precio:</span>
                    <span class="detail-value price">S/.{{ number_format($item->price, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Stock Actual:</span>
                    <span class="detail-value">
                        <span class="stock-count {{ $item->stock > 0 ? 'has-stock' : 'no-stock' }}">
                            {{ $item->stock }} unidades
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ventas Totales:</span>
                    <span class="detail-value sales">{{ number_format($item->sales_count) }}</span>
                </div>
            </div>

            {{-- Descripción --}}
            @if($item->description)
            <div class="detail-card full-width">
                <h3 class="card-title">Descripción</h3>
                <p class="detail-description">{{ $item->description }}</p>
            </div>
            @endif

            {{-- Fechas --}}
            <div class="detail-card">
                <h3 class="card-title">Fechas</h3>
                <div class="detail-row">
                    <span class="detail-label">Creado:</span>
                    <span class="detail-value">{{ $item->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Actualizado:</span>
                    <span class="detail-value">{{ $item->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="actions-footer">
            <form action="{{ route('admin.items.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este ítem? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i> Eliminar Ítem
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.details-container {
    margin-top: 2rem;
}

.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.detail-card {
    background: #1a1d29;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #2a2d3a;
}

.detail-card.image-card {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
}

.detail-card.full-width {
    grid-column: 1 / -1;
}

.item-image {
    max-width: 100%;
    max-height: 400px;
    border-radius: 8px;
    object-fit: contain;
}

.item-image-placeholder {
    text-align: center;
    color: #8b92a7;
}

.item-image-placeholder i {
    margin-bottom: 1rem;
    opacity: 0.3;
}

.card-title {
    color: #fff;
    font-size: 1.1rem;
    margin: 0 0 1.5rem 0;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #2a2d3a;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #8b92a7;
    font-size: 0.9rem;
}

.detail-value {
    color: #fff;
    font-weight: 500;
}

.detail-value.price {
    color: #10b981;
    font-size: 1.2rem;
    font-weight: 600;
}

.detail-value.sales {
    color: #3b82f6;
    font-weight: 600;
}

.detail-description {
    color: #b8beca;
    line-height: 1.6;
    margin: 0;
}

.actions-footer {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #2a2d3a;
}

.btn-danger {
    background: #dc3545;
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
    background: #c82333;
    transform: translateY(-2px);
}
</style>
@endsection
