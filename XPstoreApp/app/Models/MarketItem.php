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
}
