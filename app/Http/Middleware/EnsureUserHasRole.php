<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // <-- Recibiremos el rol que queremos comprobar (ej: 'admin')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. Comprobamos si el usuario ha iniciado sesión Y si tiene el rol requerido.
        //    Auth::user() nos da el usuario actual.
        //    Auth::user()->role nos da el rol que guardamos en la base de datos ('admin' o 'cajero').
        if (Auth::check() && Auth::user()->role == $role) {
            
            // 2. Si tiene el rol, lo dejamos pasar a la siguiente petición (al controlador).
            return $next($request);
        }

        // 3. Si no tiene el rol, lo redirigimos a la página principal con un mensaje de error.
        //    abort(403) es una opción más simple que muestra una página de "Acceso Denegado".
        //    Usaremos una redirección para que sea más amigable.
        return redirect('/')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}