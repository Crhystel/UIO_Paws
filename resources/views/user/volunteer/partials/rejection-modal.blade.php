<div class="modal fade" id="volunteerRejectionModal-{{ $app['id_volunteer_applications'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #dc3545 0%, #6c757d 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-clipboard-x-fill"></i> Actualización de Solicitud</h2>
                    <p class="mb-0 opacity-75">Información sobre tu proceso de voluntariado.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- COLUMNA IZQUIERDA (VISUAL) --}}
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="rounded-circle border border-4 border-secondary shadow-sm d-flex align-items-center justify-content-center mb-3" 
                             style="width:120px; height:120px; background-color: white;">
                            <i class="bi bi-person-fill-slash text-secondary" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-secondary fw-bold">Solicitud en Pausa</h5>
                        <span class="badge bg-secondary">No Aprobada</span>
                    </div>

                    {{-- COLUMNA DERECHA (RAZONES) --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="fw-bold text-dark mb-3">Estado: No aprobado</h5>
                        <p class="text-muted small">
                            Agradecemos enormemente tu tiempo e interés en unirte a nuestro equipo. Lamentablemente, en esta ocasión no podemos proceder con tu solicitud.
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
                                        <em>Generalmente esto se debe a que las posiciones de voluntariado disponibles ya han sido cubiertas.</em>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <p class="small text-muted mb-2">¡No te desanimes! Tu deseo de ayudar es muy valioso. Hay otras formas de colaborar:</p>
                            <a href="{{ route('public.donations.index') }}" class="btn btn-outline-dark btn-sm rounded-pill w-100">
                               <i class="bi bi-box2-heart-fill"></i> Ver necesidades de donación
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>