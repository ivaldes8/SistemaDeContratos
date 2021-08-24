<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturadorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);
        if(Auth::check()){
            if(Auth::user()->role_as == '2'){
                return $next($request);
            }
            else{
                return redirect('/home')->with('status','Acceso denegado');
            }
        }
        else{
            return redirect()->back()->with('status','Acceso denegado, por favor autentíquese');
        }
    }
}
