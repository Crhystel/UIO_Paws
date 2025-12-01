@extends('layouts.app')

@section('title', 'Revisar Solicitud de Voluntariado')

@section('content')
<div class="container-fluid">
    {{-- HEADER Y NAVEGACIÓN --}}
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4 border-bottom pb-3">
        <div>
            <h1 class="h3 mb-0">Solicitud #{{ $application['id_volunteer_applications'] }}</h1>
            <p class="text-muted mb-0">
                <i class="fas fa-calendar-alt me-1"></i>
                Fecha de postulación: {{ \Carbon\Carbon::parse($application['application_date'])->format('d/m/Y H:i') }}
            </p>
        </div>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    <div class="row">
        {{-- COLUMNA IZQUIERDA: INFORMACIÓN DE LA SOLICITUD --}}
        <div class="col-lg-8">
            
            {{-- 1. DATOS DEL PUESTO / OPORTUNIDAD --}}
            <div class="card mb-4 border-start border-4 border-primary shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                            <i class="fas fa-briefcase fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="text-uppercase text-muted small fw-bold mb-1">Postulando para el puesto:</h6>
                            @if(isset($application['opportunity']))
                                <h3 class="text-primary fw-bold mb-2">{{ $application['opportunity']['title'] }}</h3>
                                <p class="mb-0 text-muted">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    {{ Str::limit($application['opportunity']['description'], 150) }}
                                </p>
                            @else
                                <h3 class="text-secondary fw-bold mb-2">Voluntariado General</h3>
                                <p class="mb-0 text-muted">El usuario ofrece su ayuda sin especificar un puesto activo.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. INFORMACIÓN DEL CANDIDATO --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-user me-2 text-secondary"></i> Datos del Candidato
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase fw-bold">Nombre Completo</label>
                            <p class="fs-5 mb-0">{{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase fw-bold">Correo Electrónico</label>
                            <p class="fs-5 mb-0">
                                <a href="mailto:{{ $application['user']['email'] }}" class="text-decoration-none">
                                    {{ $application['user']['email'] }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase fw-bold">Teléfono de Contacto</label>
                            <p class="fs-5 mb-0">
                                {{ $application['user']['phone'] ?? 'No registrado' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted text-uppercase fw-bold">Usuario desde</label>
                            <p class="fs-5 mb-0">
                                {{ \Carbon\Carbon::parse($application['user']['created_at'] ?? now())->format('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. CARTA DE PRESENTACIÓN / RESPUESTAS --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-file-alt me-2 text-secondary"></i> Formulario de Postulación
                </div>
                <div class="card-body bg-light">
                    {{-- 
                        IMPORTANTE: Usamos nl2br(e(...)) para:
                        1. e(): Escapar código malicioso (seguridad).
                        2. nl2br(): Convertir los "enters" del usuario en saltos de línea HTML <br>.
                    --}}
                    <div class="p-2" style="white-space: pre-line; line-height: 1.6;">
                        {!! nl2br(e($application['motivation'])) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: PANEL DE GESTIÓN --}}
        <div class="col-lg-4">
            <div class="card sticky-top shadow border-0" style="top: 20px;">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Gestión Administrativa</span>
                    <i class="fas fa-cog"></i>
                </div>
                <div class="card-body">
                    
                    {{-- ESTADO ACTUAL --}}
                    <div class="text-center mb-4">
                        <p class="text-muted small mb-2 text-uppercase fw-bold">Estado Actual</p>
                        <span class="badge py-2 px-4 rounded-pill fs-5
                            @if($application['status']['status_name'] == 'Aprobado') bg-success 
                            @elseif($application['status']['status_name'] == 'Rechazado') bg-danger
                            @elseif($application['status']['status_name'] == 'Pendiente') bg-warning text-dark
                            @else bg-secondary @endif">
                            {{ $application['status']['status_name'] }}
                        </span>
                    </div>

                    <hr>

                    {{-- FORMULARIO DE ACTUALIZACIÓN --}}
                    <form action="{{ route('admin.applications.volunteer.updateStatus', $application['id_volunteer_applications']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="id_status" class="form-label fw-bold">Cambiar Estado</label>
                            <select name="id_status" id="id_status" class="form-select form-select-lg" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status['id_status'] }}" 
                                        {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                        {{ $status['status_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label fw-bold">Notas Internas</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" 
                                placeholder="Escribe aquí notas sobre la entrevista, disponibilidad confirmada, o razones del rechazo...">{{ $application['admin_notes'] ?? '' }}</textarea>
                            <div class="form-text text-end fst-italic">Solo visibles para administradores.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold py-2">
                                <i class="fas fa-save me-2"></i> Actualizar Solicitud
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection