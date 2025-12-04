<table class="table table-hover table-custom align-middle">
    <thead>
        <tr>
            <th scope="col" class="ps-4">Fecha</th>
            <th scope="col">Postulante</th>
            <th scope="col">Puesto / Interés</th>
            <th scope="col">Estado</th>
            <th scope="col" class="text-end pe-4">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($applications as $app)
        <tr>
            {{-- Fecha --}}
            <td class="ps-4">
                <span class="text-muted fw-bold">
                    {{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}
                </span>
            </td>
            
            {{-- Postulante --}}
            <td>
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-2" style="width: 35px; height: 35px; background-color: #E3F2FD; color: #1976D2;">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                        <small class="text-muted" style="font-size: 0.8rem;">{{ $app['user']['email'] ?? '' }}</small>
                    </div>
                </div>
            </td>

            {{-- Puesto (Conexión con Oportunidad) --}}
            <td>
                @if(isset($app['opportunity']))
                    <span class="badge rounded-pill bg-light text-dark border border-secondary">
                        <i class="bi bi-briefcase me-1"></i> {{ $app['opportunity']['title'] }}
                    </span>
                @else
                    <span class="badge rounded-pill bg-light text-muted border border-light">
                        Voluntariado General
                    </span>
                @endif
            </td>

            {{-- Estado --}}
            <td>
                <span class="badge rounded-pill px-3 py-2 
                    @if($app['status']['status_name'] == 'Aprobado') bg-success 
                    @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                    @elseif($app['status']['status_name'] == 'Pendiente') bg-warning text-dark
                    @else bg-secondary @endif">
                    {{ $app['status']['status_name'] }}
                </span>
            </td>

            {{-- Botón Revisar --}}
            <td class="text-end pe-4">
                <a href="{{ route('admin.applications.volunteer.show', $app['id_volunteer_applications']) }}" 
                   class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3">
                    Revisar <i class="bi bi-arrow-right-short"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-5">
                <div class="d-flex flex-column align-items-center opacity-50">
                    <i class="bi bi-clipboard-check fs-1 mb-2"></i>
                    <p class="mb-0">No hay postulaciones pendientes.</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>