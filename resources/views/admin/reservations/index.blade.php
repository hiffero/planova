<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Reservasi — PLANOVA Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --green-deep:   #1a3d17;
            --green-mid:    #2d5a27;
            --green-bright: #4a8c40;
            --green-accent: #6dbf5f;
            --green-glow:   rgba(74,140,64,0.25);
            --black:        #0a0a0a;
            --surface:      #111111;
            --card:         #161616;
            --card-hover:   #1c1c1c;
            --white:        #ffffff;
            --gray:         #888888;
            --gray-light:   #aaaaaa;
            --border:       rgba(255,255,255,0.07);
            --border-green: rgba(74,140,64,0.28);
            --amber:        #f5a623;
            --blue:         #3b8fd4;
            --red:          #e05252;
        }

        *,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }

        body {
            font-family: "DM Sans", sans-serif;
            background: var(--black);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ── LAYOUT ── */
        .layout { display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            flex-shrink: 0;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: transform 0.3s ease;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .logo-text {
            font-family: "Playfair Display", serif;
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--white);
            letter-spacing: -0.5px;
            text-decoration: none;
            display: block;
        }

        .logo-text span { color: var(--green-accent); }

        .logo-sub {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gray);
            margin-top: 4px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gray);
            padding: 10px 12px 6px;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: var(--gray-light);
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-item i { font-size: 1.05rem; width: 18px; text-align: center; }

        .nav-item:hover {
            background: rgba(74,140,64,0.12);
            color: var(--white);
        }

        .nav-item.active {
            background: rgba(74,140,64,0.18);
            color: var(--green-accent);
            border: 1px solid var(--border-green);
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .btn-logout-side {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid rgba(224,82,82,0.25);
            background: rgba(224,82,82,0.08);
            color: #ff7b7b;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
        }

        .btn-logout-side:hover {
            background: rgba(224,82,82,0.18);
            border-color: rgba(224,82,82,0.5);
        }

        /* ── MAIN ── */
        .main {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── TOPBAR ── */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 36px;
            background: rgba(17,17,17,0.9);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left h1 {
            font-family: "Playfair Display", serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--white);
            margin: 0;
        }

        .topbar-left p {
            font-size: 0.8rem;
            color: var(--gray);
            margin: 2px 0 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-time {
            font-size: 0.8rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-time i { color: var(--green-accent); }

        .btn-topbar {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid var(--border-green);
            background: rgba(74,140,64,0.1);
            color: var(--green-accent);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-topbar:hover {
            background: var(--green-mid);
            color: var(--white);
        }

        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--green-mid);
            border: 2px solid var(--green-bright);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--white);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 4px;
        }

        /* ── PAGE BODY ── */
        .page-body {
            flex: 1;
            padding: 32px 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 50px;
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--gray-light);
            transition: all 0.2s ease;
        }

        .stat-pill i { font-size: 0.88rem; }
        .stat-pill strong { color: var(--white); }

        .stat-pill.all    i { color: var(--green-accent); }
        .stat-pill.pending  { border-color: rgba(245,166,35,0.3); }
        .stat-pill.pending  i { color: var(--amber); }
        .stat-pill.approved { border-color: rgba(74,140,64,0.3); }
        .stat-pill.approved i { color: var(--green-accent); }
        .stat-pill.rejected { border-color: rgba(224,82,82,0.3); }
        .stat-pill.rejected i { color: var(--red); }

        /* ── TOOLBAR ── */
        .toolbar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-wrapper {
            flex: 1;
            min-width: 220px;
            position: relative;
        }

        .search-wrapper i.search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 0.9rem;
            pointer-events: none;
            z-index: 1;
        }

        .search-wrapper input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--white);
            font-size: 0.88rem;
            font-family: "DM Sans", sans-serif;
            transition: border-color 0.2s;
        }

        .search-wrapper input:focus {
            outline: none;
            border-color: var(--green-bright);
            background: var(--card-hover);
        }

        .search-wrapper input::placeholder { color: var(--gray); }

        .filter-select {
            padding: 10px 32px 10px 14px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--gray-light);
            font-size: 0.88rem;
            font-family: "DM Sans", sans-serif;
            cursor: pointer;
            transition: border-color 0.2s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-color: var(--card);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--green-bright);
        }

        .filter-select option { background: #1c1c1c; color: var(--white); }

        .btn-toolbar {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--gray-light);
            font-size: 0.88rem;
            font-family: "DM Sans", sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-toolbar:hover {
            background: rgba(74,140,64,0.12);
            border-color: var(--border-green);
            color: var(--green-accent);
        }

        /* ── FLASH ── */
        .alert-success {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: rgba(109,191,95,0.1);
            border: 1px solid rgba(109,191,95,0.3);
            border-left: 3px solid var(--green-accent);
            border-radius: 12px;
            font-size: 0.88rem;
            color: var(--white);
        }

        .alert-success i { color: var(--green-accent); }

        .alert-close {
            margin-left: auto;
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
        }

        .alert-close:hover { color: var(--white); }

        /* ── SECTION CARD ── */
        .section-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow: hidden;
            animation: fadeUp 0.4s ease both;
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .section-head-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-head-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            background: rgba(74,140,64,0.15);
            border: 1px solid var(--border-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            color: var(--green-accent);
        }

        .section-head h2 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--white);
            margin: 0;
        }

        .section-count {
            font-size: 0.75rem;
            color: var(--gray);
            font-weight: 400;
            margin-left: 4px;
        }

        /* ── TABLE ── */
        .table-wrap { overflow-x: auto; }

        .table-modern {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.88rem;
        }

        .table-modern thead tr {
            border-bottom: 1px solid var(--border);
        }

        .table-modern thead th {
            padding: 14px 20px;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--gray);
            white-space: nowrap;
        }

        .table-modern tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s ease;
        }

        .table-modern tbody tr:last-child { border-bottom: none; }

        .table-modern tbody tr:hover {
            background: rgba(74,140,64,0.05);
        }

        .table-modern td {
            padding: 14px 20px;
            vertical-align: middle;
            color: var(--gray-light);
        }

        /* User cell */
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--green-mid);
            border: 1px solid var(--border-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--white);
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--white);
            margin: 0 0 1px;
        }

        .user-email {
            font-size: 0.76rem;
            color: var(--gray);
            margin: 0;
        }

        .cafe-name-text {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--white);
        }

        /* Date/time badge */
        .dt-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.82rem;
            color: var(--gray-light);
            white-space: nowrap;
        }

        .dt-badge i { color: var(--green-accent); font-size: 0.78rem; }

        /* Guests badge */
        .guests-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.84rem;
            color: var(--gray-light);
        }

        .guests-badge i { color: var(--blue); font-size: 0.82rem; }

        /* Proof button */
        .btn-proof {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: rgba(59,143,212,0.1);
            border: 1px solid rgba(59,143,212,0.3);
            border-radius: 8px;
            color: var(--blue);
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-proof:hover {
            background: rgba(59,143,212,0.2);
            border-color: var(--blue);
            color: var(--white);
        }

        /* Status pills */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.74rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .pill.pending  { background: rgba(245,166,35,0.12);  color: var(--amber);        border: 1px solid rgba(245,166,35,0.3); }
        .pill.approved { background: rgba(109,191,95,0.12);  color: var(--green-accent); border: 1px solid rgba(109,191,95,0.3); }
        .pill.rejected { background: rgba(224,82,82,0.12);   color: var(--red);          border: 1px solid rgba(224,82,82,0.3); }

        /* Action buttons */
        .action-group { display: flex; gap: 6px; align-items: center; }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            font-family: "DM Sans", sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid;
        }

        .btn-action.approve {
            background: rgba(109,191,95,0.1);
            border-color: rgba(109,191,95,0.3);
            color: var(--green-accent);
        }

        .btn-action.approve:hover {
            background: rgba(109,191,95,0.22);
            border-color: var(--green-accent);
            color: var(--white);
            transform: translateY(-1px);
        }

        .btn-action.reject {
            background: rgba(224,82,82,0.1);
            border-color: rgba(224,82,82,0.3);
            color: var(--red);
        }

        .btn-action.reject:hover {
            background: rgba(224,82,82,0.22);
            border-color: var(--red);
            color: var(--white);
            transform: translateY(-1px);
        }

        .done-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.78rem;
            color: var(--gray);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
        }

        .empty-state i {
            font-size: 2.8rem;
            color: var(--gray);
            opacity: 0.3;
            display: block;
            margin-bottom: 16px;
        }

        .empty-state h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-light);
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 0.85rem;
            color: var(--gray);
            margin: 0;
        }

        /* ── PAGINATION ── */
        .pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination-info {
            font-size: 0.8rem;
            color: var(--gray);
        }

        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
            margin: 0; padding: 0;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--gray-light);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background: rgba(74,140,64,0.12);
            border-color: var(--border-green);
            color: var(--green-accent);
        }

        .page-item.active .page-link {
            background: var(--green-bright);
            border-color: var(--green-bright);
            color: var(--white);
        }

        .page-item.disabled .page-link {
            opacity: 0.35;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ── FOOTER ── */
        .page-footer {
            border-top: 1px solid var(--border);
            padding: 18px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--gray);
        }

        .page-footer a { color: var(--green-accent); text-decoration: none; }
        .page-footer a:hover { color: var(--white); }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .mobile-toggle { display: flex; }
            .page-body { padding: 20px; }
            .topbar { padding: 14px 20px; }
            .page-footer { padding: 14px 20px; flex-direction: column; gap: 8px; text-align: center; }
        }

        @media (max-width: 640px) {
            .toolbar { flex-direction: column; }
            .search-wrapper, .filter-select, .btn-toolbar { width: 100%; }
            .stats-row { gap: 6px; }

            .table-modern thead { display: none; }
            .table-modern tbody tr {
                display: block;
                padding: 14px 16px;
                border-radius: 12px;
                margin: 8px 16px;
                border: 1px solid var(--border);
                background: rgba(255,255,255,0.02);
            }
            .table-modern tbody tr:last-child { border-bottom: 1px solid var(--border); }
            .table-modern td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 6px 0;
                border: none;
            }
            .table-modern td::before {
                content: attr(data-label);
                font-size: 0.72rem;
                font-weight: 600;
                color: var(--gray);
                text-transform: uppercase;
                letter-spacing: 0.06em;
            }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="layout">

    {{-- ═══ SIDEBAR ═══ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="logo-text">PLANO<span>VA</span></a>
            <div class="logo-sub">Admin Panel</div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Overview</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <span class="nav-section-label">Manajemen</span>
            <a href="{{ route('admin.cafes.index') }}" class="nav-item">
                <i class="bi bi-building"></i> Kelola Cafe
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-item">
                <i class="bi bi-menu-button-wide"></i> Kelola Menu
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item active">
                <i class="bi bi-calendar-check"></i> Reservasi
            </a>

            <span class="nav-section-label">Sistem</span>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="bi bi-globe2"></i> Lihat Website
            </a>
        </nav>

        <div class="sidebar-footer">
            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button class="btn-logout-side" onclick="handleLogout(event)">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            @endauth
        </div>
    </aside>

    {{-- ═══ MAIN ═══ --}}
    <div class="main">

        {{-- ── TOPBAR ── --}}
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:14px;">
                <button class="mobile-toggle" onclick="toggleSidebar()" aria-label="Toggle sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-left">
                    <h1>Kelola Reservasi</h1>
                    <p>Konfirmasi dan manajemen reservasi cafe</p>
                </div>
            </div>
            <div class="topbar-right">
                <span class="topbar-time">
                    <i class="bi bi-clock"></i>
                    <span id="clock">--:--</span>
                </span>
                <a href="{{ route('admin.dashboard') }}" class="btn-topbar">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
                <div class="avatar">A</div>
            </div>
        </header>

        {{-- ── PAGE BODY ── --}}
        <main class="page-body">

            {{-- Flash --}}
            @if(session('success'))
            <div class="alert-success" id="flash-msg">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button class="alert-close" onclick="document.getElementById('flash-msg').remove()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            @endif

            {{-- Stats --}}
            <div class="stats-row">
                <span class="stat-pill all">
                    <i class="bi bi-list-check"></i>
                    Total: <strong>{{ $reservations->total() }}</strong>
                </span>
                <span class="stat-pill pending">
                    <i class="bi bi-hourglass-split"></i>
                    Pending: <strong>{{ $reservations->where('status','pending')->count() }}</strong>
                </span>
                <span class="stat-pill approved">
                    <i class="bi bi-check-circle"></i>
                    Approved: <strong>{{ $reservations->where('status','approved')->count() }}</strong>
                </span>
                <span class="stat-pill rejected">
                    <i class="bi bi-x-circle"></i>
                    Rejected: <strong>{{ $reservations->where('status','rejected')->count() }}</strong>
                </span>
            </div>

            {{-- Toolbar --}}
            <div class="toolbar">
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <form method="GET" action="{{ route('admin.reservations.index') }}" id="searchForm">
                        <input type="text" name="search"
                               placeholder="Cari user atau cafe..."
                               value="{{ request('search') }}"
                               id="searchInput"
                               onchange="this.form.submit()">
                    </form>
                </div>
                <select class="filter-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending"  {{ request('status')=='pending'  ? 'selected':'' }}>Pending</option>
                    <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>Approved</option>
                    <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>Rejected</option>
                </select>
                <button class="btn-toolbar" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>

            {{-- Hidden filter form --}}
            <form id="filterForm" method="GET" action="{{ route('admin.reservations.index') }}" style="display:none;">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <input type="hidden" name="status" id="statusInput" value="{{ request('status') }}">
            </form>

            {{-- Table card --}}
            <div class="section-card">
                <div class="section-head">
                    <div class="section-head-left">
                        <div class="section-head-icon"><i class="bi bi-calendar-check"></i></div>
                        <h2>Daftar Reservasi <span class="section-count">({{ $reservations->total() }})</span></h2>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="table-modern">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Cafe</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Tamu</th>
                                <th>Bukti Bayar</th>
                                <th>Status</th>
                                <th style="width:140px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $r)
                            <tr>
                                <td data-label="User">
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($r->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="user-name">{{ $r->user->name ?? 'Guest' }}</p>
                                            <p class="user-email">{{ Str::limit($r->user->email ?? '-', 22) }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td data-label="Cafe">
                                    <span class="cafe-name-text">{{ $r->cafe->name ?? '-' }}</span>
                                </td>

                                <td data-label="Tanggal">
                                    <span class="dt-badge">
                                        <i class="bi bi-calendar3"></i>
                                        {{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}
                                    </span>
                                </td>

                                <td data-label="Waktu">
                                    <span class="dt-badge">
                                        <i class="bi bi-clock"></i>
                                        {{ $r->reservation_time }}
                                    </span>
                                </td>

                                <td data-label="Tamu">
                                    <span class="guests-badge">
                                        <i class="bi bi-people"></i>
                                        {{ $r->guests ?? '-' }}
                                    </span>
                                </td>

                                <td data-label="Bukti Bayar">
                                    @if($r->payment_proof)
                                        <a href="{{ asset('storage/'.$r->payment_proof) }}"
                                           target="_blank" class="btn-proof">
                                            <i class="bi bi-image"></i> Lihat
                                        </a>
                                    @else
                                        <span style="font-size:0.82rem;color:var(--gray);">—</span>
                                    @endif
                                </td>

                                <td data-label="Status">
                                    <span class="pill {{ $r->status }}">
                                        @if($r->status === 'pending')
                                            <i class="bi bi-hourglass-split"></i>
                                        @elseif($r->status === 'approved')
                                            <i class="bi bi-check-circle-fill"></i>
                                        @else
                                            <i class="bi bi-x-circle-fill"></i>
                                        @endif
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </td>

                                <td data-label="Aksi">
                                    @if($r->status === 'pending')
                                        <div class="action-group">
                                            <form method="POST"
                                                  action="{{ route('admin.reservations.update', $r) }}"
                                                  onsubmit="return confirm('Approve reservasi ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn-action approve" title="Setujui">
                                                    <i class="bi bi-check-lg"></i> Approve
                                                </button>
                                            </form>
                                            <form method="POST"
                                                  action="{{ route('admin.reservations.update', $r) }}"
                                                  onsubmit="return confirm('Tolak reservasi ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn-action reject" title="Tolak">
                                                    <i class="bi bi-x-lg"></i> Reject
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="done-label">
                                            <i class="bi bi-check2-circle"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <h3>Belum Ada Reservasi</h3>
                                        <p>Tidak ada data reservasi yang ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if(isset($reservations) && $reservations->hasPages())
                <div class="pagination-bar">
                    <span class="pagination-info">
                        {{ $reservations->firstItem() }}–{{ $reservations->lastItem() }} dari {{ $reservations->total() }} data
                    </span>
                    <ul class="pagination">
                        @if($reservations->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">‹</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $reservations->previousPageUrl() }}">‹</a></li>
                        @endif

                        @foreach($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                            @if($page == $reservations->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if($reservations->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $reservations->nextPageUrl() }}">›</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">›</span></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

        </main>

        {{-- ── FOOTER ── --}}
        <footer class="page-footer">
            <span>&copy; {{ date('Y') }} PLANOVA — Admin Panel</span>
            <a href="{{ route('home') }}">Kembali ke Website &rarr;</a>
        </footer>

    </div>{{-- end .main --}}

</div>{{-- end .layout --}}

<script>
    function handleLogout(e) {
        if (e) e.preventDefault();
        if (confirm('Yakin ingin logout dari panel admin?')) {
            document.getElementById('logout-form')?.submit();
        }
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        if (sidebar.classList.contains('open') &&
            !sidebar.contains(e.target) &&
            toggle && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });

    // Clock
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Status filter
    document.getElementById('statusFilter')?.addEventListener('change', function() {
        document.getElementById('statusInput').value = this.value;
        document.getElementById('filterForm').submit();
    });

    // Search on enter
    document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') document.getElementById('searchForm').submit();
    });
</script>
</body>
</html>