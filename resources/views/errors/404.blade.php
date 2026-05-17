<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | PLANOVA</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        :root {
            --green-deep: #1a3d17;
            --green-mid: #2d5a27;
            --green-bright: #4a8c40;
            --green-accent: #6dbf5f;
            --black: #0a0a0a;
            --surface: #111111;
            --card: #161616;
            --white: #ffffff;
            --gray: #888888;
            --border: rgba(255,255,255,0.07);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: "DM Sans", sans-serif;
            background: var(--black);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }
        
        .error-container {
            text-align: center;
            max-width: 500px;
            animation: fadeIn 0.5s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .error-code {
            font-family: "Playfair Display", serif;
            font-size: 6rem;
            font-weight: 900;
            color: var(--green-accent);
            line-height: 1;
            margin-bottom: 10px;
            text-shadow: 0 0 40px rgba(109, 191, 95, 0.3);
        }
        
        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--white);
        }
        
        .error-message {
            color: var(--gray);
            margin-bottom: 30px;
            font-size: 0.95rem;
        }
        
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background: var(--green-bright);
            color: var(--black);
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-family: "DM Sans", sans-serif;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-home:hover {
            background: var(--green-accent);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(74, 140, 64, 0.4);
        }
        
        .btn-home i { font-size: 1.1rem; }
        
        .decoration {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            z-index: -1;
        }
        
        .decoration-1 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(92,184,92,0.1) 0%, transparent 70%);
            top: -100px; right: -100px;
        }
        
        .decoration-2 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(61,139,61,0.08) 0%, transparent 70%);
            bottom: -50px; left: -50px;
        }
        
        @media (max-width: 640px) {
            .error-code { font-size: 4rem; }
            .error-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <div class="decoration decoration-1"></div>
    <div class="decoration decoration-2"></div>
    
    <div class="error-container">
        <div class="error-code">404</div>
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        <p class="error-message">
            Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan.
            Silakan kembali ke beranda untuk melanjutkan.
        </p>
        <a href="{{ route('home') }}" class="btn-home">
            <i class="bi bi-house-door"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>