@extends('layouts.dashboard')
@section('title', 'Hasil Rangking')

@section('content')
<style>
    .filter-card .form-label { font-size: .75rem; font-weight: 600; margin-bottom: .25rem; color: var(--text-muted); }
    .detail-card { background: #f8fafc; border: 1px solid #e5e7eb; border-radius: var(--radius-sm); }
    .juara-1 { background: linear-gradient(135deg, #fef3c7, #fde68a); }
    .juara-2 { background: linear-gradient(135deg, #f3f4f6, #e5e7eb); }
    .juara-3 { background: linear-gradient(135deg, #fff7ed, #fed7aa); }
    .rank-badge { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; font-weight: 800; font-size: .85rem; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-trophy text-warning me-2"></i> Hasil Rangking</h4>
        <p class="text-muted small mb-0">Perangkingan peserta per jenjang berdasarkan perhitungan GAP profile matching.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.perhitungan.export', request()->only('jenjang_id', 'tahun')) }}" class="btn btn-outline-dark btn-custom px-3 fw-semibold btn-sm">
            <i class="fa-solid fa-file-excel me-1"></i> Export
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4 col-xl-3">
        <div class="card filter-card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-sliders me-2 text-primary"></i> Filter</h6>
            </div>
            <div class="card-body">
                <form method="GET">
                    <div class="mb-3">
                        <label class="form-label" for="jenjang_id">Jenjang</label>
                        <select name="jenjang_id" id="jenjang_id" class="form-select">
                            <option value="">Semua Jenjang</option>
                            @foreach($jenjangList as $j)
                                <option value="{{ $j->id }}" {{ $selectedJenjang == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tahun">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ $selectedTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-filter me-1"></i> Terapkan</button>
                        <a href="{{ route('admin.perhitungan.ranking') }}" class="btn btn-outline-secondary w-100"><i class="fa-solid fa-rotate me-1"></i> Reset</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-xl-9">
        @if($hasilList->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <i class="fa-solid fa-trophy fa-3x mb-3 d-block text-secondary"></i>
                    <p class="mb-0">Belum ada hasil perhitungan. Lakukan perhitungan GAP terlebih dahulu.</p>
                    <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-primary mt-3 btn-sm">
                        <i class="fa-solid fa-calculator me-1"></i> Ke Halaman Perhitungan
                    </a>
                </div>
            </div>
        @else
            @php
                $groupedByJenjang = $hasilList->groupBy(fn($h) => $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana');
            @endphp

            @foreach($groupedByJenjang as $namaJenjang => $items)
            <div class="card border-0 shadow-sm mb-4" style="border-radius:var(--radius)">
                <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-graduation-cap text-primary me-2"></i> {{ $namaJenjang }}
                        <span class="badge bg-secondary ms-2" style="font-size:.65rem">{{ $items->count() }} peserta</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:2px solid #e5e7eb;background:#f9fafb">
                                <th style="width:50px;padding:0.6rem 0 0.6rem 1rem;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Rank</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Nama Peserta</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">NPM</th>
                                <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Prodi</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">NCF (Core)</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">NSF (Secondary)</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Nilai Akhir</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Status</th>
                                <th style="width:60px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $h)
                            @php
                                $rowClass = match($h->ranking) { 1 => 'juara-1', 2 => 'juara-2', 3 => 'juara-3', default => '' };
                                $rankColor = match($h->ranking) { 1 => '#d97706', 2 => '#6b7280', 3 => '#92400e', default => '#9ca3af' };
                                $rankBg = match($h->ranking) { 1 => '#fef3c7', 2 => '#f3f4f6', 3 => '#fff7ed', default => 'transparent' };
                            @endphp
                            <tr style="border-bottom:1px solid #f3f4f6;background:{{ $rankBg }}">
                                <td style="padding:0.6rem 0 0.6rem 1rem;text-align:center">
                                    <span class="rank-badge" style="background:{{ $rankColor }};color:#fff">
                                        @if($h->ranking == 1) <i class="fa-solid fa-crown" style="font-size:.75rem"></i>
                                        @elseif($h->ranking == 2) <i class="fa-solid fa-medal" style="font-size:.75rem"></i>
                                        @elseif($h->ranking == 3) <i class="fa-solid fa-star" style="font-size:.7rem"></i>
                                        @else {{ $h->ranking }}
                                        @endif
                                    </span>
                                </td>
                                <td style="padding:0.6rem 0;font-weight:600">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                <td style="padding:0.6rem 0;color:#6b7280;font-size:0.75rem"><code>{{ $h->pendaftaran->mahasiswa->nim }}</code></td>
                                <td style="padding:0.6rem 0;font-size:0.75rem;color:#6b7280">{{ $h->pendaftaran->mahasiswa->parsed_prodi }}</td>
                                <td style="padding:0.6rem 0;text-align:center;font-weight:600">{{ number_format($h->skor_final, 4) }}</td>
                                <td style="padding:0.6rem 0;text-align:center;font-weight:600">{{ number_format($h->skor_awal, 4) }}</td>
                                <td style="padding:0.6rem 0;text-align:center;font-weight:800;color:#059669">{{ number_format($h->nilai_total, 4) }}</td>
                                <td style="padding:0.6rem 0;text-align:center">
                                    @php
                                        $juaraStyle = match($h->status_juara) {
                                            'Juara 1' => 'background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff',
                                            'Juara 2' => 'background:linear-gradient(135deg,#9ca3af,#6b7280);color:#fff',
                                            'Juara 3' => 'background:linear-gradient(135deg,#d97706,#92400e);color:#fff',
                                            default => 'background:#f3f4f6;color:#9ca3af'
                                        };
                                    @endphp
                                    <span style="{{ $juaraStyle }};border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.7rem;font-weight:700;white-space:nowrap">
                                        {{ $h->status_juara }}
                                    </span>
                                </td>
                                <td style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center">
                                    <button type="button" class="btn btn-sm btn-outline-info table-action-btn btn-toggle-detail"
                                        data-target="detail-{{ $h->id }}">
                                        <i class="fa-solid fa-chart-simple"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr id="detail-{{ $h->id }}" style="display:none">
                                <td colspan="9" style="padding:0;border-bottom:1px solid #f3f4f6">
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

                                        <div class="row g-3">
                                            {{-- Kriteria Breakdown --}}
                                            <div class="col-12">
                                                <h6 class="fw-bold mb-2 small text-secondary"><i class="fa-solid fa-list-check me-1"></i> Rincian Perhitungan GAP</h6>
                                                <div class="table-responsive">
                                                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.78rem">
                                                    <thead>
                                                        <tr style="border-bottom:2px solid #e5e7eb">
                                                            <th style="padding:0.35rem 0;font-weight:700;color:#374151">Kriteria</th>
                                                            <th style="padding:0.35rem 0;text-align:center;font-weight:700;color:#374151">Nama Kriteria</th>
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
                                                            $isCore = $k->jenis_faktor === 'Tahap Final';
                                                        @endphp
                                                        <tr style="border-bottom:1px solid #f3f4f6;background:{{ $isCore ? '#f0fdf4' : '#f0f9ff' }}">
                                                            <td style="padding:0.35rem 0;font-weight:700">{{ $k->kode_kriteria }}</td>
                                                            <td style="padding:0.35rem 0;font-size:0.72rem;color:#4b5563">{{ $k->nama_kriteria }}</td>
                                                            <td style="padding:0.35rem 0;text-align:center">{{ number_format($avg, 2) }}</td>
                                                            <td style="padding:0.35rem 0;text-align:center">{{ $k->bobot }}%</td>
                                                            <td style="padding:0.35rem 0;text-align:center;font-weight:600">{{ number_format($actual, 1) }}</td>
                                                            <td style="padding:0.35rem 0;text-align:center">{{ $target }}</td>
                                                            <td style="padding:0.35rem 0;text-align:center;font-weight:700;color:{{ $gap >= 0 ? '#10b981' : '#ef4444' }}">
                                                                {{ $gap > 0 ? '+' : '' }}{{ $gap }}
                                                            </td>
                                                            <td style="padding:0.35rem 0.5rem 0.35rem 0;text-align:center;font-weight:700">{{ number_format($bobotGap, 1) }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>

                                            {{-- Summary Scores --}}
                                            <div class="col-12">
                                                <div class="d-flex flex-wrap gap-3 p-3" style="background:#fff;border-radius:var(--radius-sm);border:1px solid #e5e7eb">
                                                    <div class="px-3 py-2 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0">
                                                        <small class="text-muted d-block" style="font-size:.7rem">NCF (Core Factor)</small>
                                                        <strong style="font-size:1rem;color:#16a34a">{{ number_format($h->skor_final, 4) }}</strong>
                                                    </div>
                                                    <div class="px-3 py-2 rounded-3" style="background:#f0f9ff;border:1px solid #bae6fd">
                                                        <small class="text-muted d-block" style="font-size:.7rem">NSF (Secondary Factor)</small>
                                                        <strong style="font-size:1rem;color:#0284c7">{{ number_format($h->skor_awal, 4) }}</strong>
                                                    </div>
                                                    <div class="px-3 py-2 rounded-3" style="background:#fef3c7;border:1px solid #fde68a">
                                                        <small class="text-muted d-block" style="font-size:.7rem">Nilai Akhir (70% NCF + 30% NSF)</small>
                                                        <strong style="font-size:1.1rem;color:#d97706">{{ number_format($h->nilai_total, 4) }}</strong>
                                                    </div>
                                                    <div class="px-3 py-2 rounded-3" style="background:#f3f4f6;border:1px solid #e5e7eb">
                                                        <small class="text-muted d-block" style="font-size:.7rem">Ranking</small>
                                                        <strong style="font-size:1rem;color:#374151">#{{ $h->ranking }}</strong>
                                                    </div>
                                                </div>
                                            </div>
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
            @endforeach
        @endif
    </div>
</div>
@endsection

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
</script>
@endpush