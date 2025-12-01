<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_game_id',
        'title',
        'type',
        'rarity',
        'description',
        'image',
        'price',
        'stock',
        'attributes',
        'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    public function game()
    {
        return $this->belongsTo(VideoGame::class, 'video_game_id');
    }

    /**
     * Obtener la rareza traducida al español
     */
    public function getRaritySpanishAttribute()
    {
        return match($this->rarity) {
            'common' => 'Común',
            'uncommon' => 'Poco Común',
            'rare' => 'Raro',
            'epic' => 'Épico',
            'legendary' => 'Legendario',
            default => ucfirst($this->rarity),
        };
    }

    /**
     * Obtener el color del badge según la rareza
     */
    public function getRarityColorAttribute()
    {
        return match($this->rarity) {
            'common' => 'common',
            'uncommon' => 'uncommon',
            'rare' => 'rare',
            'epic' => 'epic',
            'legendary' => 'legendary',
            default => 'common',
        };
    }

    /**
     * Obtener el tipo traducido al español
     */
    public function getTypeSpanishAttribute()
    {
        return match($this->type) {
            'skin' => 'Skin',
            'weapon' => 'Arma',
            'item' => 'Ítem',
            'bundle' => 'Paquete',
            default => ucfirst($this->type),
        };
    }

    /**
     * Obtener el ícono según el tipo de ítem
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'skin' => 'fa-tshirt',
            'weapon' => 'fa-gun',
            'item' => 'fa-cube',
            'bundle' => 'fa-box',
            default => 'fa-cube',
        };
    }
}
