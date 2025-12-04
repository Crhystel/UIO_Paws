@extends('layouts.app')
@section('title', 'Añadir Especie')

@section('content')

<!-- Estilos del Tema Welcome -->
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
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.05);
    }
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px; font-weight: 700;
        border: none; box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease; text-decoration: none; display: inline-block;
    }
    .btn-cta:hover { transform: translateY(-3px); }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="text-center mb-4">
                 <h1 class="hero-title h2 mb-0">Añadir Nueva Especie</h1>
                 <p class="text-muted">Crea una nueva categoría para los animales del refugio.</p>
            </div>
            
            <div class="feature-card">
                <form action="{{ route('admin.species.store') }}" method="POST">
                    @include('admin.species.form', ['buttonText' => 'Crear Especie'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection