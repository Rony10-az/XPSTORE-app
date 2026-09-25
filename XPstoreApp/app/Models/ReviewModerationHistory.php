<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModerationHistory extends Model
{
    protected $fillable = [
        'game_review_id',
        'admin_id',
        'action',
        'previous_status',
        'new_status',
        'rejection_reason',
        'note'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relación con la reseña
    public function gameReview()
    {
        return $this->belongsTo(GameReview::class);
    }

    // Relación con el admin que hizo la acción
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Mapeo de nombres de acciones
    public static function getActionLabels()
    {
        return [
            'aprobar' => 'Aprobó',
            'rechazar' => 'Rechazó',
            'editar' => 'Editó',
            'ocultar' => 'Ocultó'
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
