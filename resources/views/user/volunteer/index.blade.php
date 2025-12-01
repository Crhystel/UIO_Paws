@extends('layouts.app')
@section('title', 'Solicitudes de Voluntariado')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Gestión de Voluntarios</h1>
    
    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.applications.volunteer.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Buscar Postulante</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Nombre o Email...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="id_status" class="form-select">
                        <option value="">Todos</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status['id_status'] }}" {{ request('id_status') == $status['id_status'] ? 'selected' : '' }}>
                                {{ $status['status_name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white">
            <i class="fas fa-hands-helping me-1"></i> Postulaciones Recientes
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Postulante</th>
                            <th>Motivación (Extracto)</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $app)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                                    <small class="text-muted">{{ $app['user']['email'] }}</small>
                                </td>
                                <td>{{ Str::limit($app['motivation'], 60) }}</td>
                                <td>
                                    <span class="badge rounded-pill 
                                        @if($app['status']['status_name'] == 'Aprobado') bg-success 
                                        @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                                        @else bg-warning text-dark @endif">
                                        {{ $app['status']['status_name'] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.applications.volunteer.show', $app['id_volunteer_applications']) }}" class="btn btn-sm btn-outline-primary">
                                        Revisar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-4">No hay solicitudes pendientes.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection