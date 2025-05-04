<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        // Si no hay un rol específico requerido, continuar
        if (!$role) {
            return $next($request);
        }

        // Verificar si el usuario está autenticado
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Verificar si el usuario tiene el rol requerido
        if ($request->user()->role !== $role && $request->user()->role !== 'admin') {
            // Los administradores pueden acceder a cualquier ruta
            // Si no es admin y no tiene el rol requerido, redirigir al dashboard
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
