<?php

namespace App\Http\Controllers\WR3;

use App\Http\Controllers\Controller;
use App\Models\HasilPenilaian;
use Illuminate\Support\Facades\Auth;

class RekomendaciController extends Controller
{
    use \App\Traits\Notifiable;

    public function index()
    {
        $jenjangList = \App\Models\Jenjang::orderBy('id')->get();
        $hasilAll = HasilPenilaian::with('pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang')
            ->orderBy('ranking')->get();
        $grouped = $hasilAll->groupBy(fn($h) => $h->pendaftaran->mahasiswa->jenjang->nama_jenjang ?? '-');
        $wr3User = \App\Models\User::where('role', 'wr3')->first();
        return view('wr3.rekomendasi.index', compact('hasilAll', 'grouped', 'jenjangList', 'wr3User'));
    }

    public function validasi()
    {
        $updatedCount = HasilPenilaian::where('validasi_wr3', 'Pending')
            ->update(['validasi_wr3' => 'Divalidasi']);

        // Update status_seleksi peserta menjadi Selesai
        $allUpdated = HasilPenilaian::with('pendaftaran')->get();
        $allUpdated->each(function ($hasil) {
            $hasil->pendaftaran->update(['status_seleksi' => 'Selesai']);
        });

        activity()->causedBy(Auth::user())
            ->withProperties([
                'records_validated' => $updatedCount,
                'total_records' => $allUpdated->count(),
            ])
            ->event('updated')
            ->log('WR3 validasi akhir: ' . $updatedCount . ' hasil direkomendasi');

        $this->notifyAllRole('mahasiswa', 'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.', 'info');

        return back()->with('success', 'Semua hasil rekomendasi telah divalidasi oleh Wakil Rektor III.');
    }
}
