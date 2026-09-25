@extends('layouts.admin')

@section('title', 'Editar Usuario - XP Store')

@section('content')
<div class="admin-container">
    {{-- Preparé este formulario para modificar rol y estado sin salir del estilo actual. --}}
    <div class="admin-header">
        <div class="admin-title">
            <h1><i class="fas fa-user-cog"></i> Editar Usuario</h1>
            <p class="admin-subtitle">Actualiza datos básicos, rol y estado de la cuenta.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <div class="form-card">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="crud-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="role">Rol</label>
                    <select id="role" name="role" class="select">
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                        <option value="user" @selected(old('role', $user->role) === 'user')>Usuario</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Estado</label>
                    <select id="status" name="status" class="select">
                        <option value="active" @selected(old('status', $user->status) === 'active')>Activo</option>
                        <option value="blocked" @selected(old('status', $user->status) === 'blocked')>Bloqueado</option>
                        <option value="pending" @selected(old('status', $user->status) === 'pending')>Pendiente</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
                <a href="{{ route('admin.users.show', $user) }}" class="btn-secondary">
                    <i class="fas fa-eye"></i> Ver perfil
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
