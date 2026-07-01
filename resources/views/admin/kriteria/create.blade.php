@extends('layouts.dashboard')
@section('title', 'Tambah Kriteria')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kriteria.index') }}" class="btn btn-sm btn-outline-secondary me-2">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
    <span class="fw-bold fs-5">Tambah Kriteria Penilaian</span>
</div>

<div class="card" style="max-width:600px">
    <div class="card-body p-4">
        <form action="{{ route('admin.kriteria.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="jenjang_id" class="form-label fw-semibold">Jenjang</label>
                <select name="jenjang_id" id="jenjang_id" class="form-select @error('jenjang_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenjang --</option>
                    @foreach($jenjangs as $j)
                    <option value="{{ $j->id }}" {{ old('jenjang_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jenjang }}</option>
                    @endforeach
                </select>
                @error('jenjang_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="kode_kriteria" class="form-label fw-semibold">Kode Kriteria</label>
                <input type="text" name="kode_kriteria" id="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror"
                    value="{{ old('kode_kriteria') }}" placeholder="Otomatis" required>
                @error('kode_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tipe Kriteria</label>
                <select name="nama_kriteria" id="tipe_kriteria" class="form-select @error('nama_kriteria') is-invalid @enderror" onchange="onTipeChange(this)" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Naskah Gagasan Kreatif" data-kode="A02">Naskah Gagasan Kreatif</option>
                    <option value="Presentasi Gagasan Kreatif" data-kode="F02">Presentasi Gagasan Kreatif</option>
                    <option value="Bahasa Inggris" data-kode="">Bahasa Inggris</option>
                    <option value="Wawancara Capaian Unggulan" data-kode="F01">Wawancara Capaian Unggulan</option>
                    <option value="Portofolio Capaian Unggulan" data-kode="A01">Portofolio Capaian Unggulan</option>
                    <option value="__custom__" data-kode="">Lainnya (custom)...</option>
                </select>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3" id="custom_nama_wrapper" style="display:none">
                <label class="form-label fw-semibold">Nama Kriteria Kustom</label>
                <input type="text" name="custom_nama_kriteria" class="form-control" placeholder="Masukkan nama kriteria baru">
            </div>
            <div class="mb-3">
                <label for="jenis_faktor" class="form-label fw-semibold">Tahap Seleksi</label>
                <select name="jenis_faktor" id="jenis_faktor" class="form-select @error('jenis_faktor') is-invalid @enderror" required>
                    <option value="">-- Pilih Tahap --</option>
                    <option value="Tahap Awal" {{ old('jenis_faktor') === 'Tahap Awal' ? 'selected' : '' }}>Tahap Awal</option>
                    <option value="Tahap Final" {{ old('jenis_faktor') === 'Tahap Final' ? 'selected' : '' }}>Tahap Final</option>
                </select>
                @error('jenis_faktor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="tipe_faktor" class="form-label fw-semibold">Tipe Faktor (Profile Matching)</label>
                <select name="tipe_faktor" id="tipe_faktor" class="form-select @error('tipe_faktor') is-invalid @enderror" required>
                    <option value="Core Factor" {{ old('tipe_faktor') === 'Core Factor' ? 'selected' : '' }}>Core Factor (CF)</option>
                    <option value="Secondary Factor" {{ old('tipe_faktor') === 'Secondary Factor' ? 'selected' : '' }}>Secondary Factor (SF)</option>
                </select>
                @error('tipe_faktor')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="nilai_target" class="form-label fw-semibold">Nilai Target (1-5)</label>
                <input type="number" name="nilai_target" id="nilai_target" class="form-control @error('nilai_target') is-invalid @enderror"
                    value="{{ old('nilai_target') }}" min="1" max="5" required>
                @error('nilai_target')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="bobot" class="form-label fw-semibold">Bobot (%)</label>
                <input type="number" name="bobot" id="bobot" class="form-control @error('bobot') is-invalid @enderror"
                    value="{{ old('bobot') }}" step="0.01" min="0" max="100" required>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-save me-2"></i> Simpan Kriteria
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function onTipeChange(sel) {
    var kode = document.getElementById('kode_kriteria');
    var opt = sel.options[sel.selectedIndex];
    var isCustom = sel.value === '__custom__';
    document.getElementById('custom_nama_wrapper').style.display = isCustom ? 'block' : 'none';
    if (isCustom) {
        kode.readOnly = false;
        kode.value = '';
        kode.placeholder = 'Masukkan kode';
    } else if (opt && opt.dataset.kode) {
        kode.value = opt.dataset.kode;
        kode.readOnly = true;
    } else {
        kode.readOnly = false;
        kode.value = '';
        kode.placeholder = 'Otomatis (kosongkan)';
    }
}
</script>
@endpush
@endsection
