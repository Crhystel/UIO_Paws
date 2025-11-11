@extends('layouts.app')

@section('title', 'Editar Refugio')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h1 class="h3 mb-0">Editar Refugio: {{ $shelter['shelter_name'] }}</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shelters.update', $shelter['id_shelter']) }}" method="POST">
                @method('PUT')
                @include('admin.shelters.form', ['shelter' => $shelter, 'buttonText' => 'Actualizar Refugio'])
            </form>
        </div>
    </div>
</div>
@endsection