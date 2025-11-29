<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \App\Models\CommunityPost|null $post
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostComment query()
 * @mixin \Eloquent
 */
class PostComment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }
}
