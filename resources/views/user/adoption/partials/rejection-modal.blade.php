<div class="modal fade" id="rejectionModal-{{ $app['id_adoption_application'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            {{-- HEADER: Gradiente Rojizo --}}
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #dc3545 0%, #6c757d 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-heartbreak-fill"></i> Actualización de Solicitud</h2>
                    <p class="mb-0 opacity-75">Información sobre tu proceso con {{ $app['animal']['animal_name'] }}.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- COLUMNA IZQUIERDA --}}
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="mb-3">
                            @if($photoUrl)
                                {{-- Filtro grayscale para dar tono serio --}}
                                <img src="{{ $photoUrl }}" class="rounded-circle border border-4 border-secondary shadow-sm" width="120" height="120" style="object-fit:cover; filter: grayscale(100%);" onerror="this.onerror=null; this.src='https://via.placeholder.com/120?text=Sin+Foto'">
                            @else
                                <div class="rounded-circle bg-white border border-4 border-secondary shadow d-flex align-items-center justify-content-center" style="width:120px; height:120px;"><i class="bi bi-paw text-secondary fs-1"></i></div>
                            @endif
                        </div>
                        <h5 class="text-secondary fw-bold">{{ $app['animal']['animal_name'] }}</h5>
                        <span class="badge bg-secondary">No Asignado</span>
                    </div>

                    {{-- COLUMNA DERECHA (RAZONES) --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3">Estado: No aprobado</h5>
                        <p class="text-muted small">
                            Agradecemos mucho tu interés en adoptar. Lamentablemente, en esta ocasión no hemos podido proceder con tu solicitud para este animalito específico.
                        </p>
                        
                        <div class="card bg-danger bg-opacity-10 border-danger border-opacity-25 mt-3">
                            <div class="card-body">
                                <h6 class="card-title text-danger fw-bold small text-uppercase">
                                    <i class="bi bi-info-circle-fill me-1"></i> Motivo / Observaciones:
                                </h6>
                                <p class="card-text text-dark small mb-0">
                                    @if(!empty($app['admin_notes']))
                                        "{{ $app['admin_notes'] }}"
                                    @else
                                        <em>El refugio no ha especificado un motivo detallado, pero usualmente se debe a incompatibilidad con las necesidades específicas de este peludito.</em>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <p class="small text-muted mb-2">¡No te desanimes!</p>
                            <a href="{{ route('public.animals.index') }}" class="btn btn-outline-dark btn-sm rounded-pill w-100">
                                Ver otros animalitos disponibles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>