<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_game_id',
        'code',
        'used'
    ];

    // RELACIÓN INVERSA: Un código pertenece a un videojuego
    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }
}
