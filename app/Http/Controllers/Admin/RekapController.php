<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\RekapTahap1;
use App\Models\PenugasanJuri;
use App\Models\User;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    use \App\Traits\Notifiable;

    public function index()
    {
        $rekaps = RekapTahap1::with('pendaftaran.mahasiswa.user')->latest()->get();
        return view('admin.rekap.index', compact('rekaps'));
    }

    public function lolos(Pendaftaran $pendaftaran)
    {
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
        $pesertaLolos = Pendaftaran::with('mahasiswa.user')
            ->where('status_seleksi', 'Lolos Tahap 1')->get();
        $juris = User::where('role', 'juri')->get();
        $penugasans = PenugasanJuri::with('juri', 'pendaftaran.mahasiswa.user')->get();
        return view('admin.rekap.penugasan', compact('pesertaLolos', 'juris', 'penugasans'));
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
