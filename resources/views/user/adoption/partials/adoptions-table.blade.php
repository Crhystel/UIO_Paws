<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Animalito</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                @php
                    $statusName = $app['status']['status_name'] ?? 'Desconocido';
                    $isApproved = in_array($statusName, ['Aprobada', 'Aprobado']);
                    $isRejected = in_array($statusName, ['Rechazada', 'Rechazado']);
                    
                    $hasPhoto = !empty($app['animal']['photos'][0]['image_url']);
                    $photoUrl = $hasPhoto ? $apiUrl . '/storage/' . $app['animal']['photos'][0]['image_url'] : null;
                @endphp

                <tr>
                    {{-- FECHA --}}
                    <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                    
                    {{-- ANIMALITO --}}
                    <td class="fw-bold">
                        <div class="d-flex align-items-center">
                            @if($photoUrl)
                                <img src="{{ $photoUrl }}" class="rounded-circle me-2 object-fit-cover shadow-sm" width="40" height="40" alt="Foto" onerror="this.onerror=null; this.src='https://via.placeholder.com/40?text=Pet'">
                            @else
                                <div class="rounded-circle me-2 bg-light d-flex align-items-center justify-content-center text-muted border" style="width:40px; height:40px;"><i class="bi bi-paw"></i></div>
                            @endif
                            <span>{{ $app['animal']['animal_name'] }}</span>
                        </div>
                    </td>

                    {{-- ESTADO --}}
                    <td>
                        <span @class(['badge rounded-pill', 'bg-success' => $isApproved, 'bg-danger'  => $isRejected, 'bg-warning text-dark' => !$isApproved && !$isRejected])>
                            {{ $statusName }}
                        </span>
                    </td>

                    {{-- ACCIONES (Botones estandarizados) --}}
                    <td class="text-end">
                        @if($isApproved)
                            {{-- Botón APROBADO (Unificado) --}}
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#celebrationModal-{{ $app['id_adoption_application'] }}">
                                <i class="bi bi-check-circle-fill"></i> Ver Detalles
                            </button>
                        
                        @elseif($isRejected)
                            {{-- Botón RECHAZADO (Unificado) --}}
                            <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#rejectionModal-{{ $app['id_adoption_application'] }}">
                                <i class="bi bi-exclamation-circle"></i> Ver Motivo
                            </button>
                        
                        @else
                            {{-- Botón PENDIENTE CON NOTAS (Unificado) --}}
                            @if(!empty($app['admin_notes']))
                                <button type="button" class="btn btn-sm btn-outline-secondary fw-bold rounded-pill" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#note-adoption-{{ $app['id_adoption_application'] }}">
                                    <i class="bi bi-chat-text"></i> Ver Notas
                                </button>
                            @else
                                <span class="text-muted small fst-italic">En revisión</span>
                            @endif
                        @endif
                    </td>
                </tr>

                {{-- NOTA PENDIENTE (Collapse) --}}
                @if(!empty($app['admin_notes']) && !$isApproved && !$isRejected)
                    <tr class="collapse bg-light" id="note-adoption-{{ $app['id_adoption_application'] }}">
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
                    <td colspan="4" class="text-center py-5">
                        <h6 class="text-muted fw-bold">No tienes solicitudes activas</h6>
                        <a href="{{ route('public.animals.index') }}" class="btn btn-primary rounded-pill px-4 mt-2">Ver Animalitos</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- MODALES --}}
@foreach($applications as $app)
    @php
        $statusName = $app['status']['status_name'] ?? '';
        $isApproved = in_array($statusName, ['Aprobada', 'Aprobado']);
        $isRejected = in_array($statusName, ['Rechazada', 'Rechazado']);
        
        $hasPhoto = !empty($app['animal']['photos'][0]['image_url']);
        $photoUrl = $hasPhoto ? $apiUrl . '/storage/' . $app['animal']['photos'][0]['image_url'] : null;
    @endphp

    @if($isApproved)
        @include('user.adoption.partials.celebration-modal', ['app' => $app, 'photoUrl' => $photoUrl])
    @elseif($isRejected)
        @include('user.adoption.partials.rejection-modal', ['app' => $app, 'photoUrl' => $photoUrl])
    @endif
@endforeach