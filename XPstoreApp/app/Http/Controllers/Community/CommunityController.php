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

        // AGREGADO: juegos populares de la BD
        $popularGames = VideoGame::orderBy('sales_count', 'desc')
            ->take(4)
            ->get();

        return view('community.index', compact('posts', 'filter', 'popularGames'));
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
