<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pendukung Keputusan PILMAPRES UM Metro</title>
    <link rel="icon" href="{{ asset('assets/logoummetro.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <style>
        :root {
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
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
            font-weight: 400;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
        }
        .fw-bold {
            font-weight: 700 !important;
        }
        .fw-semibold {
            font-weight: 600 !important;
        }
        .fw-normal {
            font-weight: 400 !important;
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
        }
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #ffffff;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 10px 20px;
            margin-bottom: 5px;
            border-radius: var(--radius-sm);
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: var(--primary);
        }
        .sidebar .nav-link i {
            width: 24px;
        }
        .main-content {
            padding: 20px;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: var(--radius);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/" onclick="event.preventDefault();">
                <img src="{{ asset('assets/logoummetro.webp') }}" alt="Logo UM Metro" height="35" class="me-2">
                PILMAPRES UM Metro
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle me-1"></i> {{ Auth::user()->nama_lengkap }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-sign-out-alt me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        @php $regJadwal = \App\Models\Jadwal::where('kegiatan', 'like', '%Pendaftaran%')->first(); $regBuka = $regJadwal && now()->between(\Carbon\Carbon::parse($regJadwal->tanggal_mulai), \Carbon\Carbon::parse($regJadwal->tanggal_selesai)); @endphp
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if($regBuka)
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white ms-2 px-3" href="{{ route('register') }}">Daftar Mahasiswa</a>
                        </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar py-3 collapse" id="sidebarMenu">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->role == 'admin')
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Manajemen Admin</span>
                    </h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-users"></i> Akun Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-list-check"></i> Kriteria Penilaian
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-file-signature"></i> Pendaftaran & Berkas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-calculator"></i> Proses Perhitungan
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'mahasiswa')
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Menu Mahasiswa</span>
                    </h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-user-edit"></i> Data Pendaftaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-upload"></i> Upload Berkas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-bullhorn"></i> Pengumuman Hasil
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'juri')
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Menu Juri</span>
                    </h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-clipboard-check"></i> Penilaian Peserta
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'wr3')
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Menu WR III</span>
                    </h6>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-file-shield"></i> Validasi Tahap I
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-ranking-star"></i> Rekomendasi Juara
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endauth

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonColor: '#0d6efd',
                    customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                    buttonsStyling: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json(session('error')),
                    confirmButtonColor: '#dc3545',
                    customClass: { confirmButton: 'btn btn-danger rounded-pill px-4' },
                    buttonsStyling: false
                });
            @endif

            @if($errors->any())
                @php
                    $errorItems = collect($errors->all())->map(fn($err) =>
                        '<li class="list-group-item list-group-item-danger border-0 py-1 px-0 text-start small"><i class="fa-solid fa-circle-exclamation me-2 text-danger"></i>' . e($err) . '</li>'
                    )->implode('');
                @endphp
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Input!',
                    html: '<ul class="list-group list-group-flush mb-0 bg-transparent">{{ $errorItems }}</ul>',
                    confirmButtonColor: '#dc3545',
                    customClass: { confirmButton: 'btn btn-danger rounded-pill px-4' },
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
                            confirmButtonColor: '#0d6efd',
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
                            confirmButtonColor: '#0d6efd',
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
