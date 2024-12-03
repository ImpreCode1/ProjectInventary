<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => 'required|max:255',
            'apellidos' => 'required|max:255',
            'email' => 'required|max:255|email',
            'password'=>'required|max:255|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/','confirmed',
            'rol'=>'required',
            'imagen' => 'nullable|mimes:jpeg,png,gif,avi,jpg|max:100000'
        ];
    }

    public function messages()
    {
        return [
            'nombres.required' => 'El campo nombre es obligatorio.',
            'nombres.max' => 'El campo nombre no debe terner mas de :max caracteres',
            'apellidos.required' => 'El campo apellido es obligatorio.',
            'apellidos.max' => 'El campo apellido no debe tener mas de :max carcateres.',
            'email.email' => 'El email debe ser una dirección de correo electrónico válida.',
            // 'email.unique' => 'El email ya ha sido registrado.',
            'email.required' => 'El campo email es requerido.',
            'email.max' => 'El campo email no debe tener mas de :max caracteres.',
            'password.required' => 'El campo contraseña es requerido.',
            'password.min' => 'El campo contraseña debe tener almenos :min caracteres.',
            'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, un número y un carácter especial.',
            'password.max' => 'El campo contraseña no debe tener mas de :max caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'rol.required' => 'El campo rol es requerido',
            'imagen.mimes' => 'El campo Imagen debe ser un archivo de tipo: jpeg,png,gif,avi,jpg.',
            'imagen.max' => 'El archivo debe pesar maximo :max.'

            
        ];
    }
}
