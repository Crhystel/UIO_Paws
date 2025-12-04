{{-- resources/views/admin/donation-items/edit.blade.php --}}

@extends('layouts.app')
@section('title', 'Editar Artículo')

@section('content')

<!-- Estilos del Tema Welcome -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    .btn-cta:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(116, 198, 157, 0.5); }
    .table th { color: var(--color-acento); font-weight: 600; text-transform: uppercase; font-size: 0.8rem; border-bottom: 2px solid var(--color-verde-suave); }
    .table td { vertical-align: middle; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
             <div class="text-center mb-4">
                 <h1 class="hero-title h2 mb-0">Editar Artículo</h1>
                 <p class="text-muted fst-italic">"{{ $item['item_name'] }}"</p>
            </div>
        
            <div class="feature-card">
                <form action="{{ route('admin.donation-items.update', $item['id_donation_item_catalog']) }}" method="POST">
                    @method('PUT')
                    @include('admin.donation-items.form', ['buttonText' => 'Actualizar Artículo'])
                </form>
            </div>
        </div>
    </div>
</div>
@endsection