<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameReview extends Model
{
    protected $fillable = [
        'user_id',
        'video_game_id',
        'rating',
        'comment',
        'is_verified_purchase',
        'status',
        'rejection_reason',
        'moderation_note',
        'moderated_at',
        'moderated_by'
    ];

    protected $casts = [
        'is_verified_purchase' => 'boolean',
        'moderated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el videojuego
    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }

    // Relación con el moderador
    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    // Relación con el historial de moderación
    public function moderationHistory()
    {
        return $this->hasMany(ReviewModerationHistory::class, 'game_review_id');
    }

    // Mapeo de estados
    public static function getStatusLabels()
    {
        return [
            'pendiente' => 'Pendiente',
            'aprobada' => 'Aprobada',
            'rechazada' => 'Rechazada'
        ];
    }

    // Mapeo de motivos de rechazo
    public static function getRejectionReasons()
    {
        return [
            'lenguaje_ofensivo' => 'Lenguaje ofensivo',
            'spam' => 'Spam',
            'contenido_no_relacionado' => 'Contenido no relacionado',
            'insultos' => 'Insultos',
            'otro' => 'Otro'
        ];
    }
}
