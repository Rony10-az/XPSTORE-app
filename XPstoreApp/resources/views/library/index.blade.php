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
            <span class="badge-count">{{ count($libraryItems) }}</span>
        </h1>
        <p class="subtitle">Todos tus juegos, ítems y códigos en un solo lugar</p>
    </div>

    <div class="library-search">
        <input type="text" placeholder="Buscar en mi biblioteca..." id="searchLibrary">
    </div>

    <div class="library-grid">

        @foreach ($libraryItems as $purchase)

        @php
        // Determinar el modelo asociado
        $item = $purchase->videoGame
        ?? $purchase->marketItem
        ?? $purchase->streamingCode;

        // Determinar tipo
        $type = $purchase->videoGame ? 'Videojuego'
        : ($purchase->marketItem ? 'Ítem de Marketplace'
        : ($purchase->streamingCode ? 'Código Streaming' : 'Desconocido'));

        // Resolver imagen
        $image = $purchase->videoGame ? $item->main_image
        : ($purchase->marketItem ? $item->image
        : ($purchase->streamingCode ? $item->image
        : 'https://via.placeholder.com/400x400?text=Sin+Imagen'));

        // Título del ítem (varía según tipo)
        $title = $purchase->videoGame ? $item->title
        : ($purchase->marketItem ? $item->title
        : ($purchase->streamingCode ? $item->service
        : 'Sin título'));
        @endphp

        <div class="library-card">

            {{-- Imagen --}}
            <div class="library-image">
                <img src="{{ $image }}" alt="{{ $title }}">
                <span class="badge-active">{{ $type }}</span>
            </div>

            {{-- Contenido --}}
            <div class="library-content">

                {{-- Título --}}
                <h2 class="game-title">{{ $title }}</h2>

                {{-- Fecha --}}
                <p class="date">
                    <i class="far fa-calendar-alt"></i>
                    Comprado el {{ $purchase->created_at->format('d \d\e F \d\e\l Y') }}
                </p>

                {{-- Tags (solo videojuegos) --}}
                @if($purchase->videoGame && is_array($item->genre))
                <div class="tags">
                    @foreach($item->genre as $tag)
                    <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Códigos de activación --}}
                @if(isset($purchase->activation_codes) && count($purchase->activation_codes) > 0)
                <div class="code-box">
                    <label>
                        Código{{ count($purchase->activation_codes) > 1 ? 's' : '' }} de activación
                        @if(count($purchase->activation_codes) > 1)
                            <span class="code-count-badge">{{ count($purchase->activation_codes) }} copias</span>
                        @endif
                    </label>

                    @foreach($purchase->activation_codes as $index => $code)
                    <div class="code-row">
                        @if(count($purchase->activation_codes) > 1)
                            <span class="code-number">#{{ $index + 1 }}</span>
                        @endif
                        <input type="text" value="{{ $code }}" readonly class="code-input">
                        <button class="copy-btn" data-code="{{ $code }}">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Plataformas (solo videojuegos) --}}
                @if($purchase->videoGame && is_array($item->platforms))
                <div class="platforms">
                    <label>Disponible en:</label>
                    <div class="platform-list">
                        @foreach($item->platforms as $p)
                        <span class="platform">{{ $p }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <a href="#" class="details-btn">
                    <i class="fas fa-info-circle"></i> Ver detalles
                </a>
            </div>

        </div>

        @endforeach

    </div>
</div>
@endsection