# Petunjuk Perhitungan GAP (Profile Matching)

Sistem ini menggunakan algoritma **GAP Analysis / Profile Matching** untuk menentukan peringkat mahasiswa dalam seleksi PILMAPRES.

---

## 1. Kriteria Penilaian

Terdapat **6 kriteria** yang dinilai oleh 3 Juri:

| Kode | Nama Kriteria | Tahap | Tipe Faktor | Bobot |
|------|--------------|-------|-------------|-------|
| A01 | Capaian Unggulan (CU) Berkas | Tahap Awal | Secondary Factor | 35% |
| A02 | Gagasan Kreatif (GK) Naskah | Tahap Awal | Secondary Factor | 35% |
| A03 | Bahasa Inggris (BI) Video | Tahap Awal | Secondary Factor | 30% |
| F01 | Capaian Unggulan (CU) Wawancara | Tahap Final | Core Factor | 35% |
| F02 | Gagasan Kreatif (GK) Presentasi | Tahap Final | Core Factor | 35% |
| F03 | Bahasa Inggris (BI) Lisan | Tahap Final | Core Factor | 30% |

**Pembagian Faktor:**
- **Secondary Factor (SF)** → Kriteria A01, A02, A03 → digunakan untuk **NSF**
- **Core Factor (CF)** → Kriteria F01, F02, F03 → digunakan untuk **NCF**

---

## 2. Alur Perhitungan

```
Nilai Juri 1  ─┐
Nilai Juri 2  ─┼─→ Rata-rata → × Bobot → Skala 1-10 → GAP → Bobot GAP
Nilai Juri 3  ─┘
```

### Step 1: Rata-rata Nilai per Kriteria

Rata-rata nilai dari seluruh juri untuk setiap kriteria:

```
AVG_A01 = (Nilai_J1_A01 + Nilai_J2_A01 + Nilai_J3_A01) / 3
AVG_A02 = (Nilai_J1_A02 + Nilai_J2_A02 + Nilai_J3_A02) / 3
AVG_A03 = (Nilai_J1_A03 + Nilai_J2_A03 + Nilai_J3_A03) / 3
AVG_F01 = (Nilai_J1_F01 + Nilai_J2_F01 + Nilai_J3_F01) / 3
AVG_F02 = (Nilai_J1_F02 + Nilai_J2_F02 + Nilai_J3_F02) / 3
AVG_F03 = (Nilai_J1_F03 + Nilai_J2_F03 + Nilai_J3_F03) / 3
```

### Step 2: Pembobotan (Weighted Score)

Rata-rata dikalikan bobot kriteria dari database:

```
Weighted_A01 = AVG_A01 × 35/100
Weighted_A02 = AVG_A02 × 35/100
Weighted_A03 = AVG_A03 × 30/100
Weighted_F01 = AVG_F01 × 35/100
Weighted_F02 = AVG_F02 × 35/100
Weighted_F03 = AVG_F03 × 30/100
```

### Step 3: Konversi ke Skala 1-10

Weighted score (range 0-100) dikonversi ke skala 1-10:

| Rentang Weighted Score | Skala |
|----------------------|-------|
| ≤ 12 | 1 |
| ≤ 15 | 2 |
| ≤ 18 | 3 |
| ≤ 21 | 4 |
| ≤ 24 | 5 |
| ≤ 26 | 6 |
| ≤ 28 | 7 |
| ≤ 30 | 8 |
| ≤ 32 | 9 |
| > 32 | 10 |

### Step 4: GAP (Selisih)

GAP = **Skala - Target**

Target selalu **10** (nilai ideal maksimal).

```
GAP_A01 = Skala_A01 - 10
GAP_A02 = Skala_A02 - 10
GAP_A03 = Skala_A03 - 10
GAP_F01 = Skala_F01 - 10
GAP_F02 = Skala_F02 - 10
GAP_F03 = Skala_F03 - 10
```

Nilai GAP negatif (≤ 0) karena target = 10 adalah nilai maksimum.

### Step 5: Bobot GAP

Selisih GAP dikonversi ke bobot:

| GAP | Bobot GAP | Keterangan |
|-----|-----------|------------|
| 0 | 10 | Tidak ada selisih (sempurna) |
| -1 | 9 | Selisih sedikit |
| -2 | 8 | Selisih kecil |
| -3 | 7 | Selisih sedang |
| -4 | 6 | Selisih agak besar |
| -5 | 5 | Selisih besar |
| -6 | 4 | Selisih cukup besar |
| -7 | 3 | Selisih sangat besar |
| -8 | 2 | Selisih ekstrim |
| -9 atau kurang | 1 | Selisih maksimal |

Rumus: `Bobot GAP = MAX(1, 10 + GAP)`

---

## 3. Perhitungan NSF & NCF

### NSF (Nilai Secondary Factor) — Tahap Awal

Rata-rata Bobot GAP dari kriteria Tahap Awal:

```
NSF = (BobotGAP_A01 + BobotGAP_A02 + BobotGAP_A03) / 3
```

NSF merepresentasikan kemampuan akademik dan portofolio mahasiswa.

### NCF (Nilai Core Factor) — Tahap Final

Rata-rata Bobot GAP dari kriteria Tahap Final:

```
NCF = (BobotGAP_F01 + BobotGAP_F02 + BobotGAP_F03) / 3
```

NCF merepresentasikan kemampuan presentasi, komunikasi, dan wawancara.

---

## 4. Nilai Akhir (Profile Matching)

**Nilai Akhir** = **(0.7 × NCF) + (0.3 × NSF)**

Rasio 70:30 ini menekankan bahwa **Core Factor (Tahap Final)** memiliki pengaruh lebih besar dalam penentuan juara dibanding Secondary Factor (Tahap Awal).

---

## 5. Perangkingan

1. Semua mahasiswa diurutkan berdasarkan **Nilai Akhir** (tertinggi ke terendah)
2. Peringkat 1 → **Juara 1**
3. Peringkat 2 → **Juara 2**
4. Peringkat 3 → **Juara 3**
5. Peringkat 4+ → **Tidak Juara**

Perangkingan dilakukan **per jenjang** (Sarjana, Diploma, Khusus), sehingga setiap jenjang memiliki juara 1, 2, dan 3 sendiri.

---

## 6. Contoh Perhitungan

**Mahasiswa: Khoirul Faridz**

| Kode | Rata2 Juri | × Bobot | Weighted | Skala 1-10 | GAP | Bobot GAP |
|------|-----------|---------|----------|------------|-----|-----------|
| A01 | 74.00 | × 35% | 25.90 | 6 | -4 | 6 |
| A02 | 92.56 | × 35% | 32.40 | 10 | 0 | 10 |
| A03 | 17.80 | × 30% | 5.34 | 1 | -9 | 1 |
| F01 | 92.40 | × 35% | 32.34 | 10 | 0 | 10 |
| F02 | 90.95 | × 35% | 31.83 | 9 | -1 | 9 |
| F03 | 17.80 | × 30% | 5.34 | 1 | -9 | 1 |

```
NSF = (6 + 10 + 1) / 3 = 5.333
NCF = (10 + 9 + 1) / 3 = 6.333
Nilai Akhir = (0.7 × 6.333) + (0.3 × 5.333) = 4.433 + 1.600 = 6.033
```

---

## 7. Catatan Penting

1. **Nilai A01 (CU Berkas)** diisi otomatis oleh sistem dari rata-rata skor rekomendasi portofolio yang sudah divalidasi
2. **Nilai A03 (BI Video)** jika kosong, akan disamakan dengan **F03 (BI Lisan)** secara otomatis
3. Semua nilai input dari juri berada di rentang **0-100**
4. Target nilai untuk semua kriteria adalah **10** (skala 1-10)
5. Bobot kriteria dapat diubah melalui menu **Kriteria Penilaian** di sistem
6. Perubahan bobot akan langsung mempengaruhi hasil perhitungan GAP
