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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
