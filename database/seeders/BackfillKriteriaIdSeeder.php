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
