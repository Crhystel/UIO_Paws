@extends('layouts.app')

@section('title', 'Panel de Super Administrador')

@section('content')
    <h1 class="mb-4">Panel de Super Administrador</h1>
    <p class="lead">Bienvenido, {{ Session::get('user_name') }}. Desde aquí tienes control total sobre los usuarios del sistema.</p>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Usuarios</h5>
                    <p class="card-text">Crear nuevos administradores, editar perfiles de usuario o eliminar cuentas del sistema.</p>
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-danger">Administrar Usuarios</a>
                </div>
            </div>
        </div>
    </div>
@endsection