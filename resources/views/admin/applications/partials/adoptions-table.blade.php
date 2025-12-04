{{-- resources/views/admin/applications/partials/adoptions-table.blade.php --}}

<table class="table table-hover table-custom align-middle">
    <thead>
        <tr>
            <th scope="col" class="ps-4">ID</th>
            <th scope="col">Adoptante</th>
            <th scope="col">Animal</th>
            <th scope="col">Fecha</th>
            <th scope="col">Estado</th>
            <th scope="col" class="text-end pe-4">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($applications as $app)
            @php
                $backendUrl = str_replace('/api', '', env('API_URL', 'http://127.0.0.1:8001'));
                $animalPhotoPath = $app['animal']['photos'][0]['image_url'] ?? null;
                $animalPhotoUrl = $animalPhotoPath 
                    ? $backendUrl . '/storage/' . $animalPhotoPath 
                    : null;

                $statusName = $app['status']['status_name'] ?? 'Desconocido';
            @endphp

            <tr>
                {{-- ID --}}
                <td class="ps-4 fw-bold text-muted">#{{ $app['id_adoption_application'] }}</td>
                
                {{-- COLUMNA ADOPTANTE --}}
                <td>
                    <div class="d-flex align-items-center">
                        @php
                            $userPhotoPath = $app['user']['profile_photo_path'] ?? null;
                            $userPhotoUrl = $userPhotoPath 
                                ? $backendUrl . '/storage/' . $userPhotoPath 
                                : 'https://ui-avatars.com/api/?name='.urlencode($app['user']['first_name'].'+'.$app['user']['last_name']).'&background=D8F3DC&color=1B4332&size=100';
                        @endphp

                        <img src="{{ $userPhotoUrl }}" 
                            class="rounded-circle me-2 object-fit-cover border border-1 border-success" 
                            style="width: 40px; height: 40px;"
                            alt="User"
                            onerror="this.src='https://ui-avatars.com/api/?name=User&background=random'">

                        <div>
                            <div class="fw-bold text-dark">{{ $app['user']['first_name'] }} {{ $app['user']['last_name'] }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $app['user']['email'] ?? '' }}</small>
                        </div>
                    </div>
                </td>

                {{-- COLUMNA ANIMAL --}}
                <td>
                    <div class="d-flex align-items-center">
                        {{-- Foto o Placeholder --}}
                        <div class="me-3 flex-shrink-0">
                            @if($animalPhotoUrl)
                                {{-- USAMOS LA URL CORREGIDA AQUÍ --}}
                                <img src="{{ $animalPhotoUrl }}" 
                                    alt="{{ $app['animal']['animal_name'] }}" 
                                    class="rounded-circle shadow-sm border border-2 border-white object-fit-cover"
                                    style="width: 45px; height: 45px;"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/45?text=Pet'">
                            @else
                                <div class="d-flex justify-content-center align-items-center rounded-circle shadow-sm border border-2 border-white" 
                                    style="width: 45px; height: 45px; background-color: #FFF3E0; color: #FB8C00;">
                                    <i class="bi bi-paw-fill fs-5"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Nombre y Raza --}}
                        <div>
                            <span class="fw-bold d-block" style="color: var(--color-verde-oscuro);">
                                {{ $app['animal']['animal_name'] ?? 'Sin Nombre' }}
                            </span>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ $app['animal']['breed']['breed_name'] ?? 'Raza desconocida' }}
                            </small>
                        </div>
                    </div>
                </td>

                {{-- FECHA --}}
                <td>
                    <span class="text-muted fw-medium">
                        <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::parse($app['application_date'])->format('d/m/Y') }}
                    </span>
                </td>
                
                {{-- ESTADO --}}
                <td>
                    <span class="badge rounded-pill px-3 py-2 
                        @if(in_array($statusName, ['Aprobada', 'Aprobado'])) bg-success 
                        @elseif(in_array($statusName, ['Rechazada', 'Rechazado'])) bg-danger 
                        @else bg-warning text-dark @endif">
                        {{ $statusName }}
                    </span>
                </td>
                
                {{-- ACCIONES --}}
                <td class="text-end pe-4">
                    <a href="{{ route('admin.applications.adoption.show', $app['id_adoption_application']) }}" 
                    class="btn btn-sm btn-outline-success rounded-pill fw-bold px-3 transition-hover">
                    Revisar <i class="bi bi-arrow-right-short"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center py-5">
                    <div class="d-flex flex-column align-items-center opacity-50">
                        <i class="bi bi-folder2-open fs-1 mb-2"></i>
                        <p class="mb-0">No hay solicitudes de adopción pendientes.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>