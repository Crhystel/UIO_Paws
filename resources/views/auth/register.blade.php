@extends('layouts.app')

@section('title', 'Crear Cuenta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card">
            <div class="card-header text-center bg-white border-0 pt-4">
                <h4 class="card-title">Crear una Cuenta</h4>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                    <div class="d-grid">
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