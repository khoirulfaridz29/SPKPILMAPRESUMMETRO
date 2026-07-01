# Task 7: Seed & Backfill Existing Data

## Files
- Modify: `database/seeders/DatabaseSeeder.php` (or create dedicated seeder)

## Context

Existing rubrik records have `label` values like "Naskah Gagasan Kreatif", "Wawancara Capaian Unggulan", etc. but don't have `kriteria_id` set (it's NULL). We need to:

1. Ensure `kriteria_penilaian` has entries matching the existing rubrik labels
2. Backfill `kriteria_id` in all 5 rubrik tables

## Step 1: Create Seeder

Run `php artisan make:seeder BackfillKriteriaIdSeeder`

The seeder should:

```php
<?php

namespace Database\Seeders;

use App\Models\KriteriaPenilaian;
use App\Models\RubrikNaskahGk;
use App\Models\RubrikPresentasiGk;
use App\Models\RubrikBahasaInggris;
use App\Models\RubrikWawancaraCu;
use App\Models\RubrikCapaianUnggulan;
use Illuminate\Database\Seeder;

class BackfillKriteriaIdSeeder extends Seeder
{
    private function getKodeForRubrik(string $tableName): string
    {
        return match($tableName) {
            'rubrik_naskah_gk' => 'A02',
            'rubrik_presentasi_gk' => 'F02',
            'rubrik_bahasa_inggris' => 'A03',
            'rubrik_wawancara_cu' => 'F01',
            'rubrik_capaian_unggulan' => 'A01',
            default => 'C01',
        };
    }

    private function ensureKriteria(string $tableName, string $namaKriteria, int $jenjangId): ?KriteriaPenilaian
    {
        $kode = $this->getKodeForRubrik($tableName);
        return KriteriaPenilaian::firstOrCreate(
            ['kode_kriteria' => $kode, 'jenjang_id' => $jenjangId],
            [
                'nama_kriteria' => $namaKriteria,
                'jenis_faktor' => in_array($kode, ['A01','A02','A03']) ? 'Tahap Awal' : 'Tahap Final',
                'tipe_faktor' => in_array($kode, ['A01','A02','A03']) ? 'Secondary Factor' : 'Core Factor',
                'nilai_target' => 3,
                'bobot' => 0,
            ]
        );
    }

    public function run(): void
    {
        // Process RubrikNaskahGk
        foreach (RubrikNaskahGk::whereNull('kriteria_id')->get() as $r) {
            $label = $r->label ?: 'Naskah Gagasan Kreatif';
            $kriteria = $this->ensureKriteria('rubrik_naskah_gk', $label, $r->jenjang_id);
            $r->update(['kriteria_id' => $kriteria->id]);
        }

        // Process RubrikPresentasiGk
        foreach (RubrikPresentasiGk::whereNull('kriteria_id')->get() as $r) {
            $label = $r->label ?: 'Presentasi Gagasan Kreatif';
            $kriteria = $this->ensureKriteria('rubrik_presentasi_gk', $label, $r->jenjang_id);
            $r->update(['kriteria_id' => $kriteria->id]);
        }

        // Process RubrikBahasaInggris — can be A03 or F03 based on jenis_faktor of parent kriteria
        foreach (RubrikBahasaInggris::whereNull('kriteria_id')->get() as $r) {
            $label = $r->label ?: 'Bahasa Inggris';
            // Try A03 first (Tahap Awal)
            $kriteria = KriteriaPenilaian::where('jenjang_id', $r->jenjang_id)
                ->where('kode_kriteria', 'A03')
                ->first();
            if (!$kriteria) {
                $kriteria = $this->ensureKriteria('rubrik_bahasa_inggris', $label, $r->jenjang_id);
            }
            $r->update(['kriteria_id' => $kriteria->id]);
        }

        // Process RubrikWawancaraCu
        foreach (RubrikWawancaraCu::whereNull('kriteria_id')->get() as $r) {
            $label = $r->label ?: 'Wawancara Capaian Unggulan';
            $kriteria = $this->ensureKriteria('rubrik_wawancara_cu', $label, $r->jenjang_id);
            $r->update(['kriteria_id' => $kriteria->id]);
        }

        // Process RubrikCapaianUnggulan
        foreach (RubrikCapaianUnggulan::whereNull('kriteria_id')->get() as $r) {
            $label = 'Portofolio Capaian Unggulan';
            $kriteria = $this->ensureKriteria('rubrik_capaian_unggulan', $label, $r->jenjang_id);
            $r->update(['kriteria_id' => $kriteria->id]);
        }

        $this->command->info('Backfill kriteria_id completed for all rubrik tables.');
    }
}
```

## Step 2: Register in DatabaseSeeder

In `database/seeders/DatabaseSeeder.php`, add:
```php
$this->call(BackfillKriteriaIdSeeder::class);
```

## Step 3: Run

Run: `php artisan db:seed --class=BackfillKriteriaIdSeeder`

Verify with: `php artisan tinker` → `App\Models\RubrikNaskahGk::whereNull('kriteria_id')->count()` should be 0.

## Step 4: Commit

Commit with message: "feat: backfill kriteria_id for existing rubrik records"
