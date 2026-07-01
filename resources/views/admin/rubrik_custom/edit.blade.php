@extends('layouts.dashboard')
@section('title', 'Edit Template Rubrik Custom')

@section('content')
<div class="card">
    <div class="card-header"><i class="fa-solid fa-pen me-2"></i> Edit Template Rubrik Custom</div>
    <div class="card-body">
        <form action="{{ route('admin.rubrik-custom.update', $template) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Template</label>
                <input type="text" name="nama_template" class="form-control" value="{{ $template->nama_template }}" required placeholder="Cth: Penilaian Kreativitas">
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Field Rubrik</label>
                <div id="fields-container">
                    @foreach($template->fields as $i => $f)
                    <div class="row g-2 mb-2 field-row">
                        <div class="col-4"><input type="text" name="fields[{{ $i }}][nama_field]" class="form-control" value="{{ $f->nama_field }}" required></div>
                        <div class="col-3">
                            <select name="fields[{{ $i }}][tipe_input]" class="form-select">
                                <option value="text" {{ $f->tipe_input == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ $f->tipe_input == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="textarea" {{ $f->tipe_input == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                <option value="score_range" {{ $f->tipe_input == 'score_range' ? 'selected' : '' }}>Score Range</option>
                            </select>
                        </div>
                        <div class="col-2"><input type="number" name="fields[{{ $i }}][urutan]" class="form-control" value="{{ $f->urutan }}"></div>
                        <div class="col-2"><input type="number" name="fields[{{ $i }}][bobot]" class="form-control" value="{{ $f->bobot }}" step="0.01"></div>
                        <div class="col-1"><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.field-row').remove()"><i class="fa-solid fa-xmark"></i></button></div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-1" onclick="addField()"><i class="fa-solid fa-plus me-1"></i> Tambah Field</button>
            </div>

            <button type="submit" class="btn btn-primary w-100">Simpan Template</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let fieldIndex = {{ count($template->fields) }};
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
