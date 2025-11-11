@extends('layouts.app')
@section('title', 'Editar Raza')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Editar Raza: {{ $breed['breed_name'] }}</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.breeds.update', $breed['id_breed']) }}" method="POST">
                @method('PUT')
                @include('admin.breeds.form', ['breed' => $breed, 'buttonText' => 'Actualizar Raza'])
            </form>
        </div>
    </div>
</div>
@endsection