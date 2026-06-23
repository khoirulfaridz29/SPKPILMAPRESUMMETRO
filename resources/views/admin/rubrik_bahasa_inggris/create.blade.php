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
                <label class="form-label">Jenjang</label>
                <select name="jenjang_id" class="form-control" required>
                    <option value="">Pilih Jenjang</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}">{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Label Tampilan <small class="text-muted">(cth: Bahasa Inggris)</small></label>
                <input type="text" name="label" class="form-control" placeholder="Kosongkan untuk default">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Field Penilaian</label>
                <input type="text" name="field" class="form-control" placeholder="Contoh: CONTENT" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 border-end">
                    <h6 class="text-success fw-bold">EXCELLENT</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="excellent_score" class="form-control" placeholder="Contoh: 25-22" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="excellent_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-bold">GOOD TO AVERAGE</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="good_score" class="form-control" placeholder="Contoh: 21-18" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="good_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-6 border-end">
                    <h6 class="text-warning fw-bold">FAIR TO POOR</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="fair_score" class="form-control" placeholder="Contoh: 17-11" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="fair_criteria" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-danger fw-bold">VERY POOR</h6>
                    <div class="mb-2">
                        <label class="form-label">Range Skor</label>
                        <input type="text" name="poor_score" class="form-control" placeholder="Contoh: 10-5" required>
                    </div>
                    <div>
                        <label class="form-label">Kriteria</label>
                        <textarea name="poor_criteria" class="form-control" rows="3" required></textarea>
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
