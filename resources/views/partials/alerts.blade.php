{{-- MENSAJE DE ÉXITO --}}
@if (session('success'))
    <div class="alert alert-paws alert-paws-success alert-dismissible fade show" role="alert">
        <!-- Icono Circular -->
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
             style="width: 45px; height: 45px; color: var(--color-verde-principal);">
            <i class="bi bi-check-lg fs-4"></i>
        </div>
        
        <!-- Texto -->
        <div class="flex-grow-1 py-1">
            <h6 class="fw-bold mb-1">¡Excelente!</h6>
            <p class="mb-0 small opacity-75">
                {{ session('success') }}
            </p>
        </div>
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- MENSAJE DE ERROR GENÉRICO --}}
@if (session('error'))
    <div class="alert alert-paws alert-paws-error alert-dismissible fade show" role="alert">
        <!-- Icono Circular -->
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
             style="width: 45px; height: 45px; color: #E53E3E;">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        </div>
        
        <!-- Texto -->
        <div class="flex-grow-1 py-1">
            <h6 class="fw-bold mb-1">Hubo un problema</h6>
            <p class="mb-0 small opacity-75">
                {{ session('error') }}
            </p>
        </div>
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- ERRORES DE VALIDACIÓN (FORMULARIOS) --}}
@if ($errors->any())
    <div class="alert alert-paws alert-paws-error alert-dismissible fade show" role="alert">
        <!-- Icono Circular -->
        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" 
             style="width: 45px; height: 45px; color: #E53E3E;">
            <i class="bi bi-x-octagon-fill fs-4"></i>
        </div>
        
        <!-- Texto -->
        <div class="flex-grow-1 py-1">
            <h6 class="fw-bold mb-1">¡Revisa los campos!</h6>
            <div class="small opacity-75">
                Por favor, corrige los errores marcados en el formulario.
                {{-- Opcional: Si quieres listar los errores aquí mismo, descomenta lo siguiente: --}}
                {{-- <ul class="mb-0 mt-1 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul> --}}
            </div>
        </div>
        
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif