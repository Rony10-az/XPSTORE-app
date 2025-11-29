@extends('layouts.app')

@section('title', 'Mis Compras')

@push('styles')
@vite(['resources/css/user/purchases.css'])
@endpush

@section('content')

<div class="container">

    <h1 class="page-title">Mis Compras</h1>

    @if($purchases->isEmpty())
    <p class="empty-message">Aún no has comprado nada.</p>
    @else

    <div class="purchase-list">

        @foreach($purchases as $purchase)
        <div class="purchase-item">

            <img src="{{ $purchase->videoGame->first_image }}" class="purchase-img">

            <div class="purchase-info">
                <h3>{{ $purchase->videoGame->title }}</h3>
                <p>Precio pagado: ${{ number_format($purchase->price_paid, 2) }}</p>
                <p>Fecha: {{ $purchase->created_at->format('d M Y') }}</p>
            </div>

        </div>
        @endforeach

    </div>

    @endif

</div>

@endsection