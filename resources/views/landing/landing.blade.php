<!DOCTYPE html>
<html lang="en">

<head>
    @notifyCss
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Impresistem</title>
    <link rel="stylesheet" href="/assets/css/landing.css">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">


</head>

<body>

    <header>
        <nav>
            <div class="logo">
                <a href="#" style="Color:#A46935">Inventario</a>
            </div>
            <ul>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
                <li><a style="Color:#5A483D"></a></li>
            </ul>

            <div class="user-profile">
                <img src="{{ asset($userImagen) }}" alt="Profile Picture" class="profile-picture">
                <span class="username">{{ $userNombres ?? '' }} {{ $userApellidos ?? '' }}</span>
            </div>
            <div>
                <a class="Btn" href="{{route('logouts')}}">
                    <div class="sign"><svg viewBox="0 0 512 512">
                            <path
                                d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                            </path>
                        </svg></div>
                    <div class="text">Salir</div>
                </a>
            </div>
        </nav>
    </header>
    <main>

        <section class="hero">
            <div class="hero-content">
                <h1 style="color:rgb(247, 155, 75) ">Bienvenido a Nuestro Sistema de Inventario de Productos</h1>
                <p>Explora y gestiona eficientemente nuestro catalogo de productos con nuestra intuitiva plataforma
                    de inventario. Aqui encontraras todas las herramientas necesarias para mantener un control preciso
                    y actualizado, optimizando asi tu tiempo y recursos.
                </p>
                <a href="{{ route('categorias') }}" class="btn">Comenzar</a>
            </div>
        </section>

        <section class="registration">
            <div class="registration-content">
                <h2>Gestion de Usuarios</h2>
                <p>Administra el acceso a la plataforma de inventario de nuestra empresa registrando nuevos
                    administradores
                    y usuarios.</p>
            </div>
            <div class="form-container">
                <form method="POST" class="form" action="{{ route('usuario.store') }}" enctype="multipart/form-data">
                    @csrf
                    <h3 class="form-title">Registrar Usuario</h3>

                    <div class="form-group">
                        <div class="file-select">
                            <input type="file" id="imagen" name="imagen" accept="imagen/*" class="form-input"
                                style="display: none">
                        </div>
                        <div class="imagen-preview"></div>
                        @if ($errors->has('imagen'))
                            <small class="form-e">
                                <strong>{{ $errors->first('imagen') }}</strong>
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="text" id="nombres" name="nombres" value="{{ old('nombres', '') }}"
                            class="form-input" placeholder=" ">
                        <label for="nombres" class="form-label">Nombres</label>
                        @if ($errors->has('nombres'))
                            <small class="form-e">
                                <strong>{{ $errors->first('nombres') }}</strong>
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="text" id="apellidos" name="apellidos" value="{{ old('apellidos', '') }}"
                            class="form-input" placeholder=" ">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        @if ($errors->has('apellidos'))
                            <small class="form-e">
                                <strong>{{ $errors->first('apellidos') }}</strong>
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" value="{{ old('email', '') }}"
                            class="form-input" placeholder=" ">
                        <label for="email" class="form-label">Email</label>
                        @if ($errors->has('email'))
                            <small class="form-e">
                                <strong>{{ $errors->first('email') }}</strong>
                            </small>
                        @endif
                    </div>
                    <div class="form-group">
                        <select id="rol" name="rol" class="form-input" placeholder=" ">
                            <option class="form-label" disabled selected>Selecciona un rol</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Usuario">Usuario</option>
                        </select>
                        @if ($errors->has('rol'))
                            <small class="form-e">
                                <strong>{{ $errors->first('rol') }}</strong>
                            </small>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="password" id="password-input" name="password" value="{{ old('password', '') }}"
                            class="form-input" placeholder=" ">
                        <label for="password" class="form-label">Contraseña</label>
                        <span class="password-toggle-icon" onclick="togglePasswordVisibility()">&#128065;</span>

                        @if ($errors->has('password'))
                            <small class="form-d">
                                <strong>{{ $errors->first('password') }}</strong>
                            </small>
                        @endif
                    </div>
                    <br>
                    <br>
                    <button type="submit" class="form-btn">Registrar</button>
                </form>
            </div>
        </section>
    </main>
    <div id="custom-alert-bg" class="custom-alert-bg"></div>

    {{-- validacion  --}}
    <div id="custom-alert" class="custom-alert">
        <div class="custom-alert-content">
            <div class="custom-alert-header">
                <img src="https://img.icons8.com/?size=50&id=7819&format=png" alt="Icono de usuario">
            </div>
            <h2>¿Crear un nuevo usuario?</h2>
            <p>¿Estás seguro de que deseas crear un nuevo usuario?</p>
            <div class="custom-alert-buttons">
                <button id="custom-confirm-yes" class="custom-confirm-yes">Sí, crear usuario</button>
                <button id="custom-confirm-cancel" class="custom-confirm-cancel">Cancelar</button>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div>
                <p class="footer-text">
                    &copy; 2024 <span class="footer-logo">Impresistem</span>
                </p>
                <p class="footer-text">
                    Reservados todos los derechos.
                </p>
                <p class="footer-text">
                    Diseñado y desarrollado por <span class="designer-name">Kevin Jhoe Gomez</span>
                </p>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const imagenPreview = document.querySelector('.imagen-preview');
        const inputImagen = document.getElementById('imagen');

        imagenPreview.addEventListener('click', () => {
            inputImagen.click();
        });

        inputImagen.addEventListener('change', () => {
            const file = inputImagen.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    imagenPreview.innerHTML = '';
                    imagenPreview.appendChild(preview);
                };
                reader.readAsDataURL(file);
            } else {
                imagenPreview.innerHTML = '';
            }
        });


        // validacion 
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const customAlertBg = document.getElementById('custom-alert-bg');
            const customAlert = document.getElementById('custom-alert');
            const customConfirmYes = document.getElementById('custom-confirm-yes');
            const customConfirmCancel = document.getElementById('custom-confirm-cancel');

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
            //        position: "top-end",
            //        icon: "success",
            //        text: '{{ session('success') }}', 
            //        showConfirmButton: false,
            //        timer: 1500
            //      });
            // @endif

        });


        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-input');
            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';
        }

        function dismissAlert(element) {
            const alert = element.closest('.alert');
            alert.classList.add('fade-out');
            setTimeout(() => {
                alert.remove();
            }, 300);
        }
    </script>
     @notifyJs
     @include('notify::components.notify')
</body>

</html>
