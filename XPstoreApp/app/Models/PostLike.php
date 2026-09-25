<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostLike newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostLike newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostLike query()
 * @mixin \Eloquent
 */
class PostLike extends Model
{
    protected $fillable = ['post_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
