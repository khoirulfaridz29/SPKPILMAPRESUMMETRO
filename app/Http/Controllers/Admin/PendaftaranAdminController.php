<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\BerkasPendaftaran;
use App\Models\RekapTahap1;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranAdminController extends Controller
{
    use \App\Traits\Notifiable;

    public function index(Request $request)
    {
        $query = Pendaftaran::with('mahasiswa.user', 'mahasiswa.jenjang');

        // Filter by year (tahun akademik)
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_daftar', $request->tahun);
        }

        // Filter by date range
        if ($request->filled('dari')) {
            $query->where('tanggal_daftar', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tanggal_daftar', '<=', $request->sampai);
        }

        // Filter by status_seleksi
        if ($request->filled('status')) {
            $query->where('status_seleksi', $request->status);
        }

        $pendaftarans = $query->latest()->get();
        $jenjangList = Jenjang::orderBy('id')->get();
        $grouped = $pendaftarans->groupBy(fn($p) => $p->mahasiswa->jenjang?->nama_jenjang ?? 'Sarjana');

        // Available years for filter
        $years = Pendaftaran::selectRaw('YEAR(tanggal_daftar) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.pendaftaran.index', compact('grouped', 'jenjangList', 'years'));
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load('mahasiswa.user', 'berkas', 'portofolios.rubrikCu');
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function verifikasi(Pendaftaran $pendaftaran)
    {
        $oldStatus = $pendaftaran->status_seleksi;
        $pendaftaran->update([
            'status_berkas' => 'Lengkap',
            'status_seleksi' => 'Lolos Tahap 1',
        ]);
        
        $rekapCreated = false;
        if (!$pendaftaran->rekap) {
            RekapTahap1::create([
                'pendaftaran_id' => $pendaftaran->id,
                'status_laporan' => 'Pending',
            ]);
            $rekapCreated = true;
        }

        activity()->causedBy(Auth::user())
            ->performedOn($pendaftaran)
            ->withProperties([
                'mahasiswa_nim' => $pendaftaran->mahasiswa->nim,
                'old_status' => $oldStatus,
                'new_status' => 'Lolos Tahap 1',
                'rekap_created' => $rekapCreated,
            ])
            ->event('updated')
            ->log('Verifikasi pendaftaran: ' . $pendaftaran->mahasiswa->nim . ' -> Lolos Tahap 1');

        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Berkas pendaftaran Anda telah dinyatakan LENGKAP dan Anda lolos ke Tahap I.', 'success');

        return back()->with('success', 'Berkas dinyatakan Lengkap. Status seleksi: Lolos Tahap I.');
    }

    public function tolak(Pendaftaran $pendaftaran)
    {
        $oldStatus = $pendaftaran->status_seleksi;
        $pendaftaran->update([
            'status_berkas'  => 'Belum Lengkap',
            'status_seleksi' => 'Tidak Lolos',
        ]);

        activity()->causedBy(Auth::user())
            ->performedOn($pendaftaran)
            ->withProperties([
                'mahasiswa_nim' => $pendaftaran->mahasiswa->nim,
                'old_status' => $oldStatus,
                'new_status' => 'Tidak Lolos',
            ])
            ->event('updated')
            ->log('Tolak pendaftaran: ' . $pendaftaran->mahasiswa->nim . ' -> Tidak Lolos');

        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Berkas pendaftaran Anda dinyatakan TIDAK LENGKAP / TIDAK LOLOS.', 'danger');

        return back()->with('success', 'Berkas peserta dinyatakan Tidak Lengkap.');
    }

    public function validasiBerkas(BerkasPendaftaran $berkas, Request $request)
    {
        $request->validate(['status' => 'required|in:Valid,Tidak Valid']);
        $oldStatus = $berkas->status_validasi;
        $berkas->update(['status_validasi' => $request->status]);

        activity()->causedBy(Auth::user())
            ->performedOn($berkas)
            ->withProperties([
                'berkas_nama' => $berkas->nama_berkas,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
            ])
            ->event('updated')
            ->log('Validasi berkas: ' . $berkas->nama_berkas . ' -> ' . $request->status);

        $this->sendNotification($berkas->pendaftaran->mahasiswa->user_id, 'Dokumen "' . $berkas->nama_berkas . '" Anda dinyatakan ' . strtoupper($request->status) . '.', $request->status === 'Valid' ? 'success' : 'danger');

        return back()->with('success', 'Validasi berkas berhasil diperbarui.');
    }

    public function validasiPortofolio(\App\Models\PortofolioCu $portofolio, Request $request)
    {
        $request->validate(['status' => 'required|in:Valid,Tidak Valid']);
        $oldStatus = $portofolio->status_validasi;
        $portofolio->update(['status_validasi' => $request->status]);

        activity()->causedBy(Auth::user())
            ->performedOn($portofolio)
            ->withProperties([
                'prestasi' => $portofolio->nama_prestasi,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
            ])
            ->event('updated')
            ->log('Validasi portofolio: ' . $portofolio->nama_prestasi . ' -> ' . $request->status);

        $this->sendNotification($portofolio->pendaftaran->mahasiswa->user_id, 'Portofolio CU "' . $portofolio->nama_prestasi . '" Anda dinyatakan ' . strtoupper($request->status) . '.', $request->status === 'Valid' ? 'success' : 'danger');

        return back()->with('success', 'Validasi portofolio berhasil diperbarui.');
    }
}
