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
                <label class="form-label" for="label_select">Label Tampilan</label>
                @php $labelOpts = ['Presentasi Gagasan Kreatif','Presentasi Produk Inovatif']; @endphp
                <select name="label_select" id="label_select" class="form-control" onchange="toggleLabelCustom(this)">
                    <option value="">-- Default --</option>
                    @foreach($labelOpts as $opt)
                    <option value="{{ $opt }}" {{ $rubrik_presentasi_gk->label == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                    <option value="__custom__" {{ $rubrik_presentasi_gk->label && !in_array($rubrik_presentasi_gk->label, $labelOpts) ? 'selected' : '' }}>Lainnya...</option>
                </select>
                <input type="text" name="label" id="label_custom" class="form-control mt-2"
                    style="display:{{ $rubrik_presentasi_gk->label && !in_array($rubrik_presentasi_gk->label, $labelOpts) ? 'block' : 'none' }}"
                    value="{{ $rubrik_presentasi_gk->label && !in_array($rubrik_presentasi_gk->label, $labelOpts) ? $rubrik_presentasi_gk->label : '' }}"
                    placeholder="Masukkan label kustom">
            </div>
            <script>function toggleLabelCustom(s){var c=document.getElementById('label_custom');if(!c)return;c.style.display=s.value==='__custom__'?'block':'none';if(s.value!=='__custom__')c.value='';}</script>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.rubrik-presentasi-gk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
