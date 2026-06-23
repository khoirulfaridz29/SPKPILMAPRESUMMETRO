<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\BerkasPendaftaran;
use App\Models\Pendaftaran;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    use \App\Traits\Notifiable;

    private function getPendaftaran()
    {
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        return $mahasiswa ? Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->first() : null;
    }

    public function index(Request $request)
    {
        $pendaftaran = $this->getPendaftaran();
        if (!$pendaftaran) {
            return redirect()->route('mahasiswa.pendaftaran.create')->with('error', 'Silakan daftar terlebih dahulu.');
        }
        $berkass = BerkasPendaftaran::where('pendaftaran_id', $pendaftaran->id)->get();
        $persyaratan = \App\Models\Persyaratan::all();
        $portofolios = \App\Models\PortofolioCu::where('pendaftaran_id', $pendaftaran->id)->get();
        $rubriks = \App\Models\RubrikCapaianUnggulan::all();

        // Dynamic rubrik info based on student's jenjang (keyword matching from KRITERIA PENILAIAN)
        $mahasiswa = \App\Models\Mahasiswa::where('user_id', Auth::id())->first();
        $studentJenjangId = $mahasiswa->jenjang_id ?? 1;
        $kriterias = \App\Models\KriteriaPenilaian::where('jenjang_id', $studentJenjangId)->get();
        $kriteriaNames = $kriterias->pluck('nama_kriteria')->map(fn($n) => strtolower($n));

        $hasNaskah = $kriteriaNames->contains(fn($n) =>
            str_contains($n, 'naskah') || str_contains($n, 'gagasan kreatif') || str_contains($n, 'produk inovatif')
        );
        $hasBi = $kriteriaNames->contains(fn($n) =>
            str_contains($n, 'bahasa inggris') || str_contains($n, 'bi ')
        );

        $naskahLabel = \App\Models\RubrikNaskahGk::where('jenjang_id', $studentJenjangId)->value('label');
        $rubrikNaskahLabel = $naskahLabel ?? ($mahasiswa->jenjang?->kode_jenjang === 'D3' ? 'Produk Inovatif' : 'Gagasan Kreatif');

        $activeTab = $request->get('tab', 'dokumen');

        return view('mahasiswa.berkas.index', compact(
            'berkass', 'pendaftaran', 'persyaratan', 'portofolios', 'rubriks', 'activeTab',
            'rubrikNaskahLabel', 'hasNaskah', 'hasBi'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_berkas' => 'required|string|max:255',
        ];

        if ($request->nama_berkas === 'Video Bahasa Inggris') {
            $rules['file'] = 'required|file|mimes:mp4,webm,mkv,avi|max:20480';
        } else {
            $rules['file'] = 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120';
        }

        $request->validate($rules);

        $pendaftaran = $this->getPendaftaran();
        if (!$pendaftaran) abort(403);

        $path = $request->file('file')->store('berkas/' . $pendaftaran->id, 'public');

        BerkasPendaftaran::create([
            'pendaftaran_id'  => $pendaftaran->id,
            'nama_berkas'     => $request->nama_berkas,
            'file_path'       => $path,
            'status_validasi' => 'Pending',
        ]);

        $this->sendNotification(Auth::id(), 'Berkas "' . $request->nama_berkas . '" berhasil diunggah.', 'success');
        $this->notifyAllAdmins('Berkas baru diunggah oleh ' . Auth::user()->nama_lengkap . ': ' . $request->nama_berkas, 'info');

        return redirect()->route('mahasiswa.berkas.index', ['tab' => $request->tab ?? 'dokumen'])->with('success', 'Berkas berhasil diunggah.');
    }

    public function storePortofolio(Request $request)
    {
        $request->validate([
            'rubrik_cu_id' => 'required|exists:rubrik_capaian_unggulans,id',
            'kategori_jenjang' => 'required|string|max:50',
            'nama_prestasi' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'file' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $pendaftaran = $this->getPendaftaran();
        if (!$pendaftaran) abort(403);

        $path = $request->file('file')->store('portofolio/' . $pendaftaran->id, 'public');

        $rubrik = \App\Models\RubrikCapaianUnggulan::find($request->rubrik_cu_id);
        $skor_rekomendasi = null;
        if ($rubrik) {
            $jenjang = strtolower($request->kategori_jenjang);
            if ($jenjang === 'kab/kota/pt' || $jenjang === 'kabupaten/kota/pt' || $jenjang === 'kab_kota') {
                $field = 'skor_kab_kota';
            } else {
                $field = 'skor_' . $jenjang;
            }
            $skor_rekomendasi = $rubrik->$field ?? null;
        }

        \App\Models\PortofolioCu::create([
            'pendaftaran_id' => $pendaftaran->id,
            'rubrik_cu_id' => $request->rubrik_cu_id,
            'kategori_jenjang' => $request->kategori_jenjang,
            'nama_prestasi' => $request->nama_prestasi,
            'tempat' => $request->tempat,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'file_path' => $path,
            'status_validasi' => 'Pending',
            'skor_rekomendasi' => $skor_rekomendasi,
        ]);

        return redirect()->route('mahasiswa.berkas.index', ['tab' => 'portofolio'])->with('success', 'Portofolio CU berhasil ditambahkan.');
    }

    public function destroy(BerkasPendaftaran $berkas)
    {
        $pendaftaran = $this->getPendaftaran();
        abort_if($berkas->pendaftaran_id !== $pendaftaran?->id, 403);

        Storage::disk('public')->delete($berkas->file_path);
        $berkas->delete();
        return back()->with('success', 'Berkas berhasil dihapus.');
    }

    public function destroyPortofolio($id)
    {
        $porto = \App\Models\PortofolioCu::findOrFail($id);
        $pendaftaran = $this->getPendaftaran();
        abort_if($porto->pendaftaran_id !== $pendaftaran?->id, 403);

        Storage::disk('public')->delete($porto->file_path);
        $porto->delete();
        return redirect()->route('mahasiswa.berkas.index', ['tab' => 'portofolio'])->with('success', 'Portofolio CU berhasil dihapus.');
    }
}
