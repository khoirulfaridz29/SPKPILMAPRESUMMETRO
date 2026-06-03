@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')


{{-- ADMIN DASHBOARD --}}
@if($role === 'admin')
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#3b82f6,#1d4ed8)">
            <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
            <div class="stat-val">{{ $stats['total_pendaftar'] }}</div>
            <div class="stat-lbl">Total Pendaftar</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#059669)">
            <div class="stat-icon"><i class="fa-solid fa-file-circle-check"></i></div>
            <div class="stat-val">{{ $stats['berkas_lengkap'] }}</div>
            <div class="stat-lbl">Berkas Lengkap</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-icon"><i class="fa-solid fa-medal"></i></div>
            <div class="stat-val">{{ $stats['lolos_tahap1'] }}</div>
            <div class="stat-lbl">Lolos Tahap I</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#8b5cf6,#6d28d9)">
            <div class="stat-icon"><i class="fa-solid fa-list-check"></i></div>
            <div class="stat-val">{{ $stats['total_kriteria'] }}</div>
            <div class="stat-lbl">Kriteria Penilaian</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="mb-3"><i class="fa-solid fa-users-gear fa-3x text-primary opacity-75"></i></div>
            <h5 class="fw-bold">Kelola Akun</h5>
            <p class="text-muted small">{{ $stats['total_juri'] }} Juri &bull; {{ $stats['total_mahasiswa'] }} Mahasiswa</p>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm mt-auto">Kelola Akun</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="mb-3"><i class="fa-solid fa-clipboard-list fa-3x text-warning opacity-75"></i></div>
            <h5 class="fw-bold">Rekap Tahap I</h5>
            <p class="text-muted small">Verifikasi berkas dan kirim notifikasi lolos administrasi</p>
            <a href="{{ route('admin.rekap.index') }}" class="btn btn-warning btn-sm mt-auto">Lihat Rekap</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4">
            <div class="mb-3"><i class="fa-solid fa-calculator fa-3x text-success opacity-75"></i></div>
            <h5 class="fw-bold">Perhitungan GAP</h5>
            <p class="text-muted small">Proses nilai juri, hitung CF/SF, dan rangking peserta</p>
            <a href="{{ route('admin.perhitungan.index') }}" class="btn btn-success btn-sm mt-auto">Proses Nilai</a>
        </div>
    </div>
</div>

{{-- MAHASISWA DASHBOARD --}}
@elseif($role === 'mahasiswa')
@php
    $pendaftaran = $stats['pendaftaran'] ?? null;
    $mahasiswa = $stats['mahasiswa'] ?? null;
@endphp
<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-user-check me-2 text-primary"></i> Status Pendaftaran Saya</span>
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
                        @php
                            $colors = ['Proses'=>'primary','Lolos Tahap 1'=>'success','Tidak Lolos'=>'danger','Selesai'=>'info'];
                        @endphp
                        <span class="badge bg-{{ $colors[$pendaftaran->status_seleksi] ?? 'secondary' }}">{{ $pendaftaran->status_seleksi }}</span>
                    </td></tr>
                    <tr><td class="text-muted">Jumlah Berkas</td><td class="fw-semibold">{{ $pendaftaran->berkas->count() }} berkas diunggah</td></tr>
                </table>
                <a href="{{ route('mahasiswa.berkas.index') }}" class="btn btn-outline-primary btn-sm mt-3">
                    <i class="fa-solid fa-upload me-1"></i> Kelola Berkas
                </a>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fa-regular fa-folder-open fa-3x mb-3 opacity-50"></i>
                    <p>Anda belum mendaftar. Silakan klik tombol <strong>Daftar Sekarang</strong>.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-route me-2 text-success"></i> Alur Pendaftaran</div>
            <div class="card-body p-3">
                @php
                    $steps = [
                        ['Registrasi Akun', true],
                        ['Isi Form Pendaftaran', (bool)$pendaftaran],
                        ['Upload Berkas', $pendaftaran && $pendaftaran->berkas->count() > 0],
                        ['Validasi Admin', $pendaftaran && $pendaftaran->status_berkas === 'Lengkap'],
                        ['Seleksi Juri', $pendaftaran && $pendaftaran->status_seleksi === 'Lolos Tahap 1'],
                        ['Pengumuman Hasil', $pendaftaran && $pendaftaran->status_seleksi === 'Selesai'],
                    ];
                @endphp
                <ul class="list-unstyled mb-0">
                    @foreach($steps as [$label, $done])
                    <li class="d-flex align-items-center py-2 border-bottom">
                        <span class="me-3 {{ $done ? 'text-success' : 'text-muted' }}">
                            <i class="fa-solid {{ $done ? 'fa-circle-check' : 'fa-circle' }}"></i>
                        </span>
                        <span class="{{ $done ? 'fw-semibold' : 'text-muted' }}">{{ $label }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- JURI DASHBOARD --}}
