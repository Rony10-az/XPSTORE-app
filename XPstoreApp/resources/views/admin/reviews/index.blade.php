@extends('layouts.admin')

@section('title', 'Gestión de Reseñas - XP Store')
@section('subtitle', 'Modera comentarios y calificaciones de la comunidad')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-star-half-alt"></i> Gestión de Reseñas</h1>
            <p class="admin-subtitle">Revisa, filtra y elimina reseñas con baja calidad o reportes.</p>
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
                <div class="stat-icon"><i class="fas fa-comments"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['total'] }}</h3>
            <p class="stat-label">Total reseñas</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
            </div>
            <h3 class="stat-number">{{ number_format($metrics['avg_rating'], 1) }}</h3>
            <p class="stat-label">Rating promedio</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-flag"></i></div>
            </div>
            <h3 class="stat-number">{{ $metrics['low_ratings'] }}</h3>
            <p class="stat-label">Con rating ≤ 2</p>
        </div>
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon"><i class="fas fa-thumbs-up"></i></div>
            </div>
            <h3 class="stat-number">
                {{ optional($metrics['most_helpful'])->helpful ?? 0 }}
            </h3>
            <p class="stat-label">Más útiles (votos)</p>
        </div>
    </div>

    <form class="crud-toolbar" method="GET" action="{{ route('admin.reviews.index') }}">
        <div class="toolbar-left">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Buscar usuario, juego o título...">
            </div>
        </div>
        <div class="toolbar-right">
            <select class="filter-select" name="rating">
                <option value="">Todos los ratings</option>
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" @selected($rating == $i)>{{ $i }} estrellas</option>
                @endfor
            </select>
            <select class="filter-select" name="sort">
                <option value="recent" @selected($sort === 'recent')>Más recientes</option>
                <option value="high_rating" @selected($sort === 'high_rating')>Mejor rating</option>
                <option value="helpful" @selected($sort === 'helpful')>Más útiles</option>
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
                    <th>Usuario</th>
                    <th>Juego</th>
                    <th>Rating</th>
                    <th>Contenido</th>
                    <th>Útil</th>
                    <th>Fecha</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr>
                        <td class="text-center">#{{ $review->id }}</td>
                        <td>
                            <div class="user-info">
                                <div class="user-details">
                                    <p class="user-name">{{ $review->user->name ?? 'Usuario eliminado' }}</p>
                                    <p class="user-email">{{ $review->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $review->videoGame->title ?? 'Juego eliminado' }}</td>
                        <td>
                            <div class="rating-stars">
                                <i class="fas fa-star"></i> {{ $review->rating }}/5
                            </div>
                        </td>
                        <td>
                            <p class="table-title">{{ \Illuminate\Support\Str::limit($review->title, 60) }}</p>
                            <p class="table-subtitle">{{ \Illuminate\Support\Str::limit($review->content, 90) }}</p>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-thumbs-up"></i> {{ $review->helpful ?? 0 }}
                        </td>
                        <td>{{ optional($review->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('¿Eliminar esta reseña?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay reseñas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
