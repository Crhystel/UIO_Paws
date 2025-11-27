@csrf
{{-- CATEGORÍA --}}
<div class="mb-3">
    <label class="form-label fw-bold">Tipo de Artículo</label>
    <select class="form-select" id="categorySelect" name="category" onchange="handleCategoryChange()" required>
        <option value="" disabled selected>Selecciona una categoría...</option>
        @foreach(['Alimento', 'Medicina', 'Juguetes', 'Mantas', 'Higiene', 'Otro'] as $cat)
            <option value="{{ $cat }}" {{ (old('category', $item['category'] ?? '') == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
</div>

{{-- NOMBRE DEL ARTÍCULO --}}
<div class="mb-3">
    <label for="item_name" class="form-label fw-bold">Nombre Específico</label>
    <div class="input-group">
        <span class="input-group-text bg-white"><i id="iconPreview" class="bi bi-box"></i></span>
        <input type="text" class="form-control" id="item_name" name="item_name" 
               value="{{ old('item_name', $item['item_name'] ?? '') }}" 
               placeholder="Ej. Croquetas para cachorro" required>
    </div>
    <div class="form-text" id="itemNameHelp">Si seleccionas "Otro", especifica aquí el nombre.</div>
</div>

<div class="row">
    {{-- CANTIDAD --}}
    <div class="col-md-6 mb-3">
        <label for="quantity_needed" class="form-label fw-bold">Cantidad Meta</label>
        <input type="number" class="form-control" name="quantity_needed" min="1" 
               value="{{ old('quantity_needed', $item['quantity_needed'] ?? 1) }}" required>
    </div>

    {{-- REFUGIO --}}
    <div class="col-md-6 mb-3">
        <label for="id_shelter" class="form-label fw-bold">Refugio Destino</label>
        <select name="id_shelter" class="form-select">
            <option value="">General (Todos los refugios)</option>
            @foreach($shelters as $shelter)
                <option value="{{ $shelter['id_shelter'] }}" 
                    {{ (old('id_shelter', $item['id_shelter'] ?? '') == $shelter['id_shelter']) ? 'selected' : '' }}>
                    {{ $shelter['shelter_name'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mb-3">
    <label for="description" class="form-label fw-bold">Descripción / Detalles</label>
    <textarea class="form-control" name="description" rows="3">{{ old('description', $item['description'] ?? '') }}</textarea>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">{{ $buttonText }}</button>
    <a href="{{ route('admin.donation-items.index') }}" class="btn btn-secondary">Cancelar</a>
</div>

<script>
function handleCategoryChange() {
    const category = document.getElementById('categorySelect').value;
    const nameInput = document.getElementById('item_name');
    const iconPreview = document.getElementById('iconPreview');

    // Mapeo de iconos
    const icons = {
        'Alimento': 'bi-egg-fried',
        'Medicina': 'bi-capsule',
        'Juguetes': 'bi-joystick',
        'Mantas': 'bi-box-seam',
        'Higiene': 'bi-droplet',
        'Otro': 'bi-question-circle'
    };

    // Actualizar icono
    iconPreview.className = 'bi ' + (icons[category] || 'bi-box');
    if (category !== 'Otro' && category !== '') {
        if(nameInput.value === '') nameInput.value = category; 
    }
}
// Ejecutar al cargar por si es edición
document.addEventListener("DOMContentLoaded", handleCategoryChange);
</script>