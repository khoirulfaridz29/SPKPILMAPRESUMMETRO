mysqldump: [Warning] Using a password on the command line interface can be insecure.
-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: pilmapres
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject_type`,`subject_id`),
  KEY `causer` (`causer_type`,`causer_id`),
  KEY `activity_log_log_name_index` (`log_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_log`
--

LOCK TABLES `activity_log` WRITE;
/*!40000 ALTER TABLE `activity_log` DISABLE KEYS */;
INSERT INTO `activity_log` VALUES (2,'default','Menghapus akun mahasiswa: AULIA AZZAHRA  PUTRI',NULL,'deleted',NULL,'App\\Models\\User',1,'{\"deleted_role\": \"mahasiswa\", \"deleted_username\": \"AULIA AZZAHRA PUTRI\"}',NULL,'2026-06-24 04:40:20','2026-06-24 04:40:20'),(3,'default','Menghapus akun mahasiswa: FUADIL ROZAQ',NULL,'deleted',NULL,'App\\Models\\User',1,'{\"deleted_role\": \"mahasiswa\", \"deleted_username\": \"FUADIL ROZAQ\"}',NULL,'2026-06-24 05:05:43','2026-06-24 05:05:43'),(4,'default','Menjalankan perhitungan GAP: 20 peserta, 2 jenjang',NULL,'updated',NULL,'App\\Models\\User',1,'{\"total_jenjang\": 2, \"total_peserta\": 20, \"filter_jenjang_id\": null}',NULL,'2026-06-24 05:12:37','2026-06-24 05:12:37');
/*!40000 ALTER TABLE `activity_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `berkas_pendaftaran`
--

