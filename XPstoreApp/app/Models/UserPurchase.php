<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'video_game_id',
        'market_item_id',
        'streaming_code_id',
        'price_paid',
        'activation_code'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }
    public function item()
    {
        return $this->morphTo();
    }
    public function marketItem()
    {
        return $this->belongsTo(MarketItem::class, 'market_item_id');
    }

    public function streamingCode()
    {
        return $this->belongsTo(StreamingCode::class, 'streaming_code_id');
    }
    public function getItemAttribute()
    {
        if ($this->videoGame) return $this->videoGame;
        if ($this->marketItem) return $this->marketItem;
        if ($this->streamingCode) return $this->streamingCode;

        return null;
    }

    public function getTypeAttribute()
    {
        if ($this->videoGame) return "Videojuego";
        if ($this->marketItem) return "Marketplace";
        if ($this->streamingCode) return "Streaming";

        return "Desconocido";
    }
}
