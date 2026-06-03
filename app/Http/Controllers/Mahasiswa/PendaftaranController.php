<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    private function getMahasiswa()
    {
        return Mahasiswa::where('user_id', Auth::id())->first();
    }

    public function index()
    {
        $mahasiswa = $this->getMahasiswa();
        $pendaftaran = $mahasiswa
            ? Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->with('berkas', 'hasil')->first()
            : null;
        return view('mahasiswa.pendaftaran.index', compact('pendaftaran', 'mahasiswa'));
    }

    public function create()
    {
        $mahasiswa = $this->getMahasiswa();
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Profil mahasiswa belum lengkap.');
        }
        $existing = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->first();
        if ($existing) {
            return redirect()->route('mahasiswa.pendaftaran.index')->with('error', 'Anda sudah mendaftar.');
        }
        return view('mahasiswa.pendaftaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ipk' => 'required|numeric|min:0|max:4',
            'pernah_pilmapres' => 'required|in:Belum Pernah,Lokal,Nasional',
        ]);

        $mahasiswa = $this->getMahasiswa();
        if (!$mahasiswa) abort(403);
        
        $mahasiswa->update([
            'ipk' => $request->ipk,
            'pernah_pilmapres' => $request->pernah_pilmapres,
        ]);

        Pendaftaran::create([
            'mahasiswa_id'   => $mahasiswa->id,
            'tanggal_daftar' => now()->toDateString(),
            'status_berkas'  => 'Belum Lengkap',
            'status_seleksi' => 'Proses',
            'is_submitted'   => false,
        ]);

        return redirect()->route('mahasiswa.berkas.index')->with('success', 'Data pendaftaran awal berhasil disimpan. Silakan unggah berkas persyaratan.');
    }

    public function submit()
    {
        $mahasiswa = $this->getMahasiswa();
        if (!$mahasiswa) abort(403);

        $pendaftaran = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->first();
        if (!$pendaftaran) abort(404);

        $pendaftaran->update(['is_submitted' => true]);

        return redirect()->route('mahasiswa.pendaftaran.index')->with('success', 'Pendaftaran Anda berhasil dikirim secara final.');
    }
}
