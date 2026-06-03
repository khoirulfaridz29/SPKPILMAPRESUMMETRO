@extends('layouts.dashboard')
@section('title', 'Edit Rubrik Bahasa Inggris')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa-solid fa-edit me-2"></i> Edit Field Rubrik Bahasa Inggris
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-bahasa-inggris.update', $rubrik_bahasa_inggri->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Field Penilaian</label>
                <input type="text" name="field" class="form-control" value="{{ $rubrik_bahasa_inggri->field }}" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 border-end">
                    <h6 class="text-success fw-bold">EXCELLENT</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="excellent_score" class="form-control" value="{{ $rubrik_bahasa_inggri->excellent_score }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="excellent_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->excellent_criteria }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-bold">GOOD TO AVERAGE</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="good_score" class="form-control" value="{{ $rubrik_bahasa_inggri->good_score }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="good_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->good_criteria }}</textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-warning fw-bold">FAIR TO POOR</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="fair_score" class="form-control" value="{{ $rubrik_bahasa_inggri->fair_score }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="fair_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->fair_criteria }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-danger fw-bold">VERY POOR</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="poor_score" class="form-control" value="{{ $rubrik_bahasa_inggri->poor_score }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="poor_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->poor_criteria }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-bahasa-inggris.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
