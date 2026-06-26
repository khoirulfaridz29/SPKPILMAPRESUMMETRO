@extends('layouts.dashboard')
@section('title', 'Tambah Akun')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Tambah Akun Pengguna</span>
</div>

<div class="card" style="max-width:550px">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                    value="{{ old('nama_lengkap') }}" required>
                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nidn" class="form-label fw-semibold" id="labelNidn">NIDN/NIP</label>
                <input type="text" name="nidn" id="nidn" class="form-control @error('nidn') is-invalid @enderror"
                    value="{{ old('nidn') }}" placeholder="Kosongkan jika tidak ada">
                @error('nidn')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username') }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="role" class="form-label fw-semibold">Role</label>
                <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="juri" {{ old('role') === 'juri' ? 'selected' : '' }}>Juri</option>
                    <option value="wr3" {{ old('role') === 'wr3' ? 'selected' : '' }}>Wakil Rektor III</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin (Bid. Kemahasiswaan)</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-user-plus me-2"></i> Buat Akun
            </button>
        </form>
    </div>
</div>
@endsection
