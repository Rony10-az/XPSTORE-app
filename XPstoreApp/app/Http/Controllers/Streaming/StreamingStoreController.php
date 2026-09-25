<?php

namespace App\Http\Controllers\Streaming;

use App\Http\Controllers\Controller;
use App\Models\StreamingCode;

class StreamingStoreController extends Controller
{
    // Lista todos los productos
    public function index()
    {
        $codes = StreamingCode::where('is_active', true)
            ->orderBy('service')
            ->get();

        return view('streaming.index', compact('codes'));
    }

    // Muestra un producto
    public function show(StreamingCode $code)
    {
        return view('streaming.show', compact('code'));
    }
}
