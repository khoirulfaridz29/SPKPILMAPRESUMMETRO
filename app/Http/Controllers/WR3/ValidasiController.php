<?php

namespace App\Http\Controllers\WR3;

use App\Http\Controllers\Controller;
use App\Models\RekapTahap1;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    use \App\Traits\Notifiable;

    public function index()
    {
        $jenjangList = \App\Models\Jenjang::orderBy('id')->get();
        $rekaps = RekapTahap1::with('pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang', 'pendaftaran.berkas')
            ->latest()->get();
        $grouped = $rekaps->groupBy(fn($r) => $r->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? '-');
        return view('wr3.validasi.index', compact('grouped', 'jenjangList'));
    }

    public function approve(RekapTahap1 $rekap)
    {
        $rekap->update([
            'status_laporan'   => 'Divalidasi',
            'divalidasi_oleh'  => Auth::id(),
            'tanggal_validasi' => now(),
        ]);

        $pendaftaran = $rekap->pendaftaran;
        $pendaftaran->update([
            'status_seleksi' => 'Lolos Tahap 1',
            'status_berkas'  => 'Lengkap',
        ]);

        // Notify mahasiswa
        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Selamat! Berkas Anda telah divalidasi WR3 dan dinyatakan LOLOS seleksi Tahap I.', 'success');

        // Notify all admins
        $this->notifyAllAdmins('Peserta ' . $pendaftaran->mahasiswa->user->nama_lengkap . ' (' . $pendaftaran->mahasiswa->nim . ') telah divalidasi WR3 dan LOLOS Tahap I.', 'success');

        return back()->with('success', 'Rekap berhasil divalidasi. Admin dapat mengatur penugasan juri di menu Rekap.');
    }
}
