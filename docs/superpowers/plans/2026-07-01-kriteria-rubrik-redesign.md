# Kriteria → Rubrik Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development or superpowers:executing-plans to implement this task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Link rubrik penilaian to kriteria_penilaian via `kriteria_id`, add dropdown for `nama_kriteria`, build custom template system.

**Architecture:** Add `kriteria_id` FK to 5 rubrik tables, change `nama_kriteria` form to dropdown, create `rubrik_custom_templates` + `rubrik_custom_template_fields` tables for dynamic form builder.

**Tech Stack:** Laravel 11, MySQL, Bootstrap 5, Blade

## Global Constraints

- Do NOT change GAP/Profile Matching algorithm
- Keep `label` column nullable for backward compat
- `kriteria_id` nullable for existing data
- Test at http://127.0.0.1:8000/ after each task

---

### Task 1: Fix Sidebar Dropdown Bug

**Files:**
- Modify: `resources/views/layouts/dashboard.blade.php:533`

- [ ] **Step 1: Remove `data-bs-parent` from inner collapse**

Change line 533 from:
```
<div class="collapse {{ $isSJActive ? 'show' : '' }}" id="collapseJenjang{{ $sj->id }}" data-bs-parent="#collapseRubrik">
```
to:
```
<div class="collapse {{ $isSJActive ? 'show' : '' }}" id="collapseJenjang{{ $sj->id }}">
```

This prevents the parent `#collapseRubrik` from intercepting the child collapse toggle, fixing both the "can't close" and "scroll" bugs.

- [ ] **Step 2: Test** — toggle rubrik dropdown, per-jenjang sub-menus, verify no scroll jump

---

### Task 2: Migration — Add kriteria_id + Create Custom Tables

**Files:**
- Create: `database/migrations/xxxx_xx_xx_add_kriteria_id_to_rubrik_tables.php`
- Create: `database/migrations/xxxx_xx_xx_create_rubrik_custom_templates_tables.php`

- [ ] **Step 1: Create migration `add_kriteria_id_to_rubrik_tables`**

Run `php artisan make:migration add_kriteria_id_to_rubrik_tables`

Content:
```php
public function up(): void
{
    foreach (['rubrik_naskah_gk','rubrik_presentasi_gk','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulan'] as $table) {
        Schema::table($table, fn(Blueprint $t) =>
            $t->foreignId('kriteria_id')->nullable()->constrained('kriteria_penilaian')->nullOnDelete()->after('jenjang_id')
        );
    }
}
public function down(): void
{
    foreach (['rubrik_naskah_gk','rubrik_presentasi_gk','rubrik_bahasa_inggris','rubrik_wawancara_cu','rubrik_capaian_unggulan'] as $table) {
        Schema::table($table, fn(Blueprint $t) => {
            $t->dropForeign(['kriteria_id']);
            $t->dropColumn('kriteria_id');
        });
    }
}
```

- [ ] **Step 2: Create migration `create_rubrik_custom_templates_tables`**

Run `php artisan make:migration create_rubrik_custom_templates_tables`

Content: Create `rubrik_custom_templates` (id, nama_template, timestamps) and `rubrik_custom_template_fields` (id, template_id FK, nama_field, tipe_input ENUM text/number/textarea/score_range, urutan INT, bobot DECIMAL 5,2, timestamps).

- [ ] **Step 3: Run migrations**

Run: `php artisan migrate`

---

### Task 3: Models — Add Relations

**Files:**
- Modify: `app/Models/KriteriaPenilaian.php`
- Modify: `app/Models/RubrikNaskahGk.php` + `RubrikPresentasiGk.php` + `RubrikBahasaInggris.php` + `RubrikWawancaraCu.php` + `RubrikCapaianUnggulan.php`
- Create: `app/Models/RubrikCustomTemplate.php`
- Create: `app/Models/RubrikCustomTemplateField.php`

- [ ] **Step 1: Add `kriteria()` relation + `kriteria_id` to fillable in all 5 rubrik models**

```php
public function kriteria()
{
    return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
}
```
Add `'kriteria_id'` to `$fillable`.

- [ ] **Step 2: Add `getTipeKriteriaAttribute()` to KriteriaPenilaian**

```php
public function getTipeKriteriaAttribute(): string
{
    $lower = strtolower($this->nama_kriteria);
    if (str_contains($lower, 'naskah')) return 'naskah_gk';
    if (str_contains($lower, 'presentasi')) return 'presentasi_gk';
    if (str_contains($lower, 'bahasa inggris') || $lower === 'bi') return 'bahasa_inggris';
    if (str_contains($lower, 'wawancara')) return 'wawancara_cu';
    if (str_contains($lower, 'portofolio') || str_contains($lower, 'capaian') || $lower === 'cu') return 'cu';
    return 'custom';
}
```

