<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Retorna la vista principal
        return view('layouts.principal');
    }
}
