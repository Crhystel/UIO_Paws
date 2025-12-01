<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Postulante</th>
                <th>Puesto / Interés</th>
                <th>Estado</th>
                <th class="text-end">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                {{-- Fecha --}}
                <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                
                {{-- Postulante --}}
                <td>
                    <div class="fw-bold">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                    <small class="text-muted">{{ $app['user']['email'] }}</small>
                </td>

                {{-- Puesto (Conexión con Oportunidad) --}}
                <td>
                    @if(isset($app['opportunity']))
                        <span class="badge bg-info text-dark">{{ $app['opportunity']['title'] }}</span>
                    @else
                        <span class="text-muted fst-italic small">Voluntariado General</span>
                    @endif
                </td>

                {{-- Estado --}}
                <td>
                    <span class="badge rounded-pill 
                        @if($app['status']['status_name'] == 'Aprobado') bg-success 
                        @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                        @elseif($app['status']['status_name'] == 'Pendiente') bg-warning text-dark
                        @else bg-secondary @endif">
                        {{ $app['status']['status_name'] }}
                    </span>
                </td>

                {{-- Botón Revisar --}}
                <td class="text-end">
                    <a href="{{ route('admin.applications.volunteer.show', $app['id_volunteer_applications']) }}" class="btn btn-sm btn-outline-primary">
                        Revisar
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    No hay solicitudes de voluntariado pendientes.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>