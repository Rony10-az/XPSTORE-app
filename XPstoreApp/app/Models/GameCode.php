<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'used',
        'status',
        'used_at',
        'batch',
    ];

    protected $casts = [
        'used' => 'boolean',
        'used_at' => 'datetime',
    ];

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
        return match ($this->status) {
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