- [ ] **Step 3: Create `app/Models/RubrikCustomTemplate.php`** — fillable: nama_template, hasMany fields
- [ ] **Step 4: Create `app/Models/RubrikCustomTemplateField.php`** — fillable: template_id, nama_field, tipe_input, urutan, bobot; belongsTo template

---

### Task 4: Kriteria Penilaian — Dropdown nama_kriteria

**Files:**
- Modify: `app/Http/Requests/Admin/KriteriaRequest.php`
- Modify: `app/Http/Controllers/Admin/KriteriaController.php`
- Modify: `resources/views/admin/kriteria/create.blade.php`
- Modify: `resources/views/admin/kriteria/edit.blade.php`

- [ ] **Step 1: Update KriteriaRequest** — `nama_kriteria` rule stays `required|string|max:255` (dropdown sends string value)

- [ ] **Step 2: Update KriteriaController store/update** — after validated, detect if `nama_kriteria` is from dropdown and auto-gen kode:
```php
$data = $request->validated();
$kodeMap = ['Naskah Gagasan Kreatif'=>'A02','Presentasi Gagasan Kreatif'=>'F02','Wawancara Capaian Unggulan'=>'F01','Portofolio Capaian Unggulan'=>'A01'];
if (isset($kodeMap[$data['nama_kriteria']])) {
    $data['kode_kriteria'] = $kodeMap[$data['nama_kriteria']];
} elseif ($data['nama_kriteria'] === '__custom__') {
    $data['nama_kriteria'] = $request->custom_nama_kriteria;
}
```

- [ ] **Step 3: Update `create.blade.php`** — replace text input with dropdown, add JS auto-fill kode

Replace:
```blade
<div class="mb-3">
    <label for="nama_kriteria" class="form-label fw-semibold">Nama Kriteria</label>
    <input type="text" name="nama_kriteria" id="nama_kriteria" ...>
</div>
```
With:
```blade
<div class="mb-3">
    <label class="form-label fw-semibold">Tipe Kriteria</label>
    <select name="nama_kriteria" id="tipe_kriteria" class="form-select" onchange="onTipeChange(this)">
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
Add JS:
```blade
@push('scripts')
<script>
function onTipeChange(sel) {
    var kode = document.getElementById('kode_kriteria');
    var opt = sel.options[sel.selectedIndex];
    var isCustom = sel.value === '__custom__';
    document.getElementById('custom_nama_wrapper').style.display = isCustom ? 'block' : 'none';
    if (!isCustom && opt.dataset.kode) {
        kode.value = opt.dataset.kode;
        kode.readOnly = true;
    } else {
        kode.readOnly = false;
    }
}
</script>
@endpush
```

- [ ] **Step 4: Update edit.blade.php** — same pattern with pre-selection from `$kriteria->nama_kriteria`

---

### Task 5: Rubrik Forms — Ganti `label` Input Jadi Dropdown Pilih Kriteria

**Files (5 types × create + edit = 10 files):**
- `resources/views/admin/rubrik_naskah_gk/create.blade.php` and `edit.blade.php`
- `resources/views/admin/rubrik_presentasi_gk/create.blade.php` and `edit.blade.php`
- `resources/views/admin/rubrik_bahasa_inggris/create.blade.php` and `edit.blade.php`
- `resources/views/admin/rubrik_wawancara_cu/create.blade.php` and `edit.blade.php`
- `resources/views/admin/rubrik_cu/create.blade.php` and `edit.blade.php`

**Controller changes (5 files):**
- `app/Http/Controllers/Admin/RubrikNaskahGkController.php`
- `app/Http/Controllers/Admin/RubrikPresentasiGkController.php`
- `app/Http/Controllers/Admin/RubrikBahasaInggrisController.php`
- `app/Http/Controllers/Admin/RubrikWawancaraCuController.php`
- `app/Http/Controllers/Admin/RubrikCapaianUnggulanController.php`

**Request changes (4 files — Capaian Unggulan doesn't use FormRequest):**
- `app/Http/Requests/Admin/RubrikNaskahGkRequest.php`
- `app/Http/Requests/Admin/RubrikPresentasiGkRequest.php`
- `app/Http/Requests/Admin/RubrikBahasaInggrisRequest.php`
- `app/Http/Requests/Admin/RubrikWawancaraCuRequest.php`

- [ ] **Step 1: Update FormRequests** — change `label` from `required` to `nullable`, add `kriteria_id`:
```php
'label' => 'nullable|string|max:255',
'kriteria_id' => 'nullable|exists:kriteria_penilaian,id',
```

- [ ] **Step 2: Update controllers** — resolve label from kriteria, remove resolveLabel() helper added earlier:

In RubrikNaskahGkController::store() and update():
```php
$data = $request->validated();
if ($data['kriteria_id']) {
    $kriteria = \App\Models\KriteriaPenilaian::find($data['kriteria_id']);
    $data['label'] = $kriteria?->nama_kriteria ?? $data['label'];
}
```
Same pattern for all 5 controllers. Remove the `resolveLabel()` helper method added previously.

- [ ] **Step 3: Update create views** — Replace label input block with kriteria dropdown:

For each rubrik type, replace the label text input with:
```blade
<div class="mb-3">
    <label class="form-label">Pilih Kriteria</label>
    <select name="kriteria_id" class="form-control">
        <option value="">-- Default --</option>
        @foreach($kriterias as $k)
        <option value="{{ $k->id }}">{{ $k->nama_kriteria }} ({{ $k->kode_kriteria }})</option>
        @endforeach
    </select>
