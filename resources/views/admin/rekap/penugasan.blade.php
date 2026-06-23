@extends('layouts.dashboard')
@section('title', 'Penugasan Juri')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rekap.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Penugasan Juri</span>
</div>

<div class="row g-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-gavel me-2"></i> Daftar Penugasan Juri</span>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="fa-solid fa-plus me-1"></i> Tambah Penugasan
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                    <thead>
                        <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                            <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                            <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Juri / NIDN</th>
                            <th style="padding:0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Peserta Yang Dinilai</th>
                            <th style="padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Status Penugasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penugasanPerJuri as $pj)
                        <tr style="border-bottom:0" class="penugasan-row">
                            <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem;vertical-align:middle">{{ $loop->iteration }}</td>
                            <td style="padding:0.7rem 0;vertical-align:middle">
                                <div style="font-weight:600">{{ $pj['juri']->nama_lengkap }}</div>
                                <div style="font-size:0.72rem;color:#6b7280"><code>{{ $pj['juri']->nidn ?? '-' }}</code></div>
                            </td>
                            <td style="padding:0.7rem 0;text-align:center;vertical-align:middle">
                                <button type="button" class="btn btn-sm btn-outline-info table-action-btn"
                                    data-bs-toggle="collapse" data-bs-target="#pesertaCollapse{{ $pj['juri']->id }}">
                                    <i class="fa-solid fa-users me-1"></i> {{ $pj['total'] }} Peserta
                                </button>
                            </td>
                            <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center;vertical-align:middle">
                                @if($pj['total'] > 0)
                                    <span style="background:#e6f7ee;color:#10b981;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">
                                        <i class="fa-solid fa-check-circle me-1"></i> Ditugaskan
                                    </span>
                                @else
                                    <span style="background:#f3f4f6;color:#9ca3af;border-radius:var(--radius-sm);padding:0.2rem 0.6rem;font-size:0.72rem;font-weight:600">
                                        <i class="fa-solid fa-minus-circle me-1"></i> Belum Ditugaskan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr id="pesertaCollapse{{ $pj['juri']->id }}" class="collapse" data-bs-parent=".penugasan-row">
                            <td colspan="4" style="padding:0;border-bottom:1px solid #f3f4f6">
                                <div style="padding:0.75rem 1rem 0.75rem 3rem;background:#fafbfc">
                                    @if($pj['total'] > 0)
                                    <div class="table-responsive">
                                    <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.8rem">
                                        <thead>
                                            <tr style="border-bottom:1px solid #e5e7eb">
                                                <th style="padding:0.4rem 0;font-weight:600;color:#6b7280;font-size:0.7rem;width:40%">Nama Mahasiswa</th>
                                                <th style="padding:0.4rem 0;font-weight:600;color:#6b7280;font-size:0.7rem;width:30%">NPM</th>
                                                <th style="padding:0.4rem 0.5rem 0.4rem 0;font-weight:600;color:#6b7280;font-size:0.7rem;width:30%">Tingkatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pj['peserta'] as $pg)
                                            <tr style="border-bottom:1px solid #f3f4f6">
                                                <td style="padding:0.4rem 0;font-weight:500">{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                                                <td style="padding:0.4rem 0;color:#6b7280">{{ $pg->pendaftaran->mahasiswa->nim }}</td>
                                                <td style="padding:0.4rem 0.5rem 0.4rem 0">{{ $pg->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                    @else
                                    <p class="text-muted small text-center mb-0 py-2">
                                        <i class="fa-solid fa-inbox me-1"></i> Belum ada peserta.
                                    </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding:2rem;text-align:center;color:#9ca3af">
                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada juri.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Penugasan --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:var(--radius);border:none">
            <form action="{{ route('admin.rekap.penugasan.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h6 class="fw-bold mb-0"><i class="fa-solid fa-plus-circle me-2 text-primary"></i> Tambah Penugasan Juri</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Juri</label>
                        <select name="juri_id" class="form-select" required>
                            <option value="">-- Pilih Juri --</option>
                            @foreach($juris as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_lengkap }} ({{ $j->nidn ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Pilih Peserta</label>
                        <div style="max-height:240px;overflow-y:auto;border:1px solid #e5e7eb;border-radius:var(--radius-sm);padding:.5rem">
                            @forelse($pesertaLolos as $p)
                            <div class="form-check py-1" style="border-bottom:1px solid #f3f4f6">
                                <input class="form-check-input" type="checkbox" name="pendaftaran_id[]" value="{{ $p->id }}" id="peserta{{ $p->id }}">
                                <label class="form-check-label small" for="peserta{{ $p->id }}">
                                    <strong>{{ $p->mahasiswa->user->nama_lengkap }}</strong>
                                    <span class="text-muted">({{ $p->mahasiswa->nim }})</span>
                                    <span class="badge bg-secondary ms-1" style="font-size:.65rem">{{ $p->mahasiswa->jenjang->nama_jenjang ?? '-' }}</span>
                                </label>
                            </div>
                            @empty
                            <p class="text-muted small text-center mb-0 py-2">Tidak ada peserta lolos tahap I.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection