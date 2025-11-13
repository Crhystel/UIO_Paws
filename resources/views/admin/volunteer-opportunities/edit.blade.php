@extends('layouts.app')
@section('title', 'Editar Oportunidad')
@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header"><h1 class="h3 mb-0">Editar Oportunidad: {{ $opportunity['title'] }}</h1></div>
        <div class="card-body">
            <form action="{{ route('admin.volunteer-opportunities.update', $opportunity['id_volunteer_opportunity']) }}" method="POST">
                @method('PUT')
                @include('admin.volunteer-opportunities.form', ['buttonText' => 'Actualizar Oportunidad'])
            </form>
        </div>
    </div>
</div>
@endsection