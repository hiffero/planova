<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Reservasi - PLANOVA</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ═══ TOKENS ═══ */
        :root {
            --black:  #0a0a0a;
            --ink:    #111111;
            --dark:   #1a1a1a;
            --card:   #161616;
            --border: rgba(255,255,255,0.07);
            --border-hover: rgba(92,184,92,0.4);
            --green:  #5cb85c;
            --green-d:#3d8b3d;
            --green-l:#8edb8e;
            --green-xd:#1f4d1f;
            --glow:   rgba(92,184,92,0.15);
            --white:  #ffffff;
            --offwhite: #f4f4f4;
            --muted:  #888888;
            --muted2: #555555;
            --radius: 14px;
            --radius-lg: 22px;
        }

        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.65;
        }

        /* ── Noise texture overlay ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ── Green ambient glow ── */
        .ambient {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
        }
        .ambient-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(92,184,92,0.12) 0%, transparent 70%);
            top: -150px; right: -100px;
            animation: drift 18s ease-in-out infinite;
        }
        .ambient-2 {
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(61,139,61,0.08) 0%, transparent 70%);
            bottom: -80px; left: -80px;
            animation: drift 22s ease-in-out infinite reverse;
        }
        @keyframes drift {
            0%,100% { transform: translate(0,0) scale(1); }
            33%  { transform: translate(30px,-25px) scale(1.06); }
            66%  { transform: translate(-20px,18px) scale(0.94); }
        }

        /* ════ NAVBAR ════ */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(10,10,10,0.85);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-back {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.25s;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-back:hover { border-color: var(--border-hover); color: var(--white); background: rgba(255,255,255,0.04); }

        .nav-history {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            background: rgba(92,184,92,0.08);
            border: 1px solid rgba(92,184,92,0.2);
            border-radius: 10px;
            color: var(--green-l);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
        }
        .nav-history:hover { background: rgba(92,184,92,0.14); border-color: rgba(92,184,92,0.4); color: var(--green); }

        .topbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 2px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .topbar-brand .brand-white { color: var(--white); }
        .topbar-brand .brand-green { color: var(--green); }

        .nav-logout {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            text-decoration: none;
            transition: all 0.25s;
        }
        .nav-logout:hover { border-color: rgba(239,68,68,0.4); color: #fc8181; background: rgba(239,68,68,0.06); }

        /* ════ PAGE LAYOUT ════ */
        .page-wrap {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 520px 1fr;
            gap: 0;
            min-height: calc(100vh - 62px);
            padding: 48px 24px 80px;
        }

        .page-center { grid-column: 2; }

        /* ════ FORM CARD ════ */
        .form-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0,0,0,0.6), 0 0 0 1px rgba(255,255,255,0.04) inset;
            animation: riseUp 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes riseUp {
            from { opacity:0; transform: translateY(40px) scale(0.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* Card header */
        .card-head {
            position: relative;
            padding: 40px 40px 32px;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
        }

        .card-head::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 80% 0%, rgba(92,184,92,0.12) 0%, transparent 60%),
                linear-gradient(180deg, rgba(92,184,92,0.04) 0%, transparent 100%);
        }

        /* Decorative corner accent */
        .card-head::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 180px; height: 180px;
            background: conic-gradient(from 210deg at 100% 0%, rgba(92,184,92,0.12), transparent 40%);
            pointer-events: none;
        }

        .head-tag {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 13px;
            background: rgba(92,184,92,0.1);
            border: 1px solid rgba(92,184,92,0.25);
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }
        .head-tag i { font-size: 12px; }

        .card-head h1 {
            position: relative;
            z-index: 1;
            font-family: 'Syne', sans-serif;
            font-size: 30px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        .card-head h1 span { color: var(--green); }

        .card-head p {
            position: relative;
            z-index: 1;
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* Card body */
        .card-body { padding: 36px 40px 40px; }

        /* ════ ALERTS ════ */
        .pv-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 24px;
            line-height: 1.5;
            animation: slideAlert 0.3s ease;
        }
        @keyframes slideAlert {
            from { opacity:0; transform: translateY(-8px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .pv-alert-success {
            background: rgba(92,184,92,0.08);
            border: 1px solid rgba(92,184,92,0.25);
            color: var(--green-l);
        }
        .pv-alert-error {
            background: rgba(239,68,68,0.07);
            border: 1px solid rgba(239,68,68,0.2);
            color: #fc8181;
        }
        .pv-alert i { flex-shrink:0; font-size:16px; margin-top:1px; }
        .pv-alert ul { margin:6px 0 0 4px; padding-left:14px; }
        .pv-alert ul li { margin-bottom:2px; font-size:13px; }

        /* ════ USER STATUS ════ */
        .user-status {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            margin-bottom: 22px;
            font-size: 13.5px;
            border: 1px solid;
        }
        .user-status.auth {
            background: rgba(92,184,92,0.06);
            border-color: rgba(92,184,92,0.2);
            color: var(--green-l);
        }
        .user-status.guest {
            background: rgba(234,179,8,0.06);
            border-color: rgba(234,179,8,0.2);
            color: #fbbf24;
        }
        .status-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .user-status.auth .status-icon { background: rgba(92,184,92,0.12); color: var(--green); }
        .user-status.guest .status-icon { background: rgba(234,179,8,0.12); color: #fbbf24; }
        .user-status a { color: var(--green); font-weight: 600; text-decoration: none; }
        .user-status a:hover { text-decoration: underline; }
        .status-role {
            font-size: 11.5px;
            opacity: 0.6;
            margin-left: 4px;
        }

        /* ════ INFO BOX ════ */
        .info-tip {
            display: flex;
            gap: 12px;
            padding: 14px 18px;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border);
            border-left: 3px solid var(--green);
            border-radius: 0 var(--radius) var(--radius) 0;
            font-size: 13.5px;
            color: var(--muted);
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .info-tip i { color: var(--green); flex-shrink:0; margin-top:2px; }
        .info-tip strong { color: var(--offwhite); }

        /* ════ SECTION LABEL ════ */
        .section-label {
            font-family: 'Syne', sans-serif;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted2);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ════ FORM FIELDS ════ */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--offwhite);
            margin-bottom: 9px;
            letter-spacing: 0.2px;
        }
        .form-label i { color: var(--green); font-size: 14px; }
        .required-dot {
            width: 5px; height: 5px;
            background: var(--green);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .input-shell {
            position: relative;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255,255,255,0.04);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: var(--radius);
            font-size: 14.5px;
            font-family: 'DM Sans', sans-serif;
            color: var(--white);
            outline: none;
            transition: all 0.25s ease;
            appearance: none;
            -webkit-appearance: none;
        }
        .form-input::placeholder { color: var(--muted2); }
        .form-input:hover,
        .form-select:hover { border-color: rgba(255,255,255,0.15); }
        .form-input:focus,
        .form-select:focus {
            border-color: var(--green);
            background: rgba(92,184,92,0.05);
            box-shadow: 0 0 0 4px rgba(92,184,92,0.1);
        }

        /* Select arrow */
        .select-shell { position: relative; }
        .select-shell::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            font-size: 14px;
            transition: transform 0.2s;
        }
        .form-select option { background: #1e1e1e; color: var(--white); }

        /* Date & time suffix icon */
        .form-input[type="date"],
        .form-input[type="time"] {
            color-scheme: dark;
        }

        /* 2-col grid */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ════ CAFÉ CARDS ════ */
        .cafe-picker {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 4px;
        }

        .cafe-option {
            display: none; /* hidden input */
        }

        .cafe-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 16px;
            background: rgba(255,255,255,0.03);
            border: 1.5px solid rgba(255,255,255,0.07);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--muted);
        }
        .cafe-label:hover { border-color: rgba(92,184,92,0.3); color: var(--offwhite); background: rgba(255,255,255,0.05); }
        .cafe-option:checked + .cafe-label {
            border-color: var(--green);
            background: rgba(92,184,92,0.08);
            color: var(--green-l);
        }
        .cafe-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            border: 2px solid currentColor;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .cafe-option:checked + .cafe-label .cafe-dot {
            background: var(--green);
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(92,184,92,0.2);
        }

        /* ════ FILE UPLOAD ════ */
        .upload-zone {
            position: relative;
            border: 1.5px dashed rgba(255,255,255,0.12);
            border-radius: var(--radius-lg);
            padding: 36px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: rgba(255,255,255,0.02);
            overflow: hidden;
        }
        .upload-zone::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(92,184,92,0.06) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .upload-zone:hover,
        .upload-zone.active {
            border-color: rgba(92,184,92,0.4);
            background: rgba(92,184,92,0.04);
        }
        .upload-zone:hover::before,
        .upload-zone.active::before { opacity: 1; }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon-wrap {
            width: 64px; height: 64px;
            border-radius: 20px;
            background: rgba(92,184,92,0.1);
            border: 1px solid rgba(92,184,92,0.2);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 18px;
            font-size: 26px;
            color: var(--green);
            transition: transform 0.3s;
        }
        .upload-zone:hover .upload-icon-wrap { transform: scale(1.08) translateY(-2px); }

        .upload-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--offwhite);
            margin-bottom: 6px;
        }
        .upload-hint {
            font-size: 12.5px;
            color: var(--muted2);
        }
        .upload-hint span {
            display: inline-block;
            margin-top: 6px;
            padding: 3px 10px;
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            border: 1px solid var(--border);
            font-size: 11.5px;
        }

        .file-preview {
            display: none;
            align-items: center;
            gap: 10px;
            margin-top: 14px;
            padding: 12px 16px;
            background: rgba(92,184,92,0.07);
            border: 1px solid rgba(92,184,92,0.2);
            border-radius: var(--radius);
            font-size: 13.5px;
            color: var(--green-l);
            animation: fadeFile 0.3s ease;
        }
        @keyframes fadeFile {
            from { opacity:0; transform: scale(0.97); }
            to   { opacity:1; transform: scale(1); }
        }
        .file-preview.show { display: flex; }
        .file-preview i { font-size:18px; color: var(--green); flex-shrink:0; }
        .file-preview span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .file-preview .file-size { font-size: 12px; color: var(--muted); margin-left: auto; flex-shrink: 0; }

        /* ════ SUBMIT BUTTON ════ */
        .btn-submit {
            width: 100%;
            padding: 16px 28px;
            background: var(--green);
            color: var(--black);
            border: none;
            border-radius: var(--radius);
            font-size: 15px;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            letter-spacing: 0.5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 0 0 rgba(92,184,92,0);
            margin-top: 8px;
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .btn-submit:hover {
            background: #6dcf6d;
            transform: translateY(-2px);
            box-shadow: 0 12px 36px rgba(92,184,92,0.35);
        }
        .btn-submit:hover::before { opacity:1; }
        .btn-submit:active { transform: translateY(0); box-shadow: none; }
        .btn-submit:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-submit i { font-size:16px; transition: transform 0.25s; }
        .btn-submit:hover i { transform: translateX(3px); }

        /* ════ DIVIDER ════ */
        .form-divider {
            height: 1px;
            background: var(--border);
            margin: 28px 0;
        }

        /* ════ FOOTER ════ */
        .page-footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 24px 16px 40px;
            font-size: 13px;
            color: var(--muted2);
            border-top: 1px solid var(--border);
        }
        .page-footer a { color: var(--green); text-decoration: none; font-weight: 500; }
        .page-footer a:hover { color: var(--green-l); }
        .footer-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: var(--white);
        }

        /* ════ SHAKE ANIMATION ════ */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20% { transform: translateX(-8px); }
            40% { transform: translateX(8px); }
            60% { transform: translateX(-5px); }
            80% { transform: translateX(5px); }
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        /* ════ RESPONSIVE ════ */
        @media (max-width: 1100px) {
            .page-wrap { grid-template-columns: 1fr; padding: 36px 20px 70px; }
            .page-center { max-width: 560px; margin: 0 auto; width: 100%; }
        }
        @media (max-width: 640px) {
            .topbar { padding: 0 16px; }
            .topbar-brand { font-size: 17px; }
            .page-wrap { padding: 24px 16px 60px; }
            .card-head { padding: 28px 24px 22px; }
            .card-head h1 { font-size: 24px; }
            .card-body { padding: 26px 24px 30px; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .cafe-picker { grid-template-columns: 1fr; }
            .nav-history span, .nav-back span { display: none; }
            .nav-logout span { display: none; }
        }
    </style>
</head>
<body>

    <div class="ambient ambient-1"></div>
    <div class="ambient ambient-2"></div>

    {{-- ════ NAVBAR ════ --}}
    <nav class="topbar">
        <div class="topbar-left">
            <a href="{{ route('reservations.index') }}" class="nav-back">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <a href="{{ route('reservations.index') }}" class="nav-history">
                <i class="fas fa-clock-rotate-left"></i>
                <span>Histori</span>
            </a>
        </div>

        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="brand-white">PLANO</span><span class="brand-green">VA</span>
        </a>

        <div>
            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button type="button" class="nav-logout" onclick="if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit()">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="nav-logout" style="display:flex;align-items:center;gap:7px;text-decoration:none;color:var(--muted);">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </nav>

    {{-- ════ MAIN ════ --}}
    <main class="page-wrap">
        <div class="page-center">
            <div class="form-card">

                {{-- Header --}}
                <div class="card-head">
                    <div class="head-tag">
                        <i class="fas fa-calendar-check"></i>
                        Form Reservasi
                    </div>
                    <h1>Pesan Meja<br><span>Favoritmu</span></h1>
                    <p>Lengkapi data di bawah untuk membuat reservasi.<br>Konfirmasi dalam 1×24 jam setelah pembayaran terverifikasi.</p>
                </div>

                {{-- Body --}}
                <div class="card-body">

                    {{-- Flash Messages --}}
                    @if(session('success'))
                    <div class="pv-alert pv-alert-success">
                        <i class="fas fa-circle-check"></i>
                        <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="pv-alert pv-alert-error">
                        <i class="fas fa-triangle-exclamation"></i>
                        <div>
                            <strong>Ada kesalahan:</strong>
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    {{-- User Status --}}
                    @auth
                    <div class="user-status auth">
                        <div class="status-icon"><i class="fas fa-circle-user"></i></div>
                        <div>
                            Masuk sebagai <strong>{{ auth()->user()->name }}</strong>
                            <span class="status-role">· {{ ucfirst(auth()->user()->role) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="user-status guest">
                        <div class="status-icon"><i class="fas fa-triangle-exclamation"></i></div>
                        <div>Belum login? <a href="{{ route('login') }}">Login dulu</a> untuk pengalaman lebih baik.</div>
                    </div>
                    @endauth

                    {{-- Info Tip --}}
                    <div class="info-tip">
                        <i class="fas fa-lightbulb"></i>
                        <div>Pastikan <strong>bukti pembayaran</strong> jelas & terbaca. Reservasi dikonfirmasi dalam <strong>1×24 jam</strong>.</div>
                    </div>

                    {{-- FORM --}}
                    <form action="{{ route('reservations.store') }}" method="POST"
                          enctype="multipart/form-data" id="reservationForm" novalidate>
                        @csrf

                        {{-- Café Section --}}
                        <div class="section-label">Pilih Café</div>

                        {{-- Dropdown fallback (uses select) --}}
                        <div class="form-group">
                            <label class="form-label" for="cafe_id">
                                <i class="fas fa-store"></i>
                                Café
                                <span class="required-dot"></span>
                            </label>
                            <div class="select-shell">
                                <select name="cafe_id" id="cafe_id" class="form-input form-select" required>
                                    <option value="">— Pilih café favoritmu —</option>
                                    @foreach($cafes as $cafe)
                                    <option value="{{ $cafe->id }}"
                                        {{ (request('cafe_id') == $cafe->id || old('cafe_id') == $cafe->id) ? 'selected' : '' }}>
                                        {{ $cafe->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-divider"></div>

                        {{-- Date & Time --}}
                        <div class="section-label">Jadwal Kunjungan</div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="reservation_date">
                                    <i class="fas fa-calendar"></i>
                                    Tanggal
                                    <span class="required-dot"></span>
                                </label>
                                <input type="date" name="reservation_date" id="reservation_date"
                                       class="form-input" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('reservation_date') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="reservation_time">
                                    <i class="fas fa-clock"></i>
                                    Waktu
                                    <span class="required-dot"></span>
                                </label>
                                <input type="time" name="reservation_time" id="reservation_time"
                                       class="form-input" required
                                       min="08:00" max="22:00"
                                       value="{{ old('reservation_time') }}">
                            </div>
                        </div>

                        {{-- Guest Count --}}
                        <div class="form-group">
                            <label class="form-label" for="guests">
                                <i class="fas fa-users"></i>
                                Jumlah Tamu
                                <span class="required-dot"></span>
                            </label>
                            <input type="number" name="guests" id="guests"
                                   class="form-input" min="1" max="50"
                                   placeholder="Berapa orang? (maks. 50)"
                                   required value="{{ old('guests') }}">
                        </div>

                        <div class="form-divider"></div>

                        {{-- Payment --}}
                        <div class="section-label">Pembayaran</div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-receipt"></i>
                                Bukti Pembayaran
                                <span class="required-dot"></span>
                            </label>

                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="payment_proof" id="payment_proof"
                                       accept="image/*" required>
                                <div class="upload-icon-wrap">
                                    <i class="fas fa-cloud-arrow-up"></i>
                                </div>
                                <div class="upload-title">Klik atau seret file ke sini</div>
                                <div class="upload-hint">
                                    Format JPG atau PNG &nbsp;·&nbsp;
                                    <span>Maks. 2 MB</span>
                                </div>
                            </div>

                            <div class="file-preview" id="filePreview">
                                <i class="fas fa-file-image"></i>
                                <span id="fileNameText">—</span>
                                <span class="file-size" id="fileSizeText"></span>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane" id="submitIcon"></i>
                            <span id="submitText">Kirim Reservasi</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </main>

    {{-- ════ FOOTER ════ --}}
    <footer class="page-footer">
        &copy; {{ date('Y') }} <span class="footer-brand">PLANOVA</span> &nbsp;·&nbsp;
        <a href="{{ route('home') }}">Kembali ke Beranda</a>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // ── File Upload ──
        const fileInput   = document.getElementById('payment_proof');
        const uploadZone  = document.getElementById('uploadZone');
        const filePreview = document.getElementById('filePreview');
        const fileNameText= document.getElementById('fileNameText');
        const fileSizeText= document.getElementById('fileSizeText');

        function handleFile(file) {
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB.');
                fileInput.value = '';
                uploadZone.classList.remove('active');
                filePreview.classList.remove('show');
                return;
            }
            const kb = (file.size / 1024).toFixed(0);
            const sz = kb >= 1024 ? (kb/1024).toFixed(1)+' MB' : kb+' KB';
            fileNameText.textContent = file.name;
            fileSizeText.textContent = sz;
            filePreview.classList.add('show');
            uploadZone.classList.add('active');
        }

        fileInput?.addEventListener('change', e => handleFile(e.target.files[0]));

        // Keyboard
        uploadZone?.addEventListener('keydown', e => {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); }
        });

        // Drag & Drop
        ['dragenter','dragover'].forEach(ev => {
            uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.add('active'); });
        });
        ['dragleave','drop'].forEach(ev => {
            uploadZone?.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.remove('active'); });
        });
        uploadZone?.addEventListener('drop', e => {
            const f = e.dataTransfer.files[0];
            if (f) { fileInput.files = e.dataTransfer.files; handleFile(f); }
        });

        // ── Date limits ──
        const dateInput = document.getElementById('reservation_date');
        if (dateInput) {
            const t = new Date();
            t.setDate(t.getDate() + 1);
            dateInput.min = t.toISOString().split('T')[0];
            const max = new Date();
            max.setDate(max.getDate() + 30);
            dateInput.max = max.toISOString().split('T')[0];
        }

        // ── Form submit ──
        const form      = document.getElementById('reservationForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitIcon= document.getElementById('submitIcon');
        const submitText= document.getElementById('submitText');

        form?.addEventListener('submit', function (e) {
            if (!fileInput?.files?.length) {
                e.preventDefault();
                uploadZone.style.animation = 'shake 0.5s ease';
                uploadZone.style.borderColor = 'rgba(239,68,68,0.5)';
                setTimeout(() => {
                    uploadZone.style.animation = '';
                    uploadZone.style.borderColor = '';
                }, 600);
                alert('Silakan upload bukti pembayaran terlebih dahulu.');
                return;
            }
            submitBtn.disabled = true;
            submitText.textContent = 'Mengirim...';
            submitIcon.className = 'fas fa-spinner';
            submitIcon.style.animation = 'spin 1s linear infinite';
        });
    });
    </script>
</body>
</html>