<?php

namespace App\Repositories;

use App\DTOs\UserDTO;

// Interfaz del repositorio de usuarios.
interface UserRepositoryInterface
{
    // Buscar por email
    public function findByEmail(string $email): ?UserDTO;

    // Crear usuario
    public function create(UserDTO $user): UserDTO;

    // Existe email?
    public function exists(string $email): bool;
}
