<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PILMAPRES Universitas Muhammadiyah Metro</title>
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
    <!-- Turbo: SPA-like navigation without full reload -->
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo/dist/turbo.es2017-umd.min.js"></script>

    @php
        $jadwalReg = \App\Models\Jadwal::where('kegiatan', 'like', '%Pendaftaran%')->first();
        $isRegistrationOpen = $jadwalReg && now()->between(\Carbon\Carbon::parse($jadwalReg->tanggal_mulai), \Carbon\Carbon::parse($jadwalReg->tanggal_selesai));
    @endphp

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
            background-color: #fcfcfc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        /* Pulsing ring effect for status dot */
        .status-dot {
            position: relative;
            display: inline-flex;
            width: 10px;
            height: 10px;
            margin-right: 8px;
        }
        .status-dot .dot-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: currentColor;
            position: relative;
            z-index: 1;
        }
        .status-dot.status-open { color: #4ade80; }
        .status-dot.status-closed { color: #f87171; }
        .status-dot .dot-inner {
            animation: dot-pulse 2s ease-in-out infinite;
        }
        .status-dot::before,
        .status-dot::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid currentColor;
            animation: ping-ring 2s ease-out infinite;
        }
        .status-dot::after {
            animation-delay: 1s;
        }
        @keyframes ping-ring {
            0% { transform: scale(1); opacity: 1; }
            100% { transform: scale(1.8); opacity: 0; }
        }
        @keyframes dot-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Navbar Styling */
        .navbar {
            padding: 15px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }
        .navbar-brand .logo-text {
            font-weight: 700;
            color: var(--primary);
            font-size: 20px;
            line-height: 1.2;
        }
        .navbar-brand .logo-subtext {
            font-weight: 400;
            font-size: 12px;
            color: #6c757d;
        }
        .nav-link {
            color: #555;
            font-weight: 500;
            font-size: 15px;
            margin: 0 10px;
            position: relative;
        }
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
            font-weight: 600;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 10px;
            right: 10px;
            height: 2px;
            background-color: #ff7b00;
            border-radius: 2px;
        }
        .btn-outline-custom {
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: var(--radius) !important;
            padding: 8px 20px;
            font-weight: 600;
        }
        .btn-outline-custom:hover {
            background-color: var(--primary);
            color: white;
        }
        .btn-orange {
            background-color: #ff7b00;
            color: white;
            border-radius: var(--radius) !important;
            padding: 8px 25px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 6px rgba(255, 123, 0, 0.2);
        }
        .btn-orange:hover {
            background-color: #e66a00;
            color: white;
        }

        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 50px 0;
            color: white;
            text-align: center;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: var(--primary);
            color: white;
            padding: 20px 0;
            text-align: center;
            flex-shrink: 0;
        }

        /* Global cursor — panah di non-interaktif, I-beam hanya di input */
        * { cursor: default; -webkit-user-select: none; user-select: none; }
        a, button, [role="button"], .btn, label[for],
        input[type="button"], input[type="submit"], input[type="reset"],
        input[type="checkbox"], input[type="radio"] { cursor: pointer; }
        input:not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="checkbox"]):not([type="radio"]),
        textarea, select, [contenteditable="true"] { cursor: text; -webkit-user-select: text; user-select: text; }
        .disabled, [disabled] { cursor: default !important; }

        @yield('custom-css')
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}" onclick="event.preventDefault();">
                <img src="{{ asset('assets/logoummetro.webp') }}" alt="Logo UM Metro" height="50" class="me-2">
                <div>
                    <div class="logo-text">PILMAPRES</div>
                    <div class="logo-subtext">Universitas Muhammadiyah Metro</div>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}" href="{{ route('informasi') }}">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('jadwal') ? 'active' : '' }}" href="{{ route('jadwal') }}">Jadwal</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pengumuman') ? 'active' : '' }}" href="{{ route('pengumuman') }}">Pengumuman</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" data-turbo="false" class="btn btn-outline-custom me-2"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                    @else
                        @if($isRegistrationOpen)
                        <a href="{{ route('register') }}" data-turbo="false" class="btn btn-outline-custom me-2 text-decoration-none">Daftar</a>
                        @endif
                        <a href="{{ route('login') }}" data-turbo="false" class="btn btn-orange text-decoration-none"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} PILMAPRES Universitas Muhammadiyah Metro. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function initFrontend() {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonColor: '#1a3c7a',
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
        }

        // Run on both initial load and Turbo navigations
        document.addEventListener('DOMContentLoaded', initFrontend);
        document.addEventListener('turbo:load', initFrontend);
    </script>
</body>
</html>
