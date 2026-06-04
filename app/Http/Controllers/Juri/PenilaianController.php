<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use App\Models\PenugasanJuri;
use App\Models\Penilaian;
use App\Models\KriteriaPenilaian;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    public function index()
    {
        $penugasans = PenugasanJuri::with('pendaftaran.mahasiswa.user')
            ->where('juri_id', Auth::id())->get();
        return view('juri.penilaian.index', compact('penugasans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $kriterias = KriteriaPenilaian::all();
        $pendaftaran->load('mahasiswa.user', 'berkas');

        $rubrik_naskah = \App\Models\RubrikNaskahGk::all();
        $rubrik_presentasi = \App\Models\RubrikPresentasiGk::all();
        $rubrik_inggris = \App\Models\RubrikBahasaInggris::all();
        $rubrik_wawancara_cu = \App\Models\RubrikWawancaraCu::all();

        $penilaian_naskah = \App\Models\PenilaianNaskahGk::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)->pluck('nilai_input', 'rubrik_naskah_gk_id');
        $penilaian_presentasi = \App\Models\PenilaianPresentasiGk::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)->pluck('nilai_input', 'rubrik_presentasi_gk_id');
        $penilaian_inggris = \App\Models\PenilaianBahasaInggris::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)->pluck('nilai_input', 'rubrik_bahasa_inggris_id');
        $penilaian_wawancara_cu = \App\Models\PenilaianWawancaraCu::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)->pluck('nilai_input', 'rubrik_wawancara_cu_id');

        // hitung rekomendasi skor Capaian Unggulan (A01) dari portofolio yang tervalidasi admin
        $portofolios = \App\Models\PortofolioCu::where('pendaftaran_id', $pendaftaran->id)
            ->where('status_validasi', 'Valid')->get();
        $total_rekomendasi = 0;
        foreach ($portofolios as $porto) {
            $skor = $porto->skor_rekomendasi;
            if ($skor) {
                // Ambil semua angka, lalu pakai NILAI TENGAH bila berupa range.
                // Contoh: "40-50" => (40+50)/2 = 45 ; "80" => 80
                preg_match_all('/\d+(?:\.\d+)?/', $skor, $matches);
                if (!empty($matches[0])) {
                    $angka = array_map('floatval', $matches[0]);
                    $total_rekomendasi += array_sum($angka) / count($angka);
                }
            }
        }
        if ($total_rekomendasi > 100) $total_rekomendasi = 100;

        // ambil nilai kriteria global yang sudah tersimpan (jika ada)
        $kriterias_pluck = $kriterias->pluck('id', 'kode_kriteria');
        $existing_a01 = isset($kriterias_pluck['A01']) ? Penilaian::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)
            ->where('kriteria_id', $kriterias_pluck['A01'])->value('nilai_input') : null;

        return view('juri.penilaian.show', compact(
            'pendaftaran', 'kriterias', 'rubrik_naskah', 'rubrik_presentasi', 'rubrik_inggris', 'rubrik_wawancara_cu',
            'penilaian_naskah', 'penilaian_presentasi', 'penilaian_inggris', 'penilaian_wawancara_cu',
            'total_rekomendasi', 'existing_a01', 'portofolios' //ini yang aku tambahkan
        ));
    }

    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        try {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE penilaian MODIFY COLUMN nilai_input DECIMAL(8,4) NOT NULL");
        } catch (\Exception $e) {
            // ignore
        }

        // Menyimpan nilai detail Naskah GK
        if ($request->has('naskah')) {
            foreach ($request->naskah as $rubrikId => $nilai) {
                \App\Models\PenilaianNaskahGk::updateOrCreate(
                    ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'rubrik_naskah_gk_id' => $rubrikId],
                    ['nilai_input' => $nilai]
                );
            }
        }

        // Menyimpan nilai detail Presentasi GK
        if ($request->has('presentasi')) {
            foreach ($request->presentasi as $rubrikId => $nilai) {
                \App\Models\PenilaianPresentasiGk::updateOrCreate(
                    ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'rubrik_presentasi_gk_id' => $rubrikId],
                    ['nilai_input' => $nilai]
                );
            }
        }

        // Menyimpan nilai detail Bahasa Inggris
        if ($request->has('inggris')) {
            foreach ($request->inggris as $rubrikId => $nilai) {
                \App\Models\PenilaianBahasaInggris::updateOrCreate(
                    ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'rubrik_bahasa_inggris_id' => $rubrikId],
                    ['nilai_input' => $nilai]
                );
            }
        }

        // Menyimpan nilai detail Wawancara CU
        if ($request->has('wawancara_cu')) {
            foreach ($request->wawancara_cu as $rubrikId => $nilai) {
                \App\Models\PenilaianWawancaraCu::updateOrCreate(
                    ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'rubrik_wawancara_cu_id' => $rubrikId],
                    ['nilai_input' => $nilai]
                );
            }
        }

        // --- HITUNG AGREGASI UNTUK KRITERIA PENILAIAN SPK ---
        $kriterias = KriteriaPenilaian::all()->pluck('id', 'kode_kriteria');

        // 1. Capaian Unggulan (CU) Berkas (A01)
        if (isset($kriterias['A01']) && $request->has('nilai_a01')) {
            // Hitung nilai rekomendasi portofolio (nilai tengah range) sebagai acuan batas.
            $rekomendasi = 0;
            $portofolios = \App\Models\PortofolioCu::where('pendaftaran_id', $pendaftaran->id)
                ->where('status_validasi', 'Valid')->get();
            foreach ($portofolios as $porto) {
                $skor = $porto->skor_rekomendasi;
                if ($skor) {
                    preg_match_all('/\d+(?:\.\d+)?/', $skor, $m);
                    if (!empty($m[0])) {
                        $angka = array_map('floatval', $m[0]);
                        $rekomendasi += array_sum($angka) / count($angka);
                    }
                }
            }
            if ($rekomendasi > 100) $rekomendasi = 100;

            // Juri sebagai tim penilai boleh menyesuaikan maksimal +/- 10 dari rekomendasi.
            $nilai_a01 = (float) $request->nilai_a01;
            $batasBawah = $rekomendasi - 10;
            $batasAtas  = $rekomendasi + 10;
            if ($nilai_a01 < $batasBawah) $nilai_a01 = $batasBawah;
            if ($nilai_a01 > $batasAtas)  $nilai_a01 = $batasAtas;
            if ($nilai_a01 > 100) $nilai_a01 = 100; // tetap dibatasi skala maksimal 100
            if ($nilai_a01 < 0)   $nilai_a01 = 0;   // pengaman agar tidak negatif

            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['A01']],
                ['nilai_input' => $nilai_a01]
            );
        }

        // 2. Gagasan Kreatif (GK) Naskah (A02)
        if (isset($kriterias['A02'])) {
            $scores = \App\Models\PenilaianNaskahGk::where('juri_id', Auth::id())
                ->where('pendaftaran_id', $pendaftaran->id)
                ->with('rubrik')
                ->get();
            $sum_naskah = 0;
            foreach ($scores as $s) {
                if ($s->rubrik) {
                    $sum_naskah += $s->nilai_input * ($s->rubrik->bobot / 100.0);
                }
            }
            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['A02']],
                ['nilai_input' => $sum_naskah]
            );
        }

        // 3. Bahasa Inggris (BI) Video (A03) & 6. Bahasa Inggris (BI) Lisan (F03)
        // Rubrik B. Inggris tidak memiliki kolom bobot (hanya rentang skor per field),
        // sehingga setiap field diberi bobot setara. Memakai rata-rata (avg) agar
        // hasilnya tetap pada skala 60-100, konsisten dengan kriteria lain.
        // (Sebelumnya memakai sum() yang membuat nilai membengkak bila field > 1.)
        $sum_inggris = \App\Models\PenilaianBahasaInggris::where('juri_id', Auth::id())
            ->where('pendaftaran_id', $pendaftaran->id)->avg('nilai_input') ?? 0;

        if (isset($kriterias['A03'])) {
            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['A03']],
                ['nilai_input' => $sum_inggris]
            );
        }

        // 4. Capaian Unggulan (CU) Wawancara (F01)
        if (isset($kriterias['F01'])) {
            $scores = \App\Models\PenilaianWawancaraCu::where('juri_id', Auth::id())
                ->where('pendaftaran_id', $pendaftaran->id)
                ->with('rubrikWawancaraCu')
                ->get();
            $sum_wawancara_cu = 0;
            foreach ($scores as $s) {
                if ($s->rubrikWawancaraCu) {
                    $sum_wawancara_cu += $s->nilai_input * ($s->rubrikWawancaraCu->bobot / 100.0);
                }
            }
            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['F01']],
                ['nilai_input' => $sum_wawancara_cu]
            );
        }

        // 5. Gagasan Kreatif (GK) Presentasi (F02)
        if (isset($kriterias['F02'])) {
            $scores = \App\Models\PenilaianPresentasiGk::where('juri_id', Auth::id())
                ->where('pendaftaran_id', $pendaftaran->id)
                ->with('rubrik')
                ->get();
            $sum_presentasi = 0;
            foreach ($scores as $s) {
                if ($s->rubrik) {
                    $sum_presentasi += $s->nilai_input * ($s->rubrik->bobot / 100.0);
                }
            }
            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['F02']],
                ['nilai_input' => $sum_presentasi]
            );
        }

        if (isset($kriterias['F03'])) {
            Penilaian::updateOrCreate(
                ['juri_id' => Auth::id(), 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $kriterias['F03']],
                ['nilai_input' => $sum_inggris]
            );
        }

        return redirect()->route('juri.penilaian.index')
            ->with('success', 'Penilaian detail dan kriteria global berhasil disimpan.');
    }

    public function nilai()
    {
        $penugasans = PenugasanJuri::with('pendaftaran.mahasiswa.user', 'pendaftaran.penilaian')
            ->where('juri_id', Auth::id())->get();
        return view('juri.penilaian.nilai', compact('penugasans'));
    }
}