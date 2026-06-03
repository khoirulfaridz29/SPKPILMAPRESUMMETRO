<?php

namespace App\Http\Controllers\WR3;

use App\Http\Controllers\Controller;
use App\Models\HasilPenilaian;

class RekomendaciController extends Controller
{
    public function index()
    {
        $hasilList = HasilPenilaian::with('pendaftaran.mahasiswa.user')
            ->orderBy('ranking')->get();
        return view('wr3.rekomendasi.index', compact('hasilList'));
    }

    public function validasi()
    {
        HasilPenilaian::where('validasi_wr3', 'Pending')
            ->update(['validasi_wr3' => 'Divalidasi']);

        // Update status_seleksi peserta menjadi Selesai
        HasilPenilaian::with('pendaftaran')->get()->each(function ($hasil) {
            $hasil->pendaftaran->update(['status_seleksi' => 'Selesai']);
        });

        return back()->with('success', 'Semua hasil rekomendasi telah divalidasi oleh Wakil Rektor III.');
    }
}
