<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Reservasi - PLANOVA</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ═══ TOKENS ═══ */
        :root {
            --black:    #0a0a0a;
            --ink:      #111111;
            --dark:     #1a1a1a;
            --card:     #161616;
            --card2:    #1c1c1c;
            --border:   rgba(255,255,255,0.07);
            --border-g: rgba(92,184,92,0.3);
            --green:    #5cb85c;
            --green-d:  #3d8b3d;
            --green-l:  #8edb8e;
            --green-xd: #1f4d1f;
            --amber:    #f59e0b;
            --amber-l:  #fcd34d;
            --red:      #ef4444;
            --red-l:    #fc8181;
            --white:    #ffffff;
            --offwhite: #f4f4f4;
            --muted:    #888888;
            --muted2:   #444444;
            --radius:   14px;
            --radius-lg:22px;
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

        /* Noise overlay */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0; opacity: 0.6;
        }

        /* Ambient glows */
        .ambient { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; z-index: 0; }
        .ambient-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(92,184,92,0.1) 0%, transparent 70%);
            top: -150px; right: -100px;
            animation: drift 18s ease-in-out infinite;
        }
        .ambient-2 {
            width: 360px; height: 360px;
            background: radial-gradient(circle, rgba(61,139,61,0.07) 0%, transparent 70%);
            bottom: -80px; left: -80px;
            animation: drift 22s ease-in-out infinite reverse;
        }
        @keyframes drift {
            0%,100% { transform: translate(0,0) scale(1); }
            33%  { transform: translate(30px,-25px) scale(1.06); }
            66%  { transform: translate(-20px,18px) scale(0.94); }
        }

        /* ════ TOPBAR ════ */
        .topbar {
            position: sticky; top: 0; z-index: 200;
            background: rgba(10,10,10,0.88);
            backdrop-filter: blur(24px);
            border-bottom: 1px solid var(--border);
            padding: 0 32px; height: 62px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .topbar-left { display: flex; align-items: center; gap: 10px; }

        .nav-back {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 14px;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--muted); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.25s;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-back:hover { border-color: var(--border-g); color: var(--white); background: rgba(255,255,255,0.04); }

        .topbar-brand {
            font-family: 'Syne', sans-serif;
            font-size: 20px; font-weight: 800; letter-spacing: 2px;
            text-decoration: none; display: flex; align-items: center; gap: 4px;
        }
        .brand-white { color: var(--white); }
        .brand-green { color: var(--green); }

        .nav-logout {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: var(--muted); font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'DM Sans', sans-serif;
            text-decoration: none; transition: all 0.25s;
        }
        .nav-logout:hover { border-color: rgba(239,68,68,0.4); color: var(--red-l); background: rgba(239,68,68,0.06); }

        /* ════ PAGE HEADER ════ */
        .page-header {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 44px 28px 32px;
            display: flex; flex-wrap: wrap;
            align-items: flex-end; justify-content: space-between; gap: 20px;
        }

        .header-left {}
        .header-eyebrow {
            font-size: 11px; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            color: var(--green); margin-bottom: 10px;
            display: flex; align-items: center; gap: 8px;
        }
        .header-eyebrow::before {
            content: '';
            width: 20px; height: 2px;
            background: var(--green); border-radius: 2px;
        }

        .page-title {
            font-family: 'Syne', sans-serif;
            font-size: 36px; font-weight: 800;
            color: var(--white); line-height: 1.1;
            letter-spacing: -0.5px; margin: 0;
        }
        .page-title span { color: var(--green); }

        .btn-create {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 13px 24px;
            background: var(--green);
            color: var(--black);
            border: none; border-radius: var(--radius);
            font-family: 'Syne', sans-serif;
            font-size: 14px; font-weight: 700; letter-spacing: 0.3px;
            text-decoration: none;
            transition: all 0.28s ease;
            box-shadow: 0 0 0 0 rgba(92,184,92,0);
            position: relative; overflow: hidden;
        }
        .btn-create::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.18), transparent);
            opacity: 0; transition: opacity 0.3s;
        }
        .btn-create:hover { background: #6dcf6d; transform: translateY(-2px); box-shadow: 0 10px 32px rgba(92,184,92,0.35); }
        .btn-create:hover::before { opacity: 1; }
        .btn-create i { font-size: 15px; transition: transform 0.25s; }
        .btn-create:hover i { transform: rotate(90deg); }

        /* ════ STATS BAR ════ */
        .stats-bar {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 0 28px 32px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .stat-chip {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            display: flex; align-items: center; gap: 16px;
            position: relative; overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-chip:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(0,0,0,0.4); }
        .stat-chip::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
        }
        .stat-chip.pending::before  { background: var(--amber); }
        .stat-chip.approved::before { background: var(--green); }
        .stat-chip.rejected::before { background: var(--red); }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .stat-chip.pending .stat-icon  { background: rgba(245,158,11,0.1); color: var(--amber); }
        .stat-chip.approved .stat-icon { background: rgba(92,184,92,0.1);  color: var(--green); }
        .stat-chip.rejected .stat-icon { background: rgba(239,68,68,0.1);  color: var(--red); }

        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 28px; font-weight: 800; line-height: 1;
        }
        .stat-chip.pending .stat-num  { color: var(--amber-l); }
        .stat-chip.approved .stat-num { color: var(--green-l); }
        .stat-chip.rejected .stat-num { color: var(--red-l); }

        .stat-lbl { font-size: 12px; color: var(--muted); margin-top: 3px; }

        /* ════ RESERVATION GRID ════ */
        .res-grid {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 0 28px 80px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 18px;
        }

        /* ── Card ── */
        .res-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            animation: riseUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
            box-shadow: 0 4px 24px rgba(0,0,0,0.35);
        }
        .res-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.55);
            border-color: rgba(255,255,255,0.12);
        }
        .res-card:nth-child(1) { animation-delay: 0.05s; }
        .res-card:nth-child(2) { animation-delay: 0.12s; }
        .res-card:nth-child(3) { animation-delay: 0.19s; }
        .res-card:nth-child(4) { animation-delay: 0.26s; }
        .res-card:nth-child(5) { animation-delay: 0.33s; }
        .res-card:nth-child(6) { animation-delay: 0.40s; }

        @keyframes riseUp {
            from { opacity:0; transform: translateY(28px) scale(0.97); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* Card top accent line */
        .res-card::before {
            content: '';
            display: block; height: 2px;
        }
        .res-card.pending::before  { background: linear-gradient(90deg, var(--amber), transparent); }
        .res-card.approved::before { background: linear-gradient(90deg, var(--green), transparent); }
        .res-card.rejected::before { background: linear-gradient(90deg, var(--red), transparent); }

        /* Card header */
        .rc-head {
            padding: 18px 20px 14px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px;
        }

        .rc-status {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px;
            border-radius: 40px;
            font-size: 12px; font-weight: 600;
            border: 1px solid;
        }
        .rc-status.pending  { background: rgba(245,158,11,0.08); border-color: rgba(245,158,11,0.3); color: var(--amber-l); }
        .rc-status.approved { background: rgba(92,184,92,0.08);  border-color: rgba(92,184,92,0.3);  color: var(--green-l); }
        .rc-status.rejected { background: rgba(239,68,68,0.08);  border-color: rgba(239,68,68,0.3);  color: var(--red-l); }
        .rc-status i { font-size: 11px; }

        .rc-id {
            font-family: 'Syne', sans-serif;
            font-size: 11px; font-weight: 700;
            color: var(--muted2); letter-spacing: 1px;
        }

        /* Card body */
        .rc-body { padding: 18px 20px; flex: 1; }

        .rc-cafe {
            font-family: 'Syne', sans-serif;
            font-size: 17px; font-weight: 700;
            color: var(--white); margin-bottom: 4px;
            display: flex; align-items: center; gap: 8px;
        }
        .rc-cafe i { color: var(--green); font-size: 15px; }

        .rc-desc {
            font-size: 12.5px; color: var(--muted);
            margin-bottom: 18px; line-height: 1.5;
        }

        /* Detail grid */
        .rc-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 16px;
            margin-bottom: 18px;
        }

        .rc-detail-item {}
        .rc-detail-label {
            font-size: 10.5px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--muted2);
            display: flex; align-items: center; gap: 5px;
            margin-bottom: 4px;
        }
        .rc-detail-label i { font-size: 11px; color: var(--green); }
        .rc-detail-val {
            font-size: 14px; font-weight: 600; color: var(--offwhite);
        }

        /* Separator */
        .rc-sep {
            height: 1px; background: var(--border);
            margin: 0 0 16px;
        }

        /* Payment proof */
        .rc-proof {
            margin-bottom: 14px;
        }
        .rc-proof-label {
            font-size: 10.5px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--muted2);
            display: flex; align-items: center; gap: 5px;
            margin-bottom: 8px;
        }
        .rc-proof-label i { color: var(--green); font-size: 11px; }

        .btn-proof {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 16px;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--muted); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.25s;
        }
        .btn-proof:hover { border-color: var(--border-g); color: var(--green-l); background: rgba(92,184,92,0.06); }
        .btn-proof i { font-size: 14px; }

        /* Notes */
        .rc-notes {
            padding: 12px 14px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-left: 3px solid var(--green);
            border-radius: 0 var(--radius) var(--radius) 0;
            font-size: 13px; color: var(--muted); line-height: 1.5;
        }
        .rc-notes strong { color: var(--offwhite); display: block; margin-bottom: 3px; font-size: 12px; }

        /* Card footer */
        .rc-foot {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
        }

        .rc-status-msg {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            border-radius: var(--radius);
            font-size: 13px; line-height: 1.5;
            border: 1px solid;
        }
        .rc-status-msg.pending  { background: rgba(245,158,11,0.06); border-color: rgba(245,158,11,0.2); color: var(--amber-l); }
        .rc-status-msg.approved { background: rgba(92,184,92,0.06);  border-color: rgba(92,184,92,0.2);  color: var(--green-l); }
        .rc-status-msg.rejected { background: rgba(239,68,68,0.06);  border-color: rgba(239,68,68,0.2);  color: var(--red-l); }
        .rc-status-msg i { font-size: 17px; flex-shrink: 0; }
        .rc-status-msg .msg-text strong { display: block; font-size: 13px; font-weight: 600; margin-bottom: 1px; }
        .rc-status-msg .msg-text small  { font-size: 12px; opacity: 0.75; }

        /* ════ EMPTY STATE ════ */
        .empty-wrap {
            position: relative; z-index: 1;
            max-width: 480px; margin: 80px auto;
            padding: 0 24px;
            text-align: center;
            animation: riseUp 0.5s ease both;
        }

        .empty-icon-ring {
            width: 100px; height: 100px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--card);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            font-size: 40px; color: var(--muted2);
            box-shadow: 0 0 0 8px rgba(255,255,255,0.02);
        }

        .empty-title {
            font-family: 'Syne', sans-serif;
            font-size: 26px; font-weight: 800;
            color: var(--white); margin-bottom: 12px;
        }
        .empty-desc {
            font-size: 14.5px; color: var(--muted);
            line-height: 1.7; margin-bottom: 32px;
        }

        /* ════ FOOTER ════ */
        .page-footer {
            position: relative; z-index: 1;
            text-align: center; padding: 24px 16px 40px;
            font-size: 13px; color: var(--muted2);
            border-top: 1px solid var(--border);
        }
        .page-footer a { color: var(--green); text-decoration: none; font-weight: 500; }
        .page-footer a:hover { color: var(--green-l); }
        .footer-brand { font-family: 'Syne', sans-serif; font-weight: 800; letter-spacing: 1.5px; color: var(--white); }

        /* ════ RESPONSIVE ════ */
        @media (max-width: 900px) {
            .stats-bar { grid-template-columns: 1fr; }
            .res-grid  { grid-template-columns: 1fr; padding: 0 20px 60px; }
        }
        @media (max-width: 640px) {
            .topbar { padding: 0 16px; }
            .topbar-brand { font-size: 17px; }
            .page-header { padding: 28px 20px 20px; flex-direction: column; align-items: flex-start; }
            .page-title { font-size: 28px; }
            .btn-create { width: 100%; justify-content: center; }
            .stats-bar { padding: 0 20px 24px; }
            .rc-details { grid-template-columns: 1fr; }
            .nav-back span, .nav-logout span { display: none; }
        }
    </style>
