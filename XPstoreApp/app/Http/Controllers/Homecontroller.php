<?php

namespace App\Http\Controllers;

use App\Models\VideoGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        // Cargar juegos destacados
        $featuredGames = VideoGame::where('featured', true)->take(6)->get();

        // Cargar últimos lanzamientos
        $newReleases = VideoGame::latest('release_date')->take(8)->get();

        // Cargar juegos con descuento
        $discountedGames = VideoGame::where('discount', '>', 0)
            ->orderBy('discount', 'desc')
            ->take(4)
            ->get();

        return view('layouts.principal', compact(
            'featuredGames',
            'newReleases',
            'discountedGames'
        ));
    }
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('dashboard.admin');
        }

        return view('dashboard.user');
    }
}
