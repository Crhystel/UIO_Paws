@extends('layouts.app')
@section('title', 'Editar Especie')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Editar Especie: {{ $species['species_name'] }}</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.species.update', $species['id_species']) }}" method="POST">
                @method('PUT')
                @include('admin.species.form', ['species' => $species, 'buttonText' => 'Actualizar Especie'])
            </form>
        </div>
    </div>
</div>
@endsection