<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\UnidadMedida;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'nombre' => 'required',
            ],
            [
                'nombre.required' => 'El campo nombre es obligatorio',
            ],
        );

        Categoria::create($request->all());
        try {
            notify()->success('Categoria creada', 'Éxito');
            return redirect()->route('categorias');
        } catch (\Exception $e) {
            // notify()->error('No se pudo crear la categoria', '❌ Error');
            return redirect()->back()->withInput()->with('error', 'Hubo un error al crear la categoria');
        }
    }

    public function show()
    {
        $categorias = Categoria::all();
        
        return view('categorias', compact('categorias'));
    }

    public function agregarmedida(Request $request)
    {
        $unidadData = $request->only('nombre','abreviatura','es_compuesta', 'cantidad_base','factor_conversion');

        
        UnidadMedida::create($unidadData);
        notify()->success('Unidad de medida creada', 'Éxito');
        return redirect()->route('categorias');
       
        // return view('categorias', compact('UnidadMedidad'));
    }

    public function edit(Categoria $categoria)
    {
        //
    }

    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    public function delete(Categoria $categoria)
    {
     
        $categoria->productos()->update(['idCategoria' => null]);
        $categoria->delete();
        notify()->warning('Se ha eliminado la categoria', 'Atención');
        return redirect()->route('categorias');
    }
}
