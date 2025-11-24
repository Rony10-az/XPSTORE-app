@extends('layouts.app')

@section('title', 'Pago Exitoso')
@push('styles')
@vite(['resources/css/checkout/success.css'])
@endpush
@section('content')

<div class="success-wrapper">

    <div class="success-card">

        <div class="icon-circle">
            <i class="fas fa-check"></i>
        </div>

        <h1 class="success-title">¡Pago realizado con éxito!</h1>

        <p class="success-text">
            Gracias por tu compra. Tus juegos ya están disponibles en tu biblioteca.
        </p>

        <a href="#" class="success-button">
            <i class="fas fa-gamepad"></i> Ir a Mis Juegos
        </a>

    </div>

</div>

@endsection