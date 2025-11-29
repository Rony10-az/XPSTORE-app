<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
        // Sumé status y last_login_at para exponerlos en la administración.
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        // Añadí last_login_at para poder mostrar la última sesión en administración.
        'last_login_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function purchasedGames()
    {
        return $this->belongsToMany(VideoGame::class, 'library_items')
            ->withTimestamps()
            ->withPivot(['purchase_date', 'activation_code', 'status']);
    }

    public function gamesInCart()
    {
        return $this->belongsToMany(VideoGame::class, 'cart_items')
            ->withTimestamps()
            ->withPivot(['quantity']);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
