@extends('layouts.dashboard')
@section('title', 'Dashboard Perangkingan Profile Matching')

@section('content')
<style>
    /* Styling Premium & Harmonious Color Palette */
    .sheet-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .sheet-tabs {
        background: #f8f9fa;
        border-bottom: 2px solid #eef2f5;
        padding: 0.75rem 1rem 0 1rem;
        display: flex;
        gap: 0.25rem;
        overflow-x: auto;
        white-space: nowrap;
    }
    .sheet-tab-link {
        font-weight: 600;
        font-size: 13.5px;
        color: #6c757d;
        border: 1px solid transparent;
        border-bottom: none;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
        padding: 0.6rem 1.2rem;
        transition: all 0.25s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .sheet-tab-link:hover {
        background: #eef2f5;
        color: #0d6efd;
    }
    .sheet-tab-link.active {
        background: #ffffff;
        color: #198754; /* Green color scheme mimicking Microsoft Excel */
        border-color: #eef2f5;
        border-bottom: 2px solid #198754;
        box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.03);
    }
    .excel-table {
        font-size: 13px;
    }
    .excel-table thead th {
        background-color: #198754;
        color: #ffffff;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 10px;
        border: 1px solid #146c43;
    }
    .excel-table tbody td {
        padding: 10px;
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }
    .excel-table tbody tr:hover {
        background-color: #f4faf6 !important;
    }
    .badge-premium {
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 11px;
    }
    .badge-ncf {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }
    .badge-nsf {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffe0b2;
    }
    .badge-gap-pos {
        background-color: #e3f2fd;
        color: #0d47a1;
        border: 1px solid #bbdefb;
    }
    .badge-gap-neg {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ffcdd2;
    }
    .badge-gap-zero {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }
    .math-formula {
        background: #f1f8f5;
        border-left: 4px solid #198754;
        border-radius: 6px;
        padding: 12px;
        font-family: monospace;
        font-size: 12px;
        color: #1b5e20;
    }
    .badge-custom { border-radius: var(--radius); }
    .btn-custom { border-radius: var(--radius); }
</style>

@php
// Helper: get bobot percentages for a peserta's jenjang
$getBobot = function($hasil) use ($bobotPerJenjang) {
    $jid = $hasil->pendaftaran->mahasiswa->jenjang_id ?? 1;
    $b = $bobotPerJenjang[$jid] ?? [];
    return [
        'A01' => ($b['A01'] ?? 35) / 100,
        'A02' => ($b['A02'] ?? 35) / 100,
        'A03' => ($b['A03'] ?? 30) / 100,
        'F01' => ($b['F01'] ?? 35) / 100,
        'F02' => ($b['F02'] ?? 35) / 100,
        'F03' => ($b['F03'] ?? 30) / 100,
    ];
};
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fa-solid fa-trophy text-warning me-2"></i> Dashboard Hasil Perangkingan SPK</h4>
        <p class="text-muted small mb-0">Sistem Pendukung Keputusan Pemilihan Mahasiswa Berprestasi (Pilmapres) | Metode Profile Matching</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.perhitungan.export', $selectedJenjang ? ['jenjang_id' => $selectedJenjang] : []) }}" class="btn btn-success px-3 btn-custom fw-semibold">
            <i class="fa-solid fa-file-excel me-2"></i> Ekspor Excel (9 Sheet)
        </a>
        <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-outline-secondary px-3 btn-custom">
            <i class="fa-solid fa-calculator me-2"></i> Hitung Ulang
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex gap-2 mb-3 flex-wrap">
    <span class="fw-semibold small text-muted me-1 align-self-center">Filter Jenjang:</span>
    <a href="{{ route('admin.perhitungan.hasil') }}"
       class="btn btn-sm {{ !$selectedJenjang ? 'btn-primary' : 'btn-outline-primary' }} btn-custom px-3">
        Semua
    </a>
    @foreach($jenjangList as $j)
    <a href="{{ route('admin.perhitungan.hasil', ['jenjang_id' => $j->id]) }}"
       class="btn btn-sm {{ $selectedJenjang == $j->id ? 'btn-primary' : 'btn-outline-primary' }} btn-custom px-3">
        <i class="fa-solid fa-graduation-cap me-1"></i> {{ $j->nama_jenjang }}
    </a>
    @endforeach
