<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Café — PLANOVA Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --black:    #0a0a0a;
            --surface:  #111111;
            --card:     #161616;
            --card2:    #1c1c1c;
            --border:   rgba(255,255,255,0.07);
            --border-g: rgba(92,184,92,0.28);
            --green:    #5cb85c;
            --green-d:  #3d8b3d;
            --green-l:  #8edb8e;
            --green-xd: #1a3d1a;
            --amber:    #f5a623;
            --amber-l:  #fcd34d;
            --blue:     #3b8fd4;
            --blue-l:   #7ec8f7;
            --red:      #e05252;
            --red-l:    #fc8181;
            --white:    #ffffff;
            --offwhite: #f0f0f0;
            --muted:    #888888;
            --muted2:   #444444;
            --radius:   13px;
            --radius-lg:20px;
            --sidebar-w:230px;
        }

        *,*::before,*::after { box-sizing:border-box; margin:0; padding:0; }
        html { scroll-behavior:smooth; }

        body {
            font-family:'DM Sans',sans-serif;
            background:var(--black);
            color:var(--white);
            min-height:100vh;
            overflow-x:hidden;
            line-height:1.6;
        }

        /* Noise */
        body::before {
            content:''; position:fixed; inset:0;
            background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            pointer-events:none; z-index:0; opacity:0.5;
        }

        .ambient { position:fixed; border-radius:50%; filter:blur(130px); pointer-events:none; z-index:0; }
        .amb-1 { width:420px;height:420px; background:radial-gradient(circle,rgba(92,184,92,0.08) 0%,transparent 70%); top:-100px;right:-80px; animation:drift 20s ease-in-out infinite; }
        .amb-2 { width:300px;height:300px; background:radial-gradient(circle,rgba(61,139,61,0.06) 0%,transparent 70%); bottom:-60px;left:80px; animation:drift 26s ease-in-out infinite reverse; }
        @keyframes drift { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(25px,-20px) scale(1.05)} 66%{transform:translate(-15px,15px) scale(0.95)} }

        /* ════ LAYOUT ════ */
        .layout { display:flex; min-height:100vh; position:relative; z-index:1; }

        /* ════ SIDEBAR ════ */
        .sidebar {
            width:var(--sidebar-w); flex-shrink:0;
            background:rgba(17,17,17,0.97);
            border-right:1px solid var(--border);
            display:flex; flex-direction:column;
            position:fixed; top:0;left:0;bottom:0;
            z-index:300;
            transition:transform 0.32s cubic-bezier(0.4,0,0.2,1);
            backdrop-filter:blur(20px);
        }
        .sidebar::after {
            content:''; position:absolute; top:0;right:0;
            width:1px; height:100%;
            background:linear-gradient(180deg,transparent,rgba(92,184,92,0.18) 40%,rgba(92,184,92,0.08) 70%,transparent);
        }

        .sidebar-logo { padding:22px 20px 18px; border-bottom:1px solid var(--border); }
        .logo-link { display:flex;align-items:center;gap:10px; text-decoration:none; }
        .logo-img { width:34px;height:34px; border-radius:10px; overflow:hidden; border:1.5px solid rgba(92,184,92,0.25); flex-shrink:0; }
        .logo-img img { width:100%;height:100%;object-fit:cover; }
        .logo-wordmark { font-family:'Syne',sans-serif; font-size:17px;font-weight:800;letter-spacing:1.5px;color:var(--white); }
        .logo-wordmark span { color:var(--green); }
        .logo-sub { font-size:10px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--muted);margin-top:4px; }

        .sidebar-nav { flex:1; padding:14px 10px; display:flex;flex-direction:column;gap:2px; overflow-y:auto; }

        .nav-section { font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--muted2);padding:10px 12px 5px;margin-top:6px; }

        .nav-item {
            display:flex;align-items:center;gap:10px;
            padding:10px 13px; border-radius:10px;
            text-decoration:none; color:var(--muted);
            font-size:13.5px;font-weight:500;
            transition:all 0.2s; border:1px solid transparent;
        }
        .nav-item i { font-size:15px;width:18px;text-align:center;flex-shrink:0; }
        .nav-item:hover { background:rgba(92,184,92,0.08);color:var(--white); }
        .nav-item.active { background:rgba(92,184,92,0.12);color:var(--green-l);border-color:var(--border-g); }

        .nav-badge {
            margin-left:auto; font-size:10.5px;font-weight:700;
            padding:2px 8px;border-radius:20px;
            background:rgba(245,166,35,0.15);color:var(--amber);
            border:1px solid rgba(245,166,35,0.25);
        }

        .sidebar-footer { padding:14px 10px; border-top:1px solid var(--border); }

        .btn-logout-side {
            display:flex;align-items:center;gap:10px;
            padding:10px 13px;border-radius:10px;
            border:1px solid rgba(224,82,82,0.2);
            background:rgba(224,82,82,0.06);
            color:var(--red-l);font-size:13.5px;font-weight:500;
            cursor:pointer;width:100%;text-align:left;
            font-family:'DM Sans',sans-serif;transition:all 0.2s;
        }
        .btn-logout-side:hover { background:rgba(224,82,82,0.14);border-color:rgba(224,82,82,0.4); }

        /* ════ MAIN ════ */
        .main { margin-left:var(--sidebar-w); flex:1; display:flex;flex-direction:column; min-height:100vh; }

        /* ════ TOPBAR ════ */
        .topbar {
            display:flex;align-items:center;justify-content:space-between;
            padding:14px 28px;
            background:rgba(10,10,10,0.88);
            backdrop-filter:blur(20px);
            border-bottom:1px solid var(--border);
            position:sticky;top:0;z-index:100;
            gap:12px;
        }
        .topbar-left { display:flex;align-items:center;gap:12px; min-width:0; }

        .mobile-toggle {
            display:none;
            background:none;
            border:1px solid var(--border); color:var(--white);
            font-size:16px; cursor:pointer; padding:7px 9px;
            border-radius:9px; transition:all 0.2s; flex-shrink:0;
        }
        .mobile-toggle:hover { border-color:var(--border-g);color:var(--green); }

        .topbar-title h1 { font-family:'Syne',sans-serif;font-size:17px;font-weight:700;color:var(--white);margin:0; white-space:nowrap; }
        .topbar-title p  { font-size:12px;color:var(--muted);margin:1px 0 0; white-space:nowrap; }

        .topbar-right { display:flex;align-items:center;gap:8px; flex-shrink:0; }

        .clock-chip {
            display:flex;align-items:center;gap:7px;
            padding:7px 13px;
            background:rgba(255,255,255,0.04);border:1px solid var(--border);
            border-radius:9px;font-size:12.5px;color:var(--muted);
            white-space:nowrap;
        }
        .clock-chip i { color:var(--green);font-size:13px; }

        .btn-add {
            display:flex;align-items:center;gap:7px;
            padding:9px 16px;
            background:var(--green);color:var(--black);
            border:none;border-radius:9px;
            font-family:'Syne',sans-serif;font-size:13px;font-weight:700;
            text-decoration:none;cursor:pointer;
            transition:all 0.25s; white-space:nowrap;
            position:relative;overflow:hidden;
        }
        .btn-add::before { content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent);opacity:0;transition:opacity 0.3s; }
        .btn-add:hover { background:#6dcf6d;transform:translateY(-1px);box-shadow:0 8px 24px rgba(92,184,92,0.3);color:var(--black); }
        .btn-add:hover::before { opacity:1; }
        .btn-add i { font-size:13px; }

        /* hide "Tambah" text on small screens, keep icon */
        .btn-add .btn-add-text { display:inline; }

        .admin-avatar {
            width:32px;height:32px;border-radius:9px;
            background:var(--green-xd);border:1.5px solid var(--border-g);
            display:flex;align-items:center;justify-content:center;
            font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--green-l);
            flex-shrink:0;
        }

        /* ════ PAGE BODY ════ */
        .page-body { flex:1;padding:28px;display:flex;flex-direction:column;gap:20px; }

        .page-headline { display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap; }
        .headline-eyebrow { font-size:10.5px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--green);margin-bottom:6px;display:flex;align-items:center;gap:8px; }
        .headline-eyebrow::before { content:'';width:16px;height:2px;background:var(--green);border-radius:2px; }
        .headline-title { font-family:'Syne',sans-serif;font-size:24px;font-weight:800;color:var(--white);letter-spacing:-0.3px;line-height:1.1;margin:0; }
        .headline-title span { color:var(--green); }

        .stats-row { display:flex;gap:10px;flex-wrap:wrap; }
        .stat-pill {
            display:inline-flex;align-items:center;gap:8px;
            padding:9px 16px;
            background:var(--card);border:1px solid var(--border);
            border-radius:40px;font-size:13px;font-weight:500;color:var(--muted);
        }
        .stat-pill i { color:var(--green);font-size:13px; }
        .stat-pill strong { color:var(--white); }

        /* ════ TOOLBAR ════ */
        .toolbar { display:flex;gap:10px;flex-wrap:wrap;align-items:center; }

        .search-shell { flex:1;min-width:200px;position:relative; }
        .search-shell .s-icon { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:14px;pointer-events:none;z-index:1; }

        .search-input {
            width:100%;padding:11px 40px 11px 40px;
            background:var(--card);border:1.5px solid var(--border);
            border-radius:var(--radius);color:var(--white);
            font-size:13.5px;font-family:'DM Sans',sans-serif;
            transition:all 0.25s; outline:none;
        }
        .search-input:hover { border-color:rgba(255,255,255,0.14); }
        .search-input:focus { border-color:var(--green);background:rgba(92,184,92,0.04);box-shadow:0 0 0 4px rgba(92,184,92,0.08); }
        .search-input::placeholder { color:var(--muted2); }

        .search-clear {
            position:absolute;right:10px;top:50%;transform:translateY(-50%);
            background:rgba(224,82,82,0.1);border:1px solid rgba(224,82,82,0.2);
            color:var(--red-l);width:22px;height:22px;border-radius:50%;
            cursor:pointer;font-size:11px;display:none;align-items:center;justify-content:center;
        }
        .search-shell.has-value .search-clear { display:flex; }

        .filter-select {
            padding:11px 36px 11px 14px;
            background:var(--card);border:1.5px solid var(--border);
            border-radius:var(--radius);color:var(--muted);
            font-size:13.5px;font-family:'DM Sans',sans-serif;
            cursor:pointer;outline:none;
            appearance:none;-webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23888' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat:no-repeat;background-position:right 12px center;
            transition:border-color 0.2s;
        }
        .filter-select:focus { border-color:var(--green); }
        .filter-select option { background:#1c1c1c;color:var(--white); }

        .btn-tool {
            display:inline-flex;align-items:center;gap:7px;
            padding:11px 14px;
            background:var(--card);border:1.5px solid var(--border);
            border-radius:var(--radius);color:var(--muted);
            font-size:13.5px;font-family:'DM Sans',sans-serif;font-weight:500;
            cursor:pointer;transition:all 0.2s; white-space:nowrap;
        }
        .btn-tool:hover { border-color:var(--border-g);color:var(--green-l);background:rgba(92,184,92,0.06); }

        /* ════ FLASH ════ */
        .flash-msg {
            display:flex;align-items:center;gap:12px;
            padding:14px 18px;
            background:rgba(92,184,92,0.08);
            border:1px solid rgba(92,184,92,0.25);
            border-left:3px solid var(--green);
            border-radius:var(--radius);
            font-size:13.5px;color:var(--green-l);
            animation:slideAlert 0.3s ease;
        }
        @keyframes slideAlert { from{opacity:0;transform:translateY(-8px)} to{opacity:1;transform:translateY(0)} }
        .flash-msg i { font-size:16px;flex-shrink:0; }
        .flash-close { margin-left:auto;background:none;border:none;color:var(--muted);cursor:pointer;font-size:16px;line-height:1;transition:color 0.2s; }
        .flash-close:hover { color:var(--white); }

        /* ════ TABLE CARD ════ */
        .tc {
            background:var(--card);border:1px solid var(--border);
            border-radius:var(--radius-lg);overflow:hidden;
            animation:fadeUp 0.45s ease both;
        }

        .tc-head {
            display:flex;align-items:center;justify-content:space-between;
            padding:16px 22px 14px;border-bottom:1px solid var(--border);
        }
        .tc-head-left { display:flex;align-items:center;gap:10px; }
        .tc-icon {
            width:34px;height:34px;border-radius:9px;
            background:rgba(92,184,92,0.1);border:1px solid var(--border-g);
            display:flex;align-items:center;justify-content:center;
            font-size:15px;color:var(--green);
        }
        .tc-title { font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--white); }
        .tc-count { font-size:12px;color:var(--muted);font-weight:400;margin-left:4px; }

        /* ── Desktop Table ── */
        .table-wrap { overflow-x:auto; -webkit-overflow-scrolling:touch; }

        .tbl { width:100%;border-collapse:collapse;font-size:13.5px; min-width:480px; }

        .tbl thead tr { border-bottom:1px solid var(--border); }
        .tbl thead th {
            padding:12px 18px;text-align:left;
            font-size:10.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;
            color:var(--muted2);white-space:nowrap;
        }

        .tbl tbody tr { border-bottom:1px solid rgba(255,255,255,0.04);transition:background 0.15s; }
        .tbl tbody tr:last-child { border-bottom:none; }
        .tbl tbody tr:hover { background:rgba(92,184,92,0.04); }

        .tbl td { padding:14px 18px;vertical-align:middle;color:var(--muted); }

        /* Thumbnail */
        .cafe-thumb {
            width:52px;height:52px;border-radius:12px;
            object-fit:cover;border:1px solid var(--border);
            cursor:pointer;transition:all 0.2s;display:block;
        }
        .cafe-thumb:hover { border-color:var(--border-g);transform:scale(1.07);box-shadow:0 6px 20px rgba(0,0,0,0.4); }

        .thumb-placeholder {
            width:52px;height:52px;border-radius:12px;
            background:rgba(255,255,255,0.03);
            border:1.5px dashed rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:var(--muted2);font-size:18px;
        }

        .cafe-name-txt { font-size:14px;font-weight:600;color:var(--white);margin-bottom:4px; }
        .cafe-addr { display:flex;align-items:flex-start;gap:5px;font-size:12px;color:var(--muted);margin-bottom:3px; }
        .cafe-addr i { color:var(--green);font-size:11px;margin-top:2px;flex-shrink:0; }
        .cafe-meta-txt { display:flex;align-items:center;gap:5px;font-size:11.5px;color:var(--muted2); }
        .cafe-meta-txt i { font-size:11px; }

        .action-group { display:flex;gap:6px;align-items:center; }

        .ab {
            width:32px;height:32px;border-radius:8px;
            display:inline-flex;align-items:center;justify-content:center;
            font-size:13px;cursor:pointer;text-decoration:none;
            transition:all 0.2s; border:1px solid;
        }
        .ab.edit { border-color:rgba(59,143,212,0.25);color:var(--blue-l);background:rgba(59,143,212,0.07); }
        .ab.edit:hover { background:rgba(59,143,212,0.18);border-color:var(--blue);transform:translateY(-2px);box-shadow:0 6px 16px rgba(59,143,212,0.2); }
        .ab.del  { border-color:rgba(224,82,82,0.25); color:var(--red-l); background:rgba(224,82,82,0.07); }
        .ab.del:hover  { background:rgba(224,82,82,0.18); border-color:var(--red); transform:translateY(-2px);box-shadow:0 6px 16px rgba(224,82,82,0.2); }

        /* ── Mobile Card List (hidden on desktop) ── */
        .mobile-card-list { display:none; padding:12px; flex-direction:column; gap:10px; }

        .mobile-cafe-card {
            background:var(--card2);
            border:1px solid var(--border);
            border-radius:var(--radius);
            padding:14px;
            display:flex;
            gap:12px;
            align-items:flex-start;
            transition:border-color 0.2s;
        }
        .mobile-cafe-card:hover { border-color:var(--border-g); }

        .mobile-cafe-thumb {
            width:56px;height:56px;border-radius:10px;
            object-fit:cover;border:1px solid var(--border);flex-shrink:0;
            cursor:pointer;
        }
        .mobile-cafe-thumb-placeholder {
            width:56px;height:56px;border-radius:10px;
            background:rgba(255,255,255,0.03);
            border:1.5px dashed rgba(255,255,255,0.08);
            display:flex;align-items:center;justify-content:center;
            color:var(--muted2);font-size:20px;flex-shrink:0;
        }

        .mobile-cafe-info { flex:1;min-width:0; }
        .mobile-cafe-name { font-size:14px;font-weight:600;color:var(--white);margin-bottom:4px; white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
        .mobile-cafe-addr { font-size:12px;color:var(--muted);margin-bottom:6px;display:flex;align-items:flex-start;gap:4px; }
        .mobile-cafe-addr i { color:var(--green);font-size:11px;margin-top:2px;flex-shrink:0; }
        .mobile-cafe-date { font-size:11.5px;color:var(--muted2); }

        .mobile-cafe-actions { display:flex;gap:6px;margin-top:10px; }
        .mobile-ab {
            flex:1;height:34px;border-radius:8px;
            display:inline-flex;align-items:center;justify-content:center;gap:6px;
            font-size:12.5px;font-weight:500;font-family:'DM Sans',sans-serif;
            cursor:pointer;text-decoration:none;
            transition:all 0.2s; border:1px solid;
        }
        .mobile-ab.edit { border-color:rgba(59,143,212,0.3);color:var(--blue-l);background:rgba(59,143,212,0.07); }
        .mobile-ab.edit:hover { background:rgba(59,143,212,0.18); }
        .mobile-ab.del { border-color:rgba(224,82,82,0.3);color:var(--red-l);background:rgba(224,82,82,0.07); }
        .mobile-ab.del:hover { background:rgba(224,82,82,0.18); }

        /* Empty state */
        .empty-state { text-align:center;padding:52px 24px; }
        .empty-ring {
            width:76px;height:76px;border-radius:50%;
            background:var(--card2);border:1px solid var(--border);
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 20px;font-size:30px;color:var(--muted2);
            box-shadow:0 0 0 8px rgba(255,255,255,0.015);
        }
        .empty-state h3 { font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:var(--white);margin-bottom:8px; }
        .empty-state p  { font-size:13.5px;color:var(--muted);margin-bottom:22px; }

        /* Pagination */
        .pagination-bar {
            display:flex;align-items:center;justify-content:space-between;
            padding:14px 20px;border-top:1px solid var(--border);
            flex-wrap:wrap;gap:10px;
        }
        .pag-info { font-size:12px;color:var(--muted2); }
        .pag { display:flex;gap:4px;list-style:none;flex-wrap:wrap; }

        .pag-link {
            display:flex;align-items:center;justify-content:center;
            min-width:34px;height:34px;padding:0 8px;
            background:rgba(255,255,255,0.03);border:1px solid var(--border);
            border-radius:8px;color:var(--muted);
            text-decoration:none;font-size:13px;font-weight:500;
            transition:all 0.2s;
        }
        .pag-link:hover { background:rgba(92,184,92,0.1);border-color:var(--border-g);color:var(--green-l); }
        .pag-item.active .pag-link { background:var(--green);border-color:var(--green);color:var(--black);font-weight:700; }
        .pag-item.disabled .pag-link { opacity:0.3;cursor:not-allowed;pointer-events:none; }

        /* ════ IMAGE MODAL ════ */
        .img-modal {
            position:fixed;inset:0;
            background:rgba(0,0,0,0.94);backdrop-filter:blur(16px);
            display:none;align-items:center;justify-content:center;
            z-index:1000;padding:20px;
        }
        .img-modal.show { display:flex; }
        .modal-box { position:relative;max-width:min(88vw,600px); }
        .modal-img { max-width:100%;max-height:80vh;border-radius:16px;border:1px solid var(--border);display:block; }
        .modal-cap { text-align:center;font-size:13px;color:var(--muted);margin-top:12px; }
        .modal-x {
            position:absolute;top:-14px;right:-14px;
            width:34px;height:34px;border-radius:50%;
            background:rgba(224,82,82,0.15);border:1px solid rgba(224,82,82,0.35);
            color:var(--red-l);font-size:15px;cursor:pointer;
            display:flex;align-items:center;justify-content:center;
            transition:background 0.2s;
        }
        .modal-x:hover { background:rgba(224,82,82,0.35); }

        /* ════ TOAST ════ */
        .toast-wrap { position:fixed;bottom:20px;right:20px;z-index:2000;display:flex;flex-direction:column;gap:8px;max-width:calc(100vw - 40px); }
        .toast {
            display:flex;align-items:center;gap:10px;
            padding:12px 18px;background:var(--card2);
            border:1px solid var(--border);border-radius:var(--radius);
            font-size:13.5px;color:var(--white);
            box-shadow:0 8px 32px rgba(0,0,0,0.6);
            animation:toastIn 0.3s ease;
        }
        @keyframes toastIn { from{opacity:0;transform:translateX(20px)} to{opacity:1;transform:translateX(0)} }
        .toast.success { border-left:3px solid var(--green); }
        .toast.success i { color:var(--green-l); }
        .toast.error   { border-left:3px solid var(--red); }
        .toast.error   i { color:var(--red-l); }

        /* ════ FOOTER ════ */
        .page-footer {
            border-top:1px solid var(--border);padding:14px 28px;
            display:flex;align-items:center;justify-content:space-between;
            font-size:12px;color:var(--muted2);gap:10px;flex-wrap:wrap;
        }
        .footer-brand { font-family:'Syne',sans-serif;font-weight:800;letter-spacing:1px;color:var(--white); }
        .page-footer a { color:var(--green);text-decoration:none;transition:color 0.2s; }
        .page-footer a:hover { color:var(--green-l); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

        /* Sidebar overlay */
        .sidebar-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,0.65);z-index:299;backdrop-filter:blur(4px); }
        .sidebar-overlay.show { display:block; }

        /* ════ RESPONSIVE ════ */

        /* Medium — collapsed sidebar */
        @media (max-width:900px) {
            .sidebar { transform:translateX(-100%); }
            .sidebar.open { transform:translateX(0); }
            .main { margin-left:0; }
            .mobile-toggle { display:flex; }
            .page-body { padding:20px; }
            .topbar { padding:12px 20px; }
            .page-footer { padding:12px 20px;flex-direction:column;gap:6px;text-align:center; }
            .page-headline { flex-direction:column;align-items:flex-start;gap:12px; }
            .clock-chip { display:none; }
        }

        /* Small — switch table to card list */
        @media (max-width:640px) {
            .page-body { padding:14px; gap:14px; }
            .topbar { padding:10px 14px; gap:8px; }

            /* Hide "Tambah Café" label, keep icon */
            .btn-add .btn-add-text { display:none; }
            .btn-add { padding:9px 12px; }

            /* Topbar title collapse */
            .topbar-title p { display:none; }
            .topbar-title h1 { font-size:15px; }

            /* Toolbar full-width */
            .toolbar { flex-direction:column; }
            .search-shell { min-width:0;width:100%; }
            .filter-select { width:100%; }
            .btn-tool { width:100%;justify-content:center; }

            /* Hide desktop table, show mobile cards */
            .table-wrap { display:none; }
            .mobile-card-list { display:flex; }

            /* Pagination compact */
            .pagination-bar { justify-content:center; }
            .pag-info { width:100%;text-align:center; }
        }

        /* Very small */
        @media (max-width:380px) {
            .page-headline .headline-title { font-size:20px; }
            .stats-row { width:100%; }
            .stat-pill { width:100%;justify-content:center; }
        }
    </style>
