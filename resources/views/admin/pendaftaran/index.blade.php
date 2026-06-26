@extends('layouts.dashboard')
@section('title', 'Pendaftaran & Berkas')

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
    .card-custom { border-radius: var(--radius); }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-file-lines text-primary me-2"></i> Pendaftaran &amp; Berkas</h4>
        <p class="text-muted small mb-0">Kelola pendaftaran dan verifikasi berkas peserta per jenjang pendidikan.</p>
    </div>
</div>

<div class="row g-4">
    <!-- FILTER SIDEBAR -->
    <div class="col-lg-4 col-xl-3">
        <div class="card filter-card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-sliders me-2 text-primary"></i>Filter</h6>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="mb-3">
                        <label class="form-label" for="tahun">Tahun Akademik</label>
                        <select name="tahun" id="tahun" class="form-select">
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
                        <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-outline-secondary w-100"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
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
            <!-- Jenjang Tabs -->
            <ul class="nav nav-pills mb-3 gap-2" role="tablist">
                @foreach($jenjangList as $j)
                @php $count = $grouped->get($j->nama_jenjang, collect())->count(); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
                <li class="nav-item" role="presentation">
                    <button class="nav-link jenjang-tab {{ $loop->first ? 'active' : '' }}"
                            id="tab-{{ $slug }}"
                            data-bs-toggle="tab"
                            data-bs-target="#panel-{{ $slug }}"
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
                     id="panel-{{ $slug }}"
                     role="tabpanel">
                    <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                            <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                                <thead>
                                    <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                        <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Mahasiswa</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NPM</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Prodi</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Tgl Daftar</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Berkas</th>
                                        <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Seleksi</th>
                                        <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $i => $p)
                                    <tr style="border-bottom:1px solid #f3f4f6">
                                        <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                        <td style="padding:0.7rem 0;font-weight:600">{{ $p->mahasiswa->user->nama_lengkap }}</td>
                                        <td style="padding:0.7rem 0"><code>{{ $p->mahasiswa->nim }}</code></td>
                                        <td style="padding:0.7rem 0;font-size:0.72rem;color:#6b7280">{{ $p->mahasiswa->parsed_prodi }}</td>
                                        <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                                        <td style="padding:0.7rem 0">
                                            @if(!$p->is_submitted)
                                                <span class="badge bg-secondary badge-custom">Draft</span>
                                            @else
                                                <span class="badge badge-custom {{ $p->status_berkas === 'Lengkap' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    {{ $p->status_berkas }}
                                                </span>
                                            @endif
                                        </td>
                                        <td style="padding:0.7rem 0">
                                            @php $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                                            <span class="badge badge-custom bg-{{ $colors[$p->status_seleksi] ?? 'secondary' }}">{{ $p->status_seleksi }}</span>
                                        </td>
                                        <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                            <a href="{{ route('admin.pendaftaran.show', $p) }}" class="btn btn-outline-primary table-action-btn" style="font-size:0.7rem;padding:0.2rem 0.5rem;line-height:1.3">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" style="padding:2rem;text-align:center;color:#9ca3af">
                                            <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada pendaftaran {{ $j->nama_jenjang }}.
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
@endsection