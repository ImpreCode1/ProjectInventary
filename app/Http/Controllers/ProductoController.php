<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\InfoMovimiento;
use App\Models\MovimientoProducto;
use App\Models\Producto;
use App\Models\UnidadMedida;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\FuncCall;
use XMLWriter;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $categoria = Categoria::all();
        $unidadMedida = UnidadMedida::all();
        $productos = Producto::with('categoria')->get();

        if ($request->ajax()) {
            return view('productos', compact('categoria', 'unidadMedida', 'productos'))->render();
        }
        return view('productos', compact('categoria', 'unidadMedida', 'productos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $filename = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('uploads'), $filename);
            $path = 'uploads/' . $filename;

            $categriaId = $request['idCategoria'];
            $categoria = Categoria::findOrFail($categriaId);

            $unidadMedidaId = $request['unidad_medida_id'];
            $unidadMedida = UnidadMedida::findOrFail($unidadMedidaId);

            $producto = new Producto([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'imagen' => $path,
                'cantidad' => $request['cantidad'],
                'idCategoria' => $categoria->id,
                'unidad_medida_id' => $unidadMedida->id,
                'cantidad_minima' => $request['cantidad_minima'],
                'fecharegistro' => now(),
                'cantidad_unidad_compuesta' => $request['cantidad_unidad_compuesta'],
                'cantidad_total' => $request['cantidad_total']
            ]);
        } else {
            $categriaId = $request['idCategoria'];
            $categoria = Categoria::findOrFail($categriaId);

            $unidadMedidaId = $request['unidad_medida_id'];
            $unidadMedida = UnidadMedida::findOrFail($unidadMedidaId);

            $producto = new Producto([
                'nombre' => $request['nombre'],
                'descripcion' => $request['descripcion'],
                'imagen' => '/assets/Recursos/prodef.jpg',
                'cantidad' => $request['cantidad'],
                'idCategoria' => $categoria->id,
                'unidad_medida_id' => $unidadMedida->id,
                'cantidad_minima' => $request['cantidad_minima'],
                'fecharegistro' => now(),
                'cantidad_unidad_compuesta' => $request['cantidad_unidad_compuesta'],
                'cantidad_total' => $request['cantidad_total']
            ]);
        }

        $producto->save();
        notify()->success('Producto creado', 'Éxito');
        return redirect()->route('productos');
    }

    public function show(Producto $producto)
    {
        // return response()->json($producto);
    }

    public function edit($id)
    {
        $productoEditar = Producto::findOrFail($id);
        $categoria = Categoria::all();
        $unidadMedida = UnidadMedida::all();

        if (request()->ajax()) {
            return view('edicionproductos', compact('productoEditar', 'categoria', 'unidadMedida'))->render();
        }

        return view('edicionproductos', compact('productoEditar', 'categoria', 'unidadMedida'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $producto->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');

            if ($archivo->isValid()) {
                if ($producto->imagen && $producto->imagen != '/assets/Recursos/prodef.jpg') {
                    $oldImagePath = public_path($producto->imagen);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
            }

            // Almacenar la nueva imagen
            $filename = time() . '_' . $archivo->getClientOriginalName();
            $archivo->move(public_path('uploads'), $filename);
            $producto->imagen = 'uploads/' . $filename;
        }

        // Guardar cambios
        $producto->save();
        notify()->info('Producto actualizado', 'ℹ️ Información');

        // if($request->ajax()) {
        //     return response()->json(['success' => true, 'message' => 'Producto actualizado exitosamente']);
        // }

        // return redirect()->back();
    }

    public function destroy(Producto $producto)
    {
        $defaultImagePath = '/assets/Recursos/prodef.jpg';
        // $filePath = public_path($producto->imagen);

        if ($producto->imagen !== $defaultImagePath) {
            $filePath = public_path($producto->imagen);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $producto->delete();
        notify()->warning('Se ha eliminado el producto', 'Atención');
        return redirect()->route('productos');
    }

    public function verinfoproducto()
    {
        $productos = Producto::where('cantidad', '>=', 1)->get();
        return view('verproductos', compact('productos'));
    }

    public function mostrarFormulario($id)
    {
        $producto = Producto::findOrFail($id);
        if (request()->ajax()) {
            return view('formulario', compact('producto'))->render();
        }
        return view('formulario', compact('producto'));
    }

    public function realizarMovimiento(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $cantidadUsada = $request->cantidadUsada;

        if ($request->cantidad > $producto->cantidad) {
            return back()->withErrors(['cantidadUsada' => 'No hay suficiente cantidad disponible.']);
        }

        DB::transaction(function () use ($request, $producto, $cantidadUsada) {
            $movimiento = MovimientoProducto::create([
                'idProducto' => $producto->id,
                'cantidadUsada' => $cantidadUsada,
                'idUsuario' => auth()->id(),
                'fecha' => now(),
            ]);

            InfoMovimiento::create([
                'idMovimientoProducto' => $movimiento->id,
                'mensaje' => $request->mensaje,
                'vicepresidencia' => $request->vicepresidencia,
                'direccion' => $request->direccion,
                'departamento' =>$request->departamento,
                'observaciones' => $request->observaciones,
            ]);



            // $producto->decrement('cantidad', $request->cantidadUsada);

            if($producto->UnidadMedida->es_compuesta){
            //    $producto->decrement('cantidad_total', $cantidadUsada);
                if($producto->cantidad_unidad_compuesta > 0){
                    $unidadesCompletasUsadas = floor($cantidadUsada / $producto->cantidad_unidad_compuesta);
                    $producto->decrement('cantidad', $unidadesCompletasUsadas);

                    $remanente = $cantidadUsada % $producto->cantidad_unidad_compuesta;
                    if ($remanente > 0) {
                        $nuevaCantidadUnidadCompuesta = $producto->cantidad_unidad_compuesta - $remanente;
                        if ($nuevaCantidadUnidadCompuesta <= 0) {
                            $producto->decrement('cantidad', 1);
                            $nuevaCantidadUnidadCompuesta += $producto->cantidad_unidad_compuesta;
                        }
                        $producto->update(['cantidad_unidad_compuesta' => $nuevaCantidadUnidadCompuesta]);
                    }

                    $nuevaCantidadTotal = $producto->cantidad * $producto->cantidad_unidad_compuesta;
                }else{

                    // $producto->update(['cantidad_total' => $producto->cantidad_total - $cantidadUsada]);

                    $producto->decrement('cantidad', $cantidadUsada);
                    $nuevaCantidadTotal = $producto->cantidad;
                }

                // $nuevaCantidadTotal = $producto->cantidad * ($producto->cantidad_unidad_compuesta ?: 1);
                $producto->update(['cantidad_total' => $nuevaCantidadTotal]);

            }else{
                $producto->decrement('cantidad', $cantidadUsada);
                $producto->decrement('cantidad_total', $cantidadUsada);
            }
        });

        notify()->success('Movimiento realizado correctamente', 'Éxito');
        return redirect()->route('verproductos');

        // notify()->success('Movimiento realizado')->flash('');
        // return redirect()->route('verproductos');
    }

    public function mostrarMovimiento()
    {
        // $movimientos =  MovimientoProducto::with(['infoMovimientos','producto','usuario'])->get();
        $movimientos = MovimientoProducto::with(['infoMovimiento', 'producto', 'usuario', 'producto.unidadMedida'])->get();
        // $unidades = UnidadMedida::
        return view('reportes', compact('movimientos'));
    }
    public function verstock()
    {
        $producto = Producto::where('cantidad', '>=', 1)->get();
        return view('stock', compact('producto'));
    }

    public function formatCantidad($cantidad)
    {
        $cantidad = floatval($cantidad);

        if (floor($cantidad) == $cantidad) {
            return number_format($cantidad, 0);
        } else {
            return rtrim(rtrim(number_format($cantidad, 2, '.', ''), '0'), '.');
        }
    }

    public function formatUnidadMedida($cantidad, $unidad)
    {
        $cantidad = floatval($cantidad);
        $singular = [
            'Galón' => 'Galón',
            'Kilos' => 'Kilo',
            'Unidad' => 'Unidad',
            'Litros' => 'Litro',
            'Paquete' => 'Paquete',
            'Caja' => 'Caja',
            'Paca' => 'Paca',
            'Rollos' => 'Rollo',
            'Pares' => 'Par',
            'Libras' => 'Libra',
        ];

        $plural = [
            'Galón' => 'Galones',
            'Kilos' => 'Kilos',
            'Unidad' => 'Unidades',
            'Litros' => 'Litros',
            'Paquete' => 'Paquetes',
            'Caja' => 'Cajas',
            'Paca' => 'Pacas',
            'Rollos' => 'Rollos',
            'Pares' => 'Pares',
            'Libras' => 'Libras',
        ];

        if ($cantidad <= 1) {
            return $singular[$unidad] ?? $unidad;
        } else {
            return $plural[$unidad] ?? $unidad . 's';
        }
    }

    public function export(Request $request)
    {
        $query = MovimientoProducto::query();

        if ($request->has('search') && !empty($request->search)) {
            $searchValue = $request->search;
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('producto', function ($q) use ($searchValue) {
                    $q->where('nombre', 'like', "%{$searchValue}%");
                })
                    ->orWhereHas('usuario', function ($q) use ($searchValue) {
                        $q->where('nombres', 'like', "%{$searchValue}%")->orWhere('apellidos', 'like', "%{$searchValue}%");
                    })
                    ->orWhereHas('infoMovimiento', function ($q) use ($searchValue) {
                        $q->where('vicepresidencia', 'like', "%{$searchValue}%");
                    })
                    ->orWhere('cantidadUsada', 'like', "%{$searchValue}%")
                    ->orWhere('fecha', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order') && is_array($request->order)) {
            $columns = ['producto.nombre', 'usuario.nombres', 'infoMovimiento.vicepresidencia', 'cantidadUsada', 'fecha'];
            foreach ($request->order as $order) {
                if (isset($order['column']) && isset($order['dir'])) {
                    $query->orderBy($columns[$order['column']], $order['dir']);
                }
            }
        }

        // if ($request->has('start') && $request->has('length')) {
        //     $query->skip($request->start)->take($request->length);
        // }

        $movimientos = $query->with(['producto', 'usuario', 'infoMovimiento'])->get();

        $filename = 'movimientos_' . date('Y-m-d') . '.xls';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!--[if gte mso 9]>
            <x ml>
            <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Reporte</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
            </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
            table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
                font-size: 14px;
            }
            th {
                background-color: #f2f2f2;
                font-weight: bold;
            }
            </style>
            </head>
            <body>
            <table>';

               // Encabezados
            $output .= '<tr>';
            $headers = ['Producto', 'Usuario', 'Vicepresidencia', 'Direccion', 'Departamento', 'Cantidad utilizada', 'Fecha'];
            foreach ($headers as $header) {
              $output .= "<th>{$header}</th>";
            }
            $output .= '</tr>';

             // Datos
            foreach ($movimientos as $movimiento) {
                $unidadMedida = $this->formatUnidadMedida($movimiento->cantidadUsada, $movimiento->producto && $movimiento->producto->UnidadMedida ? $movimiento->producto->UnidadMedida->nombre : 'Unidad de medida no disponible');

                $output .= '<tr>';
                $output .= '<td>' . ($movimiento->producto ? htmlspecialchars($movimiento->producto->nombre) : 'Producto no disponible') . '</td>';
                $output .= '<td>' . ($movimiento->usuario ? htmlspecialchars($movimiento->usuario->nombres . ' ' . $movimiento->usuario->apellidos) : 'Usuario no disponible') . '</td>';
                $output .= '<td>' . htmlspecialchars($movimiento->infoMovimiento->vicepresidencia) . '</td>';
                $output .= '<td>' . htmlspecialchars($movimiento->infoMovimiento->direccion) . '</td>';
                $output .= '<td>' . htmlspecialchars($movimiento->infoMovimiento->departamento) . '</td>';


                // if (isset($movimiento->producto) && isset($movimiento->producto->unidadMedida)) {
                //     $cantidadFormateada = $this->formatCantidad($movimiento->cantidadUsada);
                //     if ($movimiento->producto->unidadMedida->es_compuesta) {
                //         $output .= '<td>' . htmlspecialchars($cantidadFormateada . ' unidade(s)') . '</td>';
                //     } else {
                //         $unidadMedida = $movimiento->producto->unidadMedida->nombre ?? 'N/A';
                //         $output .= '<td>' . htmlspecialchars($cantidadFormateada . ' ' . $unidadMedida) . '</td>';
                //     }
                // } else {
                //     $output .= '<td>Información no disponible</td>';
                // }

                if($movimiento->producto->unidadMedida->es_compuesta){
                    $cantidadFormateada = $this->formatCantidad($movimiento->cantidadUsada);
                    if($movimiento->producto->cantidad_unidad_compuesta !== null){
                        $output .= '<td>' . htmlspecialchars($cantidadFormateada . 'unidad(es)') . '</td>';
                    }else{
                        $output .= '<td>' . htmlspecialchars($cantidadFormateada . ' ' . $unidadMedida) . '</td>';
                    }
                }else {
                    $cantidadFormateada = $this->formatCantidad($movimiento->cantidadUsada);
                    $output .= '<td>' . htmlspecialchars($cantidadFormateada . ' ' . $unidadMedida) . '</td>';
                }

                $output .= '<td>' . htmlspecialchars($movimiento->fecha) . '</td>';
                $output .= '</tr>';

            }

        $output .= '</table></body></html>';

        echo $output;
        exit();
    }

    public function exportproducto(Request $request)
    {
        try {
            $query = Producto::query();

            if ($request->filled('search')) {
                $searchValue = $request->search;
                $query->where(function ($q) use ($searchValue) {
                    $q->where('nombre', 'like', "%{$searchValue}%")
                        ->orWhere('cantidad', 'like', "%{$searchValue}%")
                        ->orWhere('updated_at', 'like', "%{$searchValue}%");
                });
            }

            if ($request->has('order') && is_array($request->order)) {
                $columns = ['nombre', 'cantidad', 'updated_at'];
                foreach ($request->order as $order) {
                    if (isset($order['column']) && isset($order['dir'])) {
                        $query->orderBy($columns[$order['column']], $order['dir']);
                    }
                }
            }

            if ($request->has('start') && $request->has('length') && is_numeric($request->start) && is_numeric($request->length)) {
                $query->skip($request->start)->take($request->length);
            }

            $productos = $query->with('UnidadMedida')->get();

            $filename = 'productos_en_stock_' . date('Y-m-d') . '.xls';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Pragma: no-cache');
            header('Expires: 0');

            $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <!--[if gte mso 9]>
            <xml>
                <x:ExcelWorkbook>
                    <x:ExcelWorksheets>
                        <x:ExcelWorksheet>
                            <x:Name>Reporte</x:Name>
                            <x:WorksheetOptions>
                                <x:DisplayGridlines/>
                            </x:WorksheetOptions>
                        </x:ExcelWorksheet>
                    </x:ExcelWorksheets>
                </x:ExcelWorkbook>
            </xml>
            <![endif]-->
            <style>
                table, th, td {
                    border: 1px solid black;
                    border-collapse: collapse;
                }
                th, td {
                    padding: 5px;
                    text-align: left;
                    font-size: 14px;
                }
                th {
                    background-color: #f2f2f2;
                    font-weight: bold;
                }
            </style>
            </head>
            <body>
            <table>';

            // Headers
            $output .= '<tr>';
            $headers = ['Producto', 'En stock', 'Fecha'];
            foreach ($headers as $header) {
                $output .= "<th>{$header}</th>";
            }
            $output .= '</tr>';

            // Data
            foreach ($productos as $producto) {
                $cantidadFormateada = $this->formatCantidad($producto->cantidad);
                $unidadMedida = $this->formatUnidadMedida($producto->cantidad, optional($producto->UnidadMedida)->nombre);

                $output .= '<tr>';
                $output .= '<td>' . htmlspecialchars($producto->nombre) . '</td>';
                if($producto->unidadMedida->es_compuesta === 1 && $producto->cantidad_unidad_compuesta !== null){
                    $cantidadTotalFormateada = formatNumber($producto->cantidad_total);
                    $output .='<td>' . htmlspecialchars($cantidadFormateada . ' ' . $producto->unidadMedida->nombre) .
                        ' <span style="color: #4CAF50;">Cantidad disponible: </span>' .
                        htmlspecialchars($cantidadTotalFormateada . ' unidade(s)') . '</td>';
                }else{
                    $output .= '<td>' . htmlspecialchars($cantidadFormateada . ' ' . $unidadMedida) . '</td>';
                }
                $output .= '<td>' . $producto->updated_at->format('Y-m-d H:i:s') . '</td>';
                $output .= '</tr>';
            }

            $output .= '</table></body></html>';

            echo $output;
            exit();
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while exporting data'], 500);
        }
    }
}



