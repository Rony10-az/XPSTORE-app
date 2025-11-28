<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
