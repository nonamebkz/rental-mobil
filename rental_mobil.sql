-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2023 at 07:59 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE rental_mobil;
USE rental_mobil;

-- Use utf8mb4 charset for better compatibility
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

-- Table structure for table `booking`

CREATE TABLE `booking` (
  `id_booking` INT NOT NULL AUTO_INCREMENT,
  `kode_booking` VARCHAR(255) NOT NULL,
  `id_login` INT NOT NULL,
  `id_mobil` INT NOT NULL,
  `ktp` VARCHAR(255) NOT NULL,
  `ktp_file` VARCHAR(255) DEFAULT NULL,
  `npwp_file` VARCHAR(255) DEFAULT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `alamat` VARCHAR(255) NOT NULL,
  `no_tlp` VARCHAR(15) NOT NULL,
  `tanggal` DATE NOT NULL, -- Changed to DATE
  `lama_sewa` INT NOT NULL,
  `total_harga` INT NOT NULL,
  `konfirmasi_pembayaran` VARCHAR(255) NOT NULL,
  `tgl_input` DATETIME NOT NULL, -- Changed to DATETIME
  PRIMARY KEY (`id_booking`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `infoweb`

CREATE TABLE `infoweb` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nama_rental` VARCHAR(255) DEFAULT NULL,
  `telp` VARCHAR(15) DEFAULT NULL,
  `alamat` TEXT DEFAULT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `no_rek` TEXT DEFAULT NULL,
  `updated_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `login`

CREATE TABLE `login` (
  `id_login` INT NOT NULL AUTO_INCREMENT,
  `nama_pengguna` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `level` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `mobil`

CREATE TABLE `mobil` (
  `id_mobil` INT NOT NULL AUTO_INCREMENT,
  `no_plat` VARCHAR(255) NOT NULL,
  `merk` VARCHAR(255) NOT NULL,
  `harga` INT NOT NULL,
  `deskripsi` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL,
  `gambar` TEXT NOT NULL,
  PRIMARY KEY (`id_mobil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `pembayaran`

CREATE TABLE `pembayaran` (
  `id_pembayaran` INT NOT NULL AUTO_INCREMENT,
  `id_booking` INT NOT NULL,
  `no_rekening` VARCHAR(255) NOT NULL, -- Changed to VARCHAR
  `nama_rekening` VARCHAR(255) NOT NULL,
  `nominal` INT NOT NULL,
  `tanggal` DATE NOT NULL, -- Changed to DATE
  `bukti_bayar` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id_pembayaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Table structure for table `pengembalian`

CREATE TABLE `pengembalian` (
  `id_pengembalian` INT NOT NULL AUTO_INCREMENT,
  `kode_booking` VARCHAR(255) NOT NULL,
  `tanggal` DATE NOT NULL, -- Changed to DATE
  `denda` INT NOT NULL,
  PRIMARY KEY (`id_pengembalian`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

-- Dumping data for table `booking`

-- Corrected INSERT statement for `booking` table
INSERT INTO `booking` (`id_booking`, `kode_booking`, `id_login`, `id_mobil`, `ktp`, `ktp_file`, `npwp_file`, `nama`, `alamat`, `no_tlp`, `tanggal`, `lama_sewa`, `total_harga`, `konfirmasi_pembayaran`, `tgl_input`) 
VALUES
(1, '1576329294', 3, 5, '231423123', '231423123.jpg', NULL, 'Krisna', 'Bekasi', '08132312321', '2019-12-28', 2, 400000, 'Pembayaran di terima', '2019-12-14'),
(2, '1576671989', 3, 5, '231423', '231423.jpg', NULL, 'Krisna Waskita', 'Bekasi Ujung Harapan', '082391273127', '2019-12-20', 2, 400525, 'Pembayaran di terima', '2019-12-18'),
(3, '1642998828', 3, 5, '1283821832813', '1283821832813.jpg', NULL, 'Krisna', 'Bekasi', '089618173609', '2022-01-26', 4, 800743, 'Pembayaran di terima', '2022-01-24');

-- --------------------------------------------------------

-- Dumping data for table `infoweb`

INSERT INTO `infoweb` (`id`, `nama_rental`, `telp`, `alamat`, `email`, `no_rek`, `updated_at`) VALUES
(1, 'Rental Mobil Mobilan', '0872364663', 'Ujung Harapan Kab. Bekasi', 'apa@gmail.com', 'BRI A/N Wkwk 123123213123', '2022-01-24 04:57:29');

-- --------------------------------------------------------

-- Dumping data for table `login`

INSERT INTO `login` (`id_login`, `nama_pengguna`, `username`, `password`, `level`) VALUES
(1, 'Anang', 'admin', 'fe01ce2a7fbac8fafaed7c982a04e229', 'admin'),
(3, 'Krisna Waskita', 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'pengguna');

-- --------------------------------------------------------

-- Dumping data for table `mobil`

INSERT INTO `mobil` (`id_mobil`, `no_plat`, `merk`, `harga`, `deskripsi`, `status`, `gambar`) VALUES
(5, 'N34234', 'Avanza', 200000, 'Apa aja', 'Tidak Tersedia', '1673593078toyota-all-new-avanza-2015-tangkapan-layar_169.jpeg'),
(6, 'N 1232 BKT', 'New Xenia', 500000, 'Baru', 'Tersedia', 'all-new-xenia-exterior-tampak-perspektif-depan---varian-1.5r-ads.jpg');

-- --------------------------------------------------------

-- Dumping data for table `pembayaran`

INSERT INTO `pembayaran` (`id_pembayaran`, `id_booking`, `no_rekening`, `nama_rekening`, `nominal`, `tanggal`) VALUES
(3, 1, '2131241', 'Krisna Aldi Waskito', 400000, '2019-12-14'),
(4, 2, '2131241', 'Krisna Aldi Waskito', 400525, '2019-12-18'),
(5, 3, '13213', 'Fauzan Falah', 800743, '2022-01-24');

-- --------------------------------------------------------

-- Dumping data for table `pengembalian`

INSERT INTO `pengembalian` (`id_pengembalian`, `kode_booking`, `tanggal`, `denda`) VALUES
(1, '1576329294', '2019-12-30', 50000);

-- --------------------------------------------------------

-- AUTO_INCREMENT for dumped tables
ALTER TABLE `booking` AUTO_INCREMENT = 4;
ALTER TABLE `login` AUTO_INCREMENT = 4;
ALTER TABLE `mobil` AUTO_INCREMENT = 7;
ALTER TABLE `pembayaran` AUTO_INCREMENT = 6;
ALTER TABLE `pengembalian` AUTO_INCREMENT = 2;

COMMIT;
