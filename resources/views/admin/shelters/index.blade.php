@extends('layouts.app')

@section('title', 'Gestión de Refugios')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gestión de Refugios</h1>
        <a href="{{ route('admin.shelters.create') }}" class="btn btn-primary">Añadir Refugio</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email de Contacto</th>
                        <th>Teléfono</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shelters as $shelter)
                        <tr>
                            <td>{{ $shelter['shelter_name'] }}</td>
                            <td>{{ $shelter['contact_email'] }}</td>
                            <td>{{ $shelter['phone'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.shelters.edit', $shelter['id_shelter']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.shelters.destroy', $shelter['id_shelter']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este refugio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay refugios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection