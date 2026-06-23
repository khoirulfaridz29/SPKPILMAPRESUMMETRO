<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => '52', 'nama' => 'Teknik Mesin'],
            ['kode' => '51', 'nama' => 'Teknik Sipil'],
            ['kode' => '43', 'nama' => 'Ilmu Komputer'],
            ['kode' => '11', 'nama' => 'Pendidikan Ekonomi'],
            ['kode' => '21', 'nama' => 'Pendidikan Matematika'],
            ['kode' => '71', 'nama' => 'Akuntansi'],
            ['kode' => '72', 'nama' => 'Manajemen'],
            ['kode' => '61', 'nama' => 'Ilmu Hukum'],
            ['kode' => '18', 'nama' => 'Pendidikan Teknologi Informasi'],
        ];

        foreach ($data as $item) {
            ProgramStudi::firstOrCreate(
                ['kode' => $item['kode']],
                ['nama' => $item['nama']]
            );
        }
    }
}
