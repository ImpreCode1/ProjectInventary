

{{-- <div class="panel-lateral"> --}}
    <div class="titulo-panel">
      <ion-icon name="menu-outline" id="toggle-menu"></ion-icon>
      <span class="etiqueta-menu">Inventario</span>
    </div>
    
    <nav class="menu-navegacion">
      <ul>
        <li>
          <a href="#" class="enlace-nav activo">
            <ion-icon name="home-outline"></ion-icon>
            <span class="etiqueta-menu">Inicio</span>
          </a>
        </li>
        <li>
          <a href="{{route('verproductos')}}" class="enlace-nav">
            <ion-icon name="bag-outline"></ion-icon>
            <span class="etiqueta-menu">Ver productos</span>
          </a>
        </li>
        <li>
          <a href="{{ route('perfil.edit', auth()->id()) }}" class="enlace-nav">
            <ion-icon name="person-outline"></ion-icon>
            <span class="etiqueta-menu">Perfil</span>
          </a>
        </li>
      </ul>
    </nav>
  
    <div class="separador"></div>
  
    <div class="selector-tema">
      <div class="info-tema">
        <ion-icon name="moon-outline"></ion-icon>
        <span class="etiqueta-menu">Tema Oscuro</span>
      </div>
      <div class="toggle-tema">
        <div class="toggle-base">
          <div class="toggle-circulo"></div>
        </div>
      </div>
    </div>
  
    <div class="info-usuario">
      <img src="{{asset($userImagen)}}" alt="Imagen Usuario">
      <div class="detalles-usuario">
        <div class="nombre-correo">
          <span class="nombre">{{$userNombres ?? 'Usuario'}}</span>
          <span class="correo">{{$userRol ?? 'Rol'}}</span>
        </div>
        {{-- <ion-icon name="ellipsis-vertical-outline"></ion-icon> --}}
      </div>
    </div>
  
    <div class="boton-salir">
      <a href="{{route('landinguser')}}" class="enlace-salir">
        <ion-icon name="log-out-outline"></ion-icon>
        <span class="etiqueta-menu">Regresar</span>
      </a>
    </div>
  {{-- </div> --}}