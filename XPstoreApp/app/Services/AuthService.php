<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthService
{
    /**
     * Intentar autenticar un usuario con email y password.
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function attempt(string $email, string $password): ?User
    {
        // Buscar el usuario por email
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning('Login fallido: Usuario no encontrado', ['email' => $email]);
            return null;
        }

        // Verificar la contraseña
        if (!Hash::check($password, $user->password)) {
            Log::warning('Login fallido: Contraseña incorrecta', ['email' => $email]);
            return null;
        }

        // Autenticar al usuario
        Auth::login($user);

        Log::info('Login exitoso', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role
        ]);

        return $user;
    }

    /**
     * Registrar un nuevo usuario.
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     * @throws \RuntimeException
     */
    public function register(string $name, string $email, string $password): User
    {
        // Verificar si el email ya existe
        if (User::where('email', $email)->exists()) {
            Log::warning('Registro fallido: Email ya registrado', ['email' => $email]);
            throw new \RuntimeException('El correo electrónico ya está registrado');
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user', // Por defecto es usuario normal
            'avatar' => null,
        ]);

        // Autenticar automáticamente después del registro
        Auth::login($user);

        Log::info('Registro exitoso', [
            'user_id' => $user->id,
            'email' => $user->email
        ]);

        return $user;
    }

    /**
     * Cerrar la sesión del usuario autenticado.
     *
     * @return void
     */
    public function logout(): void
    {
        $user = Auth::user();

        if ($user) {
            Log::info('Logout exitoso', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        }

        Auth::logout();

        // Regenerar el token de sesión para prevenir ataques de fijación de sesión
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }

    /**
     * Obtener el usuario autenticado.
     *
     * @return User|null
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Verificar si hay un usuario autenticado.
     *
     * @return bool
     */
    public function check(): bool
    {
        return Auth::check();
    }
}
