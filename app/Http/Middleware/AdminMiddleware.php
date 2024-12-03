<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->rol == 'Administrador'){
            return $next($request);
        }

        return redirect('auth/login')->with('error', 'You do not have admin access.');
    }
}