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
        // Busque el usuario por email.
        $user = User::where('email', $email)->first();

        if (!$user) {
            Log::warning('Login fallido: Usuario no encontrado', ['email' => $email]);
            return null;
        }

        // Bloquee el acceso si el usuario no esta activo.
        if ($user->status !== 'active') {
            Log::warning('Login bloqueado por estado de cuenta', [
                'email' => $email,
                'status' => $user->status,
            ]);
            return null;
        }

        // Verifique la contrasena.
        if (!Hash::check($password, $user->password)) {
            Log::warning('Login fallido: Contrasena incorrecta', ['email' => $email]);
            return null;
        }

        // Autentique al usuario.
        Auth::login($user);

        // Actualice last_login_at aqui para dejar rastreo de la hora exacta de acceso.
        $user->forceFill(['last_login_at' => now()])->save();

        Log::info('Login exitoso', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
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
        // Verifique si el email ya existe.
        if (User::where('email', $email)->exists()) {
            Log::warning('Registro fallido: Email ya registrado', ['email' => $email]);
            throw new \RuntimeException('El correo electronico ya esta registrado');
        }

        // Cree el nuevo usuario.
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'user', // Por defecto es usuario normal.
            'avatar' => null,
        ]);

        // Autentique automaticamente despues del registro.
        Auth::login($user);

        Log::info('Registro exitoso', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return $user;
    }

    /**
     * Cerrar la sesion del usuario autenticado.
     *
     * @return void
     */
    public function logout(): void
    {
        $user = Auth::user();

        if ($user) {
            Log::info('Logout exitoso', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }

        Auth::logout();

        // Regenero el token de sesion para prevenir ataques de fijacion de sesion.
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
