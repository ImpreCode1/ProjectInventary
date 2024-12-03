<div class="nombre-pagina">
    {{-- <ion-icon name="clipboard-outline" id="cloud"></ion-icon> --}}
    <ion-icon name="menu-outline" id="cloud"></ion-icon>

    <span>Inventario</span>
</div>
{{-- <button class="botton">
    <ion-icon name="desktop-outline"></ion-icon>
    <span>Bienvenidos</span>
</button> --}}
<nav class="navegacion">
    <ul>
        <li>
            <a href="{{ route('categorias') }}" class="nav-link">
                <ion-icon name="duplicate-outline"></ion-icon>
                <span>Gestionar Inventario</span>
            </a>
        </li>
        <li>
            <a href="{{ route('productos') }}" class="nav-link">
                <ion-icon name="layers-outline"></ion-icon>
                <span>Productos</span>
            </a>
        </li>
        <li>
            <a href="{{route('stock')}}" class="nav-link">
                <ion-icon name="server-outline"></ion-icon>
                <span>En stock</span>
            </a>
        </li>
        <li>
            <a href="{{ route('reportes') }}" class="nav-link">
                <ion-icon name="receipt-outline"></ion-icon>
                <span>Reportes</span>
            </a>
        </li>
        <li>
            <a href="{{ route('usuarios') }}" class="nav-link">
                <ion-icon name="people-outline"></ion-icon>
                <span>Ver Usuarios</span>
            </a>
        </li>
        <li>
            <a href="{{ route('admin.perfil.edit', auth()->id()) }}" class="nav-link">
                <ion-icon name="person-outline"></ion-icon>
                <span>Mi Perfil</span>
            </a>
        </li>
    </ul>
</nav>
<div class="linea"></div>
<div class="modo-oscuro">
    <div class="info">
        <ion-icon name="moon-outline"></ion-icon>
        <span>Modo Oscuro</span>
    </div>
    <div class="switch">
        <div class="base">
            <div class="circulo"></div>
        </div>
    </div>
</div>
<div class="usuario">
    <img src="{{ asset($userImagen) }}" alt="Imagen Usuario">
    <div class="info-usuario">
        <div class="nombre-email">
            <span class="nombre">{{ $userNombres ?? '' }}</span>
            <span class="email">{{$userRol}}</span>
        </div>
        <ion-icon name="ellipsis-vertical-outline"></ion-icon>
    </div>
</div>
<div class="exit">
    <div class="info">
        <a class="enlace-salir" style="text-decoration:none" href="{{ route('landing') }}">
            <ion-icon name="exit-outline"></ion-icon>
            <span>Regresar</span>
        </a>
    </div>
</div>
