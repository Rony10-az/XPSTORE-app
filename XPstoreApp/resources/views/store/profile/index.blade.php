@extends('layouts.app')

@section('title', 'Mi Perfil - XP Store')

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

            <!-- Avatar Section -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fas fa-camera"></i>
                    Foto de Perfil
                </h2>

                <div class="avatar-section">
                    <div class="avatar-preview">
                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" id="avatarImage">
                        @else
                        <div class="avatar-placeholder">
                            <i class="fas fa-user"></i>
                        </div>
                        @endif
                    </div>

                    <div class="avatar-actions">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $user->name }}">
                            <input type="hidden" name="nickname" value="{{ $user->nickname ?? '' }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">

                            <label for="avatar" class="btn-upload">
                                <i class="fas fa-upload"></i>
                                Cambiar avatar
                            </label>
                            <input type="file" name="avatar" id="avatar" accept="image/*">
                        </form>

                        @if($user->avatar)
                        <form action="{{ route('profile.avatar.delete') }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('¿Eliminar avatar?')">
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                        @endif
                    </div>

                    <p class="avatar-hint">Formatos permitidos: JPG, PNG, WEBP (máx. 2MB)</p>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="profile-card">
                <h2 class="card-title">
                    <i class="fas fa-id-card"></i>
                    Información Personal
                </h2>

                <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user"></i>
                            Nombre Completo
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nickname">
                            <i class="fas fa-at"></i>
                            Apodo / Username (opcional)
                        </label>
                        <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}" placeholder="Ej: GamerPro123">
                        @error('nickname')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Correo Electrónico
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-hint">Se enviará un correo de verificación si cambias tu email</small>
                    </div>

                    <div class="form-group readonly-info">
                        <label>
                            <i class="fas fa-calendar-alt"></i>
                            Miembro desde
                        </label>
                        <div class="readonly-value">
                            {{ $user->created_at->format('d/m/Y') }}
                            <span class="time-badge">{{ $user->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="form-group readonly-info">
                        <label>
                            <i class="fas fa-shield-alt"></i>
                            Rol
                        </label>
                        <div class="readonly-value">
                            <span class="role-badge role-{{ $user->role }}">
                                @if($user->role === 'admin')
                                <i class="fas fa-crown"></i> Administrador
                                @else
                                <i class="fas fa-user"></i> Usuario
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i>
                            Guardar cambios
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
                        <label for="current_password">
                            <i class="fas fa-key"></i>
                            Contraseña Actual
                        </label>
                        <input type="password" name="current_password" id="current_password" required>
                        @error('current_password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Nueva Contraseña
                        </label>
                        <input type="password" name="password" id="password" required>
                        @error('password')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-hint">Mínimo 8 caracteres</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">
                            <i class="fas fa-lock"></i>
                            Confirmar Nueva Contraseña
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save btn-warning">
                            <i class="fas fa-shield-alt"></i>
                            Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- AVATAR --}}
        <div class="avatar-section">
            @php
            $avatar = $user->avatar;

            if ($avatar) {
            $isUrl = Str::startsWith($avatar, ['http://', 'https://']);
            }
            @endphp

            <img class="avatar-img"
                src="{{ $avatar ? ($isUrl ? $avatar : asset('storage/'.$avatar)) : 'https://via.placeholder.com/150' }}"
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

@push('styles')
<style>
    /* Profile Page */
    .profile-page {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem 0;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 3rem;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .profile-header .header-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0;
        background: linear-gradient(135deg, #ffffff, #cbd5e1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: var(--text-secondary);
        margin: 0.5rem 0 0;
    }

    /* Profile Content */
    .profile-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Profile Card */
    .profile-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        padding: 2rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: var(--primary-purple);
    }

    /* Avatar Section */
    .avatar-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid var(--primary-purple);
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
    }

    .avatar-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-upload,
    .btn-delete {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
    }

    .btn-upload {
        background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
        color: white;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.5);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.5);
    }

    .avatar-hint {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin: 0;
    }

    #avatar {
        display: none;
    }

    /* Profile Form */
    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group label i {
        color: var(--primary-purple);
    }

    .form-group input {
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-purple);
        background: rgba(255, 255, 255, 0.08);
    }

    .form-hint {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
        margin-top: 0.25rem;
    }

    .error-message {
        font-size: 0.85rem;
        color: #ef4444;
        margin-top: 0.25rem;
    }

    /* Readonly Info */
    .readonly-info .readonly-value {
        padding: 0.875rem 1rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .time-badge {
        background: rgba(139, 92, 246, 0.2);
        color: var(--primary-purple);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
    }

    .role-admin {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #1f2937;
    }

    .role-user {
        background: linear-gradient(135deg, var(--primary-purple), var(--primary-blue));
        color: white;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .btn-save {
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .btn-warning:hover {
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-page {
            padding: 1rem;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .avatar-actions {
            flex-direction: column;
            width: 100%;
        }

        .btn-upload,
        .btn-delete {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Preview y upload de avatar con AJAX
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validar tamaño (2MB)
            if (file.size > 2048 * 1024) {
                showToast('La imagen es demasiado grande. Máximo 2MB', 'error');
                return;
            }

            // Validar tipo
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                showToast('Formato no válido. Use JPG, PNG, WEBP o GIF', 'error');
                return;
            }

            // Mostrar preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarImage = document.getElementById('avatarImage');
                if (avatarImage) {
                    avatarImage.src = e.target.result;
                } else {
                    // Si no hay imagen, reemplazar el placeholder
                    const avatarPreview = document.querySelector('.avatar-preview');
                    avatarPreview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" id="avatarImage">';
                }

                // Enviar formulario con AJAX después de mostrar preview
                uploadAvatar();
            }
            reader.readAsDataURL(file);
        }
    });

    function uploadAvatar() {
        const form = document.getElementById('avatarForm');
        const formData = new FormData(form);
        const uploadButton = document.querySelector('.btn-upload');
        const originalText = uploadButton.innerHTML;

        // Mostrar estado de carga
        uploadButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subiendo...';
        uploadButton.style.pointerEvents = 'none';

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ||
                        document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Avatar actualizado correctamente', 'success');

                    // Actualizar avatar en el header si existe
                    const headerAvatar = document.querySelector('.user-avatar img');
                    if (headerAvatar && data.avatar_url) {
                        headerAvatar.src = data.avatar_url;
                    }
                } else {
                    showToast(data.message || 'Error al actualizar avatar', 'error');
                }

                uploadButton.innerHTML = originalText;
                uploadButton.style.pointerEvents = 'auto';
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error al subir la imagen', 'error');
                uploadButton.innerHTML = originalText;
                uploadButton.style.pointerEvents = 'auto';
            });
    }
</script>
@endpush