@csrf

@if ($errors->any())
<div class="alert alert-danger rounded-3">
    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

<div class="row g-3">
    <div class="col-md-6">
        <label for="id_species" class="form-label fw-bold small text-muted d-flex justify-content-between align-items-center">
            <span>ESPECIE</span>
            <a href="{{ route('admin.species.create') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">+ Nueva</a>
        </label>
        
        <select class="form-select form-select-lg rounded-pill" id="id_species" name="id_species" required>
            <option value="" disabled {{ !isset($breed['id_species']) ? 'selected' : '' }}>Selecciona una especie...</option>
            @foreach($species as $specie)
                <option value="{{ $specie['id_species'] }}" {{ old('id_species', $breed['id_species'] ?? '') == $specie['id_species'] ? 'selected' : '' }}>
                    {{ $specie['species_name'] }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label for="breed_name" class="form-label fw-bold small text-muted">NOMBRE DE LA RAZA</label>
        <input type="text" class="form-control form-control-lg rounded-pill" id="breed_name" name="breed_name" value="{{ old('breed_name', $breed['breed_name'] ?? '') }}" required>
    </div>
</div>

<div class="mt-4 border-top pt-4">
    <button type="submit" class="btn-cta">{{ $buttonText }}</button>
    <a href="{{ route('admin.breeds.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
</div>