@extends('layouts.app')

@section('title', 'Revisar Solicitudes')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Revisar Solicitudes</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Panel</a></li>
        <li class="breadcrumb-item active">Todas las Solicitudes</li>
    </ol>

    {{-- Pestañas de Navegación --}}
    <ul class="nav nav-tabs" id="applicationTabs" role="tablist">
        {{-- Tab Adopciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="adoptions-tab-button" data-bs-toggle="tab" data-bs-target="#adoptions-tab-pane" type="button" role="tab" aria-controls="adoptions-tab-pane" aria-selected="true">
                Adopciones <span class="badge bg-secondary">{{ $adoptionsPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
        {{-- Tab Donaciones --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donations-tab-button" data-bs-toggle="tab" data-bs-target="#donations-tab-pane" type="button" role="tab" aria-controls="donations-tab-pane" aria-selected="false">
                Donaciones <span class="badge bg-secondary">{{ $donationsPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
        {{-- NUEVO: Tab Voluntariado --}}
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="volunteers-tab-button" data-bs-toggle="tab" data-bs-target="#volunteers-tab-pane" type="button" role="tab" aria-controls="volunteers-tab-pane" aria-selected="false">
                Voluntariado <span class="badge bg-secondary">{{ $volunteersPaginator['total'] ?? 0 }}</span>
            </button>
        </li>
    </ul>

    {{-- Contenido de las Pestañas --}}
    <div class="tab-content" id="applicationTabsContent">
        {{-- Panel Adopciones --}}
        <div class="tab-pane fade show active" id="adoptions-tab-pane" role="tabpanel" aria-labelledby="adoptions-tab-button" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                @include('admin.applications.partials.adoptions-table', ['applications' => $adoptions])
            </div>
        </div>

        {{-- Panel Donaciones --}}
        <div class="tab-pane fade" id="donations-tab-pane" role="tabpanel" aria-labelledby="donations-tab-button" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                @include('admin.applications.partials.donations-table', ['applications' => $donations])
            </div>
        </div>

        {{-- NUEVO: Panel Voluntariado --}}
        <div class="tab-pane fade" id="volunteers-tab-pane" role="tabpanel" aria-labelledby="volunteers-tab-button" tabindex="0">
            <div class="card card-body border-top-0 rounded-0 rounded-bottom">
                {{-- Creamos un archivo nuevo para mantener el orden --}}
                @include('admin.applications.partials.volunteers-table', ['applications' => $volunteers])
            </div>
        </div>
    </div>
</div>
@endsection