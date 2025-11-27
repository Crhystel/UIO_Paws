<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Notas del Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge 
                            @if($app['status']['status_name'] == 'Aprobado') bg-success 
                            @elseif($app['status']['status_name'] == 'Rechazado') bg-danger
                            @else bg-warning text-dark @endif">
                            {{ $app['status']['status_name'] }}
                        </span>
                    </td>
                    <td>
                        @if(!empty($app['admin_notes']))
                            <span class="text-muted fst-italic">{{ $app['admin_notes'] }}</span>
                        @else
                            <span class="text-muted small">Sin notas adicionales</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4">
                        <div class="text-muted mb-2">No tienes solicitudes de donación registradas.</div>
                        <a href="{{ route('user.donations.create') }}" class="btn btn-sm btn-success">Hacer una Donación</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>