<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use Illuminate\Support\Facades\Hash;

// Repositorio en memoria (demo)
class InMemoryUserRepository implements UserRepositoryInterface
{
    /** @var UserDTO[] Lista interna */
    private array $users = [];

    // Usuario de demo
    public function __construct()
    {
        $this->users[] = new UserDTO(
            name: 'Admin',
            email: 'admin@example.com',
            passwordHash: Hash::make('secret')
        );
    }

    // Buscar por email
    public function findByEmail(string $email): ?UserDTO
    {
        foreach ($this->users as $user) {
            if ($user->email === $email) {
                return $user;
            }
        }

        return null;
    }

    // Crear usuario
    public function create(UserDTO $user): UserDTO
    {
        $this->users[] = $user;
        return $user;
    }

    // Existe email?
    public function exists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }
}
