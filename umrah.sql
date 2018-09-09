/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50719
 Source Host           : localhost:3306
 Source Schema         : umrah

 Target Server Type    : MySQL
 Target Server Version : 50719
 File Encoding         : 65001

 Date: 25/05/2018 14:27:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dat_hotel
-- ----------------------------
DROP TABLE IF EXISTS `dat_hotel`;
CREATE TABLE `dat_hotel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_hotel` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_hotel` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `bintang` varchar(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for dat_hotel_seat
-- ----------------------------
DROP TABLE IF EXISTS `dat_hotel_seat`;
CREATE TABLE `dat_hotel_seat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kamar` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tipe_kamar` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `seat` int(50) NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `created_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for dat_pesawat
-- ----------------------------
DROP TABLE IF EXISTS `dat_pesawat`;
CREATE TABLE `dat_pesawat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesawat` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_pesawat` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_by` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_by` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dat_pesawat
-- ----------------------------
INSERT INTO `dat_pesawat` VALUES (1, 'PSW9785', 'Airbus 330 200', 'admin', NULL, '2018-05-25 12:51:26', '2018-05-25 12:51:26');

-- ----------------------------
-- Table structure for dat_pesawat_seat
-- ----------------------------
DROP TABLE IF EXISTS `dat_pesawat_seat`;
CREATE TABLE `dat_pesawat_seat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pesawat` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_kursi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kursi` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `created_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dat_pesawat_seat
-- ----------------------------
INSERT INTO `dat_pesawat_seat` VALUES (1, 'PSW9785', 'PSW97854A', '4A', '2018-05-25 12:54:35', '2018-05-25 12:54:35', NULL, NULL);
INSERT INTO `dat_pesawat_seat` VALUES (2, 'PSW9785', 'PSW97854B', '4B', '2018-05-25 13:11:20', '2018-05-25 13:11:20', NULL, NULL);
INSERT INTO `dat_pesawat_seat` VALUES (3, 'PSW9785', 'PSW97854C', '4C', '2018-05-25 13:11:24', '2018-05-25 13:11:24', NULL, NULL);

-- ----------------------------
-- Table structure for pendaftar
-- ----------------------------
DROP TABLE IF EXISTS `pendaftar`;
CREATE TABLE `pendaftar`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_pendaftar` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_perusahaan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telephone` varchar(13) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jk` enum('L','P') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nip` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nik` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `approval_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pendaftar
-- ----------------------------
INSERT INTO `pendaftar` VALUES (1, '695172002', 'ilham', '123121', 'ilhamsabar@gmail.com', '085397587200', NULL, NULL, '1111111111111111', '1111111111111111', NULL, 'admin', '2018-05-19 19:00:53', '2018-05-19 19:56:04');
INSERT INTO `pendaftar` VALUES (2, '432141171', 'ilham', '123121', 'ilhamsabar@gmail.com', '085397587200', NULL, NULL, '1111111111111111', '1111111111111111', NULL, 'admin', '2018-05-19 19:01:27', '2018-05-19 20:01:54');
INSERT INTO `pendaftar` VALUES (5, '320655262', 'Dimas', '1', 'dimss.satria@gmail.com', '08159510969', '$2y$10$vHpongZC8EqE43Dirf4v5eLG6aax3WAv4y6768KmHHdmFY4o4evty', 'L', '123456789', '1234567890123456', 'approval', 'admin', '2018-05-22 12:18:39', '2018-05-22 16:17:24');

-- ----------------------------
-- Table structure for perusahaan
-- ----------------------------
DROP TABLE IF EXISTS `perusahaan`;
CREATE TABLE `perusahaan`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_perusahaan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `website` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `telephone` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `alamat` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedt_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of perusahaan
-- ----------------------------
INSERT INTO `perusahaan` VALUES (1, '62125517', 'pt aaa', 'ilhamsabar@gmail.com', 'www.aaa.com', '085397587200', 'adasdasd', '2018-05-19 19:06:27', '2018-05-19 19:06:27');
INSERT INTO `perusahaan` VALUES (2, '90570300', 'aaa', 'ilhamsabar@gmail.com', NULL, '1111111', 'dadasda', '2018-05-21 18:55:00', '2018-05-21 18:55:00');

