@extends('layouts.app')
@section('title', 'Crear Oportunidad de Voluntariado')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Crear Nueva Oportunidad de Voluntariado</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.volunteer-opportunities.store') }}" method="POST">
                @include('admin.volunteer-opportunities.form', ['buttonText' => 'Crear Oportunidad'])
            </form>
        </div>
    </div>
</div>
@endsection