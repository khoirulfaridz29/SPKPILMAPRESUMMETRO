@extends('layouts.dashboard')
@section('title', 'Data Pendaftaran')

@section('content')
<h4 class="fw-bold mb-4">Data Pendaftaran Saya</h4>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-user-check me-2 text-primary"></i> Status Pendaftaran</span>
                @if(!$pendaftaran)
                    <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Daftar Sekarang
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($pendaftaran)
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted" width="160">Tanggal Daftar</td><td class="fw-semibold">{{ $pendaftaran->tanggal_daftar->format('d M Y') }}</td></tr>
                    <tr><td class="text-muted">Status Berkas</td><td>
                        <span class="badge {{ $pendaftaran->status_berkas === 'Lengkap' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $pendaftaran->status_berkas }}
                        </span>
                    </td></tr>
                    <tr><td class="text-muted">Status Seleksi</td><td>
                        @php $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                        <span class="badge bg-{{ $colors[$pendaftaran->status_seleksi] ?? 'secondary' }}">{{ $pendaftaran->status_seleksi }}</span>
                    </td></tr>
                </table>

                @if($pendaftaran->status_seleksi === 'Selesai' && $pendaftaran->hasil)
                <div class="alert alert-info mt-3">
                    <h6 class="fw-bold"><i class="fa-solid fa-trophy me-2"></i> Hasil Penilaian</h6>
                    <p class="mb-1">Nilai Total: <strong>{{ number_format($pendaftaran->hasil->nilai_total, 3) }}</strong></p>
                    <p class="mb-1">Ranking: <strong>#{{ $pendaftaran->hasil->ranking }}</strong></p>
                    <p class="mb-0">Status Juara: <strong>{{ $pendaftaran->hasil->status_juara }}</strong></p>
                </div>
                @endif

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('mahasiswa.berkas.index') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa-solid fa-upload me-1"></i> Kelola Berkas
                    </a>
                    
                    @if(!$pendaftaran->is_submitted)
                    <form action="{{ route('mahasiswa.pendaftaran.submit') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success btn-sm" onclick="return confirm('Kirim pendaftaran secara final? Data tidak dapat diubah lagi setelah dikirim.')">
                            <i class="fa-solid fa-paper-plane me-1"></i> Kirim Pendaftaran (Final)
                        </button>
                    </form>
                    @endif
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fa-regular fa-folder-open fa-3x mb-3 opacity-50"></i>
                    <p>Anda belum mendaftar. Silakan klik <strong>Daftar Sekarang</strong>.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-circle-info me-2 text-info"></i> Profil Mahasiswa</div>
            <div class="card-body">
                @if($mahasiswa)
                <table class="table table-borderless mb-0">
                    <tr><td class="text-muted">Nama</td><td class="fw-semibold">{{ Auth::user()->nama_lengkap }}</td></tr>
                    <tr><td class="text-muted">NIM</td><td>{{ $mahasiswa->nim }}</td></tr>
                    <tr><td class="text-muted">Program Studi</td><td>{{ $mahasiswa->program_studi }}</td></tr>
                    <tr><td class="text-muted">IPK Terakhir</td><td>{{ $mahasiswa->ipk ?? '-' }}</td></tr>
                    <tr><td class="text-muted">Riwayat Pilmapres</td><td>{{ $mahasiswa->pernah_pilmapres }}</td></tr>
                </table>
                @else
                <p class="text-muted">Data profil tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
