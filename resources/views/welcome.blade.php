@extends('layouts.app')

@section('title', 'Bienvenido a UIO Paws')

@section('content')

<!-- Fuente Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        /* === PALETA DE COLORES (Verdes Wireframe) === */
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-verde-suave: #D8F3DC;     
        --color-acento: #40916C;          
        --color-fondo-crema: #F9FFF9;     /* Fondo base muy clarito */
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--color-verde-oscuro);
        background-color: var(--color-fondo-crema);
        overflow-x: hidden;

        /* === AQUÍ ESTÁ EL EFECTO DE HOJA CON PUNTITOS === */
        /* Creamos puntitos verdes con un degradado radial */
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        /* Define la separación entre los puntos (30px) */
        background-size: 30px 30px;
        /* Esto hace que el patrón de puntos se quede quieto al hacer scroll (Efecto premium) */
        background-attachment: fixed;
    }

    /* === HERO SECTION === */
    .hero-section {
        /* Un degradado blanco encima para que el texto se lea bien sobre los puntos */
        background: linear-gradient(180deg, rgba(255,255,255,0.6) 0%, rgba(255,255,255,0) 100%);
        padding: 80px 0 120px 0;
        position: relative;
    }

    .hero-title {
        font-weight: 800;
        line-height: 1.1;
        font-size: 3.8rem;
        color: var(--color-verde-oscuro);
    }

    /* Subrayado orgánico verde */
    .highlight-shape {
        position: relative;
        z-index: 1;
        display: inline-block;
    }
    
    .highlight-shape::after {
        content: '';
        position: absolute;
        bottom: 8px; left: -5px; width: 105%; height: 25px;
        background-color: var(--color-verde-principal);
        opacity: 0.5; 
        border-radius: 20px;
        z-index: -1;
        transform: rotate(-2deg);
    }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        padding: 16px 45px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cta:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
        filter: brightness(1.05);
    }

    .btn-secondary-custom {
        background-color: rgba(255, 255, 255, 0.8); /* Fondo semi-transparente para leerse sobre puntos */
        border: 2px solid var(--color-verde-oscuro);
        color: var(--color-verde-oscuro);
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }

    .btn-secondary-custom:hover {
        background-color: var(--color-verde-oscuro);
        color: white;
        transform: translateY(-2px);
    }

    /* === BLOBS (Manchas de fondo) === */
    .blob {
        position: absolute;
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        filter: blur(60px);
        z-index: -1;
        animation: float 8s ease-in-out infinite;
    }

    .blob-1 { 
        top: -10%; right: -10%; width: 500px; height: 500px; 
        background-color: var(--color-verde-suave); 
        opacity: 0.8; /* Más opacidad para tapar un poco los puntos */
    }
    .blob-2 { 
        bottom: 10%; left: -5%; width: 350px; height: 350px; 
        background-color: #95D5B2; 
        opacity: 0.5; 
        animation-delay: 2s; 
    }

    /* === TARJETAS === */
    .feature-card {
        background: white; /* Fondo blanco sólido para tapar los puntos detrás del texto */
        border-radius: 30px;
        padding: 40px 30px;
        height: 100%;
        transition: transform 0.3s ease;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        border-color: var(--color-verde-principal);
        box-shadow: 0 20px 40px rgba(116, 198, 157, 0.2);
    }

    .icon-wrapper {
        width: 80px; height: 80px; border-radius: 25px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; margin-bottom: 25px;
    }

    /* === BANNER DE DONACIÓN === */
    .donation-banner {
        background-color: var(--color-verde-oscuro);
        border-radius: 40px; padding: 60px;
        position: relative; overflow: hidden; color: white;
        box-shadow: 0 20px 40px rgba(27, 67, 50, 0.25);
    }
    
    .donation-blob {
        position: absolute; width: 300px; height: 300px; 
        background: var(--color-verde-principal);
        border-radius: 50%; filter: blur(70px); opacity: 0.3; top: -50%; right: -10%;
    }

    .hero-img {
        border-radius: 40px;
        transform: rotate(3deg);
        border: 8px solid white;
        box-shadow: 0 25px 50px rgba(27, 67, 50, 0.15);
        width: 100%;
        object-fit: cover;
    }

    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }

    @media (max-width: 768px) {
        .hero-title { font-size: 2.8rem; }
    }
