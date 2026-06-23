<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pengumuman;
use App\Models\Persyaratan;
use App\Models\Mahasiswa;
use App\Models\Pendaftaran;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function beranda()
    {
        $jadwal = Jadwal::orderBy('tanggal_mulai', 'asc')->get();
        $pengumuman = Pengumuman::orderBy('tanggal_publish', 'desc')->limit(3)->get();
        return view('welcome', compact('jadwal', 'pengumuman'));
    }

    public function informasi()
    {
        $persyaratan = Persyaratan::all();
        return view('informasi', compact('persyaratan'));
    }

    public function jadwal()
    {
        $jadwal = Jadwal::orderBy('tanggal_mulai', 'asc')->get();
        return view('jadwal', compact('jadwal'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::orderBy('tanggal_publish', 'desc')->get();
        return view('pengumuman', compact('pengumuman'));
    }

    public function getProdiList()
    {
        return response()->json(ProgramStudi::pluck('nama', 'kode'));
    }

    public function cekStatus($nim)
    {
        // Logged-in mahasiswa may only check their own NIM
        if (auth()->check() && auth()->user()->role === 'mahasiswa') {
            $ownMhs = Mahasiswa::where('user_id', auth()->id())->first();
            if (!$ownMhs || $ownMhs->nim !== $nim) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
        }

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        if (!$mahasiswa) {
            return response()->json(['success' => false, 'message' => 'Not Found']);
        }

        $pendaftaran = Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->first();
        if (!$pendaftaran) {
            return response()->json(['success' => false, 'message' => 'Belum Mendaftar']);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'status_berkas' => $pendaftaran->status_berkas,
                'status_seleksi' => $pendaftaran->status_seleksi,
            ]
        ]);
    }
}
