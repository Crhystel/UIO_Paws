@csrf

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
    <div class="col-md-6">
        <label for="animal_name" class="form-label">Nombre del Animal</label>
        <input type="text" class="form-control" id="animal_name" name="animal_name" value="{{ old('animal_name', $animal['animal_name'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="id_breed" class="form-label d-flex justify-content-between align-items-center">
            <span>Raza</span>
            <a href="{{ route('admin.breeds.create') }}" target="_blank" class="btn btn-sm btn-outline-success">+ Nueva Raza</a>
        </label>
        <select class="form-select" id="id_breed" name="id_breed" required>
            <option value="">Selecciona una raza...</option>
            @foreach($breeds as $breed)
                <option value="{{ $breed['id_breed'] }}" {{ old('id_breed', $animal['id_breed'] ?? '') == $breed['id_breed'] ? 'selected' : '' }}>
                    {{ $breed['species']['species_name'] }} - {{ $breed['breed_name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="age" class="form-label">Edad (años)</label>
        <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $animal['age'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label for="birth_date" class="form-label">Fecha de Nacimiento (Opcional)</label>
        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date', $animal['birth_date'] ?? '') }}">
    </div>
    <div class="col-md-4">
        <label for="sex" class="form-label">Sexo</label>
        <select class="form-select" id="sex" name="sex" required>
            <option value="Macho" {{ old('sex', $animal['sex'] ?? '') == 'Macho' ? 'selected' : '' }}>Macho</option>
            <option value="Hembra" {{ old('sex', $animal['sex'] ?? '') == 'Hembra' ? 'selected' : '' }}>Hembra</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="size" class="form-label">Tamaño</label>
        <select class="form-select" id="size" name="size" required>
            <option value="Pequeño" {{ old('size', $animal['size'] ?? '') == 'Pequeño' ? 'selected' : '' }}>Pequeño</option>
            <option value="Mediano" {{ old('size', $animal['size'] ?? '') == 'Mediano' ? 'selected' : '' }}>Mediano</option>
            <option value="Grande" {{ old('size', $animal['size'] ?? '') == 'Grande' ? 'selected' : '' }}>Grande</option>
        </select>
    </div>
     <div class="col-md-4">
        <label for="color" class="form-label">Color</label>
        <input type="text" class="form-control" id="color" name="color" value="{{ old('color', $animal['color'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label for="id_shelter" class="form-label d-flex justify-content-between align-items-center">
            <span>Refugio</span>
            <a href="{{ route('admin.shelters.create') }}" target="_blank" class="btn btn-sm btn-outline-success">+ Nuevo Refugio</a>
        </label>
        <select class="form-select" id="id_shelter" name="id_shelter" required>
            <option value="">Selecciona un refugio...</option>
            @foreach($shelters as $shelter)
                <option value="{{ $shelter['id_shelter'] }}" {{ old('id_shelter', $animal['id_shelter'] ?? '') == $shelter['id_shelter'] ? 'selected' : '' }}>
                    {{ $shelter['shelter_name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Estado</label>
        <select class="form-select" id="status" name="status" required>
            <option value="Disponible" {{ old('status', $animal['status'] ?? '') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="En Proceso" {{ old('status', $animal['status'] ?? '') == 'En Proceso' ? 'selected' : '' }}>En Proceso</option>
            <option value="Adoptado" {{ old('status', $animal['status'] ?? '') == 'Adoptado' ? 'selected' : '' }}>Adoptado</option>
        </select>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Descripción</label>
        <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $animal['description'] ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="is_sterilized" name="is_sterilized" value="1" {{ old('is_sterilized', $animal['is_sterilized'] ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_sterilized">Esterilizado</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">{{ $buttonText }}</button>
    <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary">Cancelar</a>
</div>