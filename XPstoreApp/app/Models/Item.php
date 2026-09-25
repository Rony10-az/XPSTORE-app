<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'price',
        'rarity',
        'stock',
        'image',
        'description',
        'is_active',
        'sales_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock' => 'integer',
        'sales_count' => 'integer',
    ];

    /**
     * Obtener el color del badge según la rareza
     */
    public function getRarityColorAttribute()
    {
        return match($this->rarity) {
            'común' => 'secondary',
            'poco común' => 'success',
            'raro' => 'info',
            'épico' => 'warning',
            'legendario' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Obtener el ícono según el tipo de ítem
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'skin' => 'fa-tshirt',
            'arma' => 'fa-gun',
            'emote' => 'fa-smile',
            'moneda' => 'fa-coins',
            'pase' => 'fa-ticket-alt',
            default => 'fa-cube',
        };
    }
}
