<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FilamentAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            // Guardar la URL a la que intentaba acceder para redirigir después del login
            session()->put('url.intended', $request->url());
            return redirect()->route('login');
        }

        // Verificar si el usuario tiene rol de administrador
        if (auth()->user()->role !== 'admin') {
            // Redirigir al dashboard con mensaje de error
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        // Si el usuario está autenticado y es admin, permitir el acceso
        return $next($request);
    }
}