</head>
<body>

<div class="ambient amb-1"></div>
<div class="ambient amb-2"></div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<div class="layout">

    {{-- ════ SIDEBAR ════ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo-img">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
                </div>
                <div>
                    <div class="logo-wordmark">PLANO<span>VA</span></div>
                    <div class="logo-sub">Admin Panel</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section">Overview</span>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="fas fa-table-cells-large"></i> Dashboard
            </a>

            <span class="nav-section">Manajemen</span>
            <a href="{{ route('admin.cafes.index') }}" class="nav-item active">
                <i class="fas fa-store"></i> Kelola Café
            </a>
            <a href="{{ route('admin.reservations.index') }}" class="nav-item">
                <i class="fas fa-calendar-check"></i> Reservasi
                @php $pending = \App\Models\Reservation::where('status','pending')->count(); @endphp
                @if($pending > 0)<span class="nav-badge">{{ $pending }}</span>@endif
            </a>

            <span class="nav-section">Sistem</span>
            <a href="{{ route('home') }}" class="nav-item">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
        </nav>

        <div class="sidebar-footer">
            @auth
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
            <button class="btn-logout-side" onclick="handleLogout(event)">
                <i class="fas fa-arrow-right-from-bracket"></i> Logout
            </button>
            @endauth
        </div>
    </aside>

    {{-- ════ MAIN ════ --}}
    <div class="main">

        {{-- Topbar --}}
        <header class="topbar">
            <div class="topbar-left">
                <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <div class="topbar-title">
                    <h1>Kelola Café</h1>
                    <p>Manajemen data café partner</p>
                </div>
            </div>
            <div class="topbar-right">
                <div class="clock-chip">
                    <i class="fas fa-clock"></i>
                    <span id="clock">--:--</span>
                </div>
                <a href="{{ route('admin.cafes.create') }}" class="btn-add">
                    <i class="fas fa-plus"></i>
                    <span class="btn-add-text">Tambah Café</span>
                </a>
                <div class="admin-avatar">A</div>
            </div>
        </header>

        {{-- Page body --}}
        <main class="page-body">

            {{-- Headline --}}
            <div class="page-headline">
                <div>
                    <div class="headline-eyebrow">Manajemen</div>
                    <h2 class="headline-title">Daftar <span>Café Partner</span></h2>
                </div>
                <div class="stats-row">
                    <span class="stat-pill">
                        <i class="fas fa-store"></i>
                        Total: <strong>{{ $cafes->total() }}</strong> café
                    </span>
                </div>
            </div>

            {{-- Flash --}}
            @if(session('success'))
            <div class="flash-msg" id="flash-msg">
                <i class="fas fa-circle-check"></i>
                <span>{{ session('success') }}</span>
                <button class="flash-close" onclick="document.getElementById('flash-msg').remove()">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            @endif

            {{-- Toolbar --}}
            <div class="toolbar">
                <div class="search-shell" id="searchShell">
                    <i class="fas fa-magnifying-glass s-icon"></i>
                    <form method="GET" action="{{ route('admin.cafes.index') }}" id="searchForm">
                        <input type="text" name="search" id="searchInput" class="search-input"
                            placeholder="Cari nama atau alamat café..."
                            value="{{ request('search') }}">
                        <button type="button" class="search-clear" onclick="clearSearch()">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </form>
                </div>
                <select class="filter-select" onchange="window.location.href='?sort='+this.value">
                    <option value="">Terbaru</option>
                    <option value="name_asc"  {{ request('sort')=='name_asc'  ?'selected':'' }}>Nama A–Z</option>
                    <option value="name_desc" {{ request('sort')=='name_desc' ?'selected':'' }}>Nama Z–A</option>
                </select>
                <button class="btn-tool" onclick="location.reload()">
                    <i class="fas fa-rotate-right"></i> Refresh
                </button>
            </div>

            {{-- Table card --}}
            <div class="tc">
                <div class="tc-head">
                    <div class="tc-head-left">
                        <div class="tc-icon"><i class="fas fa-store"></i></div>
                        <span class="tc-title">Semua Café <span class="tc-count">({{ $cafes->total() }})</span></span>
                    </div>
                </div>

                {{-- ── Desktop Table ── --}}
                <div class="table-wrap">
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th style="width:78px;">Foto</th>
                                <th>Informasi Café</th>
                                <th style="width:100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cafes as $cafe)
                            <tr>
                                <td>
                                    @if($cafe->image)
                                        <img src="{{ asset('storage/'.$cafe->image) }}"
                                             alt="{{ $cafe->name }}"
                                             class="cafe-thumb"
                                             onclick="openModal(this.src,'{{ addslashes($cafe->name) }}')">
                                    @else
                                        <div class="thumb-placeholder"><i class="fas fa-image"></i></div>
                                    @endif
                                </td>
                                <td>
                                    <div class="cafe-name-txt">{{ $cafe->name }}</div>
                                    <div class="cafe-addr">
                                        <i class="fas fa-location-dot"></i>
                                        {{ Str::limit($cafe->address, 58) }}
                                    </div>
                                    <div class="cafe-meta-txt">
                                        <i class="fas fa-calendar"></i>
                                        {{ $cafe->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <a href="{{ route('admin.cafes.edit', $cafe) }}" class="ab edit" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.cafes.destroy', $cafe) }}" method="POST"
                                              onsubmit="return confirm('Yakin hapus {{ addslashes($cafe->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="ab del" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">
                                    <div class="empty-state">
                                        <div class="empty-ring"><i class="fas fa-store-slash"></i></div>
                                        <h3>Belum Ada Café</h3>
                                        <p>Mulai dengan menambahkan café partner pertama.</p>
                                        <a href="{{ route('admin.cafes.create') }}" class="btn-add" style="display:inline-flex;margin:0 auto;">
                                            <i class="fas fa-plus"></i>
                                            <span class="btn-add-text">Tambah Café</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ── Mobile Card List ── --}}
                <div class="mobile-card-list">
                    @forelse($cafes as $cafe)
                    <div class="mobile-cafe-card">
                        @if($cafe->image)
                            <img src="{{ asset('storage/'.$cafe->image) }}"
                                 alt="{{ $cafe->name }}"
                                 class="mobile-cafe-thumb"
                                 onclick="openModal(this.src,'{{ addslashes($cafe->name) }}')">
                        @else
                            <div class="mobile-cafe-thumb-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                        <div class="mobile-cafe-info" style="flex:1;min-width:0;">
                            <div class="mobile-cafe-name">{{ $cafe->name }}</div>
                            <div class="mobile-cafe-addr">
                                <i class="fas fa-location-dot"></i>
                                <span>{{ Str::limit($cafe->address, 50) }}</span>
                            </div>
                            <div class="mobile-cafe-date">
                                <i class="fas fa-calendar" style="font-size:10px;color:var(--muted2);"></i>
                                {{ $cafe->created_at->format('d M Y') }}
                            </div>
                            <div class="mobile-cafe-actions">
                                <a href="{{ route('admin.cafes.edit', $cafe) }}" class="mobile-ab edit">
                                    <i class="fas fa-pen"></i> Edit
                                </a>
                                <form action="{{ route('admin.cafes.destroy', $cafe) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus {{ addslashes($cafe->name) }}?')"
                                      style="flex:1;display:flex;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="mobile-ab del" style="flex:1;">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="padding:40px 16px;">
                        <div class="empty-ring"><i class="fas fa-store-slash"></i></div>
                        <h3>Belum Ada Café</h3>
                        <p>Mulai dengan menambahkan café partner pertama.</p>
                        <a href="{{ route('admin.cafes.create') }}" class="btn-add" style="display:inline-flex;margin:0 auto;">
                            <i class="fas fa-plus"></i>
                            <span class="btn-add-text">Tambah Café</span>
                        </a>
                    </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($cafes->hasPages())
                <div class="pagination-bar">
                    <span class="pag-info">{{ $cafes->firstItem() }}–{{ $cafes->lastItem() }} dari {{ $cafes->total() }} data</span>
                    <ul class="pag">
                        @if($cafes->onFirstPage())
                            <li class="pag-item disabled"><span class="pag-link"><i class="fas fa-chevron-left"></i></span></li>
                        @else
                            <li class="pag-item"><a class="pag-link" href="{{ $cafes->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a></li>
                        @endif

                        @foreach($cafes->getUrlRange(1,$cafes->lastPage()) as $page => $url)
                            @if($page == $cafes->currentPage())
                                <li class="pag-item active"><span class="pag-link">{{ $page }}</span></li>
                            @else
                                <li class="pag-item"><a class="pag-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if($cafes->hasMorePages())
                            <li class="pag-item"><a class="pag-link" href="{{ $cafes->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a></li>
                        @else
                            <li class="pag-item disabled"><span class="pag-link"><i class="fas fa-chevron-right"></i></span></li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

        </main>

        {{-- Footer --}}
        <footer class="page-footer">
            <span>&copy; {{ date('Y') }} <span class="footer-brand">PLANOVA</span> — Admin Panel</span>
            <a href="{{ route('home') }}">Kembali ke Website <i class="fas fa-arrow-right" style="font-size:11px;"></i></a>
        </footer>
    </div>
</div>

{{-- Image Modal --}}
<div class="img-modal" id="imgModal" onclick="closeModalOutside(event)">
    <div class="modal-box">
        <button class="modal-x" onclick="closeModal()"><i class="fas fa-xmark"></i></button>
        <img src="" alt="" class="modal-img" id="modalImg">
        <p class="modal-cap" id="modalCap"></p>
    </div>
</div>

{{-- Toast --}}
<div class="toast-wrap" id="toastWrap"></div>

<script>
    function handleLogout(e) {
        if (e) e.preventDefault();
        if (confirm('Yakin ingin logout dari panel admin?')) document.getElementById('logout-form')?.submit();
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('overlay').classList.toggle('show');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('overlay').classList.remove('show');
    }

    // Close sidebar on ESC
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });

    // Clock
    function updateClock() {
        const el = document.getElementById('clock');
        if (el) el.textContent = new Date().toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
    }
    updateClock(); setInterval(updateClock, 1000);

    // Search
    const searchInput = document.getElementById('searchInput');
    const searchShell = document.getElementById('searchShell');
    if (searchInput) {
        searchInput.addEventListener('input', () => searchShell.classList.toggle('has-value', searchInput.value.length > 0));
        if (searchInput.value) searchShell.classList.add('has-value');
        searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') document.getElementById('searchForm').submit(); });
    }
    function clearSearch() { searchInput.value=''; searchShell.classList.remove('has-value'); document.getElementById('searchForm').submit(); }

    // Modal
    function openModal(src, cap) {
        document.getElementById('modalImg').src = src;
        document.getElementById('modalCap').textContent = cap;
        document.getElementById('imgModal').classList.add('show');
    }
    function closeModal() { document.getElementById('imgModal').classList.remove('show'); }
    function closeModalOutside(e) { if (e.target.id === 'imgModal') closeModal(); }

    // Toast
    function showToast(type, msg) {
        const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-xmark';
        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.innerHTML = `<i class="fas ${icon}"></i><span>${msg}</span>`;
        document.getElementById('toastWrap').appendChild(el);
        setTimeout(() => el.remove(), 4000);
    }

    @if(session('success'))
        showToast('success', "{{ session('success') }}");
    @endif
</script>
</body>
</html>