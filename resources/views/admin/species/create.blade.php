@extends('layouts.app')
@section('title', 'Añadir Especie')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Añadir Nueva Especie</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.species.store') }}" method="POST">
                @include('admin.species.form', ['buttonText' => 'Crear Especie'])
            </form>
        </div>
    </div>
</div>
@endsection