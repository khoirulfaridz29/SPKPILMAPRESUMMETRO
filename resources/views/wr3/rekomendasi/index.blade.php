@extends('layouts.dashboard')
@section('title', 'Rekomendasi Mahasiswa Berprestasi')

@section('content')
<style>
    .jenjang-tab { border-radius: var(--radius); padding: .45rem 1.2rem; font-size: .875rem; font-weight: 600; transition: all .2s; }
    .jenjang-tab:not(.active) { background: var(--bg-body); color: var(--text-body); border: 1px solid var(--border-color); }
    .jenjang-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .jenjang-tab .badge { font-size: .7rem; border-radius: var(--radius); }

    @media print {
        @page { margin: 1.5cm 1.5cm 2cm 1.5cm; }
        body { background: #fff !important; color: #000 !important; font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1; padding: 0; margin: 0; }
        .sidebar, .navbar, .btn, .no-print, .breadcrumb, footer, form, header, .nav-header { display: none !important; }
        .main-content, .container-fluid, .card, .card-body { border: none !important; box-shadow: none !important; background: transparent !important; padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        .print-header { display: block !important; margin-bottom: 18px; }
        .print-header img { width: 100%; height: auto; display: block; }
        .print-body { display: block !important; }
        .print-body table { width: 100%; border-collapse: collapse; margin: 10px 0; font-size: 10pt; }
        .print-body table th, .print-body table td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        .print-body table th { background: #f2f2f2; font-weight: bold; text-align: center; }
        .print-body table td { vertical-align: middle; }
        .print-body .jenjang-section { page-break-inside: avoid; margin-top: 16px; }
        .print-title { display: block !important; text-align: center; font-weight: bold; font-size: 12pt; margin: 0 0 4px 0; line-height: 1.4; }
        .print-subtitle { display: block !important; text-align: center; font-weight: bold; font-size: 12pt; margin: 0 0 2px 0; }
        .print-signature { display: block !important; margin-top: 40px; float: right; text-align: center; width: 260px; font-size: 11pt; }
        .print-signature p { margin: 4px 0; }
        .print-footer { display: none !important; }
        header, footer, #header, #footer, .header, .footer { display: none !important; }
    }
</style>

<!-- KOP -->
<div class="print-header d-none d-print-block" style="margin-bottom: 18px;">
    <img src="{{ asset('assets/kop-ummetro.png') }}" alt="KOP UM Metro" style="width:100%;height:auto;display:block;">
</div>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-ranking-star text-warning me-2"></i> Rekomendasi Mahasiswa Berprestasi</h4>
        <p class="text-muted small mb-0">Halaman ini digunakan oleh Wakil Rektor III untuk meninjau dan menetapkan juara hasil perhitungan SPK.</p>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-dark px-3 rounded-pill">
            <i class="fa-solid fa-print me-2"></i> Cetak
        </button>
        @if($hasilAll->isNotEmpty() && $hasilAll->where('validasi_wr3','Pending')->isNotEmpty())
        <form action="{{ route('wr3.rekomendasi.validasi') }}" method="POST"
            onsubmit="return confirm('Validasi dan tetapkan semua hasil juara?')" class="mb-0">
            @csrf
            <button type="submit" class="btn btn-success px-3 rounded-pill fw-semibold">
                <i class="fa-solid fa-stamp me-2"></i> Validasi & Tetapkan Juara
            </button>
        </form>
        @endif
    </div>
</div>

@if($grouped->isEmpty())
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body text-center py-5 text-muted no-print">
        <i class="fa-solid fa-calculator fa-3x mb-3 d-block text-secondary"></i>
        <p class="mb-0">Hasil belum tersedia. Admin harus melakukan perhitungan GAP terlebih dahulu.</p>
    </div>
</div>
@else

@php $firstWithData = $jenjangList->first(fn($j) => $grouped->get($j->nama_jenjang, collect())->isNotEmpty()); @endphp

<ul class="nav nav-pills mb-3 gap-2 no-print" role="tablist">
    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
    @if($items->isNotEmpty())
    <li class="nav-item" role="presentation">
        <button class="nav-link jenjang-tab {{ $firstWithData && $j->id === $firstWithData->id ? 'active' : '' }}"
                id="rek-tab-{{ $slug }}"
                data-bs-toggle="tab"
                data-bs-target="#rek-panel-{{ $slug }}"
                type="button" role="tab">
            <i class="fa-solid fa-graduation-cap me-1"></i> {{ $j->nama_jenjang }}
            <span class="badge bg-light text-dark ms-1">{{ $items->count() }}</span>
        </button>
    </li>
    @endif
    @endforeach
</ul>

<div class="tab-content no-print">
    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
    @if($items->isNotEmpty())
    <div class="tab-pane fade {{ $firstWithData && $j->id === $firstWithData->id ? 'show active' : '' }}"
         id="rek-panel-{{ $slug }}"
         role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                <th style="padding:0.6rem 0 0.6rem 1rem;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Ranking</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Peserta</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NPM</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Program Studi</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nilai Total (SPK)</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Juara</th>
                                <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Validasi WR3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $h)
                            <tr style="border-bottom:1px solid #f3f4f6;{{ $h->ranking <= 3 ? 'background:#fffbeb' : '' }}">
                                <td style="padding:0.7rem 0 0.7rem 1rem;text-align:center;font-weight:700">
                                    @if($h->ranking == 1) <span style="background:#fef3c7;color:#d97706;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.75rem">🥇 1</span>
                                    @elseif($h->ranking == 2) <span style="background:#f3f4f6;color:#6b7280;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.75rem">🥈 2</span>
                                    @elseif($h->ranking == 3) <span style="background:#fde8d8;color:#cd7f32;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.75rem">🥉 3</span>
                                    @else <span style="color:#9ca3af;font-size:0.82rem">{{ $h->ranking }}</span>
                                    @endif
                                </td>
                                <td style="padding:0.7rem 0;font-weight:600">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $h->pendaftaran->mahasiswa->nim }}</td>
                                <td style="padding:0.7rem 0;color:#6b7280;font-size:0.75rem">{{ $h->pendaftaran->mahasiswa->program_studi }}</td>
                                <td style="padding:0.7rem 0;text-align:center;font-weight:700;color:#2563eb">{{ number_format($h->nilai_total, 4) }}</td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    @php
                                        $jStyle = [
                                            'Juara 1' => 'background:#fef3c7;color:#d97706',
                                            'Juara 2' => 'background:#f3f4f6;color:#6b7280',
                                            'Juara 3' => 'background:#fde8d8;color:#cd7f32',
                                            'Tidak Juara' => 'background:#f3f4f6;color:#9ca3af',
                                        ];
                                    @endphp
                                    <span style="{{ $jStyle[$h->status_juara] ?? 'background:#f3f4f6;color:#6b7280' }};border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $h->status_juara }}</span>
                                </td>
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    @if($h->validasi_wr3 === 'Divalidasi')
                                        <span style="background:#e6f7ee;color:#10b981;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Divalidasi</span>
                                    @else
                                        <span style="background:#fee2e2;color:#ef4444;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $h->validasi_wr3 }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

