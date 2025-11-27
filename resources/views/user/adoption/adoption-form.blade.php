@extends('layouts.app')

@section('title', 'Formulario de Adopción para ' . $animal['animal_name'])

@section('content')
{{-- AJUSTE 1: padding-top: 100px para que el Navbar no tape el contenido --}}
<div class="container mb-5" style="padding-top: 100px;">
    <div class="row">
        {{-- Columna de Información del Animal --}}
        <div class="col-lg-4 text-center mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm sticky-top" style="top: 110px; z-index: 0;">
                <div class="card-body">
                    @if(!empty($animal['photos']))
                        <img src="{{ env('API_URL', 'http://127.0.0.1:8000') . '/storage/' . $animal['photos'][0]['image_url'] }}" 
                             class="img-fluid rounded-circle mb-3 shadow-sm border border-4 border-white" 
                             style="width: 200px; height: 200px; object-fit: cover;" 
                             alt="Foto de {{ $animal['animal_name'] }}">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                            <i class="bi bi-camera fs-1 text-muted"></i>
                        </div>
                    @endif
                    
                    <h2 class="fw-bold text-primary">{{ $animal['animal_name'] }}</h2>
                    <p class="text-muted fw-bold">{{ $animal['breed']['breed_name'] ?? 'Mestizo' }} &bull; {{ $animal['age'] }} años</p>
                    <hr class="opacity-10">
                    <p class="small text-muted">Estás a un paso de cambiar una vida. Por favor, completa este formulario con la mayor sinceridad posible. Tu información nos ayuda a asegurar que nuestros animalitos encuentren el hogar perfecto.</p>
                </div>
            </div>
        </div>

        {{-- Columna del Formulario --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4">
                <h3 class="fw-bold" style="color: #003366;">Solicitud de Adopción</h3>
                <hr class="mb-4">

                @if($errors->any())
                    <div class="alert alert-danger rounded-3 border-0">
                        <p class="fw-bold mb-2"><i class="bi bi-exclamation-circle-fill"></i> Por favor corrige los siguientes errores:</p>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('adoption.submit', $animal['id_animal']) }}" method="POST">
                    @csrf
                    
                    {{-- Sección 1 --}}
                    <h5 class="mt-2 fw-bold text-success"><i class="bi bi-house-door-fill me-2"></i>1. Sobre tu Vivienda</h5>
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="dwelling_type" class="form-label fw-bold small text-muted">Tipo de vivienda</label>
                            <input type="text" class="form-control" id="dwelling_type" name="home_info[dwelling_type]" value="{{ old('home_info.dwelling_type') }}" placeholder="Ej: Casa, Apartamento..." required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label for="adults_in_home" class="form-label fw-bold small text-muted">Adultos en casa</label>
                            <input type="number" class="form-control" id="adults_in_home" name="home_info[adults_in_home]" value="{{ old('home_info.adults_in_home') }}" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="wall_material" class="form-label fw-bold small text-muted">Material paredes</label>
                            <input type="text" class="form-control" id="wall_material" name="home_info[wall_material]" value="{{ old('home_info.wall_material') }}" placeholder="Ej: Ladrillo, Cemento" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="floor_material" class="form-label fw-bold small text-muted">Material piso</label>
                            <input type="text" class="form-control" id="floor_material" name="home_info[floor_material]" value="{{ old('home_info.floor_material') }}" placeholder="Ej: Cerámica, Madera" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="room_count" class="form-label fw-bold small text-muted">Habitaciones</label>
                            <input type="number" class="form-control" id="room_count" name="home_info[room_count]" value="{{ old('home_info.room_count') }}" min="1" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="bathroom_count" class="form-label fw-bold small text-muted">Baños</label>
                            <input type="number" class="form-control" id="bathroom_count" name="home_info[bathroom_count]" value="{{ old('home_info.bathroom_count') }}" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">¿Tiene patio?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[has_yard]" id="has_yard_yes" value="1" {{ old('home_info.has_yard') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="has_yard_yes">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[has_yard]" id="has_yard_no" value="0" {{ old('home_info.has_yard', '0') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_yard_no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3" id="yard_enclosure_field" style="display: none;">
                            <label for="yard_enclosure_type" class="form-label fw-bold small text-muted">Tipo de cerramiento del patio</label>
                            <input type="text" class="form-control" id="yard_enclosure_type" name="home_info[yard_enclosure_type]" value="{{ old('home_info.yard_enclosure_type') }}" placeholder="Ej: Muro alto, Reja, Cerca de madera">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">¿Tiene balcón?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[has_balcony]" id="has_balcony_yes" value="1" {{ old('home_info.has_balcony') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="has_balcony_yes">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[has_balcony]" id="has_balcony_no" value="0" {{ old('home_info.has_balcony', '0') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_balcony_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 2 --}}
                    <h5 class="mt-4 fw-bold text-success"><i class="bi bi-people-fill me-2"></i>2. Familia y Mascotas</h5>
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="current_pet_count" class="form-label fw-bold small text-muted">Mascotas actuales</label>
                            <input type="number" class="form-control" id="current_pet_count" name="home_info[current_pet_count]" value="{{ old('home_info.current_pet_count') }}" min="0" required>
                        </div>
                        <div class="col-md-12 mb-3" id="other_pets_field" style="display: none;">
                            <label for="others_pets_description" class="form-label fw-bold small text-muted">Describe a tus otras mascotas</label>
                            <textarea class="form-control" id="others_pets_description" name="home_info[others_pets_description]" rows="2" placeholder="Ej: Perro Poodle de 5 años...">{{ old('home_info.others_pets_description') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="previous_pets_history" class="form-label fw-bold small text-muted">Experiencia previa con mascotas</label>
                            <textarea class="form-control" id="previous_pets_history" name="home_info[previous_pets_history]" rows="2" placeholder="Cuéntanos tu historia...">{{ old('home_info.previous_pets_history') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold small text-muted">¿Todos en casa están de acuerdo?</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_members_agree_yes" value="1" {{ old('home_info.all_members_agree') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="all_members_agree_yes">Sí, todos</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_members_agree_no" value="0" {{ old('home_info.all_members_agree') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="all_members_agree_no">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sección 3 --}}
                    <h5 class="mt-4 fw-bold text-success"><i class="bi bi-heart-pulse-fill me-2"></i>3. Cuidados</h5>
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-md-12 mb-3">
                            <label for="motivation_for_adoption" class="form-label fw-bold small text-muted">Motivación para adoptar</label>
                            <textarea class="form-control" id="motivation_for_adoption" name="home_info[motivation_for_adoption]" rows="2" required placeholder="¿Por qué deseas adoptar?">{{ old('home_info.motivation_for_adoption') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="hours_pet_will_be_alone" class="form-label fw-bold small text-muted">Horas solo/a al día</label>
                            <input type="number" class="form-control" id="hours_pet_will_be_alone" name="home_info[hours_pet_will_be_alone]" value="{{ old('home_info.hours_pet_will_be_alone') }}" min="0" max="24" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location_when_alone" class="form-label fw-bold small text-muted">¿Dónde estará cuando esté solo/a?</label>
                            <input type="text" class="form-control" id="location_when_alone" name="home_info[location_when_alone]" value="{{ old('home_info.location_when_alone') }}" required placeholder="Ej: Dentro de casa...">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="exercise_plan" class="form-label fw-bold small text-muted">Plan de paseos/ejercicio</label>
                            <textarea class="form-control" id="exercise_plan" name="home_info[exercise_plan]" rows="2" required>{{ old('home_info.exercise_plan') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="vacation_emergency_plan" class="form-label fw-bold small text-muted">Plan vacaciones/emergencias</label>
                            <textarea class="form-control" id="vacation_emergency_plan" name="home_info[vacation_emergency_plan]" rows="2" required>{{ old('home_info.vacation_emergency_plan') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="behavioral_issue_plan" class="form-label fw-bold small text-muted">Manejo de comportamiento</label>
                            <textarea class="form-control" id="behavioral_issue_plan" name="home_info[behavioral_issue_plan]" rows="2" required placeholder="¿Qué harías si se porta mal?">{{ old('home_info.behavioral_issue_plan') }}</textarea>
                        </div>
                    </div>

                    {{-- Sección 4 --}}
                    <h5 class="mt-4 fw-bold text-success"><i class="bi bi-bandaid-fill me-2"></i>4. Veterinaria (Opcional)</h5>
                    <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="vet_reference_name" class="form-label fw-bold small text-muted">Veterinario de confianza</label>
                            <input type="text" class="form-control" id="vet_reference_name" name="home_info[vet_reference_name]" value="{{ old('home_info.vet_reference_name') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="vet_reference_phone" class="form-label fw-bold small text-muted">Teléfono</label>
                            <input type="text" class="form-control" id="vet_reference_phone" name="home_info[vet_reference_phone]" value="{{ old('home_info.vet_reference_phone') }}">
                        </div>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input @error('terms_accepted') is-invalid @enderror" type="checkbox" name="terms_accepted" id="terms_accepted" required>
                        <label class="form-check-label small" for="terms_accepted">
                            He leído y acepto los <a href="#" class="text-decoration-none fw-bold">Términos y Condiciones</a> de la adopción.
                        </label>
                        @error('terms_accepted')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info border-0 rounded-3 small" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Al enviar, confirmas que la información es real. Revisaremos tu perfil y te contactaremos por email.
                    </div>

                    <button type="submit" class="btn btn-lg w-100 fw-bold text-white shadow-sm" style="background-color: #FF7F50; border: none;">
                        Enviar Solicitud
                    </button>
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

        hasYardYes.addEventListener('change', toggleYardField);
        hasYardNo.addEventListener('change', toggleYardField);
        petCountInput.addEventListener('input', toggleOtherPetsField);

        toggleYardField();
        toggleOtherPetsField();
    });
</script>
@endpush