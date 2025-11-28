@extends('layouts.admin')

@section('title', 'Configuración - XP Store')
@section('subtitle', 'Ajustes básicos del panel')

@section('content')
<div class="admin-container">
    <div class="settings-hero">
        <div class="settings-hero-icon">
            <i class="fas fa-cog"></i>
        </div>
        <div class="settings-hero-text">
            <p class="hero-kicker">Panel XP</p>
            <h1>Configuración</h1>
            <p>Datos básicos de la tienda y correo.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        <div class="settings-grid">
            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon gradient-purple"><i class="fas fa-store"></i></div>
                    <div>
                        <h3>Datos de la tienda</h3>
                        <p class="card-subtitle">Nombre y URL base</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="app_name">Nombre</label>
                    <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $data['app_name']) }}" required>
                    @error('app_name') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="app_url">URL</label>
                    <input type="url" id="app_url" name="app_url" value="{{ old('app_url', $data['app_url']) }}" required>
                    @error('app_url') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="settings-card">
                <div class="card-header">
                    <div class="card-icon gradient-blue"><i class="fas fa-envelope"></i></div>
                    <div>
                        <h3>Correo remitente</h3>
                        <p class="card-subtitle">Nombre y dirección de salida</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mail_from_name">MAIL_FROM_NAME</label>
                    <input type="text" id="mail_from_name" name="mail_from_name" value="{{ old('mail_from_name', $data['mail_from_name']) }}" required>
                    @error('mail_from_name') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="mail_from_address">MAIL_FROM_ADDRESS</label>
                    <input type="email" id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', $data['mail_from_address']) }}" required>
                    @error('mail_from_address') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label for="support_email">Email de soporte</label>
                    <input type="email" id="support_email" name="support_email" value="{{ old('support_email', $data['support_email']) }}">
                    @error('support_email') <p class="text-danger">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="settings-card status-card">
                <div class="card-header">
                    <div class="card-icon gradient-green"><i class="fas fa-headset"></i></div>
                    <div>
                        <h3>Soporte y ayudas</h3>
                        <p class="card-subtitle">Contactos y referencias rápidas</p>
                    </div>
                </div>
                <div class="helper-block">
                    <p><strong>Correo de soporte:</strong> {{ $data['support_email'] ?: 'No definido' }}</p>
                    <p><strong>Documentación Laravel:</strong> <a href="https://laravel.com/docs" target="_blank" rel="noopener">laravel.com/docs</a></p>
                    <p><strong>Logs de la app:</strong> <code>storage/logs/laravel.log</code></p>
                    <p><strong>Backups DB (sugerido):</strong> programa tarea semanal</p>
                </div>
            </div>
        </div>

        <div class="settings-actions">
            <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
