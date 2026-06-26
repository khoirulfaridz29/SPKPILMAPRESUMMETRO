@extends('layouts.auth')

@section('title', 'Register - PILMAPRES UM Metro')
@section('form-title', 'Buat Akun Baru')
@section('form-subtitle', 'Daftar untuk mengikuti seleksi PILMAPRES')
@section('form-container-class', 'register-container')
@section('body-class', 'register-page')

@push('styles')
<style>
    body.register-page .form-panel {
        overflow-y: auto;
        align-items: flex-start;
        padding-top: 32px;
        padding-bottom: 32px;
        scrollbar-gutter: stable;
    }
    .form-container.register-container {
        max-width: 480px;
    }
    .form-container.register-container .input-group-text {
        padding: 10px 12px;
        font-size: 13px;
    }
    .form-container.register-container .form-control {
        padding: 10px 12px;
        font-size: 13px;
    }
    .form-container.register-container .form-label {
        font-size: 12px;
        margin-bottom: 4px;
    }
    .form-container.register-container .row.gap-row {
        margin-bottom: 14px;
    }
    .form-container.register-container .btn-login {
        margin-top: 4px;
    }

    @media (max-width: 767px) {
        .form-container.register-container {
            max-width: 100%;
        }
    }
</style>
@endpush

@section('form-content')
    <form method="POST" action="{{ route('register') }}" data-turbo="false">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="nama_lengkap">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
                <label class="form-label" for="nim">NPM</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" required placeholder="Contoh: 21520001">
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="program_studi">Program Studi</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                <select id="program_studi" name="program_studi" class="form-control @error('program_studi') is-invalid @enderror" required>
                    <option value="">— Pilih Program Studi —</option>
                    <option value="Akuntansi" {{ old('program_studi') == 'Akuntansi' ? 'selected' : '' }}>Akuntansi</option>
                    <option value="Bimbingan dan Konseling" {{ old('program_studi') == 'Bimbingan dan Konseling' ? 'selected' : '' }}>Bimbingan dan Konseling</option>
                    <option value="Ilmu Hukum" {{ old('program_studi') == 'Ilmu Hukum' ? 'selected' : '' }}>Ilmu Hukum</option>
                    <option value="Ilmu Komputer" {{ old('program_studi') == 'Ilmu Komputer' ? 'selected' : '' }}>Ilmu Komputer</option>
                    <option value="Kedokteran" {{ old('program_studi') == 'Kedokteran' ? 'selected' : '' }}>Kedokteran</option>
                    <option value="Komunikasi dan Penyiaran Islam" {{ old('program_studi') == 'Komunikasi dan Penyiaran Islam' ? 'selected' : '' }}>Komunikasi dan Penyiaran Islam</option>
                    <option value="Manajemen" {{ old('program_studi') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                    <option value="Manajemen Pendidikan Islam" {{ old('program_studi') == 'Manajemen Pendidikan Islam' ? 'selected' : '' }}>Manajemen Pendidikan Islam</option>
                    <option value="Pendidikan Agama Islam" {{ old('program_studi') == 'Pendidikan Agama Islam' ? 'selected' : '' }}>Pendidikan Agama Islam</option>
                    <option value="Pendidikan Bahasa Inggris" {{ old('program_studi') == 'Pendidikan Bahasa Inggris' ? 'selected' : '' }}>Pendidikan Bahasa Inggris</option>
                    <option value="Pendidikan Biologi" {{ old('program_studi') == 'Pendidikan Biologi' ? 'selected' : '' }}>Pendidikan Biologi</option>
                    <option value="Pendidikan Ekonomi" {{ old('program_studi') == 'Pendidikan Ekonomi' ? 'selected' : '' }}>Pendidikan Ekonomi</option>
                    <option value="Pendidikan Fisika" {{ old('program_studi') == 'Pendidikan Fisika' ? 'selected' : '' }}>Pendidikan Fisika</option>
                    <option value="Pendidikan Islam Anak Usia Dini" {{ old('program_studi') == 'Pendidikan Islam Anak Usia Dini' ? 'selected' : '' }}>Pendidikan Islam Anak Usia Dini</option>
                    <option value="Pendidikan Matematika" {{ old('program_studi') == 'Pendidikan Matematika' ? 'selected' : '' }}>Pendidikan Matematika</option>
                    <option value="Pendidikan Sejarah" {{ old('program_studi') == 'Pendidikan Sejarah' ? 'selected' : '' }}>Pendidikan Sejarah</option>
                    <option value="Pendidikan Teknologi Informasi" {{ old('program_studi') == 'Pendidikan Teknologi Informasi' ? 'selected' : '' }}>Pendidikan Teknologi Informasi</option>
                    <option value="Teknik Mesin" {{ old('program_studi') == 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                    <option value="Teknik Sipil" {{ old('program_studi') == 'Teknik Sipil' ? 'selected' : '' }}>Teknik Sipil</option>
                </select>
                @error('program_studi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="jenjang">Jenjang</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-layer-group"></i></span>
                <select id="jenjang" name="jenjang_id" class="form-control @error('jenjang_id') is-invalid @enderror" required>
                    <option value="">— Pilih Jenjang —</option>
                    @foreach($jenjang as $j)
                        <option value="{{ $j->id }}" {{ old('jenjang_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->kode_jenjang }} — {{ $j->nama_jenjang }}
                        </option>
                    @endforeach
                </select>
                @error('jenjang_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="username">Username Login</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autocomplete="username" placeholder="Buat username">
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password" placeholder="Min. 8 karakter">
                    <span class="toggle-pw" id="togglePassword" role="button" tabindex="0" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Ulangi password">
                    <span class="toggle-pw" id="togglePasswordConf" role="button" tabindex="0" aria-label="Toggle password visibility">
                        <i class="fa-regular fa-eye"></i>
                    </span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <i class="fa-solid fa-user-plus me-2"></i> Daftar Akun
        </button>

        <div class="register-link">
            Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
        </div>
    </form>

<script>
(function() {
    var toggle = document.getElementById('togglePassword');
    var pw = document.getElementById('password');
    if (toggle && pw) {
        function togglePassword() {
            var type = pw.getAttribute('type') === 'password' ? 'text' : 'password';
            pw.setAttribute('type', type);
            toggle.querySelector('i').className = type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        }
        toggle.addEventListener('click', togglePassword);
        toggle.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePassword();
            }
        });
    }

    var toggle2 = document.getElementById('togglePasswordConf');
    var pw2 = document.getElementById('password_confirmation');
    if (toggle2 && pw2) {
        function togglePassword2() {
            var type = pw2.getAttribute('type') === 'password' ? 'text' : 'password';
            pw2.setAttribute('type', type);
            toggle2.querySelector('i').className = type === 'password' ? 'fa-regular fa-eye' : 'fa-regular fa-eye-slash';
        }
        toggle2.addEventListener('click', togglePassword2);
        toggle2.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                togglePassword2();
            }
        });
    }

})();
</script>
@endsection
