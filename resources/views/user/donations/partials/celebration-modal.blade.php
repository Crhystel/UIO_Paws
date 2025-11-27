@php
    $totalItems = count($app['items']);
@endphp

<div class="modal fade" id="donationSuccess-{{ $app['id_donation_application'] }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-lg">
            {{-- HEADER: Gradiente Verde --}}
            <div class="modal-header text-white border-0 p-4" 
                 style="background: linear-gradient(135deg, #198754 0%, #20c997 100%);">
                <div>
                    <h2 class="modal-title h4 fw-bold"><i class="bi bi-box2-heart-fill"></i> ¡Donación Aceptada!</h2>
                    <p class="mb-0 opacity-75">Gracias por tu generosidad. Tu aporte hace la diferencia.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5 bg-light p-4 text-center d-flex flex-column justify-content-center align-items-center border-end">
                        <div class="position-relative mb-3">
                            {{-- Icono Grande --}}
                            <div class="rounded-circle bg-white border border-4 border-success shadow d-flex align-items-center justify-content-center" 
                                 style="width:140px; height:140px;">
                                <i class="bi bi-gift text-success" style="font-size: 4rem;"></i>
                            </div>
                            
                            {{-- Badge Flotante --}}
                            <span class="position-absolute bottom-0 start-50 translate-middle-x badge rounded-pill bg-success border border-white px-3 shadow-sm">
                                APROBADO
                            </span>
                        </div>
                        
                        <h5 class="text-success fw-bold mt-2">Donación #{{ $app['id_donation_application'] }}</h5>
                        <p class="text-muted small fst-italic">"Pequeñas acciones, grandes cambios."</p>
                        
                        {{-- TARJETA TIPO TICKET --}}
                        <div class="card bg-white border-warning mt-2 p-3 shadow-sm w-100 text-start">
                            <h6 class="text-uppercase text-warning fw-bold small mb-2 border-bottom pb-1">Comprobante Digital</h6>
                            <div class="d-flex justify-content-between small text-muted mb-1">
                                <span>Total Artículos:</span>
                                <span class="fw-bold text-dark">{{ $totalItems }}</span>
                            </div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Fecha Aprobación:</span>
                                <span class="fw-bold">{{ now()->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- COLUMNA DERECHA (TIMELINE / INSTRUCCIONES) --}}
                    <div class="col-md-7 p-4 bg-white">
                        <h5 class="mb-4 fw-bold text-dark">Pasos para la entrega</h5>
                        
                        <div class="timeline ms-2">
                            {{-- PASO 1 --}}
                            <div class="d-flex mb-4">
                                <div class="me-3">
                                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1 text-success">Confirmación Recibida</h6>
                                    <p class="text-muted small mb-0">Hemos validado que los artículos que ofreces son necesarios actualmente.</p>
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
                                    <h6 class="fw-bold mb-1 text-primary">Preparación y Entrega</h6>
                                    <p class="text-muted small mb-0">Por favor empaca los artículos y acércalos a nuestro centro de acopio. 
                                    <br><strong>Horario:</strong> Lun-Vie 9am - 5pm.</p>
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
                                    <h6 class="fw-bold mb-1 text-secondary">Recepción Final</h6>
                                    <p class="text-muted small mb-0">Indica tu número <strong>#{{ $app['id_donation_application'] }}</strong> en recepción.</p>
                                </div>
                            </div>
                        </div>

                        {{-- NOTAS DEL ADMIN --}}
                        @if(!empty($app['admin_notes']))
                            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 mt-4 mb-0 rounded-3">
                                <div class="d-flex">
                                    <i class="bi bi-chat-quote-fill text-warning me-2"></i>
                                    <div>
                                        <small class="fw-bold text-warning-emphasis">Nota del Refugio:</small>
                                        <p class="small mb-0 text-dark">{{ $app['admin_notes'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>