<?php

namespace App\Http\Controllers;

use App\Models\InfoMovimiento;
use Illuminate\Http\Request;

class InfoMovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function show(InfoMovimiento $infoMovimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfoMovimiento $infoMovimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InfoMovimiento $infoMovimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfoMovimiento $infoMovimiento)
    {
        //
    }

    public function cargarSeccion($seccion)
    {
        try{
            switch ($seccion) {
                case 'productos':
                    return view('productos');
                case 'usuarios':
                    return view('usuarios');
                case 'categorias':
                    return view('categorias');
                case 'reportes':
                    return view('reportes');
                default:
                    return response()->json(['error' => 'Sección no encontrada'], 404);
            }

        }catch(\Exception $e){
            // \Log::error('Error en cargarSeccion: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }

    }
}
