@csrf
@if ($errors->any())
    <div class="alert alert-danger rounded-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="row g-3">
    {{-- CATEGORÍA --}}
    <div class="col-md-6">
        <label for="categorySelect" class="form-label fw-bold small text-muted">CATEGORÍA</label>
        <select class="form-select form-select-lg rounded-pill" id="categorySelect" name="category" onchange="handleCategoryChange()" required>
            <option value="" disabled {{ !isset($item['category']) ? 'selected' : '' }}>Selecciona una categoría...</option>
            @foreach(['Alimento', 'Medicina', 'Juguetes', 'Mantas', 'Higiene', 'Otro'] as $cat)
                <option value="{{ $cat }}" {{ (old('category', $item['category'] ?? '') == $cat) ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>

    {{-- NOMBRE DEL ARTÍCULO --}}
    <div class="col-md-6">
        <label for="item_name" class="form-label fw-bold small text-muted">NOMBRE ESPECÍFICO</label>
        <div class="input-group">
            <span class="input-group-text bg-light rounded-start-pill border-end-0" style="font-size: 1.2rem;"><i id="iconPreview" class="bi bi-box"></i></span>
            <input type="text" class="form-control form-control-lg rounded-end-pill border-start-0" id="item_name" name="item_name" 
                   value="{{ old('item_name', $item['item_name'] ?? '') }}" 
                   placeholder="Ej. Croquetas para cachorro" required>
        </div>
    </div>

    {{-- CANTIDAD --}}
    <div class="col-md-6">
        <label for="quantity_needed" class="form-label fw-bold small text-muted">CANTIDAD META</label>
        <input type="number" class="form-control form-control-lg rounded-pill" name="quantity_needed" min="1" 
               value="{{ old('quantity_needed', $item['quantity_needed'] ?? 1) }}" required>
    </div>

    {{-- REFUGIO --}}
    <div class="col-md-6">
        <label for="id_shelter" class="form-label fw-bold small text-muted">REFUGIO DESTINO</label>
        <select name="id_shelter" class="form-select form-select-lg rounded-pill">
            <option value="">General (Todos los refugios)</option>
            @foreach($shelters as $shelter)
                <option value="{{ $shelter['id_shelter'] }}" 
                    {{ (old('id_shelter', $item['id_shelter'] ?? '') == $shelter['id_shelter']) ? 'selected' : '' }}>
                    {{ $shelter['shelter_name'] }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- DESCRIPCIÓN --}}
    <div class="col-12">
        <label for="description" class="form-label fw-bold small text-muted">DESCRIPCIÓN / DETALLES (OPCIONAL)</label>
        <textarea class="form-control form-control-lg rounded-3" name="description" rows="3">{{ old('description', $item['description'] ?? '') }}</textarea>
    </div>
</div>

<div class="mt-4 border-top pt-4">
    <button type="submit" class="btn-cta">{{ $buttonText }}</button>
    <a href="{{ route('admin.donation-items.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
</div>

<script>
function handleCategoryChange() {
    const category = document.getElementById('categorySelect').value;
    const iconPreview = document.getElementById('iconPreview');
    const icons = {
        'Alimento': 'bi-egg-fried', 'Medicina': 'bi-capsule', 'Juguetes': 'bi-joystick',
        'Mantas': 'bi-box-seam', 'Higiene': 'bi-droplet', 'Otro': 'bi-question-circle'
    };
    iconPreview.className = 'bi ' + (icons[category] || 'bi-box');
}
document.addEventListener("DOMContentLoaded", handleCategoryChange);
</script>