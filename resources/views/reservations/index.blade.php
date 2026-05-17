<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Reservasi - PLANOVA</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,700&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --white:      #ffffff;
            --off:        #f9f9f7;
            --surface:    #f3f4f0;
            --border:     #e4e5e0;
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

        /* grain texture */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
            pointer-events: none; z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0; right: 0;
            width: 500px; height: 500px;
            background: radial-gradient(ellipse at 90% 10%, rgba(45,122,45,0.05) 0%, transparent 55%);
            pointer-events: none; z-index: 0;
        }

        /* ════ TOPBAR ════ */
        .topbar {
            position: sticky; top: 0; z-index: 200;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 0 36px; height: 64px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
            box-shadow: 0 1px 0 var(--border);
        }

        .topbar-left { display: flex; align-items: center; gap: 8px; }

        .nav-back {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 14px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--ink2); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
            font-family: 'Outfit', sans-serif;
            box-shadow: var(--shadow-xs);
        }
        .nav-back:hover { border-color: var(--green-bdr); color: var(--green); background: var(--green-bg); box-shadow: none; }

        .topbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 22px; font-weight: 700; letter-spacing: 1px;
            text-decoration: none; display: flex; align-items: center;
        }
        .brand-ink   { color: var(--ink); }
        .brand-green { color: var(--green); }

        .nav-logout {
            display: flex; align-items: center; gap: 7px;
            padding: 8px 16px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--ink2); font-size: 13px; font-weight: 500;
            cursor: pointer; font-family: 'Outfit', sans-serif;
            text-decoration: none; transition: all 0.2s;
            box-shadow: var(--shadow-xs);
        }
        .nav-logout:hover { border-color: var(--red-bdr); color: var(--red-text); background: var(--red-bg); box-shadow: none; }

        /* ════ PAGE HEADER ════ */
        .page-header {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 48px 32px 32px;
            display: flex; flex-wrap: wrap;
            align-items: flex-end; justify-content: space-between; gap: 24px;
        }

        .header-eyebrow {
            font-size: 11px; font-weight: 600;
            letter-spacing: 2px; text-transform: uppercase;
            color: var(--green); margin-bottom: 10px;
            display: flex; align-items: center; gap: 8px;
        }
        .header-eyebrow::before {
            content: '';
            width: 20px; height: 2px;
            background: var(--green); border-radius: 2px;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 38px; font-weight: 700;
            color: var(--ink); line-height: 1.1;
            letter-spacing: -0.5px; margin: 0;
        }
        .page-title em { font-style: italic; color: var(--green); }

        .btn-create {
            display: inline-flex; align-items: center; gap: 9px;
            padding: 13px 22px;
            background: var(--green);
            color: var(--white);
            border: none; border-radius: var(--radius);
            font-family: 'Outfit', sans-serif;
            font-size: 14px; font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(45,122,45,0.25);
            position: relative; overflow: hidden;
        }
        .btn-create::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12), transparent);
        }
        .btn-create:hover { background: var(--green-l); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(45,122,45,0.3); }
        .btn-create i { font-size: 14px; transition: transform 0.22s; }
        .btn-create:hover i { transform: rotate(90deg); }

        /* ════ STATS BAR ════ */
        .stats-bar {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 0 32px 32px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .stat-chip {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            display: flex; align-items: center; gap: 16px;
            position: relative; overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: var(--shadow-xs);
        }
        .stat-chip:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        /* top accent bar */
        .stat-chip::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            border-radius: 3px 3px 0 0;
        }
        .stat-chip.pending::before  { background: #f59e0b; }
        .stat-chip.approved::before { background: var(--green); }
        .stat-chip.rejected::before { background: #ef4444; }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; flex-shrink: 0;
        }
        .stat-chip.pending .stat-icon  { background: var(--amber-bg); color: var(--amber-text); }
        .stat-chip.approved .stat-icon { background: var(--green-bg); color: var(--green); }
        .stat-chip.rejected .stat-icon { background: var(--red-bg);   color: var(--red-text); }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 30px; font-weight: 700; line-height: 1;
        }
        .stat-chip.pending .stat-num  { color: var(--amber-text); }
        .stat-chip.approved .stat-num { color: var(--green); }
        .stat-chip.rejected .stat-num { color: var(--red-text); }

        .stat-lbl { font-size: 12px; color: var(--ink3); margin-top: 4px; }

        /* ════ RESERVATION GRID ════ */
        .res-grid {
            position: relative; z-index: 1;
            max-width: 1200px; margin: 0 auto;
            padding: 0 32px 80px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 18px;
        }

        /* ── Card ── */
        .res-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
            animation: riseUp 0.5s cubic-bezier(0.16,1,0.3,1) both;
            box-shadow: var(--shadow-sm);
        }
        .res-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--green-bdr);
        }

        @keyframes riseUp {
            from { opacity:0; transform: translateY(24px) scale(0.98); }
            to   { opacity:1; transform: translateY(0) scale(1); }
        }

        /* top accent line */
        .res-card::before {
            content: ''; display: block; height: 3px;
            border-radius: 3px 3px 0 0;
        }
        .res-card.pending::before  { background: linear-gradient(90deg, #f59e0b, #fcd34d 60%, transparent); }
        .res-card.approved::before { background: linear-gradient(90deg, var(--green), var(--green-xl) 60%, transparent); }
        .res-card.rejected::before { background: linear-gradient(90deg, #ef4444, #fc8181 60%, transparent); }

        /* Card header */
        .rc-head {
            padding: 16px 20px 14px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
        }

        .rc-status {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 13px;
            border-radius: 40px;
            font-size: 12px; font-weight: 600;
            border: 1px solid;
        }
        .rc-status.pending  { background: var(--amber-bg);  border-color: var(--amber-bdr); color: var(--amber-text); }
        .rc-status.approved { background: var(--green-bg);  border-color: var(--green-bdr); color: var(--green); }
        .rc-status.rejected { background: var(--red-bg);    border-color: var(--red-bdr);   color: var(--red-text); }
        .rc-status i { font-size: 11px; }

        .rc-id {
            font-family: 'Outfit', sans-serif;
            font-size: 11px; font-weight: 600;
            color: var(--ink3); letter-spacing: 1px;
        }

        /* Card body */
        .rc-body { padding: 18px 20px; flex: 1; }

        .rc-cafe {
            font-family: 'Playfair Display', serif;
            font-size: 17px; font-weight: 700;
            color: var(--ink); margin-bottom: 4px;
            display: flex; align-items: center; gap: 8px;
        }
        .rc-cafe i { color: var(--green); font-size: 14px; }

        .rc-desc {
            font-size: 13px; color: var(--ink3);
            margin-bottom: 18px; line-height: 1.55;
        }

        /* Detail grid */
        .rc-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 16px;
            margin-bottom: 18px;
        }

        .rc-detail-label {
            font-size: 10.5px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--ink3);
            display: flex; align-items: center; gap: 5px;
            margin-bottom: 4px;
        }
        .rc-detail-label i { font-size: 11px; color: var(--green); }
        .rc-detail-val {
            font-size: 14px; font-weight: 600; color: var(--ink);
        }

        .rc-sep {
            height: 1px; background: var(--border);
            margin: 0 0 16px;
        }

        /* Payment proof */
        .rc-proof { margin-bottom: 14px; }
        .rc-proof-label {
            font-size: 10.5px; font-weight: 600; letter-spacing: 1px;
            text-transform: uppercase; color: var(--ink3);
            display: flex; align-items: center; gap: 5px;
            margin-bottom: 8px;
        }
        .rc-proof-label i { color: var(--green); font-size: 11px; }

        .btn-proof {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 10px 16px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            color: var(--ink2); font-size: 13px; font-weight: 500;
            text-decoration: none; transition: all 0.2s;
            box-shadow: var(--shadow-xs);
        }
        .btn-proof:hover { border-color: var(--green-bdr); color: var(--green); background: var(--green-bg); box-shadow: none; }
        .btn-proof i { font-size: 14px; }

        /* Notes */
        .rc-notes {
            padding: 12px 14px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-left: 3px solid var(--green);
            border-radius: 0 var(--radius) var(--radius) 0;
            font-size: 13px; color: var(--ink2); line-height: 1.5;
        }
        .rc-notes strong { color: var(--ink); display: block; margin-bottom: 3px; font-size: 12px; font-weight: 600; }

        /* Card footer */
        .rc-foot {
            padding: 14px 20px;
            border-top: 1px solid var(--border);
            background: var(--off);
        }

        .rc-status-msg {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            border-radius: var(--radius);
            font-size: 13px; line-height: 1.5;
            border: 1px solid;
        }
        .rc-status-msg.pending  { background: var(--amber-bg); border-color: var(--amber-bdr); color: var(--amber-text); }
        .rc-status-msg.approved { background: var(--green-bg); border-color: var(--green-bdr); color: var(--green); }
        .rc-status-msg.rejected { background: var(--red-bg);   border-color: var(--red-bdr);   color: var(--red-text); }
        .rc-status-msg i { font-size: 17px; flex-shrink: 0; }
        .rc-status-msg .msg-text strong { display: block; font-size: 13px; font-weight: 600; margin-bottom: 1px; color: inherit; }
        .rc-status-msg .msg-text small  { font-size: 12px; opacity: 0.75; }

        /* ════ EMPTY STATE ════ */
        .empty-wrap {
            position: relative; z-index: 1;
            max-width: 460px; margin: 80px auto;
            padding: 0 24px;
            text-align: center;
            animation: riseUp 0.5s ease both;
        }

        .empty-icon-ring {
            width: 96px; height: 96px;
            border-radius: 50%;
            border: 1px solid var(--border);
            background: var(--white);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
            font-size: 36px; color: var(--ink3);
            box-shadow: var(--shadow-sm);
        }

        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 26px; font-weight: 700;
            color: var(--ink); margin-bottom: 12px;
        }
        .empty-desc {
            font-size: 14.5px; color: var(--ink3);
            line-height: 1.7; margin-bottom: 32px;
        }

        /* ════ FOOTER ════ */
        .page-footer {
            position: relative; z-index: 1;
            text-align: center; padding: 24px 16px 40px;
            font-size: 13px; color: var(--ink3);
            border-top: 1px solid var(--border);
        }
        .page-footer a { color: var(--green); text-decoration: none; font-weight: 500; }
        .page-footer a:hover { color: var(--green-l); text-decoration: underline; }
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700; font-size: 14px;
            color: var(--ink); letter-spacing: 0.5px;
        }

        /* ════ RESPONSIVE ════ */
        @media (max-width: 900px) {
            .stats-bar { grid-template-columns: 1fr; }
            .res-grid  { grid-template-columns: 1fr; padding: 0 20px 60px; }
        }
        @media (max-width: 640px) {
            .topbar { padding: 0 16px; }
            .topbar-brand { font-size: 18px; }
            .page-header { padding: 28px 20px 20px; flex-direction: column; align-items: flex-start; }
            .page-title { font-size: 30px; }
            .btn-create { width: 100%; justify-content: center; }
            .stats-bar { padding: 0 20px 24px; }
            .rc-details { grid-template-columns: 1fr; }
            .nav-back span, .nav-logout span { display: none; }
        }
    </style>
</head>
<body>

    {{-- ════ TOPBAR ════ --}}
    <nav class="topbar">
        <div class="topbar-left">
            <a href="{{ route('home') }}" class="nav-back">
                <i class="fas fa-arrow-left"></i>
                <span>Beranda</span>
            </a>
        </div>

        <a href="{{ route('home') }}" class="topbar-brand">
            <span class="brand-ink">PLANO</span><span class="brand-green">VA</span>
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
        <div>
            <div class="header-eyebrow">Riwayat</div>
            <h1 class="page-title">Reservasi<br><em>Kamu</em></h1>
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
                                <i class="fas fa-arrow-up-right-from-square" style="font-size:11px; margin-left:auto;"></i>
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
        document.querySelectorAll('.res-card').forEach((card, i) => {
            card.style.animationDelay = (0.05 + i * 0.07) + 's';
        });
    });
    </script>
</body>
</html>