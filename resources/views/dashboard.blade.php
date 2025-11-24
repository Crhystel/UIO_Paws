@extends('layouts.app')

@section('title', 'Mi Panel')

@section('content')
    <h1 class="mb-4">Bienvenido a tu panel, {{ Session::get('user_name') }}!</h1>
    <p class="lead">Desde aquí podrás gestionar tus solicitudes de adopción, voluntariado y donaciones.</p>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mis Solicitudes</h5>
                    <p class="card-text">Revisa el estado de todas las solicitudes que has enviado.</p>
                    <a href="{{ route('adoption.my-applications') }}" class="btn btn-primary">Ver mis solicitudes</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mi Perfil</h5>
                    <p class="card-text">Actualiza tu información de contacto y detalles personales.</p>
                    <a href="#" class="btn btn-secondary">Editar perfil</a>
                </div>
            </div>
        </div>
    </div>
@endsection