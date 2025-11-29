<?php

/** Middleware para redirigir si el usuario ya está autenticado */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            $user = Auth::user();

            // Redirección correcta por rol
            return $user->role === 'admin'
                ? redirect()->route('dashboard.admin')
                : redirect()->route('dashboard.user');
        }

        return $next($request);
    }
}
