<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Penilaian;
use App\Models\KriteriaPenilaian;
use App\Models\HasilPenilaian;
use App\Models\PortofolioCu;
use App\Models\PenugasanJuri;
use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    use \App\Traits\Notifiable;

    public function index(Request $request)
    {
        $query = Pendaftaran::with('mahasiswa.user', 'mahasiswa.jenjang', 'penilaian', 'hasil')
            ->where('status_seleksi', 'Lolos Tahap 1');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_daftar', $request->tahun);
        }

        $pesertaLolos = $query->get();
        $jenjangList = \App\Models\Jenjang::orderBy('id')->get();
        $grouped = $pesertaLolos->groupBy(fn($p) => $p->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana');

        $hasilList = HasilPenilaian::with('pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang', 'pendaftaran.penilaian.kriteria')
            ->orderBy('ranking')->get();
        $hasilGrouped = $hasilList->groupBy(fn($h) => $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? 'Sarjana');

        $kriterias = KriteriaPenilaian::with('jenjang')->get();

        $juries = \App\Models\User::where('role', 'juri')->orderBy('id')->get(['id', 'nama_lengkap']);

        $bobotPerJenjang = [];
        foreach ($kriterias as $k) {
            $jid = $k->jenjang_id ?? 1;
            if (!isset($bobotPerJenjang[$jid])) {
                $bobotPerJenjang[$jid] = [];
            }
            $bobotPerJenjang[$jid][$k->kode_kriteria] = $k->bobot;
        }

        $years = Pendaftaran::where('status_seleksi', 'Lolos Tahap 1')
            ->selectRaw('YEAR(tanggal_daftar) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.perhitungan.index', compact('grouped', 'jenjangList', 'years', 'hasilGrouped', 'kriterias', 'juries', 'bobotPerJenjang'));
    }

    private function convertToScale10($score)
    {
        if ($score <= 12.0) return 1;
        if ($score <= 15.0) return 2;
        if ($score <= 18.0) return 3;
        if ($score <= 21.0) return 4;
        if ($score <= 24.0) return 5;
        if ($score <= 26.0) return 6;
        if ($score <= 28.0) return 7;
        if ($score <= 30.0) return 8;
        if ($score <= 32.0) return 9;
        return 10;
    }

    private function getGapWeight($gap)
    {
        return match ($gap) {
            0 => 10.0,
            1 => 9.5,
            -1 => 9.0,
            2 => 8.5,
            -2 => 8.0,
            3 => 7.5,
            -3 => 7.0,
            4 => 6.5,
            -4 => 6.0,
            5 => 5.5,
            -5 => 5.0,
            -6 => 4.0,
            -7 => 3.0,
            -8 => 2.0,
            -9 => 1.0,
            default => $gap < 0 ? max(1.0, 10.0 + $gap) : max(1.0, 10.0 - $gap)
        };
    }

    public static function convertToScale10Static($score)
    {
        if ($score <= 12.0) return 1;
        if ($score <= 15.0) return 2;
        if ($score <= 18.0) return 3;
        if ($score <= 21.0) return 4;
        if ($score <= 24.0) return 5;
        if ($score <= 26.0) return 6;
        if ($score <= 28.0) return 7;
        if ($score <= 30.0) return 8;
        if ($score <= 32.0) return 9;
        return 10;
    }

    public static function getGapWeightStatic($gap)
    {
        return match ($gap) {
            0 => 10.0,
            1 => 9.5,
            -1 => 9.0,
            2 => 8.5,
            -2 => 8.0,
            3 => 7.5,
            -3 => 7.0,
            4 => 6.5,
            -4 => 6.0,
            5 => 5.5,
            -5 => 5.0,
            -6 => 4.0,
            -7 => 3.0,
            -8 => 2.0,
            -9 => 1.0,
            default => $gap < 0 ? max(1.0, 10.0 + $gap) : max(1.0, 10.0 - $gap)
        };
    }

    public function proses(Request $request)
    {
        $allKriterias = KriteriaPenilaian::with('jenjang')->get();
        $kriteriasByJenjang = $allKriterias->groupBy('jenjang_id');

        $query = Pendaftaran::with('penugasanJuri', 'mahasiswa.user')
            ->where('status_seleksi', 'Lolos Tahap 1');

        if ($request->filled('jenjang_id')) {
            $query->whereHas('mahasiswa', fn($q) => $q->where('jenjang_id', $request->jenjang_id));
        }

        $pesertaLolos = $query->get();

        if ($allKriterias->isEmpty() || $pesertaLolos->isEmpty()) {
            return back()->with('error', 'Tidak ada data kriteria atau peserta lolos.');
        }

        // Pre-load all related data in bulk to eliminate N+1
        $pendaftaranIds = $pesertaLolos->pluck('id');
        $allPortofolios = PortofolioCu::whereIn('pendaftaran_id', $pendaftaranIds)
            ->where('status_validasi', 'Valid')->get()->groupBy('pendaftaran_id');
        $allPenugasans = PenugasanJuri::whereIn('pendaftaran_id', $pendaftaranIds)->get()->groupBy('pendaftaran_id');
        $allPenilaians = Penilaian::whereIn('pendaftaran_id', $pendaftaranIds)
            ->with('kriteria')->get()->groupBy('pendaftaran_id');

        // Helper to compute total rekomendasi from portofolios
        $hitungRekomendasi = function ($portofolios) {
            $total = 0;
            foreach ($portofolios as $porto) {
                $skor = $porto->skor_rekomendasi;
                if ($skor) {
                    preg_match_all('/\d+(?:\.\d+)?/', $skor, $matches);
                    if (!empty($matches[0])) {
                        $angka = array_map('floatval', $matches[0]);
                        $total += array_sum($angka) / count($angka);
                    }
                }
            }
            return min($total, 100);
        };

        // --- 1. OTOMATISASI DAN VERIFIKASI NILAI KRITERIA A01 ---
        foreach ($pesertaLolos as $pendaftaran) {
            $pendaftaran->load('mahasiswa');
            $jenjangId = $pendaftaran->mahasiswa->jenjang_id ?? 1;
            $kriteriasMap = ($kriteriasByJenjang->get($jenjangId, collect()) ?: $kriteriasByJenjang->get(1, collect()))->keyBy('kode_kriteria');
            if (!isset($kriteriasMap['A01'])) continue;
            $a01KriteriaId = $kriteriasMap['A01']->id;
            $portofolios = $allPortofolios->get($pendaftaran->id, collect());
            $total_rekomendasi = $hitungRekomendasi($portofolios);
            $penugasans = $allPenugasans->get($pendaftaran->id, collect());
            foreach ($penugasans as $penugasan) {
                Penilaian::firstOrCreate(
                    ['juri_id' => $penugasan->juri_id, 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $a01KriteriaId],
                    ['nilai_input' => $total_rekomendasi]
                );
            }
        }

        // Otomatisasi A03 (BI Video) disamakan dengan F03 jika kosong
        foreach ($pesertaLolos as $pendaftaran) {
            $pendaftaran->load('mahasiswa');
            $jenjangId = $pendaftaran->mahasiswa->jenjang_id ?? 1;
            $kriteriasMap = ($kriteriasByJenjang->get($jenjangId, collect()) ?: $kriteriasByJenjang->get(1, collect()))->keyBy('kode_kriteria');
            if (!isset($kriteriasMap['A03']) || !isset($kriteriasMap['F03'])) continue;
            $a03Id = $kriteriasMap['A03']->id;
            $f03Id = $kriteriasMap['F03']->id;
            $penugasans = $allPenugasans->get($pendaftaran->id, collect());
            foreach ($penugasans as $penugasan) {
                    $existingF03Val = Penilaian::where('juri_id', $penugasan->juri_id)
                        ->where('pendaftaran_id', $pendaftaran->id)
                        ->where('kriteria_id', $f03Id)
                        ->value('nilai_input');
                    if ($existingF03Val !== null) {
                        Penilaian::updateOrCreate(
                            ['juri_id' => $penugasan->juri_id, 'pendaftaran_id' => $pendaftaran->id, 'kriteria_id' => $a03Id],
                            ['nilai_input' => $existingF03Val]
                        );
                    }
                }
            }

        // Cek apakah semua juri sudah memberi nilai
        foreach ($pesertaLolos as $pendaftaran) {
            $jumlahJuriDitugaskan = $pendaftaran->penugasanJuri->count();
            $penilaiansPeserta = $allPenilaians->get($pendaftaran->id, collect());
            $jumlahJuriMemberiNilai = $penilaiansPeserta->pluck('juri_id')->unique()->count();

            if ($jumlahJuriMemberiNilai < $jumlahJuriDitugaskan && $jumlahJuriDitugaskan > 0) {
                return back()->with('error', 'Proses gagal. Masih ada juri yang belum memberikan penilaian lengkap untuk peserta: ' . $pendaftaran->mahasiswa->user->nama_lengkap);
            }
        }

        foreach ($pesertaLolos as $pendaftaran) {
            $penilaianList = $allPenilaians->get($pendaftaran->id, collect());
            if ($penilaianList->isEmpty()) continue;

            $nilaiPerKriteriaRaw = [];
            foreach ($penilaianList as $p) {
                if ($p->kriteria) {
                    $nilaiPerKriteriaRaw[$p->kriteria->kode_kriteria][] = $p->nilai_input;
                }
            }

            $nilaiPerKriteria = [];
            foreach ($nilaiPerKriteriaRaw as $kode => $nilaiArr) {
                $nilaiPerKriteria[$kode] = array_sum($nilaiArr) / count($nilaiArr);
            }

            $weights = [];
            $jenjangId = $pendaftaran->mahasiswa->jenjang_id ?? 1;
            $kriteriasJenjang = $kriteriasByJenjang->get($jenjangId, collect());
            if ($kriteriasJenjang->isEmpty()) {
                $kriteriasJenjang = $kriteriasByJenjang->get(1, collect());
            }
            $bobotMap = $kriteriasJenjang->pluck('bobot', 'kode_kriteria');

            foreach ($kriteriasJenjang as $k) {
                $avgScore = $nilaiPerKriteria[$k->kode_kriteria] ?? 0;
                $weightedScore = $avgScore * ($k->bobot / 100.0);
                $actual = $this->convertToScale10($weightedScore);
                $target = $k->nilai_target;
                $gap = $actual - $target;
                $weights[$k->kode_kriteria] = $this->getGapWeight($gap);
            }

            $a01 = $nilaiPerKriteria['A01'] ?? 0;
            $a02 = $nilaiPerKriteria['A02'] ?? 0;
            $a03 = $nilaiPerKriteria['A03'] ?? 0;
            $awalSementara = ($a01 * ($bobotMap['A01'] ?? 35) / 100)
                           + ($a02 * ($bobotMap['A02'] ?? 35) / 100)
                           + ($a03 * ($bobotMap['A03'] ?? 30) / 100);

            $f01 = $nilaiPerKriteria['F01'] ?? 0;
            $f02 = $nilaiPerKriteria['F02'] ?? 0;
            $f03 = $nilaiPerKriteria['F03'] ?? 0;
            $finalSementara = ($f01 * ($bobotMap['F01'] ?? 35) / 100)
                            + ($f02 * ($bobotMap['F02'] ?? 35) / 100)
                            + ($f03 * ($bobotMap['F03'] ?? 30) / 100);

            $nilaiSementara = (0.3 * $awalSementara) + (0.7 * $finalSementara);

            $ncf = ($weights['F01'] + $weights['F02'] + $weights['F03']) / 3.0;
            $nsf = ($weights['A01'] + $weights['A02'] + $weights['A03']) / 3.0;
            $nilaiTotal = (0.7 * $ncf) + (0.3 * $nsf);

            HasilPenilaian::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'skor_awal' => $nsf,
                    'skor_final' => $ncf,
                    'nilai_total' => $nilaiTotal,
                    'nilai_sementara' => $nilaiSementara
                ]
            );
        }

        // Perangkingan per jenjang — setiap jenjang punya Juara 1, 2, 3 sendiri
        $hasilByJenjang = HasilPenilaian::with('pendaftaran.mahasiswa')
            ->orderByDesc('nilai_total')
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy(fn($h) => $h->pendaftaran->mahasiswa->jenjang_id ?? 1);

        foreach ($hasilByJenjang as $jenjangId => $hasilPerJenjang) {
            $rank = 1;
            foreach ($hasilPerJenjang as $hasil) {
                $statusJuara = match ($rank) {
                    1 => 'Juara 1',
                    2 => 'Juara 2',
                    3 => 'Juara 3',
                    default => 'Tidak Juara',
                };
                $hasil->update(['ranking' => $rank++, 'status_juara' => $statusJuara]);
            }
        }

        $this->notifyAllRole('wr3', 'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.', 'info');
        $this->notifyAllRole('mahasiswa', 'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.', 'info');

        return redirect()->route('admin.perhitungan.index', $request->filled('jenjang_id') ? ['jenjang_id' => $request->jenjang_id] : [])
            ->with('success', 'Perhitungan GAP skala 1-10 selesai. Hasil perangkingan telah diperbarui.');
    }

    public function resetPerhitungan()
    {
        HasilPenilaian::truncate();

        return redirect()->route('admin.perhitungan.index')
            ->with('success', 'Riwayat perhitungan GAP berhasil dikosongkan.');
    }

    public function ranking(Request $request)
    {
        $query = HasilPenilaian::with(
            'pendaftaran.mahasiswa.user',
            'pendaftaran.mahasiswa.jenjang',
            'pendaftaran.penilaian.kriteria',
            'pendaftaran.penilaian'
        );

        if ($request->filled('jenjang_id')) {
            $query->whereHas('pendaftaran.mahasiswa', fn($q) =>
                $q->where('jenjang_id', $request->jenjang_id)
            );
        }

        $hasilList = $query->orderBy('ranking')->get();
        $jenjangList = \App\Models\Jenjang::orderBy('id')->get();

        $kriterias = KriteriaPenilaian::with('jenjang')->get();
        $juries = \App\Models\User::where('role', 'juri')->orderBy('id')->get(['id', 'nama_lengkap']);

        $bobotPerJenjang = [];
        foreach ($kriterias as $k) {
            $jid = $k->jenjang_id ?? 1;
            if (!isset($bobotPerJenjang[$jid])) {
                $bobotPerJenjang[$jid] = [];
            }
            $bobotPerJenjang[$jid][$k->kode_kriteria] = $k->bobot;
        }

        $selectedJenjang = $request->jenjang_id;

        return view('admin.perhitungan.ranking', compact('hasilList', 'kriterias', 'jenjangList', 'bobotPerJenjang', 'juries', 'selectedJenjang'));
    }

    public function hasil(Request $request)
    {
        $query = HasilPenilaian::with('pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang', 'pendaftaran.penilaian.kriteria', 'pendaftaran.penilaian');

        if ($request->filled('jenjang_id')) {
            $query->whereHas('pendaftaran.mahasiswa', fn($q) =>
                $q->where('jenjang_id', $request->jenjang_id)
            );
        }

        $hasilList = $query->orderBy('ranking')->get();

        $kriteriasQuery = KriteriaPenilaian::with('jenjang');
        if ($request->filled('jenjang_id')) {
            $kriteriasQuery->where('jenjang_id', $request->jenjang_id);
        }
        $kriterias = $kriteriasQuery->get();

        $jenjangList = \App\Models\Jenjang::orderBy('id')->get();
        $juries = \App\Models\User::where('role', 'juri')->orderBy('id')->get(['id', 'nama_lengkap']);

        // Compute bobot map per jenjang: [jenjang_id => [kode_kriteria => bobot]]
        $bobotPerJenjang = [];
        foreach ($kriterias as $k) {
            $jid = $k->jenjang_id ?? 1;
            if (!isset($bobotPerJenjang[$jid])) {
                $bobotPerJenjang[$jid] = [];
            }
            $bobotPerJenjang[$jid][$k->kode_kriteria] = $k->bobot;
        }

        $selectedJenjang = $request->jenjang_id;
        return view('admin.perhitungan.hasil', compact('hasilList', 'kriterias', 'jenjangList', 'bobotPerJenjang', 'juries', 'selectedJenjang'));
    }

    public function export(Request $request)
    {
        $query = HasilPenilaian::with('pendaftaran.mahasiswa.user', 'pendaftaran.penilaian.kriteria');

        if ($request->filled('jenjang_id')) {
            $query->whereHas('pendaftaran.mahasiswa', fn($q) =>
                $q->where('jenjang_id', $request->jenjang_id)
            );
        }

        $hasilList = $query->orderBy('ranking')->get();

        $kriteriasQuery = KriteriaPenilaian::with('jenjang');
        if ($request->filled('jenjang_id')) {
            $kriteriasQuery->where('jenjang_id', $request->jenjang_id);
        }
        $kriterias = $kriteriasQuery->get();

        $kriteriasMap = $kriterias->pluck('id', 'kode_kriteria');
        // Peta bobot kriteria dari database (kode => bobot persen).
        // Dipakai agar perhitungan di export SELALU sinkron dengan proses() yang
        // memakai $k->bobot, sehingga tidak melenceng bila bobot diubah dari DB.
        $bobotMap = $kriterias->pluck('bobot', 'kode_kriteria');
        $juries = \App\Models\User::where('role', 'juri')->get();

        if ($hasilList->isEmpty()) {
            return back()->with('error', 'Belum ada hasil perhitungan untuk diekspor.');
        }

        // Helper: nilai rata-rata kriteria dikali bobot kriteria dari DB (skala persen).
        // Mengganti hardcode 0.35 / 0.30 agar konsisten dengan proses().
        $weighted = function ($kode, $avg) use ($bobotMap) {
            return $avg * ($bobotMap->get($kode, 0) / 100.0);
        };

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Remove the default sheet
        $spreadsheet->removeSheetByIndex(0);

        // Helper function to style headers
        $styleHeader = function($sheet, $range, $color = '198754') {
            $sheet->getStyle($range)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
        };

        // Helper function for cell borders & alignment
        $styleData = function($sheet, $range, $align = 'center') {
            $hAlign = match($align) {
                'left' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'right' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                default => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            };
            $sheet->getStyle($range)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'D3D3D3'],
                    ],
                ],
                'alignment' => [
                    'horizontal' => $hAlign,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ]);
        };

        // ----------------------------------------------------
        // SHEET 1: Rubrik Penilaian
        // ----------------------------------------------------
        $sheet1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Rubrik Penilaian');
        $spreadsheet->addSheet($sheet1);
        $sheet1->setCellValue('A1', 'KODE');
        $sheet1->setCellValue('B1', 'NAMA KRITERIA');
        $sheet1->setCellValue('C1', 'TAHAP');
        $sheet1->setCellValue('D1', 'TIPE FAKTOR');
        $sheet1->setCellValue('E1', 'TARGET');
        $sheet1->setCellValue('F1', 'BOBOT');

        $row = 2;
        foreach ($kriterias as $k) {
            $sheet1->setCellValue('A' . $row, $k->kode_kriteria);
            $sheet1->setCellValue('B' . $row, $k->nama_kriteria);
            $sheet1->setCellValue('C' . $row, $k->jenis_faktor);
            $sheet1->setCellValue('D' . $row, $k->jenis_faktor === 'Tahap Final' ? 'Core Factor (CF)' : 'Secondary Factor (SF)');
            $sheet1->setCellValue('E' . $row, $k->nilai_target);
            $sheet1->setCellValue('F' . $row, $k->bobot . '%');
            $styleData($sheet1, "A$row:F$row");
            $sheet1->getStyle("B$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet1, 'A1:F1', '198754');
        foreach (range('A', 'F') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 2: Data Mahasiswa
        // ----------------------------------------------------
        $sheet2 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Data Mahasiswa');
        $spreadsheet->addSheet($sheet2);
        $sheet2->setCellValue('A1', 'NO');
        $sheet2->setCellValue('B1', 'NPM');
        $sheet2->setCellValue('C1', 'NAMA MAHASISWA');
        $sheet2->setCellValue('D1', 'PROGRAM STUDI');
        $sheet2->setCellValue('E1', 'IPK');
        $sheet2->setCellValue('F1', 'RIWAYAT PILMAPRES');

        $row = 2;
        foreach ($hasilList as $i => $h) {
            $m = $h->pendaftaran->mahasiswa;
            $sheet2->setCellValue('A' . $row, $i + 1);
            $sheet2->setCellValue('B' . $row, $m->nim);
            $sheet2->setCellValue('C' . $row, $m->user->nama_lengkap);
            $sheet2->setCellValue('D' . $row, $m->program_studi);
            $sheet2->setCellValue('E' . $row, number_format($m->ipk ?? 4.0, 2));
            $sheet2->setCellValue('F' . $row, $m->pernah_pilmapres);
            $styleData($sheet2, "A$row:F$row");
            $sheet2->getStyle("C$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet2, 'A1:F1', '0d6efd');
        foreach (range('A', 'F') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 3: Input Nilai Juri
        // ----------------------------------------------------
        $sheet3 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Input Nilai Juri');
        $spreadsheet->addSheet($sheet3);
        $sheet3->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet3->setCellValue('B1', 'NPM');
        $sheet3->setCellValue('C1', 'JURI PENILAI');
        $sheet3->setCellValue('D1', 'A01 (CU Berkas)');
        $sheet3->setCellValue('E1', 'A02 (GK Naskah)');
        $sheet3->setCellValue('F1', 'A03 (BI Video)');
        $sheet3->setCellValue('G1', 'F01 (CU Wawancara)');
        $sheet3->setCellValue('H1', 'F02 (GK Presentasi)');
        $sheet3->setCellValue('I1', 'F03 (BI Lisan)');

        $row = 2;
        foreach ($hasilList as $h) {
            $pendaftaran = $h->pendaftaran;
            $penilaians = $pendaftaran->penilaian;

            foreach ($juries as $jIndex => $juri) {
                $getScore = function($kode) use ($penilaians, $juri, $kriteriasMap) {
                    $kId = $kriteriasMap[$kode] ?? 0;
                    return $penilaians->where('juri_id', $juri->id)->where('kriteria_id', $kId)->first()->nilai_input ?? 60;
                };

                $sheet3->setCellValue('A' . $row, $pendaftaran->mahasiswa->user->nama_lengkap);
                $sheet3->setCellValue('B' . $row, $pendaftaran->mahasiswa->nim);
                $sheet3->setCellValue('C' . $row, 'Juri #' . ($jIndex + 1) . ' - ' . $juri->nama_lengkap);
                $sheet3->setCellValue('D' . $row, number_format($getScore('A01'), 2));
                $sheet3->setCellValue('E' . $row, number_format($getScore('A02'), 2));
                $sheet3->setCellValue('F' . $row, number_format($getScore('A03'), 2));
                $sheet3->setCellValue('G' . $row, number_format($getScore('F01'), 2));
                $sheet3->setCellValue('H' . $row, number_format($getScore('F02'), 2));
                $sheet3->setCellValue('I' . $row, number_format($getScore('F03'), 2));

                $styleData($sheet3, "A$row:I$row");
                $sheet3->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet3->getStyle("C$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $row++;
            }
        }
        $styleHeader($sheet3, 'A1:I1', 'ffc107');
        foreach (range('A', 'I') as $col) {
            $sheet3->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 4: Perhitungan Tahap Awal
        // ----------------------------------------------------
        $sheet4 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Perhitungan Tahap Awal');
        $spreadsheet->addSheet($sheet4);
        $sheet4->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet4->setCellValue('B1', 'AVG A01');
        $sheet4->setCellValue('C1', 'WEIGHTED A01 (AVG*35%)');
        $sheet4->setCellValue('D1', 'AVG A02');
        $sheet4->setCellValue('E1', 'WEIGHTED A02 (AVG*35%)');
        $sheet4->setCellValue('F1', 'AVG A03');
        $sheet4->setCellValue('G1', 'WEIGHTED A03 (AVG*30%)');

        $row = 2;
        foreach ($hasilList as $h) {
            $penilaians = $h->pendaftaran->penilaian;
            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                $kId = $kriteriasMap[$kode] ?? 0;
                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                return $scores->count() > 0 ? $scores->avg() : 60;
            };
            $avgA01 = $getAvg('A01');
            $avgA02 = $getAvg('A02');
            $avgA03 = $getAvg('A03');

            $sheet4->setCellValue('A' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet4->setCellValue('B' . $row, number_format($avgA01, 4));
            $sheet4->setCellValue('C' . $row, number_format($weighted('A01', $avgA01), 4));
            $sheet4->setCellValue('D' . $row, number_format($avgA02, 4));
            $sheet4->setCellValue('E' . $row, number_format($weighted('A02', $avgA02), 4));
            $sheet4->setCellValue('F' . $row, number_format($avgA03, 4));
            $sheet4->setCellValue('G' . $row, number_format($weighted('A03', $avgA03), 4));
            $styleData($sheet4, "A$row:G$row");
            $sheet4->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet4, 'A1:G1', '0dcaf0');
        foreach (range('A', 'G') as $col) {
            $sheet4->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 5: Perhitungan Tahap Akhir
        // ----------------------------------------------------
        $sheet5 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Perhitungan Tahap Akhir');
        $spreadsheet->addSheet($sheet5);
        $sheet5->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet5->setCellValue('B1', 'AVG F01');
        $sheet5->setCellValue('C1', 'WEIGHTED F01 (AVG*35%)');
        $sheet5->setCellValue('D1', 'AVG F02');
        $sheet5->setCellValue('E1', 'WEIGHTED F02 (AVG*35%)');
        $sheet5->setCellValue('F1', 'AVG F03');
        $sheet5->setCellValue('G1', 'WEIGHTED F03 (AVG*30%)');

        $row = 2;
        foreach ($hasilList as $h) {
            $penilaians = $h->pendaftaran->penilaian;
            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                $kId = $kriteriasMap[$kode] ?? 0;
                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                return $scores->count() > 0 ? $scores->avg() : 60;
            };
            $avgF01 = $getAvg('F01');
            $avgF02 = $getAvg('F02');
            $avgF03 = $getAvg('F03');

            $sheet5->setCellValue('A' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet5->setCellValue('B' . $row, number_format($avgF01, 4));
            $sheet5->setCellValue('C' . $row, number_format($weighted('F01', $avgF01), 4));
            $sheet5->setCellValue('D' . $row, number_format($avgF02, 4));
            $sheet5->setCellValue('E' . $row, number_format($weighted('F02', $avgF02), 4));
            $sheet5->setCellValue('F' . $row, number_format($avgF03, 4));
            $sheet5->setCellValue('G' . $row, number_format($weighted('F03', $avgF03), 4));
            $styleData($sheet5, "A$row:G$row");
            $sheet5->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet5, 'A1:G1', 'dc3545');
        foreach (range('A', 'G') as $col) {
            $sheet5->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 6: Konversi 1-10
        // ----------------------------------------------------
        $sheet6 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Konversi 1-10');
        $spreadsheet->addSheet($sheet6);
        $sheet6->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet6->setCellValue('B1', 'A01');
        $sheet6->setCellValue('C1', 'A02');
        $sheet6->setCellValue('D1', 'A03');
        $sheet6->setCellValue('E1', 'F01');
        $sheet6->setCellValue('F1', 'F02');
        $sheet6->setCellValue('G1', 'F03');

        $row = 2;
        foreach ($hasilList as $h) {
            $penilaians = $h->pendaftaran->penilaian;
            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                $kId = $kriteriasMap[$kode] ?? 0;
                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                return $scores->count() > 0 ? $scores->avg() : 60;
            };

            $sheet6->setCellValue('A' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet6->setCellValue('B' . $row, $this->convertToScale10($weighted('A01', $getAvg('A01'))));
            $sheet6->setCellValue('C' . $row, $this->convertToScale10($weighted('A02', $getAvg('A02'))));
            $sheet6->setCellValue('D' . $row, $this->convertToScale10($weighted('A03', $getAvg('A03'))));
            $sheet6->setCellValue('E' . $row, $this->convertToScale10($weighted('F01', $getAvg('F01'))));
            $sheet6->setCellValue('F' . $row, $this->convertToScale10($weighted('F02', $getAvg('F02'))));
            $sheet6->setCellValue('G' . $row, $this->convertToScale10($weighted('F03', $getAvg('F03'))));
            $styleData($sheet6, "A$row:G$row");
            $sheet6->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet6, 'A1:G1', '6c757d');
        foreach (range('A', 'G') as $col) {
            $sheet6->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 7: Perhitungan GAP
        // ----------------------------------------------------
        $sheet7 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Perhitungan GAP');
        $spreadsheet->addSheet($sheet7);
        $sheet7->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet7->setCellValue('B1', 'GAP A01');
        $sheet7->setCellValue('C1', 'GAP A02');
        $sheet7->setCellValue('D1', 'GAP A03');
        $sheet7->setCellValue('E1', 'GAP F01');
        $sheet7->setCellValue('F1', 'GAP F02');
        $sheet7->setCellValue('G1', 'GAP F03');

        $row = 2;
        foreach ($hasilList as $h) {
            $penilaians = $h->pendaftaran->penilaian;
            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                $kId = $kriteriasMap[$kode] ?? 0;
                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                return $scores->count() > 0 ? $scores->avg() : 60;
            };

            $sheet7->setCellValue('A' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet7->setCellValue('B' . $row, $this->convertToScale10($weighted('A01', $getAvg('A01'))) - 10);
            $sheet7->setCellValue('C' . $row, $this->convertToScale10($weighted('A02', $getAvg('A02'))) - 10);
            $sheet7->setCellValue('D' . $row, $this->convertToScale10($weighted('A03', $getAvg('A03'))) - 10);
            $sheet7->setCellValue('E' . $row, $this->convertToScale10($weighted('F01', $getAvg('F01'))) - 10);
            $sheet7->setCellValue('F' . $row, $this->convertToScale10($weighted('F02', $getAvg('F02'))) - 10);
            $sheet7->setCellValue('G' . $row, $this->convertToScale10($weighted('F03', $getAvg('F03'))) - 10);
            $styleData($sheet7, "A$row:G$row");
            $sheet7->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet7, 'A1:G1', 'b02a37');
        foreach (range('A', 'G') as $col) {
            $sheet7->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 8: Core & Secondary
        // ----------------------------------------------------
        $sheet8 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Core & Secondary');
        $spreadsheet->addSheet($sheet8);
        $sheet8->setCellValue('A1', 'NAMA MAHASISWA');
        $sheet8->setCellValue('B1', 'BOBOT GAP A01');
        $sheet8->setCellValue('C1', 'BOBOT GAP A02');
        $sheet8->setCellValue('D1', 'BOBOT GAP A03');
        $sheet8->setCellValue('E1', 'BOBOT GAP F01');
        $sheet8->setCellValue('F1', 'BOBOT GAP F02');
        $sheet8->setCellValue('G1', 'BOBOT GAP F03');
        $sheet8->setCellValue('H1', 'NSF (SECONDARY AVG)');
        $sheet8->setCellValue('I1', 'NCF (CORE AVG)');
        $sheet8->setCellValue('J1', 'NILAI AKHIR (PROFILE MATCHING)');

        $row = 2;
        foreach ($hasilList as $h) {
            $penilaians = $h->pendaftaran->penilaian;
            $getAvg = function($kode) use ($penilaians, $kriteriasMap) {
                $kId = $kriteriasMap[$kode] ?? 0;
                $scores = $penilaians->where('kriteria_id', $kId)->pluck('nilai_input');
                return $scores->count() > 0 ? $scores->avg() : 60;
            };

            $a01 = $this->convertToScale10($weighted('A01', $getAvg('A01')));
            $a02 = $this->convertToScale10($weighted('A02', $getAvg('A02')));
            $a03 = $this->convertToScale10($weighted('A03', $getAvg('A03')));
            $f01 = $this->convertToScale10($weighted('F01', $getAvg('F01')));
            $f02 = $this->convertToScale10($weighted('F02', $getAvg('F02')));
            $f03 = $this->convertToScale10($weighted('F03', $getAvg('F03')));

            $wA01 = $this->getGapWeight($a01 - 10);
            $wA02 = $this->getGapWeight($a02 - 10);
            $wA03 = $this->getGapWeight($a03 - 10);
            $wF01 = $this->getGapWeight($f01 - 10);
            $wF02 = $this->getGapWeight($f02 - 10);
            $wF03 = $this->getGapWeight($f03 - 10);

            $nsf = ($wA01 + $wA02 + $wA03) / 3.0;
            $ncf = ($wF01 + $wF02 + $wF03) / 3.0;

            $sheet8->setCellValue('A' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet8->setCellValue('B' . $row, number_format($wA01, 1));
            $sheet8->setCellValue('C' . $row, number_format($wA02, 1));
            $sheet8->setCellValue('D' . $row, number_format($wA03, 1));
            $sheet8->setCellValue('E' . $row, number_format($wF01, 1));
            $sheet8->setCellValue('F' . $row, number_format($wF02, 1));
            $sheet8->setCellValue('G' . $row, number_format($wF03, 1));
            $sheet8->setCellValue('H' . $row, number_format($nsf, 4));
            $sheet8->setCellValue('I' . $row, number_format($ncf, 4));
            $sheet8->setCellValue('J' . $row, number_format($h->nilai_total, 4));
            $styleData($sheet8, "A$row:J$row");
            $sheet8->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet8, 'A1:J1', '198754');
        foreach (range('A', 'J') as $col) {
            $sheet8->getColumnDimension($col)->setAutoSize(true);
        }

        // ----------------------------------------------------
        // SHEET 9: Ranking
        // ----------------------------------------------------
        $sheet9 = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Ranking');
        $spreadsheet->addSheet($sheet9);
        $sheet9->setCellValue('A1', 'RANKING');
        $sheet9->setCellValue('B1', 'NPM');
        $sheet9->setCellValue('C1', 'NAMA MAHASISWA');
        $sheet9->setCellValue('D1', 'PROGRAM STUDI');
        $sheet9->setCellValue('E1', 'NILAI SEMENTARA (RAW AVG)');
        $sheet9->setCellValue('F1', 'SKOR NSF (SECONDARY)');
        $sheet9->setCellValue('G1', 'SKOR NCF (CORE)');
        $sheet9->setCellValue('H1', 'NILAI AKHIR (SPK)');
        $sheet9->setCellValue('I1', 'STATUS JUARA');

        $row = 2;
        foreach ($hasilList as $h) {
            $sheet9->setCellValue('A' . $row, $h->ranking);
            $sheet9->setCellValue('B' . $row, $h->pendaftaran->mahasiswa->nim);
            $sheet9->setCellValue('C' . $row, $h->pendaftaran->mahasiswa->user->nama_lengkap);
            $sheet9->setCellValue('D' . $row, $h->pendaftaran->mahasiswa->program_studi);
            $sheet9->setCellValue('E' . $row, number_format($h->nilai_sementara ?? 0, 4));
            $sheet9->setCellValue('F' . $row, number_format($h->skor_awal, 4));
            $sheet9->setCellValue('G' . $row, number_format($h->skor_final, 4));
            $sheet9->setCellValue('H' . $row, number_format($h->nilai_total, 4));
            $sheet9->setCellValue('I' . $row, $h->status_juara);
            $styleData($sheet9, "A$row:I$row");
            $sheet9->getStyle("C$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }
        $styleHeader($sheet9, 'A1:I1', 'ffc107');
        foreach (range('A', 'I') as $col) {
            $sheet9->getColumnDimension($col)->setAutoSize(true);
        }

        // Set active sheet index to the first sheet (Rubrik Penilaian)
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PERHITUNGAN_SPK_PILMAPRES_' . date('Ymd_His') . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
