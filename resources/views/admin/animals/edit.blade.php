@extends('layouts.app')

@section('title', 'Editar Animal')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0">Editar Animal: {{ $animal['animal_name'] }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.animals.update', $animal['id_animal']) }}" method="POST">
                @method('PUT')
                @include('admin.animals.form', ['animal' => $animal, 'buttonText' => 'Actualizar Animal'])
            </form>
        </div>
    </div>
</div>
@endsection