</head>
<body>

    <div class="ambient ambient-1"></div>
    <div class="ambient ambient-2"></div>

    {{-- ════ TOPBAR ════ --}}
    <nav class="topbar">
        <div class="topbar-left">
            <a href="{{ route('home') }}" class="nav-back">
                <i class="fas fa-arrow-left"></i>
                <span>Beranda</span>
            </a>
        </div>

        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="brand-white">PLANO</span><span class="brand-green">VA</span>
        </a>

        <div>
            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                <button type="button" class="nav-logout"
                    onclick="if(confirm('Yakin ingin logout?')) document.getElementById('logout-form').submit()">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            @else
                <a href="{{ route('login') }}" class="nav-logout" style="text-decoration:none;">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </nav>

    {{-- ════ PAGE HEADER ════ --}}
    <header class="page-header">
        <div class="header-left">
            <div class="header-eyebrow">Riwayat</div>
            <h1 class="page-title">Reservasi<br><span>Kamu</span></h1>
        </div>
        <a href="{{ route('reservations.create') }}" class="btn-create">
            <i class="fas fa-plus"></i>
            Buat Reservasi Baru
        </a>
    </header>

    {{-- ════ MAIN ════ --}}
    <main>
        @if($reservations->count() > 0)

            {{-- Stats --}}
            <div class="stats-bar">
                <div class="stat-chip pending">
                    <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                    <div>
                        <div class="stat-num">{{ $reservations->where('status','pending')->count() }}</div>
                        <div class="stat-lbl">Menunggu Konfirmasi</div>
                    </div>
                </div>
                <div class="stat-chip approved">
                    <div class="stat-icon"><i class="fas fa-circle-check"></i></div>
                    <div>
                        <div class="stat-num">{{ $reservations->where('status','approved')->count() }}</div>
                        <div class="stat-lbl">Disetujui</div>
                    </div>
                </div>
                <div class="stat-chip rejected">
                    <div class="stat-icon"><i class="fas fa-circle-xmark"></i></div>
                    <div>
                        <div class="stat-num">{{ $reservations->where('status','rejected')->count() }}</div>
                        <div class="stat-lbl">Ditolak</div>
                    </div>
                </div>
            </div>

            {{-- Reservation Cards --}}
            <div class="res-grid">
                @foreach($reservations as $reservation)
                <article class="res-card {{ $reservation->status }}">

                    {{-- Header --}}
                    <div class="rc-head">
                        <span class="rc-status {{ $reservation->status }}">
                            @if($reservation->status == 'pending')
                                <i class="fas fa-hourglass-half"></i> Menunggu
                            @elseif($reservation->status == 'approved')
                                <i class="fas fa-circle-check"></i> Disetujui
                            @else
                                <i class="fas fa-circle-xmark"></i> Ditolak
                            @endif
                        </span>
                        <span class="rc-id">#{{ str_pad($reservation->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    {{-- Body --}}
                    <div class="rc-body">
                        <div class="rc-cafe">
                            <i class="fas fa-store"></i>
                            {{ $reservation->cafe->name }}
                        </div>
                        <div class="rc-desc">
                            {{ Str::limit($reservation->cafe->description ?? 'Café pilihan kamu', 65) }}
                        </div>

                        <div class="rc-details">
                            <div class="rc-detail-item">
                                <div class="rc-detail-label"><i class="fas fa-calendar"></i> Tanggal</div>
                                <div class="rc-detail-val">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</div>
                            </div>
                            <div class="rc-detail-item">
                                <div class="rc-detail-label"><i class="fas fa-clock"></i> Waktu</div>
                                <div class="rc-detail-val">{{ $reservation->reservation_time }}</div>
                            </div>
                            <div class="rc-detail-item">
                                <div class="rc-detail-label"><i class="fas fa-users"></i> Tamu</div>
                                <div class="rc-detail-val">{{ $reservation->guests }} Orang</div>
                            </div>
                            <div class="rc-detail-item">
                                <div class="rc-detail-label"><i class="fas fa-calendar-plus"></i> Dibuat</div>
                                <div class="rc-detail-val">{{ $reservation->created_at->format('d M Y') }}</div>
                            </div>
                        </div>

                        <div class="rc-sep"></div>

                        {{-- Payment Proof --}}
                        @if($reservation->payment_proof)
                        <div class="rc-proof">
                            <div class="rc-proof-label"><i class="fas fa-receipt"></i> Bukti Pembayaran</div>
                            <a href="{{ asset('storage/' . $reservation->payment_proof) }}" target="_blank" class="btn-proof">
                                <i class="fas fa-eye"></i>
                                Lihat Bukti Pembayaran
                                <i class="fas fa-arrow-up-right-from-square" style="font-size:11px;margin-left:auto;"></i>
                            </a>
                        </div>
                        @endif

                        {{-- Notes --}}
                        @if($reservation->notes)
                        <div class="rc-notes">
                            <strong><i class="fas fa-comment-dots"></i> Catatan</strong>
                            {{ $reservation->notes }}
                        </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="rc-foot">
                        <div class="rc-status-msg {{ $reservation->status }}">
                            @if($reservation->status == 'approved')
                                <i class="fas fa-circle-check"></i>
                                <div class="msg-text">
                                    <strong>Reservasi Dikonfirmasi</strong>
                                    <small>Silakan datang sesuai jadwal yang tertera.</small>
                                </div>
                            @elseif($reservation->status == 'rejected')
                                <i class="fas fa-circle-xmark"></i>
                                <div class="msg-text">
                                    <strong>Reservasi Ditolak</strong>
                                    <small>Hubungi admin untuk informasi lebih lanjut.</small>
                                </div>
                            @else
                                <i class="fas fa-hourglass-half"></i>
                                <div class="msg-text">
                                    <strong>Menunggu Konfirmasi</strong>
                                    <small>Admin sedang memverifikasi pembayaranmu.</small>
                                </div>
                            @endif
                        </div>
                    </div>

                </article>
                @endforeach
            </div>

        @else

            {{-- Empty State --}}
            <div class="empty-wrap">
                <div class="empty-icon-ring">
                    <i class="fas fa-calendar-xmark"></i>
                </div>
                <h2 class="empty-title">Belum Ada Reservasi</h2>
                <p class="empty-desc">
                    Kamu belum pernah membuat reservasi. Yuk, buat reservasi pertama dan nikmati pengalaman terbaik bersama PLANOVA!
                </p>
                <a href="{{ route('reservations.create') }}" class="btn-create" style="display:inline-flex;">
                    <i class="fas fa-plus"></i>
                    Buat Reservasi Sekarang
                </a>
            </div>

        @endif
    </main>

    {{-- ════ FOOTER ════ --}}
    <footer class="page-footer">
        &copy; {{ date('Y') }} <span class="footer-brand">PLANOVA</span> &nbsp;·&nbsp;
        <a href="{{ route('home') }}">Kembali ke Beranda</a>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Staggered card animation
        document.querySelectorAll('.res-card').forEach((card, i) => {
            card.style.animationDelay = (0.05 + i * 0.07) + 's';
        });
    });
    </script>
</body>
</html>