<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    // 1. Revisa si el usuario está logueado
    // 2. Revisa si el rol del usuario es 'admin'
    if (auth()->check() && auth()->user()->role == 'admin') {
        // Si es admin, déjalo pasar
        return $next($request);
    }

    // Si no es admin, redirígelo al dashboard con un error
    return redirect()->route('dashboard')->with('error', 'Acceso denegado. No tienes permisos de administrador.');
}
}
