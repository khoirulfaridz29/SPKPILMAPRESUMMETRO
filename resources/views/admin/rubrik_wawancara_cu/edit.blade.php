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
                <label class="form-label fw-bold" for="label_select">Label Tampilan</label>
                @php $labelOpts = ['Wawancara Capaian Unggulan']; @endphp
                <select name="label_select" id="label_select" class="form-control" onchange="toggleLabelCustom(this)">
                    <option value="">-- Default --</option>
                    @foreach($labelOpts as $opt)
                    <option value="{{ $opt }}" {{ $rubrik->label == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                    <option value="__custom__" {{ $rubrik->label && !in_array($rubrik->label, $labelOpts) ? 'selected' : '' }}>Lainnya...</option>
                </select>
                <input type="text" name="label" id="label_custom" class="form-control mt-2"
                    style="display:{{ $rubrik->label && !in_array($rubrik->label, $labelOpts) ? 'block' : 'none' }}"
                    value="{{ $rubrik->label && !in_array($rubrik->label, $labelOpts) ? $rubrik->label : '' }}"
                    placeholder="Masukkan label kustom">
            </div>
            <script>function toggleLabelCustom(s){var c=document.getElementById('label_custom');if(!c)return;c.style.display=s.value==='__custom__'?'block':'none';if(s.value!=='__custom__')c.value='';}</script>
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
