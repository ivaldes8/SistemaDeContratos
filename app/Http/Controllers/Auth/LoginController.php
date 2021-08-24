<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated()
    {
        if(Auth::user()->role_as == '1'){
            return redirect('/home')->with('status', 'Bienvenido administrador');
        }
        elseif(Auth::user()->role_as == '3'){
            return redirect('/home')->with('status', 'Usted se ha autenticado satisfactoriamente');
        }
        elseif(Auth::user()->role_as == '2'){
            return redirect('/home')->with('status', 'Bienvenido Facturador');
        }
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
