<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\RekapTahap1;
use App\Models\PenugasanJuri;
use App\Models\User;
use App\Models\Jenjang;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    use \App\Traits\Notifiable;

    public function index(Request $request)
    {
        $query = RekapTahap1::with('pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang');

        if ($request->filled('tahun')) {
            $query->whereHas('pendaftaran', fn($q) =>
                $q->whereYear('tanggal_daftar', $request->tahun)
            );
        }

        $rekaps = $query->latest()->get();
        $jenjangList = Jenjang::orderBy('id')->get();
        $grouped = $rekaps->groupBy(fn($r) => $r->pendaftaran->mahasiswa->jenjang?->nama_jenjang ?? 'Sarjana');

        $years = RekapTahap1::join('pendaftaran', 'rekap_tahap_1.pendaftaran_id', '=', 'pendaftaran.id')
            ->selectRaw('YEAR(pendaftaran.tanggal_daftar) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $semuaTervalidasi = $rekaps->isNotEmpty() && $rekaps->every(fn($r) => $r->status_laporan === 'Divalidasi');

        return view('admin.rekap.index', compact('grouped', 'jenjangList', 'years', 'semuaTervalidasi'));
    }

    public function lolos(Pendaftaran $pendaftaran)
    {
        $rekap = $pendaftaran->rekap;
        if (!$rekap || $rekap->status_laporan !== 'Divalidasi') {
            return back()->with('error', 'Peserta belum divalidasi WR3. Silakan tunggu validasi WR3 terlebih dahulu.');
        }

        $pendaftaran->update([
            'status_seleksi' => 'Lolos Tahap 1',
            'status_berkas' => 'Lengkap'
        ]);
        
        $juris = User::where('role', 'juri')->get();
        foreach ($juris as $juri) {
            PenugasanJuri::firstOrCreate([
                'juri_id' => $juri->id,
                'pendaftaran_id' => $pendaftaran->id
            ]);
            $this->sendNotification($juri->id, 'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.', 'info');
        }

        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Selamat! Anda dinyatakan LOLOS seleksi Tahap I (Administrasi).', 'success');

        return back()->with('success', 'Peserta dinyatakan Lolos Tahap I dan telah ditugaskan ke seluruh juri otomatis.');
    }

    public function tidakLolos(Pendaftaran $pendaftaran)
    {
        $pendaftaran->update(['status_seleksi' => 'Tidak Lolos']);
        
        $this->sendNotification($pendaftaran->mahasiswa->user_id, 'Mohon maaf, Anda dinyatakan TIDAK LOLOS seleksi Tahap I.', 'danger');

        return back()->with('success', 'Peserta dinyatakan Tidak Lolos Tahap I.');
    }

    public function penugasan()
    {
        $pesertaLolos = Pendaftaran::with('mahasiswa.user', 'mahasiswa.jenjang', 'rekap')
            ->where('status_seleksi', 'Lolos Tahap 1')
            ->whereHas('rekap', fn($q) => $q->where('status_laporan', 'Divalidasi'))
            ->get();
        $juris = User::where('role', 'juri')->get();
        $penugasans = PenugasanJuri::with('juri', 'pendaftaran.mahasiswa.user', 'pendaftaran.mahasiswa.jenjang')->get();

        $penugasanPerJuri = $juris->mapWithKeys(function ($juri) use ($penugasans) {
            $items = $penugasans->where('juri_id', $juri->id);
            return [$juri->id => [
                'juri' => $juri,
                'peserta' => $items,
                'total' => $items->count(),
            ]];
        });

        return view('admin.rekap.penugasan', compact('pesertaLolos', 'juris', 'penugasans', 'penugasanPerJuri'));
    }

    public function storePenugasan(Request $request)
    {
        $request->validate([
            'juri_id'        => 'required|exists:users,id',
            'pendaftaran_id' => 'required|array',
            'pendaftaran_id.*' => 'exists:pendaftaran,id',
        ]);

        foreach ($request->pendaftaran_id as $pid) {
            PenugasanJuri::firstOrCreate([
                'juri_id'        => $request->juri_id,
                'pendaftaran_id' => $pid,
            ]);
        }

        $juri = User::find($request->juri_id);
        $this->sendNotification($juri->id, 'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.', 'info');

        return back()->with('success', 'Penugasan juri berhasil disimpan.');
    }
}
