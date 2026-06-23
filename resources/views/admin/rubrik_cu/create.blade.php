@extends('layouts.dashboard')
@section('title', 'Tambah Rubrik CU')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Rubrik Capaian Unggulan</h4>
    <a href="{{ route('admin.rubrik-cu.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.rubrik-cu.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Jenjang</label>
                <select name="jenjang_id" class="form-control" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Bidang</label>
                    <input type="text" name="bidang" class="form-control" required value="{{ old('bidang') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Wujud Capaian Unggulan</label>
                    <input type="text" name="wujud_capaian_unggulan" class="form-control" required value="{{ old('wujud_capaian_unggulan') }}">
                </div>
            </div>

            <h6 class="mt-4 fw-bold">Skor per Kategori</h6>
            <hr>
            <div class="row">
                <!-- Internasional -->
                <div class="col-md-2 mb-3">
                    <label class="form-label fw-semibold text-primary">Internasional</label>
                    <input type="text" name="kode_internasional" class="form-control mb-2" placeholder="Kode" value="{{ old('kode_internasional') }}">
                    <input type="text" name="skor_internasional" class="form-control" placeholder="Skor" value="{{ old('skor_internasional') }}">
                </div>
                <!-- Regional -->
                <div class="col-md-2 mb-3">
                    <label class="form-label fw-semibold text-success">Regional</label>
                    <input type="text" name="kode_regional" class="form-control mb-2" placeholder="Kode" value="{{ old('kode_regional') }}">
                    <input type="text" name="skor_regional" class="form-control" placeholder="Skor" value="{{ old('skor_regional') }}">
                </div>
                <!-- Nasional -->
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold text-info">Nasional</label>
                    <input type="text" name="kode_nasional" class="form-control mb-2" placeholder="Kode" value="{{ old('kode_nasional') }}">
                    <input type="text" name="skor_nasional" class="form-control" placeholder="Skor" value="{{ old('skor_nasional') }}">
                </div>
                <!-- Provinsi -->
                <div class="col-md-2 mb-3">
                    <label class="form-label fw-semibold text-warning">Provinsi</label>
                    <input type="text" name="kode_provinsi" class="form-control mb-2" placeholder="Kode" value="{{ old('kode_provinsi') }}">
                    <input type="text" name="skor_provinsi" class="form-control" placeholder="Skor" value="{{ old('skor_provinsi') }}">
                </div>
                <!-- Kab/Kota/PT -->
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-semibold text-danger">Kab/Kota/PT</label>
                    <input type="text" name="kode_kab_kota" class="form-control mb-2" placeholder="Kode" value="{{ old('kode_kab_kota') }}">
                    <input type="text" name="skor_kab_kota" class="form-control" placeholder="Skor" value="{{ old('skor_kab_kota') }}">
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
