<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use App\Models\PenugasanJuri;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class D3TestDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // ============================================
        // 1. DUPLIKAT RUBRIK S1 UNTUK D3 (jenjang_id=2)
        // ============================================

        // Rubrik Naskah GK → label "Produk Inovatif (PI)"
        $naskahS1 = DB::table('rubrik_naskah_gks')->where('jenjang_id', 1)->get();
        foreach ($naskahS1 as $r) {
            DB::table('rubrik_naskah_gks')->insert([
                'jenjang_id' => 2,
                'label' => 'Produk Inovatif (PI)',
                'aspek_penilaian' => $r->aspek_penilaian,
                'kriteria_penilaian' => $r->kriteria_penilaian,
                'bobot' => $r->bobot,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Rubrik Presentasi GK → label "Presentasi PI"
        $presentasiS1 = DB::table('rubrik_presentasi_gks')->where('jenjang_id', 1)->get();
        foreach ($presentasiS1 as $r) {
            DB::table('rubrik_presentasi_gks')->insert([
                'jenjang_id' => 2,
                'label' => 'Presentasi PI',
                'aspek_penilaian' => $r->aspek_penilaian,
                'kriteria_penilaian' => $r->kriteria_penilaian,
                'bobot' => $r->bobot,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Rubrik Bahasa Inggris → label "Bahasa Inggris"
        $bInggrisS1 = DB::table('rubrik_bahasa_inggris')->where('jenjang_id', 1)->get();
        foreach ($bInggrisS1 as $r) {
            DB::table('rubrik_bahasa_inggris')->insert([
                'jenjang_id' => 2,
                'label' => 'Bahasa Inggris',
                'field' => $r->field,
                'excellent_score' => $r->excellent_score,
                'excellent_criteria' => $r->excellent_criteria,
                'good_score' => $r->good_score,
                'good_criteria' => $r->good_criteria,
                'fair_score' => $r->fair_score,
                'fair_criteria' => $r->fair_criteria,
                'poor_score' => $r->poor_score,
                'poor_criteria' => $r->poor_criteria,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Rubrik Wawancara CU → label "Wawancara CU"
        $wawancaraS1 = DB::table('rubrik_wawancara_cu')->where('jenjang_id', 1)->get();
        foreach ($wawancaraS1 as $r) {
            DB::table('rubrik_wawancara_cu')->insert([
                'jenjang_id' => 2,
                'label' => 'Wawancara CU',
                'kriteria_penilaian' => $r->kriteria_penilaian,
                'bobot' => $r->bobot,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Rubrik Capaian Unggulan (sama untuk D3)
        $cuS1 = DB::table('rubrik_capaian_unggulans')->where('jenjang_id', 1)->get();
        foreach ($cuS1 as $r) {
            DB::table('rubrik_capaian_unggulans')->insert([
                'jenjang_id' => 2,
                'bidang' => $r->bidang,
                'wujud_capaian_unggulan' => $r->wujud_capaian_unggulan,
                'kode_internasional' => $r->kode_internasional,
                'skor_internasional' => $r->skor_internasional,
                'kode_regional' => $r->kode_regional,
                'skor_regional' => $r->skor_regional,
                'kode_nasional' => $r->kode_nasional,
                'skor_nasional' => $r->skor_nasional,
                'kode_provinsi' => $r->kode_provinsi,
                'skor_provinsi' => $r->skor_provinsi,
                'kode_kab_kota' => $r->kode_kab_kota,
                'skor_kab_kota' => $r->skor_kab_kota,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ============================================
        // 2. DATA 5 MAHASISWA D3
        // ============================================

        $d3Mahasiswa = [
            ['username' => 'dina_amelia', 'nama' => 'Dina Amelia', 'nim' => '24610001', 'prodi' => 'Akuntansi', 'ipk' => 3.85],
            ['username' => 'rizky_maulana', 'nama' => 'Rizky Maulana', 'nim' => '24620002', 'prodi' => 'Manajemen', 'ipk' => 3.75],
            ['username' => 'siti_nurhaliza', 'nama' => 'Siti Nurhaliza', 'nim' => '24630003', 'prodi' => 'Ilmu Hukum', 'ipk' => 3.90],
            ['username' => 'ahmad_fauzi', 'nama' => 'Ahmad Fauzi', 'nim' => '24610004', 'prodi' => 'Akuntansi', 'ipk' => 3.65],
            ['username' => 'putri_wulandari', 'nama' => 'Putri Wulandari', 'nim' => '24620005', 'prodi' => 'Manajemen', 'ipk' => 3.80],
        ];

        $juriIds = [3, 4, 5];

        foreach ($d3Mahasiswa as $i => $data) {
            // Buat user
            $user = User::create([
                'username' => $data['username'],
                'password' => $password,
                'nama_lengkap' => $data['nama'],
                'role' => 'mahasiswa',
            ]);

            // Buat mahasiswa
            $mhs = Mahasiswa::create([
                'user_id' => $user->id,
                'jenjang_id' => 2,
                'nim' => $data['nim'],
                'program_studi' => $data['prodi'],
                'ipk' => $data['ipk'],
                'pernah_pilmapres' => match ($i) {
                    0 => 'Nasional',
                    1 => 'Belum Pernah',
                    2 => 'Lokal',
                    3 => 'Belum Pernah',
                    4 => 'Lokal',
                    default => 'Belum Pernah',
                },
            ]);

            // Buat pendaftaran
            $pendaftaran = Pendaftaran::create([
                'mahasiswa_id' => $mhs->id,
                'status_berkas' => 'Lengkap',
                'status_seleksi' => 'Lolos Tahap 1',
                'is_submitted' => true,
                'tanggal_daftar' => now()->subDays(5 - $i)->format('Y-m-d'),
            ]);

            // Assign 3 juri ke masing-masing pendaftaran
            foreach ($juriIds as $juriId) {
                PenugasanJuri::create([
                    'juri_id' => $juriId,
                    'pendaftaran_id' => $pendaftaran->id,
                ]);
            }
        }

        // ============================================
        // 3. BUAT JADWAL AGAR PENDAFTARAN TERBUKA
        // ============================================
        DB::table('jadwal')->insert([
            'jenjang_id' => 2,
            'kegiatan' => 'Pendaftaran D3 PILMAPRES 2026',
            'tanggal_mulai' => now()->subMonth()->format('Y-m-d'),
            'tanggal_selesai' => now()->addMonth()->format('Y-m-d'),
            'keterangan' => 'Pendaftaran untuk mahasiswa Diploma (D3)',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Data test D3 berhasil dibuat:');
        $this->command->info('   5 Mahasiswa D3 + User');
        $this->command->info('   5 Pendaftaran (Lolos Tahap 1)');
        $this->command->info('   15 Penugasan Juri (3 juri x 5 pendaftaran)');
        $this->command->info('   Rubrik D3 (copy dari S1)');
        $this->command->info('Password semua user: password');
    }
}
