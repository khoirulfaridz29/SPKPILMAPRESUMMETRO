CREATE DATABASE IF NOT EXISTS pilmapres;
USE pilmapres;

CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'wr3', 'juri', 'mahasiswa') NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `mahasiswa` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `nim` VARCHAR(50) NOT NULL,
  `program_studi` VARCHAR(255) NOT NULL,
  `ipk` DECIMAL(3,2) NULL,
  `pernah_pilmapres` ENUM('Belum Pernah', 'Lokal', 'Nasional') DEFAULT 'Belum Pernah',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_nim_unique` (`nim`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kriteria_penilaian` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_kriteria` VARCHAR(50) NOT NULL,
  `nama_kriteria` VARCHAR(255) NOT NULL,
  `jenis_faktor` ENUM('Tahap Awal', 'Tahap Final') NOT NULL,
  `nilai_target` INT NOT NULL,
  `bobot` DECIMAL(5,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pendaftaran` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` BIGINT UNSIGNED NOT NULL,
  `status_berkas` ENUM('Belum Lengkap', 'Lengkap') DEFAULT 'Belum Lengkap',
  `status_seleksi` ENUM('Proses', 'Lolos Tahap 1', 'Tidak Lolos', 'Selesai') DEFAULT 'Proses',
  `is_submitted` BOOLEAN DEFAULT FALSE,
  `tanggal_daftar` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `berkas_pendaftaran` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `nama_berkas` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `status_validasi` ENUM('Pending', 'Valid', 'Tidak Valid') DEFAULT 'Pending',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rekap_tahap_1` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `status_laporan` ENUM('Pending', 'Divalidasi') DEFAULT 'Pending',
  `divalidasi_oleh` BIGINT UNSIGNED NULL,
  `tanggal_validasi` DATETIME NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`divalidasi_oleh`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penugasan_juri` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `surat_penugasan` VARCHAR(255) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `kriteria_id` BIGINT UNSIGNED NOT NULL,
  `nilai_input` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `hasil_penilaian` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `skor_awal` DECIMAL(8,4) NULL,
  `skor_final` DECIMAL(8,4) NULL,
  `nilai_total` DECIMAL(8,4) NULL,
  `ranking` INT NULL,
  `status_juara` ENUM('Juara 1', 'Juara 2', 'Juara 3', 'Tidak Juara') NULL,
  `validasi_wr3` ENUM('Pending', 'Divalidasi') DEFAULT 'Pending',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jadwal` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kegiatan` VARCHAR(255) NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `keterangan` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pengumuman` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` VARCHAR(255) NOT NULL,
  `konten` TEXT NOT NULL,
  `file_path` VARCHAR(255) NULL,
  `tanggal_publish` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `persyaratan` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_syarat` VARCHAR(255) NOT NULL,
  `keterangan` TEXT NULL,
  `is_required` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `notifications` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `message` TEXT NOT NULL,
  `is_read` BOOLEAN DEFAULT FALSE,
  `type` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Dummy Users
