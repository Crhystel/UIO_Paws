@extends('layouts.app')

@section('title', 'Catálogo de Artículos para Donación')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Catálogo de Artículos para Donación</h1>
        <a href="{{ route('admin.donation-items.create') }}" class="btn btn-success">+ Añadir Nuevo Artículo</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Artículo</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item['id_donation_item_catalog'] }}</td>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['description'] ?? 'N/A' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.donation-items.edit', $item['id_donation_item_catalog']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.donation-items.destroy', $item['id_donation_item_catalog']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este artículo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No hay artículos en el catálogo.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection