@extends('layouts.dashboard')
@section('title', 'Edit Rubrik Presentasi GK')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa-solid fa-edit me-2"></i> Edit Kriteria Rubrik Presentasi GK
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-presentasi-gk.update', $rubrik_presentasi_gk->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Aspek Penilaian</label>
                <input type="text" name="aspek_penilaian" class="form-control" value="{{ $rubrik_presentasi_gk->aspek_penilaian }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" class="form-control" value="{{ $rubrik_presentasi_gk->kriteria_penilaian }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Bobot</label>
                <input type="number" name="bobot" class="form-control" value="{{ $rubrik_presentasi_gk->bobot }}" required min="1">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-presentasi-gk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
