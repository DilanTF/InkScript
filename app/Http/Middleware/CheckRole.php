<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Maneja la petición entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Comprobamos si el usuario está logueado y si NO es autor
        if (auth()->check() && auth()->user()->role !== 'author') {
            
            // 2. Si no es autor, lo mandamos al dashboard con un error
            return redirect('/dashboard')->with('error', 'No tienes permiso de autor.');
        }

        // 3. Si todo está bien, lo dejamos pasar al controlador
        return $next($request);
    }
}