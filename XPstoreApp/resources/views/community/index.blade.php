@extends('layouts.app')

@push('styles')
@vite(['resources/css/community/community.css'])
@endpush

@section('content')



{{-- HERO --}}
<div class="community-hero">
    <h1>Comunidad Gamer</h1>
    <p>Comparte tus experiencias, descubre jugadores y forma parte de la comunidad.</p>

    <div class="community-stats">
        <div class="stat">
            <span class="num">1,234</span>
            <span>Usuarios activos</span>
        </div>

        <div class="stat">
            <span class="num">5,678</span>
            <span>Reseñas</span>
        </div>

        <div class="stat">
            <span class="num">820</span>
            <span>Posts/mes</span>
        </div>
    </div>

    <a href="{{ route('community.create') }}" class="post-btn">Crear Publicación</a>
</div>


{{-- CONTENIDO PRINCIPAL --}}
<div class="community-layout">

    {{-- COLUMNA IZQUIERDA → FEED --}}
    <div class="community-main">

        {{-- TABS DE FILTROS --}}
        <div class="community-tabs">
            <a href="{{ route('community.index') }}"
                class="tab {{ !$filter ? 'active' : '' }}">Todo</a>

            <a href="{{ route('community.index', ['type' => 'review']) }}"
                class="tab {{ $filter === 'review' ? 'active' : '' }}">Reseñas</a>

            <a href="{{ route('community.index', ['type' => 'screenshot']) }}"
                class="tab {{ $filter === 'screenshot' ? 'active' : '' }}">Capturas</a>

            <a href="{{ route('community.index', ['type' => 'help']) }}"
                class="tab {{ $filter === 'help' ? 'active' : '' }}">Ayuda</a>
        </div>

        {{-- FEED --}}
        <div class="feed-container">
            @forelse($posts as $post)
            @include('community._post-card', ['post' => $post])
            @empty
            <p class="empty-message">No hay publicaciones todavía.</p>
            @endforelse
        </div>

        {{-- PAGINACIÓN --}}
        <div class="pagination-box">
            {{ $posts->links() }}
        </div>

    </div>


    {{-- COLUMNA DERECHA → SIDEBAR --}}
    <aside class="community-sidebar">

        {{-- JUEGOS POPULARES --}}
        <div class="sidebar-card">
            <h3 class="sidebar-title">🎮 Juegos populares</h3>

            <ul class="sidebar-list">
                <li><i class="fas fa-fire"></i> Cyberpunk Odyssey</li>
                <li><i class="fas fa-fire"></i> Dragonfall Legends</li>
                <li><i class="fas fa-fire"></i> Pixel Frontier</li>
                <li><i class="fas fa-fire"></i> Mecha Strike</li>
            </ul>
        </div>

        {{-- USUARIOS DESTACADOS --}}
        <div class="sidebar-card">
            <h3 class="sidebar-title">🏆 Jugadores Destacados</h3>

            <div class="user-badges">
                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=12" alt="">
                    <span>JuanXP</span>
                </div>

                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=23" alt="">
                    <span>LeyendaRPG</span>
                </div>

                <div class="user-item">
                    <img src="https://i.pravatar.cc/100?img=34" alt="">
                    <span>FireNova</span>
                </div>
            </div>
        </div>

    </aside>

</div>

@endsection