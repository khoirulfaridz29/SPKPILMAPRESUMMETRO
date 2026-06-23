@extends('layouts.dashboard')
@section('title', 'Data Pendaftaran')

@section('content')
<h4 class="fw-bold mb-4">Data Pendaftaran Saya</h4>

@if(!$pendaftaranOpen && $period)
<div class="alert alert-warning d-flex align-items-center mb-4">
    <i class="fa-solid fa-clock me-2"></i>
    <span>Pendaftaran dibuka <strong>{{ \Carbon\Carbon::parse($period->tanggal_mulai)->format('d M Y') }}</strong> s.d. <strong>{{ \Carbon\Carbon::parse($period->tanggal_selesai)->format('d M Y') }}</strong>. Saat ini <strong>sudah tutup</strong>.</span>
</div>
@endif

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-user-check me-2 text-primary"></i> Status Pendaftaran</span>
                @if(!$pendaftaran && $pendaftaranOpen)
                    <a href="{{ route('mahasiswa.pendaftaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus me-1"></i> Daftar Sekarang
                    </a>
                @elseif(!$pendaftaran && !$pendaftaranOpen)
                    <span class="text-muted"><i class="fa-solid fa-lock me-1"></i> Pendaftaran Ditutup</span>
                @endif
            </div>
            <div class="card-body">
                @if($pendaftaran)
                <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600;width:160px">Tanggal Daftar</td><td style="padding:0.6rem 0;font-weight:600">{{ $pendaftaran->tanggal_daftar->format('d M Y') }}</td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">Status Berkas</td><td style="padding:0.6rem 0">
                        <span class="badge {{ $pendaftaran->status_berkas === 'Lengkap' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ $pendaftaran->status_berkas }}
                        </span>
                    </td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">Status Seleksi</td><td style="padding:0.6rem 0">
                        @php $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info']; @endphp
                        <span class="badge bg-{{ $colors[$pendaftaran->status_seleksi] ?? 'secondary' }}">{{ $pendaftaran->status_seleksi }}</span>
                    </td></tr>
                </table>
                </div>

                {{-- Status Timeline Progress Bar --}}
                @php
                    $steps = [
                        'Daftar' => $pendaftaran->tanggal_daftar ? 100 : 0,
                        'Submit' => $pendaftaran->is_submitted ? 100 : 0,
                        'Berkas Lengkap' => $pendaftaran->status_berkas === 'Lengkap' ? 100 : ($pendaftaran->is_submitted ? 50 : 0),
                        'Validasi WR3' => $pendaftaran->rekap && $pendaftaran->rekap->status_laporan === 'Divalidasi' ? 100 : ($pendaftaran->rekap ? 50 : 0),
                        'Lolos Tahap 1' => in_array($pendaftaran->status_seleksi, ['Lolos Tahap 1', 'Selesai']) ? 100 : 0,
                        'Selesai' => $pendaftaran->status_seleksi === 'Selesai' ? 100 : 0,
                    ];
                    $overall = $pendaftaran->status_seleksi === 'Selesai' ? 100
                        : ($pendaftaran->status_seleksi === 'Lolos Tahap 1' ? 80
                        : ($pendaftaran->rekap && $pendaftaran->rekap->status_laporan === 'Divalidasi' ? 60
                        : ($pendaftaran->status_berkas === 'Lengkap' ? 40
                        : ($pendaftaran->is_submitted ? 20 : 5))));
                @endphp
                <div class="mt-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-muted">Progress</span>
                        <span class="fw-bold">{{ $overall }}%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $overall }}%" aria-valuenow="{{ $overall }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-2 small">
                        @foreach($steps as $label => $pct)
                            <span class="badge bg-{{ $pct === 100 ? 'success' : 'light text-muted' }} border">
                                <i class="fa-regular fa-{{ $pct === 100 ? 'circle-check' : 'circle' }} me-1"></i> {{ $label }}
                            </span>
                        @endforeach
                    </div>
                </div>

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
                <div class="table-responsive">
                <table style="width:100%;border-collapse:collapse;border-spacing:0;font-size:0.82rem">
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">Nama</td><td style="padding:0.6rem 0;font-weight:600">{{ Auth::user()->nama_lengkap }}</td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">NPM</td><td style="padding:0.6rem 0">{{ $mahasiswa->nim }}</td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">Program Studi</td><td style="padding:0.6rem 0">{{ $mahasiswa->program_studi }}</td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">IPK Terakhir</td><td style="padding:0.6rem 0">{{ $mahasiswa->ipk ?? '-' }}</td></tr>
                    <tr><td style="padding:0.6rem 0;color:#6b7280;white-space:nowrap;font-weight:600">Riwayat Pilmapres</td><td style="padding:0.6rem 0">{{ $mahasiswa->pernah_pilmapres }}</td></tr>
                </table>
                </div>
                @else
                <p class="text-muted">Data profil tidak ditemukan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection