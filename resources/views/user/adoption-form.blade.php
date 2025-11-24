@extends('layouts.app')

@section('title', 'Formulario de Adopción para ' . $animal['animal_name'])

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        {{-- Columna de Información del Animal --}}
        <div class="col-lg-4 text-center mb-4 mb-lg-0">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    @if(!empty($animal['photos']))
                        <img src="{{ env('API_BASE_URL') . $animal['photos'][0]['full_image_url'] }}" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;" alt="Foto de {{ $animal['animal_name'] }}">
                    @endif
                    <h2>{{ $animal['animal_name'] }}</h2>
                    <p class="text-muted">{{ $animal['breed']['breed_name'] }} &bull; {{ $animal['age'] }} años</p>
                    <hr>
                    <p class="small">Estás a un paso de cambiar una vida. Por favor, completa este formulario con la mayor sinceridad posible. Tu información nos ayuda a asegurar que nuestros animalitos encuentren el hogar perfecto.</p>
                </div>
            </div>
        </div>

        {{-- Columna del Formulario --}}
        <div class="col-lg-8">
            <h3>Formulario de Solicitud de Adopción</h3>
            <hr>

            @if($errors->any())
                <div class="alert alert-danger">
                    <p><strong>Por favor corrige los siguientes errores:</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('adoption.submit', $animal['id_animal']) }}" method="POST">
                @csrf
                
                {{-- Los nombres de los campos DEBEN coincidir con la validación: home_info[campo] --}}

                {{-- Sección 1: Sobre tu Vivienda --}}
                <h5 class="mt-4">1. Sobre tu Vivienda</h5>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="dwelling_type" class="form-label">Tipo de vivienda</label>
                        <input type="text" class="form-control" id="dwelling_type" name="home_info[dwelling_type]" value="{{ old('home_info.dwelling_type') }}" placeholder="Ej: Casa, Apartamento, Finca" required>
                    </div>
                     <div class="col-md-6 mb-3">
                        <label for="adults_in_home" class="form-label">¿Cuántos adultos viven en casa?</label>
                        <input type="number" class="form-control" id="adults_in_home" name="home_info[adults_in_home]" value="{{ old('home_info.adults_in_home') }}" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="wall_material" class="form-label">Material de las paredes</label>
                        <input type="text" class="form-control" id="wall_material" name="home_info[wall_material]" value="{{ old('home_info.wall_material') }}" placeholder="Ej: Ladrillo, Cemento" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="floor_material" class="form-label">Material del piso</label>
                        <input type="text" class="form-control" id="floor_material" name="home_info[floor_material]" value="{{ old('home_info.floor_material') }}" placeholder="Ej: Cerámica, Madera" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="room_count" class="form-label">Número de habitaciones</label>
                        <input type="number" class="form-control" id="room_count" name="home_info[room_count]" value="{{ old('home_info.room_count') }}" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bathroom_count" class="form-label">Número de baños</label>
                        <input type="number" class="form-control" id="bathroom_count" name="home_info[bathroom_count]" value="{{ old('home_info.bathroom_count') }}" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">¿Tu vivienda tiene patio?</label>
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
                    <div class="col-md-6 mb-3" id="yard_enclosure_field" style="display: none;">
                        <label for="yard_enclosure_type" class="form-label">Tipo de cerramiento del patio</label>
                        <input type="text" class="form-control" id="yard_enclosure_type" name="home_info[yard_enclosure_type]" value="{{ old('home_info.yard_enclosure_type') }}" placeholder="Ej: Muro alto, Reja, Cerca de madera">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">¿Tienes balcón(es)?</label>
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

                {{-- Sección 2: Sobre tu Familia y Otras Mascotas --}}
                <h5 class="mt-4">2. Sobre tu Familia y Otras Mascotas</h5>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="current_pet_count" class="form-label">¿Cuántas mascotas tienes actualmente?</label>
                        <input type="number" class="form-control" id="current_pet_count" name="home_info[current_pet_count]" value="{{ old('home_info.current_pet_count') }}" min="0" required>
                    </div>
                    <div class="col-md-12 mb-3" id="other_pets_field" style="display: none;">
                        <label for="others_pets_description" class="form-label">Describe a tus otras mascotas</label>
                        <textarea class="form-control" id="others_pets_description" name="home_info[others_pets_description]" rows="3" placeholder="Ej: Un perro Poodle de 5 años, un gato criollo de 2 años. Ambos esterilizados y con vacunas al día.">{{ old('home_info.others_pets_description') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="previous_pets_history" class="form-label">¿Has tenido mascotas antes? Cuéntanos sobre ellas.</label>
                        <textarea class="form-control" id="previous_pets_history" name="home_info[previous_pets_history]" rows="3" placeholder="Describe brevemente tu experiencia previa con mascotas.">{{ old('home_info.previous_pets_history') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">¿Todos los miembros de tu hogar están de acuerdo con la adopción?</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_members_agree_yes" value="1" {{ old('home_info.all_members_agree') == '1' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="all_members_agree_yes">Sí, todos están de acuerdo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="home_info[all_members_agree]" id="all_members_agree_no" value="0" {{ old('home_info.all_members_agree') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="all_members_agree_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección 3: Planes y Cuidados para el Animalito --}}
                <h5 class="mt-4">3. Planes y Cuidados</h5>
                <div class="row g-3">
                    <div class="col-md-12 mb-3">
                        <label for="motivation_for_adoption" class="form-label">¿Cuál es tu principal motivación para adoptar?</label>
                        <textarea class="form-control" id="motivation_for_adoption" name="home_info[motivation_for_adoption]" rows="3" required placeholder="Queremos conocer por qué quieres darle un hogar a un animalito.">{{ old('home_info.motivation_for_adoption') }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="hours_pet_will_be_alone" class="form-label">Horas al día que pasaría solo/a</label>
                        <input type="number" class="form-control" id="hours_pet_will_be_alone" name="home_info[hours_pet_will_be_alone]" value="{{ old('home_info.hours_pet_will_be_alone') }}" min="0" max="24" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="location_when_alone" class="form-label">¿Dónde estaría cuando esté solo/a?</label>
                        <input type="text" class="form-control" id="location_when_alone" name="home_info[location_when_alone]" value="{{ old('home_info.location_when_alone') }}" required placeholder="Ej: Dentro de casa, en el patio, en una habitación específica.">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="exercise_plan" class="form-label">Plan de ejercicio y paseos</label>
                        <textarea class="form-control" id="exercise_plan" name="home_info[exercise_plan]" rows="3" required placeholder="Describe la frecuencia, duración y lugar de los paseos o juegos.">{{ old('home_info.exercise_plan') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="vacation_emergency_plan" class="form-label">Plan en caso de vacaciones o emergencias</label>
                        <textarea class="form-control" id="vacation_emergency_plan" name="home_info[vacation_emergency_plan]" rows="3" required placeholder="¿Quién cuidaría de la mascota si te vas de viaje o tienes una emergencia?">{{ old('home_info.vacation_emergency_plan') }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="behavioral_issue_plan" class="form-label">¿Cómo manejarías problemas de comportamiento?</label>
                        <textarea class="form-control" id="behavioral_issue_plan" name="home_info[behavioral_issue_plan]" rows="3" required placeholder="Ej: Si rompe algo, ladra mucho, etc. ¿Buscarías ayuda profesional?">{{ old('home_info.behavioral_issue_plan') }}</textarea>
                    </div>
                </div>

                {{-- Sección 4: Referencia Veterinaria (Opcional) --}}
                <h5 class="mt-4">4. Referencia Veterinaria (Opcional)</h5>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="vet_reference_name" class="form-label">Nombre de tu veterinario de confianza</label>
                        <input type="text" class="form-control" id="vet_reference_name" name="home_info[vet_reference_name]" value="{{ old('home_info.vet_reference_name') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="vet_reference_phone" class="form-label">Teléfono del veterinario</label>
                        <input type="text" class="form-control" id="vet_reference_phone" name="home_info[vet_reference_phone]" value="{{ old('home_info.vet_reference_phone') }}">
                    </div>
                </div>

                <hr class="mt-4">
                <div class="alert alert-light" role="alert">
                    Al enviar esta solicitud, confirmas que toda la información proporcionada es verídica y completa. Entiendes que el equipo de la organización revisará tu perfil y que este formulario es el primer paso en el proceso de adopción. Si tu solicitud es pre-aprobada, nos comunicaremos contigo por correo electrónico para coordinar los siguientes pasos.
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Enviar Solicitud de Adopción</button>
            </form>
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

        // Event listeners
        hasYardYes.addEventListener('change', toggleYardField);
        hasYardNo.addEventListener('change', toggleYardField);
        petCountInput.addEventListener('input', toggleOtherPetsField);

        // Initial check on page load
        toggleYardField();
        toggleOtherPetsField();
    });
</script>
@endpush