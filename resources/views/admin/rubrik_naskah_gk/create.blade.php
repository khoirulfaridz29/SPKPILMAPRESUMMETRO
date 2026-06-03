@extends('layouts.dashboard')
@section('title', 'Tambah Rubrik Naskah GK')

@section('content')
<div class="card">
    <div class="card-header">
        <i class="fa-solid fa-plus me-2"></i> Tambah Kriteria Rubrik Naskah GK
    </div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-naskah-gk.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Aspek Penilaian</label>
                <input type="text" name="aspek_penilaian" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Bobot</label>
                <input type="number" name="bobot" class="form-control" required min="1">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-naskah-gk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
