@extends('layouts.app')

@section('title', 'Ofrecer Donación')

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

    /* === TEXTOS === */
    .hero-title { font-weight: 800; color: var(--color-verde-oscuro); }
    
    .highlight-shape { position: relative; z-index: 1; display: inline-block; }
    .highlight-shape::after {
        content: ''; position: absolute; bottom: 8px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal); opacity: 0.5; 
        border-radius: 20px; z-index: -1; transform: rotate(-1deg);
    }

    /* === TARJETA PRINCIPAL === */
    .feature-card {
        background: white; border-radius: 30px; padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
    }

    /* === BOTÓN CTA === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white; padding: 12px 30px; border-radius: 50px;
        font-weight: 700; border: none; width: 100%;
        box-shadow: 0 10px 25px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
    }
    .btn-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(116, 198, 157, 0.6);
        color: white;
    }

    /* === TABLA PERSONALIZADA === */
    .table-custom th {
        border-top: none;
        color: var(--color-acento);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding-bottom: 15px;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 15px 10px;
        border-bottom: 1px dashed rgba(116, 198, 157, 0.3);
    }
    .table-custom tr:last-child td { border-bottom: none; }
    
    /* Inputs Redondeados */
    .form-control-rounded {
        border-radius: 20px; border: 1px solid #ddd; text-align: center;
    }
    .form-control-rounded:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }

    /* Checkbox Verde */
    .form-check-input:checked {
        background-color: var(--color-verde-principal);
        border-color: var(--color-verde-principal);
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -10%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-5 pb-5 position-relative" style="z-index: 5;">
    
    <!-- Encabezado -->
    <div class="text-center mb-5">
        <h1 class="hero-title display-5 mb-3">
            Ofrecer <span class="highlight-shape">Donación</span>
        </h1>
        <p class="lead mx-auto" style="max-width: 700px; font-weight: 500; opacity: 0.8;">
            Selecciona los artículos que te gustaría donar y especifica la cantidad. 
            Tu generosidad nos ayuda a seguir adelante.
        </p>
    </div>

    <!-- Mensajes de Error -->
    @if($errors->any())
    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="bi bi-exclamation-circle-fill fs-5"></i>
            <strong>Por favor corrige los siguientes errores:</strong>
        </div>
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulario en Tarjeta "Feature Card" -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('user.donations.store') }}" method="POST">
                @csrf
                
                <div class="feature-card">
                    <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom">
                        <i class="bi bi-basket3-fill fs-4" style="color: var(--color-verde-principal);"></i>
                        <h4 class="fw-bold mb-0" style="color: var(--color-verde-oscuro);">Artículos que Necesitamos</h4>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">Seleccionar</th>
                                    <th>Artículo</th>
                                    <th>Descripción</th>
                                    <th style="width: 15%;">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($itemsCatalog as $index => $item)
                                    @php
                                        // Verificamos si este item es el que viene preseleccionado desde la página anterior
                                        $isSelected = (isset($preselectedId) && $preselectedId == $item['id_donation_item_catalog']);
                                    @endphp
                                    
                                    {{-- Si está seleccionado, le ponemos un fondo suave --}}
                                    <tr class="{{ $isSelected ? 'bg-light' : '' }}" id="row-{{ $index }}">
                                        
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input item-checkbox" type="checkbox" 
                                                    name="items[{{ $index }}][id]" 
                                                    value="{{ $item['id_donation_item_catalog'] }}" 
                                                    id="item-check-{{ $index }}" 
                                                    style="width: 1.3em; height: 1.3em; cursor: pointer;"
                                                    {{ $isSelected ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <label for="item-check-{{ $index }}" class="fw-bold" style="cursor: pointer;">
                                                {{ $item['item_name'] }}
                                            </label>
                                            @if($isSelected)
                                                <span class="badge bg-success ms-2 small" style="font-size: 0.7em;">Seleccionado</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <small class="text-muted">{{ $item['description'] }}</small>
                                        </td>
                                        
                                        <td>
                                            {{-- Si está seleccionado, NO está disabled. Si no, sí está disabled --}}
                                            <input type="number" 
                                                name="items[{{ $index }}][quantity]" 
                                                class="form-control form-control-rounded item-quantity" 
                                                min="1" value="1" 
                                                {{ $isSelected ? '' : 'disabled' }}
                                                style="{{ $isSelected ? 'background-color: white;' : '' }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-box-seam fs-1 d-block mb-2 opacity-50"></i>
                                            No hay artículos en el catálogo en este momento.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 pt-3">
                        <button type="submit" class="btn-cta btn-lg">
                            <i class="bi bi-heart-fill me-2"></i> Enviar Ofrecimiento
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    function toggleRowState(checkbox) {
        const row = checkbox.closest('tr');
        const quantityInput = row.querySelector('.item-quantity');
        
        if (checkbox.checked) {
            quantityInput.disabled = false;
            quantityInput.style.backgroundColor = 'white';
        } else {
            quantityInput.disabled = true;
            quantityInput.value = 1; // Resetear valor
            quantityInput.style.backgroundColor = ''; // Resetear estilo
        }
    }

    checkboxes.forEach(checkbox => {
        // 1. Escuchar cambios manuales
        checkbox.addEventListener('change', function () {
            toggleRowState(this);
        });

        if(checkbox.checked) {
            toggleRowState(checkbox); 
            
            checkbox.closest('tr').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
    });
});
</script>
@endpush