<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        // Placeholder de listado de ítems. Aquí se podría cargar MarketItem o similar.
        return view('admin.items.index');
    }
}
