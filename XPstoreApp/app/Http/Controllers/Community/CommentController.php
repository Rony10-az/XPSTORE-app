<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        $request->validate(['comment' => 'required']);

        PostComment::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return back();
    }
}
