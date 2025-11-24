@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Panel de Administración</h1>
    <p class="lead">Gestiona los animales, refugios, revisa las solicitudes y administra el contenido.</p>
    
    <div class="row mt-4 g-4">
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Gestionar Animales</h5>
                    <p class="card-text">Añadir, editar o eliminar perfiles de animales.</p>
                    <a href="{{ route('admin.animals.index') }}" class="btn btn-primary mt-auto">Ir a Animales</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Gestionar Especies</h5>
                    <p class="card-text">Añadir o editar especies (ej: Perro, Gato).</p>
                    <a href="{{ route('admin.species.index') }}" class="btn btn-secondary mt-auto">Ir a Especies</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Gestionar Razas</h5>
                    <p class="card-text">Añadir o editar razas para cada especie.</p>
                    <a href="{{ route('admin.breeds.index') }}" class="btn btn-secondary mt-auto">Ir a Razas</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Gestionar Refugios</h5>
                    <p class="card-text">Administrar la información de los refugios.</p>
                    <a href="{{ route('admin.shelters.index') }}" class="btn btn-primary mt-auto">Ir a Refugios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Catálogo de Donaciones</h5>
                    <p class="card-text">Administrar los artículos que se pueden donar.</p>
                    <a href="{{ route('admin.donation-items.index') }}" class="btn btn-primary mt-auto">Ir al Catálogo</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Gestionar Voluntariado</h5>
                    <p class="card-text">Crear y editar las oportunidades de voluntariado.</p>
                    <a href="{{ route('admin.volunteer-opportunities.index') }}" class="btn btn-primary mt-auto">Ir a Voluntariado</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Revisar Solicitudes</h5>
                    <p class="card-text">Ver solicitudes de adopción y voluntariado.</p>
                    <a href="{{ route('admin.applications.adoption.index') }}" class="btn btn-warning mt-auto">Revisar Adopciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection