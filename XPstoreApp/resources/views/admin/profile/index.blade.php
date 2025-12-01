@extends('layouts.admin')

@section('title', 'Mi Perfil')
@section('subtitle', 'Administra tu información personal y configuración')

@section('content')
<style>
.profile-container {
    max-width: 1400px;
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert i {
    font-size: 1.25rem;
}

.profile-grid {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 2rem;
}

/* Sidebar */
.profile-sidebar {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.profile-card {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.profile-avatar-section {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    text-align: center;
}

.profile-avatar-img,
.profile-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    border: 4px solid rgba(255, 255, 255, 0.3);
}

.profile-avatar-img {
    object-fit: cover;
}

.profile-avatar-placeholder {
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: white;
}

.avatar-actions {
    margin-top: 1rem;
}

.btn-delete-avatar {
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    transition: background 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-delete-avatar:hover {
    background: rgba(220, 38, 38, 0.9);
}

.profile-info {
    padding: 2rem;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #f1f5f9;
    margin: 0 0 0.5rem;
}

.profile-email {
    color: #94a3b8;
    margin: 0 0 1rem;
}

.profile-role {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.profile-meta {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.meta-item i {
    color: #8b5cf6;
    font-size: 1.1rem;
}

.meta-item > div {
    display: flex;
    flex-direction: column;
}

.meta-label {
    font-size: 0.8rem;
    color: #64748b;
}

.meta-value {
    font-size: 0.9rem;
    color: #e2e8f0;
    font-weight: 500;
}

/* Formularios */
.profile-main {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-card {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95));
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.form-card-header {
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.03);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.form-card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #f1f5f9;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-card-title i {
    color: #8b5cf6;
}

.form-card-body {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: #cbd5e1;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-label i {
    color: #64748b;
    font-size: 0.9rem;
}

.form-input,
.form-input-file {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(255, 255, 255, 0.05);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    font-size: 0.95rem;
    color: #e2e8f0;
    transition: all 0.3s;
}

.form-input:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.08);
    border-color: #8b5cf6;
    box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
}

.form-input.is-invalid {
    border-color: #ef4444;
}

.form-input-file {
    padding: 0.5rem;
}

.form-hint {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.85rem;
    color: #64748b;
}

.form-error {
    display: block;
    margin-top: 0.5rem;
    color: #f87171;
    font-size: 0.85rem;
    font-weight: 500;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Información del rol */
.role-info {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.role-badge {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 12px;
    border: 2px solid rgba(102, 126, 234, 0.2);
}

.role-badge i {
    font-size: 2rem;
    color: #667eea;
}

.role-badge > div {
    display: flex;
    flex-direction: column;
}

.role-label {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.role-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #f1f5f9;
}

.role-description {
    color: #cbd5e1;
    line-height: 1.6;
    margin: 0;
}

.role-permissions h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #e2e8f0;
    margin: 0 0 1rem;
}

.role-permissions ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.role-permissions li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #94a3b8;
}

.role-permissions li i {
    color: #10b981;
    font-size: 0.9rem;
}

@media (max-width: 1024px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }

    .profile-sidebar {
        position: relative;
        top: 0;
    }
}
</style>

<div class="profile-container">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="profile-grid">
        {{-- Sidebar con información básica --}}
        <div class="profile-sidebar">
            <div class="profile-card">
                <div class="profile-avatar-section">
                    @php
                        $avatar = $admin->avatar;
                        if ($avatar) {
                            $avatarUrl = \Illuminate\Support\Str::startsWith($avatar, ['http://', 'https://', 'data:image'])
                                ? $avatar
                                : asset('storage/' . ltrim($avatar, '/'));
                        }
                    @endphp
                    @if($avatar ?? false)
                        <img src="{{ $avatarUrl }}" alt="{{ $admin->name }}" class="profile-avatar-img">
                    @else
                        <div class="profile-avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                    @endif

                    @if($admin->avatar)
                        <form action="{{ route('admin.profile.avatar.delete') }}" method="POST" class="avatar-actions">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete-avatar" onclick="return confirm('¿Estás seguro de eliminar tu foto de perfil?')">
                                <i class="fas fa-trash"></i>
                                Eliminar foto
                            </button>
                        </form>
                    @endif
                </div>

                <div class="profile-info">
                    <h2 class="profile-name">{{ $admin->name }}</h2>
                    <p class="profile-email">{{ $admin->email }}</p>

                    <div class="profile-role">
                        <i class="fas fa-crown"></i>
                        <span>Administrador</span>
                    </div>

                    <div class="profile-meta">
                        @if($admin->created_at)
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <span class="meta-label">Miembro desde</span>
                                <span class="meta-value">{{ $admin->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        @endif
                        @if($admin->last_login_at)
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <span class="meta-label">Último acceso</span>
                                <span class="meta-value">{{ $admin->last_login_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Formularios de edición --}}
        <div class="profile-main">
            {{-- Datos básicos --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fas fa-user-edit"></i>
                        Datos Básicos
                    </h3>
                </div>
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="form-card-body">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Nombre completo
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input @error('name') is-invalid @enderror"
                            value="{{ old('name', $admin->name) }}"
                            required
                        >
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Correo electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') is-invalid @enderror"
                            value="{{ old('email', $admin->email) }}"
                            required
                        >
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="avatar" class="form-label">
                            <i class="fas fa-image"></i>
                            Foto de perfil
                        </label>
                        <input
                            type="file"
                            id="avatar"
                            name="avatar"
                            class="form-input-file @error('avatar') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                        >
                        <small class="form-hint">JPG, PNG, GIF o WEBP. Máximo 2MB.</small>
                        @error('avatar')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            {{-- Cambiar contraseña --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fas fa-lock"></i>
                        Cambiar Contraseña
                    </h3>
                </div>
                <form action="{{ route('admin.profile.password') }}" method="POST" class="form-card-body">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-key"></i>
                            Contraseña actual
                        </label>
                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            class="form-input @error('current_password') is-invalid @enderror"
                            required
                        >
                        @error('current_password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Nueva contraseña
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') is-invalid @enderror"
                            required
                        >
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock"></i>
                            Confirmar nueva contraseña
                        </label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            required
                        >
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shield-alt"></i>
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>

            {{-- Información del rol --}}
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fas fa-shield-alt"></i>
                        Información del Rol
                    </h3>
                </div>
                <div class="form-card-body">
                    <div class="role-info">
                        <div class="role-badge">
                            <i class="fas fa-crown"></i>
                            <div>
                                <span class="role-label">Rol actual</span>
                                <span class="role-value">Administrador</span>
                            </div>
                        </div>
                        <p class="role-description">
                            Como administrador, tienes acceso completo a todas las funciones del sistema,
                            incluyendo la gestión de productos, usuarios, códigos y configuración de la tienda.
                        </p>
                        <div class="role-permissions">
                            <h4>Permisos:</h4>
                            <ul>
                                <li><i class="fas fa-check"></i> Gestión de catálogo de videojuegos</li>
                                <li><i class="fas fa-check"></i> Administración de códigos de juego</li>
                                <li><i class="fas fa-check"></i> Moderación de reseñas</li>
                                <li><i class="fas fa-check"></i> Gestión de usuarios</li>
                                <li><i class="fas fa-check"></i> Configuración del sistema</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
