@extends('layouts.dashboard')
@section('title', 'Tambah Rubrik Bahasa Inggris')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa-solid fa-plus me-2"></i> Tambah Field Rubrik Bahasa Inggris
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-bahasa-inggris.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="jenjang_id">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-control" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="label">Label Tampilan <small class="text-muted">(cth: Bahasa Inggris)</small></label>
                <input type="text" name="label" id="label" class="form-control" placeholder="Kosongkan untuk default">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="field">Field Penilaian</label>
                <input type="text" name="field" id="field" class="form-control" placeholder="Contoh: CONTENT" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 border-end">
                    <h6 class="text-success fw-bold">EXCELLENT</h6>
                    <div class="mb-2">
                        <label class="form-label" for="excellent_score">Range Skor</label>
                        <input type="text" name="excellent_score" id="excellent_score" class="form-control" placeholder="Contoh: 25-22" required>
                    </div>
                    <div>
                        <label class="form-label" for="excellent_criteria">Kriteria</label>
                        <textarea name="excellent_criteria" id="excellent_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-bold">GOOD TO AVERAGE</h6>
                    <div class="mb-2">
                        <label class="form-label" for="good_score">Range Skor</label>
                        <input type="text" name="good_score" id="good_score" class="form-control" placeholder="Contoh: 21-18" required>
                    </div>
                    <div>
                        <label class="form-label" for="good_criteria">Kriteria</label>
                        <textarea name="good_criteria" id="good_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-warning fw-bold">FAIR TO POOR</h6>
                    <div class="mb-2">
                        <label class="form-label" for="fair_score">Range Skor</label>
                        <input type="text" name="fair_score" id="fair_score" class="form-control" placeholder="Contoh: 17-11" required>
                    </div>
                    <div>
                        <label class="form-label" for="fair_criteria">Kriteria</label>
                        <textarea name="fair_criteria" id="fair_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-danger fw-bold">VERY POOR</h6>
                    <div class="mb-2">
                        <label class="form-label" for="poor_score">Range Skor</label>
                        <input type="text" name="poor_score" id="poor_score" class="form-control" placeholder="Contoh: 10-5" required>
                    </div>
                    <div>
                        <label class="form-label" for="poor_criteria">Kriteria</label>
                        <textarea name="poor_criteria" id="poor_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-bahasa-inggris.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
