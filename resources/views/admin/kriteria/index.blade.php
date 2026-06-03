@extends('layouts.dashboard')
@section('title', 'Kriteria Penilaian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Kriteria Penilaian</h4>
    <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i> Tambah Kriteria
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Tahap Seleksi</th>
                    <th>Tipe Faktor (CF/SF)</th>
                    <th>Nilai Target</th>
                    <th>Bobot (%)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriterias as $i => $k)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td><code class="bg-light px-2 py-1 rounded">{{ $k->kode_kriteria }}</code></td>
                    <td class="fw-semibold">{{ $k->nama_kriteria }}</td>
                    <td>
                        <span class="badge {{ $k->jenis_faktor === 'Tahap Awal' ? 'bg-primary' : 'bg-info text-dark' }}">
                            {{ $k->jenis_faktor }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ ($k->tipe_faktor ?? 'Core Factor') === 'Core Factor' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $k->tipe_faktor ?? 'Core Factor' }}
                        </span>
                    </td>
                    <td>{{ $k->nilai_target }}</td>
                    <td>{{ $k->bobot }}%</td>
                    <td class="text-center">
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
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada data kriteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
