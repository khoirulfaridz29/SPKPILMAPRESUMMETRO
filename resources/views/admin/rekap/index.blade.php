@extends('layouts.dashboard')
@section('title', 'Rekap Tahap I')

@section('content')
<style>
    .filter-card .form-label { font-size: .75rem; font-weight: 600; margin-bottom: .25rem; color: var(--text-muted); }
    .filter-card .btn { border-radius: var(--radius); padding: .5rem 1rem; }
    .filter-card select, .filter-card input { border-radius: var(--radius); padding: .5rem .75rem; }
    .jenjang-tab { border-radius: var(--radius); padding: .45rem 1.2rem; font-size: .875rem; font-weight: 600; transition: all .2s; }
    .jenjang-tab:not(.active) { background: var(--bg-body); color: var(--text-body); border: 1px solid var(--border-color); }
    .jenjang-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .jenjang-tab .badge { font-size: .7rem; border-radius: var(--radius); }
    .table-action-btn { border-radius: var(--radius); padding: .25rem .85rem; font-size: .8rem; }
    .badge-custom { border-radius: var(--radius); }
    .btn-custom { border-radius: var(--radius); }

    /* Print Styling */
    @media print {
        body { background: #ffffff !important; color: #000000 !important; font-family: "Times New Roman", Times, serif; font-size: 12pt; padding: 0; margin: 1.5cm; }
        .sidebar, .navbar, .btn, .no-print, .breadcrumb, footer, form { display: none !important; }
        .main-content, .container-fluid, .card, .card-body { border: none !important; box-shadow: none !important; background: transparent !important; padding: 0 !important; margin: 0 !important; width: 100% !important; }
        .excel-table { width: 100% !important; border-collapse: collapse !important; margin-top: 15px; }
        .excel-table th, .excel-table td { border: 1px solid #000000 !important; padding: 8px !important; font-size: 11pt !important; color: #000000 !important; }
        .excel-table th { background-color: #f2f2f2 !important; font-weight: bold !important; text-transform: uppercase; }
        .print-header { display: block !important; }
        .print-title { display: block !important; text-align: center; font-weight: bold; text-transform: uppercase; font-size: 14pt; margin: 20px 0 10px 0; text-decoration: underline; }
        .print-signature { display: block !important; margin-top: 40px; float: right; text-align: center; width: 250px; font-size: 11pt; }
    }
</style>

<!-- KOP Surat Resmi UM Metro (Hanya Muncul saat Cetak / Print) -->
<div class="print-header d-none d-print-block" style="margin-bottom: 14px;">
    <img src="{{ asset('assets/kop-ummetro.png') }}" alt="KOP UM Metro" style="width:100%;height:auto;display:block;">
    <div style="border-top: 3px solid #000000; border-bottom: 1px solid #000000; height: 1px; margin-top: 2px;"></div>
</div>

<div class="print-title d-none d-print-block">
    REKAPITULASI BERKAS PENDAFTARAN MAHASISWA BERPRESTASI (TAHAP I)
</div>

<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-folder-open text-primary me-2"></i> Rekap Berkas Tahap I</h4>
        <p class="text-muted small mb-0">Kelola status kelulusan berkas administrasi awal per jenjang pendidikan.</p>
    </div>
        <div class="d-flex gap-2 align-items-start flex-wrap">
            <button onclick="window.print()" class="btn btn-outline-dark px-4 btn-custom fw-semibold">
                <i class="fa-solid fa-print me-2"></i> Cetak
            </button>
            @if($semuaTervalidasi)
                <a href="{{ route('admin.rekap.penugasan') }}" class="btn btn-primary px-4 btn-custom fw-semibold">
                    <i class="fa-solid fa-gavel me-2"></i> Penugasan Juri
                </a>
            @else
                <div>
                    <button type="button" class="btn btn-secondary px-4 btn-custom fw-semibold"
                        onclick="alert('Seleksi Tahap 1 Belum di Validasi oleh Wakil Rektor III')">
                        <i class="fa-solid fa-gavel me-2"></i> Penugasan Juri
                    </button>
                    <div class="text-danger small mt-1">
                        <i class="fa-solid fa-info-circle me-1"></i> Seleksi Tahap 1 Belum di Validasi oleh Wakil Rektor III
                    </div>
                </div>
            @endif
        </div>
</div>

<div class="row g-4 no-print">
    <!-- FILTER SIDEBAR -->
    <div class="col-lg-4 col-xl-3">
        <div class="card filter-card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-sliders me-2 text-primary"></i>Filter</h6>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="mb-3">
                        <label class="form-label">Tahun Akademik</label>
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}/{{ $y + 1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Terapkan</button>
                        <a href="{{ route('admin.rekap.index') }}" class="btn btn-outline-secondary w-100"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="col-lg-8 col-xl-9">
        @if($jenjangList->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <i class="fa-solid fa-graduation-cap fa-3x mb-3 d-block text-secondary"></i>
                    <p class="mb-0">Belum ada jenjang pendidikan.</p>
                </div>
            </div>
        @else
            <ul class="nav nav-pills mb-3 gap-2" role="tablist">
                @foreach($jenjangList as $j)
                @php $count = $grouped->get($j->nama_jenjang, collect())->count(); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
                <li class="nav-item" role="presentation">
                    <button class="nav-link jenjang-tab {{ $loop->first ? 'active' : '' }}"
                            id="rekap-tab-{{ $slug }}"
                            data-bs-toggle="tab"
                            data-bs-target="#rekap-panel-{{ $slug }}"
                            type="button" role="tab">
                        <i class="fa-solid fa-graduation-cap me-1"></i> {{ $j->nama_jenjang }}
                        <span class="badge bg-light text-dark ms-1">{{ $count }}</span>
                    </button>
                </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach($jenjangList as $j)
                @php $items = $grouped->get($j->nama_jenjang, collect()); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                     id="rekap-panel-{{ $slug }}"
                     role="tabpanel">
                    <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                                    <thead>
                                        <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                            <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">No</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Mahasiswa</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NPM</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Prodi</th>
                                            <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Laporan</th>
                                            <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Seleksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($items as $i => $r)
                                        <tr style="border-bottom:1px solid #f3f4f6">
                                            <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                            <td style="padding:0.7rem 0;font-weight:600">{{ $r->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                            <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $r->pendaftaran->mahasiswa->nim }}</td>
                                            <td style="padding:0.7rem 0;color:#6b7280;font-size:0.75rem">{{ $r->pendaftaran->mahasiswa->parsed_prodi }}</td>
                                            <td style="padding:0.7rem 0;text-align:center">
                                                @if($r->status_laporan === 'Divalidasi')
                                                    <span style="background:#e6f7ee;color:#10b981;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Divalidasi</span>
                                                @else
                                                    <span style="background:#f3f4f6;color:#6b7280;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $r->status_laporan }}</span>
                                                @endif
                                            </td>
                                            <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                                @php
                                                    $selStyle = ['Proses'=>'background:#e0f2fe;color:#0ea5e9','Lolos Tahap 1'=>'background:#e6f7ee;color:#10b981','Tidak Lolos'=>'background:#fee2e2;color:#ef4444','Selesai'=>'background:#e0f2fe;color:#0ea5e9'];
                                                @endphp
                                                <span style="{{ $selStyle[$r->pendaftaran->status_seleksi] ?? 'background:#f3f4f6;color:#6b7280' }};border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">
                                                    {{ $r->pendaftaran->status_seleksi }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="padding:2rem;text-align:center;color:#9ca3af">
                                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                                Belum ada peserta {{ $j->nama_jenjang }}. Verifikasi dulu berkas di menu Pendaftaran.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Print: fallback single-table view -->
<div class="d-none d-print-block">
    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); @endphp
    @if($items->isNotEmpty())
    <h5 class="fw-bold mt-4 mb-2">{{ $j->nama_jenjang }}</h5>
    <table class="table excel-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NPM</th>
                <th>Status Laporan</th>
                <th>Status Seleksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $r)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $r->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                <td>{{ $r->pendaftaran->mahasiswa->nim }}</td>
                <td>{{ $r->status_laporan }}</td>
                <td>{{ $r->pendaftaran->status_seleksi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @endforeach
</div>

<div class="print-signature d-none d-print-block">
    <p style="margin-bottom: 60px;">
        Metro, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
        <strong>Wakil Rektor III</strong>
    </p>
    <p style="text-decoration: underline; font-weight: bold; margin-bottom: 0;">
        Bapak Wakil Rektor III
    </p>
    <p style="margin-top: 0; font-size: 10pt; color: #333;">NIDN. / NIP.</p>
</div>
@endsection