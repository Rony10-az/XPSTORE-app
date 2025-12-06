<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $video_game_id
 * @property int $rating
 * @property string $title
 * @property string $content
 * @property int $helpful
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\VideoGame $videoGame
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review byRating($rating)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review mostHelpful()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review recent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereHelpful($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Review whereVideoGameId($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'video_game_id',
        'rating',
        'title',
        'content',
        'helpful',
        'is_blocked',
        'warning_message',
        'sentiment',
        'moderated_at',
        'moderated_by',
    ];

    protected $casts = [
        'rating' => 'integer',
        'helpful' => 'integer',
        'is_blocked' => 'boolean',
        'moderated_at' => 'datetime',
    ];

    /**
     * Relación: Una reseña pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Una reseña pertenece a un videojuego
     */
    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }

    /**
     * Relación: Una reseña puede ser moderada por un admin
     */
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    /**
     * Scope: Reseñas ordenadas por útiles
     */
    public function scopeMostHelpful($query)
    {
        return $query->orderBy('helpful', 'desc');
    }

    /**
     * Scope: Reseñas recientes
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope: Reseñas por rating
     */
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
