@extends('layouts.dashboard')
@section('title', 'Tambah Template Rubrik Custom')

@section('content')
<div class="card">
    <div class="card-header"><i class="fa-solid fa-plus me-2"></i> Tambah Template Rubrik Custom</div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-custom.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Template</label>
                <input type="text" name="nama_template" class="form-control" required placeholder="Cth: Penilaian Kreativitas">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Field Rubrik</label>
                <div id="fields-container">
                    <div class="row g-2 mb-2 field-row">
                        <div class="col-4"><input type="text" name="fields[0][nama_field]" class="form-control" placeholder="Nama field" required></div>
                        <div class="col-3">
                            <select name="fields[0][tipe_input]" class="form-select">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                                <option value="score_range">Score Range</option>
                            </select>
                        </div>
                        <div class="col-2"><input type="number" name="fields[0][urutan]" class="form-control" placeholder="Urutan" value="0"></div>
                        <div class="col-2"><input type="number" name="fields[0][bobot]" class="form-control" placeholder="Bobot" step="0.01"></div>
                        <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="addField()"><i class="fa-solid fa-plus me-1"></i> Tambah Field</button>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Template</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let fieldIndex = 1;
function addField() {
    const html = `<div class="row g-2 mb-2 field-row">
        <div class="col-4"><input type="text" name="fields[${fieldIndex}][nama_field]" class="form-control" placeholder="Nama field" required></div>
        <div class="col-3">
            <select name="fields[${fieldIndex}][tipe_input]" class="form-select">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="textarea">Textarea</option>
                <option value="score_range">Score Range</option>
            </select>
        </div>
        <div class="col-2"><input type="number" name="fields[${fieldIndex}][urutan]" class="form-control" placeholder="Urutan" value="0"></div>
        <div class="col-2"><input type="number" name="fields[${fieldIndex}][bobot]" class="form-control" placeholder="Bobot" step="0.01"></div>
        <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
    </div>`;
    document.getElementById('fields-container').insertAdjacentHTML('beforeend', html);
    fieldIndex++;
}
</script>
@endpush
@endsection
