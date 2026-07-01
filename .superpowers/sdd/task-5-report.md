# Task 5 Report: Rubrik Forms — Replace Label Input with Kriteria Dropdown

## Status: ✅ Complete

## Summary
Replaced `label_select` dropdown + `toggleLabelCustom()` JS with `kriteria_id` dropdown referencing `kriteria_penilaian` table across all 5 rubrik modules.

## Files Modified

### FormRequests (4 files)
- `app/Http/Requests/Admin/RubrikNaskahGkRequest.php` — added `kriteria_id => nullable|exists:kriteria_penilaian,id`
- `app/Http/Requests/Admin/RubrikPresentasiGkRequest.php` — same
- `app/Http/Requests/Admin/RubrikBahasaInggrisRequest.php` — same
- `app/Http/Requests/Admin/RubrikWawancaraCuRequest.php` — same

### Controllers (5 files)
- `app/Http/Controllers/Admin/RubrikNaskahGkController.php` — removed `resolveLabel()`, added kriteria resolution logic, added `$kriterias` to create/edit
- `app/Http/Controllers/Admin/RubrikPresentasiGkController.php` — same
- `app/Http/Controllers/Admin/RubrikBahasaInggrisController.php` — same
- `app/Http/Controllers/Admin/RubrikWawancaraCuController.php` — same
- `app/Http/Controllers/Admin/RubrikCapaianUnggulanController.php` — added `kriteria_id` validation, added kriteria resolution, added `$kriterias` to create/edit

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

## Key Changes
- All `label_select` dropdowns, `label_custom` inputs, and `toggleLabelCustom()` JS removed
- `resolveLabel()` private methods removed from all controllers
- Label is now auto-resolved from selected kriteria's `nama_kriteria` via `KriteriaPenilaian::find()`
- Tipe-based filtering uses the `tipe_kriteria` accessor on KriteriaPenilaian model
- `RubrikCapaianUnggulanController` (which doesn't use FormRequest) includes inline `kriteria_id` validation

## Verification
- `php artisan view:cache` — ✅ passed (no Blade errors)

## Commit
`c397fef` — feat: rubrik forms kriteria_id dropdown, remove label_select
