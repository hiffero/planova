<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Cafe — PLANOVA Admin</title>

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
            cursor: pointer;
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
            align-items: center;
        }

        /* ── FORM WRAPPER ── */
        .form-wrapper {
            width: 100%;
            max-width: 720px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── INFO BOX ── */
        .info-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            background: rgba(74,140,64,0.08);
            border: 1px solid var(--border-green);
            border-left: 3px solid var(--green-accent);
            border-radius: 12px;
            font-size: 0.85rem;
            color: var(--gray-light);
        }

        .info-box i {
            color: var(--green-accent);
            font-size: 1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

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

        .btn-add-menu {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(74,140,64,0.12);
            border: 1px solid var(--border-green);
            border-radius: 8px;
            color: var(--green-accent);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-add-menu:hover {
            background: rgba(74,140,64,0.2);
            border-color: var(--green-bright);
        }

        .form-body {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ── FORM ELEMENTS ── */
        .form-group { display: flex; flex-direction: column; gap: 8px; }

        .form-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--gray-light);
            letter-spacing: 0.03em;
        }

        .form-label i { color: var(--green-accent); font-size: 0.85rem; }

        .required { color: var(--red); margin-left: 2px; }

        .optional {
            font-size: 0.74rem;
            font-weight: 400;
            color: var(--gray);
            margin-left: 4px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--white);
            font-size: 0.88rem;
            font-family: "DM Sans", sans-serif;
            transition: border-color 0.2s, background 0.2s;
        }

        .form-control::placeholder { color: var(--gray); }

        .form-control:focus {
            outline: none;
            border-color: var(--green-bright);
            background: rgba(74,140,64,0.05);
        }

        .form-control.is-invalid {
            border-color: var(--red);
            background: rgba(224,82,82,0.06);
        }

        textarea.form-control {
            min-height: 110px;
            resize: vertical;
        }

        .form-hint {
            font-size: 0.76rem;
            color: var(--gray);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint i { font-size: 0.72rem; }

        .invalid-feedback {
            font-size: 0.78rem;
            color: #ff7b7b;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── CURRENT IMAGE ── */
        .current-image-box {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            background: rgba(74,140,64,0.06);
            border: 1px solid var(--border-green);
            border-radius: 12px;
        }

        .current-image-box img {
            width: 56px; height: 56px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border-green);
            flex-shrink: 0;
        }

        .current-image-info { flex: 1; min-width: 0; }

        .current-image-info p {
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--white);
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .current-image-info small {
            font-size: 0.76rem;
            color: var(--gray);
        }

        .keep-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: rgba(74,140,64,0.12);
            border: 1px solid var(--border-green);
            border-radius: 50px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--green-accent);
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* ── FILE UPLOAD ── */
        .file-upload-zone {
            position: relative;
            border: 1px dashed rgba(255,255,255,0.15);
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgba(255,255,255,0.02);
        }

        .file-upload-zone:hover,
        .file-upload-zone.dragover {
            border-color: var(--green-bright);
            background: rgba(74,140,64,0.07);
        }

        .file-upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            background: rgba(74,140,64,0.12);
            border: 1px solid var(--border-green);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.2rem;
            color: var(--green-accent);
            transition: transform 0.2s;
        }

        .file-upload-zone:hover .upload-icon { transform: scale(1.08); }

        .upload-label {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 4px;
        }

        .upload-hint {
            font-size: 0.78rem;
            color: var(--gray);
        }

        /* File preview strip */
        .file-preview {
            display: none;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: rgba(74,140,64,0.08);
            border: 1px solid var(--border-green);
            border-radius: 10px;
            margin-top: 10px;
        }

        .file-preview.show { display: flex; }

        .file-preview img {
            width: 40px; height: 40px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-green);
            flex-shrink: 0;
        }

        .file-preview-name {
            flex: 1;
            font-size: 0.82rem;
            color: var(--green-accent);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-remove {
            background: none;
            border: none;
            color: var(--red);
            cursor: pointer;
            font-size: 1rem;
            padding: 2px 4px;
            border-radius: 6px;
            transition: background 0.2s;
            flex-shrink: 0;
        }

        .file-remove:hover { background: rgba(224,82,82,0.15); }

        /* ── MENU ITEMS ── */
        .menu-items {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .menu-item {
            background: var(--card-hover);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            position: relative;
            animation: slideIn 0.3s ease both;
        }

        .menu-item.existing {
            border-left: 3px solid var(--green-accent);
        }

        .menu-item.new {
            border-left: 3px solid var(--amber);
        }

        .menu-item-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        .menu-item-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--white);
        }

        .menu-item-title i { color: var(--green-accent); }

        .menu-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(74,140,64,0.15);
            color: var(--green-accent);
            border: 1px solid var(--border-green);
        }

        .menu-badge.new {
            background: rgba(245,166,35,0.15);
            color: var(--amber);
            border-color: rgba(245,166,35,0.3);
        }

        .btn-remove-menu {
            background: rgba(224,82,82,0.1);
            border: 1px solid rgba(224,82,82,0.25);
            color: var(--red);
            padding: 6px 12px;
            border-radius: 7px;
            font-size: 0.78rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }

        .btn-remove-menu:hover {
            background: rgba(224,82,82,0.2);
            border-color: var(--red);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .menu-grid .form-group.full {
            grid-column: 1 / -1;
        }

        .menu-current-image {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: rgba(74,140,64,0.06);
            border: 1px solid var(--border-green);
            border-radius: 8px;
            margin-top: 8px;
        }

        .menu-current-image img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border-green);
        }

        .menu-current-image span {
            font-size: 0.76rem;
            color: var(--gray);
        }

        /* ── FORM ACTIONS ── */
        .form-actions {
            display: flex;
            gap: 10px;
            padding: 20px 24px;
            border-top: 1px solid var(--border);
        }

        .btn-submit {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--green-bright);
            border: none;
            border-radius: 10px;
            color: var(--white);
            font-size: 0.9rem;
            font-weight: 600;
            font-family: "DM Sans", sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: var(--green-accent);
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-cancel {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--gray-light);
            font-size: 0.9rem;
            font-weight: 500;
            font-family: "DM Sans", sans-serif;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: rgba(255,255,255,0.07);
            color: var(--white);
            border-color: rgba(255,255,255,0.15);
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
            .menu-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 560px) {
            .current-image-box { flex-wrap: wrap; }
            .form-actions { flex-direction: column-reverse; }
            .btn-cancel { text-align: center; }
            .menu-item-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .sr-only {
            position: absolute; width: 1px; height: 1px;
            padding: 0; margin: -1px; overflow: hidden;
            clip: rect(0,0,0,0); white-space: nowrap; border: 0;
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
            <a href="{{ route('admin.cafes.index') }}" class="nav-item active">
                <i class="bi bi-building"></i> Kelola Cafe
            </a>
            <a href="{{ route('admin.menus.index') }}" class="nav-item">
                <i class="bi bi-menu-button-wide"></i> Kelola Menu
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item">
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
                    <h1>Edit Cafe</h1>
                    <p>Memperbarui informasi <strong style="color:var(--green-accent);">{{ $cafe->name }}</strong></p>
                </div>
            </div>
            <div class="topbar-right">
                <span class="topbar-time">
                    <i class="bi bi-clock"></i>
                    <span id="clock">--:--</span>
                </span>
                <a href="{{ route('admin.cafes.index') }}" class="btn-topbar">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="avatar">A</div>
            </div>
        </header>

        {{-- ── PAGE BODY ── --}}
        <main class="page-body">
            <div class="form-wrapper">

                {{-- Info tip --}}
                <div class="info-box">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>Biarkan field foto kosong jika tidak ingin mengubah gambar. Foto saat ini akan tetap digunakan.</span>
                </div>

                {{-- Form card --}}
                <form action="{{ route('admin.cafes.update', $cafe) }}" method="POST"
                      enctype="multipart/form-data" id="cafeForm" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Section 1: Cafe Info --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-left">
                                <div class="section-head-icon"><i class="bi bi-pencil-square"></i></div>
                                <h2>Informasi Cafe</h2>
                            </div>
                        </div>

                        <div class="form-body">
                            {{-- Nama --}}
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    <i class="bi bi-signpost-2"></i>
                                    Nama Cafe <span class="required">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $cafe->name) }}"
                                       placeholder="Contoh: Kopi Senja Nusantara" required>
                                @error('name')<span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label class="form-label" for="address">
                                    <i class="bi bi-geo-alt"></i>
                                    Alamat Lengkap <span class="required">*</span>
                                </label>
                                <input type="text" name="address" id="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $cafe->address) }}"
                                       placeholder="Jl. Contoh No. 123, Kecamatan, Kota" required>
                                @error('address')<span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="form-group">
                                <label class="form-label" for="description">
                                    <i class="bi bi-card-text"></i>
                                    Deskripsi Cafe <span class="required">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Jelaskan suasana, konsep, menu unggulan..." required>{{ old('description', $cafe->description) }}</textarea>
                                @error('description')<span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>

                            {{-- Current Image --}}
                            @if($cafe->image)
                            <div class="form-group">
                                <label class="form-label"><i class="bi bi-image"></i> Foto Saat Ini</label>
                                <div class="current-image-box">
                                    <img src="{{ asset('storage/' . $cafe->image) }}" alt="{{ $cafe->name }}">
                                    <div class="current-image-info">
                                        <p>{{ pathinfo($cafe->image, PATHINFO_BASENAME) }}</p>
                                        <small>{{ number_format(filesize(storage_path('app/public/' . $cafe->image)) / 1024, 1) }} KB</small>
                                    </div>
                                    <span class="keep-badge"><i class="bi bi-check-circle-fill"></i> Akan dipertahankan</span>
                                </div>
                            </div>
                            @endif

                            {{-- Upload New Photo --}}
                            <div class="form-group">
                                <label class="form-label" for="image">
                                    <i class="bi bi-upload"></i> Ganti Foto Cafe <span class="optional">(Opsional)</span>
                                </label>
                                <div class="file-upload-zone" id="uploadZone">
                                    <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                                    <div class="upload-label">Klik atau seret file ke sini</div>
                                    <div class="upload-hint">JPG / PNG · Maks. 2 MB · Kosongkan jika tidak ingin mengganti</div>
                                    <input type="file" name="image" id="image"
                                           class="@error('image') is-invalid @enderror"
                                           accept="image/jpeg,image/png,image/jpg">
                                </div>
                                <div class="file-preview" id="filePreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <span class="file-preview-name" id="fileName"></span>
                                    <button type="button" class="file-remove" id="removeFile"><i class="bi bi-x-circle-fill"></i></button>
                                </div>
                                @error('image')<span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Menu Management --}}
                    <div class="section-card">
                        <div class="section-head">
                            <div class="section-head-left">
                                <div class="section-head-icon"><i class="bi bi-utensils"></i></div>
                                <h2>Kelola Menu</h2>
                            </div>
                            <button type="button" class="btn-add-menu" onclick="addNewMenuItem()">
                                <i class="bi bi-plus-lg"></i> Tambah Menu Baru
                            </button>
                        </div>

                        <div class="form-body">
                            <div id="menusContainer" class="menu-items">
                                
                                {{-- Existing Menus --}}
                                @foreach($cafe->menus as $index => $menu)
                                <div class="menu-item existing" id="menu-existing-{{ $menu->id }}">
                                    <div class="menu-item-header">
                                        <div class="menu-item-title">
                                            <i class="bi bi-cup-hot"></i>
                                            <span>{{ $menu->name }}</span>
                                            <span class="menu-badge">Existing</span>
                                        </div>
                                        <button type="button" class="btn-remove-menu" onclick="removeMenuItem('existing-{{ $menu->id }}', true)">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </div>

                                    <input type="hidden" name="menus[existing][{{ $menu->id }}][id]" value="{{ $menu->id }}">
                                    
                                    <div class="menu-grid">
                                        <div class="form-group">
                                            <label class="form-label">Nama Menu <span class="required">*</span></label>
                                            <input type="text" name="menus[existing][{{ $menu->id }}][name]" 
                                                   class="form-control" value="{{ old("menus.existing.$menu->id.name", $menu->name) }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Kategori <span class="required">*</span></label>
                                            <select name="menus[existing][{{ $menu->id }}][category]" class="form-control" required>
                                                <option value="">Pilih</option>
                                                <option value="makanan" {{ old("menus.existing.$menu->id.category", $menu->category) == 'makanan' ? 'selected' : '' }}>Makanan</option>
                                                <option value="minuman" {{ old("menus.existing.$menu->id.category", $menu->category) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                                <option value="snack" {{ old("menus.existing.$menu->id.category", $menu->category) == 'snack' ? 'selected' : '' }}>Snack</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                                            <input type="number" name="menus[existing][{{ $menu->id }}][price]" 
                                                   class="form-control" value="{{ old("menus.existing.$menu->id.price", $menu->price) }}" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group full">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="menus[existing][{{ $menu->id }}][description]" class="form-control" rows="2">{{ old("menus.existing.$menu->id.description", $menu->description) }}</textarea>
                                    </div>

                                    @if($menu->image)
                                    <div class="form-group">
                                        <label class="form-label">Foto Saat Ini</label>
                                        <div class="menu-current-image">
                                            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}">
                                            <span>{{ pathinfo($menu->image, PATHINFO_BASENAME) }}</span>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label class="form-label">Ganti Foto <span class="optional">(Opsional)</span></label>
                                        <div class="file-upload-zone" id="menuUpload-{{ $menu->id }}">
                                            <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                                            <div class="upload-label">Upload foto baru</div>
                                            <input type="file" name="menus[existing][{{ $menu->id }}][image]" 
                                                   accept="image/*" onchange="previewMenuFile(this, 'menuPreview-{{ $menu->id }}')">
                                        </div>
                                        <div class="file-preview" id="menuPreview-{{ $menu->id }}">
                                            <img src="" alt="Preview">
                                            <span class="file-preview-name"></span>
                                            <button type="button" class="file-remove" onclick="removeFile('menus[existing][{{ $menu->id }}][image]', 'menuPreview-{{ $menu->id }}')"><i class="bi bi-x-circle-fill"></i></button>
                                        </div>
                                    </div>

                                    {{-- Hidden input untuk delete --}}
                                    <input type="hidden" name="menus[existing][{{ $menu->id }}][_delete]" id="delete-existing-{{ $menu->id }}" value="0">
                                </div>
                                @endforeach

                                {{-- New Menus Container --}}
                                <div id="newMenusContainer"></div>

                            </div>

                            {{-- Empty State --}}
                            @if($cafe->menus->count() === 0)
                            <div id="emptyMenuMessage" style="text-align:center;padding:24px;color:var(--gray);">
                                <i class="bi bi-utensils" style="font-size:2rem;margin-bottom:8px;display:block;color:var(--gray);"></i>
                                <small>Belum ada menu. Klik "Tambah Menu Baru" untuk menambah.</small>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="form-actions">
                        <a href="{{ route('admin.cafes.index') }}" class="btn-cancel">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="bi bi-check-lg" id="btnIcon"></i>
                            <span id="btnText">Simpan Perubahan</span>
                        </button>
                    </div>

                </form>

            </div>
        </main>

        {{-- ── FOOTER ── --}}
        <footer class="page-footer">
            <span>&copy; {{ date('Y') }} PLANOVA — Admin Panel</span>
            <a href="{{ route('home') }}">Kembali ke Website &rarr;</a>
        </footer>

    </div>

</div>

<script>
    // ===== Logout =====
    function handleLogout(e) {
        if (e) e.preventDefault();
        if (confirm('Yakin ingin logout dari panel admin?')) {
            document.getElementById('logout-form')?.submit();
        }
    }

    // ===== Sidebar Toggle =====
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && toggle && !toggle.contains(e.target)) {
            sidebar.classList.remove('open');
        }
    });

    // ===== Clock =====
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ===== File Upload Helpers =====
    function resetUpload(inputId, previewId) {
        document.getElementById(inputId).value = '';
        document.getElementById(previewId).classList.remove('show');
        document.getElementById(previewId).querySelector('img').src = '';
    }

    function previewFile(input, previewId) {
        const file = input.files[0];
        if (!file) return;
        if (!['image/jpeg','image/png','image/jpg'].includes(file.type)) {
            alert('Format tidak didukung. Gunakan JPG atau PNG.');
            return resetUpload(input.id, previewId);
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB.');
            return resetUpload(input.id, previewId);
        }
        const preview = document.getElementById(previewId);
        const img = preview.querySelector('img');
        const nameEl = preview.querySelector('.file-preview-name');
        nameEl.textContent = file.name;
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; };
        reader.readAsDataURL(file);
        preview.classList.add('show');
    }

    function removeFile(inputName, previewId) {
        const input = document.querySelector(`[name="${inputName}"]`);
        if (input) input.value = '';
        document.getElementById(previewId).classList.remove('show');
    }

    // ===== Menu Management =====
    let newMenuIndex = 0;

    function addNewMenuItem() {
        document.getElementById('emptyMenuMessage')?.style.setProperty('display', 'none');
        
        const container = document.getElementById('newMenusContainer');
        const menuHtml = `
            <div class="menu-item new" id="menu-new-${newMenuIndex}">
                <div class="menu-item-header">
                    <div class="menu-item-title">
                        <i class="bi bi-plus-circle"></i>
                        <span>Menu Baru #${newMenuIndex + 1}</span>
                        <span class="menu-badge new">New</span>
                    </div>
                    <button type="button" class="btn-remove-menu" onclick="removeNewMenuItem(${newMenuIndex})">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </div>

                <input type="hidden" name="menus[new][${newMenuIndex}][_new]" value="1">
                
                <div class="menu-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Menu <span class="required">*</span></label>
                        <input type="text" name="menus[new][${newMenuIndex}][name]" class="form-control" placeholder="Contoh: Espresso" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span class="required">*</span></label>
                        <select name="menus[new][${newMenuIndex}][category]" class="form-control" required>
                            <option value="">Pilih</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="snack">Snack</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="menus[new][${newMenuIndex}][price]" class="form-control" placeholder="15000" min="0" required>
                    </div>
                </div>
                
                <div class="form-group full">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="menus[new][${newMenuIndex}][description]" class="form-control" rows="2" placeholder="Deskripsi menu..."></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Foto Menu <span class="optional">(Opsional)</span></label>
                    <div class="file-upload-zone">
                        <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                        <div class="upload-label">Upload foto</div>
                        <input type="file" name="menus[new][${newMenuIndex}][image]" accept="image/*" onchange="previewFile(this, 'menuPreview-new-${newMenuIndex}')">
                    </div>
                    <div class="file-preview" id="menuPreview-new-${newMenuIndex}">
                        <img src="" alt="Preview">
                        <span class="file-preview-name"></span>
                        <button type="button" class="file-remove" onclick="removeFile('menus[new][${newMenuIndex}][image]', 'menuPreview-new-${newMenuIndex}')"><i class="bi bi-x-circle-fill"></i></button>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', menuHtml);
        newMenuIndex++;
    }

    function removeMenuItem(menuId, isExisting) {
        if (!confirm('Yakin ingin menghapus menu ini?')) return;
        
        if (isExisting) {
            // Mark for deletion instead of removing from DOM
            document.getElementById(`delete-${menuId}`).value = '1';
            const item = document.getElementById(`menu-${menuId}`);
            item.style.opacity = '0.5';
            item.style.pointerEvents = 'none';
            item.querySelector('.menu-item-title span:last-child').textContent = 'Akan Dihapus';
            item.querySelector('.menu-item-title span:last-child').style.background = 'rgba(224,82,82,0.2)';
            item.querySelector('.menu-item-title span:last-child').style.color = '#ff7b7b';
            item.querySelector('.btn-remove-menu').style.display = 'none';
        } else {
            document.getElementById(`menu-${menuId}`)?.remove();
            if (!document.querySelectorAll('.menu-item:not([style*="opacity: 0.5"])').length) {
                document.getElementById('emptyMenuMessage')?.style.setProperty('display', 'block');
            }
        }
    }

    function removeNewMenuItem(index) {
        document.getElementById(`menu-new-${index}`)?.remove();
        if (!document.getElementById('newMenusContainer').children.length && 
            !document.querySelectorAll('.menu-item.existing:not([style*="opacity: 0.5"])').length) {
            document.getElementById('emptyMenuMessage')?.style.setProperty('display', 'block');
        }
    }

    // ===== Form Submit =====
    const form = document.getElementById('cafeForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');

    form?.addEventListener('submit', function(e) {
        let valid = true;
        this.querySelectorAll('[required]').forEach(f => {
            if (!f.value.trim()) {
                valid = false;
                f.classList.add('is-invalid');
            } else {
                f.classList.remove('is-invalid');
            }
        });
        if (!valid) { e.preventDefault(); return; }
        
        submitBtn.disabled = true;
        if (btnText) btnText.textContent = 'Menyimpan...';
        if (btnIcon) { 
            btnIcon.className = 'bi bi-hourglass-split'; 
            btnIcon.style.animation = 'spin 1s linear infinite'; 
        }
    });

    // ===== Real-time Validation =====
    document.querySelectorAll('.form-control[required]').forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.toggle('is-invalid', !this.value.trim());
        });
        input.addEventListener('input', function() {
            if (this.value.trim()) this.classList.remove('is-invalid');
        });
    });

    // ===== Drag & Drop for Cafe Image =====
    const uploadZone = document.getElementById('uploadZone');
    ['dragenter','dragover'].forEach(ev => {
        uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
    });
    ['dragleave','drop'].forEach(ev => {
        uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.remove('dragover'); });
    });
    uploadZone?.addEventListener('drop', e => {
        const files = e.dataTransfer.files;
        if (files?.length) { 
            document.getElementById('image').files = files; 
            document.getElementById('image').dispatchEvent(new Event('change')); 
        }
    });

    // ===== Init =====
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide empty message if there are menus
        if (document.querySelectorAll('.menu-item').length > 0) {
            document.getElementById('emptyMenuMessage')?.style.setProperty('display', 'none');
        }
    });
</script>
</body>
</html>