@csrf
@if ($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<h5 class="fw-bold small text-muted text-uppercase mb-3">Información Básica</h5>
<div class="row g-3">
    <div class="col-md-6"><label for="animal_name" class="form-label">Nombre del Animal</label><input type="text" class="form-control form-control-lg rounded-pill" id="animal_name" name="animal_name" value="{{ old('animal_name', $animal['animal_name'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="id_breed" class="form-label d-flex justify-content-between"><span>Raza</span><a href="{{ route('admin.breeds.create') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">+ Nueva</a></label><select class="form-select form-select-lg rounded-pill" id="id_breed" name="id_breed" required><option value="">Selecciona una raza...</option>@foreach($breeds as $breed)<option value="{{ $breed['id_breed'] }}" {{ old('id_breed', $animal['id_breed'] ?? '') == $breed['id_breed'] ? 'selected' : '' }}>{{ $breed['species']['species_name'] }} - {{ $breed['breed_name'] }}</option>@endforeach</select></div>
    <div class="col-md-6"><label for="age" class="form-label">Edad (años)</label><input type="number" class="form-control form-control-lg rounded-pill" id="age" name="age" value="{{ old('age', $animal['age'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="birth_date" class="form-label">Fecha de Nacimiento</label><input type="date" class="form-control form-control-lg rounded-pill" id="birth_date" name="birth_date" value="{{ old('birth_date', $animal['birth_date'] ?? '') }}"></div>
    <div class="col-md-4"><label for="sex" class="form-label">Sexo</label><select class="form-select form-select-lg rounded-pill" id="sex" name="sex" required><option value="Macho" {{ old('sex', $animal['sex'] ?? '') == 'Macho' ? 'selected' : '' }}>Macho</option><option value="Hembra" {{ old('sex', $animal['sex'] ?? '') == 'Hembra' ? 'selected' : '' }}>Hembra</option></select></div>
    <div class="col-md-4"><label for="size" class="form-label">Tamaño</label><select class="form-select form-select-lg rounded-pill" id="size" name="size" required><option value="Pequeño" {{ old('size', $animal['size'] ?? '') == 'Pequeño' ? 'selected' : '' }}>Pequeño</option><option value="Mediano" {{ old('size', $animal['size'] ?? '') == 'Mediano' ? 'selected' : '' }}>Mediano</option><option value="Grande" {{ old('size', $animal['size'] ?? '') == 'Grande' ? 'selected' : '' }}>Grande</option></select></div>
    <div class="col-md-4"><label for="color" class="form-label">Color</label><input type="text" class="form-control form-control-lg rounded-pill" id="color" name="color" value="{{ old('color', $animal['color'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="id_shelter" class="form-label d-flex justify-content-between"><span>Refugio</span><a href="{{ route('admin.shelters.create') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">+ Nuevo</a></label><select class="form-select form-select-lg rounded-pill" id="id_shelter" name="id_shelter" required><option value="">Selecciona un refugio...</option>@foreach($shelters as $shelter)<option value="{{ $shelter['id_shelter'] }}" {{ old('id_shelter', $animal['id_shelter'] ?? '') == $shelter['id_shelter'] ? 'selected' : '' }}>{{ $shelter['shelter_name'] }}</option>@endforeach</select></div>
    <div class="col-md-6"><label for="status" class="form-label">Estado</label><select class="form-select form-select-lg rounded-pill" id="status" name="status" required><option value="Disponible" {{ old('status', $animal['status'] ?? 'Disponible') == 'Disponible' ? 'selected' : '' }}>Disponible</option><option value="En Proceso" {{ old('status', $animal['status'] ?? '') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option><option value="Adoptado" {{ old('status', $animal['status'] ?? '') == 'Adoptado' ? 'selected' : '' }}>Adoptado</option></select></div>
</div>

<hr class="my-4">

<h5 class="fw-bold small text-muted text-uppercase mb-3">Foto y Descripción</h5>
<div class="row g-3">
    <div class="col-12"><label for="main_photo" class="form-label">Foto Principal</label><input type="file" class="form-control form-control-lg" id="main_photo" name="main_photo" {{ !isset($animal) ? 'required' : '' }}>@if(isset($animal) && !empty($animal['photos']))<div class="mt-2"><img src="{{ $animal['photos'][0]['full_image_url'] }}" alt="{{ $animal['animal_name'] }}" height="80" class="rounded shadow-sm"> <small class="text-muted ms-2">Subir un nuevo archivo reemplazará la foto actual.</small></div>@endif</div>
    <div class="col-12"><label for="description" class="form-label">Descripción</label><textarea class="form-control form-control-lg rounded-3" id="description" name="description" rows="4">{{ old('description', $animal['description'] ?? '') }}</textarea></div>
    <div class="col-12"><div class="form-check form-switch p-0 d-flex align-items-center"><input class="form-check-input ms-0 me-2" type="checkbox" role="switch" id="is_sterilized" name="is_sterilized" value="1" {{ old('is_sterilized', $animal['is_sterilized'] ?? false) ? 'checked' : '' }} style="transform: scale(1.5);"><label class="form-check-label fw-bold" for="is_sterilized">Esterilizado</label></div></div>
</div>

@if(!isset($animal))
<hr class="my-4">
<h5 class="fw-bold small text-muted text-uppercase mb-3">Registro Médico Inicial (Opcional)</h5>
<div class="row g-3">
    <div class="col-md-4"><label for="record_event_date" class="form-label">Fecha</label><input type="date" class="form-control form-control-lg rounded-pill" id="record_event_date" name="record_event_date" value="{{ old('record_event_date') }}"></div>
    <div class="col-md-8"><label for="record_event_type" class="form-label">Tipo de Evento</label><input type="text" class="form-control form-control-lg rounded-pill" id="record_event_type" name="record_event_type" value="{{ old('record_event_type') }}" placeholder="Ej: Vacunación, Desparasitación"></div>
    <div class="col-12"><label for="record_description" class="form-label">Descripción</label><textarea class="form-control form-control-lg rounded-3" id="record_description" name="record_description" rows="2">{{ old('record_description') }}</textarea></div>
</div>
@endif

<div class="mt-4 border-top pt-4">
    <button type="submit" class="btn-cta">{{ $buttonText }}</button>
    <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
</div>
@if(isset($animal))
<div class="mt-5">
    <h3 class="hero-title h4">Historial Médico Completo</h3>
    <div class="feature-card mt-3">
        @include('admin.animals.partials.medical-records', ['animal' => $animal])
    </div>
</div>
@endif