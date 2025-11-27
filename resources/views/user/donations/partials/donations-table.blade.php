<div class="table-responsive">
    {{-- Tabla con diseño idéntico a Adopciones --}}
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Resumen de Donación</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th> {{-- Aquí es donde cambiamos Notas por Acciones --}}
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                @php
                    $statusName = $app['status']['status_name'] ?? '';
                    $isApproved = in_array($statusName, ['Aprobada', 'Aprobado']);
                    $isRejected = in_array($statusName, ['Rechazada', 'Rechazado']);
                    $itemsList = $app['items'] ?? []; 
                    $totalItems = count($itemsList);
                    $firstItemName = $itemsList[0]['item_name'] ?? 'Artículos varios';
                @endphp

                <tr>
                    {{-- 1. FECHA --}}
                    <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                    
                    {{-- 2. RESUMEN (Icono + Nombre) - Estilo igual a la foto del animal --}}
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- Icono de regalo en lugar de foto de animal --}}
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2 border border-primary border-opacity-25" 
                                 style="width:40px; height:40px;">
                                <i class="bi bi-gift-fill"></i>
                            </div>
                            <div>
                                <span class="fw-bold text-dark">{{ $firstItemName }}</span>
                                @if($totalItems > 1)
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">+ {{ $totalItems - 1 }} otros artículos</small>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- 3. ESTADO (Badges) --}}
                    <td>
                         <span @class([
                            'badge rounded-pill',
                            'bg-success' => $isApproved,
                            'bg-danger'  => $isRejected,
                            'bg-warning text-dark' => !$isApproved && !$isRejected
                        ])>
                            {{ $statusName }}
                        </span>
                    </td>

                    {{-- 4. ACCIONES (Botones que abren los modales) --}}
                    <td class="text-end">
                        @if($isApproved)
                            {{-- Botón ÉXITO (Verde) --}}
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold shadow-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#donationSuccess-{{ $app['id_donation_application'] }}">
                                <i class="bi bi-check-circle-fill"></i> Instrucciones
                            </button>
                        
                        @elseif($isRejected)
                            {{-- Botón RECHAZO (Rojo) --}}
                            <button type="button" class="btn btn-sm btn-outline-danger fw-bold shadow-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#donationReject-{{ $app['id_donation_application'] }}">
                                <i class="bi bi-info-circle"></i> Ver motivo
                            </button>
                        
                        @else
                            {{-- Estado PENDIENTE --}}
                            <span class="text-muted small fst-italic me-2">En revisión</span>
                        @endif
                    </td>
                </tr>

                {{-- INCLUIR LOS MODALES CORRESPONDIENTES --}}
                {{-- Esto carga el código de los modales ocultos que se activan con los botones --}}
                @if($isApproved)
                    @include('user.donations.partials.celebration-modal', ['app' => $app])
                @elseif($isRejected)
                    @include('user.donations.partials.rejection-modal', ['app' => $app])
                @endif

            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <div class="mb-2"><i class="bi bi-inbox fs-2 opacity-25"></i></div>
                        Aún no has realizado donaciones.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>