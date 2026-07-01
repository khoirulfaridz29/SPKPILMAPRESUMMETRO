# Task 2 Report — Migration: Add kriteria_id + Create Custom Template Tables

## Status: ✅ SUCCESS

## Files Created
1. `database/migrations/2026_07_01_231227_add_kriteria_id_to_rubrik_tables.php`
   - Added nullable `kriteria_id` FK → `kriteria_penilaian` with `nullOnDelete()` after `jenjang_id`
   - Applied to: `rubrik_naskah_gks`, `rubrik_presentasi_gks`, `rubrik_bahasa_inggris`, `rubrik_wawancara_cu`, `rubrik_capaian_unggulans`

2. `database/migrations/2026_07_01_231250_create_rubrik_custom_templates_tables.php`
   - Created `rubrik_custom_templates` (id, nama_template, timestamps)
   - Created `rubrik_custom_template_fields` (id, template_id FK → cascadeOnDelete, nama_field, tipe_input enum, urutan, bobot decimal(5,2) nullable, timestamps)

## Migration Test
- `php artisan migrate` — both migrations ran successfully

## Notes
- Table names corrected from brief's singular form to match actual plural database tables (e.g., `rubrik_naskah_gks` not `rubrik_naskah_gk`)
- Used `fn()` arrow syntax for single-statement closures in `up()`, regular closures in `down()` (PHP arrow functions don't support brace blocks)
- Current HEAD: `6c0a965`
