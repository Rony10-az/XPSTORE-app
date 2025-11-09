<?php

namespace App\DTOs;

// DTO inmutable de usuario.
readonly class UserDTO
{
    // name, email y hash de contraseña
    public function __construct(
        public string $name,
        public string $email,
        public string $passwordHash
    ) {
    }

    // Retorna datos públicos del usuario
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
