<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostComment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostLike> $likes
 * @property-read int|null $likes_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommunityPost newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommunityPost newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommunityPost query()
 * @mixin \Eloquent
 */
class CommunityPost extends Model
{
    protected $fillable = ['user_id', 'content', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }


    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }
}
