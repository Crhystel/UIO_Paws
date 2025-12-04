@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')

<!-- ========================================== -->
<!-- 1. ESTILOS VISUALES (COPIADOS Y ADAPTADOS) -->
<!-- ========================================== -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        /* === PALETA DE COLORES === */
        --color-verde-principal: #74C69D; 
        --color-verde-oscuro: #1B4332;    
        --color-verde-suave: #D8F3DC;     
        --color-acento: #40916C;          
        --color-fondo-crema: #F9FFF9;
        --color-peligro: #e63946;
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--color-verde-oscuro);
        background-color: var(--color-fondo-crema);
        overflow-x: hidden;
        /* Patrón de puntos */
        background-image: radial-gradient(rgba(116, 198, 157, 0.4) 1.5px, transparent 1.5px);
        background-size: 30px 30px;
        background-attachment: fixed;
    }

    /* === TÍTULOS Y TEXTOS === */
    .page-title {
        font-weight: 800;
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
        position: absolute; bottom: 5px; left: -5px; width: 105%; height: 15px;
        background-color: var(--color-verde-principal);
        opacity: 0.5; 
        border-radius: 20px;
        z-index: -1;
        transform: rotate(-1deg);
    }

    /* === TARJETA PRINCIPAL (CONTENEDOR) === */
    .feature-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
        position: relative;
        z-index: 2;
    }

    /* === BOTONES === */
    .btn-cta {
        background: linear-gradient(135deg, var(--color-verde-principal), var(--color-acento));
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 600;
        border: none;
        box-shadow: 0 5px 15px rgba(116, 198, 157, 0.4);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(116, 198, 157, 0.6);
        color: white;
    }

    .btn-icon-soft {
        width: 35px; height: 35px;
        border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-edit { background-color: #FFF3CD; color: #856404; }
    .btn-edit:hover { background-color: #FFECB5; transform: scale(1.1); }
    
    .btn-delete { background-color: #F8D7DA; color: #721C24; }
    .btn-delete:hover { background-color: #F5C6CB; transform: scale(1.1); }

    /* === TABLA PERSONALIZADA === */
    .table-custom {
        width: 100%;
        border-collapse: separate; 
        border-spacing: 0 10px; /* Separación entre filas */
        margin-top: -10px;
    }

    .table-custom thead th {
        border: none;
        color: var(--color-acento);
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        padding: 15px 20px;
        background-color: transparent;
    }

    .table-custom tbody tr {
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        transition: transform 0.2s ease;
    }

    .table-custom tbody tr:hover {
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .table-custom td {
        border: none;
        padding: 20px;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .table-custom td:first-child { border-top-left-radius: 15px; border-bottom-left-radius: 15px; border-left: 1px solid #f0f0f0; }
    .table-custom td:last-child { border-top-right-radius: 15px; border-bottom-right-radius: 15px; border-right: 1px solid #f0f0f0; }

    /* Badges de Rol */
    .role-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        background-color: var(--color-verde-suave);
        color: var(--color-verde-oscuro);
    }
    .role-badge-empty {
        background-color: #f0f0f0;
        color: #999;
    }

    /* === BLOBS DE FONDO === */
    .blob {
        position: absolute;
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        filter: blur(60px);
        z-index: -1;
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
    
    <!-- Encabezado -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div class="mb-3 mb-md-0">
            <h1 class="page-title display-5 mb-1">
                Gestión de <span class="highlight-shape">Usuarios</span>
            </h1>
            <p class="text-muted mb-0">Administra los roles y accesos de la plataforma.</p>
        </div>
        
        <a href="{{ route('superadmin.users.create') }}" class="btn-cta">
            <i class="bi bi-person-plus-fill"></i> Crear Nuevo Usuario
        </a>
    </div>

    <!-- Contenedor Estilo Tarjeta -->
    <div class="feature-card">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th scope="col" class="ps-4">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Rol Asignado</th>
                        <th scope="col" class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">#{{ $user['id_user'] }}</td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Avatar generado con iniciales -->
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white me-3 fw-bold" 
                                         style="width: 40px; height: 40px; background-color: var(--color-verde-principal);">
                                        {{ substr($user['first_name'], 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user['first_name'] }} {{ $user['last_name'] }}</div>
                                        <div class="small text-muted">{{ $user['email'] }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @if(!empty($user['roles']))
                                    <span class="role-badge">
                                        <i class="bi bi-shield-lock me-1"></i> {{ $user['roles'][0]['name'] }}
                                    </span>
                                @else
                                    <span class="role-badge role-badge-empty">Sin rol</span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('superadmin.users.edit', $user['id_user']) }}" 
                                   class="btn-icon-soft btn-edit me-2" 
                                   title="Editar">
                                    <i class="bi bi-pencil-fill" style="font-size: 0.9rem;"></i>
                                </a>

                                <form action="{{ route('superadmin.users.destroy', $user['id_user']) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar a este usuario? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-soft btn-delete" title="Eliminar">
                                        <i class="bi bi-trash-fill" style="font-size: 0.9rem;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-50 mb-3">
                                    <i class="bi bi-people fs-1" style="color: var(--color-verde-principal);"></i>
                                </div>
                                <h5 class="fw-bold text-muted">No hay usuarios registrados</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<!-- Necesario para los iconos -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endpush