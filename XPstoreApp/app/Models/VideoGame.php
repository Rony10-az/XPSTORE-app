<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoGame extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'images',
        'genre',
        'platform',
        'release_date',
        'developer',
        'publisher',
        'rating',
        'stock',
        'featured',
        'requirements',
    ];

    protected $casts = [
        'images' => 'array',
        'genre' => 'array',
        'platform' => 'array',
        'requirements' => 'array',
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'featured' => 'boolean',
        'release_date' => 'date',
    ];
    // Relación con GameCode
    public function gameCodes()
    {
        return $this->hasMany(GameCode::class);
    }
}
