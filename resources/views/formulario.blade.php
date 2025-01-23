<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Productos</title>
    <link rel="stylesheet" href="/assets/css/verproducto.css">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">
    <style>
        .cantidad-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .cantidad-display {
            display: inline-block;
            background-color: rgb(198, 248, 217);
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .cantidad-principal {
            font-weight: bold;
            color: #333;
        }

        .cantidad-secundaria {
            color: hsl(0, 3%, 38%);
            margin-left: 10px;
        }
</style>
</head>

<body>


    <form action="{{ route('formulario.realizar-movimiento', $producto->id) }}" method="POST">
        @csrf
        <div class="form-group">



            <label for="cantidad" class="cantidad-label">Cantidad Disponible:</label>
            <div class="cantidad-display" id="cantidadDisponible">
                <span class="cantidad-principal">
                    {{ formatNumber($producto->cantidad) }} {{ $producto->UnidadMedida->nombre }}
                </span>
                @if ($producto->UnidadMedida->es_compuesta === 1 && $producto->cantidad_unidad_compuesta !== null)
                    <span class="cantidad-secundaria">
                        ({{ formatNumber($producto->cantidad_total) }} Unidad)
                    </span>
                @endif
            </div>


            <div>
                <div class="category-tag">Categoría: {{ $producto->categoria->nombre ?? 'Sin categoria' }}</div>
            </div>
            <div class="form-group">
                <label for="cantidadUsada">Cantidad a usar:</label>
                <input type="number" id="cantidadUsada" step="any" name="cantidadUsada" min="1"
                    max="{{ $producto->cantidad }} || {{$producto->cantidad_total}}" required>
                @if ($errors->has('cantidadUsada'))
                    <small class="error">
                        <strong>{{ $errors->first('cantidadUsada') }}</strong>
                    </small>
                @endif
            </div>
            <div class="form-group">
                <label for="mensaje">
                    Mensaje:<span class="optional-tag" style="margin-left: 8px; font-size: 0.85em; font-weight: normal; color: #6c757d; background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">Opcional</span>
                </label>
                <input type="text" id="mensaje" name="mensaje">
            </div>
            <div class="form-group">
                <input type="text" name="vicepresidencia" required placeholder="Ingrese Vicepresidencia">
            </div>

            <div class="form-group">
                <input type="text" name="direccion" required placeholder="Ingrese Dirección">
            </div>

            <div class="form-group">
                <input type="text" name="departamento" required placeholder="Ingrese Departamento">
            </div>
            <div class="form-group">
                <label for="observaciones">
                    Observaciones:<span class="optional-tag" style="margin-left: 8px; font-size: 0.85em; font-weight: normal; color: #6c757d; background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">Opcional</span>
                </label>
                <textarea id="observaciones" name="observaciones"></textarea>
            </div>
            <button class="btn-action" type="submit">Realizar Movimiento</button>
    </form>

    <script>
    </script>
</body>

</html>
