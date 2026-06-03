@extends('layouts.dashboard')
@section('title', 'Detail Pendaftaran')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Detail Pendaftaran</span>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header"><i class="fa-solid fa-user me-2 text-primary"></i> Informasi Peserta</div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</td></tr>
                    <tr><td class="text-muted">NIM</td><td>{{ $pendaftaran->mahasiswa->nim }}</td></tr>
                    <tr><td class="text-muted">Prodi</td><td>{{ $pendaftaran->mahasiswa->program_studi }}</td></tr>
                    <tr><td class="text-muted">Tgl Daftar</td><td>{{ $pendaftaran->tanggal_daftar->format('d M Y') }}</td></tr>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-gears me-2 text-warning"></i> Aksi Verifikasi</div>
            <div class="card-body">
                @if(!$pendaftaran->is_submitted)
                    <div class="alert alert-secondary mb-0 shadow-sm">
                        <i class="fa-solid fa-file-pen me-2"></i> Pendaftaran masih berstatus <strong>Draft</strong> dan belum dikirim oleh mahasiswa.
                    </div>
                @else
                    <div class="d-flex flex-column gap-3">
                        <!-- 1. Validasi Kelengkapan Berkas -->
                        <div class="p-3 border rounded-3 bg-light shadow-sm">
                            <h6 class="fw-bold mb-2 text-secondary">1. Validasi Kelengkapan Berkas</h6>
                            @if($pendaftaran->status_berkas === 'Lengkap')
                                <div class="alert alert-success py-2 px-3 mb-0 d-flex align-items-center gap-2 border-0">
                                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                    <div class="fw-bold text-success small">Berkas Sudah Dinyatakan Lengkap</div>
                                </div>
                            @else
                                <form action="{{ route('admin.pendaftaran.verifikasi', $pendaftaran) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 shadow-sm fw-bold" onclick="return confirm('Nyatakan berkas pendaftaran lengkap?')">
                                        <i class="fa-solid fa-check-double me-1"></i> Nyatakan Berkas Lengkap
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- 2. Kelulusan Tahap I -->
                        <div class="p-3 border rounded-3 bg-light shadow-sm">
                            <h6 class="fw-bold mb-2 text-secondary">2. Kelulusan Tahap I (Seleksi Berkas)</h6>
                            @if($pendaftaran->status_seleksi !== 'Lolos Tahap 1')
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.rekap.lolos', $pendaftaran) }}" method="POST" class="flex-fill m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100 shadow-sm fw-bold"
                                            onclick="return confirm('Loloskan peserta ini ke Tahap I?')">
                                            <i class="fa-solid fa-check me-1"></i> Loloskan Tahap I
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.rekap.tidakLolos', $pendaftaran) }}" method="POST" class="flex-fill m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-danger w-100 shadow-sm fw-bold"
                                            onclick="return confirm('Tolak peserta ini?')">
                                            <i class="fa-solid fa-times me-1"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-success py-2 px-3 mb-0 d-flex align-items-center gap-2 border-0">
                                    <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                    <div class="fw-bold text-success small">Peserta Lolos Tahap I</div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <!-- Dokumen Pendukung & Naskah -->
        <div class="card mb-4">
            <div class="card-header bg-white fw-bold"><i class="fa-solid fa-folder-open me-2 text-success"></i> Berkas Diunggah ({{ $pendaftaran->berkas->count() }})</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama Berkas</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran->berkas as $b)
                        <tr>
                            <td class="ps-4 fw-semibold text-wrap">{{ $b->nama_berkas }}</td>
                            <td>
                                <span class="badge {{ $b->status_validasi === 'Valid' ? 'bg-success' : ($b->status_validasi === 'Tidak Valid' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $b->status_validasi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ asset('storage/' . $b->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat/Unduh">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    @if($pendaftaran->is_submitted)
                                    <form action="{{ route('admin.pendaftaran.berkas.validasi', $b) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Valid">
                                        <button class="btn btn-sm btn-success" title="Tandai Valid"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                    <form action="{{ route('admin.pendaftaran.berkas.validasi', $b) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Tidak Valid">
                                        <button class="btn btn-sm btn-danger" title="Tandai Tidak Valid"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-muted text-wrap">Belum ada berkas diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Portofolio Capaian Unggulan (CU) -->
        <div class="card">
            <div class="card-header bg-white fw-bold"><i class="fa-solid fa-medal me-2 text-warning"></i> Portofolio Capaian Unggulan ({{ $pendaftaran->portofolios->count() }})</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Prestasi / Bidang</th>
                            <th>Rekomendasi Skor</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 250px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran->portofolios as $porto)
                        <tr>
                            <td class="ps-4 text-wrap">
                                <div class="fw-bold">{{ $porto->nama_prestasi }}</div>
                                <small class="text-muted">{{ $porto->rubrikCu->wujud_capaian_unggulan }} ({{ $porto->kategori_jenjang }})</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark fw-bold">{{ $porto->skor_rekomendasi ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $porto->status_validasi === 'Valid' ? 'bg-success' : ($porto->status_validasi === 'Tidak Valid' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $porto->status_validasi }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ asset('storage/' . $porto->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary" title="Lihat/Unduh">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                    @if($pendaftaran->is_submitted)
                                    <form action="{{ route('admin.pendaftaran.portofolio.validasi', $porto) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Valid">
                                        <button class="btn btn-sm btn-success" title="Tandai Valid"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                    <form action="{{ route('admin.pendaftaran.portofolio.validasi', $porto) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="Tidak Valid">
                                        <button class="btn btn-sm btn-danger" title="Tandai Tidak Valid"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted text-wrap">Belum ada portofolio CU diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
