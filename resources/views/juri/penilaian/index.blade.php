@extends('layouts.dashboard')
@section('title', 'Penilaian Peserta')

@section('content')
<style>
    .jenjang-tab { border-radius: var(--radius); padding: .45rem 1.2rem; font-size: .875rem; font-weight: 600; transition: all .2s; }
    .jenjang-tab:not(.active) { background: var(--bg-body); color: var(--text-body); border: 1px solid var(--border-color); }
    .jenjang-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .jenjang-tab .badge { font-size: .7rem; border-radius: var(--radius); }
</style>

<div class="d-flex align-items-center justify-content-between mb-4">
    <h4 class="fw-bold mb-0">Daftar Peserta yang Ditugaskan</h4>
    <span class="badge fs-6" style="background:var(--primary-light);color:white;border-radius:var(--radius-sm);padding:0.4rem 0.9rem">
        {{ $penugasans->count() }} Peserta
    </span>
</div>

@if($grouped->isEmpty())
<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body text-center py-5 text-muted">
        <i class="fa-solid fa-clipboard-list fa-3x mb-3 d-block text-secondary"></i>
        <p class="mb-0">Anda belum ditugaskan untuk menilai peserta.</p>
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
                id="pen-tab-{{ $slug }}"
                data-bs-toggle="tab"
                data-bs-target="#pen-panel-{{ $slug }}"
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
         id="pen-panel-{{ $slug }}"
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
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Program Studi</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Penilaian</th>
                                <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $i => $pg)
                            @php
                                $jmlPenilaian = $sudahDinilai[$pg->pendaftaran_id] ?? 0;
                                $totalKriteria = $kriteriaPerJenjang[$pg->pendaftaran->mahasiswa->jenjang_id] ?? 0;
                                $selesai = $jmlPenilaian >= $totalKriteria && $totalKriteria > 0;
                            @endphp
                            <tr style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                <td style="padding:0.7rem 0;font-weight:600">{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $pg->pendaftaran->mahasiswa->nim }}</td>
                                <td style="padding:0.7rem 0;color:#6b7280;font-size:0.75rem">{{ $pg->pendaftaran->mahasiswa->program_studi }}</td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    @if($selesai)
                                        <span class="badge" style="background:#e6f7ee;color:#10b981;font-weight:600;border:none;border-radius:var(--radius-sm)">Sudah Dinilai</span>
                                    @elseif($jmlPenilaian > 0)
                                        <span class="badge" style="background:#fef3c7;color:#f59e0b;font-weight:600;border:none;border-radius:var(--radius-sm)">{{ $jmlPenilaian }}/{{ $totalKriteria }}</span>
                                    @else
                                        <span class="badge" style="background:#fee2e2;color:#ef4444;font-weight:600;border:none;border-radius:var(--radius-sm)">Belum Dinilai</span>
                                    @endif
                                </td>
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    <a href="{{ route('juri.penilaian.show', $pg->pendaftaran_id) }}" style="background:var(--primary-light);color:white;border-radius:var(--radius-sm);padding:0.25rem 0.7rem;font-size:0.72rem;text-decoration:none;display:inline-block">
                                        Nilai
                                    </a>
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
