<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\MovimientoProducto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class UsuarioController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }

    public function store(UsuarioRequest $request): RedirectResponse
    {
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $filename = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('uploads'), $filename);
            $path = 'uploads/' . $filename;

            $usuario = new Usuario([
                'nombres' => $request['nombres'],
                'apellidos' => $request['apellidos'],
                'imagen' => $path,
                'email' => $request['email'],
                'password' => $request['password'],
                'rol' => $request['rol'],
            ]);
        } else {
            $usuario = new Usuario([
                'nombres' => $request['nombres'],
                'apellidos' => $request['apellidos'],
                'imagen' => '/assets/Recursos/prede.jpg',
                'email' => $request['email'],
                'password' => $request['password'],
                'rol' => $request['rol'],
            ]);
        }

        $usuario->save();
        notify()->success('Usuario creado correctamente', 'Éxito');
        return redirect()->route('landing');
    }

    public function show(Usuario $usuario)
    {
        $usuarios = Usuario::all();
        return view('usuarios', compact('usuarios'));
    }

    public function mostrarPerfil()
    {
        $usuarioEditar = auth()->user();
        return view('perfil', compact('usuarioEditar'));
    }

    public function edit(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $isAdmin = $request->is('admin/*');

        $view = $isAdmin ? 'admin.perfil' : 'perfil';

        return view($view, compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);
        $isAdmin = $request->is('admin/*');

        // Validación
        $request->validate(
            [
                'nombres' => 'required|string|max:50',
                'apellidos' => 'required|string|max:50',
                'password' => 'nullable|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'imagen' => 'nullable|max:2048|mimes:jpeg,jpg,png,gif,avif',
            ],
            [
                'nombres.required' => 'El campo nombres es obligatorio',
                'nombres.max' => 'El campo nombres tiene un limite de :max caracteres',
                'apellidos.required' => 'El campo apellidos es obligatorio',
                'apellidos.max' => 'El campo apellidos tiene un limite de :max caracteres',
                'password.min' => 'El campo contraseña tiene que tener :min caracteres',
                'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, un número y un carácter especial.',
                'password.confirmed' => 'Las contraseñas no coinciden',
                'imagen.mime' => 'El campo imagen deber ser un archivo de tipo:jpeg,png,gif,jpg,avif',
                'imagen.max' => 'El campo imagen no soporta mas de :max MB',
            ],
        );

        // Actualizar campos básicos
        $usuario->fill($request->only(['nombres', 'apellidos']));

        // Actualizar contraseña si se proporciona
        if ($request->filled('password')) {
            $usuario->password = $request->password;
        }

        // Manejar la actualización de la imagen
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            if ($archivo->isValid()) {
                // Eliminar imagen anterior si existe
                if ($usuario->imagen && $usuario->imagen != '/assets/Recursos/prede.jpg') {
                    $oldImagePath = public_path($usuario->imagen);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }

                // Guardar nueva imagen
                $filename = time() . '_' . $archivo->getClientOriginalName();
                $archivo->move(public_path('uploads'), $filename);
                $usuario->imagen = 'uploads/' . $filename;
            }
        }

        $usuario->save();

        notify()->info('Perfil actualizado', 'ℹ️ Información');

        $route = $isAdmin ? 'admin.perfil.edit' : 'perfil.edit';
        return redirect()
            ->route($route, $usuario->id)
            ->with('success', 'Perfil actualizado correctamente');
    }

    public function destroy(Usuario $usuario, MovimientoProducto $movimientoProducto)
    {
        $defaultImagePath = '/assets/Recursos/prede.jpg';

        if ($usuario->imagen !== $defaultImagePath) {
            $filePath = public_path($usuario->imagen);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $usuario->delete();
        notify()->warning('Se ha eliminado el usuario', 'Atención');
        return redirect()->route('usuarios');
    }
}
