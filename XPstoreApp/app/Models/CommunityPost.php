<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
