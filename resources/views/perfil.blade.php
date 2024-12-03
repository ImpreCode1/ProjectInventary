@extends('layout2')

@section('title', 'Inventario')


@section('content')
    <link rel="stylesheet" href="/assets/css/perfil.css">
    <link rel="icon" href="/assets/Recursos/icoprin.ico">
    <form method="POST" class="form" action="{{ route('perfil.update', $usuario->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="content-profile-page">
            <div class="profile-user-page card">
                <div class="img-user-profile">
                    <img class="profile-bgHome"
                        src="https://plus.unsplash.com/premium_photo-1702217998652-b9b795f52d5f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8ODV8fGZvbmRvJTIwcHJlZGV0ZXJtaW5hZG8lMjBwYXJhJTIwcGVyZmlsZXN8ZW58MHx8MHx8fDA%3D"
                        alt="Background Image" />

                    <label for="avatar-input" style="cursor: pointer">
                        <img id="avatar-preview" class="avatar" src="{{ asset($usuario->imagen) }}"
                            alt="User Avatar" />
                    </label>
                    <input type="file" id="avatar-input" name="imagen" style="display: none;" accept="image/*">
                    @if ($errors->has('imagen'))
                        <p class="error-message">{{ $errors->first('imagen') }}</p>
                    @endif
                </div>
                <div class="user-profile-data">
                    <h1 style="cursor: not-allowed">{{ $usuario->nombres }} {{ $usuario->apellidos }}</h1>
                    <p style="cursor: not-allowed">{{ $usuario->email }}</p>
                </div>

                <div class="edit-profile-form">
                    <div class="edit-profile-form">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap:15px">
                            <div class="input-container">
                                <input type="text" id="nombres" name="nombres"
                                    value="{{ old('nombres', $usuario->nombres) }}">
                                <label for="input" class="label">Nombres</label>
                                <div class="underline"></div>
                                @error('nombres')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="input-container">
                                <input type="text" id="apellidos" name="apellidos"
                                    value="{{ old('apellidos', $usuario->apellidos) }}" required="">
                                <label for="input" class="label">Apellidos</label>
                                <div class="underline"></div>
                                @error('apellidos')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap:15px">
                            <div class="input-container">
                                <input type="password" id="password" name="password">
                                <label for="password" class="label">Nueva Contraseña</label>
                                <div class="underline"></div>
                                <i class="toggle-password fas fa-eye" onclick="togglePassword('password')"></i>
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="input-container">
                                <input type="password" id="password_confirmation" name="password_confirmation">
                                <label for="password_confirmation" class="label">Confirmar Contraseña</label>
                                <div class="underline"></div>
                                <i class="toggle-password fas fa-eye" onclick="togglePassword('password_confirmation')"></i>
                            </div>

                        </div>

                        <button type="submit" class="btn-edit">
                            Guardar Cambios
                            <span class="followers"></span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="custom-alert-bg" class="custom-alert-bg"></div>
    <div id="custom-alert" class="custom-alert">
        <div class="custom-alert-content">
            <div class="custom-alert-header">
                <img src="https://cdn-icons-png.flaticon.com/128/1954/1954511.png"
                    alt="Icono de usuario">
            </div>
            <h2>¿Está seguro de que desea editar su perfil?</h2>
            <div class="custom-alert-buttons">
                <button id="custom-confirm-yes" class="custom-confirm-yes">Sí, editar perfil</button>
                <button id="custom-confirm-cancel" class="custom-confirm-cancel">Cancelar</button>
            </div>

        </div>
    </div>


    
@endsection

@push('scripts')
    <script>
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
        });

        function togglePassword(inputId) {
            var input = document.getElementById(inputId);
            var icon = input.nextElementSibling.nextElementSibling;
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        document.getElementById('avatar-input').addEventListener('change', function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatar-preview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        });
    </script>
@endpush
