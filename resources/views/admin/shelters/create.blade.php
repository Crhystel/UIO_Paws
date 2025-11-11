@extends('layouts.app')

@section('title', 'Añadir Refugio')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0">Añadir Nuevo Refugio</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shelters.store') }}" method="POST">
                @include('admin.shelters.form', ['buttonText' => 'Crear Refugio'])
            </form>
        </div>
    </div>
</div>
@endsection