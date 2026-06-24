<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use App\Models\PenugasanJuri;
use App\Models\Penilaian;
use App\Models\KriteriaPenilaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');
        $juriIds = User::where('role', 'juri')->pluck('id')->toArray();
        if (count($juriIds) < 3) {
            $this->command->error('Need at least 3 juri users');
            return;
        }

        $s1Kriterias = KriteriaPenilaian::where('jenjang_id', 1)->pluck('id', 'kode_kriteria');
        $d3Kriterias = KriteriaPenilaian::where('jenjang_id', 2)->pluck('id', 'kode_kriteria');

        $s1Data = [
            ['nama' => 'Ahmad Rizki Pratama',     'nim' => '22530001'],
            ['nama' => 'Siti Nurhaliza',           'nim' => '22530002'],
            ['nama' => 'Bambang Supriyadi',        'nim' => '22530003'],
            ['nama' => 'Dewi Kartika Sari',        'nim' => '22530004'],
            ['nama' => 'Rahmat Hidayat',           'nim' => '22530005'],
            ['nama' => 'Fitriani Ramadhani',       'nim' => '22530006'],
            ['nama' => 'Hendra Gunawan',           'nim' => '22530007'],
        ];

        $d3Data = [
            ['nama' => 'Rina Marlina',             'nim' => '24610006'],
            ['nama' => 'Agus Setiawan',            'nim' => '24610007'],
            ['nama' => 'Indah Permata Sari',       'nim' => '24620008'],
            ['nama' => 'Dedi Kurniawan',           'nim' => '24610009'],
            ['nama' => 'Putri Ayu Lestari',        'nim' => '24620010'],
        ];

        $existingNims = Mahasiswa::pluck('nim')->toArray();

        $created = 0;
        foreach ([
            ['data' => $s1Data, 'jenjang_id' => 1, 'kriterias' => $s1Kriterias, 'prodi' => 'Ilmu Komputer'],
            ['data' => $d3Data, 'jenjang_id' => 2, 'kriterias' => $d3Kriterias, 'prodi' => 'Manajemen'],
        ] as $cfg) {
            foreach ($cfg['data'] as $d) {
                if (in_array($d['nim'], $existingNims)) continue;

                $username = strtolower(str_replace(' ', '', $d['nama'])) . rand(100, 999);

                $user = User::create([
                    'nama_lengkap' => $d['nama'],
                    'username' => $username,
                    'password' => $password,
                    'role' => 'mahasiswa',
                ]);

                $mhs = Mahasiswa::create([
                    'user_id' => $user->id,
                    'nim' => $d['nim'],
                    'jenjang_id' => $cfg['jenjang_id'],
                    'program_studi' => $cfg['prodi'],
                    'ipk' => round(2.5 + mt_rand(0, 150) / 100, 2),
                    'pernah_pilmapres' => ['Belum Pernah', 'Lokal', 'Nasional'][array_rand([0, 1, 2])],
                ]);

                $pendaftaran = Pendaftaran::create([
                    'mahasiswa_id' => $mhs->id,
                    'tanggal_daftar' => now()->subDays(rand(10, 30)),
                    'status_berkas' => 'Lengkap',
                    'status_seleksi' => 'Lolos Tahap 1',
                    'is_submitted' => true,
                ]);

                foreach ($juriIds as $juriId) {
                    PenugasanJuri::create([
                        'pendaftaran_id' => $pendaftaran->id,
                        'juri_id' => $juriId,
                    ]);

                    foreach ($cfg['kriterias'] as $kode => $kriteriaId) {
                        Penilaian::create([
                            'juri_id' => $juriId,
                            'pendaftaran_id' => $pendaftaran->id,
                            'kriteria_id' => $kriteriaId,
                            'nilai_input' => round(60 + mt_rand(0, 400) / 10, 1),
                        ]);
                    }
                }

                $created++;
                $this->command->info('Created: ' . $d['nama'] . ' (' . $d['nim'] . ')');
            }
        }

        $this->command->info("Total created: $created mahasiswa");
    }
}