@elseif($role === 'juri')
<div class="row g-4">
    <div class="col-md-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-icon"><i class="fa-solid fa-clipboard-check"></i></div>
            <div class="stat-val">{{ $stats['total_tugas'] }}</div>
            <div class="stat-lbl">Peserta Ditugaskan</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card h-100 p-4">
            <h5 class="fw-bold mb-3">Selamat Datang, {{ Auth::user()->nama_lengkap }}</h5>
            <p class="text-muted">Anda bertugas menilai peserta PILMAPRES sesuai kriteria yang telah ditentukan. Silakan mulai penilaian pada menu <strong>Peserta yang Dinilai</strong>.</p>
            <div class="mt-auto">
                <a href="{{ route('juri.penilaian.index') }}" class="btn btn-warning">
                    <i class="fa-solid fa-clipboard-check me-2"></i> Mulai Penilaian
                </a>
            </div>
        </div>
    </div>
</div>

{{-- WR3 DASHBOARD --}}
@elseif($role === 'wr3')
<div class="row g-4 mb-4">
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#3b82f6,#1d4ed8)">
            <div class="stat-icon"><i class="fa-solid fa-clipboard-list"></i></div>
            <div class="stat-val">{{ $stats['total_rekap'] }}</div>
            <div class="stat-lbl">Total Rekap Masuk</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#10b981,#059669)">
            <div class="stat-icon"><i class="fa-solid fa-file-circle-check"></i></div>
            <div class="stat-val">{{ $stats['sudah_validasi'] }}</div>
            <div class="stat-lbl">Sudah Divalidasi</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706)">
            <div class="stat-icon"><i class="fa-solid fa-trophy"></i></div>
            <div class="stat-val">{{ $stats['hasil_pending'] }}</div>
            <div class="stat-lbl">Hasil Belum Divalidasi</div>
        </div>
    </div>
</div>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card text-center p-4">
            <div class="mb-3"><i class="fa-solid fa-file-shield fa-3x text-primary opacity-75"></i></div>
            <h5 class="fw-bold">Validasi Laporan Tahap I</h5>
            <p class="text-muted small">Tinjau dan validasi rekap berkas yang dikirimkan Bidang Kemahasiswaan</p>
            <a href="{{ route('wr3.validasi.index') }}" class="btn btn-primary btn-sm">Buka Validasi</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center p-4">
            <div class="mb-3"><i class="fa-solid fa-ranking-star fa-3x text-warning opacity-75"></i></div>
            <h5 class="fw-bold">Rekomendasi Mahasiswa Berprestasi</h5>
            <p class="text-muted small">Lihat perangkingan hasil perhitungan dan validasi juara 1, 2, 3</p>
            <a href="{{ route('wr3.rekomendasi.index') }}" class="btn btn-warning btn-sm">Lihat Rekomendasi</a>
        </div>
    </div>
</div>
@endif

@endsection