</div>
```

**Each rubrik type's create view needs `$kriterias`** — add to each controller's `create()` method:
```php
$kriterias = KriteriaPenilaian::where('jenjang_id', $jenjang_id_passed ?? 0)->get();
```
Filter by tipe:
```php
// For naskah_gk:
$kriterias = KriteriaPenilaian::where('jenjang_id', $jenjang_id)
    ->get()->filter(fn($k) => $k->tipe_kriteria === 'naskah_gk');
```

- [ ] **Step 4: Update edit views** — same dropdown with `$rubrik->kriteria_id` pre-selected

---

### Task 6: Custom Template Builder (Rubrik Custom CRUD)

**Files:**
- Create: `app/Http/Controllers/Admin/RubrikCustomController.php`
- Create: `resources/views/admin/rubrik_custom/index.blade.php`
- Create: `resources/views/admin/rubrik_custom/create.blade.php`
- Create: `resources/views/admin/rubrik_custom/edit.blade.php`
- Modify: `routes/web.php`
- Modify: `app/View/Composers/SidebarComposer.php`

- [ ] **Step 1: Add routes in `routes/web.php`**
```php
Route::resource('rubrik-custom', RubrikCustomController::class)->names('admin.rubrik-custom');
```

- [ ] **Step 2: Create `RubrikCustomController`** with CRUD:
- `index()` — list templates
- `create()` — show form builder
- `store()` — save template + fields
- `edit()` — load template with fields
- `update()` — update template + fields
- `destroy()` — delete

- [ ] **Step 3: Create views** with dynamic form builder (add/remove fields via JS)

---

### Task 7: Seed & Backfill Existing Data

**Files:**
- Modify: `database/seeders/DatabaseSeeder.php` (or create new seeder)

- [ ] **Step 1: Create seeder to fill kriteria_penilaian.nama_kriteria from existing rubrik labels**

For each rubrik table, find distinct `label` values per `jenjang_id` and insert into `kriteria_penilaian`:
- naskah_gk labels → `nama_kriteria = label`, `kode_kriteria = 'A02'`
- presentasi_gk labels → `nama_kriteria = label`, `kode_kriteria = 'F02'`
- etc.

- [ ] **Step 2: Backfill `kriteria_id` in rubrik tables**

Match rubrik records to kriteria_penilaian records by `jenjang_id` + label similarity:
```php
$rubriks = RubrikNaskahGk::whereNull('kriteria_id')->get();
foreach ($rubriks as $r) {
    $k = KriteriaPenilaian::where('jenjang_id', $r->jenjang_id)
        ->where('nama_kriteria', $r->label)
        ->first();
    if ($k) $r->update(['kriteria_id' => $k->id]);
}
```

---

### Task 8: Update Label Display in Views

**Files:**
- `app/Http/Controllers/Juri/PenilaianController.php` — read label from `$rubrik->kriteria->nama_kriteria ?? $rubrik->label`
- All index/detail views that display `$rubrik->label` → `$rubrik->kriteria?->nama_kriteria ?? $rubrik->label`

- [ ] **Step 1: Search all files for `->label` usage and update to use fallback:** `$rubrik->kriteria?->nama_kriteria ?? $rubrik->label`

- [ ] **Step 2: Update PenilaianController** — replace `$rubrik->label` with the fallback pattern

---

### Task 9: Final Integration Test

- [ ] **Step 1: Verify all migrations ran** — `php artisan migrate:status`
- [ ] **Step 2: Verify sidebar** — dropdown works, no scroll
- [ ] **Step 3: Create a kriteria** — select dropdown type, verify kode auto-fills, verify data saved
- [ ] **Step 4: Create rubrik item** — select kriteria from dropdown, verify label auto-fills
- [ ] **Step 5: Edit existing rubrik** — verify existing data unchanged, new data works
- [ ] **Step 6: Verify penilaian page** — labels display correctly
