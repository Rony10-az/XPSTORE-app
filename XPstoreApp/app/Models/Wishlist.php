<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'item_type'
    ];

    // Relación universal
    public function item()
    {
        return $this->morphTo(__FUNCTION__, 'item_type', 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
