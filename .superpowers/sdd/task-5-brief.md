# Task 5: Rubrik Forms — Replace Label Input with Kriteria Dropdown

## Files to Modify (19 files)

### Requests (4 files)
- `app/Http/Requests/Admin/RubrikNaskahGkRequest.php`
- `app/Http/Requests/Admin/RubrikPresentasiGkRequest.php`
- `app/Http/Requests/Admin/RubrikBahasaInggrisRequest.php`
- `app/Http/Requests/Admin/RubrikWawancaraCuRequest.php`

Change `label` from `required` to `nullable`. Add `kriteria_id` rule.

### Controllers (5 files)
- `app/Http/Controllers/Admin/RubrikNaskahGkController.php`
- `app/Http/Controllers/Admin/RubrikPresentasiGkController.php`
- `app/Http/Controllers/Admin/RubrikBahasaInggrisController.php`
- `app/Http/Controllers/Admin/RubrikWawancaraCuController.php`
- `app/Http/Controllers/Admin/RubrikCapaianUnggulanController.php`

### Create Views (5 files)
- `resources/views/admin/rubrik_naskah_gk/create.blade.php`
- `resources/views/admin/rubrik_presentasi_gk/create.blade.php`
- `resources/views/admin/rubrik_bahasa_inggris/create.blade.php`
- `resources/views/admin/rubrik_wawancara_cu/create.blade.php`
- `resources/views/admin/rubrik_cu/create.blade.php`

### Edit Views (5 files)
- `resources/views/admin/rubrik_naskah_gk/edit.blade.php`
- `resources/views/admin/rubrik_presentasi_gk/edit.blade.php`
- `resources/views/admin/rubrik_bahasa_inggris/edit.blade.php`
- `resources/views/admin/rubrik_wawancara_cu/edit.blade.php`
- `resources/views/admin/rubrik_cu/edit.blade.php`

## Step 1: Update FormRequests

In each of the 4 request files, change label rule and add kriteria_id:

```php
'label' => 'nullable|string|max:255',
'kriteria_id' => 'nullable|exists:kriteria_penilaian,id',
```

## Step 2: Update Controllers

Remove the `resolveLabel()` method that was previously added. In store() and update() methods, resolve label from kriteria:

```php
// In store() and update():
$data = $request->validated();
if (!empty($data['kriteria_id'])) {
    $kriteria = \App\Models\KriteriaPenilaian::find($data['kriteria_id']);
    $data['label'] = $kriteria?->nama_kriteria;
}
// ...create/update
```

Also add `$kriterias` to the create() and edit() methods in each controller:

```php
public function create()
{
    $jenjangs = Jenjang::orderBy('id')->get();
    $kriterias = collect(); // empty by default
    return view('admin.rubrik_naskah_gk.create', compact('jenjangs', 'kriterias'));
}
```

For the edit method, pass the current jenjang_id to filter kriterias:
```php
$kriterias = KriteriaPenilaian::where('jenjang_id', $rubrik_naskah_gk->jenjang_id)->get()
    ->filter(fn($k) => $k->tipe_kriteria === 'naskah_gk');
```

**Route name to tipe mapping:**
```
admin.rubrik-naskah-gk.*  → tipe 'naskah_gk'
admin.rubrik-presentasi-gk.* → tipe 'presentasi_gk'
admin.rubrik-bahasa-inggris.* → tipe 'bahasa_inggris'
admin.rubrik-wawancara-cu.* → tipe 'wawancara_cu'
admin.rubrik-cu.* → tipe 'cu'
```

For `RubrikCapaianUnggulanController`, the store/update methods don't use FormRequest — they use `$request->validate()` directly. Add kriteria_id rule there too.

## Step 3: Update Create Views

For each create view, find the label input block and replace it:

**Label block (current):**
```blade
<div class="mb-3">
    <label class="form-label" for="label">Label Tampilan ...</label>
    <input type="text" name="label" id="label" class="form-control" ...>
</div>
```

**Replace with:**
```blade
<div class="mb-3">
    <label class="form-label">Pilih Kriteria</label>
    <select name="kriteria_id" id="kriteria_id" class="form-control">
        <option value="">-- Default --</option>
        @foreach($kriterias as $k)
        <option value="{{ $k->id }}" {{ old('kriteria_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kriteria }} ({{ $k->kode_kriteria }})</option>
        @endforeach
    </select>
</div>
```

## Step 4: Update Edit Views

Same as create but pre-select current value:
```blade
<div class="mb-3">
    <label class="form-label">Pilih Kriteria</label>
    <select name="kriteria_id" id="kriteria_id" class="form-control">
        <option value="">-- Default --</option>
        @foreach($kriterias as $k)
        <option value="{{ $k->id }}" {{ $rubrik->kriteria_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kriteria }} ({{ $k->kode_kriteria }})</option>
        @endforeach
    </select>
</div>
```

Note: variable name varies per model — `$rubrik_naskah_gk`, `$rubrik_presentasi_gk`, `$rubrik_bahasa_inggri`, `$rubrik` (for wawancara_cu and capaian_unggulan).

## IMPORTANT NOTES
- The `wawancara_cu` edit view uses `$rubrik` as the model variable
- The `capaian_unggulan` edit view also uses `$rubrik`
- The `bahasa_inggris` edit view uses `$rubrik_bahasa_inggri`
- Remove the `resolveLabel()` private method from controllers that have it
- Remove any `label_select` / JS `toggleLabelCustom` code added previously (from Fix 3 changes)
- For `rubrik_cu` (Capaian Unggulan), the form doesn't have a label field — just add the kriteria_id dropdown before the first existing field
- Test: `php artisan view:cache` and `php artisan serve` to verify
