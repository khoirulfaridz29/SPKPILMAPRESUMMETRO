@extends('layouts.dashboard')
@section('title', 'Tambah Kriteria')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Tambah Kriteria Penilaian</span>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body p-4">
        <form action="{{ route('admin.kriteria.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenjang</label>
                <select name="jenjang_id" class="form-select @error('jenjang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenjang --</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ old('jenjang_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
                @error('jenjang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Kriteria</label>
                <input type="text" name="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror"
                    value="{{ old('kode_kriteria') }}" placeholder="Cth: K1" required>
                @error('kode_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria</label>
                <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                    value="{{ old('nama_kriteria') }}" placeholder="Cth: IPK" required>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahap Seleksi</label>
                <select name="jenis_faktor" class="form-select @error('jenis_faktor') is-invalid @enderror" required>
                    <option value="">-- Pilih Tahap --</option>
                    <option value="Tahap Awal" {{ old('jenis_faktor') === 'Tahap Awal' ? 'selected' : '' }}>Tahap Awal</option>
                    <option value="Tahap Final" {{ old('jenis_faktor') === 'Tahap Final' ? 'selected' : '' }}>Tahap Final</option>
                </select>
                @error('jenis_faktor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tipe Faktor (Profile Matching)</label>
                <select name="tipe_faktor" class="form-select @error('tipe_faktor') is-invalid @enderror" required>
                    <option value="Core Factor" {{ old('tipe_faktor') === 'Core Factor' ? 'selected' : '' }}>Core Factor (CF)</option>
                    <option value="Secondary Factor" {{ old('tipe_faktor') === 'Secondary Factor' ? 'selected' : '' }}>Secondary Factor (SF)</option>
                </select>
                @error('tipe_faktor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nilai Target (1-5)</label>
                <input type="number" name="nilai_target" class="form-control @error('nilai_target') is-invalid @enderror"
                    value="{{ old('nilai_target') }}" min="1" max="5" required>
                @error('nilai_target')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Bobot (%)</label>
                <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                    value="{{ old('bobot') }}" step="0.01" min="0" max="100" required>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save me-2"></i> Simpan Kriteria
            </button>
        </form>
    </div>
</div>
@endsection
