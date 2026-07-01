# Task 4: Kriteria Penilaian — Dropdown nama_kriteria + Auto Kode

## Files
- Modify: `app/Http/Requests/Admin/KriteriaRequest.php`
- Modify: `app/Http/Controllers/Admin/KriteriaController.php`
- Modify: `resources/views/admin/kriteria/create.blade.php`
- Modify: `resources/views/admin/kriteria/edit.blade.php`

## Step 1: Update KriteriaRequest

The `nama_kriteria` rule stays `required|string|max:255`. No change needed since dropdown sends string value.

## Step 2: Update KriteriaController store/update

Modify store method:
```php
public function store(KriteriaRequest $request)
{
    $data = $request->validated();
    $kodeMap = [
        'Naskah Gagasan Kreatif' => 'A02',
        'Presentasi Gagasan Kreatif' => 'F02',
        'Wawancara Capaian Unggulan' => 'F01',
        'Portofolio Capaian Unggulan' => 'A01',
    ];

    if (isset($kodeMap[$data['nama_kriteria']])) {
        $data['kode_kriteria'] = $kodeMap[$data['nama_kriteria']];
    } elseif ($data['nama_kriteria'] === '__custom__') {
        $data['nama_kriteria'] = $request->custom_nama_kriteria;
    }

    KriteriaPenilaian::create($data);
    return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
}
```

Same for update method. For update, if nama_kriteria is `__custom__`, use custom_nama_kriteria.

## Step 3: Update create.blade.php

Replace the `nama_kriteria` text input with dropdown:

```blade
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
```

Also update `kode_kriteria` input to be readonly when auto-filled:
```blade
<input type="text" name="kode_kriteria" id="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror"
    value="{{ old('kode_kriteria') }}" placeholder="Otomatis" {{-- readonly handled by JS --}} required>
```

Add JS at the end (before `@endsection`):
```blade
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
```

## Step 4: Update edit.blade.php

Same pattern as create, but pre-select the current value. Need to check if current nama_kriteria matches one of the predefined options:

```blade
@php
    $predefined = ['Naskah Gagasan Kreatif','Presentasi Gagasan Kreatif','Bahasa Inggris','Wawancara Capaian Unggulan','Portofolio Capaian Unggulan'];
    $isPredefined = in_array($kriteria->nama_kriteria, $predefined);
    $tipeValue = $isPredefined ? $kriteria->nama_kriteria : '__custom__';
@endphp
<select name="nama_kriteria" id="tipe_kriteria" class="form-select" onchange="onTipeChange(this)" required>
    <option value="">-- Pilih Tipe --</option>
    <option value="Naskah Gagasan Kreatif" data-kode="A02" {{ $tipeValue == 'Naskah Gagasan Kreatif' ? 'selected' : '' }}>Naskah Gagasan Kreatif</option>
    <option value="Presentasi Gagasan Kreatif" data-kode="F02" {{ $tipeValue == 'Presentasi Gagasan Kreatif' ? 'selected' : '' }}>Presentasi Gagasan Kreatif</option>
    <option value="Bahasa Inggris" data-kode="" {{ $tipeValue == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
    <option value="Wawancara Capaian Unggulan" data-kode="F01" {{ $tipeValue == 'Wawancara Capaian Unggulan' ? 'selected' : '' }}>Wawancara Capaian Unggulan</option>
    <option value="Portofolio Capaian Unggulan" data-kode="A01" {{ $tipeValue == 'Portofolio Capaian Unggulan' ? 'selected' : '' }}>Portofolio Capaian Unggulan</option>
    <option value="__custom__" data-kode="" {{ !$isPredefined ? 'selected' : '' }}>Lainnya (custom)...</option>
</select>
<div class="mb-3" id="custom_nama_wrapper" style="display:{{ !$isPredefined ? 'block' : 'none' }}">
    <label class="form-label fw-semibold">Nama Kriteria Kustom</label>
    <input type="text" name="custom_nama_kriteria" class="form-control" value="{{ !$isPredefined ? $kriteria->nama_kriteria : '' }}" placeholder="Masukkan nama kriteria baru">
</div>
```

Also update kode_kriteria input readonly state and add same JS @push script.
