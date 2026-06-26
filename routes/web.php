<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\JenjangController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PendaftaranAdminController;
use App\Http\Controllers\Admin\RekapController;
use App\Http\Controllers\Admin\PerhitunganController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PersyaratanController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\PanduanController;
use App\Http\Controllers\Mahasiswa\PendaftaranController;
use App\Http\Controllers\Mahasiswa\BerkasController;
use App\Http\Controllers\Juri\PenilaianController;
use App\Http\Controllers\WR3\ValidasiController;
use App\Http\Controllers\WR3\RekomendaciController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [\App\Http\Controllers\PublicController::class, 'beranda'])->name('beranda');
Route::get('/informasi', [\App\Http\Controllers\PublicController::class, 'informasi'])->name('informasi');
Route::get('/jadwal', [\App\Http\Controllers\PublicController::class, 'jadwal'])->name('jadwal');
Route::get('/pengumuman', [\App\Http\Controllers\PublicController::class, 'pengumuman'])->name('pengumuman');
Route::get('/api/cek-status/{nim}', [\App\Http\Controllers\PublicController::class, 'cekStatus'])
    ->middleware('throttle:10,1');
Route::get('/api/program-studi', [\App\Http\Controllers\PublicController::class, 'getProdiList']);

// ============================================
// GUEST ROUTES (Hanya untuk yang belum login)
// ============================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('throttle:3,1');
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
        Route::resource('panduan', PanduanController::class)->except(['show']);
        Route::resource('persyaratan', PersyaratanController::class);

        // Manajemen Jenjang Pendidikan
        Route::resource('jenjang', JenjangController::class)->except(['show']);

        // Manajemen Akun (Juri & WR3)
        Route::resource('users', UserManagementController::class);
        Route::post('users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');

        // Pendaftaran & Verifikasi Berkas
        Route::get('pendaftaran', [PendaftaranAdminController::class, 'index'])->name('pendaftaran.index');
        Route::get('pendaftaran/{pendaftaran}', [PendaftaranAdminController::class, 'show'])->name('pendaftaran.show');
        Route::post('pendaftaran/{pendaftaran}/verifikasi', [PendaftaranAdminController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
        Route::post('pendaftaran/{pendaftaran}/tolak', [PendaftaranAdminController::class, 'tolak'])->name('pendaftaran.tolak');
        Route::post('pendaftaran/berkas/{berkas}/validasi', [PendaftaranAdminController::class, 'validasiBerkas'])->name('pendaftaran.berkas.validasi');
        Route::post('pendaftaran/portofolio/{portofolio}/validasi', [PendaftaranAdminController::class, 'validasiPortofolio'])->name('pendaftaran.portofolio.validasi');
        Route::get('pendaftaran/berkas/{berkas}/lihat', [PendaftaranAdminController::class, 'lihatBerkas'])->name('pendaftaran.berkas.lihat');
        Route::get('pendaftaran/portofolio/{portofolio}/lihat', [PendaftaranAdminController::class, 'lihatPortofolio'])->name('pendaftaran.portofolio.lihat');

        // Rekap Tahap I & Penugasan Juri
        Route::get('rekap', [RekapController::class, 'index'])->name('rekap.index');
        Route::post('rekap/{pendaftaran}/lolos', [RekapController::class, 'lolos'])->name('rekap.lolos');
        Route::post('rekap/{pendaftaran}/tidak-lolos', [RekapController::class, 'tidakLolos'])->name('rekap.tidakLolos');
        Route::get('rekap/penugasan', [RekapController::class, 'penugasan'])->name('rekap.penugasan');
        Route::post('rekap/penugasan/store', [RekapController::class, 'storePenugasan'])->name('rekap.penugasan.store');

        // Perhitungan GAP & Hasil Akhir
        Route::get('perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan.index');
        Route::post('perhitungan/proses', [PerhitunganController::class, 'proses'])->name('perhitungan.proses');
        Route::post('perhitungan/reset', [PerhitunganController::class, 'resetPerhitungan'])->name('perhitungan.reset');
        Route::get('perhitungan/hasil', [PerhitunganController::class, 'hasil'])->name('perhitungan.hasil');
        Route::get('perhitungan/ranking', [PerhitunganController::class, 'ranking'])->name('perhitungan.ranking');
        Route::get('perhitungan/export', [PerhitunganController::class, 'export'])->name('perhitungan.export');
    });

    // Download Panduan (bisa diakses semua role yang login)
    Route::get('panduan/{panduan}/download', [\App\Http\Controllers\Admin\PanduanController::class, 'download'])->name('panduan.download');

    // Lihat Berkas (bisa diakses admin, juri, wr3 yang sudah login)
    Route::get('berkas/{berkas}/view', [\App\Http\Controllers\Admin\PendaftaranAdminController::class, 'lihatBerkas'])->name('berkas.view');
    Route::get('portofolio/{portofolio}/view', [\App\Http\Controllers\Admin\PendaftaranAdminController::class, 'lihatPortofolio'])->name('portofolio.view');

    // -----------------------------------------------
    // MAHASISWA
    // -----------------------------------------------
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('can:mahasiswa')->group(function () {
        Route::get('pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
        Route::post('pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
        Route::post('pendaftaran/submit', [PendaftaranController::class, 'submit'])->name('pendaftaran.submit');
        Route::get('berkas', [BerkasController::class, 'index'])->name('berkas.index');
        Route::post('berkas', [BerkasController::class, 'store'])->middleware('throttle:10,1')->name('berkas.store');
        Route::delete('berkas/{berkas}', [BerkasController::class, 'destroy'])->name('berkas.destroy');
        Route::post('berkas/portofolio', [BerkasController::class, 'storePortofolio'])->middleware('throttle:10,1')->name('berkas.portofolio.store');
        Route::delete('berkas/portofolio/{id}', [BerkasController::class, 'destroyPortofolio'])->name('berkas.portofolio.destroy');
        Route::get('berkas/{berkas}/lihat', [BerkasController::class, 'lihat'])->name('berkas.lihat');
        Route::get('portofolio/{portofolio}/lihat', [BerkasController::class, 'lihatPortofolio'])->name('portofolio.lihat');
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
