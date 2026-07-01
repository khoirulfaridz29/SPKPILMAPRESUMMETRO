<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PILMAPRES UM Metro</title>
    <link rel="icon" href="{{ asset('assets/logoummetro.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7"></script>
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 72px;
            --primary: #1a3c7a;
            --primary-light: #2a6df0;
            --primary-dark: #0f2550;
            --accent: #5b9bd5;
            --success: #16a34a;
            --danger: #dc2626;
            --warning: #f59e0b;
            --text: #1e293b;
            --text-muted: #64748b;
            --bg: #f8fafc;
            --border: #e2e8f0;
            --radius: 10px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px rgba(0,0,0,0.06);
            --bg-body: #f0f4f8;
            --bg-card: #ffffff;
            --text-body: #212529;
            --border-color: #e2e8f0;
            --card-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            border-radius: var(--radius) !important;
        }
        .btn-primary:hover {
            background-color: var(--primary-light) !important;
            border-color: var(--primary-light) !important;
        }
        body { font-family: 'Montserrat', sans-serif; background: var(--bg-body); font-weight: 400; color: var(--text-body); }
        h1, h2, h3, h4, h5, h6 { font-weight: 700; }
        .fw-bold { font-weight: 700 !important; }
        .fw-semibold { font-weight: 600 !important; }
        .fw-normal { font-weight: 400 !important; }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(160deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            display: flex; flex-direction: column;
            z-index: 1000;
            transition: width 0.25s ease, transform 0.3s;
            overflow: hidden;
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar-brand {
            padding: 22px 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            white-space: nowrap;
            overflow: hidden;
            transition: padding 0.25s ease;
        }
        .sidebar.collapsed .sidebar-brand { padding: 18px 14px 15px; }
        .sidebar-brand .brand-name {
            font-weight: 700; font-size: 18px; color: white;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .sidebar-brand .brand-name { opacity: 0; }
        .sidebar-brand .brand-sub {
            font-size: 11px; color: rgba(255,255,255,0.55);
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .sidebar-brand .brand-sub { opacity: 0; }
        .sidebar-nav { padding: 15px 12px; flex: 1; overflow-y: auto; overflow-anchor: none; }
        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            color: rgba(255,255,255,0.35); text-transform: uppercase;
            padding: 12px 10px 4px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .nav-section-label { opacity: 0; height: 0; padding: 0; margin: 0; }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500;
            padding: 9px 14px; border-radius: var(--radius-sm); margin-bottom: 3px;
            display: flex; align-items: center; gap: 10px;
            transition: all 0.2s;
            white-space: nowrap;
            overflow: hidden;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.12); color: white;
        }
        .sidebar .nav-link.active {
            background: var(--accent); color: white;
            box-shadow: 0 4px 12px rgba(91,155,213,0.4);
        }
        .sidebar .nav-link .nav-label {
            transition: opacity 0.2s;
        }
        .sidebar.collapsed .nav-link .nav-label { opacity: 0; width: 0; display: inline-block; }
        .sidebar .nav-link i { min-width: 18px; text-align: center; font-size: 1rem; flex-shrink: 0; }
        .sidebar .collapse-chevron {
            transition: transform 0.3s ease;
        }
        .sidebar.collapsed .nav-link .collapse-chevron { display: none; }
        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            transition: padding 0.25s ease;
        }
        .sidebar.collapsed .sidebar-footer { padding: 15px 14px; }
        .sidebar.collapsed .sidebar-footer .btn span { display: none; }
        .sidebar.collapsed .sidebar-footer .btn { justify-content: center; padding: 9px 0; }
        /* Collapse submenus in collapsed state */
        .sidebar.collapsed #collapseRubrik,
        .sidebar.collapsed #collapseRubrik .collapse { display: none !important; }

        /* Bootstrap tooltip styling for sidebar */
        .sidebar-tooltip .tooltip-inner {
            background: #1e293b;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
            max-width: 260px;
            text-align: left;
        }
        .sidebar-tooltip.bs-tooltip-end .tooltip-arrow::before {
            border-right-color: #1e293b !important;
        }

        /* SIDEBAR TOGGLE BUTTON IN TOP NAV */
        .sidebar-toggle {
            background: none; border: none; color: var(--text-muted);
            font-size: 1.2rem; cursor: pointer;
            padding: 6px 8px; border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .sidebar-toggle:hover { background: var(--border); }

        /* MAIN AREA */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
            transition: margin-left 0.25s ease;
        }
        .sidebar.collapsed ~ .main-wrapper,
        .sidebar.collapsed + .sidebar-overlay + .main-wrapper { margin-left: var(--sidebar-collapsed); }
        .top-navbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 28px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .page-content { padding: 28px; flex: 1; }

        /* STAT CARDS */
        .stat-card {
            border: none; border-radius: 14px;
            padding: 22px; color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .stat-card .stat-icon {
            width: 48px; height: 48px; background: rgba(255,255,255,0.2);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 12px;
        }
        .stat-card .stat-val { font-size: 32px; font-weight: 700; }
        .stat-card .stat-lbl { font-size: 13px; opacity: 0.85; }

        /* CARD */
        .card { border: none; border-radius: 14px; box-shadow: var(--card-shadow); background: var(--bg-card); color: var(--text-body); }
        .card-header { background: var(--bg-card); border-bottom: 1px solid var(--border-color); font-weight: 700; padding: 16px 20px; color: var(--text-body); }
        .card-body table tbody tr { transition: background 0.15s ease; }
        .card-body table tbody tr:hover { background: #f0f4ff !important; cursor: default; }

        /* GLASSMORPHISM */
        .glass-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        }

        /* CHART CONTAINER */
        .chart-container { position: relative; height: 280px; width: 100%; }

        /* SKELETON LOADER */
        .skeleton {
            background: linear-gradient(90deg, var(--border-color) 25%, rgba(255,255,255,0.15) 50%, var(--border-color) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 6px;
        }
        @keyframes skeleton-loading { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
        .skeleton-text { height: 14px; margin-bottom: 8px; width: 80%; }
        .skeleton-stat { height: 80px; width: 100%; }

        /* BADGE ROLE */
        .badge-admin { background: #dbeafe; color: var(--primary); }
        .badge-mahasiswa { background: #dcfce7; color: #15803d; }
        .badge-juri { background: #fef9c3; color: #a16207; }
        .badge-wr3 { background: #f3e8ff; color: #7e22ce; }

        /* SIDEBAR OVERLAY */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5);
            z-index: 999; display: none;
        }
        .sidebar-overlay.show { display: block; }

        @media(max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .page-content { padding: 16px; }
            .top-navbar { padding: 12px 16px; }
            .stat-card .stat-val { font-size: 24px; }
        }

        /* COLLAPSE CHEVRON */
        .collapse-chevron {
            transition: transform 0.3s ease;
        }
        .collapse-chevron.rotated {
            transform: rotate(180deg);
        }
        #collapseRubrik {
            padding-left: 0;
        }
        #collapseRubrik .collapse {
            padding-left: 0;
        }

        /* HIDE SCROLLBAR UI, KEEP FUNCTION + STABLE GUTTER */
        html { scrollbar-gutter: stable; scrollbar-width: none; -ms-overflow-style: none; }
        html::-webkit-scrollbar { display: none; }
        .sidebar-nav { scrollbar-width: none; -ms-overflow-style: none; }
        .sidebar-nav::-webkit-scrollbar { display: none; }
        

        /* SWEETALERT2 BLUR BACKDROP */
        .swal2-container.swal2-backdrop-show {
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            background: rgba(0,0,0,0.3) !important;
        }
        .swal2-container.swal2-backdrop-show .swal2-popup {
            box-shadow: 0 20px 60px rgba(0,0,0,0.3) !important;
        }

        /* MODAL BLUR BACKDROP */
        .modal-backdrop {
            transition: opacity .2s ease, backdrop-filter .2s ease !important;
        }
        .modal-backdrop.show {
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            background: rgba(15, 23, 42, 0.45) !important;
            opacity: 1 !important;
        }
        .modal-backdrop.fade:not(.show) {
            backdrop-filter: blur(0px) !important;
            -webkit-backdrop-filter: blur(0px) !important;
            opacity: 0 !important;
        }

        /* SWEETALERT2 STYLING CUSTOMIZATION */
        .swal2-popup {
            border-radius: 24px !important;
            padding: 3rem 2.5rem !important;
            font-family: 'Montserrat', sans-serif !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
            border: none !important;
            max-width: 480px !important;
        }

        .swal2-title {
            font-size: 1.5rem !important;
            font-weight: 700 !important;
            color: #1e293b !important; /* Slate 800 */
            margin-top: 1rem !important;
            margin-bottom: 0.5rem !important;
            text-align: center !important;
        }

        .swal2-html-container {
            font-size: 0.95rem !important;
            color: #64748b !important; /* Slate 500 */
            line-height: 1.6 !important;
            margin: 0.5rem 0 1.75rem 0 !important;
            text-align: center !important;
        }

        .swal2-actions {
            margin-top: 0.5rem !important;
            width: 100% !important;
            justify-content: center !important;
        }

        /* Success close button styling */
        .swal2-confirm.btn-custom-close {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 600 !important;
            font-size: 0.95rem !important;
            padding: 12px 0 !important;
            border-radius: 12px !important;
            border: none !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
            width: 100% !important;
            max-width: 280px !important;
            text-align: center !important;
        }
        .swal2-confirm.btn-custom-close:hover {
            background-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        /* Success Icon - Beautiful radial blue checkmark circle */
        .swal2-icon.swal2-success {
            border-color: transparent !important;
            background: radial-gradient(circle, var(--primary-light) 0%, var(--primary) 100%) !important;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.25) !important;
            width: 88px !important;
            height: 88px !important;
            border-radius: 50% !important;
            position: relative !important;
            margin: 0 auto 1rem auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        /* Completely hide all SweetAlert internal animated lines/divs to prevent distortion */
        .swal2-icon.swal2-success * {
            display: none !important;
        }
        /* Inject a crisp Font Awesome check icon in the center */
        .swal2-icon.swal2-success::after {
            content: "\f00c" !important;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            color: white !important;
            font-size: 2.5rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            line-height: 1 !important;
        }

        /* Error Icon */
        .swal2-icon.swal2-error {
            border-color: transparent !important;
            background: radial-gradient(circle, #ef4444 0%, #dc2626 100%) !important;
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.25) !important;
            width: 88px !important;
            height: 88px !important;
            border-radius: 50% !important;
            position: relative !important;
            margin: 0 auto 1rem auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .swal2-icon.swal2-error * {
            display: none !important;
        }
        .swal2-icon.swal2-error::after {
            content: "\f00d" !important;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            color: white !important;
            font-size: 2.3rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            line-height: 1 !important;
        }

        /* Warning Icon */
        .swal2-icon.swal2-warning {
            border-color: transparent !important;
            background: radial-gradient(circle, #f59e0b 0%, #d97706 100%) !important;
            box-shadow: 0 12px 30px rgba(217, 119, 6, 0.25) !important;
            width: 88px !important;
            height: 88px !important;
            border-radius: 50% !important;
            position: relative !important;
            margin: 0 auto 1rem auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .swal2-icon.swal2-warning * {
            display: none !important;
        }
        .swal2-icon.swal2-warning::after {
            content: "\f12a" !important;
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            color: white !important;
            font-size: 2.3rem !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            line-height: 1 !important;
        }

        /* GLOBAL CURSOR — panah di non-interaktif, I-beam hanya di input */
        * { cursor: default; -webkit-user-select: none; user-select: none; }
        a, button, [role="button"], .btn, .nav-link, .dropdown-item,
        [data-bs-toggle], summary, label[for],
        input[type="button"], input[type="submit"], input[type="reset"],
        input[type="checkbox"], input[type="radio"],
        .btn-close, .sidebar-toggle { cursor: pointer; }
        input:not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="checkbox"]):not([type="radio"]),
        textarea { cursor: text; -webkit-user-select: text; user-select: text; }
        select { cursor: pointer; }
        .disabled, [disabled], .btn.disabled, fieldset:disabled * { cursor: default !important; }

        .card .table-responsive,
        .sheet-card .table-responsive {
            max-height: 480px;
            overflow-y: auto;
        }
        .card .table-responsive table,
        .sheet-card .table-responsive table {
            margin-bottom: 0;
        }

        @media print {
            .sidebar, .top-navbar, .no-print {
                display: none !important;
            }
            .main-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .page-content {
                padding: 0 !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <script>if(localStorage.getItem('sidebarCollapsed')==='1'){document.getElementById('sidebar').classList.add('collapsed')}</script>
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('assets/logoummetro.webp') }}" alt="Logo" height="38">
                <div>
                    <div class="brand-name">PILMAPRES</div>
                    <div class="brand-sub">UM Metro</div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Utama</div>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house-chimney fa-fw"></i><span class="nav-label"> Dashboard</span>
            </a>

            @if(Auth::user()->role === 'admin')
            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.jenjang.index') }}" class="nav-link {{ request()->routeIs('admin.jenjang*') ? 'active' : '' }}">
                <i class="fa-solid fa-graduation-cap fa-fw"></i><span class="nav-label"> Jenjang Pendidikan</span>
            </a>
            <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days fa-fw"></i><span class="nav-label"> Jadwal Pelaksanaan</span>
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn fa-fw"></i><span class="nav-label"> Pengumuman</span>
            </a>
            <a href="{{ route('admin.panduan.index') }}" class="nav-link {{ request()->routeIs('admin.panduan*') ? 'active' : '' }}">
                <i class="fa-solid fa-book fa-fw"></i><span class="nav-label"> Panduan</span>
            </a>
            <a href="{{ route('admin.persyaratan.index') }}" class="nav-link {{ request()->routeIs('admin.persyaratan*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice fa-fw"></i><span class="nav-label"> Persyaratan Form</span>
            </a>
            <a href="{{ route('admin.kriteria.index', ['jenjang_id' => request('jenjang_id', 1)]) }}" class="nav-link {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check fa-fw"></i><span class="nav-label"> Kriteria Penilaian</span>
            </a>
            @php
                $rubrikPrefixes = ['admin.rubrik-cu', 'admin.rubrik-naskah-gk', 'admin.rubrik-presentasi-gk', 'admin.rubrik-bahasa-inggris', 'admin.rubrik-wawancara-cu'];
                $isRubrikActive = collect($rubrikPrefixes)->contains(fn($p) => request()->routeIs($p . '*'));
            @endphp
            <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#collapseRubrik" role="button" class="nav-link">
                <i class="fa-solid fa-book-open fa-fw"></i><span class="nav-label"> Rubrik Penilaian</span>
                <i class="fa-solid fa-chevron-down ms-auto collapse-chevron {{ $isRubrikActive ? 'rotated' : '' }}"></i>
            </a>
            <div class="collapse {{ $isRubrikActive ? 'show' : '' }}" id="collapseRubrik">
                @foreach($sidebarJenjangs as $sj)
                @php $isSJActive = $isRubrikActive && request('jenjang_id') == $sj->id; @endphp
                <a href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#collapseJenjang{{ $sj->id }}" role="button" class="nav-link" style="padding-left:24px;font-size:13px">
                    <i class="fa-solid fa-graduation-cap fa-fw"></i><span class="nav-label"> {{ $sj->nama_jenjang }}</span>
                    <i class="fa-solid fa-chevron-down ms-auto collapse-chevron {{ $isSJActive ? 'rotated' : '' }}"></i>
                </a>
                <div class="collapse {{ $isSJActive ? 'show' : '' }}" id="collapseJenjang{{ $sj->id }}">
                    @php $rl = $rubrikLabels[$sj->id] ?? []; @endphp
                    @if($rl['cu']['exists'] ?? true)
                    <a href="{{ route('admin.rubrik-cu.index', ['jenjang_id' => $sj->id]) }}" class="nav-link {{ request()->routeIs('admin.rubrik-cu*') && request('jenjang_id') == $sj->id ? 'active' : '' }}" style="padding-left:36px;font-size:12px">
                        <i class="fa-solid fa-table fa-fw"></i><span class="nav-label"> {{ $rl['cu']['label'] ?? 'Capaian Unggulan' }}</span>
                    </a>
                    @endif
                    @if($rl['naskah_gk']['exists'] ?? false)
                    <a href="{{ route('admin.rubrik-naskah-gk.index', ['jenjang_id' => $sj->id]) }}" class="nav-link {{ request()->routeIs('admin.rubrik-naskah-gk*') && request('jenjang_id') == $sj->id ? 'active' : '' }}" style="padding-left:36px;font-size:12px">
                        <i class="fa-solid fa-file-pen fa-fw"></i><span class="nav-label"> {{ $rl['naskah_gk']['label'] ?? 'Naskah GK' }}</span>
                    </a>
                    @endif
                    @if($rl['presentasi_gk']['exists'] ?? false)
                    <a href="{{ route('admin.rubrik-presentasi-gk.index', ['jenjang_id' => $sj->id]) }}" class="nav-link {{ request()->routeIs('admin.rubrik-presentasi-gk*') && request('jenjang_id') == $sj->id ? 'active' : '' }}" style="padding-left:36px;font-size:12px">
                        <i class="fa-solid fa-person-chalkboard fa-fw"></i><span class="nav-label"> {{ $rl['presentasi_gk']['label'] ?? 'Presentasi GK' }}</span>
                    </a>
                    @endif
                    @if($rl['bi']['exists'] ?? false)
                    <a href="{{ route('admin.rubrik-bahasa-inggris.index', ['jenjang_id' => $sj->id]) }}" class="nav-link {{ request()->routeIs('admin.rubrik-bahasa-inggris*') && request('jenjang_id') == $sj->id ? 'active' : '' }}" style="padding-left:36px;font-size:12px">
                        <i class="fa-solid fa-language fa-fw"></i><span class="nav-label"> {{ $rl['bi']['label'] ?? 'Bahasa Inggris' }}</span>
                    </a>
                    @endif
                    @if($rl['wawancara']['exists'] ?? false)
                    <a href="{{ route('admin.rubrik-wawancara-cu.index', ['jenjang_id' => $sj->id]) }}" class="nav-link {{ request()->routeIs('admin.rubrik-wawancara-cu*') && request('jenjang_id') == $sj->id ? 'active' : '' }}" style="padding-left:36px;font-size:12px">
                        <i class="fa-solid fa-microphone fa-fw"></i><span class="nav-label"> {{ $rl['wawancara']['label'] ?? 'Wawancara CU' }}</span>
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear fa-fw"></i><span class="nav-label"> Kelola Akun</span>
            </a>
            <div class="nav-section-label">Seleksi</div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-circle-check fa-fw"></i><span class="nav-label"> Pendaftaran & Berkas</span>
            </a>
            <a href="{{ route('admin.rekap.index') }}" class="nav-link {{ request()->routeIs('admin.rekap*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list fa-fw"></i><span class="nav-label"> Rekap Tahap I</span>
            </a>
            <a href="{{ route('admin.perhitungan.index') }}" class="nav-link {{ request()->routeIs('admin.perhitungan.index') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator fa-fw"></i><span class="nav-label"> Perhitungan GAP</span>
            </a>
            <a href="{{ route('admin.perhitungan.ranking') }}" class="nav-link {{ request()->routeIs('admin.perhitungan.ranking') ? 'active' : '' }}">
                <i class="fa-solid fa-trophy fa-fw"></i><span class="nav-label"> Hasil Rangking</span>
            </a>
            @endif

            @if(Auth::user()->role === 'mahasiswa')
            <div class="nav-section-label">Pendaftaran</div>
            <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-edit fa-fw"></i><span class="nav-label"> Data Pendaftaran</span>
            </a>
            <a href="{{ route('mahasiswa.berkas.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.berkas*') ? 'active' : '' }}">
                <i class="fa-solid fa-cloud-upload-alt fa-fw"></i><span class="nav-label"> Upload Berkas</span>
            </a>
            @endif

            @if(Auth::user()->role === 'juri')
            <div class="nav-section-label">Penilaian</div>
            <a href="{{ route('juri.penilaian.index') }}" class="nav-link {{ request()->routeIs('juri.penilaian.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check fa-fw"></i><span class="nav-label"> Peserta yang Dinilai</span>
            </a>
            <a href="{{ route('juri.penilaian.nilai') }}" class="nav-link {{ request()->routeIs('juri.penilaian.nilai') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar fa-fw"></i><span class="nav-label"> Rekap Nilai</span>
            </a>
            @endif

            @if(Auth::user()->role === 'wr3')
            <div class="nav-section-label">Validasi</div>
            <a href="{{ route('wr3.validasi.index') }}" class="nav-link {{ request()->routeIs('wr3.validasi*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-shield fa-fw"></i><span class="nav-label"> Validasi Tahap I</span>
            </a>
            <a href="{{ route('wr3.rekomendasi.index') }}" class="nav-link {{ request()->routeIs('wr3.rekomendasi*') ? 'active' : '' }}">
                <i class="fa-solid fa-ranking-star fa-fw"></i><span class="nav-label"> Rekomendasi Juara</span>
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" data-turbo="false">
                @csrf
                <button type="submit" class="btn btn-sm w-100 text-white border-0 text-start d-flex align-items-center gap-2" title="Logout" style="background:rgba(255,255,255,0.08)">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i><span> Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- SIDEBAR OVERLAY (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle d-none d-md-flex" onclick="toggleSidebarCollapse()" title="Toggle sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <button class="btn btn-sm btn-light d-md-none" onclick="toggleSidebar()" style="background: var(--bg-card); border: 1px solid var(--border-color); color: var(--text-body);">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <h6 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h6>
                    <small class="text-muted">PILMAPRES UM Metro</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- Notification Bell -->
                <div class="dropdown">
                    <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; background: var(--bg-card); border: 1px solid var(--border-color); transition: all 0.2s;">
                        <i class="fa-solid fa-bell" style="font-size: 1.1rem; color: var(--text-muted);"></i>
                        @if($unreadNotifs > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; border: 2px solid white; transform: translate(-35%, -15%) !important;">
                            {{ $unreadNotifs > 99 ? '99+' : $unreadNotifs }}
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow py-0" style="width: 350px; max-height: 450px; overflow-y: auto; border-radius: 16px; margin-top: 10px; background: var(--bg-card); border: 1px solid var(--border-color);">
                        <li>
                            <div class="d-flex align-items-center justify-content-between px-3 py-3" style="border-top-left-radius: 16px; border-top-right-radius: 16px; border-bottom: 1px solid var(--border-color); background: var(--bg-card);">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Notifikasi Terbaru</h6>
                                @if($unreadNotifs > 0)
                                <a href="javascript:void(0)" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.8rem;" onclick="event.preventDefault(); var f=document.getElementById('mark-all-read-form');if(f)f.submit();">
                                    Tandai semua dibaca
                                </a>
                                <form id="mark-all-read-form" action="{{ route('notifications.markAllRead') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                @endif
                            </div>
                        </li>
                            @forelse($notifs as $n)
                        <li>
                            <a class="dropdown-item py-3 px-3 border-bottom d-block transition {{ $n->is_read ? 'text-muted bg-white' : 'fw-semibold bg-light' }}"
                               href="{{ route('notifications.markAsRead', $n->id) }}"
                                style="{{ !$n->is_read ? 'background-color: rgba(59,130,246,0.08) !important; border-left: 3px solid var(--primary-light);' : '' }} white-space: normal;">
                                 <div class="d-flex align-items-start gap-2">
                                     <div class="text-{{ $n->type === 'success' ? 'success' : ($n->type === 'danger' ? 'danger' : 'primary') }} mt-1" style="font-size: 0.95rem;">
                                         <i class="fa-solid {{ $n->type === 'success' ? 'fa-circle-check' : ($n->type === 'danger' ? 'fa-circle-xmark' : 'fa-circle-info') }}"></i>
                                     </div>
                                     <div class="flex-grow-1" style="line-height: 1.4; font-size: 0.825rem; color: var(--text-body);">
                                        {{ $n->message }}
                                        <div class="text-muted mt-1" style="font-size: 0.725rem;"><i class="fa-regular fa-clock me-1"></i> {{ $n->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li>
                            <div class="text-center text-muted py-5">
                                <i class="fa-regular fa-bell-slash fa-2x mb-2 text-secondary opacity-50"></i>
                                <p class="mb-0 small">Tidak ada notifikasi baru</p>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>

                <span class="badge rounded-pill px-3 py-2 badge-{{ Auth::user()->role }}">
                    <i class="fa-solid fa-user-tag me-1"></i> {{ strtoupper(Auth::user()->role) }}
                </span>
                <span class="fw-semibold d-none d-md-inline" style="color: var(--text-muted);">{{ Auth::user()->nama_lengkap }}</span>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div id="flash-data" data-success="{{ session('success') }}" data-error="{{ session('error') }}" data-errors='@if($errors->any())@json($errors->all())@endif' style="display:none"></div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showFlash() {
            var flash = document.getElementById('flash-data');
            if (!flash) return;
            var success = flash.getAttribute('data-success');
            var error = flash.getAttribute('data-error');
            var errors = flash.getAttribute('data-errors');

            if (success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: success,
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn-custom-close' },
                    buttonsStyling: false
                });
                flash.removeAttribute('data-success');
                return;
            }
            if (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn-custom-close' },
                    buttonsStyling: false
                });
                flash.removeAttribute('data-error');
                return;
            }
            if (errors) {
                try {
                    var items = JSON.parse(errors);
                    var html = '<ul class="list-group list-group-flush mb-0 bg-transparent">';
                    items.forEach(function(msg) {
                        html += '<li class="list-group-item list-group-item-danger border-0 py-1 px-0 text-start small"><i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>' + msg + '</li>';
                    });
                    html += '</ul>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Input!',
                        html: html,
                        confirmButtonText: 'Tutup',
                        customClass: { confirmButton: 'btn-custom-close' },
                        buttonsStyling: false
                    });
                } catch(e) {}
                flash.removeAttribute('data-errors');
            }
        }

        function initConfirmInterceptors() {
            document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function(form) {
                var match = form.getAttribute('onsubmit').match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    var message = match[1];
                    form.removeAttribute('onsubmit');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'var(--primary)',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Lanjutkan!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'btn btn-primary rounded-pill px-4 me-2',
                                cancelButton: 'btn btn-danger rounded-pill px-4'
                            },
                            buttonsStyling: false
                        }).then(function(result) {
                            if (result.isConfirmed) form.submit();
                        });
                    });
                }
            });
            document.querySelectorAll('[onclick*="confirm("]').forEach(function(el) {
                var match = el.getAttribute('onclick').match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    var message = match[1];
                    el.removeAttribute('onclick');
                    el.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'var(--primary)',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Lanjutkan!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'btn btn-primary rounded-pill px-4 me-2',
                                cancelButton: 'btn btn-danger rounded-pill px-4'
                            },
                            buttonsStyling: false
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                var form = el.closest('form');
                                if (form) { form.submit(); }
                                else if (el.tagName === 'A' && el.getAttribute('href')) {
                                    window.location.href = el.getAttribute('href');
                                }
                            }
                        });
                    });
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            showFlash();
            initConfirmInterceptors();
        });
        document.addEventListener('turbo:load', function() {
            showFlash();
            initConfirmInterceptors();
        });

        // Sidebar Toggle (mobile)
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Sidebar Collapse (desktop) — pin/expand
        function toggleSidebarCollapse() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
            // Enable/disable tooltips
            if (window._sidebarTooltips) {
                window._sidebarTooltips.forEach(function(tp) {
                    if (sidebar.classList.contains('collapsed')) tp.enable();
                    else tp.disable();
                });
            }
        }

        function initSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;
            const sidebarNav = sidebar.querySelector('.sidebar-nav');

            // Scroll active link into view
            if (sidebarNav) {
                const activeLink = sidebarNav.querySelector('.nav-link.active');
                if (activeLink) {
                    activeLink.scrollIntoView({ block: 'center' });
                }
            }

            // Bootstrap tooltips for sidebar nav-links
            const tooltips = [];
            sidebar.querySelectorAll('.nav-link:not([data-bs-toggle="collapse"])').forEach(function(link) {
                if (link.closest('.collapse')) return;
                const label = link.querySelector('.nav-label');
                if (!label) return;
                link.setAttribute('title', label.textContent.trim());
                link.setAttribute('data-bs-toggle', 'tooltip');
                link.setAttribute('data-bs-placement', 'right');
                link.setAttribute('data-bs-custom-class', 'sidebar-tooltip');
                const tp = new bootstrap.Tooltip(link, { trigger: 'hover' });
                if (!sidebar.classList.contains('collapsed')) tp.disable();
                tooltips.push(tp);
            });
            window._sidebarTooltips = tooltips;

            // Bootstrap tooltip for logout button
            const logoutBtn = sidebar.querySelector('.sidebar-footer .btn');
            if (logoutBtn) {
                logoutBtn.setAttribute('title', 'Logout');
                logoutBtn.setAttribute('data-bs-toggle', 'tooltip');
                logoutBtn.setAttribute('data-bs-placement', 'right');
                logoutBtn.setAttribute('data-bs-custom-class', 'sidebar-tooltip');
                const tp = new bootstrap.Tooltip(logoutBtn, { trigger: 'hover' });
                if (!sidebar.classList.contains('collapsed')) tp.disable();
                window._sidebarTooltips.push(tp);
            }

            // Prevent collapse togglers from firing in collapsed mode
            sidebar.addEventListener('click', function(e) {
                if (!sidebar.classList.contains('collapsed')) return;
                if (e.target.closest('[data-bs-toggle="collapse"]')) {
                    e.stopPropagation();
                }
            }, true);

            // Chevron rotation on collapse events
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(toggler) {
                const targetId = toggler.getAttribute('data-bs-target') || toggler.getAttribute('href');
                if (!targetId) return;
                const target = document.querySelector(targetId);
                if (!target) return;
                const chevron = toggler.querySelector('.collapse-chevron');
                if (!chevron) return;
                target.addEventListener('show.bs.collapse', function() {
                    chevron.classList.add('rotated');
                });
                target.addEventListener('hide.bs.collapse', function() {
                    chevron.classList.remove('rotated');
                });
            });
        }

        // Clean up before Turbo caches page (prevents duplicate tooltips & stale intervals)
        document.addEventListener('turbo:before-cache', function() {
            if (window._sidebarTooltips) {
                window._sidebarTooltips.forEach(function(tp) { tp.dispose(); });
                window._sidebarTooltips = [];
            }
            // Clear any intervals stored on window
            if (window._pageIntervals) {
                window._pageIntervals.forEach(function(id) { clearInterval(id); });
                window._pageIntervals = [];
            }
        });

        document.addEventListener('DOMContentLoaded', initSidebar);
        document.addEventListener('turbo:load', initSidebar);
    </script>
    @stack('scripts')
</body>
</html>
