@extends('layouts.app')
@section('title', 'Gestión de Especies')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gestión de Especies</h1>
        <a href="{{ route('admin.species.create') }}" class="btn btn-primary">Añadir Especie</a>
    </div>
    @include('partials.alerts')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($species as $specie)
                        <tr>
                            <td>{{ $specie['species_name'] }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.species.edit', $specie['id_species']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.species.destroy', $specie['id_species']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">No hay especies registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection