<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PersyaratanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Mahasiswa\PendaftaranController;
use App\Http\Controllers\Mahasiswa\BerkasController;
use App\Http\Controllers\Juri\PenilaianController;
use App\Http\Controllers\WR3\ValidasiController;
use App\Http\Controllers\WR3\RekomendaciController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function() {
    $jadwal = \App\Models\Jadwal::orderBy('tanggal_mulai', 'asc')->get();
    $pengumuman = \App\Models\Pengumuman::orderBy('tanggal_publish', 'desc')->limit(3)->get();
    return view('welcome', compact('jadwal', 'pengumuman'));
})->name('beranda');

Route::get('/informasi', function() {
    $persyaratan = \App\Models\Persyaratan::all();
    return view('informasi', compact('persyaratan'));
})->name('informasi');

Route::get('/jadwal', function() {
    $jadwal = \App\Models\Jadwal::orderBy('tanggal_mulai', 'asc')->get();
    return view('jadwal', compact('jadwal'));
})->name('jadwal');

Route::get('/pengumuman', function() {
    $pengumuman = \App\Models\Pengumuman::orderBy('tanggal_publish', 'desc')->get();
    return view('pengumuman', compact('pengumuman'));
})->name('pengumuman');

// API Cek Status (Public)
Route::get('/api/cek-status/{nim}', function($nim) {
    $mahasiswa = \App\Models\Mahasiswa::where('nim', $nim)->first();
    if (!$mahasiswa) {
        return response()->json(['success' => false, 'message' => 'Not Found']);
    }

    $pendaftaran = \App\Models\Pendaftaran::where('mahasiswa_id', $mahasiswa->id)->first();
    if (!$pendaftaran) {
        return response()->json(['success' => false, 'message' => 'Belum Mendaftar']);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'nama' => $mahasiswa->user->nama_lengkap,
            'prodi' => $mahasiswa->program_studi,
            'status_berkas' => $pendaftaran->status_berkas,
            'status_seleksi' => $pendaftaran->status_seleksi,
        ]
    ]);
});

// ============================================
// GUEST ROUTES (Hanya untuk yang belum login)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ============================================
// AUTH ROUTES (Semua yang sudah login)
// ============================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-read', [DashboardController::class, 'markAllRead'])->name('notifications.markAllRead');

    // -----------------------------------------------
    // ADMIN - Bidang Kemahasiswaan
    // -----------------------------------------------
    Route::prefix('admin')->name('admin.')->middleware('can:admin')->group(function () {
        // Manajemen Kriteria & Rubrik
        Route::resource('kriteria', KriteriaController::class)->parameters([
            'kriteria' => 'kriteria'
        ]);
        Route::resource('rubrik-cu', \App\Http\Controllers\Admin\RubrikCapaianUnggulanController::class);
        Route::resource('rubrik-naskah-gk', \App\Http\Controllers\Admin\RubrikNaskahGkController::class);
        Route::resource('rubrik-presentasi-gk', \App\Http\Controllers\Admin\RubrikPresentasiGkController::class);
        Route::resource('rubrik-bahasa-inggris', \App\Http\Controllers\Admin\RubrikBahasaInggrisController::class);
        Route::resource('rubrik-wawancara-cu', \App\Http\Controllers\Admin\RubrikWawancaraCuController::class);

        // Manajemen Jadwal, Pengumuman, & Persyaratan
        Route::resource('jadwal', JadwalController::class);
        Route::resource('pengumuman', PengumumanController::class);
        Route::resource('persyaratan', PersyaratanController::class);

        // Manajemen Akun (Juri & WR3)
        Route::resource('users', UserManagementController::class);

        // Pendaftaran & Verifikasi Berkas
        Route::get('pendaftaran', [PendaftaranAdminController::class, 'index'])->name('pendaftaran.index');
        Route::get('pendaftaran/{pendaftaran}', [PendaftaranAdminController::class, 'show'])->name('pendaftaran.show');
        Route::post('pendaftaran/{pendaftaran}/verifikasi', [PendaftaranAdminController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
        Route::post('pendaftaran/{pendaftaran}/tolak', [PendaftaranAdminController::class, 'tolak'])->name('pendaftaran.tolak');
        Route::post('pendaftaran/berkas/{berkas}/validasi', [PendaftaranAdminController::class, 'validasiBerkas'])->name('pendaftaran.berkas.validasi');
        Route::post('pendaftaran/portofolio/{portofolio}/validasi', [PendaftaranAdminController::class, 'validasiPortofolio'])->name('pendaftaran.portofolio.validasi');

        // Rekap Tahap I & Penugasan Juri
        Route::get('rekap', [RekapController::class, 'index'])->name('rekap.index');
        Route::post('rekap/{pendaftaran}/lolos', [RekapController::class, 'lolos'])->name('rekap.lolos');
        Route::post('rekap/{pendaftaran}/tidak-lolos', [RekapController::class, 'tidakLolos'])->name('rekap.tidakLolos');
        Route::get('rekap/penugasan', [RekapController::class, 'penugasan'])->name('rekap.penugasan');
        Route::post('rekap/penugasan/store', [RekapController::class, 'storePenugasan'])->name('rekap.penugasan.store');

        // Perhitungan GAP & Hasil Akhir
        Route::get('perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
        Route::post('perhitungan/proses', [PerhitunganController::class, 'proses'])->name('perhitungan.proses');
        Route::get('perhitungan/hasil', [PerhitunganController::class, 'hasil'])->name('perhitungan.hasil');
        Route::get('perhitungan/export', [PerhitunganController::class, 'export'])->name('perhitungan.export');
    });

    // -----------------------------------------------
    // MAHASISWA
    // -----------------------------------------------
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('can:mahasiswa')->group(function () {
        Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
        Route::post('pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::post('pendaftaran/submit', [PendaftaranController::class, 'submit'])->name('pendaftaran.submit');
        Route::get('berkas', [BerkasController::class, 'index'])->name('berkas.index');
        Route::post('berkas', [BerkasController::class, 'store'])->name('berkas.store');
        Route::delete('berkas/{berkas}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
        Route::post('berkas/portofolio', [BerkasController::class, 'storePortofolio'])->name('berkas.portofolio.store');
        Route::delete('berkas/portofolio/{id}', [BerkasController::class, 'destroyPortofolio'])->name('berkas.portofolio.destroy');
    });

    // -----------------------------------------------
    // JURI
    // -----------------------------------------------
    Route::prefix('juri')->name('juri.')->middleware('can:juri')->group(function () {
        Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
        Route::get('penilaian/{pendaftaran}', [PenilaianController::class, 'show'])->name('penilaian.show');
        Route::post('penilaian/{pendaftaran}', [PenilaianController::class, 'store'])->name('penilaian.store');
        Route::get('nilai', [PenilaianController::class, 'nilai'])->name('penilaian.nilai');
    });

    // -----------------------------------------------
    // WR3 - Wakil Rektor III
    // -----------------------------------------------
    Route::prefix('wr3')->name('wr3.')->middleware('can:wr3')->group(function () {
        Route::get('validasi', [ValidasiController::class, 'index'])->name('validasi.index');
        Route::post('validasi/{rekap}/approve', [ValidasiController::class, 'approve'])->name('validasi.approve');
        Route::get('rekomendasi', [RekomendaciController::class, 'index'])->name('rekomendasi.index');
        Route::post('rekomendasi/validasi', [RekomendaciController::class, 'validasi'])->name('rekomendasi.validasi');
    });
});
