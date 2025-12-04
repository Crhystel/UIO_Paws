<table class="table table-hover table-custom align-middle">
    <thead>
        <tr>
            <th scope="col" class="ps-4">ID</th>
            <th scope="col">Donante</th>
            <th scope="col">Fecha</th>
            <th scope="col">Estado</th>
            <th scope="col" class="text-end pe-4">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($applications as $app)
        <tr>
            <td class="ps-4 fw-bold text-muted">#{{ $app['id_donation_application'] }}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="d-flex justify-content-center align-items-center rounded-circle me-2" style="width: 35px; height: 35px; background-color: #FFF3E0; color: #F57F17;">
                        <i class="bi bi-heart-fill"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                        <small class="text-muted" style="font-size: 0.8rem;">{{ $app['user']['email'] ?? '' }}</small>
                    </div>
                </div>
            </td>
            <td>
                <span class="text-muted">
                    <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}
                </span>
            </td>
            <td>
                <span class="badge rounded-pill px-3 py-2
                    @if($app['status']['status_name'] == 'Aprobado') bg-success 
                    @elseif($app['status']['status_name'] == 'Rechazado') bg-danger 
                    @else bg-warning text-dark @endif">
                    {{ $app['status']['status_name'] }}
                </span>
            </td>
            <td class="text-end pe-4">
                <a href="{{ route('admin.applications.donation.show', $app['id_donation_application']) }}" 
                   class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3">
                   Revisar <i class="bi bi-arrow-right-short"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-5">
                <div class="d-flex flex-column align-items-center opacity-50">
                    <i class="bi bi-inbox fs-1 mb-2"></i>
                    <p class="mb-0">No hay solicitudes de donación registradas.</p>
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>