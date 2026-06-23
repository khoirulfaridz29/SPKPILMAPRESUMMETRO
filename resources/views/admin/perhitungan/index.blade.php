@extends('layouts.dashboard')
@section('title', 'Perhitungan GAP')

@section('content')
<style>
    .filter-card .form-label { font-size: .75rem; font-weight: 600; margin-bottom: .25rem; color: var(--text-muted); }
    .filter-card .btn { border-radius: var(--radius); padding: .5rem 1rem; }
    .filter-card select, .filter-card input { border-radius: var(--radius); padding: .5rem .75rem; }
    .jenjang-tab { border-radius: var(--radius); padding: .45rem 1.2rem; font-size: .875rem; font-weight: 600; transition: all .2s; }
    .jenjang-tab:not(.active) { background: var(--bg-body); color: var(--text-body); border: 1px solid var(--border-color); }
    .jenjang-tab.active { background: var(--primary); color: #fff; border-color: var(--primary); }
    .jenjang-tab .badge { font-size: .7rem; border-radius: var(--radius); }
    .badge-custom { border-radius: var(--radius); }
    .btn-custom { border-radius: var(--radius); }
    .detail-card { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: var(--radius-sm); }
</style>

@php $firstJenjang = $jenjangList->first(); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-calculator text-primary me-2"></i> Perhitungan GAP & Rangking</h4>
        <p class="text-muted small mb-0">Hasil perhitungan per jenjang dan detail analisis profile matching.</p>
    </div>
</div>

<div class="row g-4">
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
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}/{{ $y + 1 }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Terapkan</button>
                        <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-outline-secondary w-100"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-xl-9">
        @if($jenjangList->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <i class="fa-solid fa-graduation-cap fa-3x mb-3 d-block text-secondary"></i>
                    <p class="mb-0">Belum ada jenjang pendidikan.</p>
                </div>
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <ul class="nav nav-pills gap-2 mb-0" role="tablist">
                    @foreach($jenjangList as $j)
                    @php $count = $grouped->get($j->nama_jenjang, collect())->count(); $slug = \Illuminate\Support\Str::slug($j->nama_jenjang); @endphp
                    <li class="nav-item" role="presentation">
                        <button class="nav-link jenjang-tab {{ $loop->first ? 'active' : '' }}"
                                id="gap-tab-{{ $slug }}"
                                data-bs-toggle="tab"
                                data-bs-target="#gap-panel-{{ $slug }}"
                                type="button" role="tab">
                            <i class="fa-solid fa-graduation-cap me-1"></i> {{ $j->nama_jenjang }}
                            <span class="badge bg-light text-dark ms-1">{{ $count }}</span>
                        </button>
                    </li>
                    @endforeach
                </ul>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.perhitungan.proses') }}" method="POST"
                        onsubmit="return confirm('Proses perhitungan GAP untuk jenjang ini?')">
                        @csrf
                        <input type="hidden" name="jenjang_id" id="proses_jenjang_id" value="{{ $firstJenjang->id ?? '' }}">
                        <button type="submit" class="btn btn-success btn-custom px-3 fw-semibold btn-sm">
                            <i class="fa-solid fa-calculator me-1"></i> Hitung
                        </button>
                    </form>
                    <form action="{{ route('admin.perhitungan.reset') }}" method="POST"
                        onsubmit="return confirm('Kosongkan semua riwayat perhitungan? Data nilai juri tidak akan terhapus.')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-custom px-3 fw-semibold btn-sm">
                            <i class="fa-solid fa-rotate me-1"></i> Reset
                        </button>
                    </form>
                    <a href="{{ route('admin.perhitungan.export') }}" class="btn btn-outline-dark btn-custom px-3 fw-semibold btn-sm" id="btnExportPerhitungan">
                        <i class="fa-solid fa-file-excel me-1"></i> Export
                    </a>
                </div>
            </div>

            <div class="tab-content">
                @foreach($jenjangList as $j)
                @php
                    $slug = \Illuminate\Support\Str::slug($j->nama_jenjang);
                    $hasilItems = $hasilGrouped->get($j->nama_jenjang, collect());
                    $pesertaItems = $grouped->get($j->nama_jenjang, collect());
                @endphp
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                     id="gap-panel-{{ $slug }}"
                     role="tabpanel">

                    @if($hasilItems->isNotEmpty())
                        {{-- RANKING TABLE --}}
                        <div class="card border-0 shadow-sm mb-3" style="border-radius:var(--radius)">
                            <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0 d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-trophy text-warning me-1"></i> Hasil Perangkingan {{ $j->nama_jenjang }}</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                                    <thead>
                                        <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                            <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Rank</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Nama Peserta</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">NPM</th>
                                            <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Nilai Akhir</th>
                                            <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Status</th>
                                            <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hasilItems as $h)
                                        @php $warnaRank = $h->ranking <= 3 ? ['#fef3c7','#d97706'] : ['#f9fafb','#6b7280']; @endphp
                                        <tr style="border-bottom:1px solid #f3f4f6;background:{{ $warnaRank[0] }}">
                                            <td style="padding:0.7rem 0 0.7rem 1rem;text-align:center;font-weight:800;color:{{ $warnaRank[1] }};font-size:0.85rem">
                                                @if($h->ranking == 1) <i class="fa-solid fa-crown text-warning me-1"></i> @endif
                                                {{ $h->ranking }}
                                            </td>
                                            <td style="padding:0.7rem 0;font-weight:600">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                            <td style="padding:0.7rem 0;color:#6b7280;font-size:0.75rem"><code>{{ $h->pendaftaran->mahasiswa->nim }}</code></td>
                                            <td style="padding:0.7rem 0;text-align:center;font-weight:700">{{ number_format($h->nilai_total, 4) }}</td>
                                            <td style="padding:0.7rem 0;text-align:center">
                                                @php
                                                    $juaraStyle = ['Juara 1'=>'background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff','Juara 2'=>'background:linear-gradient(135deg,#9ca3af,#6b7280);color:#fff','Juara 3'=>'background:linear-gradient(135deg,#d97706,#92400e);color:#fff','Tidak Juara'=>'background:#f3f4f6;color:#9ca3af'];
                                                @endphp
                                                <span style="{{ $juaraStyle[$h->status_juara] ?? 'background:#f3f4f6;color:#6b7280' }};border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.7rem;font-weight:700">
                                                    {{ $h->status_juara }}
                                                </span>
                                            </td>
                                            <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                                <button type="button" class="btn btn-sm btn-outline-info table-action-btn btn-toggle-detail"
                                                    data-target="detail-{{ $h->id }}">
                                                    <i class="fa-solid fa-chart-simple me-1"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <tr id="detail-{{ $h->id }}" style="display:none">
                                            <td colspan="6" style="padding:0;border-bottom:1px solid #f3f4f6">
                                                <div class="detail-card p-3" style="margin:0.5rem">
                                                    @php
                                                        $m = $h->pendaftaran->mahasiswa;
                                                        $penilaians = $h->pendaftaran->penilaian;
                                                        $kriteriasJenjang = $kriterias->where('jenjang_id', $m->jenjang_id);
                                                        if ($kriteriasJenjang->isEmpty()) $kriteriasJenjang = $kriterias->where('jenjang_id', 1);
                                                        $getAvg = function($kode) use ($penilaians, $kriterias) {
                                                            $kId = ($kriterias->where('kode_kriteria', $kode)->first())->id ?? 0;
                                                            $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                                            return $scores->count() > 0 ? $scores->avg() : 0;
                                                        };
                                                        $bobotMap = $bobotPerJenjang[$m->jenjang_id ?? 1] ?? [];
                                                    @endphp
                                                    <div class="table-responsive">
                                                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.78rem">
                                                        <thead>
                                                            <tr style="border-bottom:2px solid #e5e7eb">
                                                                <th style="padding:0.35rem 0;font-weight:700;color:#374151">Kriteria</th>
                                                                <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">Rata-rata</th>
                                                                <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">Bobot</th>
                                                                <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">Skala 1-10</th>
                                                                <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">Target</th>
                                                                <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">GAP</th>
                                                                <th style="padding:0.35rem 0.5rem 0.35rem 0;text-align:center;font-weight:700;color:#374151">Bobot GAP</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($kriteriasJenjang as $k)
                                                            @php
                                                                $avg = $getAvg($k->kode_kriteria);
                                                                $weighted = $avg * ($k->bobot / 100.0);
                                                                $actual = \App\Http\Controllers\Admin\PerhitunganController::convertToScale10Static($weighted);
                                                                $target = $k->nilai_target;
                                                                $gap = $actual - $target;
                                                                $bobotGap = \App\Http\Controllers\Admin\PerhitunganController::getGapWeightStatic($gap);
                                                            @endphp
                                                            <tr style="border-bottom:1px solid #f3f4f6">
                                                                <td style="padding:0.35rem 0;font-weight:600">{{ $k->kode_kriteria }} ({{ $k->nama_kriteria }})</td>
                                                                <td style="padding:0.35rem 0;text-align:center">{{ number_format($avg, 2) }}</td>
                                                                <td style="padding:0.35rem 0;text-align:center">{{ $k->bobot }}%</td>
                                                                <td style="padding:0.35rem 0;text-align:center">{{ number_format($actual, 1) }}</td>
                                                                <td style="padding:0.35rem 0;text-align:center">{{ $target }}</td>
                                                                <td style="padding:0.35rem 0;text-align:center;font-weight:700;color:{{ $gap >= 0 ? '#10b981' : '#ef4444' }}">{{ $gap > 0 ? '+' : '' }}{{ $gap }}</td>
                                                                <td style="padding:0.35rem 0.5rem 0.35rem 0;text-align:center;font-weight:700">{{ number_format($bobotGap, 1) }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr style="border-top:2px solid #e5e7eb;background:#f9fafb">
                                                                <td style="padding:0.5rem 0;font-weight:700" colspan="2">NCF (Core) — {{ number_format($h->skor_final, 4) }}</td>
                                                                <td style="padding:0.5rem 0;font-weight:700" colspan="2">NSF (Secondary) — {{ number_format($h->skor_awal, 4) }}</td>
                                                                <td style="padding:0.5rem 0.5rem 0.5rem 0;font-weight:700;color:#059669;font-size:0.85rem" colspan="3">
                                                                    <i class="fa-solid fa-star me-1"></i> Nilai Akhir: <strong>{{ number_format($h->nilai_total, 4) }}</strong>
                                                                </td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- PESERTA TABLE (no hasil yet) --}}
                        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
                            <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0">
                                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-users text-primary me-1"></i> Daftar Peserta {{ $j->nama_jenjang }}</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                                    <thead>
                                        <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                            <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Peserta</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">NPM</th>
                                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Prodi</th>
                                            <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Jml Penilaian</th>
                                            <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pesertaItems as $i => $p)
                                        <tr style="border-bottom:1px solid #f3f4f6">
                                            <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                                            <td style="padding:0.7rem 0;font-weight:600">{{ $p->mahasiswa->user->nama_lengkap }}</td>
                                            <td style="padding:0.7rem 0;color:#6b7280;font-size:0.72rem"><code>{{ $p->mahasiswa->nim }}</code></td>
                                            <td style="padding:0.7rem 0;font-size:0.72rem;color:#6b7280">{{ $p->mahasiswa->parsed_prodi }}</td>
                                            <td style="padding:0.7rem 0;text-align:center">
                                                <span class="badge bg-info text-dark badge-custom">{{ $p->penilaian->count() }} penilaian</span>
                                            </td>
                                            <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                                <span class="badge bg-warning text-dark badge-custom">Belum Dihitung</span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="padding:2rem;text-align:center;color:#9ca3af">
                                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i>
                                                Belum ada peserta {{ $j->nama_jenjang }} lolos tahap I.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.btn-toggle-detail').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var targetId = this.getAttribute('data-target');
        var row = document.getElementById(targetId);
        if (row.style.display === 'none' || row.style.display === '') {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.jenjang-tab');
    var hiddenInput = document.getElementById('proses_jenjang_id');
    var exportBtn = document.getElementById('btnExportPerhitungan');
    var jenjangMap = @json($jenjangList->pluck('id', 'nama_jenjang'));
    tabs.forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function () {
            var name = tab.textContent.trim().split(' ')[0];
            if (jenjangMap[name]) {
                hiddenInput.value = jenjangMap[name];
                exportBtn.href = '{{ route('admin.perhitungan.export') }}?jenjang_id=' + jenjangMap[name];
            }
        });
    });
});
</script>
@endpush
@endsection