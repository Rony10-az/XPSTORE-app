@extends('layouts.app')

@section('title', 'Crear Publicación')

@push('styles')
@vite(['resources/css/community/create.css'])
@endpush

@section('content')
@php
$tab = $tab ?? 'post';
@endphp

<div class="create-wrapper">

    <div class="create-card">

        {{-- BOTÓN VOLVER --}}
        <a href="{{ route('community.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Volver
        </a>

        {{-- TABS --}}
        <div class="create-tabs">
            <a href="?tab=post" class="create-tab {{ $tab === 'post' ? 'active' : '' }}">📝 Publicación</a>
            <a href="?tab=review" class="create-tab {{ $tab === 'review' ? 'active' : '' }}">⭐ Reseña</a>
            <a href="?tab=help" class="create-tab {{ $tab === 'help' ? 'active' : '' }}">❓ Ayuda</a>
        </div>

        {{-- CONTENIDO DEL TAB --}}
        @if($tab === 'post')
        @include('community.forms.post')
        @elseif($tab === 'review')
        @include('community.forms.review')
        @elseif($tab === 'help')
        @include('community.forms.help')
        @endif

    </div>

</div>

@endsection