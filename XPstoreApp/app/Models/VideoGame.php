<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoGame extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'images',
        'genre',
        'platform',
        'release_date',
        'developer',
        'publisher',
        'rating',
        'stock',
        'featured',
        'requirements',
    ];

    protected $casts = [
        'images' => 'array',
        'genre' => 'array',
        'platform' => 'array',
        'requirements' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'featured' => 'boolean',
        'release_date' => 'date',
    ];

    /**
     * Relación: Un juego tiene muchas reseñas
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Relación: Un juego puede estar en muchas bibliotecas
     */
    public function libraryItems()
    {
        #return $this->hasMany(LibraryItem::class);
    }

    /**
     * Relación: Un juego puede estar en muchos carritos
     */
    public function cartItems()
    {
        #return $this->hasMany(CartItem::class);
    }

    /**
     * Relación: Usuarios que compraron este juego
     */
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'library_items')
            ->withTimestamps()
            ->withPivot(['purchase_date', 'activation_code', 'status']);
    }

    /**
     * Scope: Juegos destacados
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope: Juegos con descuento
     */
    public function scopeOnSale($query)
    {
        return $query->where('discount', '>', 0);
    }

    /**
     * Scope: Juegos disponibles (con stock)
     */
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Accessor: Precio con descuento aplicado
     */
    public function getFinalPriceAttribute()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * ($this->discount / 100));
        }
        return $this->price;
    }

    /**
     * Accessor: Verificar si está en oferta
     */
    public function getIsOnSaleAttribute()
    {
        return $this->discount > 0;
    }

    /**
     * Accessor: Verificar si está disponible
     */
    public function getIsAvailableAttribute()
    {
        return $this->stock > 0;
    }
}
