# Planning Board — SPK Pilmapres UM Metro

> **Papan progres resmi.** Diupdate Lead setiap ada perubahan status.  
> **Sumber kebenaran:** `Agentku.md` (detail keputusan). File ini hanya ringkasan status.  
> **Update terakhir:** 2026-06-19 — Lead (initial review)

---

## SPRINT AKTIF: Fase 1 — Security Hardening

### ✔️ DONE — Selesai & Diverifikasi Lead

| Item | Task | Ket |
|------|------|-----|
| 1.1 | Hapus `scratch_test.php` | 404 confirmed |
| 1.4 | Rate limit + sanitasi API | throttle:10,1 aktif, nama/prodi dihapus dari response |
| 1.5 | Rate limit login | `throttle:5,1`, 429 confirmed |
| 1.6 | DDL Migration + TipeFaktorSeeder | Migration jalan, seeder verified via HeidiSQL |
| 1.7 | FormRequest (7 class) + unique fix | KriteriaRequest unique rule sudah benar |
| 1.8 | XSS (semua 3 lokasi) | plain text + `{{ }}` di layout |
| 1.9 | Password rule lebih kuat | 2 controller, test pass |
| 1.10 | SESSION_SECURE_COOKIE | `false` di localhost, benar |

---

### ✔️ FASE 1 — SEMUA DONE

| Item | Task | Verifikasi |
|------|------|-----------|
| 1.2 | IDOR BerkasController | Tinker: user_id=7 → berkas_id=14 → abort_if TRUE → 403 ✅ |
| 1.3 | IDOR PenilaianController | Tinker: juri+pendaftaran exists()=false → 403 ✅ |
| 1.11 | Gate per Role | 13 test tinker+curl pass ✅ |

### 🔵 FASE 2 — AKTIF SEKARANG

Developer submit rencana detail Fase 2 (Multi-Jenjang) di LAPORAN DEVELOPER.
Lead akan review dan ACC per item sebelum eksekusi.

### 🚨 AKSI MENDESAK

| Aksi | Status |
|------|--------|
| Hapus password plaintext dari Agentku.md | ❌ Belum — developer wajib redact segera |
| Install Brave extension chrome-bridge | ⏳ Opsional |
| Set API key agentmemory | ⏳ Opsional |

---

### 🔧 AKSI INFRASTRUKTUR (MCP — Rekomendasi Lead)

| Tool | Status | Aksi |
|------|--------|------|
| `agentmemory` v0.9.27 | ⚠️ Installed tapi tidak terdaftar | `claude mcp add agentmemory -s user -- npx @agentmemory/agentmemory` |
| `mcp-chrome-bridge` v1.0.31 | ⚠️ Installed tapi tidak terdaftar | `claude mcp add chrome-bridge -s user -- npx mcp-chrome-stdio` + install extension di Brave |

---

### ⛔ ON HOLD — Belum Bisa Dimulai

| Fase | Alasan Hold |
|------|-------------|
| Fase 2 — Multi-Jenjang | Tunggu Fase 1 selesai. + Wajib jawab: bagaimana perlakuan mahasiswa existing (data lama) tanpa `jenjang_id`? |
| Fase 3 — Bobot Dinamis | Bergantung pada Fase 2 (jenjang harus ada dulu) |
| Fase 4 — Alur Bisnis | Tunggu Fase 1 & 2 selesai |
| Fase 5 — UI/UX Overhaul | Prioritas terakhir |

---

## PROGRESS TRACKER

```
Fase 1 Security:   [██████████] 11/11 DONE ✅ CLOSED
Fase 2 Jenjang:    [░░░░░░░░░░] DIBUKA — menunggu rencana developer
Fase 3 Perhitungan:[──────────] ON HOLD
Fase 4 Bisnis:     [──────────] ON HOLD
Fase 5 UI/UX:      [──────────] ON HOLD
```

---

## LOG PERUBAHAN STATUS

| Tanggal | Item | Dari | Ke | Lead/Dev | Catatan |
|---------|------|------|----|----------|---------|
| 2026-06-19 | Semua item Fase 1 | Draft | Review | Lead | Initial review selesai |
| 2026-06-19 | 1.1, 1.5, 1.9, 1.10, 1.11 | Review | ACC ✅ | Lead | Langsung bisa dikerjakan |
| 2026-06-19 | 1.2, 1.3, 1.4, 1.6, 1.7, 1.8 | Review | REVISI 🔄 | Lead | Butuh detail implementasi dari developer |
| 2026-06-19 | Fase 2–5 | Draft | ON HOLD ⛔ | Lead | Tunggu Fase 1 selesai |
| 2026-06-19 | 1.1, 1.5, 1.9, 1.10 | Eksekusi | ✔️ DONE | Lead | Verifikasi lengkap, selesai |
| 2026-06-19 | 1.2, 1.3, 1.4, 1.7, 1.8(#2,#3) | REVISI | 🏗️ IN PROGRESS | Lead | ACC, developer siap eksekusi |
| 2026-06-19 | 1.6(#4), 1.8(#1), 1.11 | — | 🔄 Konfirmasi | Lead | Tunggu keputusan/verifikasi developer |

---

## DEFINISI STATUS

| Status | Arti |
|--------|------|
| ⏳ Draft | Developer tulis rencana, belum di-review Lead |
| 🔄 REVISI | Lead minta clarifikasi/perbaikan rencana sebelum ACC |
| ⚠️ ACC Bersyarat | ACC setelah developer submit info yang diminta |
| ✅ ACC | Lead setuju, developer boleh eksekusi |
| 🏗️ In Progress | Developer sedang mengerjakan |
| 👀 In Review | Developer selesai, Lead sedang verifikasi |
| ✔️ Done | Lead verifikasi selesai, fitur/fix confirmed di browser |
| ❌ TOLAK | Tidak dikerjakan — lihat alasan di Agentku.md |
| ⛔ ON HOLD | Ditunda, ada prasyarat yang harus selesai dulu |

---

*Dikelola oleh: Lead / Project Manager*  
*Dibuat: 2026-06-19*
