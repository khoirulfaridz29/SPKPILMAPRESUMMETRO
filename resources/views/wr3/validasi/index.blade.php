@extends('layouts.dashboard')
@section('title', 'Validasi Laporan Tahap I')

@section('content')
<style>
    .jenjang-tab { border-radius: var(--radius); padding: .45rem 1.2rem; font-size: .875rem; font-weight: 600; transition: all .2s; }
    .jenjang-tab:not(.active) { background: var(--bg-body); color: var(--text-body); border: 1px solid var(--border-color); }
    .jenjang-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .jenjang-tab .badge { font-size: .7rem; border-radius: var(--radius); }
</style>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Validasi Laporan Rekap Berkas (Tahap I)</h4>
</div>

@if($grouped->isEmpty())
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body text-center py-5 text-muted">
        <i class="fa-solid fa-inbox fa-3x mb-3 d-block text-secondary"></i>
        <p class="mb-0">Belum ada rekap untuk divalidasi.</p>
    </div>
</div>
@else

@php $firstWithData = $jenjangList->first(fn($j) => $grouped->get($j->nama_jenjang, collect())->isNotEmpty()); @endphp

<ul class="nav nav-pills mb-3 gap-2" role="tablist">
    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
    @if($items->isNotEmpty())
    <li class="nav-item" role="presentation">
        <button class="nav-link jenjang-tab {{ $firstWithData && $j->id === $firstWithData->id ? 'active' : '' }}"
                id="val-tab-{{ $slug }}"
                data-bs-toggle="tab"
                data-bs-target="#val-panel-{{ $slug }}"
                type="button" role="tab">
            <i class="fa-solid fa-graduation-cap me-1"></i> {{ $j->nama_jenjang }}
            <span class="badge bg-light text-dark ms-1">{{ $items->count() }}</span>
        </button>
    </li>
    @endif
    @endforeach
</ul>

<div class="tab-content">
    @foreach($jenjangList as $j)
    @php $items = $grouped->get($j->nama_jenjang, collect()); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
    @if($items->isNotEmpty())
    <div class="tab-pane fade {{ $firstWithData && $j->id === $firstWithData->id ? 'show active' : '' }}"
         id="val-panel-{{ $slug }}"
         role="tabpanel">
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Peserta</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NPM</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Jumlah Berkas</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Laporan</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Tgl Validasi</th>
                                <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $i => $r)
                            <tr style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                <td style="padding:0.7rem 0;font-weight:600">{{ $r->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $r->pendaftaran->mahasiswa->nim }}</td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    <span class="badge" style="background:#e0f2fe;color:#0ea5e9;font-weight:600;border:none;border-radius:var(--radius-sm)">{{ $r->pendaftaran->berkas->count() }} berkas</span>
                                </td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    @if($r->status_laporan === 'Divalidasi')
                                        <span class="badge" style="background:#e6f7ee;color:#10b981;font-weight:600;border:none;border-radius:var(--radius-sm)">Divalidasi</span>
                                    @else
                                        <span class="badge" style="background:#f3f4f6;color:#6b7280;font-weight:600;border:none;border-radius:var(--radius-sm)">{{ $r->status_laporan }}</span>
                                    @endif
                                </td>
                                <td style="padding:0.7rem 0;text-align:center;color:#6b7280;font-size:0.72rem">
                                    {{ $r->tanggal_validasi ? \Carbon\Carbon::parse($r->tanggal_validasi)->format('d M Y H:i') : '-' }}
                                </td>
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    @if($r->status_laporan === 'Pending')
                                    <form action="{{ route('wr3.validasi.approve', $r) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Validasi laporan ini?')">
                                        @csrf
                                        <button style="background:#e6f7ee;color:#10b981;border:1px solid #10b981;border-radius:var(--radius-sm);padding:0.25rem 0.7rem;font-size:0.72rem;cursor:pointer">
                                            <i class="fa-solid fa-check me-1"></i> Validasi
                                        </button>
                                    </form>
                                    @else
                                    <span style="color:#10b981;font-size:0.75rem"><i class="fa-solid fa-check-circle"></i> Sudah Divalidasi</span>
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
@endif
@endsection
