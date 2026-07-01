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
                <label class="form-label" for="jenjang_id">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-control" required>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ $rubrik_bahasa_inggri->jenjang_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Pilih Kriteria</label>
                <select name="kriteria_id" id="kriteria_id" class="form-control">
                    <option value="">-- Default --</option>
                    @foreach($kriterias as $k)
                    <option value="{{ $k->id }}" {{ $rubrik_bahasa_inggri->kriteria_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kriteria }} ({{ $k->kode_kriteria }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="field">Field Penilaian</label>
                <input type="text" name="field" id="field" class="form-control" value="{{ $rubrik_bahasa_inggri->field }}" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 border-end">
                    <h6 class="text-success fw-bold">EXCELLENT</h6>
                    <div class="mb-2">
                        <label class="form-label" for="excellent_score">Range Skor</label>
                        <input type="text" name="excellent_score" id="excellent_score" class="form-control" value="{{ $rubrik_bahasa_inggri->excellent_score }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="excellent_criteria">Kriteria</label>
                        <textarea name="excellent_criteria" id="excellent_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->excellent_criteria }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-bold">GOOD TO AVERAGE</h6>
                    <div class="mb-2">
                        <label class="form-label" for="good_score">Range Skor</label>
                        <input type="text" name="good_score" id="good_score" class="form-control" value="{{ $rubrik_bahasa_inggri->good_score }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="good_criteria">Kriteria</label>
                        <textarea name="good_criteria" id="good_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->good_criteria }}</textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-warning fw-bold">FAIR TO POOR</h6>
                    <div class="mb-2">
                        <label class="form-label" for="fair_score">Range Skor</label>
                        <input type="text" name="fair_score" id="fair_score" class="form-control" value="{{ $rubrik_bahasa_inggri->fair_score }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="fair_criteria">Kriteria</label>
                        <textarea name="fair_criteria" id="fair_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->fair_criteria }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-danger fw-bold">VERY POOR</h6>
                    <div class="mb-2">
                        <label class="form-label" for="poor_score">Range Skor</label>
                        <input type="text" name="poor_score" id="poor_score" class="form-control" value="{{ $rubrik_bahasa_inggri->poor_score }}" required>
                    </div>
                    <div>
                        <label class="form-label" for="poor_criteria">Kriteria</label>
                        <textarea name="poor_criteria" id="poor_criteria" class="form-control" rows="3" required>{{ $rubrik_bahasa_inggri->poor_criteria }}</textarea>
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
