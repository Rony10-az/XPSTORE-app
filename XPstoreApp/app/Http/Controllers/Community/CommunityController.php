<?php

namespace App\Http\Controllers\Community;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\VideoGame;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('type');

        $query = CommunityPost::with('user')->latest();

        if ($filter) {
            $query->where('type', $filter);
        }

        $posts = $query->paginate(10);

        return view('community.index', compact('posts', 'filter'));
    }

    public function create(Request $request)
    {
        $tab = $request->get('tab', 'post');

        return view('community.create', [
            'tab' => $tab,
            'games' => VideoGame::all()
        ]);
    }
}
