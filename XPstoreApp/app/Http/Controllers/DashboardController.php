<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoGame;

class DashboardController extends Controller
{
    public function admin()
    {
        $totalVideojuegos = VideoGame::count();
        $videojuegosDestacados = VideoGame::where('featured', true)->count();
        $stockTotal = VideoGame::sum('stock');
        $valorTotal = VideoGame::sum('price');

        $videojuegos = VideoGame::all(); // <-- Traemos todos los videojuegos

        return view('dashboard.admin', compact(
            'totalVideojuegos',
            'videojuegosDestacados',
            'stockTotal',
            'valorTotal',
            'videojuegos' // <-- pasamos a la vista
        ));
    }

    public function user()
    {
        return view('dashboard.user');
    }
}
