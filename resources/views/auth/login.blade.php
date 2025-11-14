@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header text-center bg-white border-0 pt-4">
                <h4 class="card-title">Iniciar Sesión</h4>
            </div>
            <div class="card-body px-4 pb-4">
                {{-- CAMBIO 1: Se elimina el 'action' y se añade un 'id' al formulario --}}
                <form id="login-form" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        {{-- CAMBIO 2: Se elimina la clase @error de Blade --}}
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        {{-- Se añade un div para mostrar errores de la API --}}
                        <div class="invalid-feedback" id="email-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        {{-- Se añade un div para mostrar errores de la API --}}
                        <div class="invalid-feedback" id="password-error"></div>
                    </div>
                    <div class="d-grid">
                         <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
                <div class="text-center mt-3">
                    <small>¿No tienes una cuenta? <a href="{{ route('register.form') }}">Regístrate aquí</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- CAMBIO 3: Se añade un bloque de JavaScript para enviar el formulario a la API --}}
@push('scripts')
<script>
    document.getElementById('login-form').addEventListener('submit', function(event) {
        // Prevenimos que el formulario se envíe de la forma tradicional
        event.preventDefault();

        // Limpiamos los errores de un intento anterior
        document.getElementById('email-error').textContent = '';
        document.getElementById('email').classList.remove('is-invalid');
        document.getElementById('password-error').textContent = '';
        document.getElementById('password').classList.remove('is-invalid');

        // Recolectamos los datos del formulario
        const formData = new FormData(this);
        // La URL de tu API en producción
        const apiUrl = 'https://uiopaws-api-app-ege6befaefczbkef.chilecentral-01.azurewebsites.net/api/login';

        // Usamos 'fetch' para enviar los datos a la API
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Accept': 'application/json', // Muy importante para que la API responda en JSON
            },
            body: formData
        })
        .then(response => {
            // Si la respuesta no es exitosa (ej. 422, 401), la convertimos en un error
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw errorData;
                });
            }
            return response.json(); // Si es exitosa, la procesamos
        })
        .then(data => {
            // ÉXITO: El inicio de sesión fue correcto
            alert('¡Inicio de sesión exitoso!');
            
            // Aquí es donde guardarías el token de autenticación que te devuelve la API
            // Ejemplo: localStorage.setItem('auth_token', data.token);
            
            // Redirigimos al usuario al dashboard o a la página principal
            window.location.href = '/dashboard';
        })
        .catch(errorData => {
            // ERROR: La API devolvió un error
            console.error('Error desde la API:', errorData);

            if (errorData.errors) {
                // Si son errores de validación (ej. email no válido)
                if (errorData.errors.email) {
                    document.getElementById('email').classList.add('is-invalid');
                    document.getElementById('email-error').textContent = errorData.errors.email[0];
                }
                if (errorData.errors.password) {
                    document.getElementById('password').classList.add('is-invalid');
                    document.getElementById('password-error').textContent = errorData.errors.password[0];
                }
            } else if (errorData.message) {
                // Si es un error general (ej. "Las credenciales no coinciden")
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('password-error').textContent = errorData.message;
            } else {
                // Si es un error inesperado
                alert('Ocurrió un error inesperado. Por favor, intenta de nuevo.');
            }
        });
    });
</script>
@endpush