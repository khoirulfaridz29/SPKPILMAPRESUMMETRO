@extends('layouts.dashboard')
@section('title', 'Perhitungan GAP')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Rekap Nilai Peserta</h4>
    <div class="d-flex gap-2">
        <form action="{{ route('admin.perhitungan.proses') }}" method="POST"
            onsubmit="return confirm('Proses perhitungan GAP sekarang?')">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-calculator me-2"></i> Hitung GAP & Rangking
            </button>
        </form>
        <a href="{{ route('admin.perhitungan.hasil') }}" class="btn btn-primary">
            <i class="fa-solid fa-trophy me-2"></i> Lihat Hasil
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Peserta</th>
                    <th>NIM</th>
                    <th class="text-center">Jumlah Penilaian Juri</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesertaLolos as $i => $p)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $p->mahasiswa->user->nama_lengkap }}</td>
                    <td><code>{{ $p->mahasiswa->nim }}</code></td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark">{{ $p->penilaian->count() }} penilaian</span>
                    </td>
                    <td class="text-center">
                        @if($p->hasil)
                            <span class="badge bg-success">Sudah Dihitung</span>
                        @else
                            <span class="badge bg-warning text-dark">Belum Dihitung</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada peserta lolos tahap I.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
