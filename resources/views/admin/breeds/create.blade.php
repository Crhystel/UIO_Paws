@extends('layouts.app')
@section('title', 'Añadir Raza')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Añadir Nueva Raza</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.breeds.store') }}" method="POST">
                @include('admin.breeds.form', ['buttonText' => 'Crear Raza'])
            </form>
        </div>
    </div>
</div>
@endsection