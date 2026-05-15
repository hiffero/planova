<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLANOVA</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --g1: #1a3d17;
            --g2: #2d5a27;
            --g3: #4a7c43;
            --g4: #5cb85c;
            --g5: #c5e8b0;
            --g6: #eaf5e4;
            --white: #ffffff;
            --ink: #111a10;
            --muted: #6b7c69;
            --border: rgba(45,90,39,0.12);
            --card-bg: rgba(255,255,255,0.82);
            --input-bg: rgba(234,245,228,0.5);
            --radius-sm: 10px;
            --radius-md: 16px;
            --radius-lg: 24px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--g6);
            overflow-x: hidden;
        }

        /* Left decorative panel */
        .panel-left {
            width: 44%;
            background: var(--g1);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px 48px;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 80%, rgba(92,184,92,0.18) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(74,124,67,0.2) 0%, transparent 55%);
        }

        /* Organic blob shapes */
        .blob {
            position: absolute;
            border-radius: 50%;
            opacity: 0.06;
        }
        .blob-1 {
            width: 340px; height: 340px;
            background: var(--g4);
            top: -80px; right: -80px;
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
        }
        .blob-2 {
            width: 280px; height: 280px;
            background: var(--g5);
            bottom: -60px; left: -60px;
            border-radius: 42% 58% 40% 60% / 60% 44% 56% 40%;
        }
        .blob-3 {
            width: 160px; height: 160px;
            background: var(--g4);
            top: 45%; right: 10%;
            border-radius: 73% 27% 62% 38% / 46% 55% 45% 54%;
            opacity: 0.08;
        }

        /* Decorative leaf SVG */
        .leaf-group {
            position: absolute;
            top: 40px; right: 40px;
            opacity: 0.12;
        }

        .panel-brand {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .brand-icon {
            width: 220px; height: 220px;
            border-radius: 28px;
            overflow: hidden;
            margin: 0 auto 32px;
            border: 3px solid rgba(255,255,255,0.18);
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        }

        .brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            color: var(--white);
            letter-spacing: 4px;
            line-height: 1;
            margin-bottom: 12px;
        }

        .brand-tagline {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 56px;
        }

        .panel-quote {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            max-width: 340px;
            backdrop-filter: blur(4px);
        }

        .panel-quote p {
            font-size: 15px;
            color: rgba(255,255,255,0.8);
            line-height: 1.75;
            font-style: italic;
        }

        .panel-quote .quote-author {
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quote-dot {
            width: 32px; height: 32px;
            background: rgba(92,184,92,0.3);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
        }
        .quote-dot i { color: var(--g5); font-size: 14px; }

        .quote-author span {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 0.5px;
        }

        /* Floating stats */
        .panel-stats {
            display: flex;
            gap: 16px;
            margin-top: 40px;
        }

        .stat-pill {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 40px;
            padding: 10px 18px;
            text-align: center;
        }
        .stat-num {
            display: block;
            font-size: 18px;
            font-weight: 600;
            color: var(--g5);
        }
        .stat-label {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            letter-spacing: 0.5px;
        }

        /* Right login area */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            position: relative;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(92,184,92,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .login-mobile-brand {
            display: none;
            text-align: center;
            margin-bottom: 36px;
        }
        .login-mobile-brand h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--g1);
            letter-spacing: 3px;
        }
        .login-mobile-brand p {
            font-size: 12px;
            color: var(--muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
        }

        .login-heading {
            margin-bottom: 32px;
        }

        .login-heading h2 {
            font-size: 26px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.25;
        }
        .login-heading h2 span {
            color: var(--g2);
        }
        .login-heading p {
            font-size: 14px;
            color: var(--muted);
            margin-top: 6px;
        }

        /* Tabs */
        .method-tabs {
            display: flex;
            gap: 6px;
            background: var(--g6);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 4px;
            margin-bottom: 28px;
        }

        .method-tab {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 12px;
            font-size: 13.5px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            color: var(--muted);
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .method-tab.active {
            background: var(--white);
            color: var(--g1);
            box-shadow: 0 1px 6px rgba(0,0,0,0.07), 0 0 0 1px var(--border);
        }

        .method-tab i { font-size: 16px; }

        .method-tab.active .tab-dot {
            width: 6px; height: 6px;
            background: var(--g3);
            border-radius: 50%;
            display: inline-block;
        }

        /* Alert */
        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .alert-error {
            background: #fff2f2;
            border: 1px solid #ffd6d6;
            color: #c0392b;
        }
        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
        .alert i { margin-top: 1px; flex-shrink: 0; }

        /* Form */
        .form-field {
            margin-bottom: 18px;
        }

        .form-field label {
            display: block;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 7px;
            letter-spacing: 0.2px;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            color: var(--g3);
            font-size: 16px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 13px 14px 13px 42px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--ink);
            background: var(--input-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.25s ease;
            outline: none;
        }

        .form-input:hover {
            border-color: rgba(45,90,39,0.25);
            background: rgba(234,245,228,0.7);
        }

        .form-input:focus {
            border-color: var(--g3);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(74,124,67,0.1);
        }

        .form-input::placeholder { color: #adc5a8; }

        .btn-eye {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            font-size: 15px;
            line-height: 1;
            transition: color 0.2s;
        }
        .btn-eye:hover { color: var(--g2); }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0 18px;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        .divider span {
            font-size: 11.5px;
            color: var(--muted);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Remember row */
        .remember-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 13px;
            color: var(--muted);
        }

        .checkbox-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--g2);
            border-radius: 4px;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--g2);
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }
        .forgot-link:hover { opacity: 0.75; text-decoration: underline; }

        /* CTA Button */
        .btn-cta {
            width: 100%;
            padding: 15px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            color: var(--white);
            background: var(--g1);
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
        }

        .btn-cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.06) 100%);
        }

        .btn-cta::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 2px;
            background: var(--g4);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .btn-cta:hover {
            background: var(--g2);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(26,61,23,0.3);
        }

        .btn-cta:hover::after { transform: scaleX(1); }
        .btn-cta:active { transform: translateY(0); box-shadow: none; }

        .btn-cta span { position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; gap: 8px; }

        /* Register link */
        .register-row {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: var(--muted);
        }
        .register-row a {
            color: var(--g2);
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        .register-row a:hover { opacity: 0.75; text-decoration: underline; }

        /* Trust badges */
        .trust-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            color: var(--muted);
        }
        .trust-item i { color: var(--g3); font-size: 14px; }

        /* Responsive */
        @media (max-width: 820px) {
            .panel-left { display: none; }
            .panel-right { justify-content: center; }
            .login-mobile-brand { display: block; }
        }

        @media (max-width: 480px) {
            .panel-right { padding: 32px 20px; }
            .login-heading h2 { font-size: 22px; }
            .trust-row { gap: 12px; flex-wrap: wrap; }
        }

        /* Fade-in animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-box { animation: fadeUp 0.55s ease forwards; }
        .panel-brand { animation: fadeUp 0.7s ease 0.15s both; }
        .panel-quote { animation: fadeUp 0.7s ease 0.3s both; }
        .panel-stats { animation: fadeUp 0.7s ease 0.45s both; }
    </style>
</head>
<body>

    <!-- Left Branding Panel -->
    <div class="panel-left">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>

        <svg class="leaf-group" width="120" height="120" viewBox="0 0 120 120" fill="none">
            <path d="M100 10C80 20 70 50 60 70C50 90 30 110 10 118C5 120 2 116 4 112C6 108 14 104 26 96C44 86 60 66 68 48C76 30 82 10 100 10Z" fill="white"/>
            <path d="M70 5C55 14 50 38 44 54C38 70 24 88 8 96" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
        </svg>

        <div class="panel-brand">
            <div class="brand-icon">
                <img src="{{ asset('images/logo.jpeg') }}" alt="PLANOVA Logo">
            </div>
            <div class="brand-tagline">Manajemen Usaha Modern</div>

            <div class="panel-quote">
                <p>"Website reservasi cafe yang memudahkan pelanggan dalam memesan meja secara online dengan cepat dan praktis."</p>
                <div class="quote-author">
                    <div class="quote-dot"><i class="fas fa-check"></i></div>
                    <span>Dipercaya ribuan pemilik usaha</span>
                </div>
            </div>

            <div class="panel-stats">
                <div class="stat-pill">
                    <span class="stat-num">12K+</span>
                    <span class="stat-label">Pengguna</span>
                </div>
                <div class="stat-pill">
                    <span class="stat-num">98%</span>
                    <span class="stat-label">Kepuasan</span>
                </div>
                <div class="stat-pill">
                    <span class="stat-num">4.9★</span>
                    <span class="stat-label">Rating</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Login Panel -->
    <div class="panel-right">
        <div class="login-box">

            <!-- Mobile brand -->
            <div class="login-mobile-brand">
                <h1>PLANOVA</h1>
                <p>Manajemen Usaha Modern</p>
            </div>

            <div class="login-heading">
                <h2>Selamat datang <span>kembali 👋</span></h2>
                <p>Masuk ke akun Planova untuk melanjutkan</p>
            </div>

            <!-- Alert messages -->
            @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Method Tabs -->
                <div class="method-tabs">
                    <button type="button" class="method-tab active" onclick="switchTab('email')" id="tab-email">
                        <i class="fas fa-envelope"></i> Email
                        <span class="tab-dot"></span>
                    </button>
                    <button type="button" class="method-tab" onclick="switchTab('whatsapp')" id="tab-wa">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </button>
                </div>

                <!-- Email -->
                <div class="form-field" id="email-field">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" class="form-input" placeholder="nama@email.com" value="{{ old('email') }}" autocomplete="email">
                    </div>
                </div>

                <!-- WhatsApp -->
                <div class="form-field" id="wa-field" style="display:none;">
                    <label for="whatsapp">Nomor WhatsApp</label>
                    <div class="input-wrap">
                        <i class="fab fa-whatsapp input-icon"></i>
                        <input id="whatsapp" type="tel" name="whatsapp" class="form-input" placeholder="08xxxxxxxxxx" autocomplete="tel">
                    </div>
                </div>

                <div class="divider"><span>dan</span></div>

                <!-- Password -->
                <div class="form-field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" class="form-input" placeholder="Masukkan password kamu" autocomplete="current-password">
                        <button type="button" class="btn-eye" onclick="togglePw()" aria-label="Tampilkan password">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="remember-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                    @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @else
                    <a href="#" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-cta">
                    <span>
                        Masuk ke Planova
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </button>
            </form>

            <div class="register-row">
                Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
            </div>

            <div class="trust-row">
                <div class="trust-item">
                    <i class="fas fa-shield-halved"></i>
                    <span>SSL Aman</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-lock"></i>
                    <span>Data Terenkripsi</span>
                </div>
                <div class="trust-item">
                    <i class="fas fa-circle-check"></i>
                    <span>Terpercaya</span>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchTab(tab) {
            const emailField = document.getElementById('email-field');
            const waField = document.getElementById('wa-field');
            const tabEmail = document.getElementById('tab-email');
            const tabWa = document.getElementById('tab-wa');

            if (tab === 'email') {
                emailField.style.display = 'block';
                waField.style.display = 'none';
                tabEmail.classList.add('active');
                tabWa.classList.remove('active');
                tabEmail.innerHTML = '<i class="fas fa-envelope"></i> Email <span class="tab-dot"></span>';
                tabWa.innerHTML = '<i class="fab fa-whatsapp"></i> WhatsApp';
            } else {
                emailField.style.display = 'none';
                waField.style.display = 'block';
                tabWa.classList.add('active');
                tabEmail.classList.remove('active');
                tabWa.innerHTML = '<i class="fab fa-whatsapp"></i> WhatsApp <span class="tab-dot"></span>';
                tabEmail.innerHTML = '<i class="fas fa-envelope"></i> Email';
            }
        }

        function togglePw() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>