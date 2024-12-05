@extends('layout')

@section('title', 'Inventario')

@section('content')
    <link rel="icon" href="/assets/Recursos/icoprin.ico">

    <div id="dynamic-content">

        <link rel="stylesheet" href="/assets/css/reportes.css">
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
            rel="stylesheet">

        <div class="container-fluid py-4">

            <header>
                <div class="top-container">
                    <div class="top-left">
                        <h1 style="color: #ffffff; font-size: 2.5rem; font-family: 'Playfair Display', serif;">Reportes</h1>
                    </div>
                </div>
            </header>


            <div class="row justify-content-center">



                <form class="form" action="{{ route('reportes.export') }}">
                    <button class="download-button" type="submit">
                        <div class="docs"><svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round"
                                fill="none" stroke-width="2" stroke="currentColor" height="20" width="20"
                                viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line y2="13" x2="8" y1="13" x1="16"></line>
                                <line y2="17" x2="8" y1="17" x1="16"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg> Descargar Reporte</div>

                        <div class="download">
                            <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none"
                                stroke-width="2" stroke="currentColor" height="24" width="24" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line y2="3" x2="12" y1="15" x1="12"></line>
                            </svg>
                        </div>
                    </button>
                </form>




                <div class="col-12 col-lg-10">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table custom-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Usuario</th>
                                            <th>Vicepresidencia</th>
                                            <th>Dirección</th>
                                            <th>Departamento</th>
                                            <th>Cantidad utilizada</th>
                                            <th>Fecha</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($movimientos as $movimiento)
                                            <tr>
                                                <td>
                                                    @if ($movimiento->producto)
                                                        {{ $movimiento->producto->nombre }}
                                                        @if ($movimiento->producto->trashed())
                                                            <span class="text-muted">(Producto eliminado)</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted" style="color: hsl(0, 95%, 63%);">Producto
                                                            no
                                                            disponible</span>
                                                    @endif

                                                <td>
                                                    @if ($movimiento->usuario)
                                                        {{ $movimiento->usuario->nombres }}
                                                        {{ $movimiento->usuario->apellidos }}
                                                        @if ($movimiento->usuario->trashed())
                                                            <span class="text-muted">(Usuario eliminado)</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted" style="color: hsl(0, 95%, 63%);">Usuario no
                                                            disponible</span>
                                                    @endif
                                                </td>
                                                <td>{{ $movimiento->infoMovimiento->vicepresidencia }}</td>
                                                <td>{{ $movimiento->infoMovimiento->direccion }}</td>
                                                <td>{{ $movimiento->infoMovimiento->departamento }}</td>

                                                <td>

                                                    @if (optional($movimiento->producto)->unidadMedida)

                                                        @if (optional($movimiento->producto->unidadMedida)->es_compuesta)

                                                            @if ($movimiento->producto->cantidad_unidad_compuesta !== null)
                                                                {{ formatNumber($movimiento->cantidadUsada) }}
                                                                unidad{{ $movimiento->cantidadUsada > 1 ? 'es' : '' }}
                                                            @else
                                                                {{ formatNumber($movimiento->cantidadUsada) }}
                                                                {{ optional($movimiento->producto->unidadMedida)->nombre }}
                                                            @endif
                                                        @else

                                                            {{ formatNumber($movimiento->cantidadUsada) }}
                                                            {{ optional($movimiento->producto->unidadMedida)->nombre }}
                                                        @endif
                                                    @else

                                                        <span class="text-muted">Cantidad no disponible</span>
                                                    @endif

                                                </td>
                                                <td>{{ $movimiento->fecha }}</td>
                                                <td>

                                                    <form method="POST"
                                                        action="{{ route('reportes.destroy', $movimiento->id) }}"
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

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- validacion reporte --}}
    {{--
    <div id="custom-alert-bg" class="custom-alert-bg"></div>
    <div id="custom-alert" class="custom-alert">
        <div class="custom-alert-content">
            <div class="custom-alert-header">
                <img src="https://cdn-icons-png.freepik.com/256/12176/12176941.png?semt=ais_hybrid" alt="Icon">
            </div>

            <p>¿Estás seguro de que deseas descargarlo?</p>
            <div class="custom-alert-buttons">
                <button id="custom-confirm-yes" class="custom-confirm-yes">Sí, Descargar</button>
                <button id="custom-confirm-cancel" class="custom-confirm-cancel">Cancelar</button>
            </div>
        </div>
    </div> --}}
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/r-2.4.1/datatables.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                    paginate: {
                        previous: '◄',
                        next: '►'
                    }
                },
                "dom": '<"top"lf>rt<"bottom"ip><"clear">',
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todos"]
                ],
                "pageLength": 10,
                "pagingType": "simple"
            });


            $('.download-button').on('click', function(e) {
                e.preventDefault();

                // var params = table.ajax.params();
                // params.export = true;
                // window.location.href = "{{ route('reportes.export') }}?" + $.param(params);

                var params = {
                    search: table.search(),
                    order: table.order().map(function(order) {
                        return {
                            colum: order[0],
                            dir: order[1]
                        }
                    }),

                    length: table.page.len(),
                    start: table.page.info().start,
                    export: true
                };

                window.location.href = "{{ route('reportes.export') }}?" + $.param(params);

            });
        });

        const eliminarBotones = document.querySelectorAll('.btn-eliminar');

        eliminarBotones.forEach(function(boton) {
            boton.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#72c6ee",
                    cancelButtonColor: "#fd604b",
                    confirmButtonText: "¡Sí, elimínalo!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        boton.submit({
                            title: "¡Eliminado!",
                            text: "Su archivo ha sido eliminado.",
                            icon: "success"
                        });
                    }
                });
            });
        });
    </script>
@endpush