-- ----------------------------
-- Table structure for peserta
-- ----------------------------
DROP TABLE IF EXISTS `peserta`;
CREATE TABLE `peserta`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_pendaftar` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nomor_peserta` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `pin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `token` varchar(1000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nomor_pendaftar`(`nomor_pendaftar`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of peserta
-- ----------------------------
INSERT INTO `peserta` VALUES (1, '695172002', 'UMHPS81681658671', 'mhw26ItX', NULL, 'admin', '2018-05-19 19:54:37', '2018-05-19 19:54:37');
INSERT INTO `peserta` VALUES (4, '432141171', 'UMHPS50189548622', 'OLHZULPA', NULL, 'admin', '2018-05-19 20:01:54', '2018-05-19 20:01:54');
INSERT INTO `peserta` VALUES (6, '320655262', 'UMHPS59191765955', '5930', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJ1aGFqLmlkIiwiYXVkIjoidWhhai5pZCIsIm5iZiI6MTUyNzIyNzM0MSwiZXhwIjoxNTI3MjQ1MzQxfQ.6tIMfjsAVLaE1RYv-dGINXwO0b_n6FgElUwynhwnTfA', 'admin', '2018-05-22 16:17:24', '2018-05-25 12:49:01');

-- ----------------------------
-- Table structure for produk
-- ----------------------------
DROP TABLE IF EXISTS `produk`;
CREATE TABLE `produk`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_produk` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `seat` int(200) NULL DEFAULT NULL,
  `status` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'Y',
  `kode_pesawat` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_hotel_madinah` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_hotel_mekkah` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_kepulangan` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `tanggal_keberangkatan` date NOT NULL,
  `harga` double NULL DEFAULT NULL,
  `diskon_max` double NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `created_by` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of produk
-- ----------------------------
INSERT INTO `produk` VALUES (4, 'PRUMH20180527957', 'umroh ramadhan 27 april 2018', 100, 'Y', NULL, NULL, NULL, NULL, '2018-05-27', 1000000000, NULL, '2018-05-19 22:13:19', '2018-05-21 21:12:11', 'admin');
INSERT INTO `produk` VALUES (5, 'PRUMH20180527642', 'umrah ramadhan 27-juni-2019', 100, 'Y', '1', '1', '1', '2018-06-04', '2018-05-27', 1000000000, NULL, '2018-05-21 19:32:56', '2018-05-21 20:33:28', 'admin');

-- ----------------------------
-- Table structure for transaksi
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nomor_peserta` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_produk` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `total_harga` double NULL DEFAULT NULL,
  `no_reff` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `diskon` double NULL DEFAULT NULL,
  `status` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaksi
-- ----------------------------
INSERT INTO `transaksi` VALUES (1, 'TRUMH8054020180521', 'UMHPS81681658671', 'PRUMH20180527957', NULL, NULL, NULL, NULL, '2018-05-21 21:11:03', '2018-05-21 21:11:03');
INSERT INTO `transaksi` VALUES (2, 'TRUMH4657520180521', 'UMHPS81681658671', 'PRUMH20180527957', 1000000000, NULL, NULL, NULL, '2018-05-21 21:12:15', '2018-05-21 21:12:15');

-- ----------------------------
-- Table structure for transaksi_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_dokumen`;
CREATE TABLE `transaksi_dokumen`  (
  `id` int(11) NOT NULL,
  `nomor_transaksi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ktp` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kk` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kartu_id` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transaksi_hotel
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_hotel`;
CREATE TABLE `transaksi_hotel`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nomor_kamar_madinah` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nomor_kamar_mekkah` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` enum('pending','approve','reject') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending',
  `approval_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transaksi_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pembayaran`;
CREATE TABLE `transaksi_pembayaran`  (
  `id` int(11) NOT NULL,
  `nomor_pembayaran` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nomor_transaksi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jenis_pembayaran` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `jumlah_pembayaran` double NULL DEFAULT NULL,
  `bukti` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` enum('approve','reject','pending') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'pending',
  `tanggal_jatuh_tempo` date NULL DEFAULT NULL,
  `approved_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transaksi_pesawat
-- ----------------------------
DROP TABLE IF EXISTS `transaksi_pesawat`;
CREATE TABLE `transaksi_pesawat`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nomor_transaksi` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `kode_kursi` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `status` enum('approve','reject','pending') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT 'approve',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL,
  `kode_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `nama_user` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `level` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  `created_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `updated_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
