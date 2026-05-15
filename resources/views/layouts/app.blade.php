<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PLANOVA - Cafe Reservation')</title>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Page Specific Styles --}}
    @stack('styles')

    <style>
        :root {
            --primary-green:   #2d5a27;
            --dark-green:      #1a3d17;
            --light-green:     #4a7c43;
            --green-light:     #d4edda;
            --green-glow:      rgba(45, 90, 39, 0.25);
            --black:           #1a1a1a;
            --white:           #ffffff;
            --gray:            #f5f5f5;
            --gray-light:      #e9ecef;
            --danger:          #dc3545;
            --warning:         #ffc107;
            --success:         #198754;
            --shadow-sm:   0 2px 8px rgba(0,0,0,0.08);
            --shadow-md:   0 4px 16px rgba(0,0,0,0.12);
            --shadow-lg:   0 8px 32px rgba(0,0,0,0.18);
            --transition-fast: 0.2s ease;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray);
            color: var(--black);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
        }

        .navbar {
            background: linear-gradient(135deg, var(--dark-green), var(--primary-green));
            box-shadow: var(--shadow-md);
            padding: 0.75rem 0;
            min-height: 65px;
            position: sticky;
            top: 0;
            z-index: 1030;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            padding: 0.5rem 0;
            min-height: 60px;
            box-shadow: var(--shadow-lg);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--white) !important;
            text-decoration: none;
        }
        
        .navbar-brand .brand-accent { color: #90EE90; }
        
        .nav-link {
            font-weight: 500;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.85) !important;
            margin: 0 0.25rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all var(--transition-fast);
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--white) !important;
            background: rgba(255, 255, 255, 0.15);
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.35rem 0.6rem;
        }
        
        .navbar-toggler:hover {
            border-color: rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(45, 90, 39, 0.25);
            outline: none;
        }
        
        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(26, 61, 23, 0.98);
                padding: 1rem;
                border-radius: 0 0 12px 12px;
                margin-top: 0.5rem;
            }
            .nav-link { padding: 0.6rem 1rem !important; margin: 0.25rem 0; }
            .navbar-brand { font-size: 1.2rem; }
        }

        .btn-outline-light-custom {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.4);
            color: var(--white);
            font-weight: 500;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            transition: all var(--transition-fast);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .btn-outline-light-custom:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: var(--white);
            color: var(--white);
        }
        
        .btn-logout {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff9999;
            font-weight: 500;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            transition: all var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            cursor: pointer;
        }
        
        .btn-logout:hover {
            background: rgba(220, 53, 69, 0.25);
            border-color: var(--danger);
            color: var(--white);
        }

        .alert {
            border: none;
            border-radius: 12px;
            font-weight: 500;
            box-shadow: var(--shadow-sm);
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid var(--success);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            border-left: 4px solid var(--danger);
        }
        
        .btn-close { filter: none; opacity: 0.7; }
        .btn-close:hover { opacity: 1; }

        main { flex: 1; padding: 1rem 0 3rem; }
        main > .container { max-width: 1200px; }
        
        footer {
            background: var(--black);
            color: rgba(255, 255, 255, 0.7);
            padding: 1.5rem 0;
            font-size: 0.9rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        footer a { color: #90EE90; text-decoration: none; }
        footer a:hover { color: var(--white); }

        @media (max-width: 576px) {
            .navbar-brand { font-size: 1.2rem; }
            main { padding: 0.5rem 0 2rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-calendar2-check"></i>
                PLANO<span class="brand-accent">VA</span>
            </a>
            
            <button class="navbar-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" 
                           href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i>Beranda
                        </a>
                    </li>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.reservations.index') }}">
                                    <i class="bi bi-calendar3 me-1"></i>Reservasi
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reservations.create') ? 'active' : '' }}" 
                                   href="{{ route('reservations.create') }}">
                                    <i class="bi bi-plus-circle me-1"></i>Reservasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('reservations.index') ? 'active' : '' }}" 
                                   href="{{ route('reservations.index') }}">
                                    <i class="bi bi-clock-history me-1"></i>Riwayat
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="button" class="btn-logout btn-sm" onclick="confirmLogout(event)">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span class="d-none d-sm-inline">Logout</span>
                                </button>
                            </form>
                        </li>
                        
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}" class="btn btn-outline-light-custom btn-sm">
                                <i class="bi bi-person-plus me-1"></i>Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @if($errors->any())
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer>
        <div class="container text-center">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong style="color: #90EE90;">PLANOVA</strong>. All rights reserved.
            </p>
        </div>
    </footer>

    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('mainNavbar');
            
            const handleScroll = () => {
                if (window.scrollY > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            };
            
            window.addEventListener('scroll', handleScroll);
            handleScroll();
        });
        
        function confirmLogout(event) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin logout dari PLANOVA?')) {
                event.target.closest('form').submit();
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert?.close();
                }, 5000);
            });
        });
    </script>

</body>
</html>