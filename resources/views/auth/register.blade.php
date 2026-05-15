<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - PLANOVA</title>
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

        /* Left panel */
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
            margin-bottom: 48px;
        }

        /* Steps indicator */
        .steps-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            padding: 24px 28px;
            max-width: 340px;
            width: 100%;
        }

        .steps-title {
            font-size: 12px;
            color: rgba(255,255,255,0.45);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 18px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }
        .step-item:last-child { margin-bottom: 0; }

        .step-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(92,184,92,0.2);
            border: 1px solid rgba(92,184,92,0.4);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .step-dot i { color: var(--g5); font-size: 14px; }

        .step-text {
            font-size: 13.5px;
            color: rgba(255,255,255,0.75);
            line-height: 1.4;
        }
        .step-text small {
            display: block;
            font-size: 11.5px;
            color: rgba(255,255,255,0.35);
            margin-top: 2px;
        }

        /* Right panel */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
            position: relative;
            overflow-y: auto;
        }

        .panel-right::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(92,184,92,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .register-box {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            padding: 20px 0;
        }

        /* Mobile brand */
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

        .register-heading {
            margin-bottom: 28px;
        }
        .register-heading h2 {
            font-size: 26px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.25;
        }
        .register-heading h2 span { color: var(--g2); }
        .register-heading p {
            font-size: 14px;
            color: var(--muted);
            margin-top: 6px;
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
        .alert i { margin-top: 1px; flex-shrink: 0; }

        /* 2-col row */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Form */
        .form-field {
            margin-bottom: 16px;
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
            font-size: 15px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
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

        .form-input.is-invalid {
            border-color: #e74c3c;
            background: #fff5f5;
        }

        .form-input::placeholder { color: #adc5a8; }

        .invalid-msg {
            font-size: 11.5px;
            color: #e74c3c;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-eye {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            font-size: 14px;
            line-height: 1;
            transition: color 0.2s;
        }
        .btn-eye:hover { color: var(--g2); }

        /* Password strength */
        .strength-wrap { margin-top: 8px; }
        .strength-bar-bg {
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
        }
        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.35s ease;
        }
        .strength-label {
            font-size: 11.5px;
            margin-top: 4px;
            color: var(--muted);
            font-weight: 500;
        }

        /* Terms */
        .terms-row {
            margin-bottom: 22px;
        }
        .terms-label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.6;
        }
        .terms-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--g2);
            margin-top: 2px;
            flex-shrink: 0;
            cursor: pointer;
        }
        .terms-label a {
            color: var(--g2);
            font-weight: 600;
            text-decoration: none;
        }
        .terms-label a:hover { text-decoration: underline; }

        /* CTA */
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

        .btn-cta span {
            position: relative; z-index: 1;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }

        /* Login link */
        .login-row {
            text-align: center;
            margin-top: 22px;
            font-size: 13.5px;
            color: var(--muted);
        }
        .login-row a {
            color: var(--g2);
            font-weight: 600;
            text-decoration: none;
        }
        .login-row a:hover { opacity: 0.75; text-decoration: underline; }

        /* Trust */
        .trust-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 24px;
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

        @media (max-width: 540px) {
            .panel-right { padding: 32px 20px; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
            .trust-row { gap: 12px; flex-wrap: wrap; }
            .register-heading h2 { font-size: 22px; }
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .register-box { animation: fadeUp 0.55s ease forwards; }
        .panel-brand { animation: fadeUp 0.7s ease 0.15s both; }
        .steps-card { animation: fadeUp 0.7s ease 0.3s both; }
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

            <div class="steps-card">
                <div class="steps-title">Mulai dalam 3 langkah</div>

                <div class="step-item">
                    <div class="step-dot"><i class="fas fa-user-pen"></i></div>
                    <div class="step-text">
                        Daftarkan akun kamu
                        <small>Isi data diri & buat password</small>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-dot"><i class="fas fa-store"></i></div>
                    <div class="step-text">
                        Setup profil usaha
                        <small>Tambahkan info café atau UMKM</small>
                    </div>
                </div>

                <div class="step-item">
                    <div class="step-dot"><i class="fas fa-rocket"></i></div>
                    <div class="step-text">
                        Mulai kelola bisnis
                        <small>Reservasi, keuangan & laporan siap</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Register Panel -->
    <div class="panel-right">
        <div class="register-box">

            <!-- Mobile brand -->
            <div class="login-mobile-brand">
                <h1>PLANOVA</h1>
                <p>Manajemen Usaha Modern</p>
            </div>

            <div class="register-heading">
                <h2>Buat akun <span>baru ✨</span></h2>
                <p>Daftar gratis dan mulai kelola bisnis kamu</p>
            </div>

            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nama & WA dalam satu baris -->
                <div class="form-row">
                    <div class="form-field">
                        <label>Nama Lengkap</label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" placeholder="Nama kamu" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                        <div class="invalid-msg"><i class="fas fa-info-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Nomor WhatsApp</label>
                        <div class="input-wrap">
                            <i class="fab fa-whatsapp input-icon"></i>
                            <input type="tel" name="phone" class="form-input @error('phone') is-invalid @enderror" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                        <div class="invalid-msg"><i class="fas fa-info-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="form-field">
                    <label>Alamat Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input @error('email') is-invalid @enderror" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-msg"><i class="fas fa-info-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-field">
                    <label>Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-input @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter" required>
                        <button type="button" class="btn-eye" onclick="togglePw('password','eye1')" aria-label="Tampilkan password">
                            <i class="fas fa-eye" id="eye1"></i>
                        </button>
                    </div>
                    <div class="strength-wrap">
                        <div class="strength-bar-bg">
                            <div class="strength-bar" id="strength-bar"></div>
                        </div>
                        <div class="strength-label" id="strength-label"></div>
                    </div>
                    @error('password')
                    <div class="invalid-msg"><i class="fas fa-info-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-field">
                    <label>Konfirmasi Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="pw-confirm" class="form-input" placeholder="Ulangi password" required>
                        <button type="button" class="btn-eye" onclick="togglePw('pw-confirm','eye2')" aria-label="Tampilkan konfirmasi">
                            <i class="fas fa-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>

                <!-- Terms -->
                <div class="terms-row">
                    <label class="terms-label">
                        <input type="checkbox" name="terms" required>
                        <span>Saya setuju dengan <a href="#">Syarat & Ketentuan</a> serta <a href="#">Kebijakan Privasi</a> Planova</span>
                    </label>
                </div>

                <button type="submit" class="btn-cta">
                    <span>
                        Daftar Sekarang
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </button>
            </form>

            <div class="login-row">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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
                    <span>Gratis Selamanya</span>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePw(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('password').addEventListener('input', function () {
            const val = this.value;
            const bar = document.getElementById('strength-bar');
            const label = document.getElementById('strength-label');
            let score = 0;

            if (val.length >= 8) score++;
            if (/[a-z]/.test(val) && /[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^a-zA-Z0-9]/.test(val)) score++;

            const levels = [
                { w: '0%',   color: 'transparent', text: '' },
                { w: '25%',  color: '#e74c3c',     text: 'Lemah' },
                { w: '50%',  color: '#f59e0b',     text: 'Sedang' },
                { w: '75%',  color: '#3b82f6',     text: 'Kuat' },
                { w: '100%', color: '#16a34a',     text: 'Sangat Kuat' },
            ];

            bar.style.width = levels[score].w;
            bar.style.backgroundColor = levels[score].color;
            label.textContent = levels[score].text;
            label.style.color = levels[score].color;
        });
    </script>
</body>
</html>