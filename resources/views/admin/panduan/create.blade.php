@extends('layouts.dashboard')
@section('title', 'Unggah Panduan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.panduan.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Unggah Panduan Baru</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.panduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Panduan</label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="file_panduan" class="form-label fw-semibold">File Panduan (PDF)</label>
                <input type="file" name="file_panduan" id="file_panduan" class="form-control @error('file_panduan') is-invalid @enderror" accept=".pdf" required>
                <small class="text-muted">Format: PDF. Maks: 10MB.</small>
                @error('file_panduan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-upload me-2"></i> Unggah Panduan
            </button>
        </form>
    </div>
</div>
@endsection