</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<!-- HERO SECTION -->
<section class="hero-section d-flex align-items-center">
    <div class="container position-relative" style="z-index: 5;">
        <div class="row align-items-center">
            <!-- Texto -->
            <div class="col-lg-6 mb-5 mb-lg-0 text-center text-lg-start">
                
                <!-- Badge -->
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 mb-4 rounded-pill bg-white fw-bold shadow-sm border" style="color: var(--color-verde-oscuro); border-color: var(--color-verde-principal) !important;">
                    <span style="font-size: 1.1rem;">🌱</span> 
                    <span style="font-size: 0.85rem; letter-spacing: 0.5px;">BIENVENIDO A UIO PAWS</span>
                </div>

                <h1 class="hero-title mb-4">
                    Encuentra felicidad <br> 
                    en <span class="highlight-shape">cuatro patas.</span>
                </h1>
                
                <p class="lead mb-5 opacity-75" style="font-weight: 500;">
                    Miles de historias esperan un nuevo comienzo. 
                    Adopta, dona y transforma una vida hoy mismo.
                </p>
                
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start flex-wrap">
                    <a href="{{ route('public.animals.index') }}" class="btn-cta">
                        🐾 Adoptar Ahora
                    </a>
                    <a href="{{ route('public.volunteer.index') }}" class="btn-secondary-custom">
                        Ser Voluntario
                    </a>
                </div>

                <!-- Estadísticas -->
                <div class="mt-5 d-flex align-items-center gap-3 justify-content-center justify-content-lg-start">
                    <div class="d-flex ps-2">
                        <div class="rounded-circle border border-2 border-white bg-secondary" style="width:40px; height:40px; background-image: url('https://randomuser.me/api/portraits/women/44.jpg'); background-size: cover;"></div>
                        <div class="rounded-circle border border-2 border-white bg-secondary" style="width:40px; height:40px; margin-left:-15px; background-image: url('https://randomuser.me/api/portraits/men/32.jpg'); background-size: cover;"></div>
                        <div class="rounded-circle border border-2 border-white bg-secondary" style="width:40px; height:40px; margin-left:-15px; background-image: url('https://randomuser.me/api/portraits/women/65.jpg'); background-size: cover;"></div>
                    </div>
                    <div>
                        <p class="mb-0 fw-bold lh-1" style="color: var(--color-verde-oscuro);">+120 Adoptantes</p>
                        <small class="text-muted">Felices este mes</small>
                    </div>
                </div>
            </div>

            <!-- Imagen -->
            <div class="col-lg-6 text-center">
                <div class="position-relative p-3">
                    <img src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" 
                         alt="Mascota feliz" 
                         class="hero-img">
                         
                    <!-- Tarjeta flotante -->
                    <div class="bg-white p-3 rounded-4 shadow position-absolute bottom-0 start-0 mb-4 ms-2 d-none d-md-flex align-items-center gap-3 border-start border-4" style="border-color: var(--color-verde-principal) !important;">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle" style="color: var(--color-verde-principal);">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <div class="text-start lh-1">
                            <div class="fw-bold small">100% Verificado</div>
                            <small class="text-muted" style="font-size: 0.7rem;">Refugios seguros</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE PASOS -->
<section class="py-5">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold display-6 mb-3" style="color: var(--color-verde-oscuro);">¿Cómo funciona?</h2>
            <p class="text-muted lead">Tu camino para cambiar una vida es natural y sencillo.</p>
        </div>

        <div class="row g-4">
            <!-- Paso 1 -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-wrapper mx-auto" style="background-color: var(--color-verde-suave); color: var(--color-verde-oscuro);">
                        <i class="bi bi-search"></i>
                    </div>
                    <h4 class="fw-bold">1. Encuentra</h4>
                    <p class="text-muted mt-3">Usa nuestros filtros inteligentes para hallar al compañero ideal para tu hogar.</p>
                </div>
            </div>

            <!-- Paso 2 -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-wrapper mx-auto" style="background-color: #FFF9C4; color: #F57F17;">
                        <i class="bi bi-chat-heart"></i>
                    </div>
                    <h4 class="fw-bold">2. Conecta</h4>
                    <p class="text-muted mt-3">Conoce sus historias, agenda una visita con el refugio y siente la conexión.</p>
                </div>
            </div>

            <!-- Paso 3 -->
            <div class="col-md-4">
                <div class="feature-card text-center">
                    <div class="icon-wrapper mx-auto" style="background-color: #FFEBEE; color: #E53935;">
                        <i class="bi bi-house-heart-fill"></i>
                    </div>
                    <h4 class="fw-bold">3. Adopta</h4>
                    <p class="text-muted mt-3">Completa el proceso y lleva alegría a tu hogar. ¡Nosotros te guiamos!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BANNER DONACIÓN -->
<section class="py-5 mb-5">
    <div class="container">
        <div class="donation-banner text-center text-md-start">
            <div class="donation-blob"></div>
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-md-7 mb-4 mb-md-0">
                    <h2 class="fw-bold display-6 mb-2">Ayúdanos a cuidarlos 💚</h2>
                    <p class="lead text-white-50 mb-0">
                        Si no puedes adoptar, tu donación de alimento o medicinas es fundamental.
                    </p>
                </div>
                <div class="col-md-5 text-center text-md-end">
                    <a href="{{ route('public.donations.index') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold shadow" style="color: var(--color-verde-oscuro);">
                        Ver qué donar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush