<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamingCode extends Model
{
    protected $fillable = [
        'service',
        'duration',
        'code',
        'stock',
        'price',
        'image',
        'is_active'
    ];
    public function item()
    {
        return $this->hasOne(MarketItem::class, 'streaming_code_id');
    }
}
