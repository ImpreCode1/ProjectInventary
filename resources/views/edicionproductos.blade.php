<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Productos</title>
    <link rel="stylesheet" href="/assets/css/producto.css">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

</head>

<body>
  


    <form id="editProductForm" method="POST" action="{{ route('producto.update', $productoEditar->id) }}"
        class="product-form" enctype="multipart/form-data" style="margin:0 auto; padding: 20px; max-width: 500px;">
        @method('PUT')
        @csrf
        <div class="product-details" style="display:grid; gap: 15px;">
            <div class="product-header" style="display: flex; align-items: center; margin-bottom: 15px;">
                <img id="previews-images" src="{{ asset($productoEditar->imagen) }}" alt="Product Image"
                    style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover; margin-right: 15px;">
                <h2 style="margin: 0; color: #333; font-size: 1.1rem;">Editar Producto</h2>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label for="nombre"
                        style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Nombre
                        del Producto</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre del producto"
                        class="form-control"
                        style="width: 100%; padding: 8px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem;"
                        value="{{ $productoEditar->nombre }}" required>
                </div>

                <div class="form-group">
                    <label for="idCategoria"
                        style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Categoría</label>
                    <select name="idCategoria" id="idCategoria" class="form-control"
                        style="width: 100%; padding: 8px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem; background-color: #ffffff;"
                        required>
                        <option value="" disabled selected>Seleccionar categoría</option>
                        @foreach ($categoria as $categoria)
                            <option value="{{ $categoria->id }}"
                                {{ $productoEditar->idCategoria == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion"
                    style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Descripción</label>
                <textarea id="descripcion" name="descripcion" placeholder="Descripción del producto" class="form-control"
                    style="width: 100%; padding: 8px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem; height: 60px; resize: none;"
                    required>{{ $productoEditar->descripcion }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label for="cantidad"
                        style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Cantidad</label>
                    <input type="number" step="any" class="nums" name="cantidad" id="cantidad"
                        value="{{ formatNumber($productoEditar->cantidad) }}"
                        style="width: 100%; padding: 8px; text-align: center; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem;"
                        placeholder="Cantidad">
                </div>
                <div class="form-group">
                    <label for="cantidad_minima"
                        style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Cantidad
                        Mínima</label>
                    <input type="number" class="nums" step="any" name="cantidad_minima" id="cantidad_minima"
                        value="{{ formatNumber($productoEditar->cantidad_minima) }}"
                        style="width: 100%; padding: 8px; text-align: center; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem;"
                        placeholder="Mínima">
                </div>
                <div class="form-group">
                    <label for="unidad_medida_id"
                        style="display: block; font-weight: bold; font-size: 0.9rem; margin-bottom: 4px;">Unidad
                        de Medida</label>
                    <select name="unidad_medida_id" id="unidad_medida_id"
                        style="width: 100%; padding: 8px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.9rem; background-color: white;"
                        required>
                        <option value="" disabled selected>Seleccione unidad</option>
                        @foreach ($unidadMedida as $unidad)
                            <option value="{{ $unidad->id }}"
                                {{ $productoEditar->unidad_medida_id == $unidad->id ? 'selected' : '' }}>
                                {{ $unidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <input type="file" id="image-inputs" name="imagen" accept="image/*" style="display: none;">
                <label for="image-inputs"
                    style="display: block; cursor: pointer; color: #007bff; font-size: 0.9rem; padding: 8px; background-color: #f8f9fa; text-align: center; border: 1px dashed #007bff; border-radius: 4px; transition: background-color 0.3s ease">
                    Seleccionar Nueva Imagen
                    <ion-icon name="folder-outline"></ion-icon>
                </label>
            </div>
        </div>

        <button class="buttons" type="submit"
            style="background-color: #007bff; color: white; font-size: 1rem; border: none; border-radius: 8px; cursor: pointer; padding: 14px; width: 100%; transition: background-color 0.3s; display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 2px;">
            <span>Guardar Cambios</span>
            <ion-icon name="create-outline"></ion-icon>
        </button>
    </form>

    <script>
        $(document).ready(function() {
            $(document).on('change', '#image-inputs', function(e) {
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previews-images').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            $('#editProductForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#editProductModal').hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
 
</body>

</html>