DROP TABLE IF EXISTS `berkas_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `berkas_pendaftaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `nama_berkas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_validasi` enum('Pending','Valid','Tidak Valid') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  CONSTRAINT `berkas_pendaftaran_ibfk_1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `berkas_pendaftaran`
--

LOCK TABLES `berkas_pendaftaran` WRITE;
/*!40000 ALTER TABLE `berkas_pendaftaran` DISABLE KEYS */;
INSERT INTO `berkas_pendaftaran` VALUES (8,2,'KTP','berkas/2/c44mXU6ar711Ec59TufEASatxcE63yeHLvccwDTM.jpg','Valid','2026-05-30 01:09:39','2026-06-03 06:19:43'),(9,2,'KTM','berkas/2/KO1d9dAQ16hU9PtseHxIwi7Gr4SveBCOWsh5TKY8.png','Valid','2026-05-30 01:10:36','2026-06-03 06:19:45'),(10,2,'Transkrip Nilai','berkas/2/Gwt4qdRMbYwyMVV0d5AQuTPw8EBvRddoiZFg0BNc.pdf','Valid','2026-05-30 01:13:27','2026-06-03 06:19:46'),(11,2,'Surat Pengantar Fakultas','berkas/2/Rj5NAHTCUYt5hQdCRr9NJPtaX8oB9ilPNe36vqQt.pdf','Valid','2026-05-30 01:15:21','2026-06-03 06:19:47'),(12,2,'Naskah Gagasan Kreatif','berkas/2/XLeZPndiX32eaWd9t4hKXrtjoIgpjRO3p6343haW.pdf','Valid','2026-05-30 01:31:30','2026-06-03 06:19:48'),(13,2,'Video Bahasa Inggris','berkas/2/kuhwgz9tm34PXKzYooDYHVwG0NePkqFCfjlJ9jsS.mp4','Valid','2026-05-30 01:31:44','2026-06-03 06:19:51'),(14,3,'KTP','berkas/3/VQpeiwc2qlMqZm6CmK13jM3dMkk87Ay8FoV1atcd.jpg','Valid','2026-06-03 05:49:44','2026-06-03 06:20:33'),(15,3,'KTM','berkas/3/VUojMmc5TP8LSqDV4PHSqdDkmultKQ4xx7nBs8RI.png','Valid','2026-06-03 05:51:41','2026-06-03 06:20:34'),(16,3,'Transkrip Nilai','berkas/3/rQI0B9o5SdG9aWU8OFY2KODyqpMLFQ0papgchVzJ.pdf','Valid','2026-06-03 05:52:09','2026-06-03 06:20:35'),(17,3,'Surat Pengantar Fakultas','berkas/3/28LcBOxtUDaYWxmpabplyJURSyWDSbjeMf6sXP9S.pdf','Valid','2026-06-03 05:52:26','2026-06-03 06:20:36'),(18,3,'Naskah Gagasan Kreatif','berkas/3/jZPAuhzGJSKdaXhs2Dlu47LPeNKNUBADxJTIpmXu.pdf','Valid','2026-06-03 05:55:44','2026-06-03 06:20:37'),(19,3,'Video Bahasa Inggris','berkas/3/fszYjbqZIHHtaLubSZ0MxnwMnTxlyIYl5hAHkfg2.mp4','Valid','2026-06-03 05:56:01','2026-06-03 06:20:38'),(20,4,'KTP','berkas/4/sFMc3ehTdLSZI2GvWxxNRqQzCuleG1APcxeZwmZ3.jpg','Valid','2026-06-03 06:04:56','2026-06-03 06:21:16'),(21,4,'KTM','berkas/4/0ToxTIggzENlGegJS7CH9KyaQEOcUu00SfyXK4oK.png','Valid','2026-06-03 06:05:49','2026-06-03 06:21:18'),(22,4,'Transkrip Nilai','berkas/4/ZwJwpxtJd067kAhAv22ppgLM03FKvPqw5yZOcVl5.pdf','Valid','2026-06-03 06:06:06','2026-06-03 06:21:19'),(23,4,'Surat Pengantar Fakultas','berkas/4/wTMpT8eqho7ISdaj7zWn1w2c1p3YRYwSugAOaKUT.pdf','Valid','2026-06-03 06:06:26','2026-06-03 06:21:20'),(24,4,'Naskah Gagasan Kreatif','berkas/4/wYXq25mM85N3tvWLxJM4irn3JbXos69kBFyEfZa1.pdf','Valid','2026-06-03 06:09:16','2026-06-03 06:21:22'),(25,4,'Video Bahasa Inggris','berkas/4/JEmcehqQEhpEySfg0wkqOCcJeA5ue5Riu3kJsIEE.mp4','Valid','2026-06-03 06:09:29','2026-06-03 06:21:23');
/*!40000 ALTER TABLE `berkas_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil_penilaian`
--

DROP TABLE IF EXISTS `hasil_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hasil_penilaian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `skor_awal` decimal(8,4) DEFAULT NULL,
  `skor_final` decimal(8,4) DEFAULT NULL,
  `nilai_total` decimal(8,4) DEFAULT NULL,
  `ranking` int DEFAULT NULL,
  `status_juara` enum('Juara 1','Juara 2','Juara 3','Tidak Juara') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validasi_wr3` enum('Pending','Divalidasi') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nilai_sementara` decimal(8,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  CONSTRAINT `hasil_penilaian_ibfk_1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil_penilaian`
--

LOCK TABLES `hasil_penilaian` WRITE;
/*!40000 ALTER TABLE `hasil_penilaian` DISABLE KEYS */;
INSERT INTO `hasil_penilaian` VALUES (1,2,7.3333,7.3333,7.3333,3,'Juara 3','Pending','2026-06-24 05:12:36','2026-06-24 05:12:37',81.7585),(2,3,5.6667,6.3333,6.1333,10,'Tidak Juara','Pending','2026-06-24 05:12:36','2026-06-24 05:12:37',76.4171),(3,4,6.0000,6.6667,6.4667,7,'Tidak Juara','Pending','2026-06-24 05:12:36','2026-06-24 05:12:37',77.1000),(4,7,4.3333,7.0000,6.2000,10,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',70.4088),(5,8,4.6667,7.6667,6.7667,4,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',72.6332),(6,9,4.6667,7.6667,6.7667,5,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',71.5821),(7,10,4.3333,7.3333,6.4333,8,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',70.9037),(8,11,4.3333,7.3333,6.4333,9,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',71.8649),(9,12,6.6667,6.3333,6.4333,8,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',79.4500),(10,13,6.3333,7.3333,7.0333,5,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',80.0147),(11,14,8.3333,7.3333,7.6333,1,'Juara 1','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',84.3272),(12,15,6.3333,7.0000,6.8000,6,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',77.8707),(13,16,6.0000,8.0000,7.4000,2,'Juara 2','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',82.4053),(14,17,5.6667,7.6667,7.0667,4,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',80.8653),(15,18,7.0000,6.0000,6.3000,9,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',77.4722),(16,19,7.6667,8.0000,7.9000,1,'Juara 1','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',88.6033),(17,20,7.6667,7.3333,7.4333,2,'Juara 2','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',81.1033),(18,21,7.6667,7.0000,7.2000,3,'Juara 3','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',79.4393),(19,22,7.0000,6.3333,6.5333,6,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',74.8520),(20,23,7.0000,6.3333,6.5333,7,'Tidak Juara','Pending','2026-06-24 05:12:37','2026-06-24 05:12:37',75.0453);
/*!40000 ALTER TABLE `hasil_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indikator_penilaians`
--

DROP TABLE IF EXISTS `indikator_penilaians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `indikator_penilaians` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned DEFAULT NULL,
  `kriteria_id` bigint unsigned NOT NULL,
  `nama_indikator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `bobot` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `kriteria_id` (`kriteria_id`),
  KEY `indikator_penilaians_jenjang_id_foreign` (`jenjang_id`),
  CONSTRAINT `indikator_penilaians_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE CASCADE,
  CONSTRAINT `indikator_penilaians_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indikator_penilaians`
--

LOCK TABLES `indikator_penilaians` WRITE;
/*!40000 ALTER TABLE `indikator_penilaians` DISABLE KEYS */;
/*!40000 ALTER TABLE `indikator_penilaians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned DEFAULT NULL,
  `kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `jadwal_jenjang_id_foreign` (`jenjang_id`),
  CONSTRAINT `jadwal_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (1,NULL,'Pendaftaran & Unggah Berkas','2026-05-01','2026-06-21','Mahasiswa mengunggah berkas persyaratan di website.','2026-05-26 08:46:50','2026-06-19 21:06:53'),(2,NULL,'Validasi Berkas (Admin)','2026-06-07','2026-06-13','Pemeriksaan kelengkapan dokumen oleh Bidang Kemahasiswaan.','2026-05-26 08:46:50','2026-05-30 01:04:53'),(3,NULL,'Pengumuman Lolos Tahap I','2026-06-07','2026-06-13','Pengumuman peserta yang berhak lanjut ke tahap penilaian juri.','2026-05-26 08:46:50','2026-05-30 01:07:36'),(4,NULL,'Penilaian Juri (Wawancara & Presentasi)','2026-06-06','2026-06-06','Peserta mempresentasikan Gagasan Kreatif di depan dewan juri.','2026-05-26 08:46:50','2026-05-30 01:08:02'),(5,2,'Pendaftaran D3 PILMAPRES 2026','2026-05-22','2026-07-22','Pendaftaran untuk mahasiswa Diploma (D3)','2026-06-22 08:02:17','2026-06-22 08:02:17');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jenjang`
--

DROP TABLE IF EXISTS `jenjang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenjang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode_jenjang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jenjang` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jenjang_kode_jenjang_unique` (`kode_jenjang`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jenjang`
--

LOCK TABLES `jenjang` WRITE;
/*!40000 ALTER TABLE `jenjang` DISABLE KEYS */;
INSERT INTO `jenjang` VALUES (1,'S1','Sarjana','Program Sarjana (S1) - Bobot: CU 35%, GK 35%, BI 30%','2026-06-19 09:41:26','2026-06-19 09:41:26'),(2,'D3','Diploma','Program Diploma (D3/D4) - Bobot: CU 35%, GK 35%, BI 30%','2026-06-19 09:41:26','2026-06-19 09:41:26'),(7,'K1','Khusus - Disabiltas','Program Khusus - Disabilitas - Bobot: CU 35%, GK 35%, BI 30%','2026-07-01 15:31:00','2026-07-01 15:31:00');
/*!40000 ALTER TABLE `jenjang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria_penilaian`
--

DROP TABLE IF EXISTS `kriteria_penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kriteria_penilaian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL,
  `kode_kriteria` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kriteria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_faktor` enum('Tahap Awal','Tahap Final') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai_target` int NOT NULL,
  `bobot` decimal(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tipe_faktor` enum('Core Factor','Secondary Factor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Core Factor',
  PRIMARY KEY (`id`),
  KEY `kriteria_penilaian_jenjang_id_foreign` (`jenjang_id`),
  CONSTRAINT `kriteria_penilaian_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria_penilaian`
--

LOCK TABLES `kriteria_penilaian` WRITE;
/*!40000 ALTER TABLE `kriteria_penilaian` DISABLE KEYS */;
INSERT INTO `kriteria_penilaian` VALUES (1,1,'A01','Capaian Unggulan (CU) Berkas','Tahap Awal',10,35.00,'2026-05-26 08:46:50','2026-07-01 17:29:10','Secondary Factor'),(2,1,'A02','Gagasan Kreatif (GK) Naskah','Tahap Awal',10,35.00,'2026-05-26 08:46:50','2026-07-01 17:29:10','Secondary Factor'),(3,1,'A03','Bahasa Inggris (BI) Video','Tahap Awal',10,30.00,'2026-05-26 08:46:50','2026-07-01 17:29:10','Secondary Factor'),(4,1,'F01','Capaian Unggulan (CU) Wawancara','Tahap Final',10,35.00,'2026-05-26 08:46:50','2026-06-19 16:42:23','Core Factor'),(5,1,'F02','Gagasan Kreatif (GK) Presentasi','Tahap Final',10,35.00,'2026-05-26 08:46:50','2026-06-19 16:42:23','Core Factor'),(6,1,'F03','Bahasa Inggris (BI) Lisan','Tahap Final',10,30.00,'2026-05-26 08:46:50','2026-07-01 17:29:10','Core Factor'),(7,2,'A01','Capaian Unggulan (CU) Berkas','Tahap Awal',10,35.00,'2026-06-20 01:48:30','2026-07-01 17:29:10','Secondary Factor'),(8,2,'A02','Gagasan Kreatif (GK) Naskah','Tahap Awal',10,35.00,'2026-06-20 01:48:30','2026-07-01 17:29:30','Secondary Factor'),(9,2,'A03','Bahasa Inggris (BI) Video','Tahap Awal',10,30.00,'2026-06-20 01:48:30','2026-07-01 17:29:10','Secondary Factor'),(10,2,'F01','Capaian Unggulan (CU) Wawancara','Tahap Final',10,35.00,'2026-06-20 01:48:30','2026-07-01 17:29:10','Core Factor'),(11,2,'F02','Gagasan Kreatif (GK) Presentasi','Tahap Final',10,35.00,'2026-06-20 01:48:30','2026-07-01 17:29:10','Core Factor'),(12,2,'F03','Bahasa Inggris (BI) Lisan','Tahap Final',10,30.00,'2026-06-20 01:48:30','2026-07-01 17:29:10','Core Factor'),(15,7,'A02','Gagasan Kreatif (GK) Naskah','Tahap Awal',10,35.00,'2026-07-01 15:34:35','2026-07-01 17:29:10','Secondary Factor'),(16,7,'F01','Capaian Unggulan (CU) Wawancara','Tahap Final',10,35.00,'2026-07-01 16:23:39','2026-07-01 17:29:10','Core Factor'),(17,7,'A01','Capaian Unggulan (CU) Berkas','Tahap Awal',10,35.00,'2026-07-01 16:53:59','2026-07-01 17:29:10','Secondary Factor'),(21,7,'A03','Bahasa Inggris (BI) Video','Tahap Awal',10,30.00,'2026-07-01 17:29:30','2026-07-01 17:29:30','Secondary Factor'),(22,7,'F02','Gagasan Kreatif (GK) Presentasi','Tahap Final',10,35.00,'2026-07-01 17:29:30','2026-07-01 17:29:30','Core Factor'),(23,7,'F03','Bahasa Inggris (BI) Lisan','Tahap Final',10,30.00,'2026-07-01 17:29:30','2026-07-01 17:29:30','Core Factor');
/*!40000 ALTER TABLE `kriteria_penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `jenjang_id` bigint unsigned NOT NULL,
  `nim` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `pernah_pilmapres` enum('Belum Pernah','Lokal','Nasional') COLLATE utf8mb4_unicode_ci DEFAULT 'Belum Pernah',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswa_nim_unique` (`nim`),
  KEY `user_id` (`user_id`),
  KEY `mahasiswa_jenjang_id_foreign` (`jenjang_id`),
  CONSTRAINT `mahasiswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mahasiswa_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (3,8,1,'22430067','Ilmu Komputer',3.90,'Belum Pernah','2026-05-30 01:08:57','2026-06-19 16:42:22'),(4,9,1,'22430055','Ilmu Komputer',3.80,'Belum Pernah','2026-06-03 05:45:39','2026-06-19 16:42:22'),(6,11,1,'22520022','Teknik Mesin',3.80,'Belum Pernah','2026-06-03 06:04:24','2026-06-19 16:42:22'),(9,15,2,'24610001','Akuntansi',3.85,'Nasional','2026-06-22 08:02:17','2026-06-22 08:02:17'),(10,16,2,'24620002','Manajemen',3.75,'Belum Pernah','2026-06-22 08:02:17','2026-06-22 08:02:17'),(11,17,2,'24630003','Ilmu Hukum',3.90,'Lokal','2026-06-22 08:02:17','2026-06-22 08:02:17'),(12,18,2,'24610004','Akuntansi',3.65,'Belum Pernah','2026-06-22 08:02:17','2026-06-22 08:02:17'),(13,19,2,'24620005','Manajemen',3.80,'Lokal','2026-06-22 08:02:17','2026-06-22 08:02:17'),(14,20,1,'22530001','Ilmu Komputer',3.30,'Belum Pernah','2026-06-24 05:11:58','2026-06-24 05:11:58'),(15,21,1,'22530002','Ilmu Komputer',2.94,'Lokal','2026-06-24 05:11:58','2026-06-24 05:11:58'),(16,22,1,'22530003','Ilmu Komputer',2.90,'Nasional','2026-06-24 05:11:59','2026-06-24 05:11:59'),(17,23,1,'22530004','Ilmu Komputer',3.18,'Lokal','2026-06-24 05:11:59','2026-06-24 05:11:59'),(18,24,1,'22530005','Ilmu Komputer',3.94,'Lokal','2026-06-24 05:11:59','2026-06-24 05:11:59'),(19,25,1,'22530006','Ilmu Komputer',2.62,'Nasional','2026-06-24 05:11:59','2026-06-24 05:11:59'),(20,26,1,'22530007','Ilmu Komputer',3.03,'Lokal','2026-06-24 05:11:59','2026-06-24 05:11:59'),(21,27,2,'24610006','Manajemen',3.99,'Nasional','2026-06-24 05:11:59','2026-06-24 05:11:59'),(22,28,2,'24610007','Manajemen',2.90,'Lokal','2026-06-24 05:12:00','2026-06-24 05:12:00'),(23,29,2,'24620008','Manajemen',2.55,'Lokal','2026-06-24 05:12:00','2026-06-24 05:12:00'),(24,30,2,'24610009','Manajemen',3.52,'Nasional','2026-06-24 05:12:00','2026-06-24 05:12:00'),(25,31,2,'24620010','Manajemen',2.75,'Belum Pernah','2026-06-24 05:12:00','2026-06-24 05:12:00');
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026_06_19_153038_fix_schema_columns',1),(2,'0001_01_01_000000_create_users_table',0),(3,'0001_01_01_000001_create_cache_table',0),(4,'0001_01_01_000002_create_jobs_table',0),(5,'2026_06_19_160000_create_jenjang_table',2),(6,'2026_06_19_160100_add_jenjang_id_to_tables',2),(7,'2026_06_19_160200_finish_jenjang_id_migration',3),(8,'2026_06_20_013956_add_jenjang_id_to_rubrik_tables',4),(9,'2026_06_20_150000_add_label_to_rubrik_tables',4),(10,'2026_06_21_065418_create_panduan_table',5),(11,'2026_06_23_133211_add_nidn_to_users_table',6),(12,'2026_06_23_140000_create_program_studi_table',7),(13,'2026_06_23_232413_create_activity_log_table',8),(14,'2026_06_23_232414_add_event_column_to_activity_log_table',8),(15,'2026_06_23_232415_add_batch_uuid_column_to_activity_log_table',8),(16,'2026_06_24_110429_create_notifications_table',9),(17,'2026_07_01_231227_add_kriteria_id_to_rubrik_tables',10),(18,'2026_07_01_231250_create_rubrik_custom_templates_tables',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=397 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-05-26 01:51:03','2026-06-20 01:06:39'),(2,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-05-29 08:31:41','2026-06-20 01:06:39'),(4,1,'Mahasiswa baru telah mendaftar: KHOIRUL FARIDZ',1,'info','2026-05-29 08:48:24','2026-06-20 01:06:39'),(7,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: KTP',1,'info','2026-05-29 23:32:01','2026-06-20 01:06:39'),(9,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: KTP',1,'info','2026-05-29 23:32:05','2026-06-20 01:06:39'),(11,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: KTM',1,'info','2026-05-29 23:32:31','2026-06-20 01:06:39'),(13,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: Transkrip Nilai',1,'info','2026-05-29 23:32:45','2026-06-20 01:06:39'),(15,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: Surat Pengantar Fakultas',1,'info','2026-05-29 23:33:01','2026-06-20 01:06:39'),(17,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: Naskah Gagasan Kreatif',1,'info','2026-05-29 23:36:22','2026-06-20 01:06:39'),(19,1,'Berkas baru diunggah oleh KHOIRUL FARIDZ: Video Bahasa Inggris',1,'info','2026-05-29 23:36:59','2026-06-20 01:06:39'),(20,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-05-30 00:44:45','2026-06-20 01:06:39'),(21,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-05-30 00:48:29','2026-06-20 23:47:18'),(22,8,'Akun Anda berhasil didaftarkan. Silakan lengkapi pendaftaran PILMAPRES.',0,'info','2026-05-30 01:08:57','2026-05-30 01:08:57'),(23,1,'Mahasiswa baru telah mendaftar: ISNANIA DEWI',1,'info','2026-05-30 01:08:57','2026-06-20 01:06:39'),(24,8,'Berkas \"KTP\" berhasil diunggah.',0,'success','2026-05-30 01:09:39','2026-05-30 01:09:39'),(25,1,'Berkas baru diunggah oleh ISNANIA DEWI: KTP',1,'info','2026-05-30 01:09:39','2026-06-20 01:06:39'),(26,8,'Berkas \"KTM\" berhasil diunggah.',0,'success','2026-05-30 01:10:36','2026-05-30 01:10:36'),(27,1,'Berkas baru diunggah oleh ISNANIA DEWI: KTM',1,'info','2026-05-30 01:10:36','2026-06-20 01:06:39'),(28,8,'Berkas \"Transkrip Nilai\" berhasil diunggah.',0,'success','2026-05-30 01:13:27','2026-05-30 01:13:27'),(29,1,'Berkas baru diunggah oleh ISNANIA DEWI: Transkrip Nilai',1,'info','2026-05-30 01:13:27','2026-06-20 01:06:39'),(30,8,'Berkas \"Surat Pengantar Fakultas\" berhasil diunggah.',0,'success','2026-05-30 01:15:21','2026-05-30 01:15:21'),(31,1,'Berkas baru diunggah oleh ISNANIA DEWI: Surat Pengantar Fakultas',1,'info','2026-05-30 01:15:21','2026-06-20 01:06:39'),(32,8,'Berkas \"Naskah Gagasan Kreatif\" berhasil diunggah.',0,'success','2026-05-30 01:31:30','2026-05-30 01:31:30'),(33,1,'Berkas baru diunggah oleh ISNANIA DEWI: Naskah Gagasan Kreatif',1,'info','2026-05-30 01:31:30','2026-06-20 01:06:39'),(34,8,'Berkas \"Video Bahasa Inggris\" berhasil diunggah.',0,'success','2026-05-30 01:31:44','2026-05-30 01:31:44'),(35,1,'Berkas baru diunggah oleh ISNANIA DEWI: Video Bahasa Inggris',1,'info','2026-05-30 01:31:44','2026-06-20 01:06:39'),(36,8,'Selamat datang kembali, ISNANIA DEWI!',0,'success','2026-06-03 05:44:30','2026-06-03 05:44:30'),(37,9,'Akun Anda berhasil didaftarkan. Silakan lengkapi pendaftaran PILMAPRES.',0,'info','2026-06-03 05:45:39','2026-06-03 05:45:39'),(38,1,'Mahasiswa baru telah mendaftar: ALIP MEDI PRASTYO',1,'info','2026-06-03 05:45:39','2026-06-20 01:06:39'),(39,9,'Berkas \"KTP\" berhasil diunggah.',0,'success','2026-06-03 05:49:44','2026-06-03 05:49:44'),(40,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: KTP',1,'info','2026-06-03 05:49:44','2026-06-20 01:06:39'),(41,9,'Berkas \"KTM\" berhasil diunggah.',0,'success','2026-06-03 05:51:41','2026-06-03 05:51:41'),(42,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: KTM',1,'info','2026-06-03 05:51:41','2026-06-20 01:06:39'),(43,9,'Berkas \"Transkrip Nilai\" berhasil diunggah.',0,'success','2026-06-03 05:52:09','2026-06-03 05:52:09'),(44,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: Transkrip Nilai',1,'info','2026-06-03 05:52:09','2026-06-20 01:06:39'),(45,9,'Berkas \"Surat Pengantar Fakultas\" berhasil diunggah.',0,'success','2026-06-03 05:52:26','2026-06-03 05:52:26'),(46,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: Surat Pengantar Fakultas',1,'info','2026-06-03 05:52:26','2026-06-20 01:06:39'),(47,9,'Berkas \"Naskah Gagasan Kreatif\" berhasil diunggah.',0,'success','2026-06-03 05:55:44','2026-06-03 05:55:44'),(48,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: Naskah Gagasan Kreatif',1,'info','2026-06-03 05:55:44','2026-06-20 01:06:39'),(49,9,'Berkas \"Video Bahasa Inggris\" berhasil diunggah.',0,'success','2026-06-03 05:56:01','2026-06-03 05:56:01'),(50,1,'Berkas baru diunggah oleh ALIP MEDI PRASTYO: Video Bahasa Inggris',1,'info','2026-06-03 05:56:01','2026-06-20 01:06:39'),(51,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-03 05:56:52','2026-06-20 01:06:39'),(53,1,'Mahasiswa baru telah mendaftar: YUSRIL ASROFI',1,'info','2026-06-03 06:02:36','2026-06-20 01:06:39'),(54,11,'Akun Anda berhasil didaftarkan. Silakan lengkapi pendaftaran PILMAPRES.',0,'info','2026-06-03 06:04:24','2026-06-03 06:04:24'),(55,1,'Mahasiswa baru telah mendaftar: MUHAMMAD RAMDANI',1,'info','2026-06-03 06:04:24','2026-06-20 01:06:39'),(56,11,'Berkas \"KTP\" berhasil diunggah.',0,'success','2026-06-03 06:04:56','2026-06-03 06:04:56'),(57,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: KTP',1,'info','2026-06-03 06:04:56','2026-06-20 01:06:39'),(58,11,'Berkas \"KTM\" berhasil diunggah.',0,'success','2026-06-03 06:05:49','2026-06-03 06:05:49'),(59,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: KTM',1,'info','2026-06-03 06:05:49','2026-06-20 01:06:39'),(60,11,'Berkas \"Transkrip Nilai\" berhasil diunggah.',0,'success','2026-06-03 06:06:06','2026-06-03 06:06:06'),(61,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: Transkrip Nilai',1,'info','2026-06-03 06:06:06','2026-06-20 01:06:39'),(62,11,'Berkas \"Surat Pengantar Fakultas\" berhasil diunggah.',0,'success','2026-06-03 06:06:26','2026-06-03 06:06:26'),(63,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: Surat Pengantar Fakultas',1,'info','2026-06-03 06:06:26','2026-06-20 01:06:39'),(64,11,'Berkas \"Naskah Gagasan Kreatif\" berhasil diunggah.',0,'success','2026-06-03 06:09:16','2026-06-03 06:09:16'),(65,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: Naskah Gagasan Kreatif',1,'info','2026-06-03 06:09:16','2026-06-20 01:06:39'),(66,11,'Berkas \"Video Bahasa Inggris\" berhasil diunggah.',0,'success','2026-06-03 06:09:29','2026-06-03 06:09:29'),(67,1,'Berkas baru diunggah oleh MUHAMMAD RAMDANI: Video Bahasa Inggris',1,'info','2026-06-03 06:09:29','2026-06-20 01:06:39'),(69,1,'Mahasiswa baru telah mendaftar: FUADIL ROZAQ',1,'info','2026-06-03 06:14:08','2026-06-20 01:06:39'),(71,1,'Berkas baru diunggah oleh FUADIL ROZAQ: KTP',1,'info','2026-06-03 06:14:41','2026-06-20 01:06:39'),(73,1,'Berkas baru diunggah oleh FUADIL ROZAQ: KTM',1,'info','2026-06-03 06:14:59','2026-06-20 01:06:39'),(75,1,'Berkas baru diunggah oleh FUADIL ROZAQ: Transkrip Nilai',1,'info','2026-06-03 06:15:26','2026-06-20 01:06:39'),(77,1,'Berkas baru diunggah oleh FUADIL ROZAQ: Surat Pengantar Fakultas',1,'info','2026-06-03 06:15:40','2026-06-20 01:06:39'),(79,1,'Berkas baru diunggah oleh FUADIL ROZAQ: Naskah Gagasan Kreatif',1,'info','2026-06-03 06:17:35','2026-06-20 01:06:39'),(81,1,'Berkas baru diunggah oleh FUADIL ROZAQ: Video Bahasa Inggris',1,'info','2026-06-03 06:17:48','2026-06-20 01:06:39'),(93,3,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',1,'info','2026-06-03 06:19:20','2026-06-20 23:47:18'),(94,4,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:19:20','2026-06-03 06:19:20'),(95,5,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:19:20','2026-06-03 06:19:20'),(97,8,'Dokumen \"KTP\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:43','2026-06-03 06:19:43'),(98,8,'Dokumen \"KTM\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:45','2026-06-03 06:19:45'),(99,8,'Dokumen \"Transkrip Nilai\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:46','2026-06-03 06:19:46'),(100,8,'Dokumen \"Surat Pengantar Fakultas\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:47','2026-06-03 06:19:47'),(101,8,'Dokumen \"Naskah Gagasan Kreatif\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:48','2026-06-03 06:19:48'),(102,8,'Dokumen \"Video Bahasa Inggris\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:51','2026-06-03 06:19:51'),(103,8,'Portofolio CU \"JUARA 1 LOMBA MENARI\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:19:58','2026-06-03 06:19:58'),(104,8,'Portofolio CU \"JUARA 2 LOMBA MENARI\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:00','2026-06-03 06:20:00'),(105,8,'Portofolio CU \"Sekretaris Himprosik\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:03','2026-06-03 06:20:03'),(106,8,'Berkas pendaftaran Anda telah dinyatakan LENGKAP.',0,'success','2026-06-03 06:20:09','2026-06-03 06:20:09'),(107,3,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',1,'info','2026-06-03 06:20:16','2026-06-20 23:47:18'),(108,4,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:20:16','2026-06-03 06:20:16'),(109,5,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:20:16','2026-06-03 06:20:16'),(110,8,'Selamat! Anda dinyatakan LOLOS seleksi Tahap I (Administrasi).',0,'success','2026-06-03 06:20:16','2026-06-03 06:20:16'),(111,9,'Dokumen \"KTP\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:33','2026-06-03 06:20:33'),(112,9,'Dokumen \"KTM\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:34','2026-06-03 06:20:34'),(113,9,'Dokumen \"Transkrip Nilai\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:35','2026-06-03 06:20:35'),(114,9,'Dokumen \"Surat Pengantar Fakultas\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:36','2026-06-03 06:20:36'),(115,9,'Dokumen \"Naskah Gagasan Kreatif\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:37','2026-06-03 06:20:37'),(116,9,'Dokumen \"Video Bahasa Inggris\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:38','2026-06-03 06:20:38'),(117,9,'Portofolio CU \"JUARA 1 SENI BELADIRI\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:40','2026-06-03 06:20:40'),(118,9,'Portofolio CU \"JUAR 2 DESIGN GRAFIS\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:42','2026-06-03 06:20:42'),(119,9,'Portofolio CU \"JUARA 3 DESAIN POSTER\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:20:42','2026-06-03 06:20:42'),(120,9,'Berkas pendaftaran Anda telah dinyatakan LENGKAP.',0,'success','2026-06-03 06:20:52','2026-06-03 06:20:52'),(121,3,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',1,'info','2026-06-03 06:20:57','2026-06-20 23:47:18'),(122,4,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:20:58','2026-06-03 06:20:58'),(123,5,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:20:58','2026-06-03 06:20:58'),(124,9,'Selamat! Anda dinyatakan LOLOS seleksi Tahap I (Administrasi).',0,'success','2026-06-03 06:20:58','2026-06-03 06:20:58'),(125,11,'Dokumen \"KTP\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:16','2026-06-03 06:21:16'),(126,11,'Dokumen \"KTM\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:18','2026-06-03 06:21:18'),(127,11,'Dokumen \"Transkrip Nilai\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:19','2026-06-03 06:21:19'),(128,11,'Dokumen \"Surat Pengantar Fakultas\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:20','2026-06-03 06:21:20'),(129,11,'Dokumen \"Naskah Gagasan Kreatif\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:22','2026-06-03 06:21:22'),(130,11,'Dokumen \"Video Bahasa Inggris\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:23','2026-06-03 06:21:23'),(131,11,'Portofolio CU \"JUARA  2 DESIGN BANGUNAN\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:24','2026-06-03 06:21:24'),(132,11,'Portofolio CU \"JUARA 3 DESIGN ARSITEKTUR\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:26','2026-06-03 06:21:26'),(133,11,'Portofolio CU \"JUARA 1 RHXGHH\" Anda dinyatakan VALID.',0,'success','2026-06-03 06:21:28','2026-06-03 06:21:28'),(134,11,'Berkas pendaftaran Anda telah dinyatakan LENGKAP.',0,'success','2026-06-03 06:21:35','2026-06-03 06:21:35'),(135,3,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',1,'info','2026-06-03 06:21:42','2026-06-20 23:47:18'),(136,4,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:21:42','2026-06-03 06:21:42'),(137,5,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:21:42','2026-06-03 06:21:42'),(138,11,'Selamat! Anda dinyatakan LOLOS seleksi Tahap I (Administrasi).',0,'success','2026-06-03 06:21:42','2026-06-03 06:21:42'),(148,3,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',1,'info','2026-06-03 06:22:24','2026-06-20 23:47:18'),(149,4,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:22:24','2026-06-03 06:22:24'),(150,5,'Anda memiliki tugas penilaian baru untuk peserta PILMAPRES.',0,'info','2026-06-03 06:22:24','2026-06-03 06:22:24'),(152,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-03 06:24:20','2026-06-20 23:47:18'),(154,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-03 19:45:19','2026-06-20 23:47:18'),(155,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-04 01:31:36','2026-06-20 23:47:18'),(156,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-04 08:03:31','2026-06-20 23:47:18'),(157,4,'Selamat datang kembali, Guna Yanti K.S Siregar, S.Kom., M.T.I.!',0,'success','2026-06-04 08:33:16','2026-06-04 08:33:16'),(158,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-04 09:53:04','2026-06-20 01:06:39'),(159,5,'Selamat datang kembali, Dr. Agus Wibowo, M.Pd.!',0,'success','2026-06-04 09:53:43','2026-06-04 09:53:43'),(160,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-04 10:12:58','2026-06-20 01:06:39'),(161,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-04 10:16:06','2026-06-23 11:26:24'),(163,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 10:16:06','2026-06-04 10:16:06'),(164,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 10:16:06','2026-06-04 10:16:06'),(166,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 10:16:06','2026-06-04 10:16:06'),(168,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-04 11:09:12','2026-06-23 11:26:24'),(170,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:09:12','2026-06-04 11:09:12'),(171,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:09:12','2026-06-04 11:09:12'),(173,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:09:12','2026-06-04 11:09:12'),(175,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-04 11:10:46','2026-06-23 11:26:24'),(177,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:10:46','2026-06-04 11:10:46'),(178,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:10:46','2026-06-04 11:10:46'),(180,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-04 11:10:46','2026-06-04 11:10:46'),(182,3,'Selamat datang kembali, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-04 11:34:58','2026-06-20 23:47:18'),(183,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-04 18:42:38','2026-06-20 01:06:39'),(184,2,'Selamat datang kembali, Dr. Ir. Eva Rolia, S.T., M.T., M.KM.!',1,'success','2026-06-04 18:49:38','2026-06-23 11:26:24'),(185,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-04 20:55:11','2026-06-20 01:06:39'),(186,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 08:53:52','2026-06-20 01:06:39'),(187,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 08:54:24','2026-06-20 01:06:39'),(188,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 08:55:01','2026-06-20 01:06:39'),(189,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:27:27','2026-06-20 01:06:39'),(190,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:28:57','2026-06-20 01:06:39'),(192,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:44:15','2026-06-20 01:06:39'),(193,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:50:25','2026-06-20 01:06:39'),(194,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:52:46','2026-06-20 01:06:39'),(195,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 09:56:00','2026-06-20 01:06:39'),(196,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 10:22:44','2026-06-20 01:06:39'),(197,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 18:53:38','2026-06-20 01:06:39'),(198,1,'Selamat datang kembali, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 20:37:01','2026-06-20 01:06:39'),(199,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:04:57','2026-06-20 01:06:39'),(200,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:06:23','2026-06-20 01:06:39'),(201,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:13:03','2026-06-20 01:06:39'),(202,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:34:52','2026-06-20 01:06:39'),(203,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:44:21','2026-06-20 01:06:39'),(204,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 21:53:44','2026-06-20 01:06:39'),(205,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 22:59:09','2026-06-20 01:06:39'),(206,2,'Welcome back, Dr. Ir. Eva Rolia, S.T., M.T., M.KM.!',1,'success','2026-06-19 23:37:14','2026-06-23 11:26:24'),(207,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-19 23:39:15','2026-06-20 23:47:18'),(208,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 23:40:25','2026-06-20 01:06:24'),(210,1,'Mahasiswa baru telah mendaftar: AULIA AZZAHRA  PUTRI',1,'info','2026-06-19 23:50:43','2026-06-20 01:06:39'),(211,1,'Mahasiswa AULIA AZZAHRA  PUTRI (23520066) telah mendaftar PILMAPRES.',1,'info','2026-06-19 23:51:12','2026-06-20 01:06:39'),(212,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 23:52:14','2026-06-20 01:06:39'),(213,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-19 23:58:54','2026-06-20 01:06:39'),(214,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-20 20:04:31','2026-06-20 20:04:31'),(215,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-20 20:08:15','2026-06-20 20:08:15'),(216,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-20 23:32:57','2026-06-20 23:32:57'),(217,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-20 23:34:58','2026-06-20 23:34:58'),(218,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',1,'success','2026-06-20 23:35:56','2026-06-20 23:47:18'),(219,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-21 00:03:49','2026-06-21 00:03:49'),(220,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-21 00:22:01','2026-06-23 11:26:24'),(222,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-21 00:22:01','2026-06-21 00:22:01'),(223,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-21 00:22:01','2026-06-21 00:22:01'),(224,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-21 00:22:01','2026-06-21 00:22:01'),(227,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-22 06:05:13','2026-06-22 06:05:13'),(228,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-22 07:50:36','2026-06-22 07:50:36'),(229,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-22 08:43:35','2026-06-22 08:43:35'),(230,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-22 08:54:18','2026-06-22 08:54:18'),(231,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-22 22:22:38','2026-06-22 22:22:38'),(232,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-23 00:47:44','2026-06-23 00:47:44'),(233,1,'Welcome back, Administrator Bid. Kemahasiswaan!',1,'success','2026-06-23 00:51:21','2026-06-23 00:59:20'),(234,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-23 02:28:36','2026-06-23 02:28:36'),(235,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-23 05:42:09','2026-06-23 05:42:09'),(236,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 05:52:25','2026-06-23 11:26:24'),(238,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(239,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(240,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(243,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(244,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(245,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(246,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(247,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:25','2026-06-23 05:52:25'),(248,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 05:52:45','2026-06-23 11:26:24'),(250,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(251,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(252,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(255,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(256,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(257,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(258,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(259,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:52:45','2026-06-23 05:52:45'),(260,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-23 05:53:50','2026-06-23 05:53:50'),(261,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 05:55:14','2026-06-23 11:26:24'),(263,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(264,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(265,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(268,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(269,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(270,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(271,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(272,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:55:14','2026-06-23 05:55:14'),(273,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 05:57:23','2026-06-23 11:26:24'),(275,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(276,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(277,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(280,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(281,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(282,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(283,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(284,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 05:57:23','2026-06-23 05:57:23'),(285,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 06:01:55','2026-06-23 11:26:24'),(287,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(288,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(289,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(292,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(293,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(294,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(295,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(296,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:01:55','2026-06-23 06:01:55'),(297,2,'Welcome back, Dr. Ir. Eva Rolia, S.T., M.T., M.KM.!',1,'success','2026-06-23 06:12:28','2026-06-23 11:26:24'),(298,2,'Welcome back, Dr. Ir. Eva Rolia, S.T., M.T., M.KM.!',1,'success','2026-06-23 06:19:15','2026-06-23 11:26:24'),(299,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-23 06:20:28','2026-06-23 06:20:28'),(300,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 06:40:23','2026-06-23 11:26:24'),(302,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(303,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(304,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(307,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(308,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(309,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(310,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(311,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:40:23','2026-06-23 06:40:23'),(312,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 06:58:36','2026-06-23 11:26:39'),(314,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(315,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(316,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(319,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(320,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(321,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(322,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(323,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 06:58:36','2026-06-23 06:58:36'),(324,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 07:00:03','2026-06-23 11:26:24'),(326,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(327,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(328,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(331,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(332,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(333,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(334,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(335,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 07:00:03','2026-06-23 07:00:03'),(336,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 08:10:32','2026-06-23 11:26:24'),(338,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(339,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(340,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(343,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(344,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(345,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(346,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(347,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:10:32','2026-06-23 08:10:32'),(348,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',1,'info','2026-06-23 08:12:00','2026-06-23 11:26:24'),(350,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(351,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(352,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(355,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(356,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(357,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(358,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(359,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-23 08:12:00','2026-06-23 08:12:00'),(360,2,'Welcome back, Dr. Ir. Eva Rolia, S.T., M.T., M.KM.!',1,'success','2026-06-23 10:54:35','2026-06-23 11:26:24'),(362,8,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(363,9,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(364,11,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(367,15,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(368,16,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(369,17,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(370,18,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(371,19,'Hasil akhir PILMAPRES telah divalidasi oleh WR3. Silakan cek status pendaftaran Anda.',0,'info','2026-06-23 11:55:09','2026-06-23 11:55:09'),(372,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-24 04:39:15','2026-06-24 04:39:15'),(373,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-06-24 05:04:51','2026-06-24 05:04:51'),(374,3,'Welcome back, Fajri Arif Wibawa, S.Pd, M.Pd.!',0,'success','2026-06-24 05:06:49','2026-06-24 05:06:49'),(375,2,'Perhitungan nilai PILMAPRES telah selesai. Silakan lakukan validasi akhir.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(376,8,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(377,9,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(378,11,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(379,15,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(380,16,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(381,17,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(382,18,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(383,19,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(384,20,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(385,21,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(386,22,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(387,23,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(388,24,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(389,25,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(390,26,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(391,27,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(392,28,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(393,29,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(394,30,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(395,31,'Proses penilaian telah selesai. Hasil akhir akan segera diumumkan.',0,'info','2026-06-24 05:12:37','2026-06-24 05:12:37'),(396,1,'Welcome back, Administrator Bid. Kemahasiswaan!',0,'success','2026-07-01 11:59:32','2026-07-01 11:59:32');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `panduan`
--

DROP TABLE IF EXISTS `panduan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `panduan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `panduan`
--

LOCK TABLES `panduan` WRITE;
/*!40000 ALTER TABLE `panduan` DISABLE KEYS */;
INSERT INTO `panduan` VALUES (1,'PANDUAN PILMAPRES SARJANA',NULL,'panduan/fRVy6BlsvzMZKsiYogDYtLi10u65dVpGmyTii9iZ.pdf','2026-06-21 00:06:52','2026-06-21 00:06:52'),(2,'PANDUAN PILMAPRES DIPLOMA',NULL,'panduan/XIPwS2fww2RMDUvjgCJuCgDxFCxzz2pGsktKCjAx.pdf','2026-06-21 00:17:07','2026-06-21 00:17:07');
/*!40000 ALTER TABLE `panduan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pendaftaran`
--

DROP TABLE IF EXISTS `pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pendaftaran` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint unsigned NOT NULL,
  `status_berkas` enum('Belum Lengkap','Lengkap') COLLATE utf8mb4_unicode_ci DEFAULT 'Belum Lengkap',
  `status_seleksi` enum('Proses','Lolos Tahap 1','Tidak Lolos','Selesai') COLLATE utf8mb4_unicode_ci DEFAULT 'Proses',
  `is_submitted` tinyint(1) DEFAULT '0',
  `tanggal_daftar` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pendaftaran`
--

LOCK TABLES `pendaftaran` WRITE;
/*!40000 ALTER TABLE `pendaftaran` DISABLE KEYS */;
INSERT INTO `pendaftaran` VALUES (2,3,'Lengkap','Lolos Tahap 1',1,'2026-05-30','2026-05-30 01:09:14','2026-06-24 05:12:08'),(3,4,'Lengkap','Lolos Tahap 1',1,'2026-06-03','2026-06-03 05:48:35','2026-06-24 05:12:08'),(4,6,'Lengkap','Lolos Tahap 1',1,'2026-06-03','2026-06-03 06:04:41','2026-06-24 05:12:08'),(7,9,'Lengkap','Lolos Tahap 1',1,'2026-06-17','2026-06-22 08:02:17','2026-06-22 08:02:17'),(8,10,'Lengkap','Lolos Tahap 1',1,'2026-06-18','2026-06-22 08:02:17','2026-06-22 08:02:17'),(9,11,'Lengkap','Lolos Tahap 1',1,'2026-06-19','2026-06-22 08:02:17','2026-06-22 08:02:17'),(10,12,'Lengkap','Lolos Tahap 1',1,'2026-06-20','2026-06-22 08:02:17','2026-06-22 08:02:17'),(11,13,'Lengkap','Lolos Tahap 1',1,'2026-06-21','2026-06-22 08:02:17','2026-06-22 08:02:17'),(12,14,'Lengkap','Lolos Tahap 1',1,'2026-06-02','2026-06-24 05:11:58','2026-06-24 05:11:58'),(13,15,'Lengkap','Lolos Tahap 1',1,'2026-05-29','2026-06-24 05:11:58','2026-06-24 05:11:58'),(14,16,'Lengkap','Lolos Tahap 1',1,'2026-05-29','2026-06-24 05:11:59','2026-06-24 05:11:59'),(15,17,'Lengkap','Lolos Tahap 1',1,'2026-05-29','2026-06-24 05:11:59','2026-06-24 05:11:59'),(16,18,'Lengkap','Lolos Tahap 1',1,'2026-06-10','2026-06-24 05:11:59','2026-06-24 05:11:59'),(17,19,'Lengkap','Lolos Tahap 1',1,'2026-06-09','2026-06-24 05:11:59','2026-06-24 05:11:59'),(18,20,'Lengkap','Lolos Tahap 1',1,'2026-06-05','2026-06-24 05:11:59','2026-06-24 05:11:59'),(19,21,'Lengkap','Lolos Tahap 1',1,'2026-06-04','2026-06-24 05:11:59','2026-06-24 05:11:59'),(20,22,'Lengkap','Lolos Tahap 1',1,'2026-06-10','2026-06-24 05:12:00','2026-06-24 05:12:00'),(21,23,'Lengkap','Lolos Tahap 1',1,'2026-06-09','2026-06-24 05:12:00','2026-06-24 05:12:00'),(22,24,'Lengkap','Lolos Tahap 1',1,'2026-06-04','2026-06-24 05:12:00','2026-06-24 05:12:00'),(23,25,'Lengkap','Lolos Tahap 1',1,'2026-05-30','2026-06-24 05:12:00','2026-06-24 05:12:00');
/*!40000 ALTER TABLE `pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengumuman`
--

DROP TABLE IF EXISTS `pengumuman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumuman` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `konten` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumuman`
--

LOCK TABLES `pengumuman` WRITE;
/*!40000 ALTER TABLE `pengumuman` DISABLE KEYS */;
INSERT INTO `pengumuman` VALUES (1,'Pendaftaran PILMAPRES 2026 Resmi Dibuka','<p>Halo Mahasiswa UM Metro! Seleksi Mahasiswa Berprestasi (PILMAPRES) tingkat Universitas tahun 2026 telah resmi dibuka. Silakan daftar segera!</p>',NULL,'2026-05-01','2026-05-26 08:46:50','2026-05-26 08:46:50'),(2,'Panduan Penulisan Gagasan Kreatif','<p>Bagi peserta yang telah mendaftar, silakan unduh panduan penulisan Gagasan Kreatif (GK) pada menu Informasi.</p>',NULL,'2026-05-05','2026-05-26 08:46:50','2026-05-26 08:46:50');
/*!40000 ALTER TABLE `pengumuman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian`
--

DROP TABLE IF EXISTS `penilaian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `kriteria_id` bigint unsigned NOT NULL,
  `nilai_input` decimal(8,4) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `kriteria_id` (`kriteria_id`),
  CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=412 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian`
--

LOCK TABLES `penilaian` WRITE;
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
INSERT INTO `penilaian` VALUES (7,3,2,1,81.0000,'2026-06-04 08:14:40','2026-06-23 05:51:26'),(8,3,2,2,81.1200,'2026-06-04 08:14:40','2026-06-23 05:51:26'),(9,3,2,3,89.6000,'2026-06-04 08:14:40','2026-06-23 05:51:27'),(10,3,2,4,82.7000,'2026-06-04 08:14:40','2026-06-23 05:51:26'),(11,3,2,5,81.4500,'2026-06-04 08:14:40','2026-06-23 05:51:26'),(12,3,2,6,89.6000,'2026-06-04 08:14:40','2026-06-23 05:51:27'),(13,3,3,1,65.0000,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(14,3,3,2,81.9400,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(15,3,3,3,80.0000,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(16,3,3,4,73.8000,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(17,3,3,5,80.4500,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(18,3,3,6,80.0000,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(19,3,4,1,55.0000,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(20,3,4,2,83.9200,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(21,3,4,3,75.8000,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(22,3,4,4,73.2000,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(23,3,4,5,77.3000,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(24,3,4,6,75.8000,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(37,4,2,1,81.0000,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(38,4,2,2,79.6200,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(39,4,2,3,85.0000,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(40,4,2,4,85.6000,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(41,4,2,5,82.0000,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(42,4,2,6,85.0000,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(43,4,3,1,65.0000,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(44,4,3,2,71.0900,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(45,4,3,3,79.4000,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(46,4,3,4,74.9000,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(47,4,3,5,79.8500,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(48,4,3,6,79.4000,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(49,4,4,1,55.0000,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(50,4,4,2,80.9300,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(51,4,4,3,80.4000,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(52,4,4,4,78.6000,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(53,4,4,5,75.5500,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(54,4,4,6,80.4000,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(67,5,2,1,81.0000,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(68,5,2,2,80.9500,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(69,5,2,3,70.4000,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(70,5,2,4,82.5000,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(71,5,2,5,79.1500,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(72,5,2,6,70.4000,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(73,5,3,1,65.0000,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(74,5,3,2,75.7200,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(75,5,3,3,71.4000,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(76,5,3,4,85.7000,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(77,5,3,5,76.8000,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(78,5,3,6,71.4000,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(79,5,4,1,55.0000,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(80,5,4,2,79.0500,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(81,5,4,3,91.2000,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(82,5,4,4,84.7000,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(83,5,4,5,76.5500,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(84,5,4,6,91.2000,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(106,3,7,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:28'),(107,4,7,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:31'),(108,5,7,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:34'),(109,3,8,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:28'),(110,4,8,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:31'),(111,5,8,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:34'),(112,3,9,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:28'),(113,4,9,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:31'),(114,5,9,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:35'),(115,3,10,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:29'),(116,4,10,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:32'),(117,5,10,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:35'),(118,3,11,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:29'),(119,4,11,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:32'),(120,5,11,7,0.0000,'2026-06-22 08:42:02','2026-06-23 05:51:35'),(121,3,7,8,73.6200,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(122,3,7,9,86.6000,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(123,3,7,10,82.1000,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(124,3,7,11,81.4500,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(125,3,7,12,86.6000,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(126,3,8,10,94.3000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(127,3,8,8,78.0300,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(128,3,8,11,85.4000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(129,3,8,9,73.8000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(130,3,8,12,73.8000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(131,3,9,10,79.8000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(132,3,9,8,86.6800,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(133,3,9,11,81.6000,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(134,3,9,9,74.2000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(135,3,9,12,74.2000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(136,3,10,10,72.6000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(137,3,10,8,81.2200,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(138,3,10,11,84.9500,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(139,3,10,9,80.6000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(140,3,10,12,80.6000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(141,3,11,10,88.6000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(142,3,11,8,76.9900,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(143,3,11,11,78.0000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(144,3,11,9,91.4000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(145,3,11,12,91.4000,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(146,4,7,10,63.4000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(147,4,7,8,82.9500,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(148,4,7,11,79.1500,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(149,4,7,9,92.6000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(150,4,7,12,92.6000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(151,4,8,10,77.2000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(152,4,8,8,81.1900,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(153,4,8,11,78.1500,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(154,4,8,9,73.6000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(155,4,8,12,73.6000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(156,4,9,10,83.7000,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(157,4,9,8,79.8400,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(158,4,9,11,85.3500,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(159,4,9,9,76.0000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(160,4,9,12,76.0000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(161,4,10,10,81.2000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(162,4,10,8,76.7800,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(163,4,10,11,84.5000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(164,4,10,9,77.8000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(165,4,10,12,77.8000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(166,4,11,10,86.0000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(167,4,11,8,77.9300,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(168,4,11,11,70.2500,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(169,4,11,9,82.2000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(170,4,11,12,82.2000,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(171,5,7,10,90.5000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(172,5,7,8,81.0500,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(173,5,7,11,77.8000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(174,5,7,9,70.2000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(175,5,7,12,70.2000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(176,5,8,10,86.3000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(177,5,8,8,87.8100,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(178,5,8,11,87.8500,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(179,5,8,9,81.0000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(180,5,8,12,81.0000,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(181,5,9,10,91.2000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(182,5,9,8,79.1000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(183,5,9,11,76.7500,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(184,5,9,9,78.4000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(185,5,9,12,78.4000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(186,5,10,10,76.9000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(187,5,10,8,80.9600,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(188,5,10,11,88.5500,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(189,5,10,9,77.6000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(190,5,10,12,77.6000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(191,5,11,10,80.9000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(192,5,11,8,78.3200,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(193,5,11,11,82.7000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(194,5,11,9,83.4000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(195,5,11,12,83.4000,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(196,3,12,1,65.5000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(197,3,12,2,88.3000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(198,3,12,3,86.6000,'2026-06-24 05:11:58','2026-06-24 05:12:36'),(199,3,12,4,82.2000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(200,3,12,5,69.6000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(201,3,12,6,86.6000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(202,4,12,1,75.9000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(203,4,12,2,78.7000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(204,4,12,3,89.3000,'2026-06-24 05:11:58','2026-06-24 05:12:36'),(205,4,12,4,70.7000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(206,4,12,5,77.0000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(207,4,12,6,89.3000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(208,5,12,1,62.7000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(209,5,12,2,98.5000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(210,5,12,3,82.8000,'2026-06-24 05:11:58','2026-06-24 05:12:36'),(211,5,12,4,83.6000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(212,5,12,5,74.7000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(213,5,12,6,82.8000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(214,3,13,1,76.8000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(215,3,13,2,74.0000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(216,3,13,3,93.1000,'2026-06-24 05:11:58','2026-06-24 05:12:36'),(217,3,13,4,74.9000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(218,3,13,5,93.2000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(219,3,13,6,93.1000,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(220,4,13,1,81.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(221,4,13,2,84.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(222,4,13,3,73.3000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(223,4,13,4,75.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(224,4,13,5,73.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(225,4,13,6,73.3000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(226,5,13,1,64.3000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(227,5,13,2,75.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(228,5,13,3,96.9000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(229,5,13,4,73.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(230,5,13,5,76.0000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(231,5,13,6,96.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(232,3,14,1,91.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(233,3,14,2,88.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(234,3,14,3,64.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(235,3,14,4,93.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(236,3,14,5,97.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(237,3,14,6,64.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(238,4,14,1,87.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(239,4,14,2,88.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(240,4,14,3,85.9000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(241,4,14,4,89.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(242,4,14,5,66.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(243,4,14,6,85.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(244,5,14,1,95.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(245,5,14,2,99.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(246,5,14,3,81.8000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(247,5,14,4,80.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(248,5,14,5,88.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(249,5,14,6,81.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(250,3,15,1,69.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(251,3,15,2,77.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(252,3,15,3,73.1000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(253,3,15,4,68.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(254,3,15,5,87.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(255,3,15,6,73.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(256,4,15,1,80.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(257,4,15,2,60.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(258,4,15,3,76.7000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(259,4,15,4,84.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(260,4,15,5,85.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(261,4,15,6,76.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(262,5,15,1,91.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(263,5,15,2,61.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(264,5,15,3,69.2000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(265,5,15,4,92.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(266,5,15,5,68.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(267,5,15,6,69.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(268,3,16,1,94.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(269,3,16,2,63.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(270,3,16,3,68.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(271,3,16,4,86.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(272,3,16,5,98.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(273,3,16,6,68.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(274,4,16,1,70.0000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(275,4,16,2,75.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(276,4,16,3,77.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(277,4,16,4,92.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(278,4,16,5,90.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(279,4,16,6,77.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(280,5,16,1,74.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(281,5,16,2,69.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(282,5,16,3,82.4000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(283,5,16,4,78.3000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(284,5,16,5,94.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(285,5,16,6,82.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(286,3,17,1,63.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(287,3,17,2,67.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(288,3,17,3,82.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(289,3,17,4,95.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(290,3,17,5,65.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(291,3,17,6,82.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(292,4,17,1,61.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(293,4,17,2,67.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(294,4,17,3,93.7000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(295,4,17,4,86.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(296,4,17,5,94.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(297,4,17,6,93.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(298,5,17,1,72.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(299,5,17,2,68.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(300,5,17,3,89.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(301,5,17,4,62.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(302,5,17,5,89.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(303,5,17,6,89.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(304,3,18,1,72.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(305,3,18,2,79.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(306,3,18,3,73.5000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(307,3,18,4,71.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(308,3,18,5,70.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(309,3,18,6,73.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(310,4,18,1,96.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(311,4,18,2,83.3000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(312,4,18,3,79.3000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(313,4,18,4,67.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(314,4,18,5,80.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(315,4,18,6,79.3000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(316,5,18,1,60.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(317,5,18,2,86.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(318,5,18,3,82.0000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(319,5,18,4,76.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(320,5,18,5,86.6000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(321,5,18,6,82.0000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(322,3,19,7,92.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(323,3,19,8,71.5000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(324,3,19,9,86.0000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(325,3,19,10,94.1000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(326,3,19,11,93.8000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(327,3,19,12,86.0000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(328,4,19,7,68.9000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(329,4,19,8,84.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(330,4,19,9,94.4000,'2026-06-24 05:11:59','2026-06-24 05:12:36'),(331,4,19,10,88.2000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(332,4,19,11,82.7000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(333,4,19,12,94.4000,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(334,5,19,7,81.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(335,5,19,8,83.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(336,5,19,9,93.5000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(337,5,19,10,90.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(338,5,19,11,95.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(339,5,19,12,93.5000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(340,3,20,7,62.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(341,3,20,8,79.7000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(342,3,20,9,77.9000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(343,3,20,10,85.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(344,3,20,11,61.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(345,3,20,12,77.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(346,4,20,7,95.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(347,4,20,8,77.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(348,4,20,9,94.6000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(349,4,20,10,65.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(350,4,20,11,83.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(351,4,20,12,94.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(352,5,20,7,85.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(353,5,20,8,93.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(354,5,20,9,90.0000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(355,5,20,10,81.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(356,5,20,11,97.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(357,5,20,12,90.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(358,3,21,7,85.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(359,3,21,8,95.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(360,3,21,9,65.4000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(361,3,21,10,64.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(362,3,21,11,95.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(363,3,21,12,65.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(364,4,21,7,91.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(365,4,21,8,83.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(366,4,21,9,64.2000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(367,4,21,10,80.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(368,4,21,11,86.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(369,4,21,12,64.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(370,5,21,7,93.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(371,5,21,8,72.5000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(372,5,21,9,68.8000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(373,5,21,10,84.5000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(374,5,21,11,63.7000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(375,5,21,12,68.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(376,3,22,7,88.1000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(377,3,22,8,99.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(378,3,22,9,65.4000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(379,3,22,10,69.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(380,3,22,11,66.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(381,3,22,12,65.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(382,4,22,7,74.5000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(383,4,22,8,65.5000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(384,4,22,9,99.3000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(385,4,22,10,62.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(386,4,22,11,75.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(387,4,22,12,99.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(388,5,22,7,71.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(389,5,22,8,69.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(390,5,22,9,68.2000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(391,5,22,10,87.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(392,5,22,11,74.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(393,5,22,12,68.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(394,3,23,7,67.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(395,3,23,8,81.9000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(396,3,23,9,72.8000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(397,3,23,10,63.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(398,3,23,11,77.0000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(399,3,23,12,72.8000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(400,4,23,7,83.3000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(401,4,23,8,87.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(402,4,23,9,81.7000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(403,4,23,10,91.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(404,4,23,11,61.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(405,4,23,12,81.7000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(406,5,23,7,79.7000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(407,5,23,8,78.4000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(408,5,23,9,72.6000,'2026-06-24 05:12:00','2026-06-24 05:12:36'),(409,5,23,10,82.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(410,5,23,11,64.2000,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(411,5,23,12,72.6000,'2026-06-24 05:12:00','2026-06-24 05:12:00');
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_bahasa_inggris`
--

DROP TABLE IF EXISTS `penilaian_bahasa_inggris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian_bahasa_inggris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `rubrik_bahasa_inggris_id` bigint unsigned NOT NULL,
  `nilai_input` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `rubrik_bahasa_inggris_id` (`rubrik_bahasa_inggris_id`),
  CONSTRAINT `penilaian_bahasa_inggris_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_bahasa_inggris_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_bahasa_inggris_ibfk_3` FOREIGN KEY (`rubrik_bahasa_inggris_id`) REFERENCES `rubrik_bahasa_inggris` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_bahasa_inggris`
--

LOCK TABLES `penilaian_bahasa_inggris` WRITE;
/*!40000 ALTER TABLE `penilaian_bahasa_inggris` DISABLE KEYS */;
INSERT INTO `penilaian_bahasa_inggris` VALUES (6,3,2,1,90,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(7,3,2,2,99,'2026-06-04 08:14:39','2026-06-23 05:51:27'),(8,3,2,3,87,'2026-06-04 08:14:39','2026-06-23 05:51:27'),(9,3,2,4,97,'2026-06-04 08:14:39','2026-06-23 05:51:27'),(10,3,2,5,75,'2026-06-04 08:14:39','2026-06-23 05:51:27'),(11,3,3,1,78,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(12,3,3,2,76,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(13,3,3,3,84,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(14,3,3,4,70,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(15,3,3,5,92,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(16,3,4,1,67,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(17,3,4,2,77,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(18,3,4,3,89,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(19,3,4,4,69,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(20,3,4,5,77,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(31,4,2,1,87,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(32,4,2,2,84,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(33,4,2,3,93,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(34,4,2,4,89,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(35,4,2,5,72,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(36,4,3,1,65,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(37,4,3,2,98,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(38,4,3,3,63,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(39,4,3,4,73,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(40,4,3,5,98,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(41,4,4,1,79,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(42,4,4,2,83,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(43,4,4,3,90,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(44,4,4,4,61,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(45,4,4,5,89,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(56,5,2,1,66,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(57,5,2,2,77,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(58,5,2,3,62,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(59,5,2,4,77,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(60,5,2,5,70,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(61,5,3,1,66,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(62,5,3,2,90,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(63,5,3,3,69,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(64,5,3,4,69,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(65,5,3,5,63,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(66,5,4,1,96,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(67,5,4,2,93,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(68,5,4,3,94,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(69,5,4,4,78,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(70,5,4,5,95,'2026-06-04 10:10:40','2026-06-23 05:51:34'),(76,3,7,6,89,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(77,3,7,7,83,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(78,3,7,8,87,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(79,3,7,9,94,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(80,3,7,10,80,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(81,3,8,6,63,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(82,3,8,7,72,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(83,3,8,8,68,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(84,3,8,9,74,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(85,3,8,10,92,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(86,3,9,6,89,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(87,3,9,7,73,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(88,3,9,8,64,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(89,3,9,9,85,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(90,3,9,10,60,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(91,3,10,6,81,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(92,3,10,7,82,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(93,3,10,8,81,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(94,3,10,9,87,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(95,3,10,10,72,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(96,3,11,6,77,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(97,3,11,7,100,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(98,3,11,8,99,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(99,3,11,9,85,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(100,3,11,10,96,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(101,4,7,6,98,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(102,4,7,7,99,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(103,4,7,8,68,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(104,4,7,9,98,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(105,4,7,10,100,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(106,4,8,6,64,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(107,4,8,7,80,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(108,4,8,8,66,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(109,4,8,9,69,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(110,4,8,10,89,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(111,4,9,6,64,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(112,4,9,7,70,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(113,4,9,8,87,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(114,4,9,9,99,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(115,4,9,10,60,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(116,4,10,6,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(117,4,10,7,94,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(118,4,10,8,73,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(119,4,10,9,62,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(120,4,10,10,92,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(121,4,11,6,82,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(122,4,11,7,80,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(123,4,11,8,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(124,4,11,9,99,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(125,4,11,10,82,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(126,5,7,6,70,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(127,5,7,7,64,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(128,5,7,8,85,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(129,5,7,9,65,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(130,5,7,10,67,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(131,5,8,6,76,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(132,5,8,7,98,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(133,5,8,8,72,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(134,5,8,9,90,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(135,5,8,10,69,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(136,5,9,6,68,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(137,5,9,7,83,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(138,5,9,8,70,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(139,5,9,9,73,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(140,5,9,10,98,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(141,5,10,6,89,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(142,5,10,7,78,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(143,5,10,8,70,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(144,5,10,9,76,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(145,5,10,10,75,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(146,5,11,6,66,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(147,5,11,7,89,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(148,5,11,8,77,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(149,5,11,9,93,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(150,5,11,10,92,'2026-06-23 05:51:35','2026-06-23 05:51:35');
/*!40000 ALTER TABLE `penilaian_bahasa_inggris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_naskah_gk`
--

DROP TABLE IF EXISTS `penilaian_naskah_gk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian_naskah_gk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `rubrik_naskah_gk_id` bigint unsigned NOT NULL,
  `nilai_input` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `rubrik_naskah_gk_id` (`rubrik_naskah_gk_id`),
  CONSTRAINT `penilaian_naskah_gk_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_naskah_gk_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_naskah_gk_ibfk_3` FOREIGN KEY (`rubrik_naskah_gk_id`) REFERENCES `rubrik_naskah_gks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=361 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_naskah_gk`
--

LOCK TABLES `penilaian_naskah_gk` WRITE;
/*!40000 ALTER TABLE `penilaian_naskah_gk` DISABLE KEYS */;
INSERT INTO `penilaian_naskah_gk` VALUES (13,3,2,1,96,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(14,3,2,2,83,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(15,3,2,3,96,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(16,3,2,4,60,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(17,3,2,5,60,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(18,3,2,6,79,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(19,3,2,7,91,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(20,3,2,8,93,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(21,3,2,9,71,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(22,3,2,10,72,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(23,3,2,11,82,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(24,3,2,12,88,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(25,3,3,1,79,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(26,3,3,2,85,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(27,3,3,3,65,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(28,3,3,4,82,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(29,3,3,5,71,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(30,3,3,6,92,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(31,3,3,7,91,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(32,3,3,8,67,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(33,3,3,9,92,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(34,3,3,10,81,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(35,3,3,11,81,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(36,3,3,12,90,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(37,3,4,1,80,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(38,3,4,2,87,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(39,3,4,3,94,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(40,3,4,4,90,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(41,3,4,5,85,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(42,3,4,6,96,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(43,3,4,7,78,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(44,3,4,8,87,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(45,3,4,9,97,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(46,3,4,10,69,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(47,3,4,11,62,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(48,3,4,12,86,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(73,4,2,1,85,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(74,4,2,2,91,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(75,4,2,3,68,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(76,4,2,4,65,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(77,4,2,5,69,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(78,4,2,6,89,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(79,4,2,7,96,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(80,4,2,8,80,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(81,4,2,9,77,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(82,4,2,10,60,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(83,4,2,11,74,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(84,4,2,12,88,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(85,4,3,1,72,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(86,4,3,2,94,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(87,4,3,3,63,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(88,4,3,4,74,'2026-06-04 09:11:18','2026-06-04 09:11:18'),(89,4,3,5,65,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(90,4,3,6,72,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(91,4,3,7,68,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(92,4,3,8,77,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(93,4,3,9,62,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(94,4,3,10,93,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(95,4,3,11,73,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(96,4,3,12,63,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(97,4,4,1,69,'2026-06-04 09:48:48','2026-06-23 05:51:30'),(98,4,4,2,90,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(99,4,4,3,72,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(100,4,4,4,93,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(101,4,4,5,78,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(102,4,4,6,85,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(103,4,4,7,60,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(104,4,4,8,99,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(105,4,4,9,67,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(106,4,4,10,94,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(107,4,4,11,85,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(108,4,4,12,97,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(133,5,2,1,91,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(134,5,2,2,74,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(135,5,2,3,87,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(136,5,2,4,89,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(137,5,2,5,98,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(138,5,2,6,75,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(139,5,2,7,91,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(140,5,2,8,81,'2026-06-04 10:06:03','2026-06-04 10:06:03'),(141,5,2,9,68,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(142,5,2,10,67,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(143,5,2,11,69,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(144,5,2,12,70,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(145,5,3,1,70,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(146,5,3,2,76,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(147,5,3,3,66,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(148,5,3,4,66,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(149,5,3,5,62,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(150,5,3,6,73,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(151,5,3,7,64,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(152,5,3,8,86,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(153,5,3,9,93,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(154,5,3,10,98,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(155,5,3,11,96,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(156,5,3,12,74,'2026-06-04 10:08:18','2026-06-04 10:08:18'),(157,5,4,1,75,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(158,5,4,2,99,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(159,5,4,3,82,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(160,5,4,4,64,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(161,5,4,5,75,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(162,5,4,6,75,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(163,5,4,7,79,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(164,5,4,8,65,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(165,5,4,9,94,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(166,5,4,10,88,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(167,5,4,11,78,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(168,5,4,12,84,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(181,3,7,13,71,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(182,3,7,14,97,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(183,3,7,15,72,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(184,3,7,16,64,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(185,3,7,17,78,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(186,3,7,18,82,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(187,3,7,19,66,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(188,3,7,20,63,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(189,3,7,21,83,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(190,3,7,22,80,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(191,3,7,23,83,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(192,3,7,24,61,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(193,3,8,13,67,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(194,3,8,14,78,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(195,3,8,15,76,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(196,3,8,16,81,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(197,3,8,17,70,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(198,3,8,18,63,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(199,3,8,19,76,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(200,3,8,20,86,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(201,3,8,21,80,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(202,3,8,22,90,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(203,3,8,23,70,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(204,3,8,24,100,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(205,3,9,13,88,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(206,3,9,14,99,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(207,3,9,15,97,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(208,3,9,16,84,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(209,3,9,17,68,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(210,3,9,18,83,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(211,3,9,19,100,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(212,3,9,20,80,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(213,3,9,21,92,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(214,3,9,22,79,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(215,3,9,23,98,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(216,3,9,24,69,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(217,3,10,13,95,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(218,3,10,14,67,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(219,3,10,15,90,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(220,3,10,16,78,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(221,3,10,17,93,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(222,3,10,18,63,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(223,3,10,19,97,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(224,3,10,20,61,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(225,3,10,21,92,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(226,3,10,22,63,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(227,3,10,23,78,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(228,3,10,24,76,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(229,3,11,13,99,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(230,3,11,14,94,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(231,3,11,15,65,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(232,3,11,16,65,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(233,3,11,17,70,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(234,3,11,18,76,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(235,3,11,19,64,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(236,3,11,20,93,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(237,3,11,21,64,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(238,3,11,22,60,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(239,3,11,23,95,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(240,3,11,24,92,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(241,4,7,13,71,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(242,4,7,14,85,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(243,4,7,15,79,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(244,4,7,16,90,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(245,4,7,17,79,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(246,4,7,18,92,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(247,4,7,19,94,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(248,4,7,20,100,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(249,4,7,21,74,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(250,4,7,22,91,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(251,4,7,23,61,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(252,4,7,24,77,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(253,4,8,13,80,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(254,4,8,14,78,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(255,4,8,15,62,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(256,4,8,16,83,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(257,4,8,17,75,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(258,4,8,18,100,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(259,4,8,19,60,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(260,4,8,20,99,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(261,4,8,21,89,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(262,4,8,22,69,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(263,4,8,23,97,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(264,4,8,24,90,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(265,4,9,13,72,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(266,4,9,14,91,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(267,4,9,15,71,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(268,4,9,16,80,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(269,4,9,17,91,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(270,4,9,18,60,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(271,4,9,19,99,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(272,4,9,20,62,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(273,4,9,21,85,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(274,4,9,22,72,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(275,4,9,23,77,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(276,4,9,24,78,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(277,4,10,13,73,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(278,4,10,14,60,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(279,4,10,15,84,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(280,4,10,16,71,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(281,4,10,17,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(282,4,10,18,98,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(283,4,10,19,64,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(284,4,10,20,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(285,4,10,21,100,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(286,4,10,22,67,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(287,4,10,23,72,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(288,4,10,24,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(289,4,11,13,93,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(290,4,11,14,74,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(291,4,11,15,97,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(292,4,11,16,74,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(293,4,11,17,77,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(294,4,11,18,80,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(295,4,11,19,61,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(296,4,11,20,70,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(297,4,11,21,80,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(298,4,11,22,77,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(299,4,11,23,77,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(300,4,11,24,91,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(301,5,7,13,76,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(302,5,7,14,83,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(303,5,7,15,90,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(304,5,7,16,97,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(305,5,7,17,74,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(306,5,7,18,96,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(307,5,7,19,71,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(308,5,7,20,74,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(309,5,7,21,73,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(310,5,7,22,73,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(311,5,7,23,85,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(312,5,7,24,85,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(313,5,8,13,100,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(314,5,8,14,90,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(315,5,8,15,81,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(316,5,8,16,91,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(317,5,8,17,63,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(318,5,8,18,71,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(319,5,8,19,96,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(320,5,8,20,99,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(321,5,8,21,95,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(322,5,8,22,99,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(323,5,8,23,95,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(324,5,8,24,82,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(325,5,9,13,77,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(326,5,9,14,76,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(327,5,9,15,92,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(328,5,9,16,75,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(329,5,9,17,91,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(330,5,9,18,80,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(331,5,9,19,88,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(332,5,9,20,63,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(333,5,9,21,65,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(334,5,9,22,69,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(335,5,9,23,62,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(336,5,9,24,95,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(337,5,10,13,92,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(338,5,10,14,66,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(339,5,10,15,98,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(340,5,10,16,65,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(341,5,10,17,95,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(342,5,10,18,88,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(343,5,10,19,69,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(344,5,10,20,92,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(345,5,10,21,74,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(346,5,10,22,85,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(347,5,10,23,74,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(348,5,10,24,82,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(349,5,11,13,88,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(350,5,11,14,74,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(351,5,11,15,89,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(352,5,11,16,88,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(353,5,11,17,66,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(354,5,11,18,61,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(355,5,11,19,86,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(356,5,11,20,84,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(357,5,11,21,82,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(358,5,11,22,84,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(359,5,11,23,67,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(360,5,11,24,75,'2026-06-23 05:51:35','2026-06-23 05:51:35');
/*!40000 ALTER TABLE `penilaian_naskah_gk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_presentasi_gk`
--

DROP TABLE IF EXISTS `penilaian_presentasi_gk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian_presentasi_gk` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `rubrik_presentasi_gk_id` bigint unsigned NOT NULL,
  `nilai_input` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `rubrik_presentasi_gk_id` (`rubrik_presentasi_gk_id`),
  CONSTRAINT `penilaian_presentasi_gk_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_presentasi_gk_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_presentasi_gk_ibfk_3` FOREIGN KEY (`rubrik_presentasi_gk_id`) REFERENCES `rubrik_presentasi_gks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_presentasi_gk`
--

LOCK TABLES `penilaian_presentasi_gk` WRITE;
/*!40000 ALTER TABLE `penilaian_presentasi_gk` DISABLE KEYS */;
INSERT INTO `penilaian_presentasi_gk` VALUES (7,3,2,1,61,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(8,3,2,2,75,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(9,3,2,3,95,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(10,3,2,4,74,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(11,3,2,5,77,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(12,3,2,6,100,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(13,3,3,1,88,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(14,3,3,2,85,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(15,3,3,3,86,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(16,3,3,4,82,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(17,3,3,5,71,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(18,3,3,6,81,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(19,3,4,1,79,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(20,3,4,2,70,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(21,3,4,3,75,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(22,3,4,4,96,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(23,3,4,5,79,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(24,3,4,6,76,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(37,4,2,1,100,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(38,4,2,2,82,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(39,4,2,3,67,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(40,4,2,4,65,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(41,4,2,5,84,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(42,4,2,6,81,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(43,4,3,1,92,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(44,4,3,2,78,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(45,4,3,3,98,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(46,4,3,4,99,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(47,4,3,5,63,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(48,4,3,6,79,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(49,4,4,1,85,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(50,4,4,2,70,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(51,4,4,3,94,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(52,4,4,4,82,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(53,4,4,5,69,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(54,4,4,6,67,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(67,5,2,1,97,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(68,5,2,2,75,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(69,5,2,3,75,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(70,5,2,4,88,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(71,5,2,5,79,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(72,5,2,6,70,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(73,5,3,1,83,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(74,5,3,2,76,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(75,5,3,3,82,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(76,5,3,4,89,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(77,5,3,5,66,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(78,5,3,6,82,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(79,5,4,1,85,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(80,5,4,2,88,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(81,5,4,3,98,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(82,5,4,4,100,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(83,5,4,5,61,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(84,5,4,6,63,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(91,3,7,7,75,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(92,3,7,8,99,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(93,3,7,9,86,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(94,3,7,10,85,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(95,3,7,11,82,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(96,3,7,12,68,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(97,3,8,7,92,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(98,3,8,8,82,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(99,3,8,9,65,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(100,3,8,10,75,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(101,3,8,11,90,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(102,3,8,12,94,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(103,3,9,7,67,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(104,3,9,8,61,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(105,3,9,9,90,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(106,3,9,10,80,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(107,3,9,11,95,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(108,3,9,12,82,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(109,3,10,7,91,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(110,3,10,8,88,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(111,3,10,9,92,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(112,3,10,10,98,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(113,3,10,11,88,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(114,3,10,12,65,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(115,3,11,7,62,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(116,3,11,8,93,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(117,3,11,9,60,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(118,3,11,10,85,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(119,3,11,11,91,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(120,3,11,12,71,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(121,4,7,7,64,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(122,4,7,8,70,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(123,4,7,9,67,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(124,4,7,10,78,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(125,4,7,11,85,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(126,4,7,12,98,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(127,4,8,7,76,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(128,4,8,8,78,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(129,4,8,9,94,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(130,4,8,10,83,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(131,4,8,11,74,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(132,4,8,12,73,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(133,4,9,7,91,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(134,4,9,8,84,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(135,4,9,9,85,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(136,4,9,10,79,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(137,4,9,11,98,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(138,4,9,12,65,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(139,4,10,7,88,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(140,4,10,8,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(141,4,10,9,96,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(142,4,10,10,93,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(143,4,10,11,64,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(144,4,10,12,94,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(145,4,11,7,66,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(146,4,11,8,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(147,4,11,9,74,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(148,4,11,10,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(149,4,11,11,60,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(150,4,11,12,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(151,5,7,7,86,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(152,5,7,8,95,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(153,5,7,9,67,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(154,5,7,10,64,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(155,5,7,11,72,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(156,5,7,12,79,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(157,5,8,7,72,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(158,5,8,8,92,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(159,5,8,9,87,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(160,5,8,10,60,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(161,5,8,11,96,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(162,5,8,12,92,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(163,5,9,7,91,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(164,5,9,8,92,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(165,5,9,9,100,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(166,5,9,10,86,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(167,5,9,11,60,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(168,5,9,12,60,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(169,5,10,7,99,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(170,5,10,8,80,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(171,5,10,9,96,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(172,5,10,10,100,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(173,5,10,11,75,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(174,5,10,12,99,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(175,5,11,7,91,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(176,5,11,8,82,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(177,5,11,9,81,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(178,5,11,10,86,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(179,5,11,11,93,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(180,5,11,12,62,'2026-06-23 05:51:35','2026-06-23 05:51:35');
/*!40000 ALTER TABLE `penilaian_presentasi_gk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penilaian_wawancara_cu`
--

DROP TABLE IF EXISTS `penilaian_wawancara_cu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penilaian_wawancara_cu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `rubrik_wawancara_cu_id` bigint unsigned NOT NULL,
  `nilai_input` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `rubrik_wawancara_cu_id` (`rubrik_wawancara_cu_id`),
  CONSTRAINT `penilaian_wawancara_cu_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_wawancara_cu_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penilaian_wawancara_cu_ibfk_3` FOREIGN KEY (`rubrik_wawancara_cu_id`) REFERENCES `rubrik_wawancara_cu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penilaian_wawancara_cu`
--

LOCK TABLES `penilaian_wawancara_cu` WRITE;
/*!40000 ALTER TABLE `penilaian_wawancara_cu` DISABLE KEYS */;
INSERT INTO `penilaian_wawancara_cu` VALUES (4,3,2,1,77,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(5,3,2,2,86,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(6,3,2,3,84,'2026-06-04 08:14:39','2026-06-23 05:51:26'),(7,3,3,1,92,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(8,3,3,2,63,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(9,3,3,3,70,'2026-06-04 08:20:27','2026-06-23 05:51:27'),(10,3,4,1,82,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(11,3,4,2,75,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(12,3,4,3,62,'2026-06-04 08:27:13','2026-06-23 05:51:27'),(19,4,2,1,94,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(20,4,2,2,94,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(21,4,2,3,66,'2026-06-04 09:07:16','2026-06-23 05:51:30'),(22,4,3,1,98,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(23,4,3,2,62,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(24,4,3,3,69,'2026-06-04 09:11:18','2026-06-23 05:51:30'),(25,4,4,1,82,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(26,4,4,2,84,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(27,4,4,3,68,'2026-06-04 09:48:49','2026-06-23 05:51:30'),(34,5,2,1,74,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(35,5,2,2,87,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(36,5,2,3,85,'2026-06-04 10:06:03','2026-06-23 05:51:33'),(37,5,3,1,92,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(38,5,3,2,98,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(39,5,3,3,63,'2026-06-04 10:08:18','2026-06-23 05:51:33'),(40,5,4,1,100,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(41,5,4,2,67,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(42,5,4,3,93,'2026-06-04 10:10:40','2026-06-23 05:51:33'),(46,3,7,4,78,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(47,3,7,5,74,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(48,3,7,6,97,'2026-06-23 02:30:44','2026-06-23 05:51:28'),(49,3,8,4,98,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(50,3,8,5,91,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(51,3,8,6,95,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(52,3,9,4,61,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(53,3,9,5,90,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(54,3,9,6,85,'2026-06-23 05:51:28','2026-06-23 05:51:28'),(55,3,10,4,61,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(56,3,10,5,75,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(57,3,10,6,81,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(58,3,11,4,88,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(59,3,11,5,91,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(60,3,11,6,86,'2026-06-23 05:51:29','2026-06-23 05:51:29'),(61,4,7,4,64,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(62,4,7,5,61,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(63,4,7,6,66,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(64,4,8,4,77,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(65,4,8,5,64,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(66,4,8,6,95,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(67,4,9,4,80,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(68,4,9,5,93,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(69,4,9,6,75,'2026-06-23 05:51:31','2026-06-23 05:51:31'),(70,4,10,4,76,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(71,4,10,5,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(72,4,10,6,68,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(73,4,11,4,65,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(74,4,11,5,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(75,4,11,6,95,'2026-06-23 05:51:32','2026-06-23 05:51:32'),(76,5,7,4,100,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(77,5,7,5,86,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(78,5,7,6,87,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(79,5,8,4,82,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(80,5,8,5,95,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(81,5,8,6,79,'2026-06-23 05:51:34','2026-06-23 05:51:34'),(82,5,9,4,90,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(83,5,9,5,96,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(84,5,9,6,86,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(85,5,10,4,60,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(86,5,10,5,82,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(87,5,10,6,87,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(88,5,11,4,86,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(89,5,11,5,68,'2026-06-23 05:51:35','2026-06-23 05:51:35'),(90,5,11,6,93,'2026-06-23 05:51:35','2026-06-23 05:51:35');
/*!40000 ALTER TABLE `penilaian_wawancara_cu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penugasan_juri`
--

DROP TABLE IF EXISTS `penugasan_juri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penugasan_juri` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `juri_id` bigint unsigned NOT NULL,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `surat_penugasan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `juri_id` (`juri_id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  CONSTRAINT `penugasan_juri_ibfk_1` FOREIGN KEY (`juri_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `penugasan_juri_ibfk_2` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penugasan_juri`
--

LOCK TABLES `penugasan_juri` WRITE;
/*!40000 ALTER TABLE `penugasan_juri` DISABLE KEYS */;
INSERT INTO `penugasan_juri` VALUES (4,3,2,NULL,'2026-06-03 06:20:16','2026-06-03 06:20:16'),(5,4,2,NULL,'2026-06-03 06:20:16','2026-06-03 06:20:16'),(6,5,2,NULL,'2026-06-03 06:20:16','2026-06-03 06:20:16'),(7,3,3,NULL,'2026-06-03 06:20:57','2026-06-03 06:20:57'),(8,4,3,NULL,'2026-06-03 06:20:58','2026-06-03 06:20:58'),(9,5,3,NULL,'2026-06-03 06:20:58','2026-06-03 06:20:58'),(10,3,4,NULL,'2026-06-03 06:21:42','2026-06-03 06:21:42'),(11,4,4,NULL,'2026-06-03 06:21:42','2026-06-03 06:21:42'),(12,5,4,NULL,'2026-06-03 06:21:42','2026-06-03 06:21:42'),(16,3,7,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(17,4,7,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(18,5,7,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(19,3,8,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(20,4,8,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(21,5,8,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(22,3,9,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(23,4,9,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(24,5,9,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(25,3,10,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(26,4,10,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(27,5,10,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(28,3,11,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(29,4,11,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(30,5,11,NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(31,3,12,NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(32,4,12,NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(33,5,12,NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(34,3,13,NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(35,4,13,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(36,5,13,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(37,3,14,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(38,4,14,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(39,5,14,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(40,3,15,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(41,4,15,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(42,5,15,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(43,3,16,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(44,4,16,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(45,5,16,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(46,3,17,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(47,4,17,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(48,5,17,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(49,3,18,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(50,4,18,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(51,5,18,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(52,3,19,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(53,4,19,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(54,5,19,NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(55,3,20,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(56,4,20,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(57,5,20,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(58,3,21,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(59,4,21,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(60,5,21,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(61,3,22,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(62,4,22,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(63,5,22,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(64,3,23,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(65,4,23,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(66,5,23,NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00');
/*!40000 ALTER TABLE `penugasan_juri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persyaratan`
--

DROP TABLE IF EXISTS `persyaratan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persyaratan` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned DEFAULT NULL,
  `nama_syarat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `is_required` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `persyaratan_jenjang_id_foreign` (`jenjang_id`),
  CONSTRAINT `persyaratan_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persyaratan`
--

LOCK TABLES `persyaratan` WRITE;
/*!40000 ALTER TABLE `persyaratan` DISABLE KEYS */;
INSERT INTO `persyaratan` VALUES (1,NULL,'KTM (Kartu Tanda Mahasiswa)','Scan KTM asli berwarna.',1,'2026-05-26 08:46:50','2026-05-26 08:46:50'),(2,NULL,'Sertifikat Prestasi (Unggulan)','Gabungkan maksimal 10 sertifikat terbaik dalam 1 file PDF.',1,'2026-05-26 08:46:50','2026-05-26 08:46:50'),(3,NULL,'Naskah Gagasan Kreatif','Format PDF sesuai template yang disediakan.',1,'2026-05-26 08:46:50','2026-05-26 08:46:50'),(4,NULL,'Surat Rekomendasi Dekan','Surat pernyataan dari pimpinan fakultas.',1,'2026-05-26 08:46:50','2026-06-23 01:00:57');
/*!40000 ALTER TABLE `persyaratan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portofolio_cu`
--

DROP TABLE IF EXISTS `portofolio_cu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `portofolio_cu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `rubrik_cu_id` bigint unsigned NOT NULL,
  `kategori_jenjang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_prestasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pelaksanaan` date NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_validasi` enum('Pending','Valid','Tidak Valid') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `skor_rekomendasi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `rubrik_cu_id` (`rubrik_cu_id`),
  CONSTRAINT `portofolio_cu_ibfk_1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `portofolio_cu_ibfk_2` FOREIGN KEY (`rubrik_cu_id`) REFERENCES `rubrik_capaian_unggulans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portofolio_cu`
--

LOCK TABLES `portofolio_cu` WRITE;
/*!40000 ALTER TABLE `portofolio_cu` DISABLE KEYS */;
INSERT INTO `portofolio_cu` VALUES (4,2,1,'Regional','JUARA 1 LOMBA MENARI','UM Metro','2026-05-29','portofolio/2/SNB6ltRjdYK4O0A8z08dgm7dM7tF85HFsK3I9TW9.pdf','Valid','30-40','2026-05-30 01:28:52','2026-06-03 06:19:58'),(6,2,2,'Internasional','JUARA 2 LOMBA MENARI','UM Metro','2026-05-29','portofolio/2/eeVskhnybuEjybvblkcbhsnD9iOcOHlmq8Lq4dHX.pdf','Valid','35-45','2026-05-30 01:30:23','2026-06-03 06:20:00'),(7,2,23,'Kab/Kota/PT','Sekretaris Himprosik','UM Metro','2026-05-02','portofolio/2/SSfTkFwbrlsPmL9X7LziGvIx8zUpFgLee8RjSREV.pdf','Valid','6','2026-05-30 01:31:19','2026-06-03 06:20:03'),(8,3,5,'Regional','JUARA 1 SENI BELADIRI','UM Metro','2024-10-22','portofolio/3/yCQ8oy0RTahRFwzgPaGUNVxuF7mA6op8Uw3fcut4.pdf','Valid','20-30','2026-06-03 05:53:27','2026-06-03 06:20:40'),(9,3,2,'Regional','JUAR 2 DESIGN GRAFIS','U','2025-11-12','portofolio/3/HBcqrCNOyg2KBSgoluMQRejsgUDwZgAcSdoqzK4d.pdf','Valid','25-35','2026-06-03 05:54:18','2026-06-03 06:20:42'),(10,3,3,'Provinsi','JUARA 3 DESAIN POSTER','UM','2022-11-11','portofolio/3/a6DV9wVKrHK5B8EXcXyig21vvr8kdSsH9VygVBLd.pdf','Valid','10','2026-06-03 05:55:13','2026-06-03 06:20:42'),(11,4,2,'Internasional','JUARA  2 DESIGN BANGUNAN','IT','2023-02-11','portofolio/4/InOEWcE2h4fCxj4MbX7z9q1V5JSLxNemonq4FbLS.pdf','Valid','35-45','2026-06-03 06:07:24','2026-06-03 06:21:24'),(12,4,3,'Nasional','JUARA 3 DESIGN ARSITEKTUR','TU','2025-10-10','portofolio/4/cmaKodCJpF9wgi04NBMz3SB5PreI2cOBESzEylOT.pdf','Valid','10-20','2026-06-03 06:08:17','2026-06-03 06:21:26'),(13,4,1,'Kab/Kota/PT','JUARA 1 RHXGHH','UM','2024-03-03','portofolio/4/Mf6AnP7aHnyfIglLRFzQ74xWXydgtMEU5dKoElz7.pdf','Valid',NULL,'2026-06-03 06:09:01','2026-06-03 06:21:28');
/*!40000 ALTER TABLE `portofolio_cu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program_studi`
--

DROP TABLE IF EXISTS `program_studi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program_studi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `program_studi_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program_studi`
--

LOCK TABLES `program_studi` WRITE;
/*!40000 ALTER TABLE `program_studi` DISABLE KEYS */;
INSERT INTO `program_studi` VALUES (1,'52','Teknik Mesin','2026-06-23 16:21:24','2026-06-23 16:21:24'),(2,'51','Teknik Sipil','2026-06-23 16:21:24','2026-06-23 16:21:24'),(3,'43','Ilmu Komputer','2026-06-23 16:21:24','2026-06-23 16:21:24'),(4,'11','Pendidikan Ekonomi','2026-06-23 16:21:24','2026-06-23 16:21:24'),(5,'21','Pendidikan Matematika','2026-06-23 16:21:24','2026-06-23 16:21:24'),(6,'71','Akuntansi','2026-06-23 16:21:24','2026-06-23 16:21:24'),(7,'72','Manajemen','2026-06-23 16:21:24','2026-06-23 16:21:24'),(8,'61','Ilmu Hukum','2026-06-23 16:21:24','2026-06-23 16:21:24'),(9,'18','Pendidikan Teknologi Informasi','2026-06-23 16:21:24','2026-06-23 16:21:24');
/*!40000 ALTER TABLE `program_studi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekap_tahap_1`
--

DROP TABLE IF EXISTS `rekap_tahap_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekap_tahap_1` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pendaftaran_id` bigint unsigned NOT NULL,
  `status_laporan` enum('Pending','Divalidasi') COLLATE utf8mb4_unicode_ci DEFAULT 'Pending',
  `divalidasi_oleh` bigint unsigned DEFAULT NULL,
  `tanggal_validasi` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pendaftaran_id` (`pendaftaran_id`),
  KEY `divalidasi_oleh` (`divalidasi_oleh`),
  CONSTRAINT `rekap_tahap_1_ibfk_1` FOREIGN KEY (`pendaftaran_id`) REFERENCES `pendaftaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rekap_tahap_1_ibfk_2` FOREIGN KEY (`divalidasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekap_tahap_1`
--

LOCK TABLES `rekap_tahap_1` WRITE;
/*!40000 ALTER TABLE `rekap_tahap_1` DISABLE KEYS */;
INSERT INTO `rekap_tahap_1` VALUES (2,2,'Divalidasi',2,'2026-06-05 01:50:04','2026-06-03 06:20:09','2026-06-04 18:50:04'),(3,3,'Divalidasi',2,'2026-06-05 01:50:02','2026-06-03 06:20:52','2026-06-04 18:50:02'),(4,4,'Divalidasi',2,'2026-06-05 01:50:00','2026-06-03 06:21:35','2026-06-04 18:50:00');
/*!40000 ALTER TABLE `rekap_tahap_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_bahasa_inggris`
--

DROP TABLE IF EXISTS `rubrik_bahasa_inggris`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_bahasa_inggris` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excellent_score` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excellent_criteria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `good_score` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `good_criteria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fair_score` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fair_criteria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `poor_score` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poor_criteria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kriteria_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_bahasa_inggris_jenjang_id_foreign` (`jenjang_id`),
  KEY `rubrik_bahasa_inggris_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `rubrik_bahasa_inggris_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rubrik_bahasa_inggris_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_bahasa_inggris`
--

LOCK TABLES `rubrik_bahasa_inggris` WRITE;
/*!40000 ALTER TABLE `rubrik_bahasa_inggris` DISABLE KEYS */;
INSERT INTO `rubrik_bahasa_inggris` VALUES (1,1,'Bahasa Inggris','CONTENT','25-22','Demonstration of excellent mastery of the topic and comprehensive elaboration - demonstrate comprehensive thorough analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.','21-18','Demonstration of good mastery of the topic and give most supportive details- demonstrate limited analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.','17-11','Demonstration of fair mastery of the topic with some missing supportive details- demonstrate limited analysis of the problem(s)','10-5','Demonstration of inadequate mastery of the topic with only few important details given.','2026-05-26 08:46:50','2026-07-01 16:23:39',3),(2,1,'Bahasa Inggris','ACCURACY','25-22','Excellent mastery of grammar and vocabulary with all appropriate choice of expressions/ register','21-18','Good mastery of grammar and vocabulary with mostly appropriate choice of expressions/ register','17-11','Fair mastery of grammar and vocabulary, with occasional inappropriate choice of expressions/ register.','10-5','Inadequate mastery of grammar and vocabulary, with frequent inappropriate choice of expressions/ register.','2026-05-26 08:46:50','2026-07-01 16:23:39',3),(3,1,'Bahasa Inggris','FLUENCY & PRONUNCIATION','20-16','Speech is very fluent, no unnatural pauses; with always intelligible and clear pronunciation as well as excellent rhythm and stress pattern','15-11','Speech is mostly fluent, a few unnatural pauses; with mostly intelligible and clear pronunciation as well as good rhythm and stress pattern','10-8','Speech is frequently halted; frequent unnatural pauses, with fairly intelligible and clear pronunciation but with some incorrect rhythm and stress pattern','7-5','Speech is jerky with poor and unclear pronunciation and incorrect rhythm and stress pattern','2026-05-26 08:46:50','2026-07-01 16:23:39',3),(4,1,'Bahasa Inggris','COMPREHENSION & RESPONSE','20-16','Excellent ability to comprehend the topic discussed and to answer all the questions raised','15-11','Good ability to comprehend the topic discussed and answer most of the questions raised','10-8','Fair ability to comprehend the topic discussed and to answer some of the questions raised','7-5','Poor ability to comprehend the topic discussed and to answer few of the questions raised','2026-05-26 08:46:50','2026-07-01 16:23:39',3),(5,1,'Bahasa Inggris','OVERALL PERFORMANCE','10-9','Very clear delivery of ideas; very active contributions to discussion; high respect and interest for others\' viewpoints','8-7','Clear delivery of ideas; active contributions to discussion; respect and interest for others\' viewpoints','6-5','Fairly clear delivery of ideas, some contributions to discussion, little respect/interest for others\' viewpoints','4-3','Unclear delivery of ideas, little contribution to discussion, some evidence of disrespect/disinterest for others\' viewpoint','2026-05-26 08:46:50','2026-07-01 16:23:39',3),(6,2,'Bahasa Inggris','CONTENT','25-22','Demonstration of excellent mastery of the topic and comprehensive elaboration - demonstrate comprehensive thorough analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.','21-18','Demonstration of good mastery of the topic and give most supportive details- demonstrate limited analysis and evaluation of the problem(s) and create solution(s) - relevant to assigned topic.','17-11','Demonstration of fair mastery of the topic with some missing supportive details- demonstrate limited analysis of the problem(s)','10-5','Demonstration of inadequate mastery of the topic with only few important details given.','2026-06-22 08:02:16','2026-07-01 16:23:39',9),(7,2,'Bahasa Inggris','ACCURACY','25-22','Excellent mastery of grammar and vocabulary with all appropriate choice of expressions/ register','21-18','Good mastery of grammar and vocabulary with mostly appropriate choice of expressions/ register','17-11','Fair mastery of grammar and vocabulary, with occasional inappropriate choice of expressions/ register.','10-5','Inadequate mastery of grammar and vocabulary, with frequent inappropriate choice of expressions/ register.','2026-06-22 08:02:16','2026-07-01 16:23:39',9),(8,2,'Bahasa Inggris','FLUENCY & PRONUNCIATION','20-16','Speech is very fluent, no unnatural pauses; with always intelligible and clear pronunciation as well as excellent rhythm and stress pattern','15-11','Speech is mostly fluent, a few unnatural pauses; with mostly intelligible and clear pronunciation as well as good rhythm and stress pattern','10-8','Speech is frequently halted; frequent unnatural pauses, with fairly intelligible and clear pronunciation but with some incorrect rhythm and stress pattern','7-5','Speech is jerky with poor and unclear pronunciation and incorrect rhythm and stress pattern','2026-06-22 08:02:16','2026-07-01 16:23:39',9),(9,2,'Bahasa Inggris','COMPREHENSION & RESPONSE','20-16','Excellent ability to comprehend the topic discussed and to answer all the questions raised','15-11','Good ability to comprehend the topic discussed and answer most of the questions raised','10-8','Fair ability to comprehend the topic discussed and to answer some of the questions raised','7-5','Poor ability to comprehend the topic discussed and to answer few of the questions raised','2026-06-22 08:02:16','2026-07-01 16:23:39',9),(10,2,'Bahasa Inggris','OVERALL PERFORMANCE','10-9','Very clear delivery of ideas; very active contributions to discussion; high respect and interest for others\' viewpoints','8-7','Clear delivery of ideas; active contributions to discussion; respect and interest for others\' viewpoints','6-5','Fairly clear delivery of ideas, some contributions to discussion, little respect/interest for others\' viewpoints','4-3','Unclear delivery of ideas, little contribution to discussion, some evidence of disrespect/disinterest for others\' viewpoint','2026-06-22 08:02:16','2026-07-01 16:23:39',9);
/*!40000 ALTER TABLE `rubrik_bahasa_inggris` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_capaian_unggulans`
--

DROP TABLE IF EXISTS `rubrik_capaian_unggulans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_capaian_unggulans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL DEFAULT '1',
  `bidang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wujud_capaian_unggulan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_internasional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skor_internasional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_regional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skor_regional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_nasional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skor_nasional` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_provinsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skor_provinsi` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_kab_kota` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skor_kab_kota` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kriteria_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_capaian_unggulans_jenjang_id_foreign` (`jenjang_id`),
  KEY `rubrik_capaian_unggulans_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `rubrik_capaian_unggulans_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rubrik_capaian_unggulans_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_capaian_unggulans`
--

LOCK TABLES `rubrik_capaian_unggulans` WRITE;
/*!40000 ALTER TABLE `rubrik_capaian_unggulans` DISABLE KEYS */;
INSERT INTO `rubrik_capaian_unggulans` VALUES (1,1,'Kompetisi','Juara-1 Perorangan','1A1','40-50','1B1','30-40','1C1','20-30','1D1','20',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(2,1,'Kompetisi','Juara-2 Perorangan','1A2','35-45','1B2','25-35','1C2','15-25','1D2','15',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(3,1,'Kompetisi','Juara-3 Perorangan','1A3','30-40','1B3','20-30','1C3','10-20','1D3','10',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(4,1,'Kompetisi','Juara Kategori Perorangan','1A4','24-32','1B4','16-24','1C4','8-16','1D4','8',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(5,1,'Kompetisi','Juara-1 Beregu','1A5','30-40','1B5','20-30','1C5','10-20','1D5','10',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(6,1,'Kompetisi','Juara-2 Beregu','1A6','25-35','1B6','15-25','1C6','7-15','1D6','7',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(7,1,'Kompetisi','Juara-3 Beregu','1A7','20-30','1B7','10-20','1C7','6-10','1D7','6',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(8,1,'Kompetisi','Juara Kategori Beregu','1A8','16-24','1B8','10-16','1C8','5-10','1D8','5',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(9,1,'Pengakuan','Pelatih/Wasit/Juri berlisensi','2A1','50','2B1','40','2C1','30','2D1','20',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(10,1,'Pengakuan','Pelatih/Wasit/Juri tidak berlisensi','2A2','25','2B2','20','2C2','15','2D2','10',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(11,1,'Pengakuan','Narasumber / pembicara','2A4','25','2B4','20','2C4','15','2D4','10',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(12,1,'Pengakuan','Moderator','2A5','20','2B5','15','2C5','10','2D5','5',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(13,1,'Pengakuan','Lainnya','2A6','20','2B6','15','2C6','10','2D6','5',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(14,1,'Penghargaan','Tanda Jasa','3A1','50','3B1','40','3C1','30','3D1','20',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(15,1,'Penghargaan','Penerima Hibah kompetisi','3A6','40','3B6','30','3C6','20','3D6','10',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(16,1,'Penghargaan','(grand final, peraih medali emas berdasar nilai batas)','3A2','30','3B2','20','3C2','10','3D2','5',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(17,1,'Penghargaan','(grand final, peraih medali perak berdasar nilai batas)','3A3','25','3B3','15','3C3','7','3D3','3',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(18,1,'Penghargaan','(grand final, peraih medali perunggu berdasar nilai batas)','3A4','20','3B4','10','3C4','5','3D4','2',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(19,1,'Penghargaan','Piagam Partisipasi','3A5','10','3B5','5','3C5','3','3D5','1',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(20,1,'Penghargaan','Lainnya','3A7','10','3B7','5','3C7','3','3D7','1',NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(21,1,'Karir Organisasi','Ketua','4A1','50','4B1','40','4C1','30','4D1','20','4E1','10','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(22,1,'Karir Organisasi','Wakil Ketua','4A2','45','4B2','35','4C2','25','4D2','15','4E2','8','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(23,1,'Karir Organisasi','Sekretaris','4A3','40','4B3','30','4C3','20','4D3','10','4E3','6','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(24,1,'Karir Organisasi','Bendahara','4A4','40','4B4','30','4C4','20','4D4','10','4E4','6','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(25,1,'Hasil Karya','Patent',NULL,NULL,NULL,NULL,'5C1','40-50*',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(26,1,'Hasil Karya','Patent Sederhana',NULL,NULL,NULL,NULL,'5C2','10-30*',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(27,1,'Hasil Karya','Hak Cipta',NULL,NULL,NULL,NULL,'5C3','10-30*',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(28,1,'Hasil Karya','Buku ber-ISBN penulis utama',NULL,NULL,NULL,NULL,'5C4','30',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(29,1,'Hasil Karya','Buku ber-ISBN penulis kedua dst',NULL,NULL,NULL,NULL,'5C5','20/x',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(30,1,'Hasil Karya','Penulis Utama/korespondensi karya ilmiah di journal yg bereputasi dan diakui','5A6','30-40*',NULL,NULL,'5C6','10-30*',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(31,1,'Hasil Karya','Penulis kedua (bukan korespondensi) dst karya ilmiah di journal yg bereputasi dan diakui','5A7','30-40* / X',NULL,NULL,'5C7','10-20* / X',NULL,NULL,NULL,NULL,'2026-05-26 08:46:50','2026-07-01 16:23:39',1),(32,1,'Pemberdayaan atau Aksi Kemanusiaan','Pemrakarsa / Pendiri','6A1','50','6B1','40','6C1','30','6D1','20','6E1','10','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(33,1,'Pemberdayaan atau Aksi Kemanusiaan','Koordinator Relawan','6A2','35','6B2','25','6C2','15','6D2','10','6E2','5','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(34,1,'Pemberdayaan atau Aksi Kemanusiaan','Relawan','6A3','25','6B3','15','6C3','10','6D3','5','6E3','3','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(35,1,'Kewirausahaan','Kewirausahaan','7A1','50','7B1','40','7C1','30','7D1','20','7E1','10','2026-05-26 08:46:50','2026-07-01 16:23:39',1),(36,2,'Kompetisi','Juara-1 Perorangan','1A1','40-50','1B1','30-40','1C1','20-30','1D1','20',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(37,2,'Kompetisi','Juara-2 Perorangan','1A2','35-45','1B2','25-35','1C2','15-25','1D2','15',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(38,2,'Kompetisi','Juara-3 Perorangan','1A3','30-40','1B3','20-30','1C3','10-20','1D3','10',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(39,2,'Kompetisi','Juara Kategori Perorangan','1A4','24-32','1B4','16-24','1C4','8-16','1D4','8',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(40,2,'Kompetisi','Juara-1 Beregu','1A5','30-40','1B5','20-30','1C5','10-20','1D5','10',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(41,2,'Kompetisi','Juara-2 Beregu','1A6','25-35','1B6','15-25','1C6','7-15','1D6','7',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(42,2,'Kompetisi','Juara-3 Beregu','1A7','20-30','1B7','10-20','1C7','6-10','1D7','6',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(43,2,'Kompetisi','Juara Kategori Beregu','1A8','16-24','1B8','10-16','1C8','5-10','1D8','5',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(44,2,'Pengakuan','Pelatih/Wasit/Juri berlisensi','2A1','50','2B1','40','2C1','30','2D1','20',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(45,2,'Pengakuan','Pelatih/Wasit/Juri tidak berlisensi','2A2','25','2B2','20','2C2','15','2D2','10',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(46,2,'Pengakuan','Narasumber / pembicara','2A4','25','2B4','20','2C4','15','2D4','10',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(47,2,'Pengakuan','Moderator','2A5','20','2B5','15','2C5','10','2D5','5',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(48,2,'Pengakuan','Lainnya','2A6','20','2B6','15','2C6','10','2D6','5',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(49,2,'Penghargaan','Tanda Jasa','3A1','50','3B1','40','3C1','30','3D1','20',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(50,2,'Penghargaan','Penerima Hibah kompetisi','3A6','40','3B6','30','3C6','20','3D6','10',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(51,2,'Penghargaan','(grand final, peraih medali emas berdasar nilai batas)','3A2','30','3B2','20','3C2','10','3D2','5',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(52,2,'Penghargaan','(grand final, peraih medali perak berdasar nilai batas)','3A3','25','3B3','15','3C3','7','3D3','3',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:39',7),(53,2,'Penghargaan','(grand final, peraih medali perunggu berdasar nilai batas)','3A4','20','3B4','10','3C4','5','3D4','2',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(54,2,'Penghargaan','Piagam Partisipasi','3A5','10','3B5','5','3C5','3','3D5','1',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(55,2,'Penghargaan','Lainnya','3A7','10','3B7','5','3C7','3','3D7','1',NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(56,2,'Karir Organisasi','Ketua','4A1','50','4B1','40','4C1','30','4D1','20','4E1','10','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(57,2,'Karir Organisasi','Wakil Ketua','4A2','45','4B2','35','4C2','25','4D2','15','4E2','8','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(58,2,'Karir Organisasi','Sekretaris','4A3','40','4B3','30','4C3','20','4D3','10','4E3','6','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(59,2,'Karir Organisasi','Bendahara','4A4','40','4B4','30','4C4','20','4D4','10','4E4','6','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(60,2,'Hasil Karya','Patent',NULL,NULL,NULL,NULL,'5C1','40-50*',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(61,2,'Hasil Karya','Patent Sederhana',NULL,NULL,NULL,NULL,'5C2','10-30*',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(62,2,'Hasil Karya','Hak Cipta',NULL,NULL,NULL,NULL,'5C3','10-30*',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(63,2,'Hasil Karya','Buku ber-ISBN penulis utama',NULL,NULL,NULL,NULL,'5C4','30',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(64,2,'Hasil Karya','Buku ber-ISBN penulis kedua dst',NULL,NULL,NULL,NULL,'5C5','20/x',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(65,2,'Hasil Karya','Penulis Utama/korespondensi karya ilmiah di journal yg bereputasi dan diakui','5A6','30-40*',NULL,NULL,'5C6','10-30*',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(66,2,'Hasil Karya','Penulis kedua (bukan korespondensi) dst karya ilmiah di journal yg bereputasi dan diakui','5A7','30-40* / X',NULL,NULL,'5C7','10-20* / X',NULL,NULL,NULL,NULL,'2026-06-22 08:02:16','2026-07-01 16:23:40',7),(67,2,'Pemberdayaan atau Aksi Kemanusiaan','Pemrakarsa / Pendiri','6A1','50','6B1','40','6C1','30','6D1','20','6E1','10','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(68,2,'Pemberdayaan atau Aksi Kemanusiaan','Koordinator Relawan','6A2','35','6B2','25','6C2','15','6D2','10','6E2','5','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(69,2,'Pemberdayaan atau Aksi Kemanusiaan','Relawan','6A3','25','6B3','15','6C3','10','6D3','5','6E3','3','2026-06-22 08:02:16','2026-07-01 16:23:40',7),(70,2,'Kewirausahaan','Kewirausahaan','7A1','50','7B1','40','7C1','30','7D1','20','7E1','10','2026-06-22 08:02:16','2026-07-01 16:23:40',7);
/*!40000 ALTER TABLE `rubrik_capaian_unggulans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_custom_template_fields`
--

DROP TABLE IF EXISTS `rubrik_custom_template_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_custom_template_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `template_id` bigint unsigned NOT NULL,
  `nama_field` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe_input` enum('text','number','textarea','score_range') COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int NOT NULL DEFAULT '0',
  `bobot` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_custom_template_fields_template_id_foreign` (`template_id`),
  CONSTRAINT `rubrik_custom_template_fields_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `rubrik_custom_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_custom_template_fields`
--

LOCK TABLES `rubrik_custom_template_fields` WRITE;
/*!40000 ALTER TABLE `rubrik_custom_template_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `rubrik_custom_template_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_custom_templates`
--

DROP TABLE IF EXISTS `rubrik_custom_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_custom_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_custom_templates`
--

LOCK TABLES `rubrik_custom_templates` WRITE;
/*!40000 ALTER TABLE `rubrik_custom_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `rubrik_custom_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_naskah_gks`
--

DROP TABLE IF EXISTS `rubrik_naskah_gks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_naskah_gks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aspek_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kriteria_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kriteria_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_naskah_gks_jenjang_id_foreign` (`jenjang_id`),
  KEY `rubrik_naskah_gks_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `rubrik_naskah_gks_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rubrik_naskah_gks_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_naskah_gks`
--

LOCK TABLES `rubrik_naskah_gks` WRITE;
/*!40000 ALTER TABLE `rubrik_naskah_gks` DISABLE KEYS */;
INSERT INTO `rubrik_naskah_gks` VALUES (1,1,'Naskah GK','Penyajian Gagasan Kreatif','Penggunaan bahasa Indonesia yang baik dan benar',5,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(2,1,'Naskah GK','Penyajian Gagasan Kreatif','Kesesuaian pengutipan dan pengacuan dengan kaidah/standar yang berlaku',5,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(3,1,'Naskah GK','Substansi Gagasan Kreatif','Fakta atau gejala dalam lingkungan yang menarik untuk dikaji',8,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(4,1,'Naskah GK','Substansi Gagasan Kreatif','Identifikasi masalah yang terdapat dalam fakta/gejala dalam lingkungan',8,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(5,1,'Naskah GK','Substansi Gagasan Kreatif','Rumusan masalah sebagai hasil identifikasi masalah',10,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(6,1,'Naskah GK','Substansi Gagasan Kreatif','Uraian mengenai akibat pembiaran yang merugikan lingkungan',8,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(7,1,'Naskah GK','Substansi Gagasan Kreatif','Uraian mengenai solusi yang berciri SMART',15,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(8,1,'Naskah GK','Substansi Gagasan Kreatif','Uraian mengenai dampak lanjutan (efek bola salju) dari pencapaian solusi',8,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(9,1,'Naskah GK','Substansi Gagasan Kreatif','Rincian uraian mengenai langkah-langkah tindakan untuk mencapai solusi',8,'2026-05-26 08:46:50','2026-07-01 16:23:38',2),(10,1,'Naskah GK','Substansi Gagasan Kreatif','Uraian mengenai kendala/hambatan pelaksanaan gagasan dan antisipasinya',5,'2026-05-26 08:46:50','2026-07-01 16:23:39',2),(11,1,'Naskah GK','Kualitas Gagasan Kreatif','Keunikan dan Orisinalitas Gagasan Kreatif',10,'2026-05-26 08:46:50','2026-07-01 16:23:39',2),(12,1,'Naskah GK','Kualitas Gagasan Kreatif','Keterlaksanaan Gagasan Kreatif',10,'2026-05-26 08:46:50','2026-07-01 16:23:39',2),(13,2,'Produk Inovatif (PI)','Penyajian Gagasan Kreatif','Penggunaan bahasa Indonesia yang baik dan benar',5,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(14,2,'Produk Inovatif (PI)','Penyajian Gagasan Kreatif','Kesesuaian pengutipan dan pengacuan dengan kaidah/standar yang berlaku',5,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(15,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Fakta atau gejala dalam lingkungan yang menarik untuk dikaji',8,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(16,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Identifikasi masalah yang terdapat dalam fakta/gejala dalam lingkungan',8,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(17,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Rumusan masalah sebagai hasil identifikasi masalah',10,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(18,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Uraian mengenai akibat pembiaran yang merugikan lingkungan',8,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(19,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Uraian mengenai solusi yang berciri SMART',15,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(20,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Uraian mengenai dampak lanjutan (efek bola salju) dari pencapaian solusi',8,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(21,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Rincian uraian mengenai langkah-langkah tindakan untuk mencapai solusi',8,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(22,2,'Produk Inovatif (PI)','Substansi Gagasan Kreatif','Uraian mengenai kendala/hambatan pelaksanaan gagasan dan antisipasinya',5,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(23,2,'Produk Inovatif (PI)','Kualitas Gagasan Kreatif','Keunikan dan Orisinalitas Gagasan Kreatif',10,'2026-06-22 08:02:16','2026-07-01 16:23:39',8),(24,2,'Produk Inovatif (PI)','Kualitas Gagasan Kreatif','Keterlaksanaan Gagasan Kreatif',10,'2026-06-22 08:02:16','2026-07-01 16:23:39',8);
/*!40000 ALTER TABLE `rubrik_naskah_gks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_presentasi_gks`
--

DROP TABLE IF EXISTS `rubrik_presentasi_gks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_presentasi_gks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aspek_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kriteria_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kriteria_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_presentasi_gks_jenjang_id_foreign` (`jenjang_id`),
  KEY `rubrik_presentasi_gks_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `rubrik_presentasi_gks_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rubrik_presentasi_gks_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_presentasi_gks`
--

LOCK TABLES `rubrik_presentasi_gks` WRITE;
/*!40000 ALTER TABLE `rubrik_presentasi_gks` DISABLE KEYS */;
INSERT INTO `rubrik_presentasi_gks` VALUES (1,1,'Presentasi GK','Presentasi Gagasan Kreatif','Poster',15,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(2,1,'Presentasi GK','Presentasi Gagasan Kreatif','Sistematika Penjelasan',15,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(3,1,'Presentasi GK','Presentasi Gagasan Kreatif','Cara menjelaskan',15,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(4,1,'Presentasi GK','Presentasi Gagasan Kreatif','Ketepatan Waktu',5,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(5,1,'Presentasi GK','Tanya Jawab','Ketepatan Jawaban',30,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(6,1,'Presentasi GK','Tanya Jawab','Cara Menjawab',20,'2026-05-26 08:46:50','2026-07-01 16:23:39',5),(7,2,'Presentasi PI','Presentasi Gagasan Kreatif','Poster',15,'2026-06-22 08:02:16','2026-07-01 16:23:39',11),(8,2,'Presentasi PI','Presentasi Gagasan Kreatif','Sistematika Penjelasan',15,'2026-06-22 08:02:16','2026-07-01 16:23:39',11),(9,2,'Presentasi PI','Presentasi Gagasan Kreatif','Cara menjelaskan',15,'2026-06-22 08:02:16','2026-07-01 16:23:39',11),(10,2,'Presentasi PI','Presentasi Gagasan Kreatif','Ketepatan Waktu',5,'2026-06-22 08:02:16','2026-07-01 16:23:39',11),(11,2,'Presentasi PI','Tanya Jawab','Ketepatan Jawaban',30,'2026-06-22 08:02:16','2026-07-01 16:23:39',11),(12,2,'Presentasi PI','Tanya Jawab','Cara Menjawab',20,'2026-06-22 08:02:16','2026-07-01 16:23:39',11);
/*!40000 ALTER TABLE `rubrik_presentasi_gks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rubrik_wawancara_cu`
--

DROP TABLE IF EXISTS `rubrik_wawancara_cu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rubrik_wawancara_cu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jenjang_id` bigint unsigned NOT NULL DEFAULT '1',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kriteria_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `kriteria_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rubrik_wawancara_cu_jenjang_id_foreign` (`jenjang_id`),
  KEY `rubrik_wawancara_cu_kriteria_id_foreign` (`kriteria_id`),
  CONSTRAINT `rubrik_wawancara_cu_jenjang_id_foreign` FOREIGN KEY (`jenjang_id`) REFERENCES `jenjang` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rubrik_wawancara_cu_kriteria_id_foreign` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria_penilaian` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rubrik_wawancara_cu`
--

LOCK TABLES `rubrik_wawancara_cu` WRITE;
/*!40000 ALTER TABLE `rubrik_wawancara_cu` DISABLE KEYS */;
INSERT INTO `rubrik_wawancara_cu` VALUES (1,1,'Wawancara CU','Kemampuan Komunikasi & Presentasi',30,'2026-05-26 08:46:50','2026-07-01 16:23:39',4),(2,1,'Wawancara CU','Penguasaan Materi & Substansi Capaian',40,'2026-05-26 08:46:50','2026-07-01 16:23:39',4),(3,1,'Wawancara CU','Sikap, Kepribadian & Integritas',30,'2026-05-26 08:46:50','2026-07-01 16:23:39',4),(4,2,'Wawancara CU','Kemampuan Komunikasi & Presentasi',30,'2026-06-22 08:02:16','2026-07-01 16:23:39',10),(5,2,'Wawancara CU','Penguasaan Materi & Substansi Capaian',40,'2026-06-22 08:02:16','2026-07-01 16:23:39',10),(6,2,'Wawancara CU','Sikap, Kepribadian & Integritas',30,'2026-06-22 08:02:16','2026-07-01 16:23:39',10),(8,7,'Wawancara Capaian Unggulan','Kemampuan Komunikasi',30,'2026-07-01 15:32:36','2026-07-01 16:23:39',16);
/*!40000 ALTER TABLE `rubrik_wawancara_cu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','wr3','juri','mahasiswa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$12$TERc9ggUEIEqYwojxS82/OYPw1ZpTaU6ZPQPVFIfyMaZ.6RFqt8Y2','Administrator Bid. Kemahasiswaan',NULL,'admin',NULL,'2026-05-26 08:46:50','2026-05-26 01:51:03'),(2,'Eva Rolia','$2y$12$MnqVZ2eMGuwQmgE1CrhLf.gs4pQvSbzLLz6uiEPbTCl8WMsQNc.W.','Dr. Ir. Eva Rolia, S.T., M.T., M.KM.',NULL,'wr3',NULL,'2026-05-26 08:46:50','2026-06-04 18:49:23'),(3,'Fajri Arif Wibawa','$2y$12$Y/bIBqKOUbRwg7SESoAQcup49JOi6xR7fRyrgBgSlOPjWMGDzjqd2','Fajri Arif Wibawa, S.Pd, M.Pd.',NULL,'juri',NULL,'2026-05-26 08:46:50','2026-05-29 08:33:47'),(4,'Guna Yanti K.S Siregar','$2y$12$y63OAVMq41iwEkw2/6qKROHCTsWAqRA0v5o6g37.0j.054yxAcrYC','Guna Yanti K.S Siregar, S.Kom., M.T.I.',NULL,'juri',NULL,'2026-05-26 08:46:50','2026-05-29 08:35:14'),(5,'Agus Wibowo','$2y$12$YCVz.UoGdkn9mlIHJABWaukebXOWq6nSBIb4dBHP/1kEhXr59Har.','Dr. Agus Wibowo, M.Pd.',NULL,'juri',NULL,'2026-05-26 08:46:50','2026-05-29 08:42:43'),(8,'ISNANIA DEWI','$2y$12$rAB1iE6DZ8ReK0Ch2.XNb.AlcIqfkJfG4IvWJsAopQVNLKudzC0m6','ISNANIA DEWI',NULL,'mahasiswa',NULL,'2026-05-30 01:08:57','2026-05-30 01:08:57'),(9,'ALIP MEDI PRASTYO','$2y$12$QKQCLNuG7FAWUoWh9/E5vuRzExl5mJUocnOj3QxfFu9G/uuA90bTu','ALIP MEDI PRASTYO',NULL,'mahasiswa',NULL,'2026-06-03 05:45:39','2026-06-03 05:45:39'),(11,'MUHAMMAD RAMDANI','$2y$12$WNJc5kWCg0aRb1ma0tWRq.5IMIq.JL.l9V5pnmnC.NhplVPm3cn6i','MUHAMMAD RAMDANI',NULL,'mahasiswa',NULL,'2026-06-03 06:04:24','2026-06-03 06:04:24'),(15,'dina_amelia','$2y$12$5SYSZIMCSHkCN7ndpnV07OxuqBTBBi24yWylZoXHqvZVi.wIrAlIK','Dina Amelia',NULL,'mahasiswa',NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(16,'rizky_maulana','$2y$12$5SYSZIMCSHkCN7ndpnV07OxuqBTBBi24yWylZoXHqvZVi.wIrAlIK','Rizky Maulana',NULL,'mahasiswa',NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(17,'siti_nurhaliza','$2y$12$5SYSZIMCSHkCN7ndpnV07OxuqBTBBi24yWylZoXHqvZVi.wIrAlIK','Siti Nurhaliza',NULL,'mahasiswa',NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(18,'ahmad_fauzi','$2y$12$5SYSZIMCSHkCN7ndpnV07OxuqBTBBi24yWylZoXHqvZVi.wIrAlIK','Ahmad Fauzi',NULL,'mahasiswa',NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(19,'putri_wulandari','$2y$12$5SYSZIMCSHkCN7ndpnV07OxuqBTBBi24yWylZoXHqvZVi.wIrAlIK','Putri Wulandari',NULL,'mahasiswa',NULL,'2026-06-22 08:02:17','2026-06-22 08:02:17'),(20,'ahmadrizkipratama178','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Ahmad Rizki Pratama',NULL,'mahasiswa',NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(21,'sitinurhaliza341','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Siti Nurhaliza',NULL,'mahasiswa',NULL,'2026-06-24 05:11:58','2026-06-24 05:11:58'),(22,'bambangsupriyadi274','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Bambang Supriyadi',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(23,'dewikartikasari846','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Dewi Kartika Sari',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(24,'rahmathidayat896','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Rahmat Hidayat',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(25,'fitrianiramadhani237','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Fitriani Ramadhani',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(26,'hendragunawan848','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Hendra Gunawan',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(27,'rinamarlina489','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Rina Marlina',NULL,'mahasiswa',NULL,'2026-06-24 05:11:59','2026-06-24 05:11:59'),(28,'agussetiawan921','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Agus Setiawan',NULL,'mahasiswa',NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(29,'indahpermatasari630','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Indah Permata Sari',NULL,'mahasiswa',NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(30,'dedikurniawan437','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Dedi Kurniawan',NULL,'mahasiswa',NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00'),(31,'putriayulestari364','$2y$12$vnoX/aY0HxDC6ZiDy6VmO./GN5WSHrEgRSVziDUMl5.lnQTlvIEXq','Putri Ayu Lestari',NULL,'mahasiswa',NULL,'2026-06-24 05:12:00','2026-06-24 05:12:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-02  0:31:38
