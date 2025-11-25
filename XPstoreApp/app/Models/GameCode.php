<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameCode extends Model
{
    protected $fillable = [
        'video_game_id',
        'user_id',
        'code',
        'used'
    ];

    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
