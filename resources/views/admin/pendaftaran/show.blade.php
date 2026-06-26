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
        <div class="card border-0 shadow-sm mb-4" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-user me-2 text-primary"></i> Informasi Peserta</h6>
            </div>
            <div class="card-body pt-2 px-3 pb-3">
                <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem;width:80px">Nama</td>
                        <td style="padding:0.45rem 0;font-weight:600">{{ $pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">NPM</td>
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">{{ $pendaftaran->mahasiswa->nim }}</td>
                    </tr>
                    <tr style="border-bottom:1px solid #f3f4f6">
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">Prodi</td>
                        <td style="padding:0.45rem 0;font-size:0.8rem">{{ $pendaftaran->mahasiswa->program_studi }}</td>
                    </tr>
                    <tr>
                        <td style="padding:0.45rem 0;color:#6b7280;font-size:0.72rem">Tgl Daftar</td>
                        <td style="padding:0.45rem 0;font-size:0.8rem">{{ $pendaftaran->tanggal_daftar->format('d M Y') }}</td>
                    </tr>
                </table>
                </div>
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
                            <h6 class="fw-bold mb-2 text-secondary"><i class="fa-solid fa-check-double me-1"></i> Validasi Kelengkapan Berkas</h6>
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

                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <!-- Dokumen Pendukung & Naskah -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-folder-open me-2 text-success"></i> Berkas Diunggah ({{ $pendaftaran->berkas->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                <th style="padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Nama Berkas</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status</th>
                                <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;width:220px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftaran->berkas as $b)
                            <tr style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:0.7rem 0 0.7rem 1rem;font-weight:600">{{ $b->nama_berkas }}</td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    @if($b->status_validasi === 'Valid')
                                        <span style="background:#e6f7ee;color:#10b981;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Valid</span>
                                    @elseif($b->status_validasi === 'Tidak Valid')
                                        <span style="background:#fee2e2;color:#ef4444;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Tidak Valid</span>
                                    @else
                                        <span style="background:#fef3c7;color:#f59e0b;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $b->status_validasi }}</span>
                                    @endif
                                </td>
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="javascript:void(0)" class="view-berkas" style="background:none;border:1px solid #d1d5db;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;color:#6b7280;cursor:pointer;text-decoration:none" title="Lihat" data-url="{{ route('admin.pendaftaran.berkas.lihat', $b) }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if($pendaftaran->is_submitted)
                                        <form action="{{ route('admin.pendaftaran.berkas.validasi', $b) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Valid">
                                            <button style="background:#e6f7ee;color:#10b981;border:1px solid #10b981;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;cursor:pointer" title="Tandai Valid"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('admin.pendaftaran.berkas.validasi', $b) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Tidak Valid">
                                            <button style="background:#fee2e2;color:#ef4444;border:1px solid #ef4444;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;cursor:pointer" title="Tandai Tidak Valid"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada berkas diunggah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Portofolio Capaian Unggulan (CU) -->
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-header bg-transparent border-0 pt-3 px-3 pb-0">
                <h6 class="fw-bold mb-0 small"><i class="fa-solid fa-medal me-2 text-warning"></i> Portofolio Capaian Unggulan ({{ $pendaftaran->portofolios->count() }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                        <thead>
                            <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                                <th style="padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">Prestasi / Bidang</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Rek. Skor</th>
                                <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status</th>
                                <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;width:200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftaran->portofolios as $porto)
                            <tr style="border-bottom:1px solid #f3f4f6">
                                <td style="padding:0.7rem 0 0.7rem 1rem">
                                    <div style="font-weight:600;font-size:0.82rem">{{ $porto->nama_prestasi }}</div>
                                    <div style="color:#9ca3af;font-size:0.7rem">{{ $porto->rubrikCu->wujud_capaian_unggulan }} ({{ $porto->kategori_jenjang }})</div>
                                </td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    <span style="background:#f3f4f6;color:#374151;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $porto->skor_rekomendasi ?? '-' }}</span>
                                </td>
                                <td style="padding:0.7rem 0;text-align:center">
                                    @if($porto->status_validasi === 'Valid')
                                        <span style="background:#e6f7ee;color:#10b981;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Valid</span>
                                    @elseif($porto->status_validasi === 'Tidak Valid')
                                        <span style="background:#fee2e2;color:#ef4444;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">Tidak Valid</span>
                                    @else
                                        <span style="background:#fef3c7;color:#f59e0b;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">{{ $porto->status_validasi }}</span>
                                    @endif
                                </td>
                                <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="javascript:void(0)" class="view-berkas" style="background:none;border:1px solid #d1d5db;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;color:#6b7280;cursor:pointer;text-decoration:none" title="Lihat" data-url="{{ route('admin.pendaftaran.portofolio.lihat', $porto) }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if($pendaftaran->is_submitted)
                                        <form action="{{ route('admin.pendaftaran.portofolio.validasi', $porto) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Valid">
                                            <button style="background:#e6f7ee;color:#10b981;border:1px solid #10b981;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;cursor:pointer" title="Tandai Valid"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('admin.pendaftaran.portofolio.validasi', $porto) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="Tidak Valid">
                                            <button style="background:#fee2e2;color:#ef4444;border:1px solid #ef4444;border-radius:6px;padding:0.2rem 0.5rem;font-size:0.75rem;cursor:pointer" title="Tandai Tidak Valid"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="padding:2rem;text-align:center;color:#9ca3af">Belum ada portofolio CU diunggah.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Lihat Berkas --}}
<div class="modal fade" id="berkasModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius);border:none">
            <div class="modal-header border-0 pb-0">
                <h6 class="fw-bold mb-0"><i class="fa-solid fa-file me-2 text-primary"></i>Dokumen Peserta</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 text-center bg-light">
                <iframe id="berkasIframe" src="" style="width:100%;height:60vh;border:none;border-radius:var(--radius-sm)"></iframe>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.view-berkas').forEach(function(btn) {
    btn.addEventListener('click', function() {
        document.getElementById('berkasIframe').src = this.dataset.url;
        new bootstrap.Modal('#berkasModal').show();
    });
});
document.getElementById('berkasModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('berkasIframe').src = '';
});
</script>
@endpush

@endsection
