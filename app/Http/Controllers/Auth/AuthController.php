<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginverify(LoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            // session(['user_name' => $user->name, 'user_rol' => $user->rol]);
            session([
                'user_nombres' => $user->nombres, 
                'user_apellidos' => $user->apellidos, 
                'user_imagen' => $user->imagen, 
                'user_rol' => $user->rol 
            ]);

            if($user->rol == 'Administrador' || $user->rol =='Usuario')
            {
                return redirect()->route('dashboard');
            }
        }

        return back()
         ->withErrors(['invalid_credentials' => 'Credenciales Incorrectas'])
         ->withInput();
    }


    public function signout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'session cerrada correctamente');
    }
}
