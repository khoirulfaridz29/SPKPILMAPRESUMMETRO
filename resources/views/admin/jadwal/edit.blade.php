@extends('layouts.dashboard')
@section('title', 'Edit Jadwal')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.jadwal.index') }}" class="btn btn-sm btn-light mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <h4 class="fw-bold">Edit Jadwal Pelaksanaan</h4>
</div>

<div class="card">
    <div class="card-body p-4">
        <form action="{{ route('admin.jadwal.update', $jadwal) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="kegiatan" class="form-label fw-semibold">Nama Kegiatan</label>
                <input type="text" name="kegiatan" id="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" value="{{ old('kegiatan', $jadwal->kegiatan) }}" required>
                @error('kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $jadwal->tanggal_mulai) }}" required>
                    @error('tanggal_mulai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $jadwal->tanggal_selesai) }}" required>
                    @error('tanggal_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label for="keterangan" class="form-label fw-semibold">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save me-2"></i> Perbarui Jadwal
            </button>
        </form>
    </div>
</div>
@endsection
