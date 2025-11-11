@extends('layouts.app')

@section('title', 'Gestión de Animales')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Gestión de Animales</h1>
        <a href="{{ route('admin.animals.create') }}" class="btn btn-primary">Añadir Animal</a>
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
                        <th>Especie / Raza</th>
                        <th>Refugio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($animals as $animal)
                        <tr>
                            <td>{{ $animal['animal_name'] }}</td>
                            <td>{{ $animal['breed']['species']['species_name'] }} / {{ $animal['breed']['breed_name'] }}</td>
                            <td>{{ $animal['shelter']['shelter_name'] }}</td>
                            <td><span class="badge bg-secondary">{{ $animal['status'] }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.animals.edit', $animal['id_animal']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.animals.destroy', $animal['id_animal']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este animal?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay animales registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if (!empty($paginator['links']))
            <div class="card-footer">
                <nav>
                    <ul class="pagination justify-content-center">
                        @foreach ($paginator['links'] as $link)
                            <li class="page-item {{ $link['active'] ? 'active' : '' }} {{ $link['url'] == null ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $link['url'] }}">{!! $link['label'] !!}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</div>
@endsection