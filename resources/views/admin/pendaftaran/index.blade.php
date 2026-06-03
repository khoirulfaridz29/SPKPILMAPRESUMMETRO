@extends('layouts.dashboard')
@section('title', 'Pendaftaran & Berkas')

@section('content')
<h4 class="fw-bold mb-4">Daftar Pendaftaran Peserta</h4>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">#</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Tgl Daftar</th>
                    <th>Status Berkas</th>
                    <th>Status Seleksi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $i => $p)
                <tr>
                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                    <td class="fw-semibold">{{ $p->mahasiswa->user->nama_lengkap }}</td>
                    <td><code>{{ $p->mahasiswa->nim }}</code></td>
                    <td class="text-muted small">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                    <td>
                        @if(!$p->is_submitted)
                            <span class="badge bg-secondary">Draft</span>
                        @else
                            <span class="badge {{ $p->status_berkas === 'Lengkap' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $p->status_berkas }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @php $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                        <span class="badge bg-{{ $colors[$p->status_seleksi] ?? 'secondary' }}">{{ $p->status_seleksi }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.pendaftaran.show', $p) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-eye me-1"></i> Detail
                        </a>
                        @if($p->is_submitted)
                            @if($p->status_seleksi !== 'Lolos Tahap 1')
                                <form action="{{ route('admin.rekap.lolos', $p) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Loloskan peserta ini ke Tahap 1?')">
                                        <i class="fa-solid fa-check"></i> Lolos
                                    </button>
                                </form>
                                <form action="{{ route('admin.rekap.tidakLolos', $p) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak peserta ini?')">
                                        <i class="fa-solid fa-times"></i> Tolak
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.rekap.tidakLolos', $p) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger" disabled title="Peserta sudah lolos tahap 1">
                                        <i class="fa-solid fa-times"></i> Tolak
                                    </button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-inbox fa-2x mb-2 d-block"></i> Belum ada pendaftaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
