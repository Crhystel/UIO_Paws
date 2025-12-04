@extends('layouts.app')

@section('title', 'Sé un Voluntario')

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
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); line-height: 1.2; }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 20px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETAS === */
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%; 
        display: flex; flex-direction: column; 
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(116, 198, 157, 0.15);
        border-color: var(--color-verde-principal);
    }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px;
        font-weight: 700; border: none; text-decoration: none;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; display: inline-block; text-align: center;
    }
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* === TAGS Y CAJAS === */
    .requirements-box {
        background-color: var(--color-fondo-crema);
        border-radius: 20px;
        padding: 20px;
        border-left: 5px solid var(--color-verde-principal);
    }
    
    /* Caja de alerta para usuarios no logueados */
    .login-prompt-box {
        background-color: #F8F9FA;
        border: 1px dashed var(--color-verde-principal);
        border-radius: 20px;
        padding: 20px;
        text-align: center;
        margin-top: auto;
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -10%; right: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: 10%; left: -5%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado Hero -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-5 mb-3">
            ¡Tu Ayuda <span class="highlight-shape">Marca la Diferencia!</span>
        </h1>
        <p class="lead mx-auto" style="max-width: 700px; font-weight: 500; opacity: 0.8;">
            Ser voluntario es una de las formas más gratificantes de ayudar.
            Mira las áreas en las que necesitamos tu talento y tu pasión.
        </p>
    </div>
    
    @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm text-center mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-4 justify-content-center">
        @forelse($opportunities as $opportunity)
            <div class="col-lg-10">
                <div class="feature-card">
                    
                    {{-- HEADER DE LA TARJETA --}}
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h3 class="fw-bold mb-1" style="color: var(--color-verde-oscuro);">
                                <i class="bi bi-person-heart me-2" style="color: var(--color-verde-principal);"></i>
                                {{ $opportunity['title'] }}
                            </h3>
                        </div>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-2 d-none d-sm-inline-block">
                            Voluntariado
                        </span>
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <p class="text-muted mb-4" style="line-height: 1.7;">
                        {{ $opportunity['description'] }}
                    </p>
                    
                    {{-- REQUISITOS --}}
                    @if($opportunity['requirements'])
                        <div class="requirements-box mb-4">
                            <h6 class="fw-bold text-uppercase small mb-2" style="color: var(--color-acento);">
                                <i class="bi bi-list-check me-1"></i> Requisitos:
                            </h6>
                            <p class="mb-0 text-secondary small">
                                {{ $opportunity['requirements'] }}
                            </p>
                        </div>
                    @endif

                    {{-- FOOTER / ACCIONES --}}
                    <div class="mt-auto pt-3 border-top">
                        @auth
                            {{-- OPCIÓN 1: USUARIO LOGUEADO --}}
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                <a href="{{ route('user.volunteer.create', ['opportunity_id' => $opportunity['id_volunteer_opportunity']]) }}" class="btn-cta">
                                    Aplicar a este puesto <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                            </div>
                        @else
                            {{-- OPCIÓN 2: USUARIO NO LOGUEADO --}}
                            
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('user.volunteer.create', ['opportunity_id' => $opportunity['id_volunteer_opportunity']]) }}" class="btn-cta py-2 px-5">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión para Postularse
                                </a>
                            </div>
                         
                        @endauth
                    </div>

                </div>
            </div>
        @empty
            <div class="col-lg-8">
                <div class="feature-card text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-calendar-heart fs-1" style="color: var(--color-verde-principal); opacity: 0.5;"></i>
                    </div>
                    <h3 class="fw-bold" style="color: var(--color-verde-oscuro);">¡Gracias por tu interés!</h3>
                    <p class="text-muted">Por el momento no tenemos nuevas oportunidades de voluntariado, ¡pero vuelve a revisar pronto!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection