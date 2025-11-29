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

            <img src="{{ $code->image }}" alt="{{ $code->service }}">

            <p class="streaming-title">{{ $code->service }}</p>

            <p class="streaming-meta">{{ $code->duration }}</p>

            <p class="streaming-price">${{ number_format($code->price, 2) }}</p>

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