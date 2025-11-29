@extends('layouts.app')

@section('title', 'Mi Perfil - XP Store')

@push('styles')
@vite(['resources/css/store/profile.css'])
@endpush

@section('content')
<div class="container">
    <div class="profile-page">

        <!-- Header -->
        <div class="profile-header">
            <div class="header-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1 class="page-title">Mi Perfil</h1>
                <p class="page-subtitle">Administra tu información personal y preferencias</p>
            </div>
        </div>

        <div class="profile-content">

            <!-- Personal profile form (avatar + data) -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fas fa-id-card"></i>
                    Información Personal
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="avatar-section">

                        <div class="avatar-preview">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                            <div class="avatar-placeholder">
                                <i class="fas fa-user"></i>
                            </div>
                            @endif
                        </div>

                        <label for="avatar" class="btn-upload">
                            <i class="fas fa-upload"></i> Cambiar avatar
                        </label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;">
                        <p class="avatar-hint">Formatos: JPG, PNG, WEBP (máx. 2MB)</p>

                        @if($user->avatar)
                        <form action="{{ route('profile.avatar.delete') }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar avatar?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                        @endif

                    </div>

                    <!-- Name -->
                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nickname -->
                    <div class="form-group">
                        <label><i class="fas fa-at"></i> Username (opcional)</label>
                        <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}">
                        @error('nickname') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <!-- Member since -->
                    <div class="form-group readonly-info">
                        <label><i class="fas fa-calendar-alt"></i> Miembro desde</label>
                        <div class="readonly-value">
                            {{ $user->created_at->format('d/m/Y') }}
                            <span class="time-badge">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <!-- Role -->
                    <div class="form-group readonly-info">
                        <label><i class="fas fa-shield-alt"></i> Rol</label>
                        <div class="readonly-value">
                            <span class="role-badge role-{{ $user->role }}">
                                @if($user->role === 'admin')
                                <i class="fas fa-crown"></i> Admin
                                @else
                                <i class="fas fa-user"></i> Usuario
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn-save" type="submit">
                            <i class="fas fa-save"></i> Guardar cambios
                        </button>
                    </div>

                </form>
            </div>

            <!-- Change Password -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fas fa-lock"></i>
                    Seguridad
                </h2>

                <form action="{{ route('profile.password') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label><i class="fas fa-key"></i> Contraseña Actual</label>
                        <input type="password" name="current_password" required>
                        @error('current_password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Nueva Contraseña</label>
                        <input type="password" name="password" required>
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-lock"></i> Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" required>
                    </div>

                    <div class="form-actions">
                        <button class="btn-save btn-warning" type="submit">
                            <i class="fas fa-shield-alt"></i> Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection