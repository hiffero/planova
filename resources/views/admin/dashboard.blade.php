<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin — PLANOVA</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ═══ TOKENS ═══ */
        :root {
            --black:    #0a0a0a;
            --surface:  #111111;
            --card:     #161616;
            --card2:    #1c1c1c;
            --border:   rgba(255,255,255,0.07);
            --border-g: rgba(92,184,92,0.28);
            --green:    #5cb85c;
            --green-d:  #3d8b3d;
            --green-l:  #8edb8e;
            --green-xd: #1a3d1a;
            --amber:    #f5a623;
            --amber-l:  #fcd34d;
            --blue:     #3b8fd4;
            --blue-l:   #7ec8f7;
            --red:      #e05252;
            --red-l:    #fc8181;
            --white:    #ffffff;
            --offwhite: #f0f0f0;
            --muted:    #888888;
            --muted2:   #444444;
            --radius:   13px;
            --radius-lg:20px;
            --sidebar-w:230px;
        }

        *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Noise texture */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events:none; z-index:0; opacity:0.5;
        }

        /* Ambient glow */
        .ambient { position:fixed; border-radius:50%; filter:blur(130px); pointer-events:none; z-index:0; }
        .amb-1 { width:420px; height:420px; background:radial-gradient(circle,rgba(92,184,92,0.09) 0%,transparent 70%); top:-100px; right:-80px; animation:drift 20s ease-in-out infinite; }
        .amb-2 { width:300px; height:300px; background:radial-gradient(circle,rgba(61,139,61,0.07) 0%,transparent 70%); bottom:-60px; left:80px; animation:drift 26s ease-in-out infinite reverse; }
        @keyframes drift { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(25px,-20px) scale(1.05)} 66%{transform:translate(-15px,15px) scale(0.95)} }

        /* ════ LAYOUT ════ */
        .layout { display:flex; min-height:100vh; position:relative; z-index:1; }

        /* ════ SIDEBAR ════ */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: rgba(17,17,17,0.95);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top:0; left:0; bottom:0;
            z-index: 300;
            transition: transform 0.32s cubic-bezier(0.4,0,0.2,1);
            backdrop-filter: blur(20px);
        }

        /* Sidebar accent line */
        .sidebar::after {
            content:'';
            position:absolute;
            top:0; right:0;
            width:1px; height:100%;
            background: linear-gradient(180deg, transparent, rgba(92,184,92,0.2) 40%, rgba(92,184,92,0.1) 70%, transparent);
        }

        .sidebar-logo {
            padding: 26px 22px 20px;
            border-bottom: 1px solid var(--border);
        }

        .logo-link {
            display:flex; align-items:center; gap:10px;
            text-decoration:none;
        }

        .logo-img {
            width:36px; height:36px;
            border-radius:10px;
            overflow:hidden;
            border: 1.5px solid rgba(92,184,92,0.25);
            flex-shrink:0;
        }
        .logo-img img { width:100%; height:100%; object-fit:cover; }

        .logo-wordmark {
            font-family:'Syne',sans-serif;
            font-size:18px; font-weight:800;
            letter-spacing:1.5px;
            color:var(--white);
        }
        .logo-wordmark span { color:var(--green); }

        .logo-sub {
            font-size:10px; font-weight:600;
            letter-spacing:2px; text-transform:uppercase;
            color:var(--muted); margin-top:5px;
        }

        .sidebar-nav {
            flex:1;
            padding: 18px 10px;
            display:flex; flex-direction:column; gap:2px;
            overflow-y:auto;
        }

        .nav-section {
            font-size:10px; font-weight:700;
            letter-spacing:2px; text-transform:uppercase;
            color:var(--muted2); padding:10px 12px 5px;
            margin-top:6px;
        }

        .nav-item {
            display:flex; align-items:center; gap:10px;
            padding:10px 13px;
            border-radius:10px;
            text-decoration:none;
            color:var(--muted); font-size:13.5px; font-weight:500;
            transition:all 0.2s ease;
            border:1px solid transparent;
        }
        .nav-item i { font-size:15px; width:18px; text-align:center; flex-shrink:0; }
        .nav-item:hover { background:rgba(92,184,92,0.08); color:var(--white); border-color:transparent; }
        .nav-item.active {
            background:rgba(92,184,92,0.12);
            color:var(--green-l);
            border-color:var(--border-g);
        }

        /* Nav badge */
        .nav-badge {
            margin-left:auto;
            font-size:10.5px; font-weight:700;
            padding:2px 8px; border-radius:20px;
            background:rgba(245,166,35,0.15);
            color:var(--amber);
            border:1px solid rgba(245,166,35,0.25);
        }

        .sidebar-footer {
            padding:14px 10px;
            border-top:1px solid var(--border);
        }

        .btn-logout-side {
            display:flex; align-items:center; gap:10px;
            padding:10px 13px; border-radius:10px;
            border:1px solid rgba(224,82,82,0.2);
            background:rgba(224,82,82,0.06);
            color:var(--red-l); font-size:13.5px; font-weight:500;
            cursor:pointer; width:100%; text-align:left;
            font-family:'DM Sans',sans-serif;
            transition:all 0.2s ease;
        }
        .btn-logout-side:hover { background:rgba(224,82,82,0.14); border-color:rgba(224,82,82,0.4); }

        /* ════ MAIN ════ */
        .main {
            margin-left:var(--sidebar-w);
            flex:1;
            display:flex; flex-direction:column;
            min-height:100vh;
        }

        /* ════ TOPBAR ════ */
        .topbar {
            display:flex; align-items:center; justify-content:space-between;
            padding:16px 32px;
            background:rgba(10,10,10,0.88);
            backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
            position:sticky; top:0; z-index:100;
            gap:16px;
        }

        .topbar-left { display:flex; align-items:center; gap:14px; }

        .mobile-toggle {
            display:none;
            background:none; border:1px solid var(--border);
            color:var(--white); font-size:16px;
            cursor:pointer; padding:7px 9px;
            border-radius:9px; transition:all 0.2s;
        }
        .mobile-toggle:hover { border-color:var(--border-g); color:var(--green); }

        .topbar-title h1 {
            font-family:'Syne',sans-serif;
            font-size:18px; font-weight:700; color:var(--white); margin:0;
        }
        .topbar-title p { font-size:12px; color:var(--muted); margin:1px 0 0; }

        .topbar-right { display:flex; align-items:center; gap:10px; }

        .clock-chip {
            display:flex; align-items:center; gap:7px;
            padding:7px 13px;
            background:rgba(255,255,255,0.04);
            border:1px solid var(--border);
            border-radius:9px;
            font-size:12.5px; color:var(--muted);
        }
        .clock-chip i { color:var(--green); font-size:13px; }

        .btn-site {
            display:flex; align-items:center; gap:7px;
            padding:8px 15px;
            background:rgba(92,184,92,0.08);
            border:1px solid var(--border-g);
            border-radius:9px;
            color:var(--green-l); font-size:13px; font-weight:500;
            text-decoration:none; transition:all 0.2s;
        }
        .btn-site:hover { background:rgba(92,184,92,0.16); color:var(--green); }

        .admin-avatar {
            width:34px; height:34px; border-radius:9px;
            background:var(--green-xd);
            border:1.5px solid var(--border-g);
            display:flex; align-items:center; justify-content:center;
            font-family:'Syne',sans-serif;
            font-size:14px; font-weight:700; color:var(--green-l);
        }

        /* ════ PAGE BODY ════ */
        .page-body {
            flex:1;
            padding:32px;
            display:flex; flex-direction:column; gap:24px;
        }

        /* Page headline */
        .page-headline {
            display:flex; align-items:flex-end; justify-content:space-between;
            gap:16px; flex-wrap:wrap;
        }

        .headline-left {}
        .headline-eyebrow {
            font-size:10.5px; font-weight:700; letter-spacing:2.5px;
            text-transform:uppercase; color:var(--green); margin-bottom:6px;
            display:flex; align-items:center; gap:8px;
        }
        .headline-eyebrow::before { content:''; width:16px; height:2px; background:var(--green); border-radius:2px; }
        .headline-title {
            font-family:'Syne',sans-serif;
            font-size:28px; font-weight:800; color:var(--white);
            letter-spacing:-0.3px; line-height:1.1; margin:0;
        }
        .headline-title span { color:var(--green); }

        .headline-date {
            font-size:12px; color:var(--muted);
            text-align:right; line-height:1.5;
        }
        .headline-date strong { display:block; color:var(--offwhite); font-size:13px; }

        /* ════ STATS GRID ════ */
        .stats-grid {
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:14px;
        }

        .stat-card {
            background:var(--card);
            border:1px solid var(--border);
            border-radius:var(--radius-lg);
            padding:22px 20px;
            display:flex; flex-direction:column; gap:16px;
            position:relative; overflow:hidden;
            transition:transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            animation:fadeUp 0.5s ease both;
        }
        .stat-card:hover {
            transform:translateY(-4px);
            box-shadow:0 16px 50px rgba(0,0,0,0.5);
        }
        .stat-card:nth-child(1){animation-delay:0.05s}
        .stat-card:nth-child(2){animation-delay:0.12s}
        .stat-card:nth-child(3){animation-delay:0.19s}
        .stat-card:nth-child(4){animation-delay:0.26s}

        /* top accent */
        .stat-card::before { content:''; display:block; position:absolute; top:0;left:0;right:0;height:2px; }
        .stat-card.green::before  { background:linear-gradient(90deg,var(--green),transparent); }
        .stat-card.amber::before  { background:linear-gradient(90deg,var(--amber),transparent); }
        .stat-card.blue::before   { background:linear-gradient(90deg,var(--blue),transparent); }
        .stat-card.red::before    { background:linear-gradient(90deg,var(--red),transparent); }

        /* glow orb bg */
        .stat-card::after {
            content:''; position:absolute;
            top:-50px; right:-50px;
            width:120px; height:120px;
            border-radius:50%; opacity:0.05;
            transition:opacity 0.3s;
        }
        .stat-card.green::after { background:var(--green); }
        .stat-card.amber::after { background:var(--amber); }
        .stat-card.blue::after  { background:var(--blue); }
        .stat-card.red::after   { background:var(--red); }
        .stat-card:hover::after { opacity:0.1; }

        /* card hover border */
        .stat-card.green:hover { border-color:rgba(92,184,92,0.3); }
        .stat-card.amber:hover { border-color:rgba(245,166,35,0.3); }
        .stat-card.blue:hover  { border-color:rgba(59,143,212,0.3); }
        .stat-card.red:hover   { border-color:rgba(224,82,82,0.3); }

        .stat-top { display:flex; align-items:center; justify-content:space-between; position:relative; z-index:1; }

        .stat-icon {
            width:42px; height:42px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px;
        }
        .stat-icon.green { background:rgba(92,184,92,0.12); color:var(--green-l); }
        .stat-icon.amber { background:rgba(245,166,35,0.12); color:var(--amber-l); }
        .stat-icon.blue  { background:rgba(59,143,212,0.12); color:var(--blue-l); }
        .stat-icon.red   { background:rgba(224,82,82,0.12);  color:var(--red-l); }

        .stat-pill {
            font-size:10.5px; font-weight:700; letter-spacing:0.5px;
            padding:3px 9px; border-radius:20px; border:1px solid;
        }
        .stat-pill.green { background:rgba(92,184,92,0.1); border-color:rgba(92,184,92,0.25); color:var(--green-l); }
        .stat-pill.amber { background:rgba(245,166,35,0.1); border-color:rgba(245,166,35,0.25); color:var(--amber-l); }
        .stat-pill.blue  { background:rgba(59,143,212,0.1); border-color:rgba(59,143,212,0.25); color:var(--blue-l); }
        .stat-pill.red   { background:rgba(224,82,82,0.1);  border-color:rgba(224,82,82,0.25);  color:var(--red-l); }

        .stat-bottom { position:relative; z-index:1; }
        .stat-num {
            font-family:'Syne',sans-serif;
            font-size:36px; font-weight:800; line-height:1; color:var(--white);
            margin-bottom:4px;
        }
        .stat-label { font-size:12.5px; color:var(--muted); font-weight:500; }

        /* ════ TWO-COL ════ */
        .two-col { display:grid; grid-template-columns:1fr 1fr; gap:18px; }

        /* ════ SECTION CARD ════ */
        .sc {
            background:var(--card);
            border:1px solid var(--border);
            border-radius:var(--radius-lg);
            overflow:hidden;
            animation:fadeUp 0.5s ease 0.3s both;
        }

        .sc-head {
            display:flex; align-items:center; justify-content:space-between;
            padding:18px 22px 14px;
            border-bottom:1px solid var(--border);
        }

        .sc-head-left { display:flex; align-items:center; gap:10px; }

        .sc-icon {
            width:34px; height:34px; border-radius:9px;
            background:rgba(92,184,92,0.1); border:1px solid var(--border-g);
            display:flex; align-items:center; justify-content:center;
            font-size:15px; color:var(--green);
        }

        .sc-title { font-family:'Syne',sans-serif; font-size:15px; font-weight:700; color:var(--white); }

        .btn-all {
            display:flex; align-items:center; gap:5px;
            font-size:12px; color:var(--green); font-weight:500;
            text-decoration:none; transition:color 0.2s;
        }
        .btn-all:hover { color:var(--green-l); }

        .sc-body { padding:18px 22px; }

        /* ════ ACTIONS GRID ════ */
        .actions-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }

        .action-tile {
            display:flex; align-items:center; gap:12px;
            padding:14px 16px;
            background:rgba(255,255,255,0.025);
            border:1px solid var(--border);
            border-radius:var(--radius);
            text-decoration:none; color:var(--white);
            transition:all 0.22s ease;
        }
        .action-tile:hover {
            background:rgba(92,184,92,0.08);
            border-color:var(--border-g);
            transform:translateY(-2px);
            box-shadow:0 8px 24px rgba(0,0,0,0.3);
        }

        .at-icon {
            width:38px; height:38px; border-radius:10px;
            background:rgba(92,184,92,0.1); border:1px solid var(--border-g);
            display:flex; align-items:center; justify-content:center;
            font-size:16px; color:var(--green); flex-shrink:0;
            transition:transform 0.2s;
        }
        .action-tile:hover .at-icon { transform:scale(1.1); }

        .at-strong { display:block; font-size:13.5px; font-weight:600; color:var(--white); margin-bottom:2px; }
        .at-small  { font-size:11.5px; color:var(--muted); }

        /* ════ ACTIVITY ════ */
        .activity-list { display:flex; flex-direction:column; gap:8px; }

        .act-row {
            display:flex; align-items:center; gap:12px;
            padding:13px 16px;
            background:rgba(255,255,255,0.02);
            border:1px solid var(--border);
            border-radius:var(--radius);
            transition:all 0.2s ease;
        }
        .act-row:hover { border-color:var(--border-g); background:rgba(92,184,92,0.04); }

        .act-dot {
            width:34px; height:34px; border-radius:9px;
            display:flex; align-items:center; justify-content:center;
            font-size:14px; flex-shrink:0;
        }
        .act-dot.pending  { background:rgba(245,166,35,0.1);  color:var(--amber-l); }
        .act-dot.approved { background:rgba(92,184,92,0.1);   color:var(--green-l); }
        .act-dot.rejected { background:rgba(224,82,82,0.1);   color:var(--red-l); }

        .act-info { flex:1; min-width:0; }
        .act-title {
            font-size:13.5px; font-weight:500; color:var(--white);
            white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;
        }
        .act-meta { font-size:11.5px; color:var(--muted); }

        .act-right { text-align:right; flex-shrink:0; }

        .status-pill {
            display:inline-block;
            padding:3px 10px; border-radius:20px;
            font-size:10.5px; font-weight:700;
            letter-spacing:0.5px; text-transform:uppercase;
            border:1px solid;
        }
        .status-pill.pending  { background:rgba(245,166,35,0.08); border-color:rgba(245,166,35,0.25); color:var(--amber-l); }
        .status-pill.approved { background:rgba(92,184,92,0.08);  border-color:rgba(92,184,92,0.25);  color:var(--green-l); }
        .status-pill.rejected { background:rgba(224,82,82,0.08);  border-color:rgba(224,82,82,0.25);  color:var(--red-l); }

        .act-time { font-size:11px; color:var(--muted2); margin-top:4px; }

        /* Empty */
        .empty-state { text-align:center; padding:40px 20px; color:var(--muted2); }
        .empty-state i { font-size:36px; opacity:0.3; display:block; margin-bottom:12px; }
        .empty-state p { font-size:13px; }

        /* ════ FOOTER ════ */
        .page-footer {
            border-top:1px solid var(--border);
            padding:16px 32px;
            display:flex; align-items:center; justify-content:space-between;
            font-size:12px; color:var(--muted2);
        }
        .page-footer .footer-brand { font-family:'Syne',sans-serif; font-weight:800; letter-spacing:1px; color:var(--white); }
        .page-footer a { color:var(--green); text-decoration:none; transition:color 0.2s; }
        .page-footer a:hover { color:var(--green-l); }

        /* ════ ANIMATIONS ════ */
        @keyframes fadeUp { from{opacity:0;transform:translateY(16px)} to{opacity:1;transform:translateY(0)} }

        /* ════ RESPONSIVE ════ */
        @media (max-width:1100px) { .stats-grid { grid-template-columns:repeat(2,1fr); } }
        @media (max-width:900px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:translateX(0); }
            .main { margin-left:0; }
            .mobile-toggle { display:flex; }
            .two-col { grid-template-columns:1fr; }
            .page-body { padding:20px; }
            .topbar { padding:14px 20px; }
            .page-footer { padding:14px 20px; flex-direction:column; gap:8px; text-align:center; }
            .page-headline { flex-direction:column; align-items:flex-start; }
        }
        @media (max-width:600px) {
            .stats-grid { grid-template-columns:1fr 1fr; gap:10px; }
            .stat-num { font-size:28px; }
            .actions-grid { grid-template-columns:1fr; }
            .clock-chip, .btn-site span { display:none; }
        }
        @media (max-width:380px) { .stats-grid { grid-template-columns:1fr; } }

        /* Sidebar overlay (mobile) */
        .sidebar-overlay {
            display:none;
            position:fixed; inset:0;
            background:rgba(0,0,0,0.6);
            z-index:299;
            backdrop-filter:blur(4px);
        }
        .sidebar-overlay.show { display:block; }
    </style>
</head>
<body>

<div class="ambient amb-1"></div>
<div class="ambient amb-2"></div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="layout">

    {{-- ════ SIDEBAR ════ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo-img">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
                </div>
                <div>
                    <div class="logo-wordmark">PLANO<span>VA</span></div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section">Overview</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                <i class="fas fa-table-cells-large"></i> Dashboard
            </a>

            <span class="nav-section">Manajemen</span>
            <a href="{{ route('admin.cafes.index') }}" class="nav-item">
                <i class="fas fa-store"></i> Kelola Café
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-item">
                <i class="fas fa-utensils"></i> Kelola Menu
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item">
                <i class="fas fa-calendar-check"></i> Reservasi
                @php $pending = \App\Models\Reservation::where('status','pending')->count(); @endphp
                @if($pending > 0)
                <span class="nav-badge">{{ $pending }}</span>
                @endif
            </a>

            <span class="nav-section">Sistem</span>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
        </nav>

        <div class="sidebar-footer">
            @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            <button class="btn-logout-side" onclick="handleLogout(event)">
                <i class="fas fa-arrow-right-from-bracket"></i> Logout
            </button>
            @endauth
        </div>
    </aside>

    {{-- ════ MAIN ════ --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>Dashboard</h1>
                    <p>Selamat datang kembali, Admin</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="clock-chip">
                    <i class="fas fa-clock"></i>
                    <span id="clock">--:--</span>
                </div>
                <a href="{{ route('home') }}" class="btn-site">
                    <i class="fas fa-arrow-left"></i>
                    <span>Website</span>
                </a>
                <div class="admin-avatar">A</div>
            </div>
        </header>

        {{-- Page body --}}
        <main class="page-body">

            {{-- Headline --}}
            <div class="page-headline">
                <div class="headline-left">
                    <div class="headline-eyebrow">Admin Panel</div>
                    <h2 class="headline-title">Pantau & Kelola<br><span>Semua Aktivitas</span></h2>
                </div>
                <div class="headline-date">
                    <strong id="date-full">—</strong>
                    <span>Data real-time PLANOVA</span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="stats-grid">

                <div class="stat-card green">
                    <div class="stat-top">
                        <div class="stat-icon green"><i class="fas fa-store"></i></div>
                        <span class="stat-pill green">Aktif</span>
                    </div>
                    <div class="stat-bottom">
                        <div class="stat-num">{{ \App\Models\Cafe::count() }}</div>
                        <div class="stat-label">Total Café Partner</div>
                    </div>
                </div>

                <div class="stat-card amber">
                    <div class="stat-top">
                        <div class="stat-icon amber"><i class="fas fa-hourglass-half"></i></div>
                        <span class="stat-pill amber">Perlu Aksi</span>
                    </div>
                    <div class="stat-bottom">
                        <div class="stat-num">{{ \App\Models\Reservation::where('status','pending')->count() }}</div>
                        <div class="stat-label">Menunggu Konfirmasi</div>
                    </div>
                </div>

                <div class="stat-card green">
                    <div class="stat-top">
                        <div class="stat-icon green"><i class="fas fa-circle-check"></i></div>
                        <span class="stat-pill green">Disetujui</span>
                    </div>
                    <div class="stat-bottom">
                        <div class="stat-num">{{ \App\Models\Reservation::where('status','approved')->count() }}</div>
                        <div class="stat-label">Reservasi Disetujui</div>
                    </div>
                </div>

                <div class="stat-card blue">
                    <div class="stat-top">
                        <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                        <span class="stat-pill blue">Terdaftar</span>
                    </div>
                    <div class="stat-bottom">
                        <div class="stat-num">{{ \App\Models\User::count() }}</div>
                        <div class="stat-label">Total Pengguna</div>
                    </div>
                </div>

            </div>

            {{-- Two column --}}
            <div class="two-col">

                {{-- Quick actions --}}
                <div class="sc">
                    <div class="sc-head">
                        <div class="sc-head-left">
                            <div class="sc-icon"><i class="fas fa-bolt"></i></div>
                            <span class="sc-title">Menu Cepat</span>
                        </div>
                    </div>
                    <div class="sc-body">
                        <div class="actions-grid">
                            <a href="{{ route('admin.cafes.index') }}" class="action-tile">
                                <div class="at-icon"><i class="fas fa-store"></i></div>
                                <div>
                                    <span class="at-strong">Kelola Café</span>
                                    <span class="at-small">Tambah, edit, hapus</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.menus.index') }}" class="action-tile">
                                <div class="at-icon"><i class="fas fa-utensils"></i></div>
                                <div>
                                    <span class="at-strong">Kelola Menu</span>
                                    <span class="at-small">Makanan & minuman</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.reservations.index') }}" class="action-tile">
                                <div class="at-icon"><i class="fas fa-calendar-check"></i></div>
                                <div>
                                    <span class="at-strong">Reservasi</span>
                                    <span class="at-small">Konfirmasi & kelola</span>
                                </div>
                            </a>
                            <a href="{{ route('admin.cafes.create') }}" class="action-tile">
                                <div class="at-icon"><i class="fas fa-plus-circle"></i></div>
                                <div>
                                    <span class="at-strong">Tambah Café</span>
                                    <span class="at-small">Daftarkan café baru</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Activity --}}
                <div class="sc">
                    <div class="sc-head">
                        <div class="sc-head-left">
                            <div class="sc-icon"><i class="fas fa-clock-rotate-left"></i></div>
                            <span class="sc-title">Aktivitas Terbaru</span>
                        </div>
                        <a href="{{ route('admin.reservations.index') }}" class="btn-all">
                            Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="sc-body">
                        <div class="activity-list">
                            @php
                                $recentReservations = \App\Models\Reservation::with(['cafe','user'])
                                    ->latest()->take(5)->get();
                            @endphp

                            @forelse($recentReservations as $r)
                            <div class="act-row">
                                <div class="act-dot {{ $r->status }}">
                                    @if($r->status === 'approved') <i class="fas fa-check"></i>
                                    @elseif($r->status === 'rejected') <i class="fas fa-xmark"></i>
                                    @else <i class="fas fa-hourglass-half"></i>
                                    @endif
                                </div>
                                <div class="act-info">
                                    <div class="act-title">{{ $r->cafe->name ?? 'Café' }}</div>
                                    <div class="act-meta">
                                        {{ $r->guests }} tamu &middot;
                                        {{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}
                                        @if($r->user) &middot; {{ $r->user->name }} @endif
                                    </div>
                                </div>
                                <div class="act-right">
                                    <span class="status-pill {{ $r->status }}">{{ ucfirst($r->status) }}</span>
                                    <div class="act-time">{{ $r->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada aktivitas terbaru</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </main>

        {{-- Footer --}}
        <footer class="page-footer">
            <span>&copy; {{ date('Y') }} <span class="footer-brand">PLANOVA</span> — Admin Panel</span>
            <a href="{{ route('home') }}">Kembali ke Website <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
        </footer>

    </div>{{-- .main --}}
</div>{{-- .layout --}}

<script>
    function handleLogout(e) {
        if (e) e.preventDefault();
        if (confirm('Yakin ingin logout dari panel admin?')) {
            document.getElementById('logout-form')?.submit();
        }
    }

    function toggleSidebar() {
        const s = document.getElementById('sidebar');
        const o = document.getElementById('overlay');
        s.classList.toggle('open');
        o.classList.toggle('show');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
    }

    // Clock
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Date
    const dateEl = document.getElementById('date-full');
    if (dateEl) {
        dateEl.textContent = new Date().toLocaleDateString('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric'});
    }
</script>

</body>
</html>