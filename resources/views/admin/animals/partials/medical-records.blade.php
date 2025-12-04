<div class="table-responsive mb-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Evento</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($animal['medical_records'] ?? [] as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record['event_date'])->format('d/m/Y') }}</td>
                    <td>{{ $record['event_type'] }}</td>
                    <td>{{ Str::limit($record['description'], 50) }}</td>
                    <td>
                        <form action="{{ route('admin.records.destroy', $record['id_medical_records']) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted">No hay registros médicos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<hr>
<h5 class="mt-4">Añadir Nuevo Registro Médico</h5>
<form action="{{ route('admin.animals.records.store', ['animal' => $animal['id_animal']]) }}" method="POST">
    @csrf
    <div class="row g-3">
        <div class="col-md-4"><input type="date" name="event_date" class="form-control rounded-pill" required></div>
        <div class="col-md-8"><input type="text" name="event_type" class="form-control rounded-pill" placeholder="Tipo de evento" required></div>
        <div class="col-12"><textarea name="description" class="form-control rounded-3" placeholder="Descripción detallada..." required></textarea></div>
    </div>
    <button type="submit" class="btn btn-primary rounded-pill mt-3">Añadir Registro</button>
</form>