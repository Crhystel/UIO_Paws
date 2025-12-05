@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <h1>Editar un Usuario: {{ $user['name'] }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user['email'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Rol</label>
                    <select name="role" id="role" class="form-select">
                        <option value="user" {{ $user['role'] == 'user' ? 'selected' : '' }}>Usuario</option>
                        <option value="admin" {{ $user['role'] == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar los Cambios</button>
            </form>
        </div>
    </div>
@endsection
