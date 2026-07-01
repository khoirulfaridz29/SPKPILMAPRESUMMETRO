@extends('layouts.dashboard')
@section('title', 'Kriteria Penilaian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Kriteria Penilaian</h4>
    <a href="{{ route('admin.kriteria.create', request()->only('jenjang_id')) }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Kriteria
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius:var(--radius)">
    <div class="card-body pb-0">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small mb-1">Filter Jenjang</label>
                <select name="jenjang_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ request('jenjang_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
            <thead>
                <tr style="border-bottom:1px solid #e5e7eb;background:#f9fafb">
                    <th style="width:40px;padding:0.6rem 0 0.6rem 1rem;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem">#</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Kode</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nama Kriteria</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Jenjang</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Tahap Seleksi</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Tipe Faktor (CF/SF)</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Nilai Target</th>
                    <th style="padding:0.6rem 0;text-align:left;font-weight:600;color:#6b7280;font-size:0.72rem;white-space:nowrap">Bobot (%)</th>
                    <th style="width:64px;padding:0.6rem 0.5rem 0.6rem 0;text-align:center;font-weight:600;color:#6b7280;font-size:0.72rem">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriterias as $i => $k)
                <tr style="border-bottom:1px solid #f3f4f6">
                    <td style="padding:0.7rem 0 0.7rem 1rem;color:#9ca3af;font-size:0.75rem">{{ $i + 1 }}</td>
                    <td style="padding:0.7rem 0"><code class="bg-light px-2 py-1 rounded">{{ $k->kode_kriteria }}</code></td>
                    <td style="padding:0.7rem 0;font-weight:600;white-space:nowrap">{{ $k->nama_kriteria }}</td>
                    <td style="padding:0.7rem 0"><span class="badge bg-secondary">{{ $k->jenjang->nama_jenjang ?? '-' }}</span></td>
                    <td style="padding:0.7rem 0">
                        <span class="badge {{ $k->jenis_faktor === 'Tahap Awal' ? 'bg-primary' : 'bg-info text-dark' }}">
                            {{ $k->jenis_faktor }}
                        </span>
                    </td>
                    <td style="padding:0.7rem 0">
                        <span class="badge {{ ($k->tipe_faktor ?? 'Core Factor') === 'Core Factor' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $k->tipe_faktor ?? 'Core Factor' }}
                        </span>
                    </td>
                    <td style="padding:0.7rem 0">{{ $k->nilai_target }}</td>
                    <td style="padding:0.7rem 0">{{ $k->bobot }}%</td>
                    <td style="padding:0.7rem 0.5rem 0.7rem 0;text-align:center">
                        <a href="{{ route('admin.kriteria.edit', $k) }}" class="btn btn-sm btn-outline-secondary me-1">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <form action="{{ route('admin.kriteria.destroy', $k) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Hapus kriteria ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding:2rem;text-align:center;color:#9ca3af">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada data kriteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>
@endsection
