<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PILMAPRES Universitas Muhammadiyah Metro</title>
    <link rel="icon" href="{{ asset('assets/logoummetro.webp') }}" type="image/webp">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
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
        /* Navbar Styling */
        .navbar {
            padding: 15px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }
        .navbar-brand .logo-text {
            font-weight: 700;
            color: #1a3c7a;
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
            color: #1a3c7a;
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
            color: #1a3c7a;
            border: 1px solid #1a3c7a;
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
        }
        .btn-outline-custom:hover {
            background-color: #1a3c7a;
            color: white;
        }
        .btn-orange {
            background-color: #ff7b00;
            color: white;
            border-radius: 20px;
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
            background: linear-gradient(135deg, #184ab8 0%, #2a6df0 100%);
            padding: 50px 0;
            color: white;
            text-align: center;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #1a3c7a;
            color: white;
            padding: 20px 0;
            text-align: center;
            flex-shrink: 0;
        }

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
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-custom me-2"><i class="fa-solid fa-chart-line me-1"></i> Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline-custom me-2 text-decoration-none">Daftar</a>
                        <a href="{{ route('login') }}" class="btn btn-orange text-decoration-none"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i> Login</a>
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
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
</body>
</html>
