<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Reservasi - PLANOVA</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --white:      #ffffff;
            --off:        #f9f9f7;
            --surface:    #f3f4f0;
            --border:     #e4e5e0;
            --border-em:  #c8e6c8;
            --ink:        #1a1a18;
            --ink2:       #4a4a46;
            --ink3:       #9a9a94;
            --green:      #2d7a2d;
            --green-l:    #3d9e3d;
            --green-xl:   #5cbf5c;
            --green-bg:   #edf7ed;
            --green-bgd:  #d4edce;
            --green-bdr:  #b0d8b0;
            --red-bg:     #fdf2f2;
            --red-bdr:    #f5c2c2;
            --red-text:   #b52a2a;
            --amber-bg:   #fffbf0;
            --amber-bdr:  #f0d990;
            --amber-text: #8a6800;
            --radius-sm:  8px;
            --radius:     12px;
            --radius-lg:  18px;
            --radius-xl:  24px;
            --shadow-xs:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-sm:  0 2px 8px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
            --shadow-md:  0 8px 24px rgba(0,0,0,0.07), 0 2px 8px rgba(0,0,0,0.04);
            --shadow-lg:  0 20px 60px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
        }

        * { margin:0; padding:0; box-sizing:border-box; -webkit-tap-highlight-color:transparent; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--off);
            color: var(--ink);
            min-height: 100vh;
            overflow-x: hidden;
            line-height: 1.65;
        }

        /* subtle grain texture */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        /* decorative botanical lines */
        body::after {
            content: '';
            position: fixed;
            top: 0; right: 0;
            width: 420px; height: 420px;
            background:
                radial-gradient(ellipse at 90% 10%, rgba(45,122,45,0.06) 0%, transparent 55%),
                radial-gradient(ellipse at 10% 90%, rgba(45,122,45,0.04) 0%, transparent 55%);
            pointer-events: none;
            z-index: 0;
        }

        /* ════ NAVBAR ════ */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 200;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 36px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 1px 0 var(--border);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-back {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--ink2);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            font-family: 'Outfit', sans-serif;
            box-shadow: var(--shadow-xs);
        }
        .nav-back:hover { border-color: var(--green-bdr); color: var(--green); background: var(--green-bg); box-shadow: none; }

        .nav-history {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            background: var(--green-bg);
            border: 1px solid var(--green-bdr);
            border-radius: var(--radius-sm);
            color: var(--green);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: var(--shadow-xs);
        }
        .nav-history:hover { background: var(--green-bgd); border-color: var(--green-l); }

        .topbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .topbar-brand .brand-ink { color: var(--ink); }
        .topbar-brand .brand-green { color: var(--green); }

        .nav-logout {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--ink2);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: var(--shadow-xs);
        }
        .nav-logout:hover { border-color: #f5c2c2; color: var(--red-text); background: var(--red-bg); box-shadow: none; }

        /* ════ PAGE LAYOUT ════ */
        .page-wrap {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 540px 1fr;
            min-height: calc(100vh - 64px);
            padding: 52px 24px 90px;
        }
        .page-center { grid-column: 2; }

        /* ════ FORM CARD ════ */
        .form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            animation: riseUp 0.55s cubic-bezier(0.16,1,0.3,1) both;
        }

        @keyframes riseUp {
            from { opacity:0; transform: translateY(32px) scale(0.98); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* Card header */
        .card-head {
            position: relative;
            padding: 44px 44px 36px;
            overflow: hidden;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(160deg, var(--green-bg) 0%, var(--white) 60%);
        }

        /* decorative leaf motif */
        .card-head::after {
            content: '';
            position: absolute;
            bottom: -30px; right: -30px;
            width: 180px; height: 180px;
            background: radial-gradient(circle at 60% 60%, var(--green-bgd) 0%, transparent 65%);
            border-radius: 50%;
            pointer-events: none;
        }

        .head-tag {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 14px;
            background: var(--green-bg);
            border: 1px solid var(--green-bdr);
            border-radius: 40px;
            font-size: 11px;
            font-weight: 600;
            color: var(--green);
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .card-head h1 {
            position: relative;
            z-index: 1;
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.15;
            margin-bottom: 12px;
            letter-spacing: -0.3px;
        }
        .card-head h1 em { font-style: italic; color: var(--green); }

        .card-head p {
            position: relative;
            z-index: 1;
            font-size: 14px;
            color: var(--ink3);
            line-height: 1.65;
        }

        /* accent line below heading */
        .head-accent {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }
        .head-accent-line {
            height: 2px;
            width: 32px;
            background: var(--green);
            border-radius: 2px;
        }
        .head-accent-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--green-xl);
        }

        /* Card body */
        .card-body { padding: 38px 44px 44px; }

        /* ════ ALERTS ════ */
        .pv-alert {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 22px;
            line-height: 1.55;
            animation: slideAlert 0.3s ease;
            border: 1px solid;
        }
        @keyframes slideAlert {
            from { opacity:0; transform: translateY(-8px); }
            to   { opacity:1; transform: translateY(0); }
        }
        .pv-alert-success {
            background: var(--green-bg);
            border-color: var(--green-bdr);
            color: var(--green);
        }
        .pv-alert-error {
            background: var(--red-bg);
            border-color: var(--red-bdr);
            color: var(--red-text);
        }
        .pv-alert i { flex-shrink:0; font-size:16px; margin-top:1px; }
        .pv-alert ul { margin:6px 0 0 4px; padding-left:14px; }
        .pv-alert ul li { margin-bottom:2px; font-size:13px; }

        /* ════ USER STATUS ════ */
        .user-status {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 16px;
            border-radius: var(--radius);
            margin-bottom: 20px;
            font-size: 13.5px;
            border: 1px solid;
        }
        .user-status.auth {
            background: var(--green-bg);
            border-color: var(--green-bdr);
            color: var(--green);
        }
        .user-status.guest {
            background: var(--amber-bg);
            border-color: var(--amber-bdr);
            color: var(--amber-text);
        }
        .status-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .user-status.auth .status-icon { background: var(--green-bgd); color: var(--green); }
        .user-status.guest .status-icon { background: var(--amber-bdr); color: var(--amber-text); }
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
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: 3px solid var(--green);
            border-radius: 0 var(--radius) var(--radius) 0;
            font-size: 13.5px;
            color: var(--ink2);
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .info-tip i { color: var(--green); flex-shrink:0; margin-top:3px; }
        .info-tip strong { color: var(--ink); }

        /* ════ SECTION LABEL ════ */
        .section-label {
            font-family: 'Playfair Display', serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
            color: var(--ink2);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-label i { color: var(--green); font-size: 14px; }
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
            font-weight: 500;
            color: var(--ink2);
            margin-bottom: 8px;
        }
        .form-label i { color: var(--green); font-size: 14px; }
        .required-dot {
            width: 5px; height: 5px;
            background: var(--green);
            border-radius: 50%;
            flex-shrink: 0;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 14px;
            font-family: 'Outfit', sans-serif;
            color: var(--ink);
            outline: none;
            transition: all 0.2s ease;
            appearance: none;
            -webkit-appearance: none;
            box-shadow: var(--shadow-xs);
        }
        .form-input::placeholder { color: var(--ink3); }
        .form-input:hover,
        .form-select:hover { border-color: var(--green-bdr); }
        .form-input:focus,
        .form-select:focus {
            border-color: var(--green-l);
            box-shadow: 0 0 0 3px rgba(45,122,45,0.1);
        }

        .select-shell { position: relative; }
        .select-shell::after {
            content: '\f107';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--ink3);
            pointer-events: none;
            font-size: 13px;
        }
        .form-select option { background: var(--white); color: var(--ink); }
        .form-input[type="date"],
        .form-input[type="time"] { color-scheme: light; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* ════ MENU SELECTION ════ */
        .menu-section {
            display: none;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            animation: fadeUp 0.35s ease both;
        }
        .menu-section.show { display: block; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .menu-category { margin-bottom: 20px; }

        .menu-category-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--green);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 7px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }

        .menu-list { display: flex; flex-direction: column; gap: 8px; }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.18s;
            box-shadow: var(--shadow-xs);
        }
        .menu-item:hover { border-color: var(--green-bdr); background: var(--green-bg); box-shadow: none; }
        .menu-item.selected { border-color: var(--green-l); background: var(--green-bg); }

        .menu-checkbox {
            width: 20px; height: 20px;
            border: 1.5px solid var(--border);
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.18s;
            background: var(--white);
        }
        .menu-checkbox i { color: var(--white); font-size: 11px; opacity: 0; transition: opacity 0.15s; }
        .menu-item.selected .menu-checkbox { border-color: var(--green); background: var(--green); }
        .menu-item.selected .menu-checkbox i { opacity: 1; }

        .menu-info { flex: 1; min-width: 0; }
        .menu-name { font-size: 14px; font-weight: 500; color: var(--ink); margin-bottom: 2px; }
        .menu-desc { font-size: 12px; color: var(--ink3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .menu-price { font-size: 13.5px; font-weight: 600; color: var(--green); flex-shrink: 0; }

        .menu-image {
            width: 46px; height: 46px;
            border-radius: 9px;
            object-fit: cover;
            border: 1px solid var(--border);
            flex-shrink: 0;
        }
        .menu-image-placeholder {
            width: 46px; height: 46px;
            border-radius: 9px;
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: var(--ink3);
            font-size: 16px;
            flex-shrink: 0;
            border: 1px solid var(--border);
        }

        .menu-empty {
            text-align: center;
            padding: 24px;
            color: var(--ink3);
            font-size: 13px;
        }
        .menu-empty i { font-size: 24px; margin-bottom: 8px; display: block; color: var(--border); }

        .menu-summary {
            display: none;
            margin-top: 16px;
            padding: 14px 16px;
            background: var(--green-bg);
            border: 1px solid var(--green-bdr);
            border-radius: var(--radius);
        }
        .menu-summary.show { display: block; }

        .menu-summary-title {
            font-size: 12px;
            font-weight: 600;
            color: var(--green);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-summary-list { display: flex; flex-wrap: wrap; gap: 7px; }

        .menu-summary-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 11px;
            background: var(--white);
            border: 1px solid var(--green-bdr);
            border-radius: 20px;
            font-size: 12px;
            color: var(--green);
        }

        .menu-summary-remove {
            background: none; border: none;
            color: var(--ink3); cursor: pointer;
            font-size: 11px; padding: 0; margin-left: 2px;
        }
        .menu-summary-remove:hover { color: var(--red-text); }

        /* ════ FILE UPLOAD ════ */
        .upload-zone {
            position: relative;
            border: 1.5px dashed var(--border);
            border-radius: var(--radius-lg);
            padding: 36px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            background: var(--surface);
        }
        .upload-zone:hover, .upload-zone.active {
            border-color: var(--green-l);
            background: var(--green-bg);
        }
        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%; height: 100%;
        }
        .upload-icon-wrap {
            width: 60px; height: 60px;
            border-radius: 16px;
            background: var(--white);
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 24px;
            color: var(--green);
            transition: transform 0.25s;
            box-shadow: var(--shadow-sm);
        }
        .upload-zone:hover .upload-icon-wrap { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .upload-title { font-size: 14.5px; font-weight: 500; color: var(--ink); margin-bottom: 6px; }
        .upload-hint { font-size: 12.5px; color: var(--ink3); }
        .upload-hint span {
            display: inline-block; margin-top: 6px;
            padding: 3px 10px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 11.5px;
        }

        .file-preview {
            display: none;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 11px 16px;
            background: var(--green-bg);
            border: 1px solid var(--green-bdr);
            border-radius: var(--radius);
            font-size: 13.5px;
            color: var(--green);
            animation: fadeFile 0.3s ease;
        }
        @keyframes fadeFile {
            from { opacity:0; transform: scale(0.97); }
            to   { opacity:1; transform: scale(1); }
        }
        .file-preview.show { display: flex; }
        .file-preview i { font-size:17px; flex-shrink:0; }
        .file-preview span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .file-preview .file-size { font-size: 12px; color: var(--ink3); margin-left: auto; flex-shrink: 0; }

        /* ════ BANK ACCOUNT CARDS ════ */

        /* Fee badge above bank card */
        .fee-badge {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 20px;
            background: var(--green-bg);
            border: 1px solid var(--green-bdr);
            border-radius: var(--radius);
            margin-bottom: 12px;
        }
        .fee-badge-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .fee-badge-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--green-bgd);
            display: flex; align-items: center; justify-content: center;
            color: var(--green);
            font-size: 16px;
            flex-shrink: 0;
        }
        .fee-badge-label {
            font-size: 12.5px;
            color: var(--ink3);
        }
        .fee-badge-amount {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--green);
            letter-spacing: -0.5px;
        }
        .fee-badge-note {
            font-size: 11.5px;
            color: var(--ink3);
            text-align: right;
            line-height: 1.45;
        }

        .bank-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            margin-bottom: 12px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
        }
        .bank-card:hover { border-color: var(--green-bdr); box-shadow: var(--shadow-md); }

        .bank-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .bank-logo {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 800;
            flex-shrink: 0;
            letter-spacing: -0.5px;
        }
        .bank-logo.bri { background: #003f8a; color: #f2c200; }

        .bank-name {
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
        }
        .bank-type {
            font-size: 12px;
            color: var(--ink3);
            margin-top: 2px;
        }

        .bank-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .bank-number {
            font-family: 'Courier New', monospace;
            font-size: 20px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: 2px;
        }
        .bank-holder {
            font-size: 12px;
            color: var(--ink3);
            margin-top: 5px;
        }

        .copy-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            font-family: 'Outfit', sans-serif;
            color: var(--ink2);
            cursor: pointer;
            transition: all 0.18s;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .copy-btn:hover { background: var(--green-bg); border-color: var(--green-bdr); color: var(--green); }
        .copy-btn.copied { background: var(--green-bg); border-color: var(--green-bdr); color: var(--green); }
        .copy-btn i { font-size: 13px; }

        .bank-notice {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 13px 16px;
            background: var(--amber-bg);
            border: 1px solid var(--amber-bdr);
            border-radius: var(--radius);
            font-size: 13px;
            color: var(--amber-text);
            margin-bottom: 16px;
            line-height: 1.55;
        }
        .bank-notice i { flex-shrink:0; margin-top:1px; font-size:15px; }

        /* ════ SUBMIT BUTTON ════ */
        .btn-submit {
            width: 100%;
            padding: 15px 28px;
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: var(--radius);
            font-size: 15px;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.3px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
            margin-top: 8px;
            box-shadow: 0 4px 14px rgba(45,122,45,0.25);
        }
        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
        }
        .btn-submit:hover {
            background: var(--green-l);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(45,122,45,0.3);
        }
        .btn-submit:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(45,122,45,0.2); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-submit i { font-size:15px; transition: transform 0.2s; }
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
            color: var(--ink3);
            border-top: 1px solid var(--border);
        }
        .page-footer a { color: var(--green); text-decoration: none; font-weight: 500; }
        .page-footer a:hover { color: var(--green-l); text-decoration: underline; }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 14px;
            color: var(--ink);
            letter-spacing: 0.5px;
        }

        /* ════ ANIMATIONS ════ */
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            20% { transform: translateX(-7px); }
            40% { transform: translateX(7px); }
            60% { transform: translateX(-4px); }
            80% { transform: translateX(4px); }
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
            .topbar-brand { font-size: 18px; }
            .page-wrap { padding: 20px 14px 60px; }
            .card-head { padding: 28px 24px 24px; }
            .card-head h1 { font-size: 26px; }
            .card-body { padding: 24px 24px 28px; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .nav-history span, .nav-back span { display: none; }
            .nav-logout span { display: none; }
        }
    </style>
</head>
<body>

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
            <span class="brand-ink">PLANO</span><span class="brand-green">VA</span>
        </a>

        <div>
            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button type="button" class="nav-logout" onclick="if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit()">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="nav-logout" style="display:flex;align-items:center;gap:7px;text-decoration:none;">
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
                    <h1>Pesan Meja<br><em>Favoritmu</em></h1>
                    <p>Lengkapi data di bawah untuk membuat reservasi.<br>Konfirmasi dalam 1×24 jam setelah pembayaran terverifikasi.</p>
                    <div class="head-accent">
                        <div class="head-accent-line"></div>
                        <div class="head-accent-dot"></div>
                    </div>
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
                        <div class="section-label"><i class="fas fa-store"></i> Pilih Café</div>

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
                                        {{ (request('cafe_id') == $cafe->id || old('cafe_id') == $cafe->id) ? 'selected' : '' }}
                                        data-menus='@json($cafe->menus)'>
                                        {{ $cafe->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Menu Selection --}}
                        <div class="menu-section" id="menuSection">
                            <div class="section-label"><i class="fas fa-utensils"></i> Pilih Menu (Opsional)</div>
                            <div id="menuContainer"></div>
                            <div class="menu-summary" id="menuSummary">
                                <div class="menu-summary-title"><i class="fas fa-check-circle"></i> Menu Terpilih</div>
                                <div class="menu-summary-list" id="menuSummaryList"></div>
                            </div>
                            <input type="hidden" name="selected_menus" id="selectedMenusInput" value="">
                        </div>

                        <div class="form-divider"></div>

                        {{-- Date & Time --}}
                        <div class="section-label"><i class="fas fa-calendar"></i> Jadwal Kunjungan</div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="reservation_date">
                                    <i class="fas fa-calendar"></i> Tanggal <span class="required-dot"></span>
                                </label>
                                <input type="date" name="reservation_date" id="reservation_date"
                                       class="form-input" required
                                       min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                       value="{{ old('reservation_date') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="reservation_time">
                                    <i class="fas fa-clock"></i> Waktu <span class="required-dot"></span>
                                </label>
                                <input type="time" name="reservation_time" id="reservation_time"
                                       class="form-input" required min="08:00" max="22:00"
                                       value="{{ old('reservation_time') }}">
                            </div>
                        </div>

                        {{-- Guest Count --}}
                        <div class="form-group">
                            <label class="form-label" for="guests">
                                <i class="fas fa-users"></i> Jumlah Tamu <span class="required-dot"></span>
                            </label>
                            <input type="number" name="guests" id="guests"
                                   class="form-input" min="1" max="50"
                                   placeholder="Berapa orang? (maks. 50)"
                                   required value="{{ old('guests') }}">
                        </div>

                        <div class="form-divider"></div>

                        {{-- Payment --}}
                        <div class="section-label"><i class="fas fa-receipt"></i> Pembayaran</div>

                        {{-- Bank Notice --}}
                        <div class="bank-notice">
                            <i class="fas fa-circle-info"></i>
                            <div>Transfer minilai <strong>Rp 50.000</strong> ke rekening di bawah, lalu upload bukti pembayaran. Reservasi dikonfirmasi setelah pembayaran terverifikasi.</div>
                        </div>

                        {{-- BRI Card --}}
                        <div class="bank-card">
                            <div class="bank-header">
                                <div class="bank-logo bri">BRI</div>
                                <div>
                                    <div class="bank-name">Bank BRI</div>
                                    <div class="bank-type">Transfer Bank · Tabungan</div>
                                </div>
                            </div>
                            <div class="bank-body">
                                <div>
                                    <div class="bank-number">5735 0103 0568 537</div>
                                    <div class="bank-holder">a.n. PLANOVA Café</div>
                                </div>
                                <button type="button" class="copy-btn" onclick="copyAccount(this, '573501030568537')">
                                    <i class="fas fa-copy"></i> Salin Nomor
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-receipt"></i> Bukti Pembayaran <span class="required-dot"></span>
                            </label>

                            <div class="upload-zone" id="uploadZone">
                                <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required>
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
        const cafeSelect = document.getElementById('cafe_id');
        const menuSection = document.getElementById('menuSection');
        const menuContainer = document.getElementById('menuContainer');
        const menuSummary = document.getElementById('menuSummary');
        const menuSummaryList = document.getElementById('menuSummaryList');
        const selectedMenusInput = document.getElementById('selectedMenusInput');
        const form = document.getElementById('reservationForm');
        const fileInput = document.getElementById('payment_proof');
        const uploadZone = document.getElementById('uploadZone');
        const submitBtn = document.getElementById('submitBtn');
        const submitIcon = document.getElementById('submitIcon');
        const submitText = document.getElementById('submitText');

        let selectedMenus = [];

        if (cafeSelect) {
            cafeSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const menusData = selectedOption.dataset.menus;
                if (menusData && menusData !== 'null' && menusData !== '[]') {
                    try {
                        const menus = JSON.parse(menusData);
                        if (menus.length > 0) {
                            renderMenuSelection(menus);
                            if (menuSection) menuSection.classList.add('show');
                        } else {
                            if (menuSection) menuSection.classList.remove('show');
                            if (menuContainer) menuContainer.innerHTML = '';
                        }
                    } catch(e) { console.error(e); }
                } else {
                    if (menuSection) menuSection.classList.remove('show');
                    if (menuContainer) menuContainer.innerHTML = '';
                    selectedMenus = [];
                    updateSelectedMenusInput();
                }
            });
        }

        function renderMenuSelection(menus) {
            if (!menus || menus.length === 0) {
                if (menuContainer) menuContainer.innerHTML = `<div class="menu-empty"><i class="fas fa-utensils"></i>Belum ada menu tersedia.</div>`;
                if (menuSummary) menuSummary.classList.remove('show');
                return;
            }
            const grouped = menus.reduce((acc, menu) => {
                if (!acc[menu.category]) acc[menu.category] = [];
                acc[menu.category].push(menu);
                return acc;
            }, {});

            let html = '';
            Object.entries(grouped).forEach(([category, categoryMenus]) => {
                html += `<div class="menu-category"><div class="menu-category-title"><i class="fas fa-tag"></i>${category.charAt(0).toUpperCase() + category.slice(1)}</div><div class="menu-list">`;
                categoryMenus.forEach(menu => {
                    const isSelected = selectedMenus.includes(menu.id);
                    html += `<div class="menu-item ${isSelected ? 'selected' : ''}" data-menu-id="${menu.id}" onclick="window.toggleMenuSelection(${menu.id}, '${menu.name.replace(/'/g,"\\'")}', ${menu.price})">
                        <div class="menu-checkbox"><i class="fas fa-check"></i></div>
                        ${menu.image ? `<img src="/storage/${menu.image}" alt="${menu.name}" class="menu-image">` : `<div class="menu-image-placeholder"><i class="fas fa-utensils"></i></div>`}
                        <div class="menu-info">
                            <div class="menu-name">${menu.name}</div>
                            ${menu.description ? `<div class="menu-desc">${menu.description}</div>` : ''}
                        </div>
                        <div class="menu-price">Rp ${new Intl.NumberFormat('id-ID').format(menu.price)}</div>
                    </div>`;
                });
                html += `</div></div>`;
            });
            if (menuContainer) menuContainer.innerHTML = html;
        }

        window.toggleMenuSelection = function(menuId, menuName, menuPrice) {
            const index = selectedMenus.indexOf(menuId);
            const menuItem = document.querySelector(`.menu-item[data-menu-id="${menuId}"]`);
            if (index === -1) {
                selectedMenus.push(menuId);
                if (menuItem) menuItem.classList.add('selected');
                addMenuToSummary(menuId, menuName, menuPrice);
            } else {
                selectedMenus.splice(index, 1);
                if (menuItem) menuItem.classList.remove('selected');
                removeMenuFromSummary(menuId);
            }
            if (selectedMenusInput) selectedMenusInput.value = JSON.stringify(selectedMenus);
            updateSummaryVisibility();
        };

        function addMenuToSummary(menuId, menuName, menuPrice) {
            const existing = document.querySelector(`.menu-summary-item[data-menu-id="${menuId}"]`);
            if (existing) return;
            const item = document.createElement('div');
            item.className = 'menu-summary-item';
            item.dataset.menuId = menuId;
            item.innerHTML = `${menuName}<button type="button" class="menu-summary-remove" onclick="toggleMenuSelection(${menuId}, '${menuName.replace(/'/g,"\\'")}', ${menuPrice})"><i class="fas fa-times"></i></button>`;
            if (menuSummaryList) menuSummaryList.appendChild(item);
        }

        function removeMenuFromSummary(menuId) {
            const item = document.querySelector(`.menu-summary-item[data-menu-id="${menuId}"]`);
            if (item) item.remove();
        }

        function updateSummaryVisibility() {
            if (menuSummary) menuSummary.classList.toggle('show', selectedMenus.length > 0);
        }

        function updateSelectedMenusInput() {
            if (selectedMenusInput) selectedMenusInput.value = JSON.stringify(selectedMenus);
        }

        const filePreview = document.getElementById('filePreview');
        const fileNameText = document.getElementById('fileNameText');
        const fileSizeText = document.getElementById('fileSizeText');

        function handleFile(file) {
            if (!file) return;
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB.');
                if (fileInput) fileInput.value = '';
                if (uploadZone) uploadZone.classList.remove('active');
                if (filePreview) filePreview.classList.remove('show');
                return;
            }
            const kb = (file.size / 1024).toFixed(0);
            const sz = kb >= 1024 ? (kb/1024).toFixed(1)+' MB' : kb+' KB';
            if (fileNameText) fileNameText.textContent = file.name;
            if (fileSizeText) fileSizeText.textContent = sz;
            if (filePreview) filePreview.classList.add('show');
            if (uploadZone) uploadZone.classList.add('active');
        }

        if (fileInput) fileInput.addEventListener('change', e => handleFile(e.target.files[0]));

        if (uploadZone) {
            ['dragenter','dragover'].forEach(ev => uploadZone.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.add('active'); }));
            ['dragleave','drop'].forEach(ev => uploadZone.addEventListener(ev, e => { e.preventDefault(); uploadZone.classList.remove('active'); }));
            uploadZone.addEventListener('drop', e => {
                const f = e.dataTransfer.files[0];
                if (f && fileInput) { fileInput.files = e.dataTransfer.files; handleFile(f); }
            });
        }

        const dateInput = document.getElementById('reservation_date');
        if (dateInput) {
            const t = new Date();
            t.setDate(t.getDate() + 1);
            dateInput.min = t.toISOString().split('T')[0];
            const max = new Date();
            max.setDate(max.getDate() + 30);
            dateInput.max = max.toISOString().split('T')[0];
        }

        if (form) {
            form.addEventListener('submit', function(e) {
                if (!fileInput?.files?.length) {
                    e.preventDefault();
                    if (uploadZone) {
                        uploadZone.style.animation = 'shake 0.5s ease';
                        uploadZone.style.borderColor = 'var(--red-bdr)';
                        setTimeout(() => { uploadZone.style.animation = ''; uploadZone.style.borderColor = ''; }, 600);
                    }
                    alert('Silakan upload bukti pembayaran terlebih dahulu.');
                    return;
                }
                if (submitBtn) submitBtn.disabled = true;
                if (submitText) submitText.textContent = 'Mengirim...';
                if (submitIcon) { submitIcon.className = 'fas fa-spinner'; submitIcon.style.animation = 'spin 1s linear infinite'; }
            });
        }
    });

    function copyAccount(btn, number) {
        navigator.clipboard.writeText(number).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
            btn.classList.add('copied');
            setTimeout(() => {
                btn.innerHTML = orig;
                btn.classList.remove('copied');
            }, 2000);
        }).catch(() => {
            const ta = document.createElement('textarea');
            ta.value = number;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i> Tersalin';
            btn.classList.add('copied');
            setTimeout(() => { btn.innerHTML = orig; btn.classList.remove('copied'); }, 2000);
        });
    }
    </script>
</body>
</html>