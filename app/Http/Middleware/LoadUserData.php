<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoadUserData
{
    
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::check()){
            $user = Auth::user();
            view()->share('userNombres', $user->nombres);
            view()->share('userApellidos', $user->apellidos);
            view()->share('userImagen', $user->imagen);
            view()->share('userRol', $user->rol);
        }
        return $next($request);
    }
}
