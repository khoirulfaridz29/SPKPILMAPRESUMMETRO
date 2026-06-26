@extends('layouts.dashboard')
@section('title', 'Edit Panduan')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.panduan.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Edit Panduan</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.panduan.update', $panduan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Panduan</label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $panduan->judul) }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label fw-semibold">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $panduan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="file_panduan" class="form-label fw-semibold">File Panduan (PDF)</label>
                @if($panduan->file_path)
                    <div class="mb-2">
                        <a href="{{ route('panduan.download', $panduan) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-file-pdf me-1"></i> Unduh File Saat Ini
                        </a>
                    </div>
                @endif
                <input type="file" name="file_panduan" id="file_panduan" class="form-control @error('file_panduan') is-invalid @enderror" accept=".pdf">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file. Format: PDF. Maks: 10MB.</small>
                @error('file_panduan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i> Update Panduan
            </button>
        </form>
    </div>
</div>
@endsection
