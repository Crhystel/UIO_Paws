<div class="modal fade" id="celebrationModal-{{ $app['id_adoption_application'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            {{-- HEADER: Gradiente Verde Bonito --}}
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-balloon-heart-fill"></i> ¡Felicidades, es un Match!</h2>
                    <p class="mb-0 opacity-75">Tu solicitud para adoptar a {{ $app['animal']['animal_name'] }} ha sido aprobada.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- COLUMNA IZQUIERDA (FOTO Y CERTIFICADO) --}}
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="position-relative mb-3">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" 
                                     class="rounded-circle border border-4 border-success shadow" 
                                     width="150" height="150" 
                                     style="object-fit:cover;"
                                     alt="{{ $app['animal']['animal_name'] }}"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=Sin+Foto'">
                            @else
                                <div class="rounded-circle bg-white border border-4 border-success shadow d-flex align-items-center justify-content-center" 
                                     style="width:150px; height:150px;">
                                    <i class="bi bi-heart-fill text-danger fs-1"></i>
                                </div>
                            @endif
                            
                            {{-- Badge Flotante --}}
                            <span class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-success border border-white px-3 shadow-sm">
                                ¡SOMOS FAMILIA!
                            </span>
                        </div>
                        
                        <h4 class="text-success fw-bold">{{ $app['animal']['animal_name'] }}</h4>
                        <p class="text-muted small fst-italic">"Gracias por darme una segunda oportunidad. Prometo llenarte de amor y pelitos."</p>
                        
                        {{-- CERTIFICADO (DISEÑO RECUPERADO) --}}
                        <div class="card bg-white border-warning mt-3 p-3 shadow-sm w-100 text-start">
                            <h6 class="text-uppercase text-warning fw-bold small mb-2 border-bottom pb-1">Certificado de Pre-Adopción</h6>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Folio:</span>
                                <span class="fw-bold font-monospace">#ADP-{{ $app['id_adoption_application'] }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Fecha:</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($app['updated_at'] ?? now())->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA (TIMELINE Y PASOS) --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="mb-4 fw-bold text-dark">¿Qué sigue ahora?</h5>
                        
                        {{-- TIMELINE RECUPERADA --}}
                        <div class="timeline ms-2">
                            {{-- PASO 1 --}}
                            <div class="d-flex mb-4">
                                <div class="me-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-success">Solicitud Aprobada</h6>
                                    <p class="text-muted small mb-0">Nuestro equipo ha revisado tu perfil y creemos que eres el hogar ideal.</p>
                                </div>
                            </div>

                            {{-- PASO 2 --}}
                            <div class="d-flex mb-4">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        2
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-primary">Coordinar Bienvenida</h6>
                                    <p class="text-muted small mb-0">En las próximas 24-48 horas, un coordinador te llamará para ultimar detalles sobre la llegada de {{ $app['animal']['animal_name'] }} a casa.</p>
                                </div>
                            </div>

                            {{-- PASO 3 --}}
                            <div class="d-flex mb-1">
                                <div class="me-3">
                                    <div class="bg-light text-secondary border rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        3
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-secondary">Firma y Reencuentro</h6>
                                    <p class="text-muted small mb-0">Firmaremos el acuerdo de adopción y podrás comenzar tu nueva vida junto a {{ $app['animal']['animal_name'] }}.</p>
                                </div>
                            </div>
                        </div>

                        {{-- NOTAS DEL ADMIN --}}
                        @if(!empty($app['admin_notes']))
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mt-4 mb-0 rounded-3">
                                <div class="d-flex">
                                    <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                                    <div>
                                        <small class="fw-bold text-warning-emphasis">Nota Importante del Refugio:</small>
                                        <p class="small mb-0 text-dark">{{ $app['admin_notes'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 justify-content-center py-3">
                <p class="small text-muted mb-0">¿Tienes dudas urgentes? Contáctanos al <span class="fw-bold text-dark">099-123-4567</span></p>
            </div>
        </div>
    </div>
</div>