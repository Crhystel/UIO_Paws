@extends('layouts.app')
@section('title', 'Gestión de Razas')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gestión de Razas</h1>
        <a href="{{ route('admin.breeds.create') }}" class="btn btn-primary">Añadir Raza</a>
    </div>
    @include('partials.alerts')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre de la Raza</th>
                        <th>Especie</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($breeds as $breed)
                        <tr>
                            <td>{{ $breed['breed_name'] }}</td>
                            <td>{{ $breed['species']['species_name'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.breeds.edit', $breed['id_breed']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.breeds.destroy', $breed['id_breed']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">No hay razas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection