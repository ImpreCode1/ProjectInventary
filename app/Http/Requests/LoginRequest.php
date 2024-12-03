<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'El email es requerido.',
            'password.required' => 'La contraseña es requerida.',
            'email.email' => 'El email debe ser una dirección de correo electrónico válida.',
        ];
    }
}
