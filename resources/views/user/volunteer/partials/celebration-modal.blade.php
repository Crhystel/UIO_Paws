<div class="modal fade" id="volunteerCelebrationModal-{{ $app['id_volunteer_applications'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-balloon-heart-fill"></i> ¡Bienvenido/a al equipo!</h2>
                    <p class="mb-0 opacity-75">Tu solicitud para ser voluntario/a ha sido aprobada.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- COLUMNA IZQUIERDA (VISUAL) --}}
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="rounded-circle border border-4 border-success shadow-sm d-flex align-items-center justify-content-center mb-3" 
                             style="width:150px; height:150px; background-color: white;">
                            <i class="bi bi-person-heart text-success" style="font-size: 5rem;"></i>
                        </div>
                        
                        <h4 class="text-success fw-bold">¡Gracias por unirte!</h4>
                        <p class="text-muted small fst-italic">"Tu ayuda y tu tiempo son el regalo más grande para nuestros peludos."</p>
                        
                        {{-- Certificado simbólico --}}
                        <div class="card bg-white border-warning mt-3 p-3 shadow-sm w-100 text-start">
                            <h6 class="text-uppercase text-warning fw-bold small mb-2 border-bottom pb-1">Credencial de Voluntario</h6>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Folio:</span>
                                <span class="fw-bold font-monospace">#VOL-{{ $app['id_volunteer_applications'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Fecha:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($app['updated_at'] ?? now())->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA (PASOS A SEGUIR) --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="mb-4 fw-bold text-dark">¿Qué sigue ahora?</h5>
                        
                        <div class="timeline ms-2">
                            <div class="d-flex mb-4">
                                <div class="me-3"><div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;"><i class="bi bi-check-lg"></i></div></div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-success">Solicitud Aprobada</h6>
                                    <p class="text-muted small mb-0">Hemos revisado tu perfil y nos encanta tu motivación para ayudar.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-4">
                                <div class="me-3"><div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">2</div></div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-primary">Coordinación</h6>
                                    <p class="text-muted small mb-0">En las próximas 24-48 horas, un encargado del refugio se pondrá en contacto contigo para coordinar tu horario y la fecha de inicio.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-1">
                                <div class="me-3"><div class="bg-light text-secondary border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">3</div></div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-secondary">¡A la acción!</h6>
                                    <p class="text-muted small mb-0">Prepárate para conocer a nuestros peludos y marcar una gran diferencia en sus vidas.</p>
                                </div>
                            </div>
                        </div>

                        @if(!empty($app['admin_notes']))
                            <div class="alert alert-info border-0 bg-info bg-opacity-10 mt-4 mb-0 rounded-3">
                                <div class="d-flex">
                                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                                    <div>
                                        <small class="fw-bold text-info-emphasis">Nota del Refugio:</small>
                                        <p class="small mb-0 text-dark">{{ $app['admin_notes'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 justify-content-center py-3">
                <p class="small text-muted mb-0">¡Estamos muy emocionados de tenerte a bordo!</p>
            </div>
        </div>
    </div>
</div>