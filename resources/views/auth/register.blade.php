@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-7">
        <div class="card">
            <div class="card-header text-center bg-white border-0 pt-4">
                <h4 class="card-title">Crear una Cuenta</h4>
                <p class="text-muted">Completa tus datos para unirte a nuestra comunidad.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="middle_name" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">
                            @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                         <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="second_last_name" class="form-label">Apellido Materno</label>
                            <input type="text" class="form-control @error('second_last_name') is-invalid @enderror" id="second_last_name" name="second_last_name" value="{{ old('second_last_name') }}">
                            @error('second_last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <hr>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="document_type" class="form-label">Tipo de Documento <span class="text-danger">*</span></label>
                            <select class="form-select @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required>
                                <option value="" disabled selected>Selecciona una opción...</option>
                                <option value="Cédula" {{ old('document_type') == 'Cedula' ? 'selected' : '' }}>Cédula</option>
                                <option value="Pasaporte" {{ old('document_type') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="Otro" {{ old('document_type') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('document_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="document_number" class="form-label">Número de Documento <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('document_number') is-invalid @enderror" id="document_number" name="document_number" value="{{ old('document_number') }}" required>
                            @error('document_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                     <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono de Contacto <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    {{-- CREDENCIALES --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </div>
                </form>
                 <div class="text-center mt-3">
                    <small>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection