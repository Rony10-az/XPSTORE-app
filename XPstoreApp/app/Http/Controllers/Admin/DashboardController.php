<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGame;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVideojuegos = VideoGame::count();
        $videojuegosDestacados = VideoGame::where('featured', true)->count();
        $stockTotal = VideoGame::sum('stock');
        $valorTotal = VideoGame::sum('price');

        $videojuegos = VideoGame::all();

        return view('dashboard.admin', compact(
            'totalVideojuegos',
            'videojuegosDestacados',
            'stockTotal',
            'valorTotal',
            'videojuegos'
        ));
    }
}
