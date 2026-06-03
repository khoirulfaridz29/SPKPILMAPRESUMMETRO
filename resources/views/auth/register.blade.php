@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center mt-4">
    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/logoummetro.webp') }}" alt="Logo UM Metro" height="75" class="mb-3">
                    <h4 class="fw-bold">Pendaftaran Akun Mahasiswa</h4>
                    <p class="text-muted">Silakan lengkapi data di bawah ini untuk mendaftar seleksi PILMAPRES</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">NIM (Nomor Pokok Mahasiswa)</label>
                            <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required placeholder="Contoh: 21520001">
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Program Studi (Otomatis)</label>
                        <input type="text" id="program_studi" name="program_studi" class="form-control @error('program_studi') is-invalid @enderror" value="{{ old('program_studi') }}" required readonly bg-light>
                        <small class="text-muted">Prodi akan terisi otomatis berdasarkan NIM yang Anda masukkan.</small>
                        @error('program_studi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username Login</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fa-solid fa-user-plus me-2"></i> Daftar Akun
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('nim').addEventListener('input', function() {
        const nim = this.value;
        const prodiField = document.getElementById('program_studi');

        // Mapping Kode Prodi UM Metro (Berdasarkan Digit ke 3 & 4)
        const mapping = {
            '52': 'Teknik Mesin',
            '51': 'Teknik Sipil',
            '43': 'Ilmu Komputer',
            '11': 'Pendidikan Ekonomi',
            '21': 'Pendidikan Matematika',
            '71': 'Akuntansi',
            '72': 'Manajemen',
            '61': 'Ilmu Hukum'
        };

        if (nim.length >= 4) {
            const kode = nim.substring(2, 4);
            prodiField.value = mapping[kode] || 'Prodi Tidak Terdaftar (' + kode + ')';
        } else {
            prodiField.value = '';
        }
    });
</script>
@endsection
