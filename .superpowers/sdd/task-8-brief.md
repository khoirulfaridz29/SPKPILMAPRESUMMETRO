# Task 8: Update Label Display in Views & Controllers

## Problem

After the redesign, rubrik `label` is now derived from `kriteria->nama_kriteria`. Any code that directly accesses `$rubrik->label` should use the fallback pattern: `$rubrik->kriteria?->nama_kriteria ?? $rubrik->label`.

## Search & Replace

Search all files for `->label` access on rubrik model instances. Files to check:

### Controller files:
- `app/Http/Controllers/Juri/PenilaianController.php` — `$rubrik->label` usage
- SidebarComposer already handles labels via `$rubrikLabels` array, but check if it still uses raw `->label`

### View files that display rubrik labels:

Run `grep -r "->label" resources/views/` to find all occurrences. Common patterns:
- `{{ $rubrik->label }}` → `{{ $rubrik->kriteria?->nama_kriteria ?? $rubrik->label }}`
- `{{ $rubrikLabel ?? $rubrik->label }}` similar

### Index views for rubrik types:
- `resources/views/admin/rubrik_naskah_gk/index.blade.php`
- `resources/views/admin/rubrik_presentasi_gk/index.blade.php`
- `resources/views/admin/rubrik_bahasa_inggris/index.blade.php`
- `resources/views/admin/rubrik_wawancara_cu/index.blade.php`
- `resources/views/admin/rubrik_cu/index.blade.php`

### Juri views:
- `resources/views/juri/penilaian/*.blade.php`

## Important

- Only change `->label` when it's on a rubrik model (NaskahGk, PresentasiGk, etc.)
- Don't change unrelated `->label` usage on other models
- Use the exact fallback pattern: `$rubrik->kriteria?->nama_kriteria ?? $rubrik->label`

## Verification

Run `php artisan view:cache` and `php artisan serve` to verify.
