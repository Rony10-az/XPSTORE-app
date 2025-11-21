@extends('layouts.app')

@section('title', 'Mi Perfil')

@vite(['resources/css/store/Profile.css', 'resources/js/store/profile.js'])

@section('content')

<div class="profile-wrapper">

    <h2 class="profile-title">Mi Perfil</h2>

    {{-- Mensajes --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
        @endforeach
    </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- AVATAR --}}
        <div class="avatar-section">
            <img class="avatar-img"
                src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://via.placeholder.com/150' }}"
                alt="Avatar">

            <label class="avatar-label">Cambiar avatar</label>
            <input type="file" name="avatar" class="file-input">
        </div>

        {{-- NOMBRE --}}
        <div class="input-group">
            <label>Nombre</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        {{-- EMAIL --}}
        <div class="input-group">
            <label>Email</label>
            <input type="text" value="{{ $user->email }}" disabled>
        </div>

        <button class="btn-save">Guardar cambios</button>
    </form>

</div>

@endsection