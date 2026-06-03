<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\BerkasPendaftaran;
use App\Models\RekapTahap1;
use Illuminate\Http\Request;

class PendaftaranAdminController extends Controller
{
    use \App\Traits\Notifiable;

    public function index()
    {
        $pendaftarans = Pendaftaran::with('mahasiswa.user')->latest()->get();
        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load('mahasiswa.user', 'berkas', 'portofolios.rubrikCu');
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function verifikasi(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status_berkas' => 'Lengkap']);
        
        // Buat rekap tahap 1 jika belum ada
        if (!$pendaftaran->rekap) {
            RekapTahap1::create([
                'pendaftaran_id' => $pendaftaran->id,
                'status_laporan' => 'Pending',
            ]);
        }

        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Berkas pendaftaran Anda telah dinyatakan LENGKAP.', 'success');

        return back()->with('success', 'Berkas dinyatakan Lengkap. Peserta masuk rekap Tahap I.');
    }

    public function tolak(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update([
            'status_berkas'  => 'Belum Lengkap',
            'status_seleksi' => 'Tidak Lolos',
        ]);

        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Berkas pendaftaran Anda dinyatakan TIDAK LENGKAP / TIDAK LOLOS.', 'danger');

        return back()->with('success', 'Berkas peserta dinyatakan Tidak Lengkap.');
    }

    public function validasiBerkas(BerkasPendaftaran $berkas, Request $request)
    {
        $request->validate(['status' => 'required|in:Valid,Tidak Valid']);
        $berkas->update(['status_validasi' => $request->status]);

        $this->sendNotification($berkas->pendaftaran->mahasiswa->user_id, 'Dokumen "' . $berkas->nama_berkas . '" Anda dinyatakan ' . strtoupper($request->status) . '.', $request->status === 'Valid' ? 'success' : 'danger');

        return back()->with('success', 'Validasi berkas berhasil diperbarui.');
    }

    public function validasiPortofolio(\App\Models\PortofolioCu $portofolio, Request $request)
    {
        $request->validate(['status' => 'required|in:Valid,Tidak Valid']);
        $portofolio->update(['status_validasi' => $request->status]);

        $this->sendNotification($portofolio->pendaftaran->mahasiswa->user_id, 'Portofolio CU "' . $portofolio->nama_prestasi . '" Anda dinyatakan ' . strtoupper($request->status) . '.', $request->status === 'Valid' ? 'success' : 'danger');

        return back()->with('success', 'Validasi portofolio berhasil diperbarui.');
    }
}
