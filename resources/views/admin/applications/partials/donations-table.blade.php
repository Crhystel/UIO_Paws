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
            {{-- ID --}}
            <td class="ps-4 fw-bold text-muted">#{{ $app['id_donation_application'] }}</td>
            
            {{-- DONANTE --}}
            <td>
                <div class="d-flex align-items-center">
                    {{-- LOGICA FOTO USUARIO --}}
                    @php
                        $backendUrl = str_replace('/api', '', env('API_URL', 'http://127.0.0.1:8001'));
                        $userPhotoPath = $app['user']['profile_photo_path'] ?? null;
                        $userPhotoUrl = $userPhotoPath 
                            ? $backendUrl . '/storage/' . $userPhotoPath 
                            : 'https://ui-avatars.com/api/?name='.urlencode($app['user']['first_name'].'+'.$app['user']['last_name']).'&background=D8F3DC&color=1B4332&size=100';
                    @endphp

                    <img src="{{ $userPhotoUrl }}" 
                        class="rounded-circle me-2 object-fit-cover border border-1 border-warning" 
                        style="width: 35px; height: 35px;"
                        alt="User"
                        onerror="this.src='https://ui-avatars.com/api/?name=User&background=random'">

                    <div>
                        <div class="fw-bold">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                        <small class="text-muted" style="font-size: 0.8rem;">{{ $app['user']['email'] ?? '' }}</small>
                    </div>
                </div>
            </td>

            {{-- FECHA --}}
            <td>
                <span class="text-muted">
                    <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}
                </span>
            </td>

            {{-- ESTADO --}}
            <td>
                <span class="badge rounded-pill px-3 py-2
                    @php $status = $app['status']['status_name'] ?? ''; @endphp
                    @if($status == 'Aprobado' || $status == 'Aprobada') bg-success 
                    @elseif($status == 'Rechazado' || $status == 'Rechazada') bg-danger 
                    @else bg-warning text-dark @endif">
                    {{ $status }}
                </span>
            </td>

            {{-- ACCIONES --}}
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