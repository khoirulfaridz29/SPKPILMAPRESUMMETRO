@extends('layouts.dashboard')
@section('title', 'Edit Akun')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Edit Akun: {{ $user->nama_lengkap }}</span>
</div>

<div class="card" style="max-width:550px">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control"
                    value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">NIDN/NIP</label>
                <input type="text" name="nidn" class="form-control"
                    value="{{ old('nidn', $user->nidn) }}" placeholder="Kosongkan jika tidak ada">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Username</label>
                <input type="text" name="username" class="form-control"
                    value="{{ old('username', $user->username) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Role</label>
                <select name="role" class="form-select" required>
                    <option value="juri" {{ $user->role === 'juri' ? 'selected' : '' }}>Juri</option>
                    <option value="wr3" {{ $user->role === 'wr3' ? 'selected' : '' }}>Wakil Rektor III</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">
                <i class="fa-solid fa-save me-2"></i> Perbarui Akun
            </button>
        </form>
    </div>
</div>
@endsection
