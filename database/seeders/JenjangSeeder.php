<?php

namespace Database\Seeders;

use App\Models\Jenjang;
use Illuminate\Database\Seeder;

class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        Jenjang::create([
            'kode_jenjang' => 'S1',
            'nama_jenjang' => 'Sarjana',
            'deskripsi' => 'Program Sarjana (S1) - Bobot: CU 35%, GK 35%, BI 30%',
        ]);

        Jenjang::create([
            'kode_jenjang' => 'D3',
            'nama_jenjang' => 'Diploma',
            'deskripsi' => 'Program Diploma (D3/D4) - Bobot: CU 40%, PI 40%, BI 20%',
        ]);
    }
}
