@extends('layouts.app')

@section('title', 'Mi Wishlist')

@push('styles')
@vite(['resources/css/wishlist/index.css'])
@endpush

@section('content')

<div class="container wishlist-container">

    <h1 class="wishlist-title">Mi Lista de Deseos</h1>
    <p class="wishlist-subtitle">Todos tus artículos guardados</p>

    @if($wishlist->isEmpty())
    <p class="empty-message">Aún no agregaste nada a tu wishlist.</p>
    @endif

    <div class="wishlist-grid">
        @foreach ($wishlist as $wish)

        <div class="wishlist-card">

            {{-- Imagen --}}
            <img src="{{ $wish->item->main_image }}" alt="{{ $wish->item->title }}">



            {{-- Nombre --}}
            <h3>{{ $wish->item->title }}</h3>

            {{-- Tipo --}}
            <span class="item-type">{{ class_basename($wish->item_type) }}</span>

            <form action="{{ route('wishlist.remove', $wish->id) }}"
                method="POST"
                class="remove-form">

                @csrf
                <input type="hidden" name="_method" value="DELETE">

                <button type="submit" class="remove-btn">Quitar</button>
            </form>





        </div>

        @endforeach
    </div>

</div>

@endsection