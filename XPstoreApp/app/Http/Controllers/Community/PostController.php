<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use Illuminate\Support\Facades\Auth;
use App\Models\VideoGame;

class PostController extends Controller
{
    public function create(Request $request)
    {
        // TAB ACTUAL
        $tab = $request->get('tab', 'post'); // post | review | help

        // JUEGOS QUE EL USUARIO PUEDE RESEÑAR
        // (sus juegos comprados)
        $games = VideoGame::all();
        // SI QUIERES SOLO SUS JUEGOS:
        // $games = UserPurchase::where('user_id', auth()->id())->with('videoGame')->get()->pluck('videoGame');

        return view('community.create', compact('tab', 'games'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'image' => 'nullable|image'
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')
                ->store('posts', 'public');
        }

        CommunityPost::create([
            'user_id' => Auth::id(),
            'content' => $request->content,
            'image' => $path
        ]);

        return redirect()->route('community.index');
    }
}
