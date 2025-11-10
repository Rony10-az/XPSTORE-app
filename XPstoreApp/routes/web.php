<?php

use App\Http\Controllers\Homecontroller;
use Illuminate\Support\Facades\Route;

Route::get('/', [Homecontroller::class, 'index']);
