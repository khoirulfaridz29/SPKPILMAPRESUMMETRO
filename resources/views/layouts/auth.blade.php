<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">
    <title>@yield('title', 'Login') - PILMAPRES UM Metro</title>
    <link rel="icon" href="{{ asset('assets/logoummetro.webp') }}" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'">
    <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo/dist/turbo.es2017-umd.min.js"></script>
    <meta name="turbo-cache-control" content="no-preview">
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Montserrat', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: var(--bg);
        }
        .split-wrapper { display: flex; height: 100vh; }

        /* ── Brand Panel (38.2% = 1/φ²) ── */
        .brand-panel {
            flex: 0 0 38.2%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .brand-panel .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .brand-panel .bg-circle:nth-child(1) {
            width: 60vmin; height: 60vmin;
            top: -15%; right: -15%;
        }
        .brand-panel .bg-circle:nth-child(2) {
            width: 40vmin; height: 40vmin;
            bottom: -10%; left: -10%;
        }

        .brand-content {
            text-align: center;
            color: #fff;
            position: relative;
            z-index: 1;
            padding: 40px;
        }
        .brand-content .logo-frame {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            backdrop-filter: blur(4px);
        }
        .brand-content .logo-frame img {
            height: 72px;
            width: auto;
        }
        .brand-content h1 {
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            letter-spacing: 2px;
            line-height: 1.15;
        }
        .brand-content .subtitle {
            font-size: clamp(13px, 1.1vw, 15px);
            font-weight: 500;
            opacity: 0.85;
            margin-top: 6px;
        }
        .brand-content .divider-line {
            width: 48px;
            height: 3px;
            border-radius: 2px;
            background: rgba(255,255,255,0.2);
            margin: 18px auto;
        }
        .brand-content .tagline {
            font-size: clamp(12px, 0.9vw, 13px);
            opacity: 0.6;
            max-width: 260px;
            line-height: 1.7;
            margin: 0 auto;
        }

        /* ── Form Panel (61.8% = 1/φ) ── */
        .form-panel {
            flex: 0 0 61.8%;
            background: #fcfcfc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .form-container {
            width: 100%;
            max-width: 380px;
        }
        .form-container .mini-logo {
            text-align: center;
            margin-bottom: 6px;
        }
        .form-container .mini-logo img {
            height: 50px;
        }
        .form-container h2 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            text-align: center;
            margin-bottom: 2px;
        }
        .form-container .form-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 26px;
        }

        /* Form fields */
        .form-container .form-label {
            font-weight: 600;
            font-size: 13px;
            color: var(--text);
            margin-bottom: 5px;
        }
        .form-container .input-group {
            border-radius: var(--radius);
        }
        .form-container .input-group-text {
            border: 1.5px solid var(--border);
            border-right: none;
            background: #fff;
            color: var(--primary);
            padding: 11px 14px;
            font-size: 14px;
        }
        .form-container .input-group-text:first-child {
            border-radius: var(--radius) 0 0 var(--radius);
        }
        .form-container .form-control {
            border: 1.5px solid var(--border);
            border-left: none;
            padding: 11px 14px;
            font-size: 14px;
            background: #fff;
            color: var(--text);
            border-radius: 0 !important;
        }
        .form-container .form-control::placeholder {
            color: #adb5bd;
        }
        .form-container .form-control:focus {
            box-shadow: none;
            border-color: var(--primary);
        }
        .form-container .toggle-pw {
            border: 1.5px solid var(--border);
            border-left: none;
            background: #fff;
            color: #adb5bd;
            padding: 11px 14px;
            cursor: pointer;
            font-size: 14px;
            transition: color 0.15s;
            user-select: none;
        }
        .form-container .toggle-pw:last-child,
        .form-container .input-group-text:last-child {
            border-radius: 0 var(--radius) var(--radius) 0;
        }
        .form-container .toggle-pw:hover { color: var(--primary); }
        .form-container .input-group:focus-within .input-group-text,
        .form-container .input-group:focus-within .toggle-pw {
            border-color: var(--primary);
        }
        .form-container .input-group:focus-within {
            box-shadow: 0 0 0 3px rgba(26,60,122,0.08);
        }

        /* Remember me + Forgot password row */
        .form-container .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 16px 0 22px;
        }
        .form-container .form-check {
            display: flex;
            align-items: center;
            min-height: auto;
            margin-bottom: 0;
            padding-left: 0;
        }
        .form-container .form-check-input {
            width: 16px;
            height: 16px;
            margin: 0 8px 0 0;
            border: 1.5px solid #d0d5dd;
            border-radius: 4px;
            cursor: pointer;
            flex-shrink: 0;
        }
        .form-container .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .form-container .form-check-label {
            font-size: 13px;
            color: var(--text);
            font-weight: 500;
            cursor: pointer;
            line-height: 1;
        }
        .form-container .forgot-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
        }
        .form-container .forgot-link:hover { text-decoration: underline; }

        /* Primary button */
        .form-container .btn-login {
            width: 100%;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 15px;
            border-radius: var(--radius);
            border: none;
            background: var(--primary);
            color: #fff;
            transition: all 0.2s;
        }
        .form-container .btn-login:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(26,60,122,0.3);
        }
        .form-container .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .form-container .divider {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 22px 0 18px;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 500;
        }
        .form-container .divider::before,
        .form-container .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Social buttons */
        .form-container .social-btns {
            display: flex;
            gap: 12px;
        }
        .form-container .social-btns .btn-social {
            flex: 1;
            padding: 10px;
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
        }
        .form-container .social-btns .btn-social:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: #f5f7ff;
        }

        /* Register link */
        .form-container .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-muted);
        }
        .form-container .register-link a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }
        .form-container .register-link a:hover { text-decoration: underline; }

        /* Validation */
        .form-container .invalid-feedback {
            font-size: 12px;
        }

        /* ── SweetAlert body shift fix ── */
        body.swal2-shown {
            padding-right: 0 !important;
        }
        body.swal2-height-auto {
            height: 100vh !important;
        }

        /* ── Responsive ── */
        @media (max-width: 767px) {
            .split-wrapper { flex-direction: column; overflow-y: auto; }
            .brand-panel { flex: none; padding: 24px 20px 16px; }
            .brand-panel .bg-circle { display: none; }
            .brand-content { padding: 0; }
            .brand-content .logo-frame { width: 80px; height: 80px; margin-bottom: 18px; }
            .brand-content .logo-frame img { height: 52px; }
            .brand-content h1 { font-size: 22px; }
            .brand-content .subtitle { font-size: 12px; }
            .brand-content .divider-line { margin: 12px auto; }
            .brand-content .tagline { display: none; }
            .form-panel { padding: 28px 20px; align-items: flex-start; }
        }
        @media (min-width: 768px) and (max-width: 1024px) {
            .brand-content h1 { font-size: 26px; }
            .brand-content .logo-frame { width: 90px; height: 90px; }
            .brand-content .logo-frame img { height: 58px; }
        }
        /* Global cursor — teks hanya untuk input */
        * { cursor: default; }
        a, button, [role="button"], .btn, label[for],
        input[type="button"], input[type="submit"], input[type="reset"],
        input[type="checkbox"], input[type="radio"] { cursor: pointer; }
        input:not([type="button"]):not([type="submit"]):not([type="reset"]):not([type="checkbox"]):not([type="radio"]),
        textarea, select, [contenteditable="true"] { cursor: text; }
        .disabled, [disabled] { cursor: default !important; }
    </style>
    @stack('styles')
