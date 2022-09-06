<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'Comercial de Proveedores' || Auth::user()->role == 'Especialista' || Auth::user()->role == 'Administrador') {
                return $next($request);
            } else {
                return redirect('/home')->with('status', 'Acceso denegado');
            }
        } else {
            return redirect()->back()->with('status', 'Acceso denegado, por favor autentíquese');
        }
    }
}
