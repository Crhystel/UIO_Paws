@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <h1 class="mb-4">Panel de Administración</h1>
    <p class="lead">Gestiona los animales, revisa las solicitudes y administra el contenido del refugio.</p>
    
    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Gestionar Animales</h5>
                    <p class="card-text">Añadir, editar o eliminar perfiles de animales.</p>
                    <a href="#" class="btn btn-primary">Ir a Animales</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Revisar Solicitudes</h5>
                    <p class="card-text">Ver y aprobar solicitudes de adopción y voluntariado.</p>
                    <a href="#" class="btn btn-primary">Ir a Solicitudes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Catálogo de Donaciones</h5>
                    <p class="card-text">Administrar los artículos que se necesitan.</p>
                    <a href="#" class="btn btn-primary">Ir al Catálogo</a>
                </div>
            </div>
        </div>
    </div>
@endsection