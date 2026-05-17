<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Café — PLANOVA Admin</title>

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
            font-family:'DM Sans',sans-serif;
            background:var(--black);
            color:var(--white);
            min-height:100vh;
            overflow-x:hidden;
            line-height:1.6;
        }

        /* Noise */
        body::before {
            content:''; position:fixed; inset:0;
            background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events:none; z-index:0; opacity:0.5;
        }

        /* Ambient */
        .ambient { position:fixed; border-radius:50%; filter:blur(130px); pointer-events:none; z-index:0; }
        .amb-1 { width:420px;height:420px; background:radial-gradient(circle,rgba(92,184,92,0.08) 0%,transparent 70%); top:-100px;right:-80px; animation:drift 20s ease-in-out infinite; }
        .amb-2 { width:300px;height:300px; background:radial-gradient(circle,rgba(61,139,61,0.06) 0%,transparent 70%); bottom:-60px;left:80px; animation:drift 26s ease-in-out infinite reverse; }
        @keyframes drift { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(25px,-20px) scale(1.05)} 66%{transform:translate(-15px,15px) scale(0.95)} }

        /* ════ LAYOUT ════ */
        .layout { display:flex; min-height:100vh; position:relative; z-index:1; }

        /* ════ SIDEBAR ════ */
        .sidebar {
            width:var(--sidebar-w); flex-shrink:0;
            background:rgba(17,17,17,0.97);
            border-right:1px solid var(--border);
            display:flex; flex-direction:column;
            position:fixed; top:0;left:0;bottom:0;
            z-index:300;
            transition:transform 0.32s cubic-bezier(0.4,0,0.2,1);
            backdrop-filter:blur(20px);
        }
        .sidebar::after {
            content:''; position:absolute; top:0;right:0;
            width:1px; height:100%;
            background:linear-gradient(180deg,transparent,rgba(92,184,92,0.18) 40%,rgba(92,184,92,0.08) 70%,transparent);
        }

        .sidebar-logo { padding:26px 22px 20px; border-bottom:1px solid var(--border); }

        .logo-link { display:flex;align-items:center;gap:10px; text-decoration:none; }
        .logo-img { width:36px;height:36px; border-radius:10px; overflow:hidden; border:1.5px solid rgba(92,184,92,0.25); flex-shrink:0; }
        .logo-img img { width:100%;height:100%;object-fit:cover; }
        .logo-wordmark { font-family:'Syne',sans-serif; font-size:18px;font-weight:800;letter-spacing:1.5px;color:var(--white); }
        .logo-wordmark span { color:var(--green); }
        .logo-sub { font-size:10px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-top:5px; }

        .sidebar-nav { flex:1; padding:18px 10px; display:flex;flex-direction:column;gap:2px; overflow-y:auto; }

        .nav-section { font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted2);padding:10px 12px 5px;margin-top:6px; }

        .nav-item {
            display:flex;align-items:center;gap:10px;
            padding:10px 13px; border-radius:10px;
            text-decoration:none; color:var(--muted);
            font-size:13.5px;font-weight:500;
            transition:all 0.2s ease; border:1px solid transparent;
        }
        .nav-item i { font-size:15px;width:18px;text-align:center;flex-shrink:0; }
        .nav-item:hover { background:rgba(92,184,92,0.08);color:var(--white); }
        .nav-item.active { background:rgba(92,184,92,0.12);color:var(--green-l);border-color:var(--border-g); }

        .sidebar-footer { padding:14px 10px; border-top:1px solid var(--border); }

        .btn-logout-side {
            display:flex;align-items:center;gap:10px;
            padding:10px 13px;border-radius:10px;
            border:1px solid rgba(224,82,82,0.2);
            background:rgba(224,82,82,0.06);
            color:var(--red-l);font-size:13.5px;font-weight:500;
            cursor:pointer;width:100%;text-align:left;
            font-family:'DM Sans',sans-serif;transition:all 0.2s ease;
        }
        .btn-logout-side:hover { background:rgba(224,82,82,0.14);border-color:rgba(224,82,82,0.4); }

        /* ════ MAIN ════ */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex;flex-direction:column; min-height:100vh; }

        /* ════ TOPBAR ════ */
        .topbar {
            display:flex;align-items:center;justify-content:space-between;
            padding:16px 32px;
            background:rgba(10,10,10,0.88);
            backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
            position:sticky;top:0;z-index:100;
            gap:16px;
        }
        .topbar-left { display:flex;align-items:center;gap:14px; }

        .mobile-toggle {
            display:none; background:none;
            border:1px solid var(--border); color:var(--white);
            font-size:16px; cursor:pointer; padding:7px 9px;
            border-radius:9px; transition:all 0.2s;
        }
        .mobile-toggle:hover { border-color:var(--border-g);color:var(--green); }

        .topbar-title h1 { font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:var(--white);margin:0; }
        .topbar-title p  { font-size:12px;color:var(--muted);margin:1px 0 0; }

        .topbar-right { display:flex;align-items:center;gap:10px; }

        .clock-chip {
            display:flex;align-items:center;gap:7px;
            padding:7px 13px;
            background:rgba(255,255,255,0.04);border:1px solid var(--border);
            border-radius:9px;font-size:12.5px;color:var(--muted);
        }
        .clock-chip i { color:var(--green);font-size:13px; }

        .btn-back {
            display:flex;align-items:center;gap:7px;
            padding:9px 18px;
            background:var(--card);color:var(--muted);
            border:1px solid var(--border);border-radius:9px;
            font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;
            text-decoration:none;cursor:pointer;
            transition:all 0.25s;
        }
        .btn-back:hover { border-color:var(--border-g);color:var(--green-l);background:rgba(92,184,92,0.06); }

        .btn-save {
            display:flex;align-items:center;gap:7px;
            padding:9px 18px;
            background:var(--green);color:var(--black);
            border:none;border-radius:9px;
            font-family:'Syne',sans-serif;font-size:13px;font-weight:700;
            cursor:pointer;transition:all 0.25s;
        }
        .btn-save:hover { background:#6dcf6d;transform:translateY(-1px);box-shadow:0 8px 24px rgba(92,184,92,0.3); }

        .admin-avatar {
            width:34px;height:34px;border-radius:9px;
            background:var(--green-xd);border:1.5px solid var(--border-g);
            display:flex;align-items:center;justify-content:center;
            font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--green-l);
        }

        /* ════ PAGE BODY ════ */
        .page-body { flex:1;padding:32px;display:flex;flex-direction:column;gap:22px; }

        .page-headline { display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap; }
        .headline-eyebrow { font-size:10.5px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--green);margin-bottom:6px;display:flex;align-items:center;gap:8px; }
        .headline-eyebrow::before { content:'';width:16px;height:2px;background:var(--green);border-radius:2px; }
        .headline-title { font-family:'Syne',sans-serif;font-size:26px;font-weight:800;color:var(--white);letter-spacing:-0.3px;line-height:1.1;margin:0; }
        .headline-title span { color:var(--green); }

        /* ════ FORM CARD ════ */
        .form-card {
            background:var(--card);border:1px solid var(--border);
            border-radius:var(--radius-lg);padding:24px;
            animation:fadeUp 0.45s ease both;
        }

        .form-section { margin-bottom:28px; padding-bottom:24px; border-bottom:1px solid var(--border); }
        .form-section:last-child { border-bottom:none; margin-bottom:0; padding-bottom:0; }

        .section-title {
            font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--white);
            margin-bottom:16px;display:flex;align-items:center;gap:8px;
        }
        .section-title i { color:var(--green); }

        .form-grid { display:grid;grid-template-columns:repeat(2,1fr);gap:16px; }
        .form-grid.full { grid-template-columns:1fr; }

        .form-group { display:flex;flex-direction:column;gap:6px; }
        .form-group label {
            font-size:12.5px;font-weight:500;color:var(--muted);
            display:flex;align-items:center;gap:5px;
        }
        .form-group label .req { color:var(--red); }

        .form-control {
            width:100%;padding:11px 14px;
            background:var(--card2);border:1.5px solid var(--border);
            border-radius:var(--radius);color:var(--white);
            font-size:13.5px;font-family:'DM Sans',sans-serif;
            transition:all 0.25s;outline:none;
        }
        .form-control:hover { border-color:rgba(255,255,255,0.14); }
        .form-control:focus { border-color:var(--green);background:rgba(92,184,92,0.04);box-shadow:0 0 0 4px rgba(92,184,92,0.08); }
        .form-control::placeholder { color:var(--muted2); }
        .form-control.is-invalid { border-color:var(--red); }
        .form-control.is-invalid:focus { box-shadow:0 0 0 4px rgba(224,82,82,0.15); }

        .invalid-feedback {
            font-size:11.5px;color:var(--red-l);margin-top:4px;
            display:flex;align-items:center;gap:4px;
        }
        .invalid-feedback i { font-size:10px; }

        textarea.form-control { min-height:90px;resize:vertical; }

        .file-input-wrapper {
            position:relative;display:inline-block;width:100%;
        }
        .file-input-wrapper input[type="file"] {
            position:absolute;left:0;top:0;opacity:0;width:100%;height:100%;cursor:pointer;
        }
        .file-input-label {
            display:flex;align-items:center;justify-content:center;gap:8px;
            padding:11px 14px;
            background:var(--card2);border:1.5px dashed var(--border);
            border-radius:var(--radius);color:var(--muted);
            font-size:13px;cursor:pointer;transition:all 0.2s;
        }
        .file-input-label:hover { border-color:var(--green);color:var(--green-l);background:rgba(92,184,92,0.04); }
        .file-input-wrapper input:focus + .file-input-label { border-color:var(--green); }

        .file-preview {
            margin-top:10px;display:flex;align-items:center;gap:10px;
            padding:10px;border-radius:var(--radius);
            background:rgba(92,184,92,0.06);border:1px solid var(--border-g);
        }
        .file-preview img {
            width:50px;height:50px;border-radius:8px;object-fit:cover;
            border:1px solid var(--border);
        }
        .file-preview .file-info { flex:1; }
        .file-preview .file-name { font-size:12.5px;font-weight:500;color:var(--white); }
        .file-preview .file-size { font-size:11px;color:var(--muted); }
        .file-preview .file-remove {
            background:none;border:none;color:var(--red-l);
            cursor:pointer;font-size:14px;padding:4px;
        }

        /* ════ MENU ITEMS ════ */
        .menu-items { display:flex;flex-direction:column;gap:16px; }

        .menu-item {
            background:var(--card2);border:1px solid var(--border);
            border-radius:var(--radius);padding:18px;
            position:relative;
        }
        .menu-item-header {
            display:flex;align-items:center;justify-content:space-between;
            margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid var(--border);
        }
        .menu-item-title {
            font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--white);
            display:flex;align-items:center;gap:6px;
        }
        .menu-item-title i { color:var(--green); }

        .btn-remove-menu {
            background:rgba(224,82,82,0.1);border:1px solid rgba(224,82,82,0.25);
            color:var(--red-l);padding:6px 12px;border-radius:7px;
            font-size:11.5px;font-weight:500;cursor:pointer;
            display:flex;align-items:center;gap:5px;
            transition:all 0.2s;
        }
        .btn-remove-menu:hover { background:rgba(224,82,82,0.2);border-color:var(--red); }

        .btn-add-menu {
            display:inline-flex;align-items:center;gap:6px;
            padding:10px 16px;
            background:rgba(92,184,92,0.1);border:1px dashed var(--border-g);
            border-radius:var(--radius);color:var(--green-l);
            font-size:13px;font-weight:500;cursor:pointer;
            transition:all 0.2s;
        }
        .btn-add-menu:hover { background:rgba(92,184,92,0.18);border-style:solid; }

        /* ════ FORM ACTIONS ════ */
        .form-actions {
            display:flex;align-items:center;justify-content:flex-end;gap:12px;
            padding-top:20px;border-top:1px solid var(--border);margin-top:20px;
        }

        /* ════ FOOTER ════ */
        .page-footer {
            border-top:1px solid var(--border);padding:16px 32px;
            display:flex;align-items:center;justify-content:space-between;
            font-size:12px;color:var(--muted2);
        }
        .footer-brand { font-family:'Syne',sans-serif;font-weight:800;letter-spacing:1px;color:var(--white); }
        .page-footer a { color:var(--green);text-decoration:none;transition:color 0.2s; }
        .page-footer a:hover { color:var(--green-l); }

        /* ════ ANIMATIONS ════ */
        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
        @keyframes slideIn { from{opacity:0;transform:translateX(-10px)} to{opacity:1;transform:translateX(0)} }

        .menu-item { animation:slideIn 0.3s ease both; }

        /* ════ RESPONSIVE ════ */
        @media (max-width:900px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:translateX(0); }
            .main { margin-left:0; }
            .mobile-toggle { display:flex; }
            .page-body { padding:20px; }
            .topbar { padding:14px 20px; }
            .page-footer { padding:14px 20px;flex-direction:column;gap:8px;text-align:center; }
            .form-grid { grid-template-columns:1fr; }
            .form-actions { flex-direction:column-reverse; }
            .btn-save, .btn-back { width:100%;justify-content:center; }
        }

        /* Sidebar overlay */
        .sidebar-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,0.65);z-index:299;backdrop-filter:blur(4px); }
        .sidebar-overlay.show { display:block; }

        /* Toast */
        .toast-wrap { position:fixed;bottom:24px;right:24px;z-index:2000;display:flex;flex-direction:column;gap:8px; }
        .toast {
            display:flex;align-items:center;gap:10px;
            padding:12px 18px;background:var(--card2);
            border:1px solid var(--border);border-radius:var(--radius);
            font-size:13.5px;color:var(--white);
            box-shadow:0 8px 32px rgba(0,0,0,0.6);
            animation:toastIn 0.3s ease;
        }
        @keyframes toastIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }
        .toast.success { border-left:3px solid var(--green); }
        .toast.success i { color:var(--green-l); }
        .toast.error { border-left:3px solid var(--red); }
        .toast.error i { color:var(--red-l); }
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
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="fas fa-table-cells-large"></i> Dashboard
            </a>

            <span class="nav-section">Manajemen</span>
            <a href="{{ route('admin.cafes.index') }}" class="nav-item active">
                <i class="fas fa-store"></i> Kelola Café
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-item">
                <i class="fas fa-utensils"></i> Kelola Menu
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item">
                <i class="fas fa-calendar-check"></i> Reservasi
                @php $pending = \App\Models\Reservation::where('status','pending')->count(); @endphp
                @if($pending > 0)<span class="nav-badge">{{ $pending }}</span>@endif
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
                <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="topbar-title">
                    <h1>Tambah Café</h1>
                    <p>Input data café & menu baru</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="clock-chip">
                    <i class="fas fa-clock"></i>
                    <span id="clock">--:--</span>
                </div>
                <a href="{{ route('admin.cafes.index') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
                <div class="admin-avatar">A</div>
            </div>
        </header>

        {{-- Page body --}}
        <main class="page-body">

            {{-- Headline --}}
            <div class="page-headline">
                <div>
                    <div class="headline-eyebrow">Manajemen</div>
                    <h2 class="headline-title">Form <span>Tambah Café</span></h2>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if($errors->any())
                <div class="flash-msg" style="background:rgba(224,82,82,0.08);border-color:rgba(224,82,82,0.25);border-left-color:var(--red);color:var(--red-l);">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>Terdapat {{ $errors->count() }} kesalahan. Silakan periksa form.</span>
                    <button class="flash-close" onclick="this.parentElement.remove()"><i class="fas fa-xmark"></i></button>
                </div>
            @endif

            {{-- Form Card --}}
            <form action="{{ route('admin.cafes.store') }}" method="POST" enctype="multipart/form-data" class="form-card" id="cafeForm">
                @csrf

                {{-- Section 1: Info Café --}}
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-building"></i> Informasi Café</h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Café <span class="req">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Contoh: Ataraxia Coffee Space" required>
                            @error('name')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap <span class="req">*</span></label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                                   value="{{ old('address') }}" placeholder="Jl. Contoh No. 123, Kota" required>
                            @error('address')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group full" style="margin-top:16px;">
                        <label>Deskripsi Café <span class="req">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  placeholder="Jelaskan suasana, konsep, atau keunggulan café..." required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group" style="margin-top:16px;max-width:400px;">
                        <label>Foto Café (Opsional)</label>
                        <div class="file-input-wrapper">
                            <input type="file" name="image" id="cafeImage" class="@error('image') is-invalid @enderror" accept="image/*" onchange="previewFile(this, 'cafeImagePreview')">
                            <label for="cafeImage" class="file-input-label">
                                <i class="fas fa-cloud-arrow-up"></i> Klik atau drag file gambar
                            </label>
                        </div>
                        @error('image')<div class="invalid-feedback"><i class="fas fa-circle-exclamation"></i>{{ $message }}</div>@enderror
                        <div id="cafeImagePreview" class="file-preview" style="display:none;">
                            <img src="" alt="Preview">
                            <div class="file-info">
                                <div class="file-name"></div>
                                <div class="file-size"></div>
                            </div>
                            <button type="button" class="file-remove" onclick="removeFile('cafeImage', 'cafeImagePreview')"><i class="fas fa-xmark"></i></button>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Menu Items --}}
                <div class="form-section">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                        <h3 class="section-title" style="margin:0;"><i class="fas fa-utensils"></i> Daftar Menu</h3>
                        <button type="button" class="btn-add-menu" onclick="addMenuItem()">
                            <i class="fas fa-plus"></i> Tambah Menu
                        </button>
                    </div>

                    <div id="menusContainer" class="menu-items">
                        <!-- Menu items will be added here dynamically -->
                    </div>

                    <div id="emptyMenuMessage" style="text-align:center;padding:24px;color:var(--muted);">
                        <i class="fas fa-utensils" style="font-size:24px;margin-bottom:8px;display:block;color:var(--muted2);"></i>
                        <small>Belum ada menu. Klik "Tambah Menu" untuk menambah.</small>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-actions">
                    <a href="{{ route('admin.cafes.index') }}" class="btn-back" style="width:auto;">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-check"></i> Simpan Café & Menu
                    </button>
                </div>
            </form>

        </main>

        {{-- Footer --}}
        <footer class="page-footer">
            <span>&copy; {{ date('Y') }} <span class="footer-brand">PLANOVA</span> — Admin Panel</span>
            <a href="{{ route('home') }}">Kembali ke Website <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
        </footer>
    </div>
