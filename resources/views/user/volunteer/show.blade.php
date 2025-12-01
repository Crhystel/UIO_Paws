@extends('layouts.app')
@section('title', 'Revisar Voluntario')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3">Solicitud #{{ $application['id_volunteer_applications'] }}</h1>
            <p class="text-muted mb-0">Postulante: {{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</p>
        </div>
        <a href="{{ route('admin.applications.volunteer.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
    </div>

    <div class="row">
        {{-- Columna Izquierda: Datos del Usuario y Respuesta --}}
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Carta de Presentación</h5>
                </div>
                <div class="card-body">
                    {{-- Mostramos el texto formateado (recordando que concatenamos campos en el store) --}}
                    <div class="p-3 bg-light rounded border">
                        {!! nl2br(e($application['motivation'])) !!}
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    Datos de Contacto
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted fw-bold">Email</label>
                            <p>{{ $application['user']['email'] }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted fw-bold">Teléfono</label>
                            <p>{{ $application['user']['phone'] ?? 'No registrado' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Panel de Decisión --}}
        <div class="col-lg-4">
            <div class="card sticky-top shadow border-0" style="top: 20px;">
                <div class="card-header bg-dark text-white">
                    Dictamen Administrativo
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        <p class="text-muted mb-1">Estado Actual</p>
                        <span class="badge fs-5 
                            @if($application['status']['status_name'] == 'Aprobado') bg-success 
                            @elseif($application['status']['status_name'] == 'Rechazado') bg-danger
                            @else bg-warning text-dark @endif">
                            {{ $application['status']['status_name'] }}
                        </span>
                    </div>

                    <form action="{{ route('admin.applications.volunteer.updateStatus', $application['id_volunteer_applications']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Actualizar Estado</label>
                            <select name="id_status" class="form-select form-select-lg" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status['id_status'] }}" {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                        {{ $status['status_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notas Internas</label>
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Ej: Entrevistado por Zoom, parece buen candidato.">{{ $application['admin_notes'] ?? '' }}</textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection