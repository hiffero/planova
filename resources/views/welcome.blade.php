<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PLANOVA — Reserve Your Moment</title>
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* ─────────────────────────────────────────────────────
           COLOR VARIABLES
           ───────────────────────────────────────────────────── */
        :root {
            --green-deep:    #1a3d17;
            --green-mid:     #2d5a27;
            --green-bright:  #4a8c40;
            --green-accent:  #6dbf5f;
            --black:         #0a0a0a;
            --off-black:     #111111;
            --dark-card:     #161616;
            --white:         #ffffff;
            --gray:          #888888;
            --border:        rgba(255, 255, 255, 0.08);
            --border-hover:  rgba(74, 140, 64, 0.3);
            --shadow-sm:     0 4px 12px rgba(0, 0, 0, 0.3);
            --shadow-lg:     0 24px 60px rgba(0, 0, 0, 0.5);
            --shadow-glow:   0 12px 32px rgba(45, 90, 39, 0.4);
        }

        /* ─────────────────────────────────────────────────────
           RESET & BASE
           ───────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: "DM Sans", sans-serif;
            background: var(--black);
            color: var(--white);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* ─────────────────────────────────────────────────────
           NAVBAR
           ───────────────────────────────────────────────────── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 48px;
            background: transparent;
            border-bottom: 1px solid transparent;
            transition: all 0.4s ease;
        }

        nav.scrolled {
            padding: 12px 48px;
            background: rgba(10, 10, 10, 0.92);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            gap: 12px;
        }

        .nav-logo img {
            height: 46px;
            width: auto;
            background: var(--white);
            border-radius: 10px;
            padding: 4px;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .nav-logo:hover img { opacity: 0.85; transform: scale(1.02); }

        .nav-logo-text {
            font-family: "Playfair Display", serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .nav-logo-text span { color: var(--green-accent); }

        .nav-links {
            display: flex;
            gap: 32px;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            font-size: 0.82rem;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            transition: color 0.2s ease;
            padding: 8px 4px;
        }

        .nav-links a:hover,
        .nav-links a.active { color: var(--white); }

        .nav-cta {
            background: var(--green-mid) !important;
            color: var(--white) !important;
            padding: 9px 22px !important;
            border-radius: 50px;
            font-weight: 600;
            transition: background 0.2s ease, transform 0.2s ease !important;
        }

        .nav-cta:hover {
            background: var(--green-bright) !important;
            transform: translateY(-2px);
        }

        .nav-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }

        .nav-toggle span {
            width: 24px;
            height: 2px;
            background: var(--white);
            border-radius: 2px;
            transition: 0.3s ease;
        }

        /* ─────────────────────────────────────────────────────
           HERO — FULLSCREEN BACKGROUND IMAGE
           ───────────────────────────────────────────────────── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Background image layer */
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transform: scale(1.05);
            animation: heroZoom 12s ease-out forwards;
        }

        @keyframes heroZoom {
            from { transform: scale(1.05); }
            to   { transform: scale(1.0); }
        }

        /* Dark gradient overlay */
        .hero-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(
                105deg,
                rgba(5, 18, 4, 0.90) 0%,
                rgba(10, 25, 8, 0.78) 45%,
                rgba(5, 18, 4, 0.60) 100%
            );
        }

        /* Right side vignette */
        .hero-overlay::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 75% 50%, rgba(45,90,39,0.12) 0%, transparent 65%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 0 64px;
            max-width: 700px;
            margin-top: 80px; /* offset for fixed nav */
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--green-accent);
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeUp 0.7s 0.1s forwards;
        }

        .hero-eyebrow::before {
            content: "";
            width: 28px;
            height: 1px;
            background: var(--green-accent);
        }

        .hero-title {
            font-family: "Playfair Display", serif;
            font-size: clamp(3.2rem, 6vw, 5.8rem);
            font-weight: 900;
            line-height: 1.0;
            letter-spacing: -0.02em;
            margin-bottom: 26px;
            text-shadow: 0 4px 24px rgba(0,0,0,0.4);
            opacity: 0;
            animation: fadeUp 0.8s 0.25s forwards;
        }

        .hero-title em {
            font-style: italic;
            color: var(--green-accent);
        }

        .hero-sub {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.75;
            color: rgba(255,255,255,0.72);
            max-width: 440px;
            margin-bottom: 42px;
            opacity: 0;
            animation: fadeUp 0.8s 0.4s forwards;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            align-items: center;
            opacity: 0;
            animation: fadeUp 0.8s 0.55s forwards;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--green-mid);
            color: var(--white);
            padding: 15px 34px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            border: 1px solid var(--green-bright);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--green-bright);
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        .btn-primary svg { transition: transform 0.3s ease; }
        .btn-primary:hover svg { transform: translateX(4px); }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: rgba(255,255,255,0.65);
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s ease;
            padding: 15px 20px;
        }

        .btn-ghost:hover { color: var(--white); }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 56px;
            padding-top: 40px;
            border-top: 1px solid rgba(255,255,255,0.12);
            opacity: 0;
            animation: fadeUp 0.8s 0.7s forwards;
        }

        .stat-num {
            font-family: "Playfair Display", serif;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.71rem;
            color: rgba(255,255,255,0.48);
            margin-top: 5px;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        /* Floating availability tag — bottom right */
        .hero-float-tag {
            position: absolute;
            bottom: 48px;
            right: 56px;
            z-index: 3;
            background: rgba(10, 10, 10, 0.82);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(16px);
            padding: 18px 22px;
            border-radius: 16px;
            min-width: 170px;
            opacity: 0;
            animation: fadeUp 0.8s 0.9s forwards;
        }

        .float-tag-label {
            font-size: 0.65rem;
            color: rgba(255,255,255,0.48);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .float-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            background: var(--green-accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .float-tag-value {
            font-family: "Playfair Display", serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--green-accent);
            margin-top: 6px;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(109,191,95,0.5); }
            50%       { opacity: 0.6; box-shadow: 0 0 0 5px rgba(109,191,95,0); }
        }

        /* ─────────────────────────────────────────────────────
           MARQUEE STRIP
           ───────────────────────────────────────────────────── */
        .marquee-strip {
            background: var(--green-mid);
            padding: 13px 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee-inner {
            display: inline-flex;
            gap: 48px;
            animation: marquee 20s linear infinite;
        }

        .marquee-item {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .marquee-dot {
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--green-accent);
        }

        /* ─────────────────────────────────────────────────────
           SECTIONS BASE
           ───────────────────────────────────────────────────── */
        section { padding: 96px 64px; }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--green-accent);
            margin-bottom: 14px;
        }

        .section-label::before {
            content: "";
            width: 22px;
            height: 1px;
            background: var(--green-accent);
        }

        .section-title {
            font-family: "Playfair Display", serif;
            font-size: clamp(1.9rem, 3.5vw, 3rem);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        /* ─────────────────────────────────────────────────────
           FEATURES STRIP
           ───────────────────────────────────────────────────── */
        .features-strip {
            background: var(--off-black);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 56px 64px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 36px;
        }

        .feature-item {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 24px 20px;
            border-radius: 16px;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: var(--dark-card);
            border-color: var(--border);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(45, 90, 39, 0.2);
            border: 1px solid rgba(74, 140, 64, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--green-accent);
        }

        .feature-title {
            font-weight: 600;
            font-size: 0.94rem;
            color: var(--white);
        }

        .feature-desc {
            font-size: 0.8rem;
            color: var(--gray);
            line-height: 1.65;
        }

        /* ─────────────────────────────────────────────────────
           CAFES SECTION
           ───────────────────────────────────────────────────── */
        .cafes-section {
            background: var(--off-black);
            position: relative;
            overflow: hidden;
        }

        /* Subtle texture overlay from cafe image */
        .cafes-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=1400&q=50');
            background-size: cover;
            background-position: center;
            opacity: 0.035;
            pointer-events: none;
            z-index: 0;
        }

        .cafes-section > * { position: relative; z-index: 1; }

        .cafes-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 48px;
            gap: 24px;
        }

        .cafes-header-right {
            font-size: 0.88rem;
            color: var(--gray);
            max-width: 280px;
            line-height: 1.6;
        }

        .cafe-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        /* ── Cafe Card ── */
        .cafe-card {
            background: var(--dark-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }

        .cafe-card:hover {
            transform: translateY(-8px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-lg);
        }

        .cafe-img-wrap {
            position: relative;
            overflow: hidden;
            height: 230px;
            background: linear-gradient(135deg, var(--green-deep), var(--dark-card));
        }

        .cafe-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .cafe-card:hover .cafe-img-wrap img { transform: scale(1.06); }

        .cafe-img-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            color: var(--green-accent);
            opacity: 0.5;
            background: linear-gradient(135deg, var(--green-deep), #0e1e0c);
        }

        .cafe-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 45%, rgba(10,10,10,0.92) 100%);
            pointer-events: none;
        }

        .cafe-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: var(--green-mid);
            color: var(--white);
            font-size: 0.67rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
            z-index: 2;
        }

        .cafe-rating {
            position: absolute;
            bottom: 14px;
            right: 14px;
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 6px 11px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .cafe-rating .star { color: #f5c518; }

        .cafe-body {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .cafe-name {
            font-family: "Playfair Display", serif;
            font-size: 1.28rem;
            font-weight: 700;
            margin-bottom: 9px;
            color: var(--white);
        }

        .cafe-desc {
            font-size: 0.85rem;
            color: var(--gray);
            line-height: 1.65;
            margin-bottom: 14px;
            flex-grow: 1;
        }

        .cafe-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 20px;
        }

        .cafe-meta-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.78rem;
            color: var(--gray);
        }

        .cafe-meta-item i { color: var(--green-accent); }

        .cafe-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .price-tag {
            font-size: 0.76rem;
            color: var(--gray);
        }

        .price-tag strong {
            color: var(--white);
            font-size: 0.92rem;
        }

        .btn-reserve {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: transparent;
            border: 1px solid var(--green-mid);
            color: var(--green-accent);
            padding: 9px 18px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-reserve:hover {
            background: var(--green-mid);
            color: var(--white);
            box-shadow: 0 6px 20px rgba(45, 90, 39, 0.35);
        }

        .cafes-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }

        .cafes-empty-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        .cafes-empty-title {
            font-family: "Playfair Display", serif;
            font-size: 1.4rem;
            color: var(--white);
            margin-bottom: 8px;
        }

        .cafes-empty-action { margin-top: 20px; }

        /* ─────────────────────────────────────────────────────
           CTA SECTION — BACKGROUND IMAGE
           ───────────────────────────────────────────────────── */
        .cta-section {
            position: relative;
            text-align: center;
            overflow: hidden;
        }

        .cta-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .cta-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 60%;
        }

        .cta-overlay {
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg,
                rgba(5, 18, 4, 0.93) 0%,
                rgba(8, 22, 6, 0.88) 50%,
                rgba(5, 18, 4, 0.95) 100%
            );
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta-tagline {
            font-family: "Playfair Display", serif;
            font-size: clamp(2.4rem, 5vw, 4.8rem);
            font-weight: 900;
            line-height: 1.05;
            letter-spacing: -0.03em;
            margin: 14px auto 26px;
            max-width: 660px;
            text-shadow: 0 4px 24px rgba(0,0,0,0.4);
        }

        .cta-tagline em {
            font-style: italic;
            color: var(--green-accent);
        }

        .cta-sub {
            color: rgba(255,255,255,0.6);
            font-size: 0.97rem;
            max-width: 400px;
            margin: 0 auto 40px;
            line-height: 1.7;
        }

        /* ─────────────────────────────────────────────────────
           FOOTER
           ───────────────────────────────────────────────────── */
        footer {
            background: var(--black);
            border-top: 1px solid var(--border);
            padding: 36px 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
        }

        .footer-brand { display: flex; align-items: center; gap: 12px; }

        .footer-logo-text {
            font-family: "Playfair Display", serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--white);
        }

        .footer-logo-text span { color: var(--green-accent); }

        .footer-copy { font-size: 0.78rem; color: var(--gray); }

        .footer-links { display: flex; gap: 22px; list-style: none; }

        .footer-links a {
            font-size: 0.78rem;
            color: var(--gray);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-links a:hover { color: var(--white); }

        /* ─────────────────────────────────────────────────────
           ANIMATIONS
           ───────────────────────────────────────────────────── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(22px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─────────────────────────────────────────────────────
           RESPONSIVE
           ───────────────────────────────────────────────────── */
        @media (max-width: 1024px) {
            .hero-content { padding: 0 32px; margin-top: 100px; }
            .hero-float-tag { right: 24px; bottom: 32px; }
            .hero-title { font-size: clamp(2.6rem, 8vw, 4.2rem); }
            .hero-stats { gap: 28px; flex-wrap: wrap; }

            .cafe-grid { grid-template-columns: repeat(2, 1fr); }
            .features-strip { grid-template-columns: repeat(2, 1fr); }

            section { padding: 72px 32px; }
            nav { padding: 16px 24px; }
            nav.scrolled { padding: 10px 24px; }

            .nav-links { display: none; }
            .nav-toggle { display: flex; }

            footer { flex-direction: column; text-align: center; padding: 32px 24px; }
            .footer-links { justify-content: center; }
        }

        @media (max-width: 640px) {
            .cafe-grid { grid-template-columns: 1fr; }
            .features-strip { grid-template-columns: 1fr; padding: 36px 20px; }

            .cafes-header { flex-direction: column; align-items: flex-start; gap: 14px; }
            .cafes-header-right { text-align: left; max-width: 100%; }

            .hero-content { padding: 0 22px; margin-top: 90px; }
            .hero-float-tag { display: none; }
            .hero-actions { flex-direction: column; align-items: flex-start; gap: 12px; }
            .btn-ghost { padding: 12px 0; }

            section { padding: 56px 20px; }
        }
    </style>
</head>
<body>

    {{-- ═══════════════════ NAVBAR ═══════════════════ --}}
    <nav id="mainNav">
        <a href="{{ route('home') }}" class="nav-logo">
            @if(file_exists(public_path('images/logo.jpeg')))
                <img src="{{ asset('images/logo.jpeg') }}" alt="PLANOVA Logo">
            @endif
            <span class="nav-logo-text">PLANO<span>VA</span></span>
        </a>

        <ul class="nav-links">
            <li><a href="#cafes" class="{{ request()->is('/') ? 'active' : '' }}">Cafe Kami</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#kontak">Kontak</a></li>
            @auth
                <li><a href="{{ route('reservations.index') }}">Riwayat</a></li>
            @endauth
            <li>
                @auth
                    <a href="{{ route('reservations.create') }}" class="nav-cta">Reservasi</a>
                @else
                    <a href="{{ route('login') }}" class="nav-cta">Masuk</a>
                @endauth
            </li>
        </ul>

        <button class="nav-toggle" aria-label="Toggle menu" onclick="toggleMobileMenu()">
            <span></span><span></span><span></span>
        </button>
    </nav>

    {{-- ═══════════════════ HERO SECTION ═══════════════════ --}}
    <section class="hero">

        {{-- Background foto cafe --}}
        <div class="hero-bg">
            <img
                src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1800&q=85"
                alt="Suasana Cafe"
                loading="eager"
                fetchpriority="high"
            >
        </div>
        <div class="hero-overlay"></div>

        {{-- Konten hero --}}
        <div class="hero-content">
            <span class="hero-eyebrow">Cafe Reservation Platform</span>

            <h1 class="hero-title">
                Reservasi<br>
                Momen<br>
                <em>Spesial</em><br>
                Anda
            </h1>

            <p class="hero-sub">
                Temukan dan reservasi cafe terbaik di kota untuk setiap momen berharga.
                Pengalaman dining yang tak terlupakan, hanya dalam beberapa klik.
            </p>

            <div class="hero-actions">
                @auth
                    <a href="{{ route('reservations.create') }}" class="btn-primary">
                        Reservasi Sekarang
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">
                        Daftar Gratis
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endauth

                <a href="#cafes" class="btn-ghost">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.35-4.35"/>
                    </svg>
                    Lihat Cafe
                </a>
            </div>

            {{-- <div class="hero-stats">
                <div>
                    <div class="stat-num">12+</div>
                    <div class="stat-label">Cafe Partner</div>
                </div>
                <div>
                    <div class="stat-num">4.9</div>
                    <div class="stat-label">Rating Rata-rata</div>
                </div>
                <div>
                    <div class="stat-num">5k+</div>
                    <div class="stat-label">Reservasi / Bulan</div>
                </div>
            </div>
        </div>

        <div class="hero-float-tag">
            <div class="float-tag-label">
                <span class="float-dot"></span>Tersedia Hari Ini
            </div>
            <div class="float-tag-value">24 Meja</div>
        </div> --}}

    </section>

    {{-- ═══════════════════ MARQUEE STRIP ═══════════════════ --}}
    <div class="marquee-strip">
        <div class="marquee-inner">
            <span class="marquee-item"><span class="marquee-dot"></span>Reservasi Mudah</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Konfirmasi Instan</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Cafe Partner</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Pengalaman Premium</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Tanpa Antrian</span>
            {{-- Duplicate for seamless loop --}}
            <span class="marquee-item"><span class="marquee-dot"></span>Reservasi Mudah</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Konfirmasi Instan</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Cafe Partner</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Pengalaman Premium</span>
            <span class="marquee-item"><span class="marquee-dot"></span>Tanpa Antrian</span>
        </div>
    </div>

    {{-- ═══════════════════ FEATURES STRIP ═══════════════════ --}}
    <div class="features-strip reveal">
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-lightning-charge"></i></div>
            <div class="feature-title">Konfirmasi Instan</div>
            <div class="feature-desc">Reservasi dikonfirmasi real-time, tanpa perlu menunggu balasan.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="feature-title">Jadwal Fleksibel</div>
            <div class="feature-desc">Pilih tanggal dan jam sesuai keinginan, modifikasi kapan saja.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
            <div class="feature-title">Pembayaran Aman</div>
            <div class="feature-desc">Proses pembayaran yang cepat dan aman dengan enkripsi terbaru.</div>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="bi bi-star"></i></div>
            <div class="feature-title">Kurasi Terbaik</div>
            <div class="feature-desc">Hanya cafe terpilih dengan kualitas dan layanan premium.</div>
        </div>
    </div>

    {{-- ═══════════════════ CAFES SECTION ═══════════════════ --}}
    <section class="cafes-section reveal" id="cafes">
        <div class="cafes-header">
            <div>
                <span class="section-label">Partner Kami</span>
                <h2 class="section-title">Pilih Cafe<br>Favoritmu</h2>
            </div>
            <p class="cafes-header-right">
                Setiap cafe dipilih dengan cermat untuk memastikan pengalaman terbaik bagi Anda.
            </p>
        </div>

        <div class="cafe-grid">
            @forelse($cafes as $cafe)
            <a href="{{ auth()->check() ? route('reservations.create', ['cafe_id' => $cafe->id]) : route('login') }}"
               class="cafe-card">

                {{-- Image — tetap dari database --}}
                <div class="cafe-img-wrap">
                    @if($cafe->image)
                        <img src="{{ asset('storage/'.$cafe->image) }}" alt="{{ $cafe->name }}" loading="lazy">
                    @else
                        <div class="cafe-img-placeholder">
                            <i class="bi bi-shop"></i>
                        </div>
                    @endif
                    <div class="cafe-img-overlay"></div>
                    <span class="cafe-badge">Partner</span>
                    <span class="cafe-rating">
                        <i class="bi bi-star-fill star"></i> 4.8
                    </span>
                </div>

                {{-- Content --}}
                <div class="cafe-body">
                    <h3 class="cafe-name">{{ $cafe->name }}</h3>
                    <p class="cafe-desc">{{ Str::limit($cafe->description, 100) }}</p>

                    <div class="cafe-meta">
                        <span class="cafe-meta-item">
                            <i class="bi bi-geo-alt"></i>
                            {{ Str::limit($cafe->address, 35) }}
                        </span>
                        <span class="cafe-meta-item">
                            <i class="bi bi-clock"></i>
                            Buka 08:00 - 22:00
                        </span>
                    </div>

                    <div class="cafe-footer">
                        <span class="price-tag">Mulai dari <strong>Rp 50k</strong></span>
                        <span class="btn-reserve">
                            {{ auth()->check() ? 'Reservasi' : 'Login' }}
                            <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="cafes-empty" style="grid-column: 1 / -1;">
                <div class="cafes-empty-icon">☕</div>
                <h4 class="cafes-empty-title">Cafe Segera Hadir</h4>
                <p>Kami sedang menyiapkan partner cafe terbaik untuk Anda.</p>
                @auth
                    @if(auth()->user()->role === 'admin')
                    <div class="cafes-empty-action">
                        <a href="{{ route('cafes.create') }}" class="btn-reserve">
                            <i class="bi bi-plus-circle"></i> Tambah Cafe Pertama
                        </a>
                    </div>
                    @endif
                @endauth
            </div>
            @endforelse
        </div>
    </section>

    {{-- ═══════════════════ CTA SECTION ═══════════════════ --}}
    <section class="cta-section reveal">

        {{-- Background foto cafe --}}
        <div class="cta-bg">
            <img
                src="https://images.unsplash.com/photo-1493857671505-72967e2e2760?w=1600&q=80"
                alt="Cafe ambiance"
                loading="lazy"
            >
        </div>
        <div class="cta-overlay"></div>

        <div class="cta-content">
            <span class="section-label">Mulai Sekarang</span>
            <h2 class="cta-tagline">
                Buat Setiap<br>
                Momen Jadi<br>
                <em>Tak Terlupakan</em>
            </h2>
            <p class="cta-sub">
                Bergabunglah dengan ribuan pelanggan yang telah menikmati kemudahan reservasi cafe bersama PLANOVA.
            </p>
            @auth
                <a href="{{ route('reservations.create') }}" class="btn-primary" style="font-size:0.97rem;padding:16px 42px;">
                    Buat Reservasi
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-primary" style="font-size:0.97rem;padding:16px 42px;">
                    Daftar &amp; Reservasi Gratis
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            @endauth
        </div>
    </section>

    {{-- ═══════════════════ FOOTER ═══════════════════ --}}
    <footer>
        <div class="footer-brand">
            <span class="footer-logo-text">PLANO<span>VA</span></span>
        </div>
        <p class="footer-copy">&#169; {{ date('Y') }} PLANOVA. Hak cipta dilindungi.</p>
        <ul class="footer-links">
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Syarat &amp; Ketentuan</a></li>
            <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
        </ul>
    </footer>

    {{-- ═══════════════════ JAVASCRIPT ═══════════════════ --}}
    <script>
        // Navbar scroll effect
        document.addEventListener('DOMContentLoaded', function () {
            const nav = document.getElementById('mainNav');
            const onScroll = () => {
                nav.classList.toggle('scrolled', window.scrollY > 40);
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        });

        // Reveal on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Mobile menu toggle
        function toggleMobileMenu() {
            const navLinks = document.querySelector('.nav-links');
            if (!navLinks) return;
            const isHidden = navLinks.style.display !== 'flex';
            navLinks.style.display        = isHidden ? 'flex' : 'none';
            navLinks.style.flexDirection  = 'column';
            navLinks.style.position       = 'absolute';
            navLinks.style.top            = '100%';
            navLinks.style.left           = '0';
            navLinks.style.right          = '0';
            navLinks.style.background     = 'rgba(10,10,10,0.98)';
            navLinks.style.padding        = '20px';
            navLinks.style.borderBottom   = '1px solid rgba(255,255,255,0.08)';
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>

</body>
</html>