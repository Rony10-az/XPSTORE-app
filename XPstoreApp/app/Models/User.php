<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación: Un usuario tiene muchas reseñas
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relación: Un usuario tiene una biblioteca de juegos
     */
    public function library()
    {
        # return $this->hasMany(LibraryItem::class);
    }

    /**
     * Relación: Un usuario tiene items en su carrito
     */
    public function cartItems()
    {
        #return $this->hasMany(CartItem::class);
    }

    /**
     * Relación: Un usuario tiene notificaciones
     */
    public function notifications()
    {
        #return $this->hasMany(Notification::class);
    }

    /**
     * Relación: Un usuario tiene compras de códigos de streaming
     */
    public function codePurchases()
    {
        #return $this->hasMany(CodePurchase::class);
    }

    /**
     * Relación: Un usuario tiene compras de items del mercado
     */
    public function itemPurchases()
    {
        #return $this->hasMany(ItemPurchase::class);
    }

    /**
     * Relación: Juegos comprados por el usuario
     */
    public function purchasedGames()
    {
        return $this->belongsToMany(VideoGame::class, 'library_items')
            ->withTimestamps()
            ->withPivot(['purchase_date', 'activation_code', 'status']);
    }

    /**
     * Relación: Juegos en el carrito del usuario
     */
    public function gamesInCart()
    {
        return $this->belongsToMany(VideoGame::class, 'cart_items')
            ->withTimestamps()
            ->withPivot(['quantity']);
    }

    /**
     * Scope: Solo administradores
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope: Solo usuarios normales
     */
    public function scopeRegularUsers($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Obtener notificaciones no leídas
     */
    public function unreadNotifications()
    {
        return $this->notifications()->unread();
    }

    /**
     * Obtener el total del carrito
     */
    public function getCartTotal()
    {
        return $this->cartItems->sum(function ($item) {
            return $item->videoGame->final_price * $item->quantity;
        });
    }

    /**
     * Verificar si el usuario tiene un juego en su biblioteca
     */
    public function ownsGame($gameId)
    {
        #return $this->library()
        #->where('video_game_id', $gameId)
        #->where('status', 'active')
        #->exists();
    }
}
