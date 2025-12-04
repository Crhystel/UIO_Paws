<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    .navbar-custom {
        --nav-green-primary: #74C69D; 
        --nav-text-dark: #1B4332; 
        --nav-green-light: #D8F3DC; 
        --nav-accent: #40916C;

        font-family: 'Poppins', sans-serif;
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(82, 183, 136, 0.15);
        padding: 15px 0;
        border-bottom: 3px solid var(--nav-green-light);
        z-index: 1030; 
    }

    /* Logo */
    .brand-text {
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--nav-text-dark);
        letter-spacing: -0.5px;
    }
    .brand-icon {
        color: var(--nav-green-primary);
        font-size: 1.8rem;
    }

    /* Enlaces del menú */
    .navbar-nav .nav-link {
        color: var(--nav-text-dark);
        font-weight: 600;
        padding: 8px 18px !important;
        border-radius: 20px;
        transition: all 0.3s ease;
        margin: 0 4px;
    }

    /* Hover en enlaces */
    .navbar-nav .nav-link:hover {
        color: var(--nav-accent);
        background-color: var(--nav-green-light);
        transform: translateY(-2px);
    }

    /* Enlace Activo */
    .navbar-nav .nav-link.active {
        color: #0d2e20 !important;
        background-color: var(--nav-green-light);
        box-shadow: inset 0 0 0 1px var(--nav-green-primary);
    }

    /* Botón Registrarse */
    .btn-nav-register {
        background: linear-gradient(135deg, var(--nav-green-primary), var(--nav-accent));
        color: white !important;
        border-radius: 50px;
        padding: 10px 28px !important;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(116, 198, 157, 0.4);
        border: none;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .btn-nav-register:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 20px rgba(116, 198, 157, 0.6);
        filter: brightness(1.05);
    }

    /* Botón Login */
    .btn-nav-login {
        color: var(--nav-text-dark) !important;
        font-weight: 700;
        border-radius: 50px;
        padding: 8px 20px !important;
    }
    
    .btn-nav-login:hover {
        color: var(--nav-green-primary) !important;
        background-color: transparent;
        text-decoration: underline;
    }

    /* Dropdown de usuario */
    .dropdown-menu {
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(27, 67, 50, 0.1);
        padding: 10px;
        margin-top: 15px;
        border-top: 4px solid var(--nav-green-primary);
    }
    
    .dropdown-item {
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 500;
        color: var(--nav-text-dark);
    }
    
    .dropdown-item:hover {
        background-color: var(--nav-green-light);
        color: var(--nav-accent);
    }

    /* Toggler para móvil */
    .navbar-toggler {
        border: none;
        background-color: var(--nav-green-light);
        border-radius: 12px;
        padding: 8px 12px;
    }
    .navbar-toggler-icon {
        filter: invert(21%) sepia(16%) saturate(1459%) hue-rotate(107deg) brightness(96%) contrast(92%);
    }
</style>

<nav class="navbar navbar-expand-lg sticky-top navbar-custom">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <span class="brand-icon">🐾</span>
            <span class="brand-text">UIO <span style="color: var(--nav-green-primary);">Paws</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.animals.index') ? 'active' : '' }}" href="{{ route('public.animals.index') }}">
                        Ver Animales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.donations.index') ? 'active' : '' }}" href="{{ route('public.donations.index') }}">
                        Qué Donar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.volunteer.index') ? 'active' : '' }}" href="{{ route('public.volunteer.index') }}">
                        Sé Voluntario
                    </a>
                </li>

                <li class="nav-item d-none d-lg-block mx-2" style="color: var(--nav-green-light);">|</li>

                @if(Session::has('api_token'))
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            
                            @php
                                $userPhotoPath = Session::get('user_photo'); 
                                $userName = Session::get('user_name', 'Usuario');
                                $fallbackPhoto = 'https://ui-avatars.com/api/?name='.urlencode($userName).'&background=74C69D&color=fff&size=128';
                                $displayPhoto = $userPhotoPath ? $userPhotoPath : $fallbackPhoto;
                            @endphp

                            {{-- FOTO DE PERFIL --}}
                            <img src="{{ $displayPhoto }}" 
                                 alt="Perfil" 
                                 class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" 
                                 width="40" height="40">

                            <span class="fw-bold">{{ explode(' ', $userName)[0] }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end slide-in" aria-labelledby="navbarDropdown">
                            <li class="px-3 py-2 text-muted small text-uppercase fw-bold" style="font-size: 0.7rem;">Mi Cuenta</li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-grid-fill me-2" style="color: var(--nav-green-primary);"></i> Mi Panel
                                </a>
                            </li>
                            
                            @if(in_array(Session::get('user_role'), ['Admin', 'Super Admin']))
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock-fill me-2 text-danger"></i> Panel Admin
                                    </a>
                                </li>
                            @endif
                             
                            @if(Session::get('user_role') === 'Super Admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('superadmin.dashboard') }}">
                                        <i class="bi bi-stars me-2 text-warning"></i> Super Admin
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider opacity-10"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item fw-bold" style="color: #e63946;">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item mt-3 mt-lg-0">
                        <a class="nav-link btn-nav-login text-center" href="{{ route('login') }}">
                            Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="nav-link btn-nav-register text-center" href="{{ route('register.form') }}">
                            Registrarse
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>