</head>
    <body class="@yield('body-class')">
    <div class="split-wrapper">
        <div class="brand-panel">
            <div class="bg-circle"></div>
            <div class="bg-circle"></div>
            <div class="brand-content">
                <div class="logo-frame">
                    <img src="{{ asset('assets/logoummetro.webp') }}" alt="UM Metro Logo">
                </div>
                <h1>PILMAPRES</h1>
                <div class="subtitle">Universitas Muhammadiyah Metro</div>
                <div class="divider-line"></div>
                <div class="tagline">Decision Support System for<br>Outstanding Student Selection</div>
            </div>
        </div>
        <div class="form-panel">
            <turbo-frame id="auth-form">
                <div class="form-container @yield('form-container-class')">
                    <div class="mini-logo">
                        <img src="{{ asset('assets/logoummetro.webp') }}" alt="UM Metro Logo">
                    </div>
                    <h2>@yield('form-title', 'Welcome Back')</h2>
                    <p class="form-subtitle">@yield('form-subtitle', 'Please enter your credentials to continue')</p>
                    @yield('form-content')

                    <script>
                    (function() {
                        function initAuthPage() {
                            @if(session('success'))
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
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
                                    confirmButtonColor: '#1a3c7a',
                                    customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
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
                                    title: 'Input Error!',
                                    html: '<ul class="list-group list-group-flush mb-0 bg-transparent">{{ $errorItems }}</ul>',
                                    confirmButtonColor: '#1a3c7a',
                                    customClass: { confirmButton: 'btn btn-primary rounded-pill px-4' },
                                    buttonsStyling: false
                                });
                            @endif
                        }

                        initAuthPage();
                        document.addEventListener('turbo:frame-load', function(e) {
                            if (e.target && e.target.id === 'auth-form') {
                                initAuthPage();
                            }
                        });
                    })();
                    </script>
                </div>
            </turbo-frame>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>
</html>
