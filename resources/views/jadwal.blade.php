@extends('layouts.frontend')

@section('custom-css')
<style>
    .page-header {
        background-color: #1e40af !important;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
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

    .timeline {
        position: relative;
        padding-left: 30px;
        margin-top: 40px;
    }
    .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -35px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #3b82f6;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #bfdbfe;
    }
    .timeline-item.completed::before {
        background-color: #10b981;
        box-shadow: 0 0 0 2px #a7f3d0;
    }
    .timeline-date {
        font-weight: 700;
        color: #3b82f6;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .timeline-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }
    .timeline-title {
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="container">
        <h1 class="fw-bold">Jadwal Seleksi PILMAPRES</h1>
        <p class="lead">Timeline pelaksanaan pendaftaran dan seleksi PILMAPRES Tingkat Universitas</p>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="timeline">
                @forelse($jadwal as $item)
                @php
                    $now = now();
                    $start = \Carbon\Carbon::parse($item->tanggal_mulai);
                    $end = \Carbon\Carbon::parse($item->tanggal_selesai);
                    $isCompleted = $now->gt($end);
                    $isCurrent = $now->between($start, $end);
                @endphp
                <div class="timeline-item {{ $isCompleted ? 'completed' : '' }}">
                    <div class="timeline-date">
                        <i class="fa-regular {{ $isCompleted ? 'fa-calendar-check' : ($isCurrent ? 'fa-calendar-days' : 'fa-calendar') }} me-1"></i>
                        {{ $start->format('d M') }} - {{ $end->format('d M Y') }}
                    </div>
                    <div class="timeline-content {{ $isCurrent ? 'border-primary border-start border-4' : '' }}">
                        @if($isCurrent)
                            <div class="float-end badge bg-primary">Sedang Berjalan</div>
                        @elseif($isCompleted)
                            <div class="float-end badge bg-success">Selesai</div>
                        @endif
                        <h4 class="timeline-title">{{ $item->kegiatan }}</h4>
                        <p class="text-muted mb-0">{{ $item->keterangan ?? '-' }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <p class="text-muted">Jadwal belum diatur.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
