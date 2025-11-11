@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Gestión de Usuarios</h1>
        <a href="{{ route('superadmin.users.create') }}" class="btn btn-primary">Crear Nuevo Usuario</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
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
                            <td>{{ $user['id_user'] }}</td>
                            <td>{{ $user['first_name'] }} {{ $user['last_name'] }}</td>
                            <td>{{ $user['email'] }}</td>
                            <td>
                                @if(!empty($user['roles']))
                                    <span class="badge bg-info text-dark">{{ $user['roles'][0]['name'] }}</span>
                                @else
                                    <span class="badge bg-secondary">Sin rol</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.users.edit', $user['id_user']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('superadmin.users.destroy', $user['id_user']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
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