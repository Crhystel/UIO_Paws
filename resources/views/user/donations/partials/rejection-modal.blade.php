<div class="modal fade" id="donationReject-{{ $app['id_donation_application'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            {{-- HEADER: Gradiente Rojizo --}}
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #dc3545 0%, #6c757d 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-x-circle-fill"></i> Estado de la Donación</h2>
                    <p class="mb-0 opacity-75">Información sobre tu ofrecimiento #{{ $app['id_donation_application'] }}.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- COLUMNA IZQUIERDA --}}
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="mb-3 rounded-circle bg-white border border-4 border-secondary shadow d-flex align-items-center justify-content-center" style="width:120px; height:120px;">
                            <i class="bi bi-archive text-secondary fs-1"></i>
                        </div>
                        <h5 class="text-secondary fw-bold">No Aceptada</h5>
                        <p class="text-muted small">Gracias por tu intención.</p>
                    </div>

                    {{-- COLUMNA DERECHA --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3">¿Por qué no procedió?</h5>
                        <p class="text-muted small">
                            A veces debemos rechazar donaciones si tenemos exceso de stock de ciertos artículos, si están caducados o si no tenemos espacio de almacenamiento en este momento.
                        </p>
                        
                        <div class="card bg-danger bg-opacity-10 border-danger border-opacity-25 mt-3">
                            <div class="card-body">
                                <h6 class="card-title text-danger fw-bold small text-uppercase">
                                    <i class="bi bi-info-circle-fill me-1"></i> Motivo:
                                </h6>
                                <p class="card-text text-dark small mb-0">
                                    {{ $app['admin_notes'] ?? 'No se especificó un motivo detallado.' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <a href="{{ route('public.donations.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                                Ver lista de necesidades actuales
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>