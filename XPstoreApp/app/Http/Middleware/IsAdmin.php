<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Agregué este guard para asegurarme de que solo admin pase a estas rutas.
        if (!$request->user() || $request->user()->role !== 'admin') {
            abort(403, 'Acceso solo para administradores.');
        }

        return $next($request);
    }
}
