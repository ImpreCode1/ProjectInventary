@extends('layout')

@section('title', 'Inventario')

@section('content')
    <div id="dynamic-content">


        <link rel="stylesheet" href="/assets/css/producto.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">
        <link rel="icon" href="/assets/Recursos/icoprin.ico">


        {{-- modal de agregar productos --}}
        <div class="modal-container">
            <div class="modal modal-close">
                <p class="close">X</p>
                <div class="modal-textos">
                    <form id="formulario" method="POST" class="product-form" action="{{ route('producto.store') }}"
                        enctype="multipart/form-data"
                        style="width: 100%; height: 100%; padding: 20px; background-color: #ffffff; display: flex; flex-direction: column; justify-content: space-between;">
                        @csrf

                        <div class="product-header" style="display: flex; align-items: center; margin-bottom: 15px;">
                            <div class="product-image" style="margin-right: 15px;">
                                <img id="preview-image" src="https://kosei-master.com/user_data/shohin_image/noimage.jpg"
                                    alt="Product Image"
                                    style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </div>
                            <div class="image-upload">
                                <input type="file" id="image-input" name="imagen" accept="image/*"
                                    style="display: none;">
                                <label for="image-input"
                                    style="cursor: pointer; color: #3498db; font-size: 0.9rem; padding: 8px 12px; background-color: #e8f4fd; border-radius: 6px;">Seleccionar
                                    Imagen (Opcional)</label>
                            </div>
                        </div>

                        <div class="product-details"
                            style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div class="form-group" style="margin-bottom: 12px;">
                                <input type="text" id="nombre" name="nombre" placeholder="Ingrese el nombre del producto"
                                    class="form-control"
                                    style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;"
                                    required="">
                            </div>

                            <div class="form-group" style="margin-bottom: 12px;">
                                <textarea id="descripcion" name="descripcion" placeholder="Ingrese la descripción del producto (opcional)" class="form-control"
                                    style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem; height: 80px; resize: none;"></textarea>
                            </div>




                            <div class="form-group">
                                <select name="idCategoria" class="form-control"
                                    style="width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; background-color: #ffffff; appearance: none; background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px top 50%; background-size: 12px auto; transition: border-color 0.3s ease;"
                                    required="">
                                    <option value="" disabled selected>Seleccionar categoría</option>
                                    @foreach ($categoria as $category)
                                        <option value="{{ $category->id }}">{{ $category->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group" style="margin-bottom: 12px;">
                                <div class="quantity-control" style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <input type="number" step="any" name="cantidad" id="cantidad" min="1"
                                            placeholder="Cantidad"
                                            value="{{ old('cantidad', isset($producto) ? formatNumber($producto->cantidad) : '') }}"
                                            style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;"
                                            required>
                                    </div>
                                    <div style="flex: 1;">


                                        <select name="unidad_medida_id" id="unidad_medida_id" class="form-control"
                                                 style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;"
                                              required>
                                            @php
                                                $hasCompuestas = $unidadMedida->where('es_compuesta', 1)->isNotEmpty();
                                                $hasNoCompuestas = $unidadMedida
                                                    ->where('es_compuesta', 0)
                                                    ->isNotEmpty();
                                            @endphp
                                            <option value="" disabled selected style="color: #777;">Seleccione unidad
                                            </option>

                                            @if ($hasCompuestas)
                                                <option style="background-color: #efed74; color: white; font-weight: bold;"
                                                    value="" disabled>Unidades Compuestas</option>
                                                @foreach ($unidadMedida->where('es_compuesta', 1) as $unidad)
                                                    <option value="{{ $unidad->id }}"
                                                        data-es-compuesta="{{ $unidad->es_compuesta }}"
                                                        data-cantidad-base="{{ $unidad->cantidad_base }}"
                                                        style="background-color: hsl(0, 0%, 100%); color: #100e0e;">
                                                        {{ $unidad->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif

                                            @if ($hasNoCompuestas)
                                                <option style="background-color: hsl(145, 70%, 74%); color: white; font-weight: bold;"
                                                    value="" disabled>Unidades</option>
                                                @foreach ($unidadMedida->where('es_compuesta', 0) as $unidad)
                                                    <option value="{{ $unidad->id }}"
                                                        data-es-compuesta="{{ $unidad->es_compuesta }}"
                                                        data-cantidad-base="{{ $unidad->cantidad_base }}"
                                                        style="background-color: hsl(0, 0%, 100%); color: #100e0e;">
                                                        {{ $unidad->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>


                                    </div>
                                </div>
                                <br>
                                <div class="quantity-control" style="display: flex; gap: 10px;">
                                    <div style="flex: 1;">
                                        <input type="number" step="any" name="cantidad_minima" id="cantidad_minima"
                                            placeholder="Cantidad mínima" 
                                            value="{{ old('cantidad_minima', isset($producto) ? formatNumber($producto->cantidad_minima) : '') }}"
                                            style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 1rem;"
                                            required>
                                    </div>

                                    
                                    <div style="flex: 1;" id="cantidad_base_container" style="display: none;">
                                        <input type="number" step="any" id="cantidad_unidad_compuesta"
                                            name="cantidad_unidad_compuesta" placeholder="Unidades"
                                            style="width:100%; padding:10px; border:1px solid #e0e0e0; border-radius:6px; font-size:1rem;">
                                    </div>


                                </div>
                                {{-- <div style="margin-top: 10px;">
                                  
                                
                                    
                                </div> --}}
                                <br>
                                <div style="flex: 1;">
                                    <div class="form-group">
                                        <label for="cantidad_total"
                                            style="text-align: center;    align-items: center; justify-content: center;">Cantidad
                                            Total</label>
                                        <input type="number" step="any" id="cantidad_total" name="cantidad_total"
                                            class="form-control"
                                            style="width: 50%; padding:10px; border: 1px solid #e0e0e0; border-radius:6px; font-size:1rem;"
                                            readonly>
                                    </div>
                                </div>



                            </div>
                        </div>

                        {{-- <button type="submit" class="add-to-cart" style="background-color: #3498db; color: white; font-size: 1rem; border: none; border-radius: 6px; cursor: pointer; padding: 12px 15px; width: 100%; transition: background-color 0.3s;">Agregar Producto</button> --}}
                        <button class="button" type="submit">
                            <svg viewBox="0 0 16 16" class="bi bi-cart-check" height="24" width="24"
                                xmlns="http://www.w3.org/2000/svg" fill="#fff">
                                <path
                                    d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z">
                                </path>
                                <path
                                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z">
                                </path>
                            </svg>
                            <p class="text">Agregar Producto</p>
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- modal para editar --}}
        <div id="editProductModal" class="modals" style="display: none;">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div id="editModalBody"></div>
            </div>
        </div>


        <header>
            <div class="top-container">
                <div class="top-left">
                    <h1 style="color: #ffffff; font-size: 2.5rem; font-family: 'Playfair Display', serif;">Productos</h1>
                </div>
            </div>
        </header>

        <div class="container">

            <div class="bottom-container">
                <div class="walletBalanceCard">
                    <div class="svgwrapper">
                        {{-- icono de productos --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-box2-heart-fill" viewBox="0 0 16 16">
                            <path
                                d="M3.75 0a1 1 0 0 0-.8.4L.1 4.2a.5.5 0 0 0-.1.3V15a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.1-.3L13.05.4a1 1 0 0 0-.8-.4zM8.5 4h6l.5.667V5H1v-.333L1.5 4h6V1h1zM8 7.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                        </svg>
                    </div>

                    <div class="balancewrapper">
                        <span class="balanceHeading">Agregar Articulo</span>
                        <p class="balance"><span id="currency">₹ 5678</span></p>
                    </div>

                    <button class="addmoney"><span class="plussign">+</span>Agregar</button>
                </div>

                {{-- buscar  --}}
                <div class="container-filter">
                    <form class="form">
                        <label for="search">
                            <input class="input" type="text" required="" placeholder="Buscar" id="search">
                            <div class="fancy-bg"></div>
                            <div class="search">
                                <svg viewBox="0 0 35 25" aria-hidden="true"
                                    class="r-14j79pv r-4qtqp9 r-yyyyoo r-1xvli5t r-dnmrzs r-4wgw6l r-f727ji r-bnwqim r-1plcrui r-lrvibr">
                                    <g>
                                        <path
                                            d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                        </path>
                                    </g>
                                </svg>
                            </div>
                            {{-- <button class="close-btn" type="reset">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button> --}}
                        </label>
                    </form>
                </div>
            </div>

            <div class="container-card">
                @if ($productos->isNotEmpty())
                    @foreach ($productos as $producto)
                        <div class="product-card-container">
                            <div class="product-card">
                                <a class="product-link">
                                    <img class="product-card-img"
                                        style="background-position: center; background-size: cover;"
                                        src="{{ asset($producto->imagen) }}" />
                                    <div class="product-card-details">

                                        <div class="product-name-price">
                                            <span class="product-name">{{ $producto->nombre }}</span>
                                            @if ($producto->cantidad < $producto->cantidad_minima)
                                                <span class="product-prices">Stock bajo</span>
                                            @else
                                                <span class="product-price">En stock</span>
                                            @endif


                                        </div>

                                        <span class="product-descripcion"><span
                                                style="font-weight: 600; font-size: 16px;">Descripción</span><br>
                                            {{ $producto->descripcion }}</span>

                                        <div class="product-view">
                                            <span class="category-list">
                                                <div>Cant:{{ formatNumber($producto->cantidad) }}
                                                    {{ $producto->UnidadMedida->abreviatura }}</div>
                                                <div class="product-category">
                                                    {{ $producto->categoria->nombre ?? 'Sin categoria' }}</div>
                                            </span>
                                        </div>
                                    </div>

                                </a>
                                <div class="product-wish-addtocart">
                                    <form method="POST" action="{{ route('producto.destroy', $producto->id) }}"
                                        class="btn-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn">
                                            <svg viewBox="0 0 15 17.5" height="17.5" width="15"
                                                xmlns="http://www.w3.org/2000/svg" class="icon">
                                                <path transform="translate(-2.5 -1.25)"
                                                    d="M15,18.75H5A1.251,1.251,0,0,1,3.75,17.5V5H2.5V3.75h15V5H16.25V17.5A1.251,1.251,0,0,1,15,18.75ZM5,5V17.5H15V5Zm7.5,10H11.25V7.5H12.5V15ZM8.75,15H7.5V7.5H8.75V15ZM12.5,2.5h-5V1.25h5V2.5Z"
                                                    id="Fill"></path>
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- <form method="POST" action="" class="btn-editar"> --}}
                                    {{-- 
                            <a href="{{ route('producto.edit', $producto->id) }}" type="submit"
                                class="addtocart-btn">Modificar</a> --}}

                                    {{-- <button href="#" type="submit" class="addtocart-btn">Modificar</button> --}}
                                    {{-- </form> --}}

                                    {{-- <a href="{{ route('producto.edit', $producto->id) }}" class="addtocart-btn edit-product">Modificar</a> --}}
                                    {{-- <a href="{{ route('productos', ['editar' => $producto->id]) }}" class="addtocart-btn edit-product">Modificar</a> --}}
                                    {{-- <a href="#" class="addtocart-btn" data-id="{{ $producto->id }}">Modificar</a> --}}

                                    {{-- <a href="{{route('productos', ['editar' => $producto->id])}}" class="addtocart-btn">Modificar</a> --}}

                                    {{-- <a href="{{ route('productos', ['editar' => $producto->id]) }}"
                                    class="addtocart-btn">Modificar</a> --}}

                                    {{-- <a href="#" class="addtocart-btn editProductBtn" data-product-id="{{ $producto->id }}">Modificar</a> --}}
                                    <button class="addtocart-btn"
                                        data-product-id="{{ $producto->id }}">Modificar</button>




                                    {{-- <a href="{{route('edit', $producto->id)}}" class="addtocart-btn">Modificar</a> --}}

                                </div>

                            </div>
                        </div>
                        <div id="no-results" style="display: none">
                            <p>No se encontraron resultados para tu búsqueda.</p>
                        </div>
                    @endforeach
                @else
                    <div class="no-products-container">
                        <div class="no-products-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h2 class="no-products-title">No hay productos agregados</h2>
                        <p class="no-products-description">Parece que aún no se han agregado productos. ¡Comienza a añadir
                            productos para verlos aquí!</p>
                        {{-- <a href="{{ route('producto.create') }}" class="add-product-btn">Agregar Producto</a> --}}
                    </div>
                @endif

            </div>

        </div>

    </div>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let cerrar = document.querySelectorAll(".close")[0];
        let abrir = document.querySelectorAll(".addmoney")[0];
        let modal = document.querySelectorAll(".modal")[0];
        let modalC = document.querySelectorAll(".modal-container")[0];

        const increment = document.querySelector('.increment');
        const decrement = document.querySelector('.decrement');
        const num = document.querySelector('.num');


        document.addEventListener('DOMContentLoaded', function() {


            const unidadMedidaSelect = document.getElementById('unidad_medida_id');
            const cantidadInput = document.getElementById('cantidad');
            const cantidadBaseContainer = document.getElementById('cantidad_base_container');
            const cantidadBaseInput = document.getElementById('cantidad_unidad_compuesta');
            const cantidadTotalInput = document.getElementById('cantidad_total');

            // Función para actualizar la cantidad total
            function updateCantidadTotal() {
                const cantidad = parseFloat(cantidadInput.value) || 0;
                const cantidadBase = parseFloat(cantidadBaseInput.value) || 1;
                cantidadTotalInput.value = cantidad * cantidadBase;
            }

            // Cambia la visibilidad del campo cantidad base y actualiza la cantidad total
            unidadMedidaSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const esCompuesta = selectedOption.getAttribute('data-es-compuesta') === '1';

                cantidadBaseContainer.style.display = esCompuesta ? 'block' : 'none';

                if (!esCompuesta) {
                    cantidadBaseInput.value = ''; // Limpia el campo si no es compuesto
                    updateCantidadTotal(); // Actualiza el total si no hay base
                }
            });

            // Actualiza la cantidad total al cambiar la cantidad o al ingresar unidades por caja
            cantidadInput.addEventListener('input', updateCantidadTotal);
            cantidadBaseInput.addEventListener('input', updateCantidadTotal);

        });

        // Función para actualizar el valor
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

        document.getElementById('image-input').addEventListener('change', function(e) {
            var preview = document.getElementById('preview-image');
            preview.src = URL.createObjectURL(e.target.files[0]);
        });


        document.getElementById('unidad_medida_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var esCompuesta = selectedOption.getAttribute('data-es-compuesta') === '1';
            document.getElementById('cantidad_base_container').style.display = esCompuesta ? 'block' : 'none';
        });

        document.getElementById('formulario').addEventListener('submit', function(event){
            var cantidadMinima = parseFloat(document.getElementById('cantidad_minima').value);
            var cantidad = parseFloat(document.getElementById('cantidad').value);

            if(cantidadMinima > cantidad){
                alert('La cantidad minima no puede ser mayor que la cantidad.');
                event.preventDefault();
            }
        });

        const inputField = document.querySelector('.input');
        const cards = document.querySelectorAll('.product-card');
        const noResultsMessage = document.getElementById('no-results');
        let resultsFound = false;

        inputField.addEventListener('input', function() {
            const searchTerm = inputField.value.trim().toLowerCase();
            let resultsFound = false;

            cards.forEach(function(card) {
                const productName = card.querySelector('.product-name').textContent
                    .toLowerCase();
                const productCategory = card.querySelector('.product-category').textContent
                    .toLowerCase();

                if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
                    // card.style.display = 'block';
                    // card.classList.remove('hidden');
                    card.style.display = 'block';
                    resultsFound = true;
                } else {
                    card.style.display = 'none';
                }
            });

            if (resultsFound) {
                noResultsMessage.style.display = 'none';
            } else {
                noResultsMessage.style.display = 'block';
            }
        });

        $(document).ready(function() {
            // Abrir el modal
            $(document).on('click', '.addtocart-btn', function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                $.ajax({
                    url: '/productos/' + productId + '/edit',
                    type: 'GET',
                    success: function(response) {
                        $('#editModalBody').html(response);
                        $('#editProductModal').show();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Cerrar el modal
            $(document).on('click', '#editProductModal .close', function() {
                $('#editProductModal').hide();
            });

            // Cerrar el modal haciendo clic fuera de él
            $(window).click(function(event) {
                if (event.target == $('#editProductModal')[0]) {
                    $('#editProductModal').hide();
                }
            });

        });

        const eliminarBotones = document.querySelectorAll('.btn-eliminar');
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
                            text: "Su producto se ha eliminado.",
                            icon: "success"
                        });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelado",
                            icon: "error"
                        });
                    }
                });

            });
        });

        // document.getElementById('cantidad').addEventListener('blur', function(e) {
        //     let value = e.target.value;


        //     if (value.includes('/')) {
        //         let parts = value.split('/');
        //         if (parts.length === 2) {
        //             let numerator = parseFloat(parts[0]);
        //             let denominator = parseFloat(parts[1]);
        //             if (!isNaN(numerator) && !isNaN(denominator) && denominator !== 0) {
        //                 e.target.value = (numerator / denominator).toFixed(2);
        //             }
        //         }
        //     }


        //     let numericValue = parseFloat(value);
        //     if (!isNaN(numericValue)) {
        //         e.target.value = numericValue.toFixed(2);
        //     }


        // });
    </script>
@endpush
