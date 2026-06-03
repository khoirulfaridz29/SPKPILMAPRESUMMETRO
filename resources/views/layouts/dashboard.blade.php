<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — PILMAPRES UM Metro</title>
    <link rel="icon" href="{{ asset('assets/logoummetro.webp') }}" type="image/webp">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #1a3c7a;
            --accent: #ff7b00;
        }
        body { font-family: 'Montserrat', sans-serif; background: #f0f4f8; font-weight: 400; }
        h1, h2, h3, h4, h5, h6 { font-weight: 700; }
        .fw-bold { font-weight: 700 !important; }
        .fw-semibold { font-weight: 600 !important; }
        .fw-normal { font-weight: 400 !important; }

        /* SIDEBAR */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-width);
            background: linear-gradient(160deg, #0f2550 0%, #1a3c7a 100%);
            color: white;
            display: flex; flex-direction: column;
            z-index: 1000;
            transition: transform 0.3s;
        }
        .sidebar-brand {
            padding: 22px 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand .brand-name {
            font-weight: 700; font-size: 18px; color: white;
        }
        .sidebar-brand .brand-sub {
            font-size: 11px; color: rgba(255,255,255,0.55);
        }
        .sidebar-nav { padding: 15px 12px; flex: 1; overflow-y: auto; }
        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            color: rgba(255,255,255,0.35); text-transform: uppercase;
            padding: 12px 10px 4px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500;
            padding: 9px 14px; border-radius: 8px; margin-bottom: 3px;
            display: flex; align-items: center; gap: 10px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.12); color: white;
        }
        .sidebar .nav-link.active {
            background: var(--accent); color: white;
            box-shadow: 0 4px 12px rgba(255,123,0,0.4);
        }
        .sidebar-footer {
            padding: 15px 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* MAIN AREA */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
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
        .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .card-header { background: white; border-bottom: 1px solid #f1f5f9; font-weight: 700; padding: 16px 20px; }

        /* BADGE ROLE */
        .badge-admin { background: #dbeafe; color: #1d4ed8; }
        .badge-mahasiswa { background: #dcfce7; color: #15803d; }
        .badge-juri { background: #fef9c3; color: #a16207; }
        .badge-wr3 { background: #f3e8ff; color: #7e22ce; }

        @media(max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
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
            background: radial-gradient(circle, #3b82f6 0%, #2563eb 100%) !important;
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
                <i class="fa-solid fa-house-chimney fa-fw"></i> Dashboard
            </a>

            @if(Auth::user()->role === 'admin')
            <div class="nav-section-label">Manajemen</div>
            <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days fa-fw"></i> Jadwal Pelaksanaan
            </a>
            <a href="{{ route('admin.pengumuman.index') }}" class="nav-link {{ request()->routeIs('admin.pengumuman*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullhorn fa-fw"></i> Pengumuman
            </a>
            <a href="{{ route('admin.persyaratan.index') }}" class="nav-link {{ request()->routeIs('admin.persyaratan*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice fa-fw"></i> Persyaratan Form
            </a>
            <a href="{{ route('admin.kriteria.index') }}" class="nav-link {{ request()->routeIs('admin.kriteria*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check fa-fw"></i> Kriteria Penilaian
            </a>
            <a href="{{ route('admin.rubrik-cu.index') }}" class="nav-link {{ request()->routeIs('admin.rubrik-cu*') ? 'active' : '' }}">
                <i class="fa-solid fa-table fa-fw"></i> Rubrik Capaian Unggulan
            </a>
            <a href="{{ route('admin.rubrik-naskah-gk.index') }}" class="nav-link {{ request()->routeIs('admin.rubrik-naskah-gk*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-pen fa-fw"></i> Rubrik Naskah GK
            </a>
            <a href="{{ route('admin.rubrik-presentasi-gk.index') }}" class="nav-link {{ request()->routeIs('admin.rubrik-presentasi-gk*') ? 'active' : '' }}">
                <i class="fa-solid fa-person-chalkboard fa-fw"></i> Rubrik Presentasi GK
            </a>
            <a href="{{ route('admin.rubrik-bahasa-inggris.index') }}" class="nav-link {{ request()->routeIs('admin.rubrik-bahasa-inggris*') ? 'active' : '' }}">
                <i class="fa-solid fa-language fa-fw"></i> Rubrik Bahasa Inggris
            </a>
            <a href="{{ route('admin.rubrik-wawancara-cu.index') }}" class="nav-link {{ request()->routeIs('admin.rubrik-wawancara-cu*') ? 'active' : '' }}">
                <i class="fa-solid fa-microphone fa-fw"></i> Rubrik Wawancara CU
            </a>
            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fa-solid fa-users-gear fa-fw"></i> Kelola Akun
            </a>
            <div class="nav-section-label">Seleksi</div>
            <a href="{{ route('admin.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('admin.pendaftaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-circle-check fa-fw"></i> Pendaftaran & Berkas
            </a>
            <a href="{{ route('admin.rekap.index') }}" class="nav-link {{ request()->routeIs('admin.rekap*') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-list fa-fw"></i> Rekap Tahap I
            </a>
            <a href="{{ route('admin.perhitungan.index') }}" class="nav-link {{ request()->routeIs('admin.perhitungan*') ? 'active' : '' }}">
                <i class="fa-solid fa-calculator fa-fw"></i> Perhitungan GAP
            </a>
            @endif

            @if(Auth::user()->role === 'mahasiswa')
            <div class="nav-section-label">Pendaftaran</div>
            <a href="{{ route('mahasiswa.pendaftaran.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.pendaftaran*') ? 'active' : '' }}">
                <i class="fa-solid fa-user-edit fa-fw"></i> Data Pendaftaran
            </a>
            <a href="{{ route('mahasiswa.berkas.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.berkas*') ? 'active' : '' }}">
                <i class="fa-solid fa-cloud-upload-alt fa-fw"></i> Upload Berkas
            </a>
            @endif

            @if(Auth::user()->role === 'juri')
            <div class="nav-section-label">Penilaian</div>
            <a href="{{ route('juri.penilaian.index') }}" class="nav-link {{ request()->routeIs('juri.penilaian.index') ? 'active' : '' }}">
                <i class="fa-solid fa-clipboard-check fa-fw"></i> Peserta yang Dinilai
            </a>
            <a href="{{ route('juri.penilaian.nilai') }}" class="nav-link {{ request()->routeIs('juri.penilaian.nilai') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar fa-fw"></i> Rekap Nilai
            </a>
            @endif

            @if(Auth::user()->role === 'wr3')
            <div class="nav-section-label">Validasi</div>
            <a href="{{ route('wr3.validasi.index') }}" class="nav-link {{ request()->routeIs('wr3.validasi*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-shield fa-fw"></i> Validasi Tahap I
            </a>
            <a href="{{ route('wr3.rekomendasi.index') }}" class="nav-link {{ request()->routeIs('wr3.rekomendasi*') ? 'active' : '' }}">
                <i class="fa-solid fa-ranking-star fa-fw"></i> Rekomendasi Juara
            </a>
            @endif
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100 text-white border-0 text-start d-flex align-items-center gap-2" style="background:rgba(255,255,255,0.08)">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN WRAPPER -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
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
                    <button class="btn btn-light position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 50%; width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center; background: #f8fafc; border: 1px solid #e2e8f0; transition: all 0.2s;">
                        <i class="fa-solid fa-bell text-secondary" style="font-size: 1.1rem;"></i>
                        @php
                            $unreadNotifs = \App\Models\NotificationApp::where('user_id', Auth::id())->where('is_read', false)->count();
                        @endphp
                        @if($unreadNotifs > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem; border: 2px solid white; transform: translate(-35%, -15%) !important;">
                            {{ $unreadNotifs > 99 ? '99+' : $unreadNotifs }}
                        </span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0" style="width: 350px; max-height: 450px; overflow-y: auto; border-radius: 16px; margin-top: 10px;">
                        <li>
                            <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom bg-light" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                                <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Notifikasi Terbaru</h6>
                                @if($unreadNotifs > 0)
                                <a href="{{ route('notifications.markAllRead') }}" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.8rem;" onclick="event.preventDefault(); document.getElementById('mark-all-read-form').submit();">
                                    Tandai semua dibaca
                                </a>
                                <form id="mark-all-read-form" action="{{ route('notifications.markAllRead') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                @endif
                            </div>
                        </li>
                        @php
                            $notifs = \App\Models\NotificationApp::where('user_id', Auth::id())->latest()->take(5)->get();
                        @endphp
                        @forelse($notifs as $n)
                        <li>
                            <a class="dropdown-item py-3 px-3 border-bottom d-block transition {{ $n->is_read ? 'text-muted bg-white' : 'fw-semibold bg-light' }}"
                               href="{{ route('notifications.markAsRead', $n->id) }}"
                               style="{{ !$n->is_read ? 'background-color: #eff6ff !important; border-left: 3px solid #3b82f6;' : '' }} white-space: normal;">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="text-{{ $n->type === 'success' ? 'success' : ($n->type === 'danger' ? 'danger' : 'primary') }} mt-1" style="font-size: 0.95rem;">
                                        <i class="fa-solid {{ $n->type === 'success' ? 'fa-circle-check' : ($n->type === 'danger' ? 'fa-circle-xmark' : 'fa-circle-info') }}"></i>
                                    </div>
                                    <div class="flex-grow-1" style="line-height: 1.4; font-size: 0.825rem; color: {{ $n->is_read ? '#64748b' : '#1e293b' }};">
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
                <span class="fw-semibold text-secondary d-none d-md-inline">{{ Auth::user()->nama_lengkap }}</span>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn-custom-close' },
                    buttonsStyling: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json(session('error')),
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn-custom-close' },
                    buttonsStyling: false
                });
            @endif

            @if($errors->any())
                @php
                    $errList = implode('', array_map(function($err) {
                        return '<li class="list-group-item list-group-item-danger border-0 py-1 px-0 text-start small"><i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>' . e($err) . '</li>';
                    }, $errors->all()));
                @endphp
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input!',
                    html: '<ul class="list-group list-group-flush mb-0 bg-transparent">{!! addslashes($errList) !!}</ul>',
                    confirmButtonText: 'Tutup',
                    customClass: { confirmButton: 'btn-custom-close' },
                    buttonsStyling: false
                });
            @endif

            // Auto-intercept standard confirm boxes in forms
            document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function(form) {
                const onsubmitAttr = form.getAttribute('onsubmit');
                const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    const message = match[1];
                    form.removeAttribute('onsubmit');
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1a3c7a',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Lanjutkan!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'btn btn-primary rounded-pill px-4 me-2',
                                cancelButton: 'btn btn-danger rounded-pill px-4'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                }
            });

            // Auto-intercept standard confirm boxes in buttons/links
            document.querySelectorAll('[onclick*="confirm("]').forEach(function(element) {
                const onclickAttr = element.getAttribute('onclick');
                const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
                if (match) {
                    const message = match[1];
                    element.removeAttribute('onclick');
                    element.addEventListener('click', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1a3c7a',
                            cancelButtonColor: '#dc3545',
                            confirmButtonText: 'Ya, Lanjutkan!',
                            cancelButtonText: 'Batal',
                            customClass: {
                                confirmButton: 'btn btn-primary rounded-pill px-4 me-2',
                                cancelButton: 'btn btn-danger rounded-pill px-4'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const form = element.closest('form');
                                if (form) {
                                    form.submit();
                                } else if (element.tagName === 'A' && element.getAttribute('href')) {
                                    window.location.href = element.getAttribute('href');
                                }
                            }
                        });
                    });
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
