@extends('layouts.app')

@section('title', 'Adopta a ' . $animal['animal_name'])

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
        --color-naranja-acento: #FF7F50; /* Para el botón principal */
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

    /* === TARJETAS === */
    .feature-card {
        background: white; border-radius: 30px; padding: 30px;
        border: 1px solid rgba(116, 198, 157, 0.1); 
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.03);
    }

    /* === BOTÓN CTA (Naranja para destacar adopción) === */
    .btn-cta-adopt {
        background: linear-gradient(135deg, #FF9966, #FF5E62);
        color: white; padding: 14px 30px; border-radius: 50px;
        font-weight: 700; border: none; width: 100%; font-size: 1.1rem;
        box-shadow: 0 10px 25px rgba(255, 94, 98, 0.3);
        transition: all 0.3s ease;
    }
    .btn-cta-adopt:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 94, 98, 0.5);
        color: white;
    }

    /* === INPUTS === */
    .form-control-rounded, .form-select-rounded {
        border-radius: 20px; border: 1px solid #ddd; padding: 10px 20px;
    }
    .form-control-rounded:focus, .form-select-rounded:focus {
        border-color: var(--color-verde-principal); box-shadow: 0 0 0 3px rgba(116, 198, 157, 0.2);
    }
    .form-label { font-weight: 600; font-size: 0.85rem; margin-bottom: 5px; color: var(--color-verde-oscuro); text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.8; }

    /* === SECCIONES === */
    .section-header {
        color: var(--color-acento);
        font-weight: 700;
        border-bottom: 2px solid var(--color-verde-suave);
        padding-bottom: 10px;
        margin-bottom: 20px;
        margin-top: 30px;
        display: flex; align-items: center; gap: 10px;
    }
    .section-icon {
        background-color: var(--color-verde-suave);
        color: var(--color-verde-oscuro);
        width: 35px; height: 35px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    /* === BLOBS === */
    .blob { position: absolute; border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; filter: blur(60px); z-index: -1; opacity: 0.6; }
    .blob-1 { top: -5%; left: -10%; width: 500px; height: 500px; background-color: var(--color-verde-suave); }
    .blob-2 { bottom: -5%; right: -10%; width: 400px; height: 400px; background-color: #95D5B2; }

</style>

<!-- Blobs de fondo -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="container pt-4 pb-5 position-relative" style="z-index: 5;">

    <!-- Botón de Regreso -->
    <div class="mb-4">
        <a href="{{ route('public.animals.show', $animal['id_animal']) }}" class="text-decoration-none fw-bold" style="color: var(--color-acento);">
            <i class="bi bi-arrow-left"></i> Volver a la ficha de {{ $animal['animal_name'] }}
        </a>
    </div>

    <div class="row g-4">
        
        {{-- COLUMNA IZQUIERDA: TARJETA DEL ANIMAL --}}
        <div class="col-lg-4">
            <div class="feature-card text-center sticky-top" style="top: 20px; z-index: 10;">
                
                <div class="position-relative d-inline-block mb-3">
                    @if(!empty($animal['photos']))
                        <img src="{{ env('API_URL', 'http://127.0.0.1:8000') . '/storage/' . $animal['photos'][0]['image_url'] }}" 
                             class="rounded-circle shadow-lg object-fit-cover border border-4 border-white" 
                             style="width: 180px; height: 180px;" 
                             alt="Foto de {{ $animal['animal_name'] }}">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto border border-4 border-white shadow-sm" style="width: 180px; height: 180px;">
                            <i class="bi bi-camera fs-1 text-muted opacity-50"></i>
                        </div>
                    @endif
                    <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm" style="margin-bottom: 10px; margin-right: 10px;">
                         <i class="bi bi-heart-fill text-danger fs-5"></i>
                    </div>
                </div>
                
                <h2 class="hero-title mb-1">{{ $animal['animal_name'] }}</h2>
                <p class="text-muted fw-bold mb-3">{{ $animal['breed']['breed_name'] ?? 'Mestizo' }} &bull; {{ $animal['age'] }} años</p>
                
                <div class="alert small text-start rounded-4 border-0" style="background-color: var(--color-verde-suave); color: var(--color-verde-oscuro);">
                    <i class="bi bi-info-circle-fill me-1"></i>
                    Estás a un paso de cambiar una vida. Por favor, sé sincero en tus respuestas para encontrar el hogar ideal.
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIO --}}
        <div class="col-lg-8">
            <div class="feature-card">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3 class="fw-bold mb-0" style="color: var(--color-verde-oscuro);">Solicitud de Adopción</h3>
                    <span class="badge bg-light text-dark border rounded-pill px-3">Paso Final</span>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-exclamation-circle-fill fs-5"></i>
                            <strong>Por favor revisa:</strong>
                        </div>
                        <ul class="mb-0 small ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('adoption.submit', $animal['id_animal']) }}" method="POST">
                    @csrf
                    
                    {{-- SECCIÓN 1: VIVIENDA --}}
                    <div class="section-header">
                        <div class="section-icon"><i class="bi bi-house-door-fill"></i></div>
                        <span class="fs-5">Sobre tu Vivienda</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo de vivienda</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[dwelling_type]" value="{{ old('home_info.dwelling_type') }}" placeholder="Ej: Casa, Apartamento..." required>
                        </div>
                         <div class="col-md-6">
                            <label class="form-label">Adultos en casa</label>
                            <input type="number" class="form-control form-control-rounded" name="home_info[adults_in_home]" value="{{ old('home_info.adults_in_home') }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Material paredes</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[wall_material]" value="{{ old('home_info.wall_material') }}" placeholder="Ej: Ladrillo" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Material piso</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[floor_material]" value="{{ old('home_info.floor_material') }}" placeholder="Ej: Cerámica" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Habitaciones</label>
                            <input type="number" class="form-control form-control-rounded" name="home_info[room_count]" value="{{ old('home_info.room_count') }}" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Baños</label>
                            <input type="number" class="form-control form-control-rounded" name="home_info[bathroom_count]" value="{{ old('home_info.bathroom_count') }}" min="1" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label d-block mb-2">¿Tiene patio?</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="home_info[has_yard]" id="has_yard_yes" value="1" {{ old('home_info.has_yard') == '1' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-success rounded-start-pill" for="has_yard_yes">Sí</label>
                                
                                <input type="radio" class="btn-check" name="home_info[has_yard]" id="has_yard_no" value="0" {{ old('home_info.has_yard', '0') == '0' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary rounded-end-pill" for="has_yard_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-12" id="yard_enclosure_field" style="display: none;">
                            <label class="form-label">Tipo de cerramiento del patio</label>
                            <input type="text" class="form-control form-control-rounded" id="yard_enclosure_type" name="home_info[yard_enclosure_type]" value="{{ old('home_info.yard_enclosure_type') }}" placeholder="Ej: Muro alto, Reja...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label d-block mb-2">¿Tiene balcón?</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="home_info[has_balcony]" id="has_balcony_yes" value="1" {{ old('home_info.has_balcony') == '1' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-success rounded-start-pill" for="has_balcony_yes">Sí</label>

                                <input type="radio" class="btn-check" name="home_info[has_balcony]" id="has_balcony_no" value="0" {{ old('home_info.has_balcony', '0') == '0' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary rounded-end-pill" for="has_balcony_no">No</label>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 2: FAMILIA --}}
                    <div class="section-header">
                        <div class="section-icon"><i class="bi bi-people-fill"></i></div>
                        <span class="fs-5">Familia y Mascotas</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mascotas actuales</label>
                            <input type="number" class="form-control form-control-rounded" id="current_pet_count" name="home_info[current_pet_count]" value="{{ old('home_info.current_pet_count') }}" min="0" required>
                        </div>
                        
                        <div class="col-md-12" id="other_pets_field" style="display: none;">
                            <label class="form-label">Describe a tus otras mascotas</label>
                            <textarea class="form-control form-control-rounded" id="others_pets_description" name="home_info[others_pets_description]" rows="2" placeholder="Ej: Perro Poodle de 5 años...">{{ old('home_info.others_pets_description') }}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Experiencia previa con mascotas</label>
                            <textarea class="form-control form-control-rounded" name="home_info[previous_pets_history]" rows="2" placeholder="Cuéntanos tu historia...">{{ old('home_info.previous_pets_history') }}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label d-block mb-2">¿Todos en casa están de acuerdo?</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_agree_yes" value="1" {{ old('home_info.all_members_agree') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="all_agree_yes">Sí, todos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_agree_no" value="0" {{ old('home_info.all_members_agree') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all_agree_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN 3: CUIDADOS --}}
                    <div class="section-header">
                        <div class="section-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                        <span class="fs-5">Cuidados y Rutina</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Motivación para adoptar</label>
                            <textarea class="form-control form-control-rounded" name="home_info[motivation_for_adoption]" rows="2" required placeholder="¿Por qué deseas adoptar?">{{ old('home_info.motivation_for_adoption') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Horas solo/a al día</label>
                            <input type="number" class="form-control form-control-rounded" name="home_info[hours_pet_will_be_alone]" value="{{ old('home_info.hours_pet_will_be_alone') }}" min="0" max="24" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">¿Dónde estará cuando esté solo?</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[location_when_alone]" value="{{ old('home_info.location_when_alone') }}" required placeholder="Ej: Dentro de casa...">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Plan de paseos/ejercicio</label>
                            <textarea class="form-control form-control-rounded" name="home_info[exercise_plan]" rows="2" required>{{ old('home_info.exercise_plan') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Plan vacaciones/emergencias</label>
                            <textarea class="form-control form-control-rounded" name="home_info[vacation_emergency_plan]" rows="2" required>{{ old('home_info.vacation_emergency_plan') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Manejo de comportamiento</label>
                            <textarea class="form-control form-control-rounded" name="home_info[behavioral_issue_plan]" rows="2" required placeholder="¿Qué harías si se porta mal?">{{ old('home_info.behavioral_issue_plan') }}</textarea>
                        </div>
                    </div>

                    {{-- SECCIÓN 4: VETERINARIA --}}
                    <div class="section-header">
                        <div class="section-icon"><i class="bi bi-bandaid-fill"></i></div>
                        <span class="fs-5">Veterinaria (Opcional)</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Veterinario de confianza</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[vet_reference_name]" value="{{ old('home_info.vet_reference_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control form-control-rounded" name="home_info[vet_reference_phone]" value="{{ old('home_info.vet_reference_phone') }}">
                        </div>
                    </div>

                    {{-- CHECKBOX LEGAL --}}
                    <div class="form-check mt-5 mb-4 p-3 rounded-4 border border-1 border-light bg-light">
                        <input class="form-check-input ms-1 mt-1" type="checkbox" name="terms_accepted" id="terms_accepted" required style="cursor: pointer;">
                        <label class="form-check-label small ms-2 text-muted" for="terms_accepted" style="cursor: pointer;">
                            Certifico que toda la información es verdadera y acepto los <a href="#" class="fw-bold text-decoration-none" style="color: var(--color-acento);">Términos y Condiciones</a>.
                        </label>
                    </div>

                    <button type="submit" class="btn-cta-adopt">
                        <i class="bi bi-envelope-heart-fill me-2"></i> Enviar Solicitud de Adopción
                    </button>

                    <p class="text-center mt-3 text-muted small">
                        <i class="bi bi-lock-fill"></i> Tus datos están seguros con nosotros.
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hasYardYes = document.getElementById('has_yard_yes');
        const hasYardNo = document.getElementById('has_yard_no');
        const yardEnclosureField = document.getElementById('yard_enclosure_field');
        
        const petCountInput = document.getElementById('current_pet_count');
        const otherPetsField = document.getElementById('other_pets_field');

        function toggleYardField() {
            yardEnclosureField.style.display = hasYardYes.checked ? 'block' : 'none';
            if (!hasYardYes.checked) {
                document.getElementById('yard_enclosure_type').value = '';
            }
        }

        function toggleOtherPetsField() {
            otherPetsField.style.display = petCountInput.value > 0 ? 'block' : 'none';
             if (petCountInput.value == 0) {
                document.getElementById('others_pets_description').value = '';
            }
        }

        // Event listeners para los cambios
        const yardRadios = document.querySelectorAll('input[name="home_info[has_yard]"]');
        yardRadios.forEach(radio => radio.addEventListener('change', toggleYardField));
        
        petCountInput.addEventListener('input', toggleOtherPetsField);

        // Inicializar estado
        toggleYardField();
        toggleOtherPetsField();
    });
</script>
@endpush