@extends('layout')

@section('title', 'Inventario')

@section('content')
    <div id="dynamic-content">
        <link rel="stylesheet" href="/assets/css/categorias.css">
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playwrite+NL:wght@100..400&display=swap" rel="stylesheet"> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">
        <link rel="icon" href="/assets/Recursos/icoprin.ico">   

        <header>
            <div class="top-container">
                <div class="top-left">
                    {{-- <h1 style="color: #ffffff; font-size: 3rem; font-family: 'Playwrite NL', sans-serif;">Categorías</h1> --}}
                    <h1 style="color: #ffffff; font-size: 2.5rem; font-family: 'Playfair Display', serif;">Categorías</h1>
                    {{-- <h1 style="color: #ffffff; font-size: 3rem; font-family: 'Kanit', sans-serif;">Categorías</h1> --}}
                </div>
            </div>
        </header>

        <div>

            <div class="container">
                <div class="text-content">
                    <h2>Administra Categorías y Unidades</h2>
                    <p>Gestiona categorías de productos y medidas de unidad para organizar tu inventario de manera
                        eficiente.</p>

                </div>

                <div>
                    <form method="POST" class="form" action="{{ route('categoria.store') }}">
                        @csrf
                        <div class="container-add">
                            <div class="input-group">
                                <input placeholder="Ingrese nueva categoria" name="nombre" type="text" id="input-field">
                                <button type="submit" class="submit-button"><span>Agregar</span></button>
                            </div>
                            @if ($errors->has('nombre'))
                                <small class="form-e">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </small>
                            @endif
                        </div>
                    </form>
                </div>
            </div>


            <div class="btn-medida">
                <P style="color: #8686db">Agregar Medida</P>
                <button class="group cursor-pointer outline-none hover:rotate-90 duration-300" title="Agregar">
                    <svg class="stroke-teal-500" fill-nome group-hover:fill-teal-800 group-active:stroke -teal-200
                        group-active:fill-teal-600 group-active:duration-0 duration-300 viewBox="0 0 24 24" height="50px"
                        width="50px" xmlns="http://www.w3.org/2000/svg">

                        <path stroke-width="1.5"
                            d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z">
                        </path>
                        <path stroke-width="1.5" d="M8 12H16"></path>
                        <path stroke-width="1.5" d="M12 16V8"></path>
                    </svg>
                </button>
            </div>
            <div class="container-card">
                @if ($categorias->isNotEmpty())
                    @foreach ($categorias as $categoria)
                        <div class="card">
                            <div class="card-image"></div>
                            <div class="card-content">
                                <span class="category">{{ $categoria->nombre }}</span>
                                <div class="button-container">
                                    {{-- <button class="button edit">Editar</button> --}}
                                    <form method="POST" action="{{ route('categoria.delete', $categoria->id) }}"
                                        class="btn-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button delete">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-products-container">
                        <div class="no-products-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h2 class="no-products-title">No hay categorias agregadas</h2>
                        <p class="no-products-description">Parece que aún no se han agregado categorias. ¡Comienza a añadir
                            categorias para verlos aquí!</p>
                        {{-- <a href="{{ route('producto.create') }}" class="add-product-btn">Agregar Producto</a> --}}
                    </div>
                @endif

            </div>

        </div>

        {{-- modal para agregar medida  --}}
        <div class="modal-container">
            <div class="modal modal-close">
                <p class="close">X</p>
                <div class="modal-textos">
                    <form class="product-form" method="POST" action="{{ route('categoria.agregarmedida') }}"
                        style="width: 100%; height: 100%; padding: 20px; background-color: #ffffff; display: flex;  flex-direction: column; justify-content: space-between;">
                        @csrf
                        {{-- <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Nuevo tipo de medida</h2> --}}
                        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Nuevo Tipo de Medida</h2>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <div style="display: flex; gap:15px;">
                                <div style="flex: 1;">
                                    <label for="nombre"
                                        style="display: block; margin-bottom:5px; font-weight: bold;">Nombre</label>
                                    <input type="text" id="nombre" name="nombre" placeholder="Nombre tipo de medida"
                                        required
                                        style="width: 100%; padding:12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size:1rem;">
                                </div>

                                <div style="flex: 1;">
                                    <label for="abreviatura"
                                        style="display: block; margin-bottom: 5px; font-weight: bold;">Abreviatura</label>
                                    <input type="text" id="abreviatura" name="abreviatura" placeholder="Abreviatura"
                                        required
                                        style="width: 100%; padding:12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size:1rem;">
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 20px;">
                            <div style="display: flex; gap:15px;">

                                {{-- <div style="flex: 1;">
                                    <label for="tipo"
                                        style="display: block; margin-bottom: 5px; font-weight: bold;">Tipo</label>
                                    <select name="tipo" id="tipo"
                                        style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;"
                                        required>
                                        <option value="" disabled selected>Seleccione tipo</option>
                                        <option>Solido</option>
                                        <option>Liquido</option>
                                        <option>Otro</option>
                                    </select>
                                </div> --}}


                                <div style="flex: 1;">
                                    <label for="factor_conversion"
                                        style="display: block; margin-bottom: 5px; font-weight:bold;">
                                        conversión
                                        <span class="optional-tag" style="
                                         margin-left: 8px; font-size: 0.85em; font-weight: normal; color: #6c757d; background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">Opcional</span>
                                    </label>
                                    <input type="number" step="any" id="factor_conversion" name="factor_conversion"
                                        placeholder="Ingrese el factor de conversion (opcional)" 
                                        style="width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;">
                                </div>

                                <div style="flex: 1;">
                                    <label for="es_compuesta" style="display: block; margin-bottom: 5px; font-weight: bold;">¿Es compuesta?</label>
                                    <select name="es_compuesta" id="es_compuesta" style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;" required>
                                        <option value="0">No</option>
                                        <option value="1">Sí</option>
                                    </select>
                                </div>

                              
                            </div>
                            <br>
                            <div style="flex: 1;">
                                <label for="factor_conversion" style="display: block; margin-bottom: 5px; font-weight:bold;">
                                    Tipo
                                    <span class="optional-tag" style="
                                     margin-left: 8px; font-size: 0.85em; font-weight: normal; color: #6c757d; background-color: #e9ecef; padding: 2px 6px; border-radius: 4px;">Opcional</span>
                                </label>
                                <input type="text" id="tipo" name="tipo" placeholder="Ingrese el tipo (opcional)"
                                style="width: 100%; padding:12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size:1rem;">
                            </div>
                        </div>

                        {{-- <div class="form-group" style="margin-bottom:20px;">
                            <div style="display: flex; gap:15px;">
                             

                                <div style="flex: 1;">
                                    <label for="cantidad_base" style="display:block; margin-bottom:5px; font-weight:bold;">Cantidad base</label>
                                    <input type="number" step="any" id="cantidad_base" name="cantidad_base" placeholder="Cantidad base" style="width:100%; padding:12px; border:1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;">
                                </div>
                            </div>
                        </div> --}}

                        {{-- <button type="submit" class="">Enviar</button> --}}
                        <button type="submit" class="buttons">
                            Enviar
                        </button>

                    </form>
                </div>
            </div>
        </div>


        {{-- validacion --}}
        <div id="custom-alert-bg" class="custom-alert-bg"></div>
        <div id="custom-alert" class="custom-alert">
            <div class="custom-alert-content">
                <div class="custom-alert-header">
                    <img src="https://cdn-icons-png.freepik.com/256/2686/2686480.png?semt=ais_hybrid"
                        alt="Icono de usuario">
                </div>
                <h2>¿Crear una nueva categoria?</h2>
                <div class="custom-alert-buttons">
                    <button id="custom-confirm-yes" class="custom-confirm-yes">Sí, crear categoria</button>
                    <button id="custom-confirm-cancel" class="custom-confirm-cancel">Cancelar</button>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            let cerrar = document.querySelectorAll(".close")[0];
            let abrir = document.querySelectorAll(".group")[0];
            let modal = document.querySelectorAll(".modal")[0];
            let modalC = document.querySelectorAll(".modal-container")[0];
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form');
                const customAlertBg = document.getElementById('custom-alert-bg');
                const customAlert = document.getElementById('custom-alert');
                const customConfirmYes = document.getElementById('custom-confirm-yes');
                const customConfirmCancel = document.getElementById('custom-confirm-cancel');
                const eliminarBotones = document.querySelectorAll('.btn-eliminar');

                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    customAlertBg.style.display = 'block';
                    customAlert.style.display = 'block';
                });

                customConfirmYes.addEventListener('click', function() {
                    form.submit();
                });

                customConfirmCancel.addEventListener('click', function() {
                    customAlertBg.style.display = 'none';
                    customAlert.style.display = 'none';
                });


                // @if (session('success'))
                //     Swal.fire({
                //         position: "top-end",
                //         icon: "success",
                //         text: '{{ session('success') }}',
                //         showConfirmButton: false,
                //         timer: 1500
                //     });
                // @endif

                eliminarBotones.forEach(function(boton) {
                    boton.addEventListener('submit', function(event) {
                        event.preventDefault();

                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "custom-confirm-yes",
                                cancelButton: "custom-confirm-cancel"
                            },
                            buttonsStyling: false
                        });
                        swalWithBootstrapButtons.fire({
                            title: "Estás seguro?",
                            text: "No podrás revertir esto!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Si, eliminar!",
                            cancelButtonText: "No, cancelar!",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                boton.submit();
                                swalWithBootstrapButtons.fire({
                                    title: "Eliminado!",
                                    text: "Su categoria se ha eliminado.",
                                    icon: "success"
                                });
                            } else if (
                                result.dismiss === Swal.DismissReason.cancel
                            ) {
                                swalWithBootstrapButtons.fire({
                                    title: "Cancelado",
                                    // text: "Your imaginary file is safe :)",
                                    icon: "error"
                                });
                            }
                        });

                    });
                });

            });

            abrir.addEventListener("click", function(e) {
                e.preventDefault();
                modalC.style.opacity = "1";
                modalC.style.visibility = "visible";
                modal.classList.toggle("modal-close");

            });

            cerrar.addEventListener("click", function() {
                modal.classList.toggle("modal-close");
                setTimeout(function() {
                    modalC.style.opacity = "0";
                    modalC.style.visibility = "hidden";
                }, 850);
            });
        </script>
    </div>

@endsection


{{-- @push('scripts')

@endpush --}}
