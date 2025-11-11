@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')
    <h1>Crear Nuevo Usuario</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.users.store') }}" method="POST">
                @csrf
                
                @include('superadmin.users.form', ['user' => null])

                <div class="mt-4">
                    <a href="{{ route('superadmin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                </div>
            </form>
        </div>
    </div>
@endsection