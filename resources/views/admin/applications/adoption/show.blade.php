@extends('layouts.admin')

@section('title', 'Revisar Solicitud de Adopción')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Revisar Solicitud #{{ $application['id_adoption_application'] }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.applications.adoption.index') }}">Solicitudes de Adopción</a></li>
        <li class="breadcrumb-item active">Revisión</li>
    </ol>

    <div class="row">
        {{-- Columna de Información --}}
        <div class="col-lg-8">
            {{-- Detalles del Animal --}}
            <div class="card mb-4">
                <div class="card-header">Información del Animalito</div>
                <div class="card-body">
                    <h4>{{ $application['animal']['animal_name'] }}</h4>
                    <p><strong>Raza:</strong> {{ $application['animal']['breed']['breed_name'] }}</p>
                    <p><strong>Edad:</strong> {{ $application['animal']['age'] }} años</p>
                    <p><strong>Sexo:</strong> {{ $application['animal']['sex'] }}</p>
                </div>
            </div>

            {{-- Detalles del Adoptante --}}
            <div class="card mb-4">
                <div class="card-header">Información del Adoptante</div>
                <div class="card-body">
                    <h4>{{ $application['user']['first_name'] }} {{ $application['user']['last_name'] }}</h4>
                    <p><strong>Email:</strong> {{ $application['user']['email'] }}</p>
                    <p><strong>Teléfono:</strong> {{ $application['user']['phone'] }}</p>
                    <p><strong>Documento:</strong> {{ $application['user']['document_type'] }} - {{ $application['user']['document_number'] }}</p>
                </div>
            </div>
            
            {{-- Formulario de Información de Vivienda --}}
            <div class="card mb-4">
                <div class="card-header">Cuestionario de Adopción</div>
                <div class="card-body">
                    <dl class="row">
                        @foreach($application['home_information'] as $key => $value)
                            @if($key !== 'id_home_info' && $key !== 'id_adoption_application')
                                <dt class="col-sm-5">{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                                <dd class="col-sm-7">
                                    @if(is_bool($value))
                                        {{ $value ? 'Sí' : 'No' }}
                                    @else
                                        {{ $value ?? 'No especificado' }}
                                    @endif
                                </dd>
                            @endif
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>

        {{-- Columna de Acciones --}}
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    Acciones de Administrador
                </div>
                <div class="card-body">
                    <p><strong>Estado Actual:</strong> 
                        <span class="badge bg-warning text-dark fs-6">{{ $application['status']['status_name'] }}</span>
                    </p>
                    <hr>
                    <form action="{{ route('admin.applications.adoption.updateStatus', $application['id_adoption_application']) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_status" class="form-label"><strong>Cambiar Estado a:</strong></label>
                            <select name="id_status" id="id_status" class="form-select" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status['id_status'] }}" {{ $status['id_status'] == $application['id_status'] ? 'selected' : '' }}>
                                        {{ $status['status_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Notas del Administrador (opcional)</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" placeholder="Ej: El adoptante cumple con todos los requisitos. Contactar para visita domiciliaria.">{{ $application['admin_notes'] }}</textarea>
                            <div class="form-text">Estas notas son internas y no serán visibles para el usuario.</div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Actualizar Estado</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection