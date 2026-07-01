# Kriteria → Rubrik Redesign

## Problem

1. `nama_kriteria` di Kriteria Penilaian berupa free text, tidak terstandarisasi
2. `label` di rubrik diisi manual, redundan dengan nama_kriteria
3. Tidak ada cara untuk menambah jenis kriteria baru yang belum punya template rubrik
4. Tidak ada mekanisme reuse format rubrik untuk kriteria baru

## Pendekatan

Pendekatan 1: Link existing rubrik ke kriteria (disetujui).

## 1. Database Schema

### 1a. Kriteria Penilaian (form change only)

Struktur tabel tetap. `nama_kriteria` berubah dari text input menjadi dropdown dengan opsi:

| Opsi Dropdown | Kode Otomatis | Tabel Rubrik |
|--------------|---------------|--------------|
| Naskah Gagasan Kreatif | A02 | rubrik_naskah_gk |
| Presentasi Gagasan Kreatif | F02 | rubrik_presentasi_gk |
| Bahasa Inggris | A03/F03 | rubrik_bahasa_inggris |
| Wawancara Capaian Unggulan | F01 | rubrik_wawancara_cu |
| Portofolio Capaian Unggulan | A01 | rubrik_capaian_unggulan |
| Lainnya (custom) | manual input | rubrik_custom |

### 1b. 5 Tabel Rubrik + kriteria_id

Setiap tabel rubrik mendapat kolom baru:

- `kriteria_id` BIGINT UNSIGNED NULL, FK → `kriteria_penilaian.id`
- `label` tetap dipertahankan sebagai nullable (fallback untuk data lama dengan kriteria_id = NULL)
- `jenjang_id` tetap dipertahankan

### 1c. Custom Template Tables

```sql
CREATE TABLE rubrik_custom_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_template VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE TABLE rubrik_custom_template_fields (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id BIGINT UNSIGNED NOT NULL,
    nama_field VARCHAR(255) NOT NULL,
    tipe_input ENUM('text','number','textarea','score_range') NOT NULL,
    urutan INT NOT NULL DEFAULT 0,
    bobot DECIMAL(5,2) NULL,
    FOREIGN KEY (template_id) REFERENCES rubrik_custom_templates(id) ON DELETE CASCADE
);
```

Data penilaian untuk custom rubrik tetap masuk ke tabel `Penilaian` (existing).

## 2. UI / Form Changes

### 2a. Kriteria Penilaian (Create & Edit)

- `nama_kriteria`: text → dropdown dengan opsi di atas
- `kode_kriteria`: diisi otomatis berdasarkan pilihan dropdown
- Jika pilih "Lainnya (custom)": muncul input text untuk nama_kriteria + kode_kriteria manual
- Filter per jenjang: dropdown opsi bisa dibedakan per jenjang (opsional)

### 2b. Form Rubrik (per tipe)

- Input `label` dihapus
- Dropdown **Pilih Kriteria**: isi diffilter berdasarkan:
  - `jenjang_id` yang dipilih
  - Tipe rubrik (misal: Naskah GK → cuma tipe "Naskah Gagasan Kreatif")
- Label tampilan otomatis mengikuti `kriteria_penilaian.nama_kriteria`

### 2c. Custom Template Builder

- Form dinamis dengan tombol "Tambah Field"
- Setiap field: nama_field (text), tipe_input (select: text/number/textarea/score_range), urutan, bobot
- Disimpan ke `rubrik_custom_templates` + `rubrik_custom_template_fields`
- Template yang sudah tersimpan bisa dipilih ulang untuk kriteria custom lainnya

### 2d. Label di View / Tampilan

Semua tampilan yang menggunakan `$rubrik->label` diganti dengan `$rubrik->kriteria->nama_kriteria` atau fallback ke label lama untuk data existing (nullable kriteria_id).

## 3. Flow / User Journey

1. **Jenjang**: Tambah/edit — sama seperti sekarang, tidak ada perubahan
2. **Kriteria Penilaian**: Pilih jenjang → dropdown tipe → isi bobot/nilai_target/jenis_faktor → submit → kode_kriteria otomatis
3. **Rubrik (per tipe)**: Pilih jenjang → dropdown Pilih Kriteria (isi: kriteria yang cocok) → isi form rubrik → submit → label otomatis
4. **Custom template**: Pertama pilih "Lainnya" di kriteria → masuk ke rubrik → buat field lewat form builder → simpan sebagai template + data rubrik. Kriteria custom berikutnya bisa pilih template yang sama.

## 4. Migration

1. Add migration: `add_kriteria_id_to_rubrik_tables` — tambah `kriteria_id` (nullable) ke 5 tabel rubrik, buat FK
2. Add migration: `create_rubrik_custom_templates_tables` — buat 2 tabel baru
3. Seed: isi `kriteria_penilaian.nama_kriteria` dari label rubrik yang sudah ada
4. Backfill: set `kriteria_id` di rubrik berdasarkan `jenjang_id` + kecocokan tipe
5. Update form request validasi: `label` jadi nullable/opsional, tambah `kriteria_id` rules
6. (Opsional nanti) Drop kolom `label` setelah semua data terbackfill

## 5. Sidebar

Tidak ada perubahan navigasi sidebar. Rubrik tetap 5 menu terpisah.

## 6. Constraints

- Data rubrik lama dengan `kriteria_id = NULL` tetap tampil (backward compatibility), label fallback ke nilai `label` yang lama (kolom tetap dipertahankan sebagai nullable)
- Kode kriteria (A01, A02, dll) tetap digunakan untuk logika perhitungan GAP di PerhitunganController dan GapCalculatorService — tidak ada perubahan algoritma
- Custom template tidak mengubah logika perhitungan, hanya menyediakan form input untuk juri
- Untuk Bahasa Inggris, dropdown tipe "Bahasa Inggris" menghasilkan satu entri kriteria (A03 atau F03 tergantung user). User harus buat 2 kriteria (A03 + F03) untuk Video BI dan Lisan BI.

## 7. Files Changed

### Models
- App\Models\RubrikNaskahGk — tambah relasi `kriteria()`
- App\Models\RubrikPresentasiGk — tambah relasi `kriteria()`
- App\Models\RubrikBahasaInggris — tambah relasi `kriteria()`
- App\Models\RubrikWawancaraCu — tambah relasi `kriteria()`
- App\Models\RubrikCapaianUnggulan — tambah relasi `kriteria()`
- App\Models\KriteriaPenilaian — tambah relasi `rubrikNaskah()`, dll

### Controllers
- KriteriaPenilaianController — handle dropdown tipe, auto kode_kriteria
- 5 Rubrik controllers — ganti `label` → `kriteria_id`, resolve label dari relasi

### Requests
- RubrikNaskahGkRequest — hapus label, tambah kriteria_id rules
- RubrikPresentasiGkRequest — sama
- RubrikBahasaInggrisRequest — sama
- RubrikWawancaraCuRequest — sama

### Views
- `admin/kriteria_penilaian/*.blade.php` — dropdown nama_kriteria, auto kode
- `admin/rubrik_*/*.blade.php` — ganti label input jadi dropdown pilih kriteria
- Semua view/detail yang tampilkan label — ganti jadi `$rubrik->kriteria->nama_kriteria ?? $rubrik->label`

### Juri/PenilaianController
- Sesuaikan pembacaan label dari relasi kriteria
