@extends('layouts.app')

@section('title', 'Añadir Animal')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0">Añadir Nuevo Animal</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.animals.store') }}" method="POST">
                @include('admin.animals.form', ['buttonText' => 'Crear Animal'])
            </form>
        </div>
    </div>
</div>
@endsection