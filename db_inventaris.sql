-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2022 pada 00.02
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventaris`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `nama_barang` varchar(30) NOT NULL,
  `tahun` varchar(100) NOT NULL,
  `jumlah` int(20) NOT NULL,
  `merek` varchar(30) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `id_user`, `id_ruangan`, `nama_barang`, `tahun`, `jumlah`, `merek`, `foto`, `jenis`) VALUES
(6, 1, 11, 'Kursi', '2020', 31, 'Sony', '24663379_A1_3.jpg', 'Kayu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gedung`
--

CREATE TABLE `tb_gedung` (
  `id_gedung` int(11) NOT NULL,
  `nama_gedung` varchar(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  `foto` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_gedung`
--

INSERT INTO `tb_gedung` (`id_gedung`, `nama_gedung`, `id_user`, `foto`) VALUES
(3, 'gedung 3', 1, '24663379_A1.jpg'),
(5, 'gedung 4', 2, 'c2139d2057e604f8c9cb41c83434e234.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_menyimpan`
--

CREATE TABLE `tb_menyimpan` (
  `id_simpan` int(11) NOT NULL,
  `id_ruangan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `tgl_simpan` date NOT NULL,
  `barang_bagus` int(11) NOT NULL,
  `barang_rusak` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_menyimpan`
--

INSERT INTO `tb_menyimpan` (`id_simpan`, `id_ruangan`, `id_barang`, `tgl_simpan`, `barang_bagus`, `barang_rusak`) VALUES
(6, 11, 6, '2022-06-16', 321, 321);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pbarangmasuk`
--

CREATE TABLE `tb_pbarangmasuk` (
  `id_pengadaan` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pembelian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pbarangmasuk`
--

INSERT INTO `tb_pbarangmasuk` (`id_pengadaan`, `id_supplier`, `id_barang`, `harga`, `jumlah`, `tgl_pembelian`) VALUES
(7, 6, 6, 25000, 241, '2022-06-16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id_ruangan` int(11) NOT NULL,
  `id_gedung` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_ruangan` varchar(20) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `kapasitas_ruangan` int(11) NOT NULL,
  `terisi_ruangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_ruangan`
--

INSERT INTO `tb_ruangan` (`id_ruangan`, `id_gedung`, `id_user`, `nama_ruangan`, `foto`, `kapasitas_ruangan`, `terisi_ruangan`) VALUES
(10, 3, 1, 'ruangan 2', '24663379_A1_1.jpg', 12, 12),
(11, 3, 1, 'ruangan 1', '24663379_A1_2.jpg', 21, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(20) NOT NULL,
  `kontak_supplier` int(20) NOT NULL,
  `nama_toko` varchar(20) NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `nama_supplier`, `kontak_supplier`, `nama_toko`, `alamat`) VALUES
(6, 'Wijaya', 2147483647, 'Toko Wijaya', 'Jalan veteran 2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama`, `username`, `password`) VALUES
(1, 'Administrator', 'admin', 'admin'),
(2, 'Renti', 'renti', 'renti');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_barang_user` (`id_user`),
  ADD KEY `fk_barang_ruangan` (`id_ruangan`);

--
-- Indeks untuk tabel `tb_gedung`
--
ALTER TABLE `tb_gedung`
  ADD PRIMARY KEY (`id_gedung`),
  ADD KEY `fk_tb_gedung_user` (`id_user`);

--
-- Indeks untuk tabel `tb_menyimpan`
--
ALTER TABLE `tb_menyimpan`
  ADD PRIMARY KEY (`id_simpan`),
  ADD KEY `fk_menyimpan_ruangan` (`id_ruangan`),
  ADD KEY `fk_menyimpan_barang` (`id_barang`);

--
-- Indeks untuk tabel `tb_pbarangmasuk`
--
ALTER TABLE `tb_pbarangmasuk`
  ADD PRIMARY KEY (`id_pengadaan`),
  ADD KEY `fk_barangmasuk_supplier` (`id_supplier`),
  ADD KEY `fk_barangmasuk_barang` (`id_barang`);

--
-- Indeks untuk tabel `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD PRIMARY KEY (`id_ruangan`),
  ADD KEY `fk_ruangan_user` (`id_user`),
  ADD KEY `fk_ruangan_gedung` (`id_gedung`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_gedung`
--
ALTER TABLE `tb_gedung`
  MODIFY `id_gedung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_menyimpan`
--
ALTER TABLE `tb_menyimpan`
  MODIFY `id_simpan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_pbarangmasuk`
--
ALTER TABLE `tb_pbarangmasuk`
  MODIFY `id_pengadaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  MODIFY `id_ruangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `fk_barang_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `tb_ruangan` (`id_ruangan`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barang_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_gedung`
--
ALTER TABLE `tb_gedung`
  ADD CONSTRAINT `fk_tb_gedung_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_menyimpan`
--
ALTER TABLE `tb_menyimpan`
  ADD CONSTRAINT `fk_menyimpan_barang` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menyimpan_ruangan` FOREIGN KEY (`id_ruangan`) REFERENCES `tb_ruangan` (`id_ruangan`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pbarangmasuk`
--
ALTER TABLE `tb_pbarangmasuk`
  ADD CONSTRAINT `fk_barangmasuk_barang` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_barangmasuk_supplier` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD CONSTRAINT `fk_ruangan_gedung` FOREIGN KEY (`id_gedung`) REFERENCES `tb_gedung` (`id_gedung`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ruangan_user` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