</div>

<div class="sheet-card">
    <!-- 9 Tabs mimicking Microsoft Excel Worksheets -->
    <div class="sheet-tabs" id="excelTabs" role="tablist">
        <button class="sheet-tab-link active" id="sheet1-tab" data-bs-toggle="tab" data-bs-target="#sheet1" type="button" role="tab">
            <i class="fa-solid fa-book text-success"></i> 1. Rubrik Penilaian
        </button>
        <button class="sheet-tab-link" id="sheet2-tab" data-bs-toggle="tab" data-bs-target="#sheet2" type="button" role="tab">
            <i class="fa-solid fa-user-group text-primary"></i> 2. Data Mahasiswa
        </button>
        <button class="sheet-tab-link" id="sheet3-tab" data-bs-toggle="tab" data-bs-target="#sheet3" type="button" role="tab">
            <i class="fa-solid fa-clipboard-user text-warning"></i> 3. Input Nilai Juri
        </button>
        <button class="sheet-tab-link" id="sheet4-tab" data-bs-toggle="tab" data-bs-target="#sheet4" type="button" role="tab">
            <i class="fa-solid fa-chart-line text-info"></i> 4. Tahap Awal
        </button>
        <button class="sheet-tab-link" id="sheet5-tab" data-bs-toggle="tab" data-bs-target="#sheet5" type="button" role="tab">
            <i class="fa-solid fa-chart-bar text-danger"></i> 5. Tahap Akhir
        </button>
        <button class="sheet-tab-link" id="sheet6-tab" data-bs-toggle="tab" data-bs-target="#sheet6" type="button" role="tab">
            <i class="fa-solid fa-shuffle text-secondary"></i> 6. Konversi 1-10
        </button>
        <button class="sheet-tab-link" id="sheet7-tab" data-bs-toggle="tab" data-bs-target="#sheet7" type="button" role="tab">
            <i class="fa-solid fa-arrow-right-arrow-left text-danger"></i> 7. Perhitungan GAP
        </button>
        <button class="sheet-tab-link" id="sheet8-tab" data-bs-toggle="tab" data-bs-target="#sheet8" type="button" role="tab">
            <i class="fa-solid fa-sliders text-success"></i> 8. Core & Secondary
        </button>
        <button class="sheet-tab-link" id="sheet9-tab" data-bs-toggle="tab" data-bs-target="#sheet9" type="button" role="tab">
            <i class="fa-solid fa-ranking-star text-warning"></i> 9. Ranking
        </button>
    </div>

    <!-- Sheet Content Pane -->
    <div class="tab-content p-4" id="excelTabsContent">
        
        <!-- SHEET 1: RUBRIK PENILAIAN -->
        <div class="tab-pane fade show active" id="sheet1" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-book text-success me-2"></i> Sheet 1: Rubrik Penilaian SPK</h5>
            <p class="text-muted small">Menampilkan struktur pembobotan bertingkat, pembagian faktor, target nilai profile matching, dan bobot masing-masing kriteria per jenjang.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th class="text-start ps-3">Nama Kriteria Penilaian</th>
                            <th>Jenjang</th>
                            <th>Jenis Tahap</th>
                            <th>Tipe Faktor</th>
                            <th>Target Nilai (Scale 1-10)</th>
                            <th>Bobot Kriteria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $k)
                        <tr>
                            <td><code>{{ $k->kode_kriteria }}</code></td>
                            <td class="text-start ps-3 fw-semibold">{{ $k->nama_kriteria }}</td>
                            <td><span class="badge bg-info">{{ $k->jenjang->nama_jenjang ?? 'Sarjana' }}</span></td>
                            <td>
                                <span class="badge bg-{{ $k->jenis_faktor === 'Tahap Awal' ? 'primary' : 'success' }}">{{ $k->jenis_faktor }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $k->jenis_faktor === 'Tahap Final' ? 'badge-ncf' : 'badge-nsf' }} badge-premium">
                                    {{ $k->jenis_faktor === 'Tahap Final' ? 'Core Factor (CF)' : 'Secondary Factor (SF)' }}
                                </span>
                            </td>
                            <td><strong class="text-primary">{{ $k->nilai_target }}</strong></td>
                            <td class="fw-bold">{{ $k->bobot }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 2: DATA MAHASISWA -->
        <div class="tab-pane fade" id="sheet2" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-user-group text-primary me-2"></i> Sheet 2: Data Mahasiswa Terdaftar</h5>
            <p class="text-muted small">Daftar mahasiswa berprestasi yang berhak mengikuti seleksi perhitungan metode Profile Matching.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NPM</th>
                            <th class="text-start ps-3">Nama Lengkap</th>
                            <th>Program Studi</th>
                            <th>IPK</th>
                            <th>Riwayat Pilmapres</th>
                            <th>Status Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $i => $h)
                        @php $m = $h->pendaftaran->mahasiswa; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td><code>{{ $m->nim }}</code></td>
                            <td class="text-start ps-3 fw-bold text-dark">{{ $m->user->nama_lengkap }}</td>
                            <td>{{ $m->program_studi }}</td>
                            <td class="fw-bold text-success">{{ number_format($m->ipk ?? 4.0, 2) }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $m->pernah_pilmapres }}</span></td>
                            <td><span class="badge bg-success badge-custom px-3">Lengkap</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 3: INPUT NILAI JURI -->
        <div class="tab-pane fade" id="sheet3" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-clipboard-user text-warning me-2"></i> Sheet 3: Nilai Mentah Juri (Subkriteria Aggregated)</h5>
            <p class="text-muted small">Menampilkan rekapitulasi nilai input mentah (skala 60-100) untuk 3 Juri pada seluruh kriteria penilaian.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th rowspan="2">NPM</th>
                            <th rowspan="2">Juri Penilai</th>
                            <th colspan="3">Tahap Awal (Skala 60-100)</th>
                            <th colspan="3">Tahap Final (Skala 60-100)</th>
                        </tr>
                        <tr>
                            <th>A01 (CU Berkas)</th>
                            <th>A02 (GK Naskah)</th>
                            <th>A03 (BI Video)</th>
                            <th>F01 (CU Wawancara)</th>
                            <th>F02 (GK Presentasi)</th>
                            <th>F03 (BI Lisan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $pendaftaran = $h->pendaftaran;
                            $penilaians = $pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                        @endphp
                        
                        @foreach($juries as $jIndex => $juri)
                        @php
                            $getScore = function($kode) use ($penilaians, $juri, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                return $penilaians->where('juri_id', $juri->id)->where('kriteria_id', $kId)->first()->nilai_input ?? 60;
                            };
                        @endphp
                        <tr>
                            @if($jIndex === 0)
                            <td rowspan="3" class="fw-bold text-dark text-start ps-3 border-end">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                            <td rowspan="3" class="border-end"><code>{{ $pendaftaran->mahasiswa->nim }}</code></td>
                            @endif
                            <td class="text-muted text-start ps-2">Juri #{{ $jIndex + 1 }} - {{ $juri->nama_lengkap }}</td>
                            <td>{{ number_format($getScore('A01'), 2) }}</td>
                            <td>{{ number_format($getScore('A02'), 2) }}</td>
                            <td>{{ number_format($getScore('A03'), 2) }}</td>
                            <td>{{ number_format($getScore('F01'), 2) }}</td>
                            <td>{{ number_format($getScore('F02'), 2) }}</td>
                            <td>{{ number_format($getScore('F03'), 2) }}</td>
                        </tr>
                        @endforeach
                        
                        <!-- Divider Line -->
                        <tr style="height: 4px; background: #dee2e6;"><td colspan="9" style="padding:0"></td></tr>
                        @empty
                        <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data nilai juri.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 4: PERHITUNGAN TAHAP AWAL -->
        <div class="tab-pane fade" id="sheet4" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-chart-line text-info me-2"></i> Sheet 4: Perhitungan Kriteria Tahap Awal</h5>
            <p class="text-muted small">Menghitung rata-rata nilai antar juri, kemudian mengalikan dengan bobot kriteria utama (LEVEL 2 — Bobot Kriteria). Bobot dinamis per jenjang.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th colspan="2">A01 (CU Berkas)</th>
                            <th colspan="2">A02 (GK Naskah)</th>
                            <th colspan="2">A03 (BI Video)</th>
                        </tr>
                        <tr>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $penilaians = $h->pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                            
                            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                return $scores->count() > 0 ? $scores->avg() : 60;
                            };
                            
                            $avgA01 = $getAvg('A01');
                            $avgA02 = $getAvg('A02');
                            $avgA03 = $getAvg('A03');
                            $bt = $getBobot($h);
                        @endphp
                        <tr>
                            <td class="text-start ps-3 fw-semibold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}
                                <span class="badge bg-info ms-2">{{ $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana' }}</span>
                            </td>
                            <td>{{ number_format($avgA01, 4) }}</td>
                            <td class="fw-bold text-primary">{{ number_format($avgA01 * $bt['A01'], 4) }}</td>
                            <td>{{ number_format($avgA02, 4) }}</td>
                            <td class="fw-bold text-primary">{{ number_format($avgA02 * $bt['A02'], 4) }}</td>
                            <td>{{ number_format($avgA03, 4) }}</td>
                            <td class="fw-bold text-primary">{{ number_format($avgA03 * $bt['A03'], 4) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data perhitungan Tahap Awal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 5: PERHITUNGAN TAHAP AKHIR -->
        <div class="tab-pane fade" id="sheet5" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-chart-bar text-danger me-2"></i> Sheet 5: Perhitungan Kriteria Tahap Akhir</h5>
            <p class="text-muted small">Menghitung rata-rata nilai antar juri, kemudian mengalikan dengan bobot kriteria utama (LEVEL 2 — Bobot Kriteria). Bobot dinamis per jenjang.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th colspan="2">F01 (CU Wawancara)</th>
                            <th colspan="2">F02 (GK Presentasi)</th>
                            <th colspan="2">F03 (BI Lisan)</th>
                        </tr>
                        <tr>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                            <th>Avg Juri</th>
                            <th>Hasil (bobot dinamis)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $penilaians = $h->pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                            
                            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                return $scores->count() > 0 ? $scores->avg() : 60;
                            };
                            
                            $avgF01 = $getAvg('F01');
                            $avgF02 = $getAvg('F02');
                            $avgF03 = $getAvg('F03');
                            $bt = $getBobot($h);
                        @endphp
                        <tr>
                            <td class="text-start ps-3 fw-semibold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}
                                <span class="badge bg-info ms-2">{{ $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana' }}</span>
                            </td>
                            <td>{{ number_format($avgF01, 4) }}</td>
                            <td class="fw-bold text-success">{{ number_format($avgF01 * $bt['F01'], 4) }}</td>
                            <td>{{ number_format($avgF02, 4) }}</td>
                            <td class="fw-bold text-success">{{ number_format($avgF02 * $bt['F02'], 4) }}</td>
                            <td>{{ number_format($avgF03, 4) }}</td>
                            <td class="fw-bold text-success">{{ number_format($avgF03 * $bt['F03'], 4) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data perhitungan Tahap Akhir.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 6: KONVERSI 1-10 -->
        <div class="tab-pane fade" id="sheet6" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-shuffle text-secondary me-2"></i> Sheet 6: Konversi Nilai Kriteria Akhir ke Skala 1-10</h5>
            <p class="text-muted small">Mengkonversi Nilai Akhir Kriteria (Hasil perkalian bobot dinamis) ke dalam skala 1–10.</p>
            
            <div class="math-formula mb-3">
                <strong>Aturan Interval Konversi Skala 1-10:</strong><br>
                Nilai &le; 12.0 &rarr; 1 | &le; 15.0 &rarr; 2 | &le; 18.0 &rarr; 3 | &le; 21.0 &rarr; 4 | &le; 24.0 &rarr; 5 | &le; 26.0 &rarr; 6 | &le; 28.0 &rarr; 7 | &le; 30.0 &rarr; 8 | &le; 32.0 &rarr; 9 | &gt; 32.0 &rarr; 10
            </div>

            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th colspan="3">Tahap Awal (Skala 1-10)</th>
                            <th colspan="3">Tahap Final (Skala 1-10)</th>
                        </tr>
                        <tr>
                            <th>A01 (CU Berkas)</th>
                            <th>A02 (GK Naskah)</th>
                            <th>A03 (BI Video)</th>
                            <th>F01 (CU Wawancara)</th>
                            <th>F02 (GK Presentasi)</th>
                            <th>F03 (BI Lisan)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $penilaians = $h->pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                            
                            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                return $scores->count() > 0 ? $scores->avg() : 60;
                            };
                            
                            $convertToScale10 = function($score) {
                                if ($score <= 12.0) return 1;
                                if ($score <= 15.0) return 2;
                                if ($score <= 18.0) return 3;
                                if ($score <= 21.0) return 4;
                                if ($score <= 24.0) return 5;
                                if ($score <= 26.0) return 6;
                                if ($score <= 28.0) return 7;
                                if ($score <= 30.0) return 8;
                                if ($score <= 32.0) return 9;
                                return 10;
                            };
                            
                            $bt = $getBobot($h);
                            $a01Val = $convertToScale10($getAvg('A01') * $bt['A01']);
                            $a02Val = $convertToScale10($getAvg('A02') * $bt['A02']);
                            $a03Val = $convertToScale10($getAvg('A03') * $bt['A03']);
                            $f01Val = $convertToScale10($getAvg('F01') * $bt['F01']);
                            $f02Val = $convertToScale10($getAvg('F02') * $bt['F02']);
                            $f03Val = $convertToScale10($getAvg('F03') * $bt['F03']);
                        @endphp
                        <tr>
                            <td class="text-start ps-3 fw-semibold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}
                                <span class="badge bg-info ms-2">{{ $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana' }}</span>
                            </td>
                            <td><span class="badge bg-primary fs-6">{{ $a01Val }}</span></td>
                            <td><span class="badge bg-primary fs-6">{{ $a02Val }}</span></td>
                            <td><span class="badge bg-primary fs-6">{{ $a03Val }}</span></td>
                            <td><span class="badge bg-success fs-6">{{ $f01Val }}</span></td>
                            <td><span class="badge bg-success fs-6">{{ $f02Val }}</span></td>
                            <td><span class="badge bg-success fs-6">{{ $f03Val }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data konversi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 7: PERHITUNGAN GAP -->
        <div class="tab-pane fade" id="sheet7" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-arrow-right-arrow-left text-danger me-2"></i> Sheet 7: Perhitungan Nilai GAP</h5>
            <p class="text-muted small">Menghitung deviasi (selisih) nilai aktual skala 1-10 terhadap nilai target profile matching. Target seluruh kriteria = **10**.</p>
            
            <div class="math-formula mb-3">
                <strong>Rumus GAP:</strong> GAP = Nilai Aktual - Nilai Target (Target = 10)
            </div>

            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th colspan="3">GAP Tahap Awal (Target = 10)</th>
                            <th colspan="3">GAP Tahap Final (Target = 10)</th>
                        </tr>
                        <tr>
                            <th>GAP A01</th>
                            <th>GAP A02</th>
                            <th>GAP A03</th>
                            <th>GAP F01</th>
                            <th>GAP F02</th>
                            <th>GAP F03</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $penilaians = $h->pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                            
                            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                return $scores->count() > 0 ? $scores->avg() : 60;
                            };
                            
                            $convertToScale10 = function($score) {
                                if ($score <= 12.0) return 1;
                                if ($score <= 15.0) return 2;
                                if ($score <= 18.0) return 3;
                                if ($score <= 21.0) return 4;
                                if ($score <= 24.0) return 5;
                                if ($score <= 26.0) return 6;
                                if ($score <= 28.0) return 7;
                                if ($score <= 30.0) return 8;
                                if ($score <= 32.0) return 9;
                                return 10;
                            };
                            
                            $bt = $getBobot($h);
                            $a01Val = $convertToScale10($getAvg('A01') * $bt['A01']);
                            $a02Val = $convertToScale10($getAvg('A02') * $bt['A02']);
                            $a03Val = $convertToScale10($getAvg('A03') * $bt['A03']);
                            $f01Val = $convertToScale10($getAvg('F01') * $bt['F01']);
                            $f02Val = $convertToScale10($getAvg('F02') * $bt['F02']);
                            $f03Val = $convertToScale10($getAvg('F03') * $bt['F03']);
                            
                            $gapA01 = $a01Val - 10;
                            $gapA02 = $a02Val - 10;
                            $gapA03 = $a03Val - 10;
                            $gapF01 = $f01Val - 10;
                            $gapF02 = $f02Val - 10;
                            $gapF03 = $f03Val - 10;
                        @endphp
                        <tr>
                            <td class="text-start ps-3 fw-semibold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}
                                <span class="badge bg-info ms-2">{{ $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana' }}</span>
                            </td>
                            <td><span class="badge-premium {{ $gapA01 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapA01 }}</span></td>
                            <td><span class="badge-premium {{ $gapA02 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapA02 }}</span></td>
                            <td><span class="badge-premium {{ $gapA03 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapA03 }}</span></td>
                            <td><span class="badge-premium {{ $gapF01 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapF01 }}</span></td>
                            <td><span class="badge-premium {{ $gapF02 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapF02 }}</span></td>
                            <td><span class="badge-premium {{ $gapF03 < 0 ? 'badge-gap-neg' : 'badge-gap-zero' }}">{{ $gapF03 }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data GAP.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 8: CORE & SECONDARY -->
        <div class="tab-pane fade" id="sheet8" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-sliders text-success me-2"></i> Sheet 8: Pemetaan Core & Secondary Factor serta Bobot GAP</h5>
            <p class="text-muted small">Mengkonversi GAP ke Bobot GAP, lalu mengelompokkan ke dalam NCF (Core — 70%) dan NSF (Secondary — 30%) untuk menghitung Nilai Akhir SPK.</p>
            
            <div class="math-formula mb-3">
                <strong>Konversi Bobot GAP:</strong> GAP 0 = 10 | GAP -1 = 9 | GAP -2 = 8 | GAP -3 = 7 | GAP -4 = 6 | GAP -5 = 5 | GAP -6 = 4 | GAP -7 = 3 | GAP -8 = 2 | GAP -9 = 1<br>
                <strong>Rumus Nilai Akhir:</strong> Nilai Akhir = (70% &times; NCF) + (30% &times; NSF)
            </div>

            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2">Nama Mahasiswa</th>
                            <th colspan="3">Bobot GAP Secondary (Awal)</th>
                            <th colspan="3">Bobot GAP Core (Akhir)</th>
                            <th rowspan="2">NSF (Avg SF)</th>
                            <th rowspan="2">NCF (Avg CF)</th>
                            <th rowspan="2">Nilai Akhir (Profile Matching)</th>
                        </tr>
                        <tr>
                            <th>A01</th>
                            <th>A02</th>
                            <th>A03</th>
                            <th>F01</th>
                            <th>F02</th>
                            <th>F03</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        @php
                            $penilaians = $h->pendaftaran->penilaian;
                            $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
                            
                            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                                $kId = $kriteriasMap[$kode] ?? 0;
                                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                                return $scores->count() > 0 ? $scores->avg() : 60;
                            };
                            
                            $convertToScale10 = function($score) {
                                if ($score <= 12.0) return 1;
                                if ($score <= 15.0) return 2;
                                if ($score <= 18.0) return 3;
                                if ($score <= 21.0) return 4;
                                if ($score <= 24.0) return 5;
                                if ($score <= 26.0) return 6;
                                if ($score <= 28.0) return 7;
                                if ($score <= 30.0) return 8;
                                if ($score <= 32.0) return 9;
                                return 10;
                            };
                            
                            $getGapWeight = function($gap) {
                                return match ($gap) {
                                    0 => 10.0,
                                    1 => 9.5,
                                    -1 => 9.0,
                                    2 => 8.5,
                                    -2 => 8.0,
                                    3 => 7.5,
                                    -3 => 7.0,
                                    4 => 6.5,
                                    -4 => 6.0,
                                    5 => 5.5,
                                    -5 => 5.0,
                                    -6 => 4.0,
                                    -7 => 3.0,
                                    -8 => 2.0,
                                    -9 => 1.0,
                                    default => $gap < 0 ? max(1.0, 10.0 + $gap) : max(1.0, 10.0 - $gap)
                                };
                            };
                            
                            $bt = $getBobot($h);
                            $a01 = $convertToScale10($getAvg('A01') * $bt['A01']);
                            $a02 = $convertToScale10($getAvg('A02') * $bt['A02']);
                            $a03 = $convertToScale10($getAvg('A03') * $bt['A03']);
                            $f01 = $convertToScale10($getAvg('F01') * $bt['F01']);
                            $f02 = $convertToScale10($getAvg('F02') * $bt['F02']);
                            $f03 = $convertToScale10($getAvg('F03') * $bt['F03']);
                            
                            $wA01 = $getGapWeight($a01 - 10);
                            $wA02 = $getGapWeight($a02 - 10);
                            $wA03 = $getGapWeight($a03 - 10);
                            $wF01 = $getGapWeight($f01 - 10);
                            $wF02 = $getGapWeight($f02 - 10);
                            $wF03 = $getGapWeight($f03 - 10);
                            
                            $nsf = ($wA01 + $wA02 + $wA03) / 3.0;
                            $ncf = ($wF01 + $wF02 + $wF03) / 3.0;
                        @endphp
                        <tr>
                            <td class="text-start ps-3 fw-semibold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}
                                <span class="badge bg-info ms-2">{{ $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana' }}</span>
                            </td>
                            <td>{{ number_format($wA01, 1) }}</td>
                            <td>{{ number_format($wA02, 1) }}</td>
                            <td>{{ number_format($wA03, 1) }}</td>
                            <td>{{ number_format($wF01, 1) }}</td>
                            <td>{{ number_format($wF02, 1) }}</td>
                            <td>{{ number_format($wF03, 1) }}</td>
                            <td><span class="badge-premium badge-nsf">{{ number_format($nsf, 4) }}</span></td>
                            <td><span class="badge-premium badge-ncf">{{ number_format($ncf, 4) }}</span></td>
                            <td class="fw-bold text-primary fs-6">{{ number_format($h->nilai_total, 4) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center py-4 text-muted">Belum ada data Core & Secondary.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SHEET 9: RANKING -->
        <div class="tab-pane fade" id="sheet9" role="tabpanel">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-ranking-star text-warning me-2"></i> Sheet 9: Ranking & Klasemen Akhir Mahasiswa</h5>
            <p class="text-muted small">Hasil rekomendasi akhir mahasiswa berprestasi yang disusun otomatis menggunakan perangkingan anti-duplikat.</p>
            
            <div class="table-responsive">
                <table class="table excel-table text-center align-middle">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>NPM</th>
                            <th class="text-start ps-4">Nama Mahasiswa</th>
                            <th>Program Studi</th>
                            <th>Nilai Sementara (Raw Avg)</th>
                            <th>Skor NSF (Secondary)</th>
                            <th>Skor NCF (Core)</th>
                            <th>Nilai Akhir (SPK)</th>
                            <th>Status Juara</th>
                            <th>Status Validasi WR3</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilList as $h)
                        <tr class="{{ $h->ranking <= 3 ? 'table-warning bg-opacity-10' : '' }}">
                            <td>
                                @if($h->ranking == 1) <span class="badge bg-warning text-dark fs-6 badge-custom px-3">🥇 1</span>
                                @elseif($h->ranking == 2) <span class="badge bg-secondary fs-6 badge-custom px-3">🥈 2</span>
                                @elseif($h->ranking == 3) <span class="badge fs-6 badge-custom px-3 text-white" style="background:#cd7f32">🥉 3</span>
                                @else <span class="text-muted fw-bold">{{ $h->ranking }}</span>
                                @endif
                            </td>
                            <td><code>{{ $h->pendaftaran->mahasiswa->nim }}</code></td>
                            <td class="text-start ps-4 fw-bold text-dark">{{ $h->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                            <td>{{ $h->pendaftaran->mahasiswa->program_studi }}</td>
                            <td class="fw-semibold text-success">{{ number_format($h->nilai_sementara ?? 0, 4) }}</td>
                            <td>{{ number_format($h->skor_awal, 4) }}</td>
                            <td>{{ number_format($h->skor_final, 4) }}</td>
                            <td class="fw-bold text-primary fs-5">{{ number_format($h->nilai_total, 4) }}</td>
                            <td>
                                @php $jColors = ['Juara 1'=>'warning text-dark','Juara 2'=>'secondary','Juara 3'=>'dark','Tidak Juara'=>'light text-muted']; @endphp
                                <span class="badge bg-{{ $jColors[$h->status_juara] ?? 'secondary' }} badge-custom px-3">{{ $h->status_juara }}</span>
                            </td>
                            <td>
                                <span class="badge badge-custom px-3 {{ $h->validasi_wr3 === 'Divalidasi' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $h->validasi_wr3 }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center py-4 text-muted">Belum ada hasil ranking.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