{{-- Print Body --}}
<div class="print-body d-none d-print-block">
    <div class="print-title">HASIL REKOMENDASI PEMILIHAN MAHASISWA BERPRESTASI (PILMAPRES)</div>
    <div class="print-subtitle">UNIVERSITAS MUHAMMADIYAH METRO</div>
    <div class="print-subtitle" style="margin-bottom:12px;">TAHUN 2026</div>

    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); @endphp
    @if($items->isNotEmpty())
    <div class="jenjang-section">
        <div style="font-weight:bold;font-size:11pt;margin:14px 0 4px 0;text-transform:uppercase;">PROGRAM {{ $j->nama_jenjang }}</div>
        <table>
            <thead>
                <tr>
                    <th style="width:40px;text-align:center">NO</th>
                    <th>NAMA</th>
                    <th>NPM</th>
                    <th>PROGRAM STUDI</th>
                    <th style="width:90px;text-align:center">NILAI TOTAL</th>
                    <th style="width:80px;text-align:center">JUARA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $h)
                <tr>
                    <td style="text-align:center">{{ $i + 1 }}</td>
                    <td>{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    <td>{{ $h->pendaftaran->mahasiswa->nim }}</td>
                    <td>{{ $h->pendaftaran->mahasiswa->program_studi }}</td>
                    <td style="text-align:center">{{ number_format($h->nilai_total, 4) }}</td>
                    <td style="text-align:center">{{ $h->status_juara }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    @endforeach

    <div class="print-signature">
        <p>Metro, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p style="font-weight:bold;text-transform:uppercase;">Wakil Rektor III</p>
        <p style="font-weight:bold;text-transform:uppercase;">Bidang Kemahasiswaan</p>
        <p style="font-weight:bold;text-transform:uppercase;">UM Metro</p>
        <br><br><br><br><br>
        <p style="text-decoration:underline;font-weight:bold;margin-bottom:2px;">
            {{ $wr3User ? $wr3User->nama_lengkap : '______________________' }}
        </p>
        <p>{{ $wr3User && $wr3User->nidn ? $wr3User->nidn : 'NIDN. ______________________' }}</p>
    </div>
</div>
@endif
@endsection