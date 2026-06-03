@extends('layouts.dashboard')
@section('title', 'Form Penilaian')

@section('content')
<div class="mb-4">
    <a href="{{ route('juri.penilaian.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Input Penilaian: {{ $pendaftaran->mahasiswa->user->nama_lengkap }}</span>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><i class="fa-solid fa-user me-2 text-primary"></i> Data Peserta</div>
            <div class="card-body">
                <table class="table table-borderless mb-0 small">
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</td></tr>
                    <tr><td class="text-muted">NIM</td><td>{{ $pendaftaran->mahasiswa->nim }}</td></tr>
                    <tr><td class="text-muted">Prodi</td><td>{{ $pendaftaran->mahasiswa->program_studi }}</td></tr>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-folder-open me-2 text-success"></i> Berkas Peserta</div>
            <ul class="list-group list-group-flush">
                @forelse($pendaftaran->berkas as $b)
                <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                    <small>{{ $b->nama_berkas }}</small>
                    <a href="{{ asset('storage/'.$b->file_path) }}" target="_blank" class="btn btn-xs btn-outline-primary" style="font-size:11px;padding:2px 8px">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                </li>
                @empty
                <li class="list-group-item text-muted small py-3 text-center">Tidak ada berkas.</li>
                @endforelse
            </ul>
        </div>

        <div class="card mt-4">
    <div class="card-header">
        <i class="fa-solid fa-award me-2 text-primary"></i>
        <strong>Sertifikat Capaian Unggulan</strong>
    </div>

    <div class="card-body p-3">

        @forelse($pendaftaran->portofolios as $porto)

        <div class="card shadow-sm border-0 mb-3 rounded-3">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">

                    <div>
                        <h6 class="fw-bold mb-2">
                            {{ $porto->nama_prestasi }}
                        </h6>

                        <table class="table table-borderless table-sm mb-0">
                            <tr>
                                <td width="120">Jenjang</td>
                                <td>: {{ $porto->kategori_jenjang }}</td>
                            </tr>

                            <tr>
                                <td>Kategori CU</td>
                                <td>: {{ $porto->rubrikCu->wujud_capaian_unggulan ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td>Tempat</td>
                                <td>: {{ $porto->tempat }}</td>
                            </tr>

                            <tr>
                                <td>Tanggal</td>
                                <td>: {{ \Carbon\Carbon::parse($porto->tanggal_pelaksanaan)->format('d M Y') }}</td>
                            </tr>

                            <tr>
                                <td>Status</td>
                                <td>
                                    :
                                    <span class="badge bg-success">
                                        {{ $porto->status_validasi }}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        @if($porto->skor_rekomendasi)
                        <span class="badge bg-info mt-2">
                            Skor {{ $porto->skor_rekomendasi }}
                        </span>
                        @endif
                    </div>

                    <div>
                        <a href="{{ asset('storage/'.$porto->file_path) }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>

                </div>

            </div>
        </div>

        @empty

        <div class="text-center text-muted py-3">
            Belum ada sertifikat capaian unggulan.
        </div>

        @endforelse

    </div>
</div>

    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-star me-2 text-warning"></i> Form Penilaian Pilmapres</div>
            <div class="card-body">
                <form action="{{ route('juri.penilaian.store', $pendaftaran) }}" method="POST">
                    @csrf

                    <ul class="nav nav-tabs mb-4" id="penilaianTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="cu-berkas-tab" data-bs-toggle="tab" data-bs-target="#cuberkas" type="button" role="tab">CU Berkas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cu-wawancara-tab" data-bs-toggle="tab" data-bs-target="#cuwawancara" type="button" role="tab">CU Wawancara</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="naskah-tab" data-bs-toggle="tab" data-bs-target="#naskah" type="button" role="tab">Naskah GK</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="presentasi-tab" data-bs-toggle="tab" data-bs-target="#presentasi" type="button" role="tab">Presentasi GK</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="inggris-tab" data-bs-toggle="tab" data-bs-target="#inggris" type="button" role="tab">B. Inggris</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2" id="penilaianTabsContent">
                        <!-- Capaian Unggulan Berkas -->
                        <div class="tab-pane fade show active" id="cuberkas" role="tabpanel">
                            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-medal me-1"></i> Validasi Skor Capaian Unggulan Berkas (A01)</h6>
                            <div class="alert alert-info small mb-4">Validasi skor rekomendasi capaian unggulan yang telah diverifikasi oleh admin.</div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Skor Akhir Capaian Unggulan Berkas (A01) - Skala 60-100</label>
                                <div class="input-group">
                                    <input type="number" name="nilai_a01" class="form-control form-control-lg" value="{{ $existing_a01 ?? ($total_rekomendasi < 60 ? 60 : $total_rekomendasi) }}" min="60" max="100" required>
                                    <span class="input-group-text bg-light fw-semibold">/ 100</span>
                                </div>
                                <div class="form-text">Rekomendasi skor berdasarkan sertifikat tervalidasi admin: <strong class="text-success">{{ $total_rekomendasi }}</strong>. Silakan sesuaikan atau konfirmasi (Skala: 60 - 100).</div>
                            </div>
                        </div>

                        <!-- Capaian Unggulan Wawancara -->
                        <div class="tab-pane fade" id="cuwawancara" role="tabpanel">
                            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-microphone me-1"></i> Penilaian Wawancara Capaian Unggulan (F01)</h6>
                            <div class="alert alert-info small mb-4">Berikan nilai untuk masing-masing kriteria dengan skala 60 - 100.</div>
                            @foreach($rubrik_wawancara_cu as $k)
                                <div class="mb-3 row align-items-center">
                                    <label class="col-sm-8 col-form-label small">
                                        {{ $k->kriteria_penilaian }}
                                        <span class="badge bg-secondary ms-1">Bobot: {{ $k->bobot }}%</span>
                                    </label>
                                    <div class="col-sm-4">
                                        <input type="number" name="wawancara_cu[{{ $k->id }}]" class="form-control form-control-sm"
                                            value="{{ $penilaian_wawancara_cu[$k->id] ?? '' }}" min="60" max="100" placeholder="Skala 60-100" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Naskah GK -->
                        <div class="tab-pane fade" id="naskah" role="tabpanel">
                            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-file-alt me-1"></i> Penilaian Naskah GK</h6>
                            <div class="alert alert-info small mb-4">Berikan nilai untuk masing-masing kriteria dengan skala 60 - 100.</div>
                            @foreach($rubrik_naskah->groupBy('aspek_penilaian') as $aspek => $items)
                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark border-bottom pb-1">{{ $aspek }}</h6>
                                    @foreach($items as $k)
                                        <div class="mb-2 row align-items-center">
                                            <label class="col-sm-8 col-form-label small">
                                                {{ $k->kriteria_penilaian }}
                                                <span class="badge bg-secondary ms-1">Bobot: {{ $k->bobot }}%</span>
                                            </label>
                                            <div class="col-sm-4">
                                                <input type="number" name="naskah[{{ $k->id }}]" class="form-control form-control-sm"
                                                    value="{{ $penilaian_naskah[$k->id] ?? '' }}" min="60" max="100" placeholder="Skala 60-100" required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <!-- Presentasi GK -->
                        <div class="tab-pane fade" id="presentasi" role="tabpanel">
                            <h6 class="fw-bold text-success mb-3"><i class="fa-solid fa-chalkboard-user me-1"></i> Penilaian Presentasi GK</h6>
                            <div class="alert alert-info small mb-4">Berikan nilai untuk masing-masing kriteria dengan skala 60 - 100.</div>
                            @foreach($rubrik_presentasi->groupBy('aspek_penilaian') as $aspek => $items)
                                <div class="mb-3">
                                    <h6 class="fw-bold text-dark border-bottom pb-1">{{ $aspek }}</h6>
                                    @foreach($items as $k)
                                        <div class="mb-2 row align-items-center">
                                            <label class="col-sm-8 col-form-label small">
                                                {{ $k->kriteria_penilaian }}
                                                <span class="badge bg-secondary ms-1">Bobot: {{ $k->bobot }}%</span>
                                            </label>
                                            <div class="col-sm-4">
                                                <input type="number" name="presentasi[{{ $k->id }}]" class="form-control form-control-sm"
                                                    value="{{ $penilaian_presentasi[$k->id] ?? '' }}" min="60" max="100" placeholder="Skala 60-100" required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <!-- Bahasa Inggris -->
                        <div class="tab-pane fade" id="inggris" role="tabpanel">
                            <h6 class="fw-bold text-warning mb-3"><i class="fa-solid fa-language me-1"></i> Penilaian Bahasa Inggris</h6>
                            <div class="alert alert-info small mb-4">Input skor berdasarkan kriteria range Excellent, Good, Fair, atau Poor.</div>
                            @foreach($rubrik_inggris as $k)
                                @php
                                    preg_match('/^[0-9]+/', $k->excellent_score, $matches);
                                    $max_score = isset($matches[0]) ? (int)$matches[0] : 100;
                                @endphp
                                <div class="mb-4 border p-3 rounded bg-light">
                                    <h6 class="fw-bold text-dark">{{ $k->field }}</h6>
                                    <div class="row small text-muted mb-2">
                                        <div class="col-3"><strong>Exc ({{ $k->excellent_score }}):</strong> <br>{{ $k->excellent_criteria }}</div>
                                        <div class="col-3"><strong>Good ({{ $k->good_score }}):</strong> <br>{{ $k->good_criteria }}</div>
                                        <div class="col-3"><strong>Fair ({{ $k->fair_score }}):</strong> <br>{{ $k->fair_criteria }}</div>
                                        <div class="col-3"><strong>Poor ({{ $k->poor_score }}):</strong> <br>{{ $k->poor_criteria }}</div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <label class="col-sm-8 col-form-label fw-bold text-end">Input Skor Final untuk Field ini:</label>
                                        <div class="col-sm-4">
                                            <input type="number" name="inggris[{{ $k->id }}]" class="form-control"
                                                value="{{ $penilaian_inggris[$k->id] ?? '' }}" min="0" max="{{ $max_score }}" placeholder="0-{{ $max_score }}" required>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr>
                    <button type="submit" class="btn btn-success w-100 mt-2">
                        <i class="fa-solid fa-save me-2"></i> Simpan Penilaian
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
