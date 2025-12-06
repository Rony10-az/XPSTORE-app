<?php

namespace App\Repositories;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserDTO
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return null;
        }

        return new UserDTO(
            name: $user->name,
            email: $user->email,
            passwordHash: $user->password
        );
    }

    public function create(UserDTO $user): UserDTO
    {
        $created = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->passwordHash,
        ]);

        return new UserDTO(
            name: $created->name,
            email: $created->email,
            passwordHash: $created->password
        );
    }

    public function exists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