</div>

{{-- Toast Container --}}
<div class="toast-wrap" id="toastWrap"></div>

<script>
    // ===== Logout =====
    function handleLogout(e) {
        if (e) e.preventDefault();
        if (confirm('Yakin ingin logout dari panel admin?')) document.getElementById('logout-form')?.submit();
    }

    // ===== Sidebar Toggle =====
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
    }

    // ===== Clock =====
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
    }
    updateClock(); setInterval(updateClock, 1000);

    // ===== File Preview =====
    function previewFile(input, previewId) {
        const file = input.files[0];
        if (!file) return;

        const preview = document.getElementById(previewId);
        const img = preview.querySelector('img');
        const nameEl = preview.querySelector('.file-name');
        const sizeEl = preview.querySelector('.file-size');

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }

        nameEl.textContent = file.name;
        sizeEl.textContent = formatFileSize(file.size);
    }

    function removeFile(inputId, previewId) {
        document.getElementById(inputId).value = '';
        document.getElementById(previewId).style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // ===== Dynamic Menu Items =====
    let menuIndex = 0;

    function addMenuItem() {
        document.getElementById('emptyMenuMessage').style.display = 'none';
        
        const container = document.getElementById('menusContainer');
        const menuHtml = `
            <div class="menu-item" id="menu-${menuIndex}" data-index="${menuIndex}">
                <div class="menu-item-header">
                    <div class="menu-item-title">
                        <i class="fas fa-utensils"></i> Menu #${menuIndex + 1}
                    </div>
                    <button type="button" class="btn-remove-menu" onclick="removeMenuItem(${menuIndex})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Menu <span class="req">*</span></label>
                        <input type="text" name="menus[${menuIndex}][name]" class="form-control" 
                               placeholder="Contoh: Espresso" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori <span class="req">*</span></label>
                        <select name="menus[${menuIndex}][category]" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="snack">Snack</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp) <span class="req">*</span></label>
                        <input type="number" name="menus[${menuIndex}][price]" class="form-control" 
                               placeholder="15000" min="0" required>
                    </div>
                </div>
                
                <div class="form-group full" style="margin-top:12px;">
                    <label>Deskripsi (Opsional)</label>
                    <textarea name="menus[${menuIndex}][description]" class="form-control" 
                              rows="2" placeholder="Deskripsi menu..."></textarea>
                </div>
                
                <div class="form-group" style="margin-top:12px;max-width:400px;">
                    <label>Foto Menu (Opsional)</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="menus[${menuIndex}][image]" class="form-control-file" 
                               accept="image/*" onchange="previewFile(this, 'menuPreview-${menuIndex}')">
                        <label class="file-input-label">
                            <i class="fas fa-cloud-arrow-up"></i> Upload foto
                        </label>
                    </div>
                    <div id="menuPreview-${menuIndex}" class="file-preview" style="display:none;">
                        <img src="" alt="Preview">
                        <div class="file-info">
                            <div class="file-name"></div>
                            <div class="file-size"></div>
                        </div>
                        <button type="button" class="file-remove" onclick="removeFile('menus[${menuIndex}][image]', 'menuPreview-${menuIndex}')"><i class="fas fa-xmark"></i></button>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', menuHtml);
        menuIndex++;
    }

    function removeMenuItem(index) {
        const menuElement = document.getElementById(`menu-${index}`);
        menuElement.style.opacity = '0';
        menuElement.style.transform = 'translateX(-10px)';
        setTimeout(() => {
            menuElement.remove();
            if (document.querySelectorAll('.menu-item').length === 0) {
                document.getElementById('emptyMenuMessage').style.display = 'block';
            }
        }, 200);
    }

    // ===== Toast Notification =====
    function showToast(type, msg) {
        const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.innerHTML = `<i class="fas ${icon}"></i><span>${msg}</span>`;
        document.getElementById('toastWrap').appendChild(el);
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateX(20px)';
            setTimeout(() => el.remove(), 300);
        }, 4000);
    }

    // ===== Form Validation Feedback =====
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-show toast if there are errors
        @if($errors->any())
            showToast('error', 'Periksa kembali form yang belum lengkap');
        @endif

        // Auto-show success toast from session
        @if(session('success'))
            showToast('success', "{{ session('success') }}");
        @endif
    });

    // ===== Confirm before submit =====
    document.getElementById('cafeForm')?.addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
</script>
</body>
</html>