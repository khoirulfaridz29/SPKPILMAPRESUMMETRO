# Task 4 Report — Kriteria Penilaian: Dropdown nama_kriteria + Auto Kode

## Status: ✅ SUCCESS

## Files Modified
1. **`app/Http/Requests/Admin/KriteriaRequest.php`** — Added `custom_nama_kriteria` as `nullable|string|max:255` to rules
2. **`app/Http/Controllers/Admin/KriteriaController.php`** — Both `store` and `update` now:
   - Map predefined `nama_kriteria` → auto-fill `kode_kriteria` (A02, F02, F01, A01)
   - Handle `__custom__` → use `custom_nama_kriteria` from request
3. **`resources/views/admin/kriteria/create.blade.php`** — Replaced text input with dropdown + custom wrapper + JS auto-fill
4. **`resources/views/admin/kriteria/edit.blade.php`** — Same dropdown + pre-selection logic + JS

## Verification
- `php artisan route:list` — All 7 `admin/kriteria*` routes present (index, store, create, show, update, destroy, edit)
- `php artisan view:cache` — Blade templates cached successfully

## Commit
- SHA: `19cb5a9`
- Message: `feat: kriteria dropdown nama_kriteria with auto kode`
