@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <h1>Editar Usuario: {{ $user['first_name'] }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.users.update', $user['id_user']) }}" method="POST">
                @csrf
                @method('PUT')
                @include('superadmin.users._form')

                <div class="mt-4">
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection