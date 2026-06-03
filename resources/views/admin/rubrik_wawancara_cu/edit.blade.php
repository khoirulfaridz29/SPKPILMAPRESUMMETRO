@extends('layouts.dashboard')
@section('title', 'Edit Rubrik Wawancara CU')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.rubrik-wawancara-cu.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Edit Rubrik Wawancara Capaian Unggulan</span>
</div>

<div class="card" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.rubrik-wawancara-cu.update', $rubrik->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label fw-bold">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" class="form-control" value="{{ $rubrik->kriteria_penilaian }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Bobot Rubrik</label>
                <input type="number" name="bobot" class="form-control" value="{{ $rubrik->bobot }}" required min="1">
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill">
                <i class="fa-solid fa-save me-2"></i> Perbarui Rubrik
            </button>
        </form>
    </div>
</div>
@endsection
