@extends('layouts.dashboard')
@section('title', 'Edit Pengumuman')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Edit Pengumuman</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="judul" class="form-label fw-semibold">Judul Pengumuman</label>
                <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $pengumuman->judul) }}" required>
                @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="tanggal_publish" class="form-label fw-semibold">Tanggal Publish</label>
                <input type="date" name="tanggal_publish" id="tanggal_publish" class="form-control @error('tanggal_publish') is-invalid @enderror" value="{{ old('tanggal_publish', $pengumuman->tanggal_publish) }}" required>
                @error('tanggal_publish')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="file_pengumuman" class="form-label fw-semibold">File Lampiran (Opsional)</label>
                @if($pengumuman->file_path)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $pengumuman->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-file-arrow-down me-1"></i> Unduh File Saat Ini
                        </a>
                    </div>
                @endif
                <input type="file" name="file_pengumuman" id="file_pengumuman" class="form-control @error('file_pengumuman') is-invalid @enderror">
                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file. Format: PDF, JPG, PNG. Maks: 5MB.</small>
                @error('file_pengumuman')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="konten" class="form-label fw-semibold">Isi Konten</label>
                <textarea name="konten" id="konten" class="form-control @error('konten') is-invalid @enderror" rows="10" required>{{ old('konten', $pengumuman->konten) }}</textarea>
                @error('konten')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i> Update Pengumuman
            </button>
        </form>
    </div>
</div>
@endsection
