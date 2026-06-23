@extends('layouts.frontend')

@section('custom-css')
<style>
    .page-header {
        background-color: var(--primary) !important;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
        position: relative;
        overflow: hidden;
    }
    .page-header::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        pointer-events: none;
    }
    .page-header .blob {
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        filter: blur(80px);
        border-radius: 50%;
        z-index: 0;
    }
    .page-header .blob-1 { top: -100px; right: -100px; background: rgba(255, 170, 0, 0.15); }
    .page-header .blob-2 { bottom: -150px; left: -100px; }
    .page-header .container {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .announcement-card {
        border-radius: var(--radius);
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }
    .announcement-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .date-badge {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 10px;
        border-radius: var(--radius);
        text-align: center;
        min-width: 80px;
    }
    .date-badge .day {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        line-height: 1;
    }
    .date-badge .month {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold">Pengumuman</h1>
        <p class="lead">Pusat informasi terbaru seputar seleksi PILMAPRES</p>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-9 mx-auto">

            @forelse($pengumuman as $item)
            @php
                $date = \Carbon\Carbon::parse($item->tanggal_publish);
            @endphp
            <div class="card announcement-card p-3 p-md-4">
                <div class="d-flex align-items-start">
                    <div class="date-badge me-4 d-none d-md-block">
                        <div class="day">{{ $date->format('d') }}</div>
                        <div class="month">{{ $date->format('M Y') }}</div>
                    </div>
                    <div>
                        <span class="badge bg-primary mb-2">Informasi Terbaru</span>
                        <h4 class="fw-bold mb-2">{{ $item->judul }}</h4>
                        <div class="text-muted small mb-3 d-md-none"><i class="fa-regular fa-calendar me-1"></i> {{ $date->format('d M Y') }}</div>
                        <div class="text-muted mb-3">
                            {{ strip_tags($item->konten) }}
                        </div>
                        @if($item->file_path)
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-download me-1"></i> Unduh Lampiran
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="text-center py-5 mt-4 text-muted">
                <i class="fa-regular fa-folder-open fa-4x mb-3 opacity-50"></i>
                <h5>Belum Ada Pengumuman</h5>
                <p>Informasi terbaru seputar seleksi akan dipublikasikan di halaman ini.</p>
            </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
