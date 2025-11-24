@extends('layouts.app')

@section('title', 'Solicitudes de Adopción')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Solicitudes de Adopción</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
        <li class="breadcrumb-item active">Solicitudes de Adopción</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Listado de Solicitudes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Adoptante</th>
                            <th>Animalito</th>
                            <th>Estado Actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $app)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y H:i') }}</td>
                                <td>{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</td>
                                <td>{{ $app['animal']['animal_name'] }}</td>
                                <td>
                                    <span class="badge 
                                        @if($app['status']['status_name'] == 'Aprobado') bg-success 
                                        @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                                        @elseif($app['status']['status_name'] == 'Pendiente') bg-warning text-dark
                                        @else bg-secondary @endif">
                                        {{ $app['status']['status_name'] }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.applications.adoption.show', $app['id_adoption_application']) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Revisar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay solicitudes de adopción por el momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación (si aplica) --}}
            @if(isset($paginator) && !empty($paginator['links']))
                {{-- Aquí iría tu lógica de paginación --}}
            @endif
        </div>
    </div>
</div>
@endsection