@extends('layouts.frontend')

@section('custom-css')
    /* Hero Section */
    .hero-section {
        background-color: var(--primary) !important;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        padding: 100px 0;
        color: white !important;
        position: relative;
        overflow: hidden;
    }
    /* Animated pattern background */
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        pointer-events: none;
    }

    /* Decorative blobs */
    .blob {
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        filter: blur(80px);
        border-radius: 50%;
        z-index: 0;
    }
    .blob-1 { top: -100px; right: -100px; background: rgba(255, 170, 0, 0.15); }
    .blob-2 { bottom: -150px; left: -100px; }

    .badge-status {
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        color: white;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        margin-bottom: 25px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .badge-status i {
        font-size: 10px;
        margin-right: 8px;
    }
    .status-open { color: #4ade80; }
    .status-closed { color: #f87171; }

    .hero-title {
        font-size: 5.5rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 0.5rem;
        letter-spacing: -1px;
        color: white !important;
    }
    .hero-title span {
        color: #ffaa00;
        text-shadow: 0 4px 10px rgba(255, 170, 0, 0.3);
    }
    .hero-subtitle {
        font-size: 2.2rem;
        font-weight: 600;
        line-height: 1.3;
        margin-bottom: 0.5rem;
        opacity: 0.95;
    }
    .hero-university {
        font-size: 1.3rem;
        font-weight: 500;
        line-height: 1.4;
        margin-bottom: 0.75rem;
        opacity: 0.9;
    }
    .hero-quote {
        font-size: 1.1rem;
        font-style: italic;
        font-weight: 400;
        line-height: 1.5;
        opacity: 0.7;
        margin-bottom: 1.5rem;
        max-width: 600px;
    }

    .hero-btn-white {
        background-color: white;
        color: var(--primary);
        border-radius: var(--radius);
        padding: 14px 35px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .hero-btn-white:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
        color: var(--primary);
    }

    .hero-btn-orange {
        background-color: #ff7b00;
        color: white;
        border-radius: var(--radius);
        padding: 14px 35px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(255, 123, 0, 0.4);
    }
    .hero-btn-orange:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(255, 123, 0, 0.5);
        color: white;
        background-color: #f57000;
    }

    /* Right Cards in Hero */
    .hero-card {
        background-color: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 18px;
        padding: 18px 24px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        transition: transform 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: white;
    }
    .hero-card:hover {
        background-color: rgba(255, 255, 255, 0.15);
        transform: translateX(-10px) scale(1.02);
        border-color: rgba(255, 255, 255, 0.3);
        color: white;
    }
    .hero-card:focus, .hero-card:focus-visible, .hero-card:active {
        outline: none !important;
        box-shadow: none !important;
    }
    .hero-card-icon {
        background-color: rgba(255, 255, 255, 0.2);
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        font-size: 20px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .hero-card:hover .hero-card-icon {
        background-color: #ffaa00;
        color: var(--primary);
    }
    .hero-card-text h6 {
        margin: 0;
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 2px;
    }
    .hero-card-text p {
        margin: 0;
        font-size: 12px;
        opacity: 0.7;
    }

    /* Schedule Section */
    .schedule-section {
        padding: 100px 0;
        background-color: #f8fafc;
    }
    .section-title {
        text-align: center;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 50px;
        position: relative;
        font-size: 2.5rem;
    }
    .section-title::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 6px;
        background: linear-gradient(to right, #ff7b00, #ffaa00);
        border-radius: 10px;
    }

    .schedule-card {
        background-color: white;
        border: none;
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 30px;
        transition: all 0.4s;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .schedule-card:hover {
        box-shadow: 0 20px 40px rgba(30, 58, 138, 0.1);
        transform: translateY(-10px);
    }
    .schedule-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }
    .schedule-card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0;
        color: var(--primary-dark);
        flex: 1;
    }

    .badge-time {
        padding: 8px 16px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .badge-blue { background-color: var(--bg); color: var(--primary); }
    .badge-green { background-color: #ecfdf5; color: #059669; }
    .badge-gray { background-color: #f1f5f9; color: #64748b; }

    .schedule-detail {
        font-size: 15px;
        color: #64748b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
    }
    .schedule-detail i {
        color: var(--primary-light);
        width: 25px;
        font-size: 16px;
        margin-right: 10px;
        text-align: center;
    }
    .btn-detail {
        background-color: var(--primary-dark);
        color: white;
        border-radius: var(--radius);
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 700;
        display: inline-block;
        margin-top: auto;
        text-decoration: none;
        transition: all 0.3s;
        text-align: center;
    }
    .btn-detail:hover {
        background-color: var(--primary);
        color: white;
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .hero-title { font-size: 4rem; }
        .hero-subtitle { font-size: 1.8rem; }
        .hero-section { padding: 60px 0; }
    }
@endsection


@section('content')

@php
    $isRegistrationOpen = false;
    $registrationSchedule = $jadwal->filter(function($item) {
        return stripos($item->kegiatan, 'Pendaftaran') !== false;
    })->first();

    if ($registrationSchedule) {
        $now = now();
        $start = \Carbon\Carbon::parse($registrationSchedule->tanggal_mulai);
        $end = \Carbon\Carbon::parse($registrationSchedule->tanggal_selesai);
        if ($now->between($start, $end)) {
            $isRegistrationOpen = true;
        }
    }
@endphp

<!-- Hero Section -->
<section class="hero-section">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="container position-relative" style="z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <div class="badge-status">
                    @if($isRegistrationOpen)
                        <span class="status-dot status-open"><span class="dot-inner"></span></span> Pendaftaran Dibuka
                    @else
                        <span class="status-dot status-closed"><span class="dot-inner"></span></span> Pendaftaran Tutup
                    @endif
                </div>
                <h1 class="hero-title">SELEKSI <span>PILMAPRES</span></h1>
                <h2 class="hero-subtitle">Pemilihan Mahasiswa Berprestasi</h2>
                <p class="hero-university">Universitas Muhammadiyah Metro</p>
                <p class="hero-quote">"Melahirkan mahasiswa berprestasi yang inovatif, inspiratif, dan berkontribusi untuk kemajuan bangsa."</p>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    @if($isRegistrationOpen)
                    <a href="{{ route('register') }}" class="hero-btn-white">
                        <i class="fa-solid fa-user-plus me-2"></i> Daftar Sekarang
                    </a>
                    @endif
                    <a href="{{ route('login') }}" class="hero-btn-orange">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Masuk Akun
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="d-flex flex-column ms-lg-4">

                    <a href="{{ route('informasi') }}" class="hero-card">
                        <div class="hero-card-icon">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div class="hero-card-text">
                            <h6>Persyaratan & Panduan</h6>
                            <p>Syarat pendaftaran & petunjuk teknis</p>
                        </div>
                    </a>

                    <a href="{{ route('jadwal') }}" class="hero-card">
                        <div class="hero-card-icon">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="hero-card-text">
                            <h6>Timeline Kegiatan</h6>
                            <p>Jadwal lengkap pelaksanaan seleksi</p>
                        </div>
                    </a>

                    <a href="{{ route('pengumuman') }}" class="hero-card">
                        <div class="hero-card-icon">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div class="hero-card-text">
                            <h6>Pengumuman Terbaru</h6>
                            <p>Informasi terkini seputar PILMAPRES</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Schedule Section -->
<section class="schedule-section">
    <div class="container">
    <h2 class="section-title">Jadwal Seleksi PILMAPRES</h2>

    <div class="row mt-5">
        @forelse($jadwal as $item)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="schedule-card">
                <div class="schedule-card-header">
                    <h3 class="schedule-card-title">{{ $item->kegiatan }}</h3>
                    @php
                        $now = now();
                        $start = \Carbon\Carbon::parse($item->tanggal_mulai);
                        $end = \Carbon\Carbon::parse($item->tanggal_selesai);
                        $status = 'Menunggu';
                        $color = 'blue';

                        if ($now->between($start, $end)) {
                            $status = 'Berlangsung';
                            $color = 'green';
                        } elseif ($now->gt($end)) {
                            $status = 'Selesai';
                            $color = 'gray';
                        }
                    @endphp
                    <span class="badge-time badge-{{ $color }}">{{ $status }}</span>
                </div>
                <div class="schedule-detail">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>{{ $start->format('d M') }} - {{ $end->format('d M Y') }}</span>
                </div>
                <div class="schedule-detail">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>{{ $item->keterangan ?? '-' }}</span>
                </div>
                <div class="mt-auto pt-3">
                    <a href="{{ route('jadwal') }}" class="btn-detail w-100">Lihat Detail</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5">
            <div class="mb-3">
                <i class="fa-solid fa-calendar-xmark fa-4x opacity-20"></i>
            </div>
            <p class="fs-5">Jadwal kegiatan belum tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</div>
</section>

<!-- Announcement Section -->
<section class="py-5" style="background-color: #ffffff;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3">Pengumuman Terbaru</h2>
        </div>
        <div class="row">
            @forelse($pengumuman as $item)
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; overflow: hidden; transition: 0.3s;">
                    <div class="card-body p-4" style="border-top: 6px solid #3b82f6;">
                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                <i class="fa-regular fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_publish)->format('d M Y') }}
                            </span>
                        </div>
                        <h5 class="card-title fw-bold mb-3" style="color: #1e3a8a; line-height: 1.4;">{{ $item->judul }}</h5>
                        <p class="card-text text-muted small mb-4">{{ Str::limit(strip_tags($item->konten), 100) }}</p>
                        @if($item->file_path)
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="text-primary fw-bold text-decoration-none d-flex align-items-center mb-2">
                                <i class="fa-solid fa-download me-2"></i> Unduh Lampiran
                            </a>
                        @endif
                        <a href="{{ route('pengumuman') }}" class="text-primary fw-bold text-decoration-none d-flex align-items-center">
                            Baca Selengkapnya <i class="fa-solid fa-chevron-right ms-2 fs-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5">
                <p>Belum ada pengumuman yang diterbitkan.</p>
            </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-5 pt-3">
            <a href="{{ route('pengumuman') }}" class="btn btn-outline-primary rounded-pill px-4">Lihat Semua</a>
        </div>
    </div>
</section>

<!-- Modal Cek Status -->
<div class="modal fade" id="cekStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Cek Status Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pb-5 px-4">
                <p class="text-muted small mb-4">Masukkan NPM Anda untuk melihat status verifikasi berkas dan hasil seleksi sementara.</p>
                <div class="input-group mb-4 shadow-sm" style="border-radius: 15px; overflow: hidden; border: 1px solid #e2e8f0;">
                    <input type="text" id="inputNimCek" class="form-control border-0 p-3" placeholder="Masukkan NPM Mahasiswa...">
                    <button class="btn btn-primary px-4" type="button" id="btnCekStatus">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <div id="hasilCek" class="mt-4 d-none animate__animated animate__fadeIn">
                    <div class="p-4 bg-light rounded-4">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-white shadow-sm p-3 rounded-circle me-3">
                                <i class="fa-solid fa-user-graduate text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" id="cekNama" style="color: #1e3a8a;">-</h6>
                                <small class="text-muted" id="cekProdi">-</small>
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="bg-white p-3 rounded-3 shadow-sm text-center">
                                    <small class="text-muted d-block mb-1">Status Berkas</small>
                                    <span class="badge" id="cekBerkas">-</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="bg-white p-3 rounded-3 shadow-sm text-center">
                                    <small class="text-muted d-block mb-1">Hasil Seleksi</small>
                                    <span class="badge" id="cekSeleksi">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="loadingCek" class="text-center d-none py-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-3 small text-muted">Mencari data mahasiswa...</p>
                </div>
                <div id="errorCek" class="alert alert-danger d-none border-0 rounded-4 mt-3">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> Data tidak ditemukan. Pastikan NPM sudah benar.
                </div>
            </div>
        </div>
    </div>
</div>

@section('custom-js')
<script>
    document.getElementById('btnCekStatus').addEventListener('click', function() {
        const nim = document.getElementById('inputNimCek').value;
        const hasil = document.getElementById('hasilCek');
        const loading = document.getElementById('loadingCek');
        const error = document.getElementById('errorCek');

        if (!nim) return;

        hasil.classList.add('d-none');
        error.classList.add('d-none');
        loading.classList.remove('d-none');

        fetch(`/api/cek-status/${nim}`)
            .then(response => response.json())
            .then(data => {
                loading.classList.add('d-none');
                if (data.success) {
                    document.getElementById('cekNama').innerText = data.data.nama;
                    document.getElementById('cekProdi').innerText = data.data.prodi;

                    const berkasBadge = document.getElementById('cekBerkas');
                    berkasBadge.innerText = data.data.status_berkas;
                    berkasBadge.className = 'badge ' +
                        (data.data.status_berkas === 'Lengkap' ? 'bg-success' :
                        (data.data.status_berkas === 'Belum Lengkap' ? 'bg-warning text-dark' : 'bg-secondary'));

                    const seleksiBadge = document.getElementById('cekSeleksi');
                    seleksiBadge.innerText = data.data.status_seleksi;
                    const colors = {
                        'Proses': 'bg-primary',
                        'Lolos Tahap 1': 'bg-success',
                        'Tidak Lolos': 'bg-danger',
                        'Selesai': 'bg-info'
                    };
                    seleksiBadge.className = 'badge ' + (colors[data.data.status_seleksi] || 'bg-secondary');

                    hasil.classList.remove('d-none');
                } else {
                    error.classList.remove('d-none');
                }
            })
            .catch(() => {
                loading.classList.add('d-none');
                error.classList.remove('d-none');
            });
    });
</script>
@endsection
@endsection
