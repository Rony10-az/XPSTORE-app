@extends('layouts.app')

@section('title', 'Configuración')

@push('styles')
@vite(['resources/css/user/settings.css'])
@endpush

@section('content')

<div class="container">

    <h1 class="page-title">Configuración</h1>

    <div class="settings-box">

        <a href="{{ route('profile.index') }}" class="settings-item">
            <i class="fas fa-user-cog"></i>
            <span>Editar Perfil</span>
        </a>

        <a href="{{ route('password.change') }}" class="settings-item">
            <i class="fas fa-lock"></i>
            <span>Cambiar Contraseña</span>
        </a>

        <a href="{{ route('notifications.settings') }}" class="settings-item">
            <i class="fas fa-bell"></i>
            <span>Notificaciones</span>
        </a>

        <a href="{{ route('privacy.settings') }}" class="settings-item">
            <i class="fas fa-shield-alt"></i>
            <span>Privacidad</span>
        </a>

    </div>

</div>

@endsection