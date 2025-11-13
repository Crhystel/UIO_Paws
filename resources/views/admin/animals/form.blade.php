@csrf

{{-- SECCIÓN DE ERRORES --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong class="h5">¡Error!</strong> Por favor, corrige los siguientes campos:
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-6"><label for="animal_name" class="form-label">Nombre del Animal</label><input type="text" class="form-control" id="animal_name" name="animal_name" value="{{ old('animal_name', $animal['animal_name'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="id_breed" class="form-label d-flex justify-content-between align-items-center"><span>Raza</span> <a href="{{ route('admin.breeds.create') }}" target="_blank" class="btn btn-sm btn-outline-success">+ Nueva Raza</a></label><select class="form-select" id="id_breed" name="id_breed" required><option value="">Selecciona una raza...</option>@foreach($breeds as $breed)<option value="{{ $breed['id_breed'] }}" {{ old('id_breed', $animal['id_breed'] ?? '') == $breed['id_breed'] ? 'selected' : '' }}>{{ $breed['species']['species_name'] }} - {{ $breed['breed_name'] }}</option>@endforeach</select></div>
    <div class="col-md-6"><label for="age" class="form-label">Edad (años)</label><input type="number" class="form-control" id="age" name="age" value="{{ old('age', $animal['age'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="birth_date" class="form-label">Fecha de Nacimiento</label><input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', $animal['birth_date'] ?? '') }}"></div>
    <div class="col-md-4"><label for="sex" class="form-label">Sexo</label><select class="form-select" id="sex" name="sex" required><option value="Macho" {{ old('sex', $animal['sex'] ?? '') == 'Macho' ? 'selected' : '' }}>Macho</option><option value="Hembra" {{ old('sex', $animal['sex'] ?? '') == 'Hembra' ? 'selected' : '' }}>Hembra</option></select></div>
    <div class="col-md-4"><label for="size" class="form-label">Tamaño</label><select class="form-select" id="size" name="size" required><option value="Pequeño" {{ old('size', $animal['size'] ?? '') == 'Pequeño' ? 'selected' : '' }}>Pequeño</option><option value="Mediano" {{ old('size', $animal['size'] ?? '') == 'Mediano' ? 'selected' : '' }}>Mediano</option><option value="Grande" {{ old('size', $animal['size'] ?? '') == 'Grande' ? 'selected' : '' }}>Grande</option></select></div>
    <div class="col-md-4"><label for="color" class="form-label">Color</label><input type="text" class="form-control" id="color" name="color" value="{{ old('color', $animal['color'] ?? '') }}" required></div>
    <div class="col-md-6"><label for="id_shelter" class="form-label d-flex justify-content-between align-items-center"><span>Refugio</span> <a href="{{ route('admin.shelters.create') }}" target="_blank" class="btn btn-sm btn-outline-success">+ Nuevo Refugio</a></label><select class="form-select" id="id_shelter" name="id_shelter" required><option value="">Selecciona un refugio...</option>@foreach($shelters as $shelter)<option value="{{ $shelter['id_shelter'] }}" {{ old('id_shelter', $animal['id_shelter'] ?? '') == $shelter['id_shelter'] ? 'selected' : '' }}>{{ $shelter['shelter_name'] }}</option>@endforeach</select></div>
    <div class="col-md-6"><label for="status" class="form-label">Estado</label><select class="form-select" id="status" name="status" required><option value="Disponible" {{ old('status', $animal['status'] ?? 'Disponible') == 'Disponible' ? 'selected' : '' }}>Disponible</option><option value="En Proceso" {{ old('status', $animal['status'] ?? '') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option><option value="Adoptado" {{ old('status', $animal['status'] ?? '') == 'Adoptado' ? 'selected' : '' }}>Adoptado</option></select></div>
    <div class="col-12"><label for="main_photo" class="form-label">Foto Principal</label><input type="file" class="form-control" id="main_photo" name="main_photo" {{ !isset($animal) ? 'required' : '' }}>@if(isset($animal) && !empty($animal['photos']))<div class="mt-2"><small>Foto actual:</small><br><img src="{{ $animal['photos'][0]['full_image_url'] }}" alt="{{ $animal['animal_name'] }}" height="80" class="rounded"></div><small class="text-muted">Subir un nuevo archivo reemplazará la foto principal existente.</small>@endif</div>
    <div class="col-12"><label for="description" class="form-label">Descripción</label><textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $animal['description'] ?? '') }}</textarea></div>
    <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" id="is_sterilized" name="is_sterilized" value="1" {{ old('is_sterilized', $animal['is_sterilized'] ?? false) ? 'checked' : '' }}><label class="form-check-label" for="is_sterilized">Esterilizado</label></div></div>
</div>

<div class="col-12 mt-4 pt-3 border-top">
    <h5 class="mb-3">Registro Médico Inicial</h5>
    <p class="text-muted small">Añade aquí el primer evento médico del animal. Podrás añadir más después de crearlo.</p>
    <div class="row g-3">
        <div class="col-md-4">
            <label for="record_event_date" class="form-label">Fecha del Evento</label>
            <input type="date" class="form-control" id="record_event_date" name="record_event_date" value="{{ old('record_event_date', $animal['medical_records'][0]['event_date'] ?? '') }}">
        </div>
        <div class="col-md-8">
            <label for="record_event_type" class="form-label">Tipo de Evento</label>
            <input type="text" class="form-control" id="record_event_type" name="record_event_type" value="{{ old('record_event_type', $animal['medical_records'][0]['event_type'] ?? '') }}" placeholder="Ej: Vacunación, Desparasitación">
        </div>
        <div class="col-12">
            <label for="record_description" class="form-label">Descripción del Evento</label>
            <textarea class="form-control" id="record_description" name="record_description" rows="3" placeholder="Añade detalles sobre el evento.">{{ old('record_description', $animal['medical_records'][0]['description'] ?? '') }}</textarea>
        </div>
        <div class="col-md-6">
            <label for="record_veterinarian_name" class="form-label">Nombre del Veterinario</label>
            <input type="text" class="form-control" id="record_veterinarian_name" name="record_veterinarian_name" value="{{ old('record_veterinarian_name', $animal['medical_records'][0]['veterinarian_name'] ?? '') }}">
        </div>
        <div class="col-md-6">
            <label for="record_medication" class="form-label">Medicamento</label>
            <input type="text" class="form-control" id="record_medication" name="record_medication" value="{{ old('record_medication', $animal['medical_records'][0]['medication'] ?? '') }}">
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
    <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

@if(isset($animal))
    
    {{-- SECCIÓN GALERÍA DE FOTOS --}}
    <div class="card mt-5">
        <div class="card-header"><h2 class="h4 mb-0">Galería de Fotos Adicionales</h2></div>
        <div class="card-body">
            <div class="row mb-3">
                @forelse(array_slice($animal['photos'] ?? [], 1) as $photo)
                    <div class="col-md-3 text-center mb-3">
                        <img src="{{ $photo['full_image_url'] }}" class="img-thumbnail" alt="Foto de {{ $animal['animal_name'] }}">
                        <form action="{{ route('admin.photos.destroy', $photo['id_animal_photos']) }}" method="POST" class="d-inline mt-2" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta foto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </div>
                @empty
                    <p class="text-center text-muted">Aún no hay fotos adicionales en la galería.</p>
                @endforelse
            </div>
            <hr>
            <h5>Añadir Nueva Foto a la Galería</h5>
            <form action="{{ route('admin.animals.photos.store', ['animal' => $animal['id_animal']]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group">
                    <input type="file" name="photo" class="form-control">
                    <button type="submit" class="btn btn-primary">Subir Foto</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SECCIÓN HISTORIAL MÉDICO --}}
    <div class="card mt-4">
        <div class="card-header"><h2 class="h4 mb-0">Historial Médico Completo</h2></div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo de Evento</th>
                        <th>Descripción</th>
                        <th>Veterinario</th>
                        <th>Medicamento</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($animal['medical_records'] ?? [] as $record)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($record['event_date'])->format('d/m/Y') }}</td>
                            <td>{{ $record['event_type'] }}</td>
                            <td>{{ $record['description'] }}</td>
                            <td>{{ $record['veterinarian_name'] ?? 'N/A' }}</td>
                            <td>{{ $record['medication'] ?? 'N/A' }}</td>
                            <td>
                                <form action="{{ route('admin.records.destroy', $record['id_medical_records']) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        {{-- Actualizar el colspan para que ocupe todas las columnas --}}
                        <tr><td colspan="6" class="text-center text-muted">No hay registros médicos.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <hr>
            <h5>Añadir Nuevo Registro Médico</h5>
            <form action="{{ route('admin.animals.records.store', ['animal' => $animal['id_animal']]) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4"><input type="date" name="event_date" class="form-control" required></div>
                    <div class="col-md-8"><input type="text" name="event_type" class="form-control" placeholder="Tipo de evento" required></div>
                    <div class="col-12"><textarea name="description" class="form-control" placeholder="Descripción detallada..." required></textarea></div>
                    <div class="col-md-6">
                        <label for="veterinarian_name" class="form-label">Nombre del Veterinario</label>
                        <input type="text" class="form-control" id="veterinarian_name" name="veterinarian_name">
                    </div>
                    <div class="col-md-6">
                        <label for="medication" class="form-label">Medicamento</label>
                        <input type="text" class="form-control" id="medication" name="medication">
                    </div>

                </div>
                <button type="submit" class="btn btn-primary mt-3">Añadir Registro</button>
            </form>
        </div>
    </div>
@endif