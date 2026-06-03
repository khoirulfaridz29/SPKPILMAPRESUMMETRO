@extends('layouts.dashboard')
@section('title', 'Upload Berkas & Portofolio')

@section('content')
<h4 class="fw-bold mb-4">Upload Berkas & Portofolio</h4>

@if(!$pendaftaran->is_submitted)
<div class="alert alert-warning d-flex flex-column flex-md-row justify-content-between align-items-md-center shadow-sm rounded-4 p-3 mb-4 gap-3">
    <div class="d-flex align-items-center gap-3">
        <div class="fs-3 text-warning"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div>
            <div class="fw-bold text-dark">Pendaftaran Anda Masih Berstatus DRAFT!</div>
            <div class="small text-muted">Berkas Anda baru sekadar disimpan. Anda <strong>WAJIB</strong> mengirimkan pendaftaran secara final agar dapat divalidasi oleh Admin.</div>
        </div>
    </div>
    <form action="{{ route('mahasiswa.pendaftaran.submit') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold shadow-sm" onclick="return confirm('Kirim pendaftaran secara final? Data tidak dapat diubah lagi setelah dikirim.')">
            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pendaftaran Sekarang
        </button>
    </form>
</div>
@else
<div class="alert alert-success d-flex align-items-center gap-3 shadow-sm rounded-4 p-3 mb-4">
    <div class="fs-3 text-success"><i class="fa-solid fa-circle-check"></i></div>
    <div>
        <div class="fw-bold text-dark">Pendaftaran Anda Telah Dikirim Secara Final!</div>
        <div class="small text-muted">Seluruh berkas Anda sudah terkunci dan sedang dalam tahap verifikasi oleh tim Kemahasiswaan (Admin). Terima kasih!</div>
    </div>
</div>
@endif

@if($pendaftaran->status_berkas === 'Lengkap')
<div class="alert alert-success mb-4 shadow-sm rounded-4 p-3 d-flex align-items-center gap-2">
    <i class="fa-solid fa-circle-check me-1 fs-5 text-success"></i>
    <div><strong>Berkas Dinyatakan Lengkap:</strong> Dokumen Anda telah disetujui sepenuhnya oleh Admin. Silakan tunggu pengumuman kelulusan Tahap I.</div>
</div>
@endif

<!-- Nav Tabs -->
<ul class="nav nav-pills mb-4 gap-2" id="berkasTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $activeTab === 'dokumen' ? 'active' : '' }}" id="dokumen-tab" data-bs-toggle="tab" data-bs-target="#dokumen" type="button" role="tab">
        <i class="fa-solid fa-file-lines me-2"></i> Page 1: Dok. Pendukung
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $activeTab === 'portofolio' ? 'active' : '' }}" id="portofolio-tab" data-bs-toggle="tab" data-bs-target="#portofolio" type="button" role="tab">
        <i class="fa-solid fa-medal me-2"></i> Page 2: Portofolio CU
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $activeTab === 'gagasan' ? 'active' : '' }}" id="gagasan-tab" data-bs-toggle="tab" data-bs-target="#gagasan" type="button" role="tab">
        <i class="fa-solid fa-lightbulb me-2"></i> Page 3: Gagasan Kreatif
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link {{ $activeTab === 'video_bi' ? 'active' : '' }}" id="video_bi-tab" data-bs-toggle="tab" data-bs-target="#video_bi" type="button" role="tab">
        <i class="fa-solid fa-video me-2"></i> Page 4: Video BI
    </button>
  </li>
</ul>

