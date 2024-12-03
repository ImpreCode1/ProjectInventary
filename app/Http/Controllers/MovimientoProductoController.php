<?php

namespace App\Http\Controllers;

use App\Models\MovimientoProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MovimientoProductoController extends Controller
{
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MovimientoProducto $movimientoProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MovimientoProducto $movimientoProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MovimientoProducto $movimientoProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MovimientoProducto $movimientoProducto)
    {
        $movimientoProducto->delete();
        notify()->warning('Se ha eliminado la fila seleccionada', 'Atención');
        return redirect()->route('reportes');
    }

    public function mostrarDeatallesMovimientos($id){
        $producto = Producto::findOrFail($id);
        return view('verproductos', compact('producto'));
    }
}
