<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $video_game_id
 * @property string $code
 * @property int $used
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\VideoGame $videoGame
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameCode whereVideoGameId($value)
 * @mixin \Eloquent
 */
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
