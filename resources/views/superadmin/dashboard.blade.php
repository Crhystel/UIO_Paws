@extends('layouts.app')

@section('title', 'Panel de Super Administrador')

@section('content')

<!-- ========================================== -->
<!-- 1. ESTILOS VISUALES (Tema Welcome)         -->
<!-- ========================================== -->
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
        --color-admin-gradiente-1: #E63946;
        --color-admin-gradiente-2: #D00000;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--color-verde-oscuro);
        background-color: var(--color-fondo-crema);
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    /* === TIPOGRAFÍA === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA === */
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(116, 198, 157, 0.15);
        border-color: var(--color-verde-principal);
    }

    /* === BOTÓN DE ACCIÓN === */
    .btn-cta-danger {
        background: linear-gradient(135deg, var(--color-admin-gradiente-1), var(--color-admin-gradiente-2));
        color: white; padding: 12px 40px; border-radius: 50px;
        font-weight: 700; border: none; text-decoration: none;
        box-shadow: 0 10px 25px rgba(230, 57, 70, 0.3);
        transition: all 0.3s ease; 
        
        /* CAMBIOS AQUÍ: */
        display: inline-flex; /* Mejor alineación */
        align-items: center;
        justify-content: center;
        white-space: nowrap; /* Evita que el texto baje de línea */
        min-width: 220px; /* Asegura un ancho mínimo elegante */
    }
    .btn-cta-danger:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(230, 57, 70, 0.5);
        color: white;
    }

    /* === ICONO === */
    .icon-wrapper {
        width: 80px; height: 80px; border-radius: 50%;
        background-color: #FFEBEE; color: #D32F2F;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; margin-right: 25px;
        
        /* CAMBIO AQUÍ: */
        flex-shrink: 0; /* Esto evita que el círculo se aplaste o se haga óvalo */
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; animation: float 8s ease-in-out infinite; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }
    
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-5 mb-3">
            Panel de <span class="highlight-shape">Super Admin</span>
        </h1>
        <p class="lead mx-auto" style="max-width: 700px; font-weight: 500; opacity: 0.8;">
            Bienvenido, <strong>{{ Session::get('user_name') }}</strong>. 
            Desde aquí tienes control total sobre los usuarios del sistema.
        </p>
    </div>
    
    <div class="row justify-content-center mt-4">
        <div class="col-lg-10">
            <div class="feature-card">
                <div class="d-flex flex-column flex-md-row align-items-center text-center text-md-start">
                    
                    <!-- Icono Grande (Ahora no se aplasta) -->
                    <div class="icon-wrapper mb-3 mb-md-0">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <!-- Texto y Descripción -->
                    <div class="flex-grow-1 pe-md-4">
                        <h3 class="fw-bold mb-2" style="color: var(--color-verde-oscuro);">Gestión de Usuarios</h3>
                        <p class="text-muted mb-0" style="font-size: 1.05rem;">
                            Administra todos los roles de la plataforma. Puedes crear nuevos administradores, 
                            editar perfiles existentes o eliminar cuentas del sistema de forma segura.
                        </p>
                    </div>

                    <!-- Botón de Acción (Ahora más ancho y sin saltos de línea) -->
                    <div class="mt-4 mt-md-0">
                        <a href="{{ route('superadmin.users.index') }}" class="btn-cta-danger">
                            <i class="bi bi-people-fill me-2"></i> Administrar Usuarios
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection