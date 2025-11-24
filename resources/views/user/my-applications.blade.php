@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')
<div class="container mt-5">
    <h1>Mis Solicitudes</h1>
    <p>Aquí puedes ver el estado de todas las solicitudes que has enviado.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Solicitudes de Adopción --}}
    <div class="card mt-4">
        <div class="card-header">
            <h3>Adopciones</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Animalito</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($adoption_applications as $app)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                                <td>{{ $app['animal']['animal_name'] }}</td>
                                <td>
                                    <span class="badge 
                                        @if($app['status']['status_name'] == 'Aprobado') bg-success 
                                        @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                                        @else bg-warning text-dark @endif">
                                        {{ $app['status']['status_name'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Aún no has enviado ninguna solicitud de adopción.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             @if(isset($adoption_applications[0]['status']['status_name']) && $adoption_applications[0]['status']['status_name'] == 'Aprobado')
                <div class="alert alert-info mt-3">
                    <strong>¡Felicidades!</strong> Una de tus solicitudes fue aprobada. Pronto nos comunicaremos contigo por correo para los siguientes pasos.
                </div>
            @endif
        </div>
    </div>
    
    {{-- Aquí puedes añadir la tabla para las solicitudes de voluntariado de la misma manera --}}

</div>
@endsection