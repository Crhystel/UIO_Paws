@extends('layouts.app')

@section('title', 'Crear Nuevo Usuario')

@section('content')

<!-- ========================================== -->
<!-- 1. ESTILOS VISUALES COMPARTIDOS            -->
<!-- ========================================== -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
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
        overflow-x: hidden;
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    /* === TÍTULOS === */
    .page-title {
        font-weight: 800;
        color: var(--color-verde-oscuro);
    }

    .highlight-shape {
        position: relative; z-index: 1; display: inline-block;
    }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 5px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA PRINCIPAL === */
    .feature-card {
        background: white;
        border-radius: 30px;
        padding: 40px; /* Más espacio interno */
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        position: relative; z-index: 2;
        max-width: 800px; /* Centrado elegante */
        margin: 0 auto;
    }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 35px; border-radius: 50px;
        font-weight: 600; border: none;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; cursor: pointer;
    }
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(116, 198, 157, 0.6);
        color: white;
    }

    .btn-secondary-custom {
        background-color: transparent;
        border: 2px solid #ddd;
        color: #777; padding: 10px 25px; border-radius: 50px;
        font-weight: 600; text-decoration: none; transition: all 0.3s ease;
        display: inline-block;
    }
    .btn-secondary-custom:hover {
        border-color: var(--color-verde-oscuro);
        color: var(--color-verde-oscuro);
        background-color: white;
    }

    .feature-card .form-control, 
    .feature-card .form-select {
        border-radius: 50px;
        padding: 12px 20px;
        border: 1px solid #e0e0e0;
        background-color: #fcfcfc;
        margin-bottom: 15px; /* Espaciado automático */
    }

    .feature-card .form-control:focus,
    .feature-card .form-select:focus {
        border-color: var(--color-verde-principal);
        box-shadow: 0 0 0 4px rgba(116, 198, 157, 0.15);
        background-color: white;
    }

    .feature-card label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        margin-left: 10px;
        color: var(--color-verde-oscuro);
    }

    /* === BLOBS DE FONDO === */
    .blob {
        position: absolute;
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        filter: blur(60px); z-index: -1;
        animation: float 8s ease-in-out infinite;
    }
    .blob-1 { top: -10%; right: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); opacity: 0.8; }
    .blob-2 { bottom: 10%; left: -5%; width: 350px; height: 350px; background-color: #95D5B2; opacity: 0.5; animation-delay: 2s; }
    
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }
</style>

<!-- Blobs decorativos -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container py-5 position-relative" style="z-index: 1;">
    
    <!-- Encabezado centrado -->
    <div class="text-center mb-5">
        <h1 class="page-title display-5 mb-2">
            Crear Nuevo <span class="highlight-shape">Usuario</span>
        </h1>
        <p class="text-muted">Ingresa los datos para registrar un nuevo miembro en el sistema.</p>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="feature-card">
        <form action="{{ route('superadmin.users.store') }}" method="POST">
            @csrf
            
            <!-- El contenido del formulario se adaptará al CSS definido arriba (.form-control) -->
            <div class="mb-4">
                @include('superadmin.users.form', ['user' => null])
            </div>

            <hr class="border-light my-4">

            <!-- Botones de Acción -->
            <div class="d-flex justify-content-end align-items-center gap-3">
                <a href="{{ route('superadmin.users.index') }}" class="btn-secondary-custom">
                    Cancelar
                </a>
                <button type="submit" class="btn-cta">
                    <i class="bi bi-check-lg me-2"></i> Crear Usuario
                </button>
            </div>
        </form>
    </div>

</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush