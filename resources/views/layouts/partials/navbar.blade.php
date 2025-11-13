<nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">🐾 UIO Paws</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.animals.index') ? 'active fw-bold' : '' }}" href="{{ route('public.animals.index') }}">Ver Animales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.donations.index') ? 'active fw-bold' : '' }}" href="{{ route('public.donations.index') }}">Qué Donar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.volunteer.index') ? 'active fw-bold' : '' }}" href="{{ route('public.volunteer.index') }}">Sé Voluntario</a>
                </li>
                @if(Session::has('api_token'))
                    {{-- Si el usuario está logueado --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            ¡Hola, {{ Session::get('user_name', 'Usuario') }}!
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Mi Panel</a></li>
                            
                            @if(in_array(Session::get('user_role'), ['Admin', 'Super Admin']))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                            @endif
                             
                            @if(Session::get('user_role') === 'Super Admin')
                                <li><a class="dropdown-item" href="{{ route('superadmin.dashboard') }}">Panel Super Admin</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Si el usuario es un invitado --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('register.form') }}">Registrarse</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>