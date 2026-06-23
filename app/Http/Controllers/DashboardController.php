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
use App\Models\Jadwal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $stats = [];
        $mahasiswaList = collect();
        $jadwalList = collect();
        $penugasanList = collect();

        if ($role === 'admin') {
            $stats = [
                'total_pendaftar'   => Pendaftaran::query()->count('*'),
                'berkas_lengkap'    => Pendaftaran::query()->where('status_berkas', 'Lengkap')->count('*'),
                'lolos_tahap1'      => Pendaftaran::query()->where('status_seleksi', 'Lolos Tahap 1')->count('*'),
                'total_kriteria'    => KriteriaPenilaian::query()->count('*'),
            ];

            $mahasiswaList = User::query()
                ->where('role', 'mahasiswa')
                ->with('mahasiswa.jenjang')
                ->orderBy('nama_lengkap')
                ->get();

            $mhsIds = $mahasiswaList->pluck('mahasiswa.id')->filter();
            $pendaftaranByMhs = Pendaftaran::whereIn('mahasiswa_id', $mhsIds)->get()->keyBy('mahasiswa_id');

            $mahasiswaList = $mahasiswaList->map(function ($user) use ($pendaftaranByMhs) {
                    $mhs = $user->mahasiswa;
                    $pd = $pendaftaranByMhs->get($mhs?->id);
                    $status = !$pd ? 'Belum Daftar' : ($pd->status_seleksi === 'Lolos Tahap 1' ? 'Lolos T1' : $pd->status_berkas);
                    return (object) [
                        'nama'   => $user->nama_lengkap,
                        'email'  => $user->email,
                        'jenjang' => $mhs?->jenjang?->nama_jenjang ?? '—',
                        'status'  => $status,
                        'inisial' => strtoupper(substr($user->nama_lengkap, 0, 1)),
                    ];
                });

            $jadwalList = Jadwal::query()
                ->where('tanggal_selesai', '>=', now()->subDays(1))
                ->orWhereNull('tanggal_selesai')
                ->orderBy('tanggal_mulai')
                ->take(4)
                ->get();
        } elseif ($role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::query()->where('user_id', $user->id)->first();
            $pendaftaran = $mahasiswa
                ? Pendaftaran::query()->where('mahasiswa_id', $mahasiswa->id)->with('berkas', 'hasil')->first()
                : null;
            $stats = compact('mahasiswa', 'pendaftaran');
        } elseif ($role === 'juri') {
            $penugasanList = PenugasanJuri::with([
                'pendaftaran.mahasiswa.user',
                'pendaftaran.mahasiswa.jenjang',
            ])
                ->where('juri_id', $user->id)
                ->latest()
                ->take(10)
                ->get();

            $pendaftaranIds = $penugasanList->pluck('pendaftaran_id')->filter();
            $kriteriaCountByJenjang = \App\Models\KriteriaPenilaian::selectRaw('jenjang_id, COUNT(*) as total')
                ->groupBy('jenjang_id')->pluck('total', 'jenjang_id');
            $scoredByPendaftaran = \App\Models\Penilaian::where('juri_id', $user->id)
                ->whereIn('pendaftaran_id', $pendaftaranIds)
                ->selectRaw('pendaftaran_id, COUNT(DISTINCT kriteria_id) as scored')
                ->groupBy('pendaftaran_id')->pluck('scored', 'pendaftaran_id');

            $penugasanList = $penugasanList->map(function ($p) use ($kriteriaCountByJenjang, $scoredByPendaftaran) {
                    $m = $p->pendaftaran?->mahasiswa;
                    $jenjangId = $m?->jenjang_id;
                    $totalKriteria = $kriteriaCountByJenjang->get($jenjangId, 0);
                    $scoredKriteria = $scoredByPendaftaran->get($p->pendaftaran_id, 0);
                    return (object) [
                        'id'       => $p->pendaftaran_id,
                        'nama'     => $m?->user?->nama_lengkap ?? '-',
                        'nim'      => $m?->nim ?? '-',
                        'prodi'    => $m?->parsed_prodi ?? '-',
                        'jenjang'  => $m?->jenjang?->kode_jenjang ?? '-',
                        'inisial'  => strtoupper(substr($m?->user?->nama_lengkap ?? '?', 0, 1)),
                        'selesai'  => $scoredKriteria >= $totalKriteria,
                    ];
                });
            $totalTugas = PenugasanJuri::query()->where('juri_id', $user->id)->count('*');
            $totalSelesai = $penugasanList->where('selesai', true)->count();
            $stats = [
                'total_tugas'   => $totalTugas,
                'total_selesai' => $totalSelesai,
            ];
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

        return view('dashboard.index', compact(
            'role', 'stats', 'notifications',
            'mahasiswaList', 'jadwalList', 'penugasanList'
        ));
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
