<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Adoptante</th>
            <th>Animal</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($applications as $app)
        <tr>
            <td>{{ $app['id_adoption_application'] }}</td>
            <td>{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</td>
            <td>{{ $app['animal']['animal_name'] ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}</td>
            <td><span class="badge bg-info text-dark">{{ $app['status']['status_name'] }}</span></td>
            <td>
                <a href="{{ route('admin.applications.adoption.show', $app['id_adoption_application']) }}" class="btn btn-sm btn-primary">Revisar</a>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No hay solicitudes de adopción.</td></tr>
        @endforelse
    </tbody>
</table>