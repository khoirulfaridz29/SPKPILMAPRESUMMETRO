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
                <label class="form-label" for="aspek_penilaian">Aspek Penilaian</label>
                <input type="text" name="aspek_penilaian" id="aspek_penilaian" class="form-control" value="{{ $rubrik_presentasi_gk->aspek_penilaian }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="kriteria_penilaian">Kriteria Penilaian</label>
                <input type="text" name="kriteria_penilaian" id="kriteria_penilaian" class="form-control" value="{{ $rubrik_presentasi_gk->kriteria_penilaian }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="bobot">Bobot</label>
                <input type="number" name="bobot" id="bobot" class="form-control" value="{{ $rubrik_presentasi_gk->bobot }}" required min="1">
            </div>
            <div class="mb-3">
                <label class="form-label" for="jenjang_id">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-control" required>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ $rubrik_presentasi_gk->jenjang_id == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="label">Label Tampilan <small class="text-muted">(cth: Presentasi GK, Presentasi PI)</small></label>
                <input type="text" name="label" id="label" class="form-control" value="{{ $rubrik_presentasi_gk->label }}" placeholder="Kosongkan untuk default">
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-presentasi-gk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
