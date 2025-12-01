@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Mis Solicitudes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
        <li class="breadcrumb-item active">Historial</li>
    </ol>

    {{-- Mensajes de feedback --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- PESTAÑAS DE NAVEGACIÓN --}}
    <ul class="nav nav-tabs" id="myApplicationsTabs" role="tablist">
        {{-- Botón Pestaña Adopciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="adoptions-tab-button" data-bs-toggle="tab" data-bs-target="#adoptions-tab-pane" type="button" role="tab" aria-controls="adoptions-tab-pane" aria-selected="true">
                Adopciones <span class="badge bg-secondary">{{ count($adoption_applications ?? []) }}</span>
            </button>
        </li>
        {{-- Botón Pestaña Donaciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donations-tab-button" data-bs-toggle="tab" data-bs-target="#donations-tab-pane" type="button" role="tab" aria-controls="donations-tab-pane" aria-selected="false">
                Donaciones <span class="badge bg-secondary">{{ count($donation_applications ?? []) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="volunteer-tab-button" data-bs-toggle="tab" data-bs-target="#volunteer-tab-pane" type="button" role="tab">
                Voluntariado <span class="badge bg-secondary">{{ count($volunteer_applications ?? []) }}</span>
            </button>
        </li>
    </ul>

    {{-- CONTENIDO DE LAS PESTAÑAS --}}
    <div class="tab-content" id="myApplicationsTabsContent">
        
        {{-- Panel de Adopciones --}}
        <div class="tab-pane fade show active" id="adoptions-tab-pane" role="tabpanel" aria-labelledby="adoptions-tab-button" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                {{-- Mantiene la ruta de adopciones --}}
                @include('user.adoption.partials.adoptions-table', ['applications' => $adoption_applications ?? []])
            </div>
        </div>

        {{-- Panel de Donaciones --}}
        <div class="tab-pane fade" id="donations-tab-pane" role="tabpanel" aria-labelledby="donations-tab-button" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                @if(view()->exists('user.donations.partials.donations-table'))
                    @include('user.donations.partials.donations-table', ['applications' => $donation_applications ?? []])
                @else
                    @if(view()->exists('user.adoption.partials.donations-table'))
                         @include('user.adoption.partials.donations-table', ['applications' => $donation_applications ?? []])
                    @else
                        <p class="text-muted p-3">No se encuentra el archivo de la tabla de donaciones.</p>
                    @endif
                @endif
                
            </div>
        </div>
        <div class="tab-pane fade" id="volunteer-tab-pane" role="tabpanel" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Detalle</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($volunteer_applications as $volApp)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($volApp['application_date'])->format('d/m/Y') }}</td>
                                <td>
                                    <span class="d-block fw-bold text-primary">Solicitud de Voluntariado</span>
                                    <small class="text-muted">{{ Str::limit($volApp['motivation'], 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $volApp['status']['status_name'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">No has enviado solicitudes de voluntariado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 10px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        top: 15px;
        bottom: 0;
        left: 26px;
        width: 2px;
        background: #e9ecef;
        z-index: 0;
    }
    .timeline > div {
        position: relative;
        z-index: 1;
    }
    .grayscale-img img {
        filter: grayscale(100%);
        transition: filter 0.3s ease;
    }
    .grayscale-img img:hover {
        filter: grayscale(0%);
    }
</style>
@endsection