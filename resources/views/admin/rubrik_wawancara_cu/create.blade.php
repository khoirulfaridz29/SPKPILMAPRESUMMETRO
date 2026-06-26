@extends('layouts.dashboard')
@section('title', 'Tambah Rubrik Wawancara CU')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rubrik-wawancara-cu.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Tambah Rubrik Wawancara Capaian Unggulan</span>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.rubrik-wawancara-cu.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold" for="jenjang_id">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-control" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="label">Label Tampilan <small class="text-muted">(cth: Wawancara CU)</small></label>
                <input type="text" name="label" id="label" class="form-control" placeholder="Kosongkan untuk default">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="kriteria_penilaian">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" id="kriteria_penilaian" class="form-control" required placeholder="Contoh: Kemampuan Komunikasi & Presentasi">
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold" for="bobot">Bobot Rubrik</label>
                <input type="number" name="bobot" id="bobot" class="form-control" required min="1" placeholder="Contoh: 30">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save me-2"></i> Simpan Rubrik
            </button>
        </form>
    </div>
</div>
@endsection
