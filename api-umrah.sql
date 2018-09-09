/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100121
 Source Host           : localhost
 Source Database       : api-umrah

 Target Server Type    : MySQL
 Target Server Version : 100121
 File Encoding         : utf-8

 Date: 06/05/2018 22:05:58 PM
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `dat_hotel`
-- ----------------------------
DROP TABLE IF EXISTS `dat_hotel`;
CREATE TABLE `dat_hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_hotel` varchar(10) DEFAULT NULL,
  `nama_hotel` varchar(100) DEFAULT NULL,
  `lokasi` enum('mekkah','madinah') DEFAULT 'mekkah',
  `bintang` varchar(5) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `dat_hotel`
-- ----------------------------
BEGIN;
INSERT INTO `dat_hotel` VALUES ('1', 'HTL8358', 'ilham', 'mekkah', '5', null, null, '2018-05-24 19:00:42', '2018-05-24 19:00:42');
COMMIT;

-- ----------------------------
--  Table structure for `dat_hotel_seat`
-- ----------------------------
DROP TABLE IF EXISTS `dat_hotel_seat`;
CREATE TABLE `dat_hotel_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kamar` varchar(10) DEFAULT NULL,
  `kode_hotel` varchar(100) DEFAULT NULL,
  `nomor_kamar` varchar(100) DEFAULT NULL,
  `lantai` varchar(100) DEFAULT NULL,
  `tipe_kamar` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `dat_hotel_seat`
