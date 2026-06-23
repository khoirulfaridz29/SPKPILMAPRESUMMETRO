<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


---

# Security Fix Plan

> Ditemukan dari hasil security review tanggal 2026-06-08. Eksekusi dilakukan setelah sistem disetujui.
> Semua perubahan bersifat lokal — tidak di-push ke GitHub sampai disetujui.

## Urutan Eksekusi

1. Hapus `scratch_test.php` (FIX 3)
2. FIX 1 — IDOR BerkasController
3. FIX 2 — IDOR PenilaianController (Juri)
4. FIX 7 — Buat migration schema + hapus DDL dari controllers → `php artisan migrate`
5. FIX 5 — Rate limit login
6. FIX 4 — Throttle + sanitasi API publik
7. FIX 8 — Ganti `$request->all()` → `$request->validated()` (14 file)
8. FIX 9 — Perbaiki XSS di blade templates
9. FIX 10 — Password rule lebih kuat
10. FIX 11 — SESSION_SECURE_COOKIE di `.env`
11. FIX 12 — Hapus duplikasi Gate
12. FIX 6 — `APP_DEBUG=false` (manual saat deploy ke production)

---

## KRITIS

---

### FIX 1 — IDOR: Mahasiswa bisa hapus berkas milik orang lain

**File:** `app/Http/Controllers/Mahasiswa/BerkasController.php`
- Baris 121 — `destroy()`: tidak cek kepemilikan sebelum hapus
- Baris 128 — `destroyPortofolio()`: `findOrFail($id)` tanpa cek kepemilikan

```php
// METHOD destroy() — tambahkan ownership check
public function destroy(BerkasPendaftaran $berkas)
{
    if ($berkas->pendaftaran->mahasiswa->user_id !== Auth::id()) {
        abort(403);
    }
    Storage::disk('public')->delete($berkas->file_path);
    $berkas->delete();
    return back()->with('success', 'Berkas berhasil dihapus.');
}

// METHOD destroyPortofolio() — tambahkan ownership check
public function destroyPortofolio($id)
{
    $porto = \App\Models\PortofolioCu::findOrFail($id);
    if ($porto->pendaftaran->mahasiswa->user_id !== Auth::id()) {
        abort(403);
    }
    Storage::disk('public')->delete($porto->file_path);
    $porto->delete();
    return redirect()->route('mahasiswa.berkas.index', ['tab' => 'portofolio'])
        ->with('success', 'Portofolio CU berhasil dihapus.');
}
```

---

### FIX 2 — IDOR: Juri bisa menilai peserta yang bukan tugasannya

**File:** `app/Http/Controllers/Juri/PenilaianController.php`
- Method `show()` dan `store()` — hanya cek role, tidak cek assignment

```php
// Tambahkan di baris PERTAMA method show() dan store():
$penugasan = PenugasanJuri::where('juri_id', Auth::id())
    ->where('pendaftaran_id', $pendaftaran->id)
    ->firstOrFail();
```

---

### FIX 3 — Hapus scratch_test.php dari root project

**File:** `scratch_test.php` (root project)

Bootstrap seluruh app Laravel dan dump isi database. Hapus file ini.

```bash
rm scratch_test.php
```

---

## TINGGI

---

### FIX 4 — Public API enumerasi data mahasiswa tanpa auth & rate limit

**File:** `routes/web.php` — baris 49–63

```php
// GANTI route /api/cek-status menjadi:
Route::middleware(['throttle:10,1'])->get('/api/cek-status/{nim}', function($nim) {
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
            'status_berkas'  => $pendaftaran->status_berkas,
            'status_seleksi' => $pendaftaran->status_seleksi,
        ]
    ]);
});
// nama & prodi dihapus dari response
```

---

### FIX 5 — Brute force login (tidak ada rate limiting)

**File:** `routes/web.php`

```php
// SEBELUM:
Route::post('/login', [AuthController::class, 'login']);

// SESUDAH:
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
```

---

### FIX 6 — APP_DEBUG=true (lakukan saat deploy ke production)

**File:** `.env` di server production

```env
APP_ENV=production
APP_DEBUG=false
```

---

### FIX 7 — DDL ALTER TABLE dijalankan dari request controller

**File-file:**
- `app/Http/Controllers/Mahasiswa/BerkasController.php` baris 85–89
- `app/Http/Controllers/Juri/PenilaianController.php` baris 75–77
- `app/Http/Controllers/Admin/KriteriaController.php` baris 16–17

Buat migration baru, lalu hapus semua blok `try { DB::statement("ALTER TABLE...") }` dari ketiga controller.

```bash
php artisan make:migration fix_schema_columns
```

```php
// Isi migration up():
public function up(): void
{
    if (Schema::hasTable('portofolio_cu') && !Schema::hasColumn('portofolio_cu', 'skor_rekomendasi')) {
        Schema::table('portofolio_cu', function (Blueprint $table) {
            $table->string('skor_rekomendasi', 50)->nullable();
        });
    }

    if (Schema::hasTable('penilaian')) {
        Schema::table('penilaian', function (Blueprint $table) {
            $table->decimal('nilai_input', 8, 4)->nullable()->change();
        });
    }

    if (Schema::hasTable('kriteria_penilaian') && !Schema::hasColumn('kriteria_penilaian', 'tipe_faktor')) {
        Schema::table('kriteria_penilaian', function (Blueprint $table) {
            $table->enum('tipe_faktor', ['Core Factor', 'Secondary Factor'])->default('Core Factor');
        });
        DB::statement("UPDATE kriteria_penilaian SET tipe_faktor = 'Secondary Factor' WHERE kode_kriteria IN ('A03', 'F03')");
    }
}
```

```bash
php artisan migrate
```

---

## SEDANG

---

### FIX 8 — `$request->all()` seharusnya `$request->validated()`

**File-file (14 tempat di `app/Http/Controllers/Admin/`):**

| File | Baris | Method |
|------|-------|--------|
| JadwalController.php | 31, 50 | store, update |
| KriteriaController.php | 43, 63 | store, update |
| PersyaratanController.php | 30, 48 | store, update |
| RubrikBahasaInggrisController.php | 36, 60 | store, update |
| RubrikNaskahGkController.php | 30, 48 | store, update |
| RubrikPresentasiGkController.php | 30, 48 | store, update |
| RubrikWawancaraCuController.php | 29, 48 | store, update |

```php
// SEBELUM (semua file):
Model::create($request->all());
$model->update($request->all());

// SESUDAH:
Model::create($request->validated());
$model->update($request->validated());
```

---

### FIX 9 — XSS: output tidak di-escape

**File 1:** `resources/views/pengumuman.blade.php` baris 97

```blade
{{-- SEBELUM: --}}
{!! $item->konten !!}

{{-- SESUDAH: --}}
{!! strip_tags($item->konten, '<p><br><b><i><ul><li><strong><em>') !!}
```

**File 2:** `resources/views/layouts/app.blade.php` baris 240
**File 3:** `resources/views/layouts/dashboard.blade.php` baris 504

```blade
{{-- SEBELUM: --}}
html: '<ul class="list-group list-group-flush mb-0 bg-transparent">{!! addslashes($errList) !!}</ul>',

{{-- SESUDAH: --}}
html: '<ul class="list-group list-group-flush mb-0 bg-transparent">{!! e($errList) !!}</ul>',
```

---

### FIX 10 — Password minimum terlalu lemah (min:6)

**File 1:** `app/Http/Controllers/AuthController.php` baris 50
**File 2:** `app/Http/Controllers/Admin/UserManagementController.php` baris 30

```php
// Tambahkan use di atas class (kedua file):
use Illuminate\Validation\Rules\Password;

// AuthController — SEBELUM:
'password' => 'required|string|min:6|confirmed',
// SESUDAH:
'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],

// UserManagementController — SEBELUM:
'password' => 'required|string|min:6',
// SESUDAH:
'password' => ['required', Password::min(8)->letters()->numbers()],
```

---

## RENDAH

---

### FIX 11 — SESSION_SECURE_COOKIE tidak diset

**File:** `.env`

```env
SESSION_SECURE_COOKIE=false   # untuk lokal (HTTP)
# SESSION_SECURE_COOKIE=true  # uncomment ini saat deploy ke HTTPS
```

---

### FIX 12 — Duplikasi Gate definition

**File:** `app/Providers/AuthServiceProvider.php`

Gate sudah didefinisikan di `AppServiceProvider`. Kosongkan di sini:

```php
public function boot(): void
{
    // Gate definitions ada di AppServiceProvider
}
```

---

### Jalankan urutan ini

git add .

git status

git commit -m "Perbaikan tampilan portofolio dan penilaian juri"

git push origin master



## evaluasi semantara perhitungan GAP
- Perubahan mlm ini hanya ada di View/Juri/show.blade.php
- Skema perhitungan cu itu sistem akan memberikan rekomendasi nilainya dan juri tetap input nilai nya
- test cek kembali skema perhitunga CU portofolio apakah sudah sesuai
- besok testing semua penilaian dari juri input 3, 3 nya
- di tampilan perhitungan Portofolio CU masih memunculkan rekomendasi 60 (di ganti)
- Sudah done mungkin tinggal penyesuaiann

# perubahan keperluan deploy

- app/Http/Controllers/Admin/PerhitunganController.php, cari dan hapus blok ini di awal method proses():
   
    try {
            \Illuminate\Support\Facades\Schema::table('hasil_penilaian', function ($table) {
                if (!\Illuminate\Support\Facades\Schema::hasColumn('hasil_penilaian', 'nilai_sementara')) {
                    $table->decimal('nilai_sementara', 8, 4)->nullable();
                }
            });
        } catch (\Exception $e) {
            // ignore
        }

- Penambahan bosostrap/app.php
  
  <?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
        //
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*'); // ← tambahkan ini
})






CATATAN
KALAU BISA SEBELUM TANGGAL 30 SUDAH SIDANG SEGERA
