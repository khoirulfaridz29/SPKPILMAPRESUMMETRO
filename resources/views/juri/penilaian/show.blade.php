@extends('layouts.dashboard')
@section('title', 'Form Penilaian')

@section('content')
<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('juri.penilaian.index') }}" class="btn btn-sm" style="background:var(--bg-card);color:var(--text-muted);border-radius:var(--radius-sm);padding:0.4rem 0.75rem;font-size:0.8rem">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold mb-0">Input Penilaian</h4>
    <div class="ms-auto d-flex align-items-center gap-2">
        <div style="width:28px;height:28px;border-radius:var(--radius-sm);background:var(--primary-light);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:0.65rem;flex-shrink:0">
            {{ substr($pendaftaran->mahasiswa->user->nama_lengkap, 0, 1) }}
        </div>
        <span class="fw-semibold small">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</span>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        {{-- Data Peserta --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-bottom-0 pt-3 px-3">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-user me-2 text-primary"></i> Data Peserta</h6>
            </div>
            <div class="card-body pt-0 px-3 pb-3">
                <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem;width:60px">Nama</td>
                        <td style="padding:0.45rem 0;font-weight:600">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">NPM</td>
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">{{ $pendaftaran->mahasiswa->nim }}</td>
                    </tr>
                    <tr>
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">Prodi</td>
                        <td style="padding:0.45rem 0;font-size:0.8rem">{{ $pendaftaran->mahasiswa->program_studi }}</td>
                    </tr>
                </table>
                </div>
            </div>
        </div>

        {{-- Berkas Peserta --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-bottom-0 pt-3 px-3">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-folder-open me-2 text-success"></i> Berkas Peserta</h6>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($pendaftaran->berkas as $b)
                <li class="list-group-item d-flex justify-content-between align-items-center px-3 py-2 border-0 border-bottom" style="border-color:var(--border-color)!important;background:transparent">
                    <small class="text-truncate me-2">{{ $b->nama_berkas }}</small>
                    <a href="javascript:void(0)" class="view-berkas flex-shrink-0" style="color:var(--primary-light);font-size:0.85rem" data-url="{{ route('berkas.view', $b) }}">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </li>
                @empty
                <li class="list-group-item text-muted small py-3 text-center border-0" style="background:transparent">Tidak ada berkas.</li>
                @endforelse
            </ul>
        </div>

        {{-- Sertifikat Capaian Unggulan --}}
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-bottom-0 pt-3 px-3">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-award me-2 text-primary"></i> Sertifikat Capaian Unggulan</h6>
            </div>
            <div class="card-body pt-0 px-3 pb-3">
                @forelse($pendaftaran->portofolios as $porto)
                <div class="mb-2 p-2 rounded" style="background:var(--bg-body);border:1px solid var(--border-color)">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="small" style="flex:1;min-width:0">
                            <h6 class="fw-bold mb-1 small">{{ $porto->nama_prestasi }}</h6>
                            <div style="font-size:0.7rem;color:var(--text-muted)">
                                <div>{{ $porto->kategori_jenjang }} &middot; {{ $porto->rubrikCu->wujud_capaian_unggulan ?? '-' }}</div>
                                <div>{{ $porto->tempat }} &middot; {{ \Carbon\Carbon::parse($porto->tanggal_pelaksanaan)->format('d M Y') }}</div>
                            </div>
                            <div class="mt-1 d-flex gap-1">
                                <span class="badge" style="background:#e6f7ee;color:#10b981;font-weight:500;border:none;font-size:0.6rem">Valid</span>
                                @if($porto->skor_rekomendasi)
                                <span class="badge" style="background:#e0f2fe;color:#0ea5e9;font-weight:500;border:none;font-size:0.6rem">
                                    Skor {{ $porto->skor_rekomendasi }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="view-berkas flex-shrink-0" style="color:var(--primary-light);font-size:0.85rem" data-url="{{ route('portofolio.view', $porto) }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3 small">Belum ada sertifikat capaian unggulan.</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-bottom-0 pt-3 px-4 d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-pen-to-square me-2 text-warning"></i> Form Penilaian</h6>
                @php
                    $totalTabs = 5;
                    $completedTabs = 0;
                    if($existing_a01) $completedTabs++;
                    if($penilaian_wawancara_cu->count() >= $rubrik_wawancara_cu->count()) $completedTabs++;
                    if($penilaian_naskah->count() >= $rubrik_naskah->count()) $completedTabs++;
                    if($penilaian_presentasi->count() >= $rubrik_presentasi->count()) $completedTabs++;
                    if($penilaian_inggris->count() >= $rubrik_inggris->count()) $completedTabs++;
                @endphp
                <span class="small text-muted">{{ $completedTabs }}/{{ $totalTabs }} tab terisi</span>
            </div>
            <div class="card-body px-4 pb-4">
                <form action="{{ route('juri.penilaian.store', $pendaftaran) }}" method="POST">
                    @csrf

                    <ul class="nav nav-pills mb-4 gap-1" id="penilaianTabs" role="tablist" style="flex-wrap:nowrap;overflow-x:auto">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="cu-berkas-tab" data-bs-toggle="tab" data-bs-target="#cuberkas" type="button" role="tab" style="border-radius:var(--radius-sm);padding:0.4rem 0.7rem;font-size:0.75rem;white-space:nowrap">
                                <i class="fa-solid fa-medal me-1"></i> CU Berkas
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cu-wawancara-tab" data-bs-toggle="tab" data-bs-target="#cuwawancara" type="button" role="tab" style="border-radius:var(--radius-sm);padding:0.4rem 0.7rem;font-size:0.75rem;white-space:nowrap">
                                <i class="fa-solid fa-microphone me-1"></i> CU Wawancara
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="naskah-tab" data-bs-toggle="tab" data-bs-target="#naskah" type="button" role="tab" style="border-radius:var(--radius-sm);padding:0.4rem 0.7rem;font-size:0.75rem;white-space:nowrap">
                                <i class="fa-solid fa-file-alt me-1"></i> Naskah GK
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="presentasi-tab" data-bs-toggle="tab" data-bs-target="#presentasi" type="button" role="tab" style="border-radius:var(--radius-sm);padding:0.4rem 0.7rem;font-size:0.75rem;white-space:nowrap">
                                <i class="fa-solid fa-chalkboard-user me-1"></i> Presentasi GK
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inggris-tab" data-bs-toggle="tab" data-bs-target="#inggris" type="button" role="tab" style="border-radius:var(--radius-sm);padding:0.4rem 0.7rem;font-size:0.75rem;white-space:nowrap">
                                <i class="fa-solid fa-language me-1"></i> B. Inggris
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="penilaianTabsContent">
                        {{-- CU Berkas --}}
                        <div class="tab-pane fade show active" id="cuberkas" role="tabpanel">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width:4px;height:20px;border-radius:2px;background:var(--primary-light)"></div>
                                <h6 class="fw-bold mb-0 small">Validasi Skor Capaian Unggulan Berkas (A01)</h6>
                            </div>
                            <div class="alert d-flex align-items-center gap-2 small mb-4" style="background:#f0f7ff;color:#2563eb;border:none;border-radius:var(--radius-sm);padding:0.6rem 0.9rem">
                                <i class="fa-solid fa-circle-info"></i> Skor rekomendasi berdasarkan sertifikat tervalidasi admin: <strong>{{ $total_rekomendasi }}</strong>. Boleh sesuaikan +/- 10.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold small" for="nilai_a01">Skor Akhir Capaian Unggulan Berkas (A01)</label>
                                <div class="input-group">
                                    <input type="number" name="nilai_a01" id="nilai_a01" class="form-control form-control-lg" value="{{ $existing_a01 ?? ($total_rekomendasi < 60 ? 60 : $total_rekomendasi) }}" min="60" max="100" required>
                                    <span class="input-group-text fw-semibold small" style="background:var(--bg-body)">/ 100</span>
                                </div>
                            </div>
                        </div>

                        {{-- CU Wawancara --}}
                        <div class="tab-pane fade" id="cuwawancara" role="tabpanel">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width:4px;height:20px;border-radius:2px;background:var(--primary-light)"></div>
                                <h6 class="fw-bold mb-0 small">Penilaian Wawancara Capaian Unggulan (F01)</h6>
                            </div>
                            <div class="alert d-flex align-items-center gap-2 small mb-4" style="background:#f0f7ff;color:#2563eb;border:none;border-radius:var(--radius-sm);padding:0.6rem 0.9rem">
                                <i class="fa-solid fa-circle-info"></i> Berikan nilai untuk masing-masing kriteria skala 60 - 100.
                            </div>
                            @foreach($rubrik_wawancara_cu as $k)
                            <div class="mb-2 p-2 rounded d-flex align-items-center justify-content-between" style="background:var(--bg-body)">
                                <span class="small" style="flex:1">{{ $k->kriteria_penilaian }} <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">{{ $k->bobot }}%</span></span>
                                <input type="number" name="wawancara_cu[{{ $k->id }}]" class="form-control form-control-sm" style="width:100px" value="{{ $penilaian_wawancara_cu[$k->id] ?? '' }}" min="60" max="100" placeholder="60-100" required>
                            </div>
                            @endforeach
                        </div>

                        {{-- Naskah GK --}}
                        <div class="tab-pane fade" id="naskah" role="tabpanel">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width:4px;height:20px;border-radius:2px;background:var(--primary-light)"></div>
                                <h6 class="fw-bold mb-0 small">Penilaian Naskah Gagasan Kreatif</h6>
                            </div>
                            <div class="alert d-flex align-items-center gap-2 small mb-4" style="background:#f0f7ff;color:#2563eb;border:none;border-radius:var(--radius-sm);padding:0.6rem 0.9rem">
                                <i class="fa-solid fa-circle-info"></i> Berikan nilai untuk masing-masing kriteria skala 60 - 100.
                            </div>
                            @foreach($rubrik_naskah->groupBy('aspek_penilaian') as $aspek => $items)
                            <div class="mb-3">
                                <h6 class="fw-semibold small border-bottom pb-1 mb-2" style="border-color:var(--border-color)!important">{{ $aspek }}</h6>
                                @foreach($items as $k)
                                <div class="mb-1 p-2 rounded d-flex align-items-center justify-content-between" style="background:var(--bg-body)">
                                    <span class="small" style="flex:1">{{ $k->kriteria_penilaian }} <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">{{ $k->bobot }}%</span></span>
                                    <input type="number" name="naskah[{{ $k->id }}]" class="form-control form-control-sm" style="width:100px" value="{{ $penilaian_naskah[$k->id] ?? '' }}" min="60" max="100" placeholder="60-100" required>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                        {{-- Presentasi GK --}}
                        <div class="tab-pane fade" id="presentasi" role="tabpanel">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width:4px;height:20px;border-radius:2px;background:var(--primary-light)"></div>
                                <h6 class="fw-bold mb-0 small">Penilaian Presentasi Gagasan Kreatif</h6>
                            </div>
                            <div class="alert d-flex align-items-center gap-2 small mb-4" style="background:#f0f7ff;color:#2563eb;border:none;border-radius:var(--radius-sm);padding:0.6rem 0.9rem">
                                <i class="fa-solid fa-circle-info"></i> Berikan nilai untuk masing-masing kriteria skala 60 - 100.
                            </div>
                            @foreach($rubrik_presentasi->groupBy('aspek_penilaian') as $aspek => $items)
                            <div class="mb-3">
                                <h6 class="fw-semibold small border-bottom pb-1 mb-2" style="border-color:var(--border-color)!important">{{ $aspek }}</h6>
                                @foreach($items as $k)
                                <div class="mb-1 p-2 rounded d-flex align-items-center justify-content-between" style="background:var(--bg-body)">
                                    <span class="small" style="flex:1">{{ $k->kriteria_penilaian }} <span class="badge text-muted" style="background:var(--bg-card);font-weight:500;font-size:0.6rem;border:1px solid var(--border-color)">{{ $k->bobot }}%</span></span>
                                    <input type="number" name="presentasi[{{ $k->id }}]" class="form-control form-control-sm" style="width:100px" value="{{ $penilaian_presentasi[$k->id] ?? '' }}" min="60" max="100" placeholder="60-100" required>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>

                        {{-- B. Inggris --}}
                        <div class="tab-pane fade" id="inggris" role="tabpanel">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <div style="width:4px;height:20px;border-radius:2px;background:var(--primary-light)"></div>
                                <h6 class="fw-bold mb-0 small">Penilaian Bahasa Inggris</h6>
                            </div>
                            <div class="alert d-flex align-items-center gap-2 small mb-4" style="background:#f0f7ff;color:#2563eb;border:none;border-radius:var(--radius-sm);padding:0.6rem 0.9rem">
                                <i class="fa-solid fa-circle-info"></i> Input skor berdasarkan kriteria range Excellent, Good, Fair, atau Poor.
                            </div>
                            @foreach($rubrik_inggris as $k)
                            @php preg_match('/^[0-9]+/', $k->excellent_score, $matches); $max_score = isset($matches[0]) ? (int)$matches[0] : 100; @endphp
                            <div class="mb-3 p-3 rounded" style="background:var(--bg-body);border:1px solid var(--border-color)">
                                <h6 class="fw-bold small mb-2">{{ $k->field }}</h6>
                                <div class="row g-1 small mb-2" style="font-size:0.7rem">
                                    <div class="col-3"><strong class="text-success">Exc ({{ $k->excellent_score }}):</strong> {{ $k->excellent_criteria }}</div>
                                    <div class="col-3"><strong class="text-primary">Good ({{ $k->good_score }}):</strong> {{ $k->good_criteria }}</div>
                                    <div class="col-3"><strong class="text-warning">Fair ({{ $k->fair_score }}):</strong> {{ $k->fair_criteria }}</div>
                                    <div class="col-3"><strong class="text-danger">Poor ({{ $k->poor_score }}):</strong> {{ $k->poor_criteria }}</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <span class="small text-muted">Skor Final:</span>
                                    <input type="number" name="inggris[{{ $k->id }}]" class="form-control form-control-sm" style="width:100px" value="{{ $penilaian_inggris[$k->id] ?? '' }}" min="0" max="{{ $max_score }}" placeholder="0-{{ $max_score }}" required>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="my-3">
                    <button type="submit" class="btn w-100" style="background:var(--primary-light);color:white;border-radius:var(--radius-sm);padding:0.6rem;font-weight:600">
                        <i class="fa-solid fa-save me-2"></i> Simpan Penilaian
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lihat Berkas --}}
<div class="modal fade" id="berkasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius);border:none">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-file me-2 text-primary"></i> Dokumen Peserta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <iframe id="berkasIframe" src="" style="width:100%;height:65vh;border:none;border-radius:var(--radius-sm);background:#fff"></iframe>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.view-berkas').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var iframe = document.getElementById('berkasIframe');
        if (iframe) iframe.src = this.dataset.url;
        new bootstrap.Modal('#berkasModal').show();
    });
});
var berkasModal = document.getElementById('berkasModal');
if (berkasModal) {
    berkasModal.addEventListener('hidden.bs.modal', function() {
        var iframe = document.getElementById('berkasIframe');
        if (iframe) iframe.src = '';
    });
}
</script>
@endpush
@endsection