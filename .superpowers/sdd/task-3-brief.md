# Task 3: Models — Add Relations

## Files to Modify
- `app/Models/KriteriaPenilaian.php` — add rubrik relations + `tipe_kriteria` accessor
- `app/Models/RubrikNaskahGk.php` — add `kriteria()` relation + `kriteria_id` to fillable
- `app/Models/RubrikPresentasiGk.php` — same
- `app/Models/RubrikBahasaInggris.php` — same
- `app/Models/RubrikWawancaraCu.php` — same
- `app/Models/RubrikCapaianUnggulan.php` — same

## Files to Create
- `app/Models/RubrikCustomTemplate.php`
- `app/Models/RubrikCustomTemplateField.php`

## Details

### Step 1: Add `kriteria_id` to `$fillable` + `kriteria()` relation in all 5 rubrik models

In each model, add `'kriteria_id'` to the `$fillable` array, and add:

```php
public function kriteria()
{
    return $this->belongsTo(KriteriaPenilaian::class, 'kriteria_id');
}
```

### Step 2: Add `tipe_kriteria` accessor to `KriteriaPenilaian`

Add this accessor to determine which rubrik type a kriteria belongs to:

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

### Step 3: Create `RubrikCustomTemplate` model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikCustomTemplate extends Model
{
    protected $fillable = ['nama_template'];

    public function fields()
    {
        return $this->hasMany(RubrikCustomTemplateField::class, 'template_id');
    }
}
```

### Step 4: Create `RubrikCustomTemplateField` model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RubrikCustomTemplateField extends Model
{
    protected $fillable = ['template_id', 'nama_field', 'tipe_input', 'urutan', 'bobot'];

    public function template()
    {
        return $this->belongsTo(RubrikCustomTemplate::class, 'template_id');
    }
}
```