-- ----------------------------
BEGIN;
INSERT INTO `dat_hotel_seat` VALUES ('3', 'ROOM2223', 'HTL8358', '101', '1', '4', '2018-05-24 19:08:33', '2018-05-24 19:08:33', null, null), ('4', 'ROOM6095', 'HTL8358', '102', '1', '4', '2018-05-26 14:22:28', '2018-05-26 14:22:28', null, null), ('5', 'ROOM4355', 'HTL8358', '103', '1', '4', '2018-05-26 14:22:32', '2018-05-26 14:22:32', null, null), ('6', 'ROOM8507', 'HTL8358', '104', '1', '4', '2018-05-26 14:22:36', '2018-05-26 14:22:36', null, null), ('7', 'ROOM1994', 'HTL8358', '105', '1', '4', '2018-05-26 14:22:40', '2018-05-26 14:22:40', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `dat_pesawat`
-- ----------------------------
DROP TABLE IF EXISTS `dat_pesawat`;
CREATE TABLE `dat_pesawat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesawat` varchar(10) DEFAULT NULL,
  `nama_pesawat` varchar(200) DEFAULT NULL,
  `created_by` varchar(200) DEFAULT NULL,
  `updated_by` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `dat_pesawat`
-- ----------------------------
BEGIN;
INSERT INTO `dat_pesawat` VALUES ('1', 'PSW2222', 'Airbus 330 200', 'admin', null, '2018-05-25 14:51:44', '2018-05-25 14:51:44');
COMMIT;

-- ----------------------------
--  Table structure for `dat_pesawat_seat`
-- ----------------------------
DROP TABLE IF EXISTS `dat_pesawat_seat`;
CREATE TABLE `dat_pesawat_seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesawat` varchar(10) DEFAULT NULL,
  `kode_kursi` varchar(10) DEFAULT NULL,
  `kursi` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `dat_pesawat_seat`
-- ----------------------------
BEGIN;
INSERT INTO `dat_pesawat_seat` VALUES ('1', 'PSW2222', 'PSW22224B', '4B', '2018-05-25 14:57:14', '2018-05-25 14:57:14', null, null), ('2', 'PSW2222', 'PSW22224A', '4A', '2018-05-25 14:57:57', '2018-05-25 14:57:57', null, null), ('3', 'PSW2222', 'PSW22224C', '4C', '2018-05-25 14:58:00', '2018-05-25 14:58:00', null, null), ('4', 'PSW2222', 'PSW2222A4', 'A4', '2018-05-30 17:17:00', '2018-05-30 17:17:00', null, null), ('5', 'PSW2222', 'PSW2222A5', 'A5', '2018-05-30 17:17:05', '2018-05-30 17:17:05', null, null);
COMMIT;

-- ----------------------------
--  Table structure for `embarkasi`
-- ----------------------------
DROP TABLE IF EXISTS `embarkasi`;
CREATE TABLE `embarkasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_embarkasi` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records of `embarkasi`
-- ----------------------------
BEGIN;
INSERT INTO `embarkasi` VALUES ('1', 'MKS', 'Makassar', 'Y', null, null, '2018-06-05 22:05:27', '2018-06-05 22:05:43'), ('2', 'SOL', 'Solo', 'Y', null, null, '2018-06-05 22:05:39', '2018-06-05 22:05:39');
COMMIT;

-- ----------------------------
--  Table structure for `pendaftar`
-- ----------------------------
DROP TABLE IF EXISTS `pendaftar`;
CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_pendaftar` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kode_perusahaan` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(13) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `jk` enum('L','P') DEFAULT NULL,
  `nip` varchar(100) DEFAULT NULL,
  `nik` varchar(100) DEFAULT NULL,
  `no_reff` varchar(50) DEFAULT NULL,
  `kode_embarkasi` varchar(100) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `hubungan_keluarga` varchar(100) DEFAULT NULL,
  `approval_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `pendaftar`
-- ----------------------------
BEGIN;
INSERT INTO `pendaftar` VALUES ('1', '932101649', 'Dimas adi satria', '64192807', 'dimas@gmail.com', '123456789012', '$2y$10$WBxGea1JAdnfdiIndQhEEuD/4jJ3MNDsRIFW8OWwpyiYHIA/bZh96', 'L', '1234567890', '1234567890123456', '45180398', null, 'approved', null, null, '2018-06-01 13:20:14', '2018-06-01 13:20:14'), ('2', '796049449', 'Nanda Putri Wulandari', '64192807', 'nandapw@gmail.com', '123456789012', '$2y$10$.DQcZxEbg9lxF6YzXeWP6uevsyl/tyrA5kN0sddQS98d98qH2f.jW', 'P', '1234567890', '1234567890123456', '45180398', null, 'approved', null, null, '2018-06-01 13:42:09', '2018-06-01 13:42:09'), ('3', '682082883', 'Eneng Resti Tri Utami', '64192807', 'ceres@gmail.com', '123456789012', '$2y$10$4IwOKHk2TYcI/dcXuUvare2BJbAuN3si/.d.Xj8nFrMuZGrCDPFby', 'P', '1234567890', '1234567890123456', '45180398', null, 'approved', null, null, '2018-06-01 15:19:02', '2018-06-01 15:19:02');
COMMIT;

-- ----------------------------
--  Table structure for `perusahaan`
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_perusahaan` varchar(50) DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `telephone` varchar(1000) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `slogan` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updatedt_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `perusahaan`
-- ----------------------------
BEGIN;
INSERT INTO `perusahaan` VALUES ('1', '62125517', null, 'pt aaa', 'ilhamsabar@gmail.com', 'www.aaa.com', '085397587200', 'adasdasd', null, null, '2018-05-19 19:06:27', '2018-05-19 19:06:27'), ('2', '90570300', null, 'aaa', 'ilhamsabar@gmail.com', null, '1111111', 'dadasda', null, null, '2018-05-21 18:55:00', '2018-05-21 18:55:00'), ('3', '39524637', '', 'PT. Nano Meter Technology', 'ilhamsabar@gmail.com', null, '1111111', 'dadasda', null, null, '2018-05-31 12:31:56', '2018-05-31 12:31:56'), ('4', '64192807', 'pt-nano-meter-technology', 'PT. Nano Meter Technology', 'ilhamsabar@gmail.com', null, '1111111', 'dadasda', null, null, '2018-05-31 12:32:30', '2018-05-31 12:32:30');
COMMIT;

-- ----------------------------
--  Table structure for `peserta`
-- ----------------------------
DROP TABLE IF EXISTS `peserta`;
CREATE TABLE `peserta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_pendaftar` varchar(100) DEFAULT NULL,
  `nomor_peserta` varchar(100) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `token` varchar(1000) DEFAULT NULL,
  `status` enum('approved','rejected','pennding') DEFAULT 'pennding',
  `approval_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `nomor_pendaftar` (`nomor_pendaftar`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `peserta`
-- ----------------------------
BEGIN;
INSERT INTO `peserta` VALUES ('1', '932101649', 'UMHPS40495418187', '6424', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1aGFqLmlkIiwiYXVkIjoidWhhai5pZCIsIm5iZiI6MTUyODAwMjkyNCwiZXhwIjoxNTI4MDIwOTI0fQ.9fPjNFiULOGuXIcvUBOnxQbnBYK4cnVqD6YYmjkeosQ', 'approved', 'admin', '2018-06-01 13:20:14', '2018-06-03 12:15:24'), ('2', '796049449', 'UMHPS63250865678', '6345', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1aGFqLmlkIiwiYXVkIjoidWhhai5pZCIsIm5iZiI6MTUyODAwMjczOCwiZXhwIjoxNTI4MDIwNzM4fQ.KvNvtgg222F5eDRp6H4a7iXB_tZmiAEHoVpVvN3yzkY', 'approved', 'admin', '2018-06-01 13:42:09', '2018-06-03 12:12:18'), ('3', '682082883', 'UMHPS72799746387', '6212', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1aGFqLmlkIiwiYXVkIjoidWhhai5pZCIsIm5iZiI6MTUyNzg0MTE1NSwiZXhwIjoxNTI3ODU5MTU1fQ.1pcTAJS8RvFruoQ5o4VSZa0aFqYnDl1GxJ-mnLNArIQ', null, 'admin', '2018-06-01 15:19:02', '2018-06-01 15:19:15');
COMMIT;

-- ----------------------------
--  Table structure for `produk`
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(50) DEFAULT NULL,
  `nama_produk` varchar(200) DEFAULT NULL,
  `seat` int(200) DEFAULT NULL,
  `status` enum('Y','N') DEFAULT 'Y',
  `kode_pesawat` varchar(50) DEFAULT NULL,
  `kode_hotel_madinah` varchar(50) DEFAULT NULL,
  `kode_hotel_mekkah` varchar(50) DEFAULT NULL,
  `tanggal_kepulangan` varchar(50) DEFAULT NULL,
  `tanggal_keberangkatan` date NOT NULL,
  `harga` double DEFAULT NULL,
  `diskon_max` double DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `produk`
-- ----------------------------
BEGIN;
INSERT INTO `produk` VALUES ('4', 'PRUMH20180527957', 'umroh ramadhan 27 april 2018', '100', 'Y', '1', '1', '1', '2018-06-04', '2018-05-27', '1000000000', null, '2018-05-19 22:13:19', '2018-05-26 20:04:00', 'admin'), ('6', 'PRUMH20180604692', 'umrah ramadhan 27-juni-2019', '100', 'Y', '1', '1', '1', '2018-06-12', '2018-06-04', '1000000000', null, '2018-06-01 13:27:04', '2018-06-01 13:27:04', 'admin'), ('7', 'PRUMH20180615702', 'umrah ramadhan 27-juni-2019', '100', 'Y', '1', '1', '1', '2018-06-23', '2018-06-15', '1000000000', null, '2018-06-01 13:27:21', '2018-06-01 13:27:21', 'admin');
COMMIT;

-- ----------------------------
--  Table structure for `transaksi`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(40) DEFAULT NULL,
  `nomor_peserta` varchar(50) DEFAULT NULL,
  `kode_produk` varchar(20) DEFAULT NULL,
  `total_harga` double DEFAULT NULL,
  `no_reff` varchar(50) DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `tgl_transaksi` datetime DEFAULT NULL,
  `exp_booking` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `transaksi`
-- ----------------------------
BEGIN;
INSERT INTO `transaksi` VALUES ('1', 'TRUMH7823820180601', 'UMHPS40495418187', 'PRUMH20180604692', '1000000000', null, null, 'approved', '2018-06-01 13:27:49', '2018-06-06 13:27:49', '2018-06-01 13:27:49', '2018-06-01 13:40:23'), ('2', 'TRUMH3186020180601', 'UMHPS63250865678', 'PRUMH20180604692', '1000000000', null, null, 'approved', '2018-06-01 13:43:19', '2018-06-06 13:43:19', '2018-06-01 13:43:19', '2018-06-01 13:43:44');
COMMIT;

-- ----------------------------
--  Table structure for `transaksi_dokumen`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_dokumen`;
CREATE TABLE `transaksi_dokumen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(50) DEFAULT NULL,
  `passpor` varchar(100) DEFAULT NULL,
  `ktp` varchar(100) DEFAULT NULL,
  `kk` varchar(100) DEFAULT NULL,
  `kartu_id` varchar(100) DEFAULT NULL,
  `kode_pembayaran` varchar(10) DEFAULT NULL,
  `exp_payment` datetime DEFAULT NULL,
  `tgl_upload` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `transaksi_dokumen`
-- ----------------------------
BEGIN;
INSERT INTO `transaksi_dokumen` VALUES ('1', 'TRUMH9292220180525', 'http://localhost:8000/storage/dokumen/TRUMH9292220180525/NIdA22L1FwkWeBA5JsvDTffQugqrBqw2R4qoRbGJ.jp', 'http://localhost:8000/storage/dokumen/TRUMH9292220180525/XFlvM2bM09BwLEJIjSRy7a6K4daAElOFOWHWQQZH.jp', 'http://localhost:8000/storage/dokumen/TRUMH9292220180525/2SQTsbBeswI6rZvpLHajDdCn9GLFmdvKoqDwKU79.jp', 'http://localhost:8000/storage/dokumen/TRUMH9292220180525/LE6fDKp7EHPD3M5PSgauw8HijZ6t9sHqiHDRlJyH.jp', null, '2018-06-01 23:19:16', '2018-05-29 23:19:16', '2018-05-29 23:19:16', '2018-05-29 23:19:16'), ('2', 'TRUMH3186020180601', 'http://localhost:8000/storage/dokumen/TRUMH3186020180601/M1UaUykkhjC2nzoMLGCjWoUNwmApGfky67gPMZ48.jp', 'http://localhost:8000/storage/dokumen/TRUMH3186020180601/W0OKWsGhSiNDbsjvWDgXRSBMySk7vKPL6JmHx99J.jp', 'http://localhost:8000/storage/dokumen/TRUMH3186020180601/Mph45rOmNyn64wjwmFMAcn5IQegleT00E34tCTlM.jp', 'http://localhost:8000/storage/dokumen/TRUMH3186020180601/xw4zDOxQhK3nJVh69rhdZgBzaosSL3fIXZLamm8F.jp', null, '2018-06-05 15:02:14', '2018-06-02 15:02:14', '2018-06-02 15:02:14', '2018-06-02 15:02:14');
COMMIT;

-- ----------------------------
--  Table structure for `transaksi_hotel`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_hotel`;
CREATE TABLE `transaksi_hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(50) DEFAULT NULL,
  `kode_produk` varchar(100) DEFAULT NULL,
  `kode_kamar_madinah` varchar(50) DEFAULT NULL,
  `kode_kamar_mekkah` varchar(50) DEFAULT NULL,
  `jumlah_orang` varchar(10) DEFAULT NULL,
  `status` enum('pending','approve','reject') DEFAULT 'pending',
  `approval_by` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `transaksi_hotel`
-- ----------------------------
BEGIN;
INSERT INTO `transaksi_hotel` VALUES ('1', 'TRUMH3186020180601', 'PRUMH20180604692', 'ROOM8507', 'ROOM1994', 'quad', 'pending', null, '2018-06-02 16:56:13', '2018-06-02 19:33:35'), ('2', 'TRUMH7823820180601', 'PRUMH20180604692', 'ROOM8507', 'ROOM1994', null, 'pending', null, '2018-06-02 19:36:38', '2018-06-02 19:36:38');
COMMIT;

-- ----------------------------
--  Table structure for `transaksi_pembayaran`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pembayaran`;
CREATE TABLE `transaksi_pembayaran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_pembayaran` varchar(100) DEFAULT NULL,
  `nomor_transaksi` varchar(100) DEFAULT NULL,
  `jenis_pembayaran` enum('dp','pelunasan') DEFAULT NULL,
  `jumlah_pembayaran` double DEFAULT NULL,
  `tgl_pembayaran` date DEFAULT NULL,
  `bukti` varchar(100) DEFAULT NULL,
  `status` enum('approve','reject','pending') DEFAULT 'pending',
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `transaksi_pembayaran`
-- ----------------------------
BEGIN;
INSERT INTO `transaksi_pembayaran` VALUES ('3', 'PAY403320180529183618', 'TRUMH4657520180521', 'dp', '1000000', '2018-05-26', '1131231231.jpg', 'pending', null, null, '2018-05-29 19:36:18', '2018-05-29 19:36:18'), ('4', 'PAY865320180602150229', 'TRUMH3186020180601', 'dp', '100000', '2018-02-06', 'http://localhost:8000/storage/1', 'pending', null, null, '2018-06-02 15:02:29', '2018-06-02 15:02:29'), ('5', 'PAY736020180602150730', 'TRUMH3186020180601', 'dp', '100000', '2018-02-06', 'http://localhost:8000/storage/bukti-pembayaran/TRUMH3186020180601/dYmlctl5gRM9VYLkm6vCa8VRJk5ydfcWo0', 'pending', null, null, '2018-06-02 15:07:30', '2018-06-02 15:07:30'), ('6', 'PAY358820180602151541', 'TRUMH3186020180601', 'dp', '100000', '2018-02-06', 'http://localhost:8000/storage/bukti-pembayaran/TRUMH3186020180601/85GhfTOqUFkBKNUHjvII7gZ0PvY4PiUvLo', 'pending', null, null, '2018-06-02 15:15:41', '2018-06-02 15:15:41'), ('7', 'PAY140220180602151719', 'TRUMH3186020180601', 'pelunasan', '100000', '2018-02-06', 'http://localhost:8000/storage/bukti-pembayaran/TRUMH3186020180601/ymrl3SA2pY95UvFX2Hoc00jXInqwhINIce', 'pending', null, null, '2018-06-02 15:17:19', '2018-06-02 15:17:19'), ('8', 'PAY205820180602151719', 'TRUMH3186020180601', 'pelunasan', '100000', '2018-02-06', 'http://localhost:8000/storage/bukti-pembayaran/TRUMH3186020180601/ymrl3SA2pY95UvFX2Hoc00jXInqwhINIce', 'pending', null, null, '2018-06-02 15:17:19', '2018-06-02 15:17:19');
COMMIT;

-- ----------------------------
--  Table structure for `transaksi_pesawat`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pesawat`;
CREATE TABLE `transaksi_pesawat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(50) DEFAULT NULL,
  `kode_kursi` varchar(10) DEFAULT NULL,
  `nomor_kursi_pergi` varchar(100) DEFAULT NULL,
  `nomor_kursi_pulang` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('approve','reject','pending') DEFAULT 'approve',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- ----------------------------
--  Records of `transaksi_pesawat`
-- ----------------------------
BEGIN;
INSERT INTO `transaksi_pesawat` VALUES ('1', 'TRUMH7823820180601', 'PSW22224A', null, null, '2018-06-01 13:41:27', '2018-06-01 13:41:27', 'approve'), ('2', 'TRUMH3186020180601', 'PSW22224B', null, null, '2018-06-01 13:44:52', '2018-06-01 13:44:52', 'approve');
COMMIT;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `kode_user` varchar(100) DEFAULT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
