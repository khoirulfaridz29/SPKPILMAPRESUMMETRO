<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\KriteriaPenilaian;
use App\Models\Mahasiswa;
use App\Models\HasilPenilaian;
use App\Models\PenugasanJuri;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $stats = [];

        if ($role === 'admin') {
            $stats = [
                'total_pendaftar'   => Pendaftaran::query()->count('*'),
                'berkas_lengkap'    => Pendaftaran::query()->where('status_berkas', 'Lengkap')->count('*'),
                'lolos_tahap1'      => Pendaftaran::query()->where('status_seleksi', 'Lolos Tahap 1')->count('*'),
                'total_kriteria'    => KriteriaPenilaian::query()->count('*'),
                'total_juri'        => User::query()->where('role', 'juri')->count('*'),
                'total_mahasiswa'   => User::query()->where('role', 'mahasiswa')->count('*'),
            ];
        } elseif ($role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::query()->where('user_id', $user->id)->first();
            $pendaftaran = $mahasiswa
                ? Pendaftaran::query()->where('mahasiswa_id', $mahasiswa->id)->with('berkas', 'hasil')->first()
                : null;
            $stats = compact('mahasiswa', 'pendaftaran');
        } elseif ($role === 'juri') {
            $totalTugas = PenugasanJuri::query()->where('juri_id', $user->id)->count('*');
            $stats = ['total_tugas' => $totalTugas];
        } elseif ($role === 'wr3') {
            $stats = [
                'total_rekap'    => \App\Models\RekapTahap1::query()->count('*'),
                'sudah_validasi' => \App\Models\RekapTahap1::query()->where('status_laporan', 'Divalidasi')->count('*'),
                'hasil_pending'  => HasilPenilaian::query()->where('validasi_wr3', 'Pending')->count('*'),
            ];
        }

        $notifications = \App\Models\NotificationApp::query()->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('role', 'stats', 'notifications'));
    }

    public function markAsRead($id)
    {
        $notification = \App\Models\NotificationApp::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    public function markAllRead()
    {
        \App\Models\NotificationApp::where('user_id', Auth::id())->where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }
}
