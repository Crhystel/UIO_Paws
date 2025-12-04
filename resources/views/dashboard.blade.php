@extends('layouts.app')

@section('title', 'Mi Panel')

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
    }

    /* === TIPOGRAFÍA === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); line-height: 1.2; }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETAS === */
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%; /* Para que tengan la misma altura */
        display: flex; flex-direction: column; justify-content: space-between;
    }
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(116, 198, 157, 0.2);
        border-color: var(--color-verde-principal);
    }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px;
        font-weight: 700; border: none; text-align: center; text-decoration: none;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; display: block; width: 100%;
    }
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    .btn-secondary-custom {
        background-color: white; border: 2px solid var(--color-verde-oscuro);
        color: var(--color-verde-oscuro); padding: 10px 25px; border-radius: 50px;
        font-weight: 700; text-align: center; text-decoration: none;
        transition: all 0.3s ease; display: block; width: 100%;
    }
    .btn-secondary-custom:hover {
        background-color: var(--color-verde-oscuro); color: white;
    }

    /* === ICONOS DE FONDO === */
    .icon-bg {
        width: 80px; height: 80px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem; margin-bottom: 20px;
    }
    .icon-green { background-color: var(--color-verde-suave); color: var(--color-verde-principal); }
    .icon-blue { background-color: #E0F7FA; color: #00BCD4; }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; animation: float 8s ease-in-out infinite; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: 10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; animation-delay: 2s; }
    
    @keyframes float { 0% { transform: translate(0, 0); } 50% { transform: translate(20px, 30px); } 100% { transform: translate(0, 0); } }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container py-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado de Bienvenida -->
    <div class="text-center mb-5 mt-4">
        <h1 class="hero-title display-5 mb-3">
            Hola, <span class="highlight-shape">{{ Session::get('user_name') }}</span> 👋
        </h1>
        <p class="lead mx-auto" style="max-width: 600px; font-weight: 500; opacity: 0.75;">
            Bienvenido a tu panel personal. Desde aquí podrás gestionar tus solicitudes y mantener tu información al día.
        </p>
    </div>
    
    <!-- Tarjetas de Acción -->
    <div class="row g-4 justify-content-center">
        
        <!-- Tarjeta 1: Mis Solicitudes -->
        <div class="col-md-6 col-lg-5">
            <div class="feature-card">
                <div>
                    <div class="icon-bg icon-green">
                        <i class="bi bi-clipboard-heart"></i>
                    </div>
                    <h3 class="fw-bold mb-3" style="color: var(--color-verde-oscuro);">Mis Solicitudes</h3>
                    <p class="text-muted mb-4">
                        Revisa el estado de todas tus interacciones: adopciones en curso, donaciones realizadas y postulaciones a voluntariado.
                    </p>
                </div>
                <div>
                    <a href="{{ route('adoption.my-applications') }}" class="btn-cta">
                        Ver historial <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta 2: Mi Perfil -->
        <div class="col-md-6 col-lg-5">
            <div class="feature-card">
                <div>
                    <div class="icon-bg icon-blue">
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    <h3 class="fw-bold mb-3" style="color: var(--color-verde-oscuro);">Mi Perfil</h3>
                    <p class="text-muted mb-4">
                        Actualiza tu información personal, cambia tu contraseña y gestiona tus datos de contacto de emergencia.
                    </p>
                </div>
                <div>
                    <a href="{{ route('user.profile.show') }}" class="btn-secondary-custom">
                        <i class="bi bi-gear-fill me-2"></i> Editar perfil
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection