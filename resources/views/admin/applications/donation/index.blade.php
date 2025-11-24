@extends('layouts.app') 

@section('title', 'Solicitudes de Donación')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Solicitudes de Donación</h1>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td>{{ $app['id_donation_application'] }}</td>
                        <td>{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                        <td>{{ $app['status']['status_name'] }}</td>
                        <td>
                            <a href="{{ route('admin.applications.donation.show', $app['id_donation_application']) }}" class="btn btn-sm btn-info">Revisar</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5">No hay solicitudes.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection