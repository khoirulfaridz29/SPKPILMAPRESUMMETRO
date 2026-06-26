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
                <label class="form-label fw-bold" for="jenjang_id">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-control" required>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ $rubrik->jenjang_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="label">Label Tampilan <small class="text-muted">(cth: Wawancara CU)</small></label>
                <input type="text" name="label" id="label" class="form-control" value="{{ $rubrik->label }}" placeholder="Kosongkan untuk default">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold" for="kriteria_penilaian">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" id="kriteria_penilaian" class="form-control" value="{{ $rubrik->kriteria_penilaian }}" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold" for="bobot">Bobot Rubrik</label>
                <input type="number" name="bobot" id="bobot" class="form-control" value="{{ $rubrik->bobot }}" required min="1">
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save me-2"></i> Perbarui Rubrik
            </button>
        </form>
    </div>
</div>
@endsection
