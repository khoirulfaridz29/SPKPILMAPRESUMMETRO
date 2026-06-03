@extends('layouts.dashboard')
@section('title', 'Validasi Laporan Tahap I')

@section('content')
<h4 class="fw-bold mb-4">Validasi Laporan Rekap Berkas (Tahap I)</h4>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Peserta</th>
                    <th>NIM</th>
                    <th class="text-center">Jumlah Berkas</th>
                    <th class="text-center">Status Laporan</th>
                    <th class="text-center">Tgl Validasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekaps as $i => $r)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $r->pendaftaran->mahasiswa->user->nama_lengkap }}</td>
                    <td><code>{{ $r->pendaftaran->mahasiswa->nim }}</code></td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark">{{ $r->pendaftaran->berkas->count() }} berkas</span>
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $r->status_laporan === 'Divalidasi' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $r->status_laporan }}
                        </span>
                    </td>
                    <td class="text-center text-muted small">
                        {{ $r->tanggal_validasi ? \Carbon\Carbon::parse($r->tanggal_validasi)->format('d M Y H:i') : '-' }}
                    </td>
                    <td class="text-center">
                        @if($r->status_laporan === 'Pending')
                        <form action="{{ route('wr3.validasi.approve', $r) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Validasi laporan ini?')">
                            @csrf
                            <button class="btn btn-sm btn-success">
                                <i class="fa-solid fa-check me-1"></i> Validasi
                            </button>
                        </form>
                        @else
                        <span class="text-success small"><i class="fa-solid fa-check-circle"></i> Sudah Divalidasi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada rekap untuk divalidasi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
