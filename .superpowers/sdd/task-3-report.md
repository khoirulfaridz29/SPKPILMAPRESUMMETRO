# Task 3: Models — Add Relations — Report

## Status: ✅ Complete

## Changes Made

### Modified Files
- `app/Models/KriteriaPenilaian.php` — added 5 rubrik `hasMany` relations + `getTipeKriteriaAttribute()` accessor
- `app/Models/RubrikNaskahGk.php` — added `'kriteria_id'` to `$fillable` + `kriteria()` relation
- `app/Models/RubrikPresentasiGk.php` — same
- `app/Models/RubrikBahasaInggris.php` — same
- `app/Models/RubrikWawancaraCu.php` — same
- `app/Models/RubrikCapaianUnggulan.php` — same

### Created Files
- `app/Models/RubrikCustomTemplate.php` — with `$fillable` and `fields()` relation
- `app/Models/RubrikCustomTemplateField.php` — with `$fillable` and `template()` relation

### Commit
`d91e482` — feat: add model relations for kriteria_id