-- Password default: 'password' (hash Bcrypt standar Laravel)
INSERT INTO `users` (`username`, `password`, `nama_lengkap`, `role`) VALUES
('admin', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Administrator Bid. Kemahasiswaan', 'admin'),
('wr3', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Bapak Wakil Rektor III', 'wr3'),
('juri1', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Juri I (Internal)', 'juri'),
('juri2', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Juri II (Akademisi)', 'juri'),
('juri3', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Juri III (Praktisi)', 'juri'),
('mahasiswa1', '$2y$10$857pa3XpZP31UFXhh0qYc.nYDLlJA5QZzcVx0bfBWdZCojJb0BFme', 'Budi Santoso', 'mahasiswa');

-- Insert Dummy Mahasiswa profile untuk user mahasiswa1 (ID 6)
INSERT INTO `mahasiswa` (`user_id`, `nim`, `program_studi`) VALUES
(6, '180210001', 'Pendidikan Teknologi Informasi');

-- Insert Dummy Kriteria (Sesuai Panduan PILMAPRES 2025/2026)
INSERT INTO `kriteria_penilaian` (`kode_kriteria`, `nama_kriteria`, `jenis_faktor`, `nilai_target`, `bobot`) VALUES
('A01', 'Capaian Unggulan (CU) Berkas', 'Tahap Awal', 10, 35),
('A02', 'Gagasan Kreatif (GK) Naskah', 'Tahap Awal', 10, 35),
('A03', 'Bahasa Inggris (BI) Video', 'Tahap Awal', 10, 30),
('F01', 'Capaian Unggulan (CU) Wawancara', 'Tahap Final', 10, 35),
('F02', 'Gagasan Kreatif (GK) Presentasi', 'Tahap Final', 10, 35),
('F03', 'Bahasa Inggris (BI) Lisan', 'Tahap Final', 10, 30);

-- Insert Dummy Jadwal
INSERT INTO `jadwal` (`kegiatan`, `tanggal_mulai`, `tanggal_selesai`, `keterangan`) VALUES
('Pendaftaran & Unggah Berkas', '2026-05-01', '2026-05-15', 'Mahasiswa mengunggah berkas persyaratan di website.'),
('Validasi Berkas (Admin)', '2026-05-16', '2026-05-18', 'Pemeriksaan kelengkapan dokumen oleh Bidang Kemahasiswaan.'),
('Pengumuman Lolos Tahap I', '2026-05-20', '2026-05-20', 'Pengumuman peserta yang berhak lanjut ke tahap penilaian juri.'),
('Penilaian Juri (Wawancara & Presentasi)', '2026-05-22', '2026-05-25', 'Peserta mempresentasikan Gagasan Kreatif di depan dewan juri.');

-- Insert Dummy Pengumuman
INSERT INTO `pengumuman` (`judul`, `konten`, `tanggal_publish`) VALUES
('Pendaftaran PILMAPRES 2026 Resmi Dibuka', '<p>Halo Mahasiswa UM Metro! Seleksi Mahasiswa Berprestasi (PILMAPRES) tingkat Universitas tahun 2026 telah resmi dibuka. Silakan daftar segera!</p>', '2026-05-01'),
('Panduan Penulisan Gagasan Kreatif', '<p>Bagi peserta yang telah mendaftar, silakan unduh panduan penulisan Gagasan Kreatif (GK) pada menu Informasi.</p>', '2026-05-05');

-- Insert Dummy Persyaratan
INSERT INTO `persyaratan` (`nama_syarat`, `keterangan`, `is_required`) VALUES
('KTM (Kartu Tanda Mahasiswa)', 'Scan KTM asli berwarna.', 1),
('Sertifikat Prestasi (Unggulan)', 'Gabungkan maksimal 10 sertifikat terbaik dalam 1 file PDF.', 1),
('Naskah Gagasan Kreatif', 'Format PDF sesuai template yang disediakan.', 1),
('Surat Rekomendasi Dekan', 'Surat pernyataan dari pimpinan fakultas.', 0);

CREATE TABLE `rubrik_capaian_unggulans` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bidang` VARCHAR(255) NOT NULL,
  `wujud_capaian_unggulan` VARCHAR(255) NOT NULL,
  `kode_internasional` VARCHAR(50) NULL,
  `skor_internasional` VARCHAR(50) NULL,
  `kode_regional` VARCHAR(50) NULL,
  `skor_regional` VARCHAR(50) NULL,
  `kode_nasional` VARCHAR(50) NULL,
  `skor_nasional` VARCHAR(50) NULL,
  `kode_provinsi` VARCHAR(50) NULL,
  `skor_provinsi` VARCHAR(50) NULL,
  `kode_kab_kota` VARCHAR(50) NULL,
  `skor_kab_kota` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rubrik_capaian_unggulans` (`bidang`, `wujud_capaian_unggulan`, `kode_internasional`, `skor_internasional`, `kode_regional`, `skor_regional`, `kode_nasional`, `skor_nasional`, `kode_provinsi`, `skor_provinsi`, `kode_kab_kota`, `skor_kab_kota`) VALUES
('Kompetisi', 'Juara-1 Perorangan', '1A1', '40-50', '1B1', '30-40', '1C1', '20-30', '1D1', '20', NULL, NULL),
('Kompetisi', 'Juara-2 Perorangan', '1A2', '35-45', '1B2', '25-35', '1C2', '15-25', '1D2', '15', NULL, NULL),
('Kompetisi', 'Juara-3 Perorangan', '1A3', '30-40', '1B3', '20-30', '1C3', '10-20', '1D3', '10', NULL, NULL),
('Kompetisi', 'Juara Kategori Perorangan', '1A4', '24-32', '1B4', '16-24', '1C4', '8-16', '1D4', '8', NULL, NULL),
('Kompetisi', 'Juara-1 Beregu', '1A5', '30-40', '1B5', '20-30', '1C5', '10-20', '1D5', '10', NULL, NULL),
('Kompetisi', 'Juara-2 Beregu', '1A6', '25-35', '1B6', '15-25', '1C6', '7-15', '1D6', '7', NULL, NULL),
('Kompetisi', 'Juara-3 Beregu', '1A7', '20-30', '1B7', '10-20', '1C7', '6-10', '1D7', '6', NULL, NULL),
('Kompetisi', 'Juara Kategori Beregu', '1A8', '16-24', '1B8', '10-16', '1C8', '5-10', '1D8', '5', NULL, NULL),
('Pengakuan', 'Pelatih/Wasit/Juri berlisensi', '2A1', '50', '2B1', '40', '2C1', '30', '2D1', '20', NULL, NULL),
('Pengakuan', 'Pelatih/Wasit/Juri tidak berlisensi', '2A2', '25', '2B2', '20', '2C2', '15', '2D2', '10', NULL, NULL),
('Pengakuan', 'Narasumber / pembicara', '2A4', '25', '2B4', '20', '2C4', '15', '2D4', '10', NULL, NULL),
('Pengakuan', 'Moderator', '2A5', '20', '2B5', '15', '2C5', '10', '2D5', '5', NULL, NULL),
('Pengakuan', 'Lainnya', '2A6', '20', '2B6', '15', '2C6', '10', '2D6', '5', NULL, NULL),
('Penghargaan', 'Tanda Jasa', '3A1', '50', '3B1', '40', '3C1', '30', '3D1', '20', NULL, NULL),
('Penghargaan', 'Penerima Hibah kompetisi', '3A6', '40', '3B6', '30', '3C6', '20', '3D6', '10', NULL, NULL),
('Penghargaan', '(grand final, peraih medali emas berdasar nilai batas)', '3A2', '30', '3B2', '20', '3C2', '10', '3D2', '5', NULL, NULL),
('Penghargaan', '(grand final, peraih medali perak berdasar nilai batas)', '3A3', '25', '3B3', '15', '3C3', '7', '3D3', '3', NULL, NULL),
('Penghargaan', '(grand final, peraih medali perunggu berdasar nilai batas)', '3A4', '20', '3B4', '10', '3C4', '5', '3D4', '2', NULL, NULL),
('Penghargaan', 'Piagam Partisipasi', '3A5', '10', '3B5', '5', '3C5', '3', '3D5', '1', NULL, NULL),
('Penghargaan', 'Lainnya', '3A7', '10', '3B7', '5', '3C7', '3', '3D7', '1', NULL, NULL),
('Karir Organisasi', 'Ketua', '4A1', '50', '4B1', '40', '4C1', '30', '4D1', '20', '4E1', '10'),
('Karir Organisasi', 'Wakil Ketua', '4A2', '45', '4B2', '35', '4C2', '25', '4D2', '15', '4E2', '8'),
('Karir Organisasi', 'Sekretaris', '4A3', '40', '4B3', '30', '4C3', '20', '4D3', '10', '4E3', '6'),
('Karir Organisasi', 'Bendahara', '4A4', '40', '4B4', '30', '4C4', '20', '4D4', '10', '4E4', '6'),
('Hasil Karya', 'Patent', NULL, NULL, NULL, NULL, '5C1', '40-50*', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Patent Sederhana', NULL, NULL, NULL, NULL, '5C2', '10-30*', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Hak Cipta', NULL, NULL, NULL, NULL, '5C3', '10-30*', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Buku ber-ISBN penulis utama', NULL, NULL, NULL, NULL, '5C4', '30', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Buku ber-ISBN penulis kedua dst', NULL, NULL, NULL, NULL, '5C5', '20/x', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Penulis Utama/korespondensi karya ilmiah di journal yg bereputasi dan diakui', '5A6', '30-40*', NULL, NULL, '5C6', '10-30*', NULL, NULL, NULL, NULL),
('Hasil Karya', 'Penulis kedua (bukan korespondensi) dst karya ilmiah di journal yg bereputasi dan diakui', '5A7', '30-40* / X', NULL, NULL, '5C7', '10-20* / X', NULL, NULL, NULL, NULL),
('Pemberdayaan atau Aksi Kemanusiaan', 'Pemrakarsa / Pendiri', '6A1', '50', '6B1', '40', '6C1', '30', '6D1', '20', '6E1', '10'),
('Pemberdayaan atau Aksi Kemanusiaan', 'Koordinator Relawan', '6A2', '35', '6B2', '25', '6C2', '15', '6D2', '10', '6E2', '5'),
('Pemberdayaan atau Aksi Kemanusiaan', 'Relawan', '6A3', '25', '6B3', '15', '6C3', '10', '6D3', '5', '6E3', '3'),
('Kewirausahaan', 'Kewirausahaan', '7A1', '50', '7B1', '40', '7C1', '30', '7D1', '20', '7E1', '10');

CREATE TABLE `rubrik_naskah_gks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `aspek_penilaian` VARCHAR(255) NOT NULL,
  `kriteria_penilaian` VARCHAR(255) NOT NULL,
  `bobot` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rubrik_naskah_gks` (`aspek_penilaian`, `kriteria_penilaian`, `bobot`) VALUES
('Penyajian Gagasan Kreatif', 'Penggunaan bahasa Indonesia yang baik dan benar', 5),
('Penyajian Gagasan Kreatif', 'Kesesuaian pengutipan dan pengacuan dengan kaidah/standar yang berlaku', 5),
('Substansi Gagasan Kreatif', 'Fakta atau gejala dalam lingkungan yang menarik untuk dikaji', 8),
('Substansi Gagasan Kreatif', 'Identifikasi masalah yang terdapat dalam fakta/gejala dalam lingkungan', 8),
('Substansi Gagasan Kreatif', 'Rumusan masalah sebagai hasil identifikasi masalah', 10),
('Substansi Gagasan Kreatif', 'Uraian mengenai akibat pembiaran yang merugikan lingkungan', 8),
('Substansi Gagasan Kreatif', 'Uraian mengenai solusi yang berciri SMART', 15),
('Substansi Gagasan Kreatif', 'Uraian mengenai dampak lanjutan (efek bola salju) dari pencapaian solusi', 8),
('Substansi Gagasan Kreatif', 'Rincian uraian mengenai langkah-langkah tindakan untuk mencapai solusi', 8),
('Substansi Gagasan Kreatif', 'Uraian mengenai kendala/hambatan pelaksanaan gagasan dan antisipasinya', 5),
('Kualitas Gagasan Kreatif', 'Keunikan dan Orisinalitas Gagasan Kreatif', 10),
('Kualitas Gagasan Kreatif', 'Keterlaksanaan Gagasan Kreatif', 10);

CREATE TABLE `rubrik_presentasi_gks` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `aspek_penilaian` VARCHAR(255) NOT NULL,
  `kriteria_penilaian` VARCHAR(255) NOT NULL,
  `bobot` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rubrik_presentasi_gks` (`aspek_penilaian`, `kriteria_penilaian`, `bobot`) VALUES
('Presentasi Gagasan Kreatif', 'Poster', 15),
('Presentasi Gagasan Kreatif', 'Sistematika Penjelasan', 15),
('Presentasi Gagasan Kreatif', 'Cara menjelaskan', 15),
('Presentasi Gagasan Kreatif', 'Ketepatan Waktu', 5),
('Tanya Jawab', 'Ketepatan Jawaban', 30),
('Tanya Jawab', 'Cara Menjawab', 20);

CREATE TABLE `rubrik_bahasa_inggris` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `field` VARCHAR(255) NOT NULL,
  `excellent_score` VARCHAR(50) NOT NULL,
  `excellent_criteria` TEXT NOT NULL,
  `good_score` VARCHAR(50) NOT NULL,
  `good_criteria` TEXT NOT NULL,
  `fair_score` VARCHAR(50) NOT NULL,
  `fair_criteria` TEXT NOT NULL,
  `poor_score` VARCHAR(50) NOT NULL,
  `poor_criteria` TEXT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rubrik_bahasa_inggris` (`field`, `excellent_score`, `excellent_criteria`, `good_score`, `good_criteria`, `fair_score`, `fair_criteria`, `poor_score`, `poor_criteria`) VALUES
('CONTENT', '25-22', 'Demonstration of excellent mastery of the topic and comprehensive elaboration - demonstrate comprehensive thorough analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.', '21-18', 'Demonstration of good mastery of the topic and give most supportive details- demonstrate limited analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.', '17-11', 'Demonstration of fair mastery of the topic with some missing supportive details- demonstrate limited analysis of the problem(s)', '10-5', 'Demonstration of inadequate mastery of the topic with only few important details given.'),
('ACCURACY', '25-22', 'Excellent mastery of grammar and vocabulary with all appropriate choice of expressions/ register', '21-18', 'Good mastery of grammar and vocabulary with mostly appropriate choice of expressions/ register', '17-11', 'Fair mastery of grammar and vocabulary, with occasional inappropriate choice of expressions/ register.', '10-5', 'Inadequate mastery of grammar and vocabulary, with frequent inappropriate choice of expressions/ register.'),
('FLUENCY & PRONUNCIATION', '20-16', 'Speech is very fluent, no unnatural pauses; with always intelligible and clear pronunciation as well as excellent rhythm and stress pattern', '15-11', 'Speech is mostly fluent, a few unnatural pauses; with mostly intelligible and clear pronunciation as well as good rhythm and stress pattern', '10-8', 'Speech is frequently halted; frequent unnatural pauses, with fairly intelligible and clear pronunciation but with some incorrect rhythm and stress pattern', '7-5', 'Speech is jerky with poor and unclear pronunciation and incorrect rhythm and stress pattern'),
('COMPREHENSION & RESPONSE', '20-16', 'Excellent ability to comprehend the topic discussed and to answer all the questions raised', '15-11', 'Good ability to comprehend the topic discussed and answer most of the questions raised', '10-8', 'Fair ability to comprehend the topic discussed and to answer some of the questions raised', '7-5', 'Poor ability to comprehend the topic discussed and to answer few of the questions raised'),
('OVERALL PERFORMANCE', '10-9', 'Very clear delivery of ideas; very active contributions to discussion; high respect and interest for others'' viewpoints', '8-7', 'Clear delivery of ideas; active contributions to discussion; respect and interest for others'' viewpoints', '6-5', 'Fairly clear delivery of ideas, some contributions to discussion, little respect/interest for others'' viewpoints', '4-3', 'Unclear delivery of ideas, little contribution to discussion, some evidence of disrespect/disinterest for others'' viewpoint');

CREATE TABLE `portofolio_cu` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `rubrik_cu_id` BIGINT UNSIGNED NOT NULL,
  `kategori_jenjang` VARCHAR(50) NOT NULL,
  `nama_prestasi` VARCHAR(255) NOT NULL,
  `tempat` VARCHAR(255) NOT NULL,
  `tanggal_pelaksanaan` DATE NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `status_validasi` ENUM('Pending', 'Valid', 'Tidak Valid') DEFAULT 'Pending',
  `skor_rekomendasi` DECIMAL(8,2) NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`rubrik_cu_id`) REFERENCES `rubrik_capaian_unggulans`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `indikator_penilaians` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kriteria_id` BIGINT UNSIGNED NOT NULL,
  `nama_indikator` VARCHAR(255) NOT NULL,
  `deskripsi` TEXT NULL,
  `bobot` DECIMAL(5,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_naskah_gk` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `rubrik_naskah_gk_id` BIGINT UNSIGNED NOT NULL,
  `nilai_input` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`rubrik_naskah_gk_id`) REFERENCES `rubrik_naskah_gks`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_presentasi_gk` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `rubrik_presentasi_gk_id` BIGINT UNSIGNED NOT NULL,
  `nilai_input` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`rubrik_presentasi_gk_id`) REFERENCES `rubrik_presentasi_gks`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `penilaian_bahasa_inggris` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `rubrik_bahasa_inggris_id` BIGINT UNSIGNED NOT NULL,
  `nilai_input` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`rubrik_bahasa_inggris_id`) REFERENCES `rubrik_bahasa_inggris`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rubrik_wawancara_cu` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kriteria_penilaian` VARCHAR(255) NOT NULL,
  `bobot` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rubrik_wawancara_cu` (`kriteria_penilaian`, `bobot`) VALUES
('Kemampuan Komunikasi & Presentasi', 30),
('Penguasaan Materi & Substansi Capaian', 40),
('Sikap, Kepribadian & Integritas', 30);

CREATE TABLE `penilaian_wawancara_cu` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `juri_id` BIGINT UNSIGNED NOT NULL,
  `pendaftaran_id` BIGINT UNSIGNED NOT NULL,
  `rubrik_wawancara_cu_id` BIGINT UNSIGNED NOT NULL,
  `nilai_input` INT NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`juri_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`rubrik_wawancara_cu_id`) REFERENCES `rubrik_wawancara_cu`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- ====== MIGRATION UPDATES (added by deploy_update.sql) ======

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
