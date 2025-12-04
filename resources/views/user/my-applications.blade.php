@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    /* === VARIABLES === */
    :root {
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-verde-suave: #D8F3DC;     
        --color-acento: #40916C;          
        --color-fondo-crema: #F9FFF9;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--color-verde-oscuro);
        background-color: var(--color-fondo-crema);
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
        overflow-x: hidden; 
    }

    /* === TEXTOS === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA CONTENEDORA === */
    .feature-card {
        background: white; border-radius: 30px; padding: 30px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        min-height: 400px;
        overflow:visible !important;
    }

    /* === PESTAÑAS PERSONALIZADAS === */
    .nav-pills-custom .nav-link {
        color: var(--color-verde-oscuro);
        background: rgba(255,255,255,0.6);
        border: 1px solid rgba(116, 198, 157, 0.3);
        border-radius: 50px;
        padding: 10px 25px;
        margin-right: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }
    
    .nav-pills-custom .nav-link:hover {
        background: var(--color-verde-suave);
        transform: translateY(-2px);
    }

    .nav-pills-custom .nav-link.active {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        border-color: transparent;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
    }

    /* Badge dentro de las pestañas */
    .nav-pills-custom .nav-link .badge {
        background-color: rgba(255,255,255,0.3) !important;
        color: inherit;
        margin-left: 8px;
        border-radius: 50%;
        padding: 0.4em 0.6em;
    }
    .nav-pills-custom .nav-link.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: white;
    }

    /* === TABLAS === */
    .table-custom {
        width: 100%;
        margin-bottom: 0;
    }
    .table-custom th {
        border-top: none;
        color: var(--color-acento);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--color-verde-suave);
    }
    .table-custom td {
        vertical-align: middle;
        padding: 15px 10px;
        border-bottom: 1px dashed rgba(116, 198, 157, 0.3);
    }
    .table-custom tr:last-child td { border-bottom: none; }

    /* === BREADCRUMB === */
    .breadcrumb-custom a {
        color: var(--color-acento); text-decoration: none; font-weight: 600;
    }
    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--color-verde-oscuro); opacity: 0.7;
    }
    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        color: var(--color-verde-principal);
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }
    .grayscale-img img { filter: grayscale(100%); transition: filter 0.3s ease; }
    .grayscale-img img:hover { filter: grayscale(0%); }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-4 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado y Breadcrumb -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <div>
            <h1 class="hero-title display-5 mb-2">
                Mis <span class="highlight-shape">Solicitudes</span>
            </h1>
            <p class="text-muted mb-0">Revisa el estado de tus trámites en tiempo real.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-decoration-none fw-bold" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- Mensajes de feedback -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert" style="background-color: var(--color-verde-suave); color: var(--color-verde-oscuro);">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- PESTAÑAS DE NAVEGACIÓN -->
    <ul class="nav nav-pills nav-pills-custom mb-4" id="myApplicationsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="adoptions-tab-button" data-bs-toggle="pill" data-bs-target="#adoptions-tab-pane" type="button" role="tab">
                <i class="bi bi-house-heart me-1"></i> Adopciones 
                <span class="badge">{{ count($adoption_applications ?? []) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="donations-tab-button" data-bs-toggle="pill" data-bs-target="#donations-tab-pane" type="button" role="tab">
                <i class="bi bi-box2-heart me-1"></i> Donaciones 
                <span class="badge">{{ count($donation_applications ?? []) }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="volunteer-tab-button" data-bs-toggle="pill" data-bs-target="#volunteer-tab-pane" type="button" role="tab">
                <i class="bi bi-person-badge me-1"></i> Voluntariado 
                <span class="badge">{{ count($volunteer_applications ?? []) }}</span>
            </button>
        </li>
    </ul>

    <!-- CONTENEDOR DE CONTENIDO -->
    <div class="feature-card">
        <div class="tab-content" id="myApplicationsTabsContent">
            
            {{-- Panel de Adopciones --}}
            <div class="tab-pane fade show active" id="adoptions-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    @include('user.adoption.partials.adoptions-table', ['applications' => $adoption_applications ?? []])
                </div>
            </div>

            {{-- Panel de Donaciones --}}
            <div class="tab-pane fade" id="donations-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    @if(view()->exists('user.donations.partials.donations-table'))
                        @include('user.donations.partials.donations-table', ['applications' => $donation_applications ?? []])
                    @else
                        @if(view()->exists('user.adoption.partials.donations-table'))
                             @include('user.adoption.partials.donations-table', ['applications' => $donation_applications ?? []])
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-exclamation-circle text-muted fs-1 opacity-50"></i>
                                <p class="text-muted mt-2">No se encuentra el archivo de la tabla de donaciones.</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Panel de Voluntariado --}}
            <div class="tab-pane fade" id="volunteer-tab-pane" role="tabpanel" tabindex="0">
                <div class="table-responsive">
                    @include('user.volunteer.partials.volunteer-table', ['applications' => $volunteer_applications ?? []])
                </div>
            </div>
        </div> 
    </div>
</div>

@endsection