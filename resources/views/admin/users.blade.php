@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <h1>Panel de Administración de Usuarios</h1>
    <p>Aquí puedes ver todos los usuarios del sistema.</p>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user['id'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td><span class="badge bg-{{ $user['role'] === 'admin' ? 'success' : 'secondary' }}">{{ $user['role'] }}</span></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Editar</a>
                                <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection