@extends('layouts.dashboard')
@section('title', 'Rekap Nilai')

@section('content')
<h4 class="fw-bold mb-4">Rekap Nilai Penilaian Saya</h4>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Peserta</th>
                    <th>NIM</th>
                    <th class="text-center">Jumlah Kriteria Dinilai</th>
                    <th class="text-center">Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penugasans as $i => $pg)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $pg->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    <td><code>{{ $pg->pendaftaran->mahasiswa->nim }}</code></td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark">
                            {{ $pg->pendaftaran->penilaian->where('juri_id', Auth::id())->count() }} kriteria
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('juri.penilaian.show', $pg->pendaftaran_id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-eye me-1"></i> Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada penilaian.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
