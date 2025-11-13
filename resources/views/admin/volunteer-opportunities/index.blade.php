@extends('layouts.app')
@section('title', 'Oportunidades de Voluntariado')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Gestionar Oportunidades de Voluntariado</h1>
        <a href="{{ route('admin.volunteer-opportunities.create') }}" class="btn btn-success">+ Nueva Oportunidad</a>
    </div>
    @include('partials.alerts')
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($opportunities as $opportunity)
                        <tr>
                            <td>{{ $opportunity['title'] }}</td>
                            <td>
                                @if($opportunity['is_active'])
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-secondary">Inactivo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.volunteer-opportunities.edit', $opportunity['id_volunteer_opportunity']) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('admin.volunteer-opportunities.destroy', $opportunity['id_volunteer_opportunity']) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta oportunidad?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No hay oportunidades de voluntariado creadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection