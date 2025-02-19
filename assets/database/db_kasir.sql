-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2025 pada 08.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_barang` text NOT NULL,
  `merk` varchar(255) NOT NULL,
  `harga_beli` varchar(255) NOT NULL,
  `harga_jual` varchar(255) NOT NULL,
  `satuan_barang` varchar(255) NOT NULL,
  `stok` text NOT NULL,
  `gambar` text NOT NULL,
  `tgl_input` varchar(255) NOT NULL,
  `tgl_update` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `id_barang`, `id_kategori`, `nama_barang`, `merk`, `harga_beli`, `harga_jual`, `satuan_barang`, `stok`, `gambar`, `tgl_input`, `tgl_update`) VALUES
(13, 'BR001', 1, 'PIXY UVW TWC Perfect Last', 'PIXY', '33200', '36000', 'PCS', '103', 'TWC.png', '2025-02-04 19:09:22', '2025-02-12 13:52:33'),
(14, 'BR002', 12, 'Superstay Teddy Tint', 'Maybelline', '93500', '97122', 'PCS', '176', 'download.jpg', '2025-02-04 19:11:34', '2025-02-12 13:56:03'),
(15, 'BR003', 14, 'Dazzle Me Supore-Fine Skin Makeup Primer', 'Dazzle Me', '37500', '49900', 'PCS', '239', '1739343347_dazz.png', '2025-02-12 13:55:07', NULL),
(16, 'BR004', 15, 'PinkFlash Pro Touch Pencil Eyeliner', 'PinkFlash ', '31200', '38000', 'PCS', '114', '1739343593_PINK.png', '2025-02-12 13:58:29', '2025-02-12 14:01:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `tgl_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `tgl_input`) VALUES
(1, 'Two Way Cake ', '7 May 2017, 10:23'),
(12, 'Lip Tint', ''),
(14, 'Primer', ''),
(15, 'Eyeliner', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id_login` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` char(32) NOT NULL,
  `id_member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id_login`, `user`, `pass`, `id_member`) VALUES
(1, 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4', 1),
(6, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 6),
(7, 'soomen', 'de7b7ebf403069ce9fb85435dd2c4c79', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id_member` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `nm_member` varchar(255) NOT NULL,
  `jenis_kelamin` enum('perempuan','laki-laki') NOT NULL,
  `alamat_member` text NOT NULL,
  `telepon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gambar` text NOT NULL,
  `NIK` text NOT NULL,
  `tgl_masuk` datetime NOT NULL,
  `tgl_keluar` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id_member`, `id_role`, `nm_member`, `jenis_kelamin`, `alamat_member`, `telepon`, `email`, `gambar`, `NIK`, `tgl_masuk`, `tgl_keluar`) VALUES
(1, 1, 'Dal Mi', 'perempuan', 'Oakvalley 1-gil, Jijeong-myeon, Wonju, Provinsi Gangwon.', '+82 123456789', 'example@gmail.com', 'unnamed.jpg', '12314121', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 2, 'Lee Ji-eun', 'perempuan', 'Eunhang-ro, Wansan-gu, kota Jeonju ', ' +82-2-312-3456', 'example@gmail.com', '1739323557.jpg', '800815', '2025-02-12 10:24:07', '0000-00-00 00:00:00'),
(7, 2, ' Kim Soo Hyun', 'laki-laki', '109-128 Chilbong-ro, Hojeo-myeon, Wonju-si, Gangwon-do', ' +82-2-312-3456', 'example@gmail.com', '1739325123_soomen.jpg', '800815', '2025-02-12 14:03:21', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL,
  `periode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `nota`
--

INSERT INTO `nota` (`id_nota`, `id_barang`, `id_member`, `jumlah`, `total`, `tanggal_input`, `periode`) VALUES
(1, 'BR001', 1, '1', '36000', '2025-02-12T00:39:23.101Z', NULL),
(2, 'BR002', 1, '1', '97122', '2025-02-12T00:59:24.365Z', NULL),
(3, 'BR001', 1, '1', '36000', '2025-02-12T01:13:05.486Z', NULL),
(4, 'BR001', 1, '1', '36000', '2025-02-12T01:16:04.461Z', NULL),
(5, 'BR002', 1, '1', '97122', '2025-02-12T01:16:04.461Z', NULL),
(6, 'BR001', 1, '1', '36000', '2025-02-12T02:35:52.687Z', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_barang` varchar(255) NOT NULL,
  `id_member` int(11) NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_input` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_barang`, `id_member`, `jumlah`, `total`, `tanggal_input`) VALUES
(1, 'BR001', 1, '1', '36000', '2025-02-12T00:39:23.101Z'),
(2, 'BR002', 1, '1', '97122', '2025-02-12T00:59:24.365Z'),
(3, 'BR001', 1, '1', '36000', '2025-02-12T01:13:05.486Z'),
(4, 'BR001', 1, '1', '36000', '2025-02-12T01:16:04.461Z'),
(5, 'BR002', 1, '1', '97122', '2025-02-12T01:16:04.461Z'),
(6, 'BR001', 1, '1', '36000', '2025-02-12T02:35:52.687Z');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'administrator'),
(2, 'petugas\r\n');

-- --------------------------------------------------------

--
-- Struktur dari tabel `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(225) NOT NULL,
  `alamat_toko` text NOT NULL,
  `tlp` varchar(13) NOT NULL,
  `nama_pemilik` char(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `alamat_toko`, `tlp`, `nama_pemilik`) VALUES
(1, 'Beauty Unnie', 'Padasuka', '089520535338', 'Melanda Dali');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id_member`);

--
-- Indeks untuk tabel `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id_member` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
