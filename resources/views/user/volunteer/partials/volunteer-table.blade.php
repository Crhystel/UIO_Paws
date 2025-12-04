<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Detalle</th>
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
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center me-2 border border-info border-opacity-25" style="width:40px; height:40px;">
                                <i class="bi bi-person-heart"></i>
                            </div>
                            <div>
                                <span class="fw-bold text-dark">Solicitud de Voluntariado</span>
                                <small class="text-muted d-block fst-italic">"{{ Str::limit($app['motivation'], 40) }}"</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span @class(['badge rounded-pill', 'bg-success' => $isApproved, 'bg-danger'  => $isRejected, 'bg-warning text-dark' => !$isApproved && !$isRejected])>
                            {{ $statusName }}
                        </span>
                    </td>
                    <td class="text-end">
                        @if($isApproved)
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#volunteerCelebrationModal-{{ $app['id_volunteer_applications'] }}">
                                <i class="bi bi-check-circle-fill"></i> Ver Detalles
                            </button>
                        @elseif($isRejected)
                            <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-pill" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#volunteerRejectionModal-{{ $app['id_volunteer_application'] }}">
                                <i class="bi bi-exclamation-circle"></i> Ver Motivo
                            </button>
                        @else
                            @if(!empty($app['admin_notes']))
                                <button type="button" class="btn btn-sm btn-outline-secondary fw-bold rounded-pill" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#note-volunteer-{{ $app['id_volunteer_application'] }}">
                                    <i class="bi bi-chat-text"></i> Ver Notas
                                </button>
                            @else
                                <span class="text-muted small fst-italic">En revisión</span>
                            @endif
                        @endif
                    </td>
                </tr>

                @if(!empty($app['admin_notes']) && !$isApproved && !$isRejected)
                <tr class="collapse bg-light" id="note-volunteer-{{ $app['id_volunteer_application'] }}">
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
                        Aún no tienes solicitudes de voluntariado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@foreach($applications as $app)
    @php
        $statusName = $app['status']['status_name'] ?? '';
        $isApproved = in_array($statusName, ['Aprobada', 'Aprobado']);
        $isRejected = in_array($statusName, ['Rechazada', 'Rechazado']);
    @endphp

    @if($isApproved)
        @include('user.volunteer.partials.celebration-modal', ['app' => $app])
    @elseif($isRejected)
        @include('user.volunteer.partials.rejection-modal', ['app' => $app])
    @endif
@endforeach