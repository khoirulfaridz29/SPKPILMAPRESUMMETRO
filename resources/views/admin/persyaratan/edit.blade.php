@extends('layouts.dashboard')
@section('title', 'Edit Persyaratan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.persyaratan.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Edit Persyaratan Pendaftaran</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.persyaratan.update', $persyaratan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Persyaratan (Judul File)</label>
                <input type="text" name="nama_syarat" class="form-control @error('nama_syarat') is-invalid @enderror" value="{{ old('nama_syarat', $persyaratan->nama_syarat) }}" required placeholder="Contoh: Sertifikat Prestasi">
                @error('nama_syarat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3" placeholder="Jelaskan detail file yang harus diunggah...">{{ old('keterangan', $persyaratan->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold d-block">Sifat Persyaratan</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_required" id="req1" value="1" {{ old('is_required', $persyaratan->is_required) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="req1">Wajib Diisi</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_required" id="req0" value="0" {{ old('is_required', $persyaratan->is_required) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="req0">Opsional</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i> Update Persyaratan
            </button>
        </form>
    </div>
</div>
@endsection
