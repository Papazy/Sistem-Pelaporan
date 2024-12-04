-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 04, 2024 at 05:24 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporan`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_admin`
--

CREATE TABLE `aktivitas_admin` (
  `id` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `aktivitas` text NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `foto_kegiatan`
--

CREATE TABLE `foto_kegiatan` (
  `id_foto` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `foto_kegiatan`
--

INSERT INTO `foto_kegiatan` (`id_foto`, `id_laporan`, `foto`) VALUES
(1, 1, '04-12-2024-Screenshot 2024-12-04 000440.png');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kegiatan`
--

CREATE TABLE `jenis_kegiatan` (
  `kegiatan` int(11) NOT NULL,
  `judul_kegiatan` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` text DEFAULT NULL,
  `edited_by` varchar(100) DEFAULT NULL,
  `edited_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_kegiatan`
--

INSERT INTO `jenis_kegiatan` (`kegiatan`, `judul_kegiatan`, `created_by`, `created_at`, `edited_by`, `edited_at`) VALUES
(13, 'Upacara', 'Reza Muksalmina', '17-03-2024 12:19:57', 'Reza Muksalmina', '2024-12-04 21:56:54'),
(14, 'Kunjungann', 'Reza Muksalmina', '17-03-2024 12:20:06', 'Reza Muksalmina', '2024-12-04 21:57:11'),
(15, 'Perbaikan', 'Reza Muksalmina', '17-03-2024 12:20:25', '', ''),
(16, 'Pelayanan soundsystem', 'Reza Muksalmina', '17-03-2024 12:20:50', '', ''),
(17, 'Pelayanan zoommeeting', 'Reza Muksalmina', '17-03-2024 12:21:10', '', ''),
(22, 'Patroli lalu lintas', 'Muhammad ', '18-03-2024 11:18:04', '', ''),
(28, 'gladi', 'Reza Muksalmina', '03-04-2024 11:24:14', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_kegiatan`
--

CREATE TABLE `laporan_kegiatan` (
  `id_laporan` int(11) NOT NULL,
  `judul_laporan` varchar(255) DEFAULT NULL,
  `satuan` int(11) DEFAULT NULL,
  `kegiatan` int(11) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `id_foto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporan_kegiatan`
--

INSERT INTO `laporan_kegiatan` (`id_laporan`, `judul_laporan`, `satuan`, `kegiatan`, `lokasi`, `tgl`, `isi`, `created_by`, `created_at`, `status`, `id_foto`) VALUES
(1, 'Sistem Evaluasi', 9, 13, 'Aceh', '2024-12-04', '', '16', '2024-12-04', 'DITERIMA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pdf_kegiatan`
--

CREATE TABLE `pdf_kegiatan` (
  `id_pdf` int(11) NOT NULL,
  `id_laporan` int(11) NOT NULL,
  `pdf` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan` int(11) NOT NULL,
  `judul_satuan` varchar(100) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` text DEFAULT NULL,
  `edited_by` varchar(100) DEFAULT NULL,
  `edited_at` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan`, `judul_satuan`, `created_by`, `created_at`, `edited_by`, `edited_at`) VALUES
(11, 'POLRES ACEH JAYAA', 'Reza Muksalmina', '17-03-2024 12:26:02', 'Reza Muksalmina', '2024-12-04 15:25:21'),
(12, 'POLRES BENER MERIAH', 'Reza Muksalmina', '17-03-2024 12:26:38', '', ''),
(13, 'POLRES LHOKSEUMAWE ', 'Reza Muksalmina', '17-03-2024 12:26:53', '', ''),
(14, 'POLRES ACEH BESAR ', 'Reza Muksalmina', '17-03-2024 12:27:19', '', ''),
(15, 'POLRES PIDIE JAYA  ', 'Reza Muksalmina', '17-03-2024 12:27:36', '', ''),
(16, 'POLRES LANGSA', 'Reza Muksalmina', '17-03-2024 12:28:07', '', ''),
(17, 'POLRES SIMEULU  ', 'Reza Muksalmina', '17-03-2024 12:28:38', '', ''),
(18, 'POLRES NAGAN RAYA ', 'Reza Muksalmina', '17-03-2024 12:29:43', '', ''),
(19, 'POLRES PIDIE  ', 'Reza Muksalmina', '17-03-2024 12:30:11', '', ''),
(20, 'POLRES GAYO LUES  ', 'Reza Muksalmina', '17-03-2024 12:30:42', '', ''),
(21, 'POLRES BIREUEN  ', 'Reza Muksalmina', '17-03-2024 12:32:48', '', ''),
(22, 'POLRES ACEH UTARA ', 'Reza Muksalmina', '17-03-2024 12:33:13', '', ''),
(23, 'POLRESTA BANDA ACEH ', 'Reza Muksalmina', '17-03-2024 12:33:56', '', ''),
(24, 'POLRES ACEH SINGKIL ', 'Reza Muksalmina', '17-03-2024 12:34:15', '', ''),
(25, 'POLRES ACEH BARAT  ', 'Reza Muksalmina', '17-03-2024 12:34:29', '', ''),
(26, 'POLRES ACEH TENGAH', 'Reza Muksalmina', '17-03-2024 12:34:37', '', ''),
(28, 'POLRES ACEH BARAT DAYA', 'Reza Muksalmina', '19-03-2024 14:29:27', '', ''),
(31, 'POLDA', 'Reza Muksalmina', '23-03-2024 20:54:35', '', ''),
(32, '', 'Reza Muksalmina', '04-12-2024 20:46:49', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id_staff` int(11) NOT NULL,
  `nrp` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(30) NOT NULL,
  `pangkat` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tipe` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id_staff`, `nrp`, `nama`, `jenis_kelamin`, `pangkat`, `password`, `tipe`) VALUES
(13, '1001', 'Muhammad ', 'laki-laki', 'komando', '1001', 'admin'),
(15, '2201999', 'rizki ratih purwasih', 'perempuan', 'kopral', '12345', 'anggota'),
(16, '123', 'Reza Muksalmina', 'laki-laki', 'operator', '123', 'admin'),
(17, '456', 'Syahril Handaya', 'laki-laki', 'operator', '456', 'admin'),
(18, '1002', 'Rizky', 'laki-laki', 'operator', '1002', 'anggota'),
(19, '101', 'Fajar Mubarak', 'laki-laki', 'operator', '101', 'admin'),
(20, '102', 'Fadhil', 'laki-laki', 'operator', '102', 'admin'),
(21, '103', 'Izzatul Rahmadani', 'perempuan', 'operator', '103', 'admin'),
(22, '104', 'Gadis Tri Wandini', 'perempuan', 'operator', '104', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `foto_kegiatan`
--
ALTER TABLE `foto_kegiatan`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indexes for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  ADD PRIMARY KEY (`kegiatan`);

--
-- Indexes for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `pdf_kegiatan`
--
ALTER TABLE `pdf_kegiatan`
  ADD PRIMARY KEY (`id_pdf`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satuan`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_admin`
--
ALTER TABLE `aktivitas_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foto_kegiatan`
--
ALTER TABLE `foto_kegiatan`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_kegiatan`
--
ALTER TABLE `jenis_kegiatan`
  MODIFY `kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `laporan_kegiatan`
--
ALTER TABLE `laporan_kegiatan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pdf_kegiatan`
--
ALTER TABLE `pdf_kegiatan`
  MODIFY `id_pdf` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
