<?php

namespace Database\Seeders;

use App\Models\KriteriaPenilaian;
use Illuminate\Database\Seeder;

class TipeFaktorSeeder extends Seeder
{
    public function run(): void
    {
        // A03 (Bahasa Inggris) dan F03 (Bahasa Inggris Final) = Secondary Factor
        KriteriaPenilaian::whereIn('kode_kriteria', ['A03', 'F03'])
            ->where('tipe_faktor', '!=', 'Secondary Factor')
            ->update(['tipe_faktor' => 'Secondary Factor']);

        // Semua kriteria lain tanpa tipe_faktor = Core Factor
        KriteriaPenilaian::whereNull('tipe_faktor')
            ->update(['tipe_faktor' => 'Core Factor']);
    }
}
