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
            gap: 10px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
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
        }

        @media (max-width: 560px) {
            .current-image-box { flex-wrap: wrap; }
            .form-actions { flex-direction: column-reverse; }
            .btn-cancel { text-align: center; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
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

                    <div class="section-card">

                        {{-- Card head --}}
                        <div class="section-head">
                            <div class="section-head-icon"><i class="bi bi-pencil-square"></i></div>
                            <h2>Informasi Cafe</h2>
                        </div>

                        {{-- Fields --}}
                        <div class="form-body">

                            {{-- Nama --}}
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    <i class="bi bi-signpost-2"></i>
                                    Nama Cafe
                                    <span class="required" aria-hidden="true">*</span>
                                    <span class="sr-only">Wajib diisi</span>
                                </label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $cafe->name) }}"
                                       placeholder="Contoh: Kopi Senja Nusantara"
                                       required>
                                @error('name')
                                    <span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="form-group">
                                <label class="form-label" for="address">
                                    <i class="bi bi-geo-alt"></i>
                                    Alamat Lengkap
                                    <span class="required" aria-hidden="true">*</span>
                                </label>
                                <input type="text" name="address" id="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $cafe->address) }}"
                                       placeholder="Jl. Contoh No. 123, Kecamatan, Kota"
                                       required>
                                @error('address')
                                    <span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="form-group">
                                <label class="form-label" for="description">
                                    <i class="bi bi-card-text"></i>
                                    Deskripsi Cafe
                                    <span class="required" aria-hidden="true">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Jelaskan suasana, konsep, menu unggulan, atau keunggulan cafe..."
                                          required>{{ old('description', $cafe->description) }}</textarea>
                                <span class="form-hint">
                                    <i class="bi bi-info-circle"></i>
                                    Minimal 20 karakter untuk deskripsi yang baik.
                                </span>
                                @error('description')
                                    <span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Current image --}}
                            @if($cafe->image)
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="bi bi-image"></i>
                                    Foto Saat Ini
                                </label>
                                <div class="current-image-box">
                                    <img src="{{ asset('storage/' . $cafe->image) }}" alt="{{ $cafe->name }}">
                                    <div class="current-image-info">
                                        <p>{{ pathinfo($cafe->image, PATHINFO_BASENAME) }}</p>
                                        <small>{{ number_format(filesize(storage_path('app/public/' . $cafe->image)) / 1024, 1) }} KB</small>
                                    </div>
                                    <span class="keep-badge">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Akan dipertahankan
                                    </span>
                                </div>
                            </div>
                            @endif

                            {{-- Upload new photo --}}
                            <div class="form-group">
                                <label class="form-label" for="image">
                                    <i class="bi bi-upload"></i>
                                    Ganti Foto Cafe
                                    <span class="optional">(Opsional)</span>
                                </label>
                                <div class="file-upload-zone" id="uploadZone">
                                    <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                                    <div class="upload-label">Klik atau seret file ke sini</div>
                                    <div class="upload-hint">JPG / PNG · Maks. 2 MB · Kosongkan jika tidak ingin mengganti</div>
                                    <input type="file" name="image" id="image"
                                           class="@error('image') is-invalid @enderror"
                                           accept="image/jpeg,image/png,image/jpg"
                                           aria-label="Upload foto cafe baru">
                                </div>
                                <div class="file-preview" id="filePreview">
                                    <img id="previewImg" src="" alt="Preview">
                                    <span class="file-preview-name" id="fileName"></span>
                                    <button type="button" class="file-remove" id="removeFile" title="Batal">
                                        <i class="bi bi-x-circle-fill"></i>
                                    </button>
                                </div>
                                @error('image')
                                    <span class="invalid-feedback"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                                @enderror
                            </div>

                        </div>{{-- end .form-body --}}

                        {{-- Actions --}}
                        <div class="form-actions">
                            <a href="{{ route('admin.cafes.index') }}" class="btn-cancel">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit" id="submitBtn">
                                <i class="bi bi-check-lg" id="btnIcon"></i>
                                <span id="btnText">Simpan Perubahan</span>
                            </button>
                        </div>

                    </div>{{-- end .section-card --}}
                </form>

            </div>{{-- end .form-wrapper --}}
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

    // File upload
    const fileInput   = document.getElementById('image');
    const uploadZone  = document.getElementById('uploadZone');
    const filePreview = document.getElementById('filePreview');
    const previewImg  = document.getElementById('previewImg');
    const fileName    = document.getElementById('fileName');
    const removeFile  = document.getElementById('removeFile');

    function resetUpload() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        previewImg.src = '';
        uploadZone.classList.remove('dragover');
    }

    fileInput?.addEventListener('change', function() {
        const file = this.files[0];
        if (!file) return;
        if (!['image/jpeg','image/png','image/jpg'].includes(file.type)) {
            alert('Format tidak didukung. Gunakan JPG atau PNG.');
            return resetUpload();
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB.');
            return resetUpload();
        }
        fileName.textContent = file.name;
        const reader = new FileReader();
        reader.onload = e => { previewImg.src = e.target.result; };
        reader.readAsDataURL(file);
        filePreview.classList.add('show');
    });

    removeFile?.addEventListener('click', resetUpload);

    ['dragenter','dragover'].forEach(ev => {
        uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
    });
    ['dragleave','drop'].forEach(ev => {
        uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.remove('dragover'); });
    });
    uploadZone?.addEventListener('drop', e => {
        const files = e.dataTransfer.files;
        if (files?.length) { fileInput.files = files; fileInput.dispatchEvent(new Event('change')); }
    });

    // Form submit
    const form      = document.getElementById('cafeForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText   = document.getElementById('btnText');
    const btnIcon   = document.getElementById('btnIcon');

    form?.addEventListener('submit', function(e) {
        let valid = true;
        this.querySelectorAll('[required]').forEach(f => {
            if (!f.value.trim()) {
                valid = false;
                f.classList.add('is-invalid');
                if (valid === false && document.activeElement !== f) f.focus();
            } else {
                f.classList.remove('is-invalid');
            }
        });
        if (!valid) { e.preventDefault(); return; }
        submitBtn.disabled = true;
        if (btnText) btnText.textContent = 'Menyimpan...';
        if (btnIcon) { btnIcon.className = 'bi bi-hourglass-split'; btnIcon.style.animation = 'spin 1s linear infinite'; }
    });

    document.querySelectorAll('.form-control[required]').forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.toggle('is-invalid', !this.value.trim());
        });
        input.addEventListener('input', function() {
            if (this.value.trim()) this.classList.remove('is-invalid');
        });
    });
</script>
</body>
</html>