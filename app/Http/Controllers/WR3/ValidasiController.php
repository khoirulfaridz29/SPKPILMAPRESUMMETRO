<?php

namespace App\Http\Controllers\WR3;

use App\Http\Controllers\Controller;
use App\Models\RekapTahap1;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    public function index()
    {
        $rekaps = RekapTahap1::with('pendaftaran.mahasiswa.user', 'pendaftaran.berkas')
            ->latest()->get();
        return view('wr3.validasi.index', compact('rekaps'));
    }

    public function approve(RekapTahap1 $rekap)
    {
        $rekap->update([
            'status_laporan'   => 'Divalidasi',
            'divalidasi_oleh'  => Auth::id(),
            'tanggal_validasi' => now(),
        ]);
        return back()->with('success', 'Laporan berhasil divalidasi.');
    }
}
