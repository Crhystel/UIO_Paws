<div class="table-responsive">
    {{-- Tabla con botones de acción --}}
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Resumen de Donación</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
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
                    
                    {{-- 2. RESUMEN --}}
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2 border border-primary border-opacity-25" style="width:40px; height:40px;">
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

                    {{-- 3. ESTADO --}}
                    <td>
                         <span @class(['badge rounded-pill', 'bg-success' => $isApproved, 'bg-danger'  => $isRejected, 'bg-warning text-dark' => !$isApproved && !$isRejected])>
                            {{ $statusName }}
                         </span>
                    </td>

                    {{-- 4. ACCIONES --}}
                    <td class="text-end">
                        @if($isApproved)
                            {{-- Botón APROBADO --}}
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#donationSuccess-{{ $app['id_donation_application'] }}">
                                <i class="bi bi-check-circle-fill"></i> Ver Detalles
                            </button>
                        
                        @elseif($isRejected)
                            {{-- Botón RECHAZADO --}}
                            <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#donationReject-{{ $app['id_donation_application'] }}">
                                <i class="bi bi-exclamation-circle"></i> Ver Motivo
                            </button>
                        
                        @else
                             {{-- Botón PENDIENTE CON NOTAS --}}
                            @if(!empty($app['admin_notes']))
                                <button type="button" class="btn btn-sm btn-outline-secondary fw-bold rounded-pill" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#note-donation-{{ $app['id_donation_application'] }}">
                                    <i class="bi bi-chat-text"></i> Ver Notas
                                </button>
                            @else
                                <span class="text-muted small fst-italic">En revisión</span>
                            @endif
                        @endif
                        
                        {{-- OJO: AQUÍ ELIMINÉ LOS INCLUDES QUE ESTABAN DENTRO DEL TD --}}
                    </td> 
                </tr>

                @if(!empty($app['admin_notes']) && !$isApproved && !$isRejected)
                    <tr class="collapse bg-light" id="note-donation-{{ $app['id_donation_application'] }}">
                        <td colspan="4" class="p-3 border-top-0">
                             <div class="d-flex align-items-start">
                                <i class="bi bi-info-circle-fill text-primary me-2 mt-1"></i>
                                <div><small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Mensaje del Refugio:</small>
                                <p class="mb-0 text-dark">{{ $app['admin_notes'] }}</p></div>
                            </div>
                        </td>
                    </tr>
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

{{-- MODALES --}}
@push('modals')
    @foreach($applications as $app)
        @php
            $statusName = $app['status']['status_name'] ?? '';
            $isApproved = in_array($statusName, ['Aprobada', 'Aprobado']);
            $isRejected = in_array($statusName, ['Rechazada', 'Rechazado']);
        @endphp

        @if($isApproved)
            @include('user.donations.partials.celebration-modal', ['app' => $app])
        @elseif($isRejected)
            @include('user.donations.partials.rejection-modal', ['app' => $app])
        @endif
    @endforeach
@endpush