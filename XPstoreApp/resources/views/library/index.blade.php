@extends('layouts.app')

@section('title', 'Mis Juegos')

@push('styles')
@vite(['resources/css/library/library.css', 'resources/js/library/library.js'])
@endpush

@section('content')
<div class="page-wrapper">

    <div class="library-header">
        <h1 class="title">
            <i class="fas fa-book"></i> Mi Biblioteca
            <span class="badge-count">{{ is_countable($libraryItems) ? count($libraryItems) : 0 }}</span>
        </h1>
        <p class="subtitle">Todos tus juegos en un solo lugar</p>
    </div>

    <div class="library-search">
        <input type="text" placeholder="Buscar en mi biblioteca..." id="searchLibrary">
    </div>

    <div class="library-grid">

        @foreach($libraryItems as $item)
        <div class="library-card">

            {{-- Imagen --}}
            <div class="library-image">
                <img src="{{ $item->videoGame->image ?? 'https://via.placeholder.com/600x400?text=Sin+Imagen' }}">

                <span class="badge-active">Activo</span>
            </div>

            {{-- Contenido --}}
            <div class="library-content">

                <h2 class="game-title">{{ $item->videoGame->title }}</h2>

                <p class="date">
                    <i class="far fa-calendar-alt"></i>
                    Comprado el {{ $item->created_at->format('d \d\e F \d\e\l Y') }}
                </p>

                {{-- Tags --}}
                <div class="tags">
                    @foreach($item->videoGame->genre as $tag)
                    <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>

                {{-- Código --}}
                <div class="code-box">
                    <label>Código de activación</label>

                    <div class="code-row">
                        <input type="text" value="{{ $item->activation_code }}" readonly class="code-input">
                        <button class="copy-btn" data-code="{{ $item->activation_code }}">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>

                {{-- Plataformas --}}
                <div class="platforms">
                    <label>Disponible en:</label>

                    <div class="platform-list">
                        @foreach(($item->videoGame->platforms ?? []) as $p)
                        <span class="platform">{{ $p }}</span>
                        @endforeach

                    </div>
                </div>

                <a href="#" class="details-btn">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
            </div>

        </div>
        @endforeach
    </div>
</div>

@endsection