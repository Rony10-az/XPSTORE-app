@extends('layouts.app')

@section('title', 'Streaming Store')

@push('styles')
@vite(['resources/css/streaming/index.css'])
@endpush

@section('content')

<div class="container">

    <h1 class="page-title">Códigos de Streaming</h1>
    <p class="page-subtitle">Compra membresías digitales para tus plataformas favoritas.</p>

    <div class="streaming-grid">

        @foreach ($codes as $code)

        <a href="{{ route('streaming.show', $code) }}" class="streaming-card">
            @php
                $img = $code->image;
                $fallback = 'data:image/svg+xml;utf8,' . rawurlencode(
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 225">'
                    . '<defs><linearGradient id="g" x1="0%" y1="0%" x2="100%" y2="100%">'
                    . '<stop offset="0%" stop-color="#7c3aed"/><stop offset="100%" stop-color="#111827"/></linearGradient></defs>'
                    . '<rect width="400" height="225" rx="24" fill="url(#g)"/>'
                    . '<text x="200" y="120" text-anchor="middle" fill="#fff" font-family="Arial, sans-serif" font-size="48" font-weight="700">HBO Max</text>'
                    . '</svg>'
                );
                if ($img) {
                    $imgSrc = \Illuminate\Support\Str::startsWith($img, ['http://', 'https://', 'data:image'])
                        ? $img
                        : asset('storage/' . ltrim($img, '/'));
                } else {
                    $imgSrc = $fallback;
                }
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $code->service }}" loading="lazy"
                onerror="this.onerror=null;this.src='{{ $fallback }}';">

            <p class="streaming-title">{{ $code->service }}</p>

            <p class="streaming-meta">{{ $code->duration }}</p>

            <p class="streaming-price"> S/.{{ number_format($code->price, 2) }}</p>

            <form action="{{ route('cart.add', $code->id) }}" method="POST" class="streaming-add-form">
                @csrf
                <input type="hidden" name="type" value="streaming_code">
                <button class="streaming-btn">Agregar</button>
            </form>

        </a>

        @endforeach

    </div>

</div>

@endsection
