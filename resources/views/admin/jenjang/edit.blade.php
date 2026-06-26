@extends('layouts.dashboard')
@section('title', 'Edit Jenjang')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jenjang.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Edit Jenjang Pendidikan</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.jenjang.update', $jenjang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="kode_jenjang" class="form-label fw-semibold">Kode Jenjang</label>
                    <input type="text" name="kode_jenjang" id="kode_jenjang" class="form-control @error('kode_jenjang') is-invalid @enderror"
                        value="{{ old('kode_jenjang', $jenjang->kode_jenjang) }}" required>
                    @error('kode_jenjang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="nama_jenjang" class="form-label fw-semibold">Nama Jenjang</label>
                    <input type="text" name="nama_jenjang" id="nama_jenjang" class="form-control @error('nama_jenjang') is-invalid @enderror"
                        value="{{ old('nama_jenjang', $jenjang->nama_jenjang) }}" required>
                    @error('nama_jenjang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                    rows="3">{{ old('deskripsi', $jenjang->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i> Perbarui Jenjang
            </button>
        </form>
    </div>
</div>
@endsection
