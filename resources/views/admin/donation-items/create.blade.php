@extends('layouts.app')

@section('title', 'Añadir Nuevo Artículo')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Añadir Nuevo Artículo al Catálogo</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.donation-items.store') }}" method="POST">
                @include('admin.donation-items.form', ['buttonText' => 'Crear Artículo'])
            </form>
        </div>
    </div>
</div>
@endsection