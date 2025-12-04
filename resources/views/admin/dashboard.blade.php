@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')

<!-- ========================================== -->
<!-- ESTILOS ESPECÍFICOS DEL DASHBOARD          -->
<!-- ========================================== -->
<style>
    :root {
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-verde-suave: #D8F3DC;     
        --color-acento: #40916C;          
        --color-alerta: #F4A261;
    }

    /* === TARJETAS DEL DASHBOARD === */
    .dashboard-card {
        background: white;
        border-radius: 30px;
        padding: 35px 25px;
        height: 100%;
        border: 1px solid rgba(116, 198, 157, 0.15);
        box-shadow: 0 10px 25px rgba(27, 67, 50, 0.03);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        display: flex; flex-direction: column; align-items: center; text-align: center;
        position: relative; overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(116, 198, 157, 0.2);
        border-color: var(--color-verde-principal);
    }

    /* Icono superior */
    .icon-box {
        width: 80px; height: 80px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover .icon-box { transform: scale(1.1) rotate(5deg); }

    /* Variantes de color */
    .icon-green { background-color: var(--color-verde-suave); color: var(--color-verde-oscuro); }
    .icon-green-solid { background-color: var(--color-verde-principal); color: white; } /* CORRECCIÓN ANIMALES */
    .icon-blue { background-color: #E0F7FA; color: #006064; }
    .icon-orange { background-color: #FFF3E0; color: #E65100; }
    .icon-pink { background-color: #FCE4EC; color: #880E4F; }
    .icon-gray { background-color: #F5F5F5; color: #616161; }

    /* Textos y Botones */
    .card-title { font-weight: 700; color: var(--color-verde-oscuro); font-size: 1.25rem; margin-bottom: 10px; }
    
    .btn-dash {
        margin-top: auto; padding: 8px 25px; border-radius: 50px;
        font-weight: 600; font-size: 0.9rem; text-decoration: none;
        transition: all 0.2s; border: 2px solid transparent;
    }
    .btn-dash-primary { background-color: var(--color-verde-principal); color: white; }
    .btn-dash-primary:hover { background-color: var(--color-acento); color: white; }
    
    .btn-dash-outline { border-color: #ddd; color: #666; background-color: transparent; }
    .btn-dash-outline:hover { border-color: var(--color-verde-oscuro); color: var(--color-verde-oscuro); }
    
    .btn-dash-warning { background-color: var(--color-alerta); color: white; }
    .btn-dash-warning:hover { filter: brightness(0.9); color: white; }

    /* Subrayado */
    .highlight-shape { position: relative; display: inline-block; z-index: 1; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 5px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.4; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }
</style>

<div class="container py-4">
    
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">
            Panel de <span class="highlight-shape">Administración</span>
        </h1>
        <p class="lead text-muted mx-auto" style="max-width: 700px;">
            Bienvenido. Selecciona una opción para gestionar la plataforma.
        </p>
    </div>

    <!-- Grid de Tarjetas -->
    <div class="row g-4">
        
        <!-- 1. GESTIONAR ANIMALES -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-green-solid shadow-sm">
                    <i class="bi bi-gitlab fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Animales</h5>
                <p class="text-muted small mb-4">Añadir, editar o eliminar perfiles de animales.</p>
                <a href="{{ route('admin.animals.index') }}" class="btn-dash btn-dash-primary">
                    Configurar
                </a>
            </div>
        </div>

        <!-- 2. GESTIONAR REFUGIOS -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-green">
                    <i class="bi bi-house-heart-fill fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Refugios</h5>
                <p class="text-muted small mb-4">Administrar la información de los refugios.</p>
                <a href="{{ route('admin.shelters.index') }}" class="btn-dash btn-dash-primary">
                    Configurar
                </a>
            </div>
        </div>

        <!-- 3. GESTIONAR ESPECIES -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-gray">
                    <i class="bi bi-tags-fill fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Especies</h5>
                <p class="text-muted small mb-4">Añadir, editar o eliminar especies (ej: Perro, Gato).</p>
                <a href="{{ route('admin.species.index') }}" class="btn-dash btn-dash-outline">
                    Configurar
                </a>
            </div>
        </div>

        <!-- 4. GESTIONAR RAZAS -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-gray">
                    <i class="bi bi-diagram-3-fill fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Razas</h5>
                <p class="text-muted small mb-4">Añadir,editar o elimina razas para cada especie.</p>
                <a href="{{ route('admin.breeds.index') }}" class="btn-dash btn-dash-outline">
                    Configurar
                </a>
            </div>
        </div>

        <!-- 5. GESTIONAR DONACIONES -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-pink">
                    <i class="bi bi-gift-fill fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Donaciones</h5>
                <p class="text-muted small mb-4">Administrar los artículos que se pueden donar.</p>
                <a href="{{ route('admin.donation-items.index') }}" class="btn-dash btn-dash-primary" style="background-color: #D81B60;">
                    Configurar
                </a>
            </div>
        </div>

        <!-- 6. GESTIONAR VOLUNTARIADO -->
        <div class="col-md-6 col-lg-4">
            <div class="dashboard-card">
                <div class="icon-box icon-blue">
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
                <h5 class="card-title">Gestionar Voluntariado</h5>
                <p class="text-muted small mb-4">Crear y editar oportunidades de voluntariado.</p>
                <a href="{{ route('admin.volunteer-opportunities.index') }}" class="btn-dash btn-dash-primary" style="background-color: #0097A7;">
                    Configurar
                </a>
            </div>
        </div>

    </div>

    <!-- 7. REVISAR SOLICITUDES (Al final y centrada) -->
    <div class="row justify-content-center mt-4 pt-2">
        <div class="col-md-8 col-lg-6">
            <div class="dashboard-card border-warning" style="border-width: 1px; border-style: dashed;">
                <div class="icon-box icon-orange">
                    <i class="bi bi-file-earmark-text-fill fs-2"></i>
                </div>
                <h5 class="card-title text-warning" style="color: #E65100 !important;">Revisar Solicitudes</h5>
                <p class="text-muted small mb-4">Ver solicitudes de adopción, voluntariado y donaciones.</p>
                <a href="{{ route('admin.applications.index') }}" class="btn-dash btn-dash-warning shadow-sm w-50">
                    <i class="bi bi-bell-fill me-1"></i> Revisar Ahora
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush