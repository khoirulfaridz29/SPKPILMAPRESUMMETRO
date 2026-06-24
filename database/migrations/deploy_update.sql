-- ==============================================================
-- DEPLOYED DATABASE UPDATE SQL
-- Generated from migration files that were not applied on deploy
-- Run this on the deployed database to update the schema
-- ==============================================================

-- 1. CREATE JENJANG TABLE
CREATE TABLE IF NOT EXISTS `jenjang` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_jenjang` VARCHAR(20) NOT NULL,
  `nama_jenjang` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenjang_kode_jenjang_unique` (`kode_jenjang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed jenjang data
INSERT INTO `jenjang` (`id`, `kode_jenjang`, `nama_jenjang`, `deskripsi`) VALUES
(1, 'S1', 'Sarjana', 'Program Sarjana S1'),
(2, 'D3', 'Diploma', 'Program Diploma D3');

-- 2. ADD jenjang_id TO mahasiswa
ALTER TABLE `mahasiswa`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `user_id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE RESTRICT;

UPDATE `mahasiswa` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;

ALTER TABLE `mahasiswa`
  MODIFY `jenjang_id` BIGINT UNSIGNED NOT NULL;

-- 3. ADD jenjang_id TO kriteria_penilaian
ALTER TABLE `kriteria_penilaian`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE RESTRICT;

UPDATE `kriteria_penilaian` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;

ALTER TABLE `kriteria_penilaian`
  MODIFY `jenjang_id` BIGINT UNSIGNED NOT NULL;

-- 4. ADD tipe_faktor TO kriteria_penilaian
ALTER TABLE `kriteria_penilaian`
  ADD COLUMN `tipe_faktor` ENUM('Core Factor', 'Secondary Factor') DEFAULT 'Core Factor' AFTER `bobot`;

-- 5. ADD nilai_sementara TO hasil_penilaian
ALTER TABLE `hasil_penilaian`
  ADD COLUMN `nilai_sementara` DECIMAL(8,4) NULL AFTER `nilai_total`;

-- 6. ADD jenjang_id TO rubrik & related tables
ALTER TABLE `rubrik_naskah_gks`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `rubrik_presentasi_gks`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `rubrik_wawancara_cu`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `rubrik_bahasa_inggris`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `rubrik_capaian_unggulans`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `persyaratan`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `jadwal`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

ALTER TABLE `indikator_penilaians`
  ADD COLUMN `jenjang_id` BIGINT UNSIGNED NULL AFTER `id`,
  ADD FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang`(`id`) ON DELETE SET NULL;

-- Backfill jenjang_id = 1 for existing rubrik data
UPDATE `rubrik_naskah_gks` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `rubrik_presentasi_gks` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `rubrik_bahasa_inggris` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `rubrik_wawancara_cu` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `rubrik_capaian_unggulans` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `persyaratan` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `jadwal` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;
UPDATE `indikator_penilaians` SET `jenjang_id` = 1 WHERE `jenjang_id` IS NULL;

-- 7. ADD label TO rubrik tables
ALTER TABLE `rubrik_naskah_gks`
  ADD COLUMN `label` VARCHAR(255) NULL AFTER `jenjang_id`;
ALTER TABLE `rubrik_presentasi_gks`
  ADD COLUMN `label` VARCHAR(255) NULL AFTER `jenjang_id`;
ALTER TABLE `rubrik_bahasa_inggris`
  ADD COLUMN `label` VARCHAR(255) NULL AFTER `jenjang_id`;
ALTER TABLE `rubrik_wawancara_cu`
  ADD COLUMN `label` VARCHAR(255) NULL AFTER `jenjang_id`;

UPDATE `rubrik_naskah_gks` SET `label` = 'Naskah GK' WHERE `jenjang_id` = 1 AND `label` IS NULL;
UPDATE `rubrik_naskah_gks` SET `label` = 'Produk Inovatif (PI)' WHERE `jenjang_id` = 2 AND `label` IS NULL;
UPDATE `rubrik_presentasi_gks` SET `label` = 'Presentasi GK' WHERE `jenjang_id` = 1 AND `label` IS NULL;
UPDATE `rubrik_presentasi_gks` SET `label` = 'Presentasi PI' WHERE `jenjang_id` = 2 AND `label` IS NULL;
UPDATE `rubrik_bahasa_inggris` SET `label` = 'Bahasa Inggris' WHERE `label` IS NULL;
UPDATE `rubrik_wawancara_cu` SET `label` = 'Wawancara CU' WHERE `label` IS NULL;

-- 8. ADD nidn TO users
ALTER TABLE `users`
  ADD COLUMN `nidn` VARCHAR(30) NULL AFTER `nama_lengkap`;

-- 9. CREATE panduan TABLE
CREATE TABLE IF NOT EXISTS `panduan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. CREATE program_studi TABLE
CREATE TABLE IF NOT EXISTS `program_studi` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(2) NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `program_studi_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. FIX portofolio_cu.skor_rekomendasi to VARCHAR
ALTER TABLE `portofolio_cu`
  MODIFY `skor_rekomendasi` VARCHAR(50) NULL;

-- 12. FIX penilaian.nilai_input to DECIMAL(8,4)
ALTER TABLE `penilaian`
  MODIFY `nilai_input` DECIMAL(8,4) NOT NULL;

-- 13. CREATE notifications table
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` CHAR(36) NOT NULL,
  `type` VARCHAR(255) NOT NULL,
  `notifiable_type` VARCHAR(255) NOT NULL,
  `notifiable_id` BIGINT UNSIGNED NOT NULL,
  `data` TEXT NOT NULL,
  `read_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`, `notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. CREATE activity_log tables
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `log_name` VARCHAR(255) NULL,
  `description` TEXT NOT NULL,
  `subject_type` VARCHAR(255) NULL,
  `event` VARCHAR(255) NULL,
  `subject_id` BIGINT UNSIGNED NULL,
  `causer_type` VARCHAR(255) NULL,
  `causer_id` BIGINT UNSIGNED NULL,
  `properties` JSON NULL,
  `batch_uuid` CHAR(36) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_log_log_name_index` (`log_name`),
  KEY `subject` (`subject_type`, `subject_id`),
  KEY `causer` (`causer_type`, `causer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
