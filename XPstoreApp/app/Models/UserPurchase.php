<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_game_id',
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
}
