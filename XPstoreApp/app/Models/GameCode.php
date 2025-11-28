<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_game_id',
        'user_id',
        'code',
        'used',
        'status',
        'used_at',
        'batch',
    ];

    protected $casts = [
        'used' => 'boolean',
        'used_at' => 'datetime',
    ];

    // RELACIÓN INVERSA: Un código pertenece a un videojuego
    public function videoGame()
    {
        return $this->belongsTo(VideoGame::class);
    }

    // RELACIÓN: Un código pertenece a un usuario (comprador)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generar un código único aleatorio
     */
    public static function generateUniqueCode($length = 16)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Marcar código como usado
     */
    public function markAsUsed($userId = null)
    {
        $this->update([
            'used' => true,
            'status' => 'usado',
            'used_at' => now(),
            'user_id' => $userId,
        ]);
    }

    /**
     * Marcar código como vencido
     */
    public function markAsExpired()
    {
        $this->update([
            'status' => 'vencido',
        ]);
    }

    /**
     * Obtener el color del badge según el estado
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'disponible' => 'success',
            'usado' => 'secondary',
            'vencido' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Scope para códigos disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'disponible');
    }

    /**
     * Scope para códigos usados
     */
    public function scopeUsed($query)
    {
        return $query->where('status', 'usado');
    }

    /**
     * Scope para códigos vencidos
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'vencido');
    }
}
