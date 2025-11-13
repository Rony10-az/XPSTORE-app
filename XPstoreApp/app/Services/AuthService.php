<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

// Servicio de autenticación.
class AuthService
{
    // Inyecta repositorio de usuarios
    public function __construct(private readonly UserRepositoryInterface $users) {}

    // Autentica y retorna UserDTO o null
    public function attempt(string $email, string $password): ?UserDTO
    {
        Log::info('Intento de login catch in auth service', ['email' => $email]);
        $user = $this->users->findByEmail($email);
        Log::info('Intento de login catch in auth service', ['email' => $user]);

        if (!$user) {
            return null;
        }

        if (!Hash::check($password, $user->passwordHash)) {
            return null;
        }

        $this->login($user);
        return $user;
    }

    // Registra un usuario y retorna el UserDTO
    public function register(string $name, string $email, string $password): UserDTO
    {
        if ($this->users->exists($email)) {
            throw new \RuntimeException('Email already registered');
        }

        $hash = Hash::make($password);
        $user = new UserDTO(name: $name, email: $email, passwordHash: $hash);
        $created = $this->users->create($user);
        $this->login($created);
        return $created;
    }

    // Guarda datos mínimos en la sesión
    private function login(UserDTO $user): void
    {
        Session::put('user', $user->toArray());
        Session::regenerate();
    }

    // Cierra sesión
    public function logout(): void
    {
        Session::forget('user');
        Session::invalidate();
        Session::regenerateToken();
    }
}