<div class="tab-content" id="berkasTabContent">
  
  <!-- TAB 1: Dokumen Pendukung -->
  <div class="tab-pane fade {{ $activeTab === 'dokumen' ? 'show active' : '' }}" id="dokumen" role="tabpanel">
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary text-white"><i class="fa-solid fa-upload me-2"></i> Upload Dokumen Pendukung</div>
                <div class="card-body">
                    <form action="{{ route('mahasiswa.berkas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tab" value="dokumen">
                        <div class="mb-3">
                            <label class="form-label">Jenis Dokumen</label>
                            <select name="nama_berkas" class="form-select" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="KTP">KTP</option>
                                <option value="KTM">KTM</option>
                                <option value="Transkrip Nilai">Transkrip Nilai</option>
                                <option value="Surat Pengantar Fakultas">Surat Pengantar Fakultas</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">File <small class="text-muted">(PDF/JPG/PNG - Max 5MB)</small></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.png" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" {{ $pendaftaran->is_submitted ? 'disabled' : '' }}>Simpan Dokumen</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-light fw-bold">Dokumen Terupload</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light"><tr><th class="ps-3">Nama Berkas</th><th class="text-center">Status</th><th class="text-center">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($berkass->whereIn('nama_berkas', ['KTP', 'KTM', 'Transkrip Nilai', 'Surat Pengantar Fakultas']) as $b)
                            <tr>
                                <td class="ps-3 fw-semibold">{{ $b->nama_berkas }}</td>
                                <td class="text-center"><span class="badge bg-secondary">{{ $b->status_validasi }}</span></td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $b->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                    @if(!$pendaftaran->is_submitted)
                                    <form action="{{ route('mahasiswa.berkas.destroy', $b) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada dokumen pendukung.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- TAB 2: Portofolio CU -->
  <div class="tab-pane fade {{ $activeTab === 'portofolio' ? 'show active' : '' }}" id="portofolio" role="tabpanel">
    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white"><i class="fa-solid fa-medal me-2"></i> Tambah Portofolio CU</div>
                <div class="card-body">
                    <form action="{{ route('mahasiswa.berkas.portofolio.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Capaian Unggulan (Berdasarkan Rubrik)</label>
                            <select name="rubrik_cu_id" class="form-select" required>
                                <option value="">-- Pilih Capaian --</option>
                                @foreach($rubriks as $r)
                                    <option value="{{ $r->id }}">{{ $r->bidang }} - {{ $r->wujud_capaian_unggulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori / Jenjang</label>
                            <select name="kategori_jenjang" class="form-select" required>
                                <option value="">-- Pilih Jenjang --</option>
                                <option value="Internasional">Internasional</option>
                                <option value="Regional">Regional</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Kab/Kota/PT">Kabupaten/Kota/PT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Prestasi/Kegiatan</label>
                            <input type="text" name="nama_prestasi" class="form-control" required placeholder="Contoh: Juara 1 Lomba Web Design">
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label">Tempat Pelaksanaan</label>
                                <input type="text" name="tempat" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal_pelaksanaan" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">File Sertifikat / Bukti <small class="text-muted">(PDF/JPG/PNG)</small></label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.png" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" {{ $pendaftaran->is_submitted ? 'disabled' : '' }}>Simpan Portofolio</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-light fw-bold">Daftar Sertifikat Terupload</div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light"><tr><th class="ps-3">Prestasi</th><th>Jenjang</th><th class="text-center">Aksi</th></tr></thead>
                        <tbody>
                            @forelse($portofolios as $porto)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold">{{ $porto->nama_prestasi }}</div>
                                    <div class="small text-muted">{{ $porto->rubrikCu->wujud_capaian_unggulan }}</div>
                                    @if($porto->status_validasi === 'Valid' && $porto->skor_rekomendasi)
                                        <div class="mt-1"><span class="badge bg-success">Skor Rekomendasi: {{ $porto->skor_rekomendasi }}</span></div>
                                    @endif
                                </td>
                                <td><span class="badge bg-info text-dark">{{ $porto->kategori_jenjang }}</span></td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $porto->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                    @if(!$pendaftaran->is_submitted)
                                    <form action="{{ route('mahasiswa.berkas.portofolio.destroy', $porto->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada portofolio CU.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- TAB 3: Gagasan Kreatif -->
  <div class="tab-pane fade {{ $activeTab === 'gagasan' ? 'show active' : '' }}" id="gagasan" role="tabpanel">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white"><i class="fa-solid fa-lightbulb me-2"></i> Upload Gagasan Kreatif</div>
                <div class="card-body text-center p-5">
                    @php 
                        $gk = $berkass->where('nama_berkas', 'Naskah Gagasan Kreatif')->first();
                    @endphp

                    @if($gk)
                        <i class="fa-solid fa-file-pdf fa-4x text-danger mb-3"></i>
                        <h5 class="fw-bold">Naskah Gagasan Kreatif Tersimpan</h5>
                        <p class="text-muted">Status Validasi: <span class="badge bg-secondary">{{ $gk->status_validasi }}</span></p>
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <a href="{{ asset('storage/' . $gk->file_path) }}" target="_blank" class="btn btn-primary"><i class="fa-solid fa-eye me-2"></i> Lihat File</a>
                            @if(!$pendaftaran->is_submitted)
                            <form action="{{ route('mahasiswa.berkas.destroy', $gk) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger"><i class="fa-solid fa-trash me-2"></i> Hapus & Re-upload</button>
                            </form>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('mahasiswa.berkas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tab" value="gagasan">
                            <input type="hidden" name="nama_berkas" value="Naskah Gagasan Kreatif">
                            <div class="mb-4 text-start">
                                <label class="form-label fw-bold">File Naskah GK (PDF - Max 5MB)</label>
                                <input type="file" name="file" class="form-control form-control-lg" accept=".pdf" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100" {{ $pendaftaran->is_submitted ? 'disabled' : '' }}>
                                <i class="fa-solid fa-upload me-2"></i> Simpan Gagasan Kreatif
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </div>
  
  <!-- TAB 4: Video Bahasa Inggris -->
  <div class="tab-pane fade {{ $activeTab === 'video_bi' ? 'show active' : '' }}" id="video_bi" role="tabpanel">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white"><i class="fa-solid fa-video me-2"></i> Upload Video Bahasa Inggris</div>
                <div class="card-body text-center p-5">
                    @php 
                        $video = $berkass->where('nama_berkas', 'Video Bahasa Inggris')->first();
                    @endphp

                    @if($video)
                        <i class="fa-solid fa-file-video fa-4x text-danger mb-3"></i>
                        <h5 class="fw-bold">Video Bahasa Inggris Tersimpan</h5>
                        <p class="text-muted">Status Validasi: <span class="badge bg-secondary">{{ $video->status_validasi }}</span></p>
                        <div class="d-flex justify-content-center gap-2 mt-4">
                            <a href="{{ asset('storage/' . $video->file_path) }}" target="_blank" class="btn btn-primary"><i class="fa-solid fa-play me-2"></i> Putar/Unduh Video</a>
                            @if(!$pendaftaran->is_submitted)
                            <form action="{{ route('mahasiswa.berkas.destroy', $video) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger"><i class="fa-solid fa-trash me-2"></i> Hapus & Re-upload</button>
                            </form>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('mahasiswa.berkas.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="tab" value="video_bi">
                            <input type="hidden" name="nama_berkas" value="Video Bahasa Inggris">
                            <div class="mb-4 text-start">
                                <label class="form-label fw-bold">File Video Bahasa Inggris (MP4 - Max 20MB)</label>
                                <input type="file" name="file" class="form-control form-control-lg" accept=".mp4" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg w-100" {{ $pendaftaran->is_submitted ? 'disabled' : '' }}>
                                <i class="fa-solid fa-upload me-2"></i> Simpan Video Bahasa Inggris
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </div>

</div>
@endsection
