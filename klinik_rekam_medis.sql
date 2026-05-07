-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Bulan Mei 2026 pada 18.42
-- Versi server: 10.4.32-MariaDB-log
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_rekam_medis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `kode_dokter` varchar(20) DEFAULT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `spesialisasi` varchar(100) DEFAULT NULL,
  `no_sip` varchar(50) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokter`
--

INSERT INTO `dokter` (`id`, `kode_dokter`, `nama_dokter`, `jenis_kelamin`, `spesialisasi`, `no_sip`, `no_telp`, `alamat`, `poli_id`, `status`, `created_at`) VALUES
(1, 'DKT-001', 'dr. Andi Saputra', 'L', 'Dokter Umum', '123/SIP/2023', '081234567890', 'Jl. Merdeka No. 1, Jakarta', 1, 'aktif', '2026-04-23 16:55:54'),
(2, 'DKT-002', 'drg. Budi Santoso', 'L', 'Dokter Gigi', '124/SIP/2023', '081298765432', 'Jl. Sudirman No. 2, Jakarta', 2, 'aktif', '2026-04-23 16:55:54'),
(3, 'DKT-003', 'dr. Citra Lestari, Sp.A', 'P', 'Spesialis Anak', '125/SIP/2023', '081311223344', 'Jl. Thamrin No. 3, Jakarta', 3, 'aktif', '2026-04-23 16:55:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_dokter`
--

CREATE TABLE `jadwal_dokter` (
  `id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal_dokter`
--

INSERT INTO `jadwal_dokter` (`id`, `dokter_id`, `hari`, `jam_mulai`, `jam_selesai`, `poli_id`, `keterangan`) VALUES
(1, 1, 'Senin', '08:00:00', '14:00:00', 1, 'Praktek Pagi'),
(2, 1, 'Rabu', '08:00:00', '14:00:00', 1, 'Praktek Pagi'),
(3, 2, 'Selasa', '09:00:00', '15:00:00', 2, 'Praktek Reguler'),
(4, 3, 'Kamis', '10:00:00', '16:00:00', 3, 'Praktek Reguler');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` int(11) NOT NULL,
  `kode_kunjungan` varchar(30) DEFAULT NULL,
  `pasien_id` int(11) NOT NULL,
  `dokter_id` int(11) NOT NULL,
  `poli_id` int(11) DEFAULT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jam_kunjungan` time DEFAULT curtime(),
  `jenis_kunjungan` enum('baru','lama') DEFAULT 'lama',
  `cara_bayar` enum('umum','bpjs','asuransi','lainnya') DEFAULT 'umum',
  `keluhan_utama` text DEFAULT NULL,
  `status_kunjungan` enum('menunggu','diperiksa','selesai','batal') DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kunjungan`
--

INSERT INTO `kunjungan` (`id`, `kode_kunjungan`, `pasien_id`, `dokter_id`, `poli_id`, `tanggal_kunjungan`, `jam_kunjungan`, `jenis_kunjungan`, `cara_bayar`, `keluhan_utama`, `status_kunjungan`, `created_at`) VALUES
(1, 'KJ-260420-001', 1, 1, 1, '2026-04-20', '08:30:00', 'baru', 'umum', 'Demam dan pusing sejak 2 hari lalu', 'selesai', '2026-04-23 16:55:54'),
(2, 'KJ-260420-002', 2, 2, 2, '2026-04-20', '09:15:00', 'baru', 'bpjs', 'Sakit gigi geraham bawah kanan', 'selesai', '2026-04-23 16:55:54'),
(3, 'KJ-260420-003', 3, 3, 3, '2026-04-20', '10:30:00', 'lama', 'asuransi', 'Batuk berdahak sudah seminggu', 'selesai', '2026-04-23 16:55:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `id` int(11) NOT NULL,
  `nama_obat` varchar(100) NOT NULL,
  `satuan` varchar(30) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `harga` decimal(12,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `satuan`, `stok`, `harga`, `keterangan`) VALUES
(1, 'Paracetamol 500mg', 'Tablet', 1000, 1000.00, 'Obat penurun panas dan pereda nyeri'),
(2, 'Amoxicillin 500mg', 'Kapsul', 500, 2000.00, 'Antibiotik, harus dihabiskan'),
(3, 'Asam Mefenamat 500mg', 'Tablet', 300, 1500.00, 'Obat pereda nyeri gigi'),
(4, 'OBH Combi Anak', 'Botol', 50, 15000.00, 'Sirup obat batuk anak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pasien`
--

CREATE TABLE `pasien` (
  `id` int(11) NOT NULL,
  `no_rm` varchar(20) NOT NULL,
  `nik` varchar(30) DEFAULT NULL,
  `nama_pasien` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `umur` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `golongan_darah` enum('A','B','AB','O') DEFAULT NULL,
  `alergi` text DEFAULT NULL,
  `status_kawin` varchar(30) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pasien`
--

INSERT INTO `pasien` (`id`, `no_rm`, `nik`, `nama_pasien`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `umur`, `alamat`, `no_telp`, `golongan_darah`, `alergi`, `status_kawin`, `pekerjaan`, `created_at`) VALUES
(1, 'RM-000001', '3171234567890001', 'Dewi Susanti', 'P', 'Bandung', '1990-05-15', 35, 'Jl. Mawar No. 10', '085712341234', 'A', 'Tidak ada', 'Menikah', 'Wiraswasta', '2026-04-23 16:55:54'),
(2, 'RM-000002', '3171234567890002', 'Agus Pratama', 'L', 'Jakarta', '1985-08-20', 40, 'Jl. Melati No. 12', '081999888777', 'O', 'Udang', 'Menikah', 'Karyawan Swasta', '2026-04-23 16:55:54'),
(3, 'RM-000003', '3171234567890003', 'Kevin Julio', 'L', 'Surabaya', '2018-12-10', 7, 'Jl. Anggrek No. 5', '081222333444', 'B', 'Debu', 'Belum Kawin', 'Pelajar', '2026-04-23 16:55:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `poli`
--

CREATE TABLE `poli` (
  `id` int(11) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`, `created_at`) VALUES
(1, 'Poli Umum', 'Melayani keluhan kesehatan umum pasien dewasa', '2026-04-23 16:55:53'),
(2, 'Poli Gigi', 'Melayani pemeriksaan dan tindakan kesehatan gigi dan mulut', '2026-04-23 16:55:53'),
(3, 'Poli Anak', 'Melayani pemeriksaan dan kesehatan bayi serta anak', '2026-04-23 16:55:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id` int(11) NOT NULL,
  `kunjungan_id` int(11) NOT NULL,
  `keluhan` text DEFAULT NULL,
  `riwayat_penyakit` text DEFAULT NULL,
  `tekanan_darah` varchar(20) DEFAULT NULL,
  `suhu_tubuh` varchar(20) DEFAULT NULL,
  `nadi` varchar(20) DEFAULT NULL,
  `pernapasan` varchar(20) DEFAULT NULL,
  `diagnosa_kerja` text DEFAULT NULL,
  `diagnosa_banding` text DEFAULT NULL,
  `pemeriksaan_fisik` text DEFAULT NULL,
  `terapi` text DEFAULT NULL,
  `catatan_dokter` text DEFAULT NULL,
  `tindak_lanjut` text DEFAULT NULL,
  `tanggal_pemeriksaan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekam_medis`
--

INSERT INTO `rekam_medis` (`id`, `kunjungan_id`, `keluhan`, `riwayat_penyakit`, `tekanan_darah`, `suhu_tubuh`, `nadi`, `pernapasan`, `diagnosa_kerja`, `diagnosa_banding`, `pemeriksaan_fisik`, `terapi`, `catatan_dokter`, `tindak_lanjut`, `tanggal_pemeriksaan`) VALUES
(1, 1, 'Demam dan pusing sejak 2 hari', 'Maag', '120/80', '38.5', '88', '20', 'Febris (Observasi)', 'Demam Berdarah', 'Tenggorokan agak merah', 'Paracetamol 3x1', 'Istirahat yang cukup', 'Kontrol 3 hari lagi jika demam tidak turun', '2026-04-23 23:55:54'),
(2, 2, 'Sakit gigi geraham bawah kanan', 'Tidak ada', '130/85', '36.5', '80', '18', 'Pulpitis akut', 'Gingivitis', 'Gigi 46 karies profunda', 'Ekstraksi gigi, Asam Mefenamat 3x1', 'Hindari makanan keras di sisi kanan', 'Kontrol pendarahan', '2026-04-23 23:55:54'),
(3, 3, 'Batuk berdahak', 'Asma', '110/70', '37.0', '90', '24', 'ISPA', 'Bronkitis', 'Suara napas vesikuler, ada ronchi', 'OBH Combi 3x1 cth', 'Banyak minum air hangat', 'Hindari es dan gorengan', '2026-04-23 23:55:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekam_medis_tindakan`
--

CREATE TABLE `rekam_medis_tindakan` (
  `id` int(11) NOT NULL,
  `rekam_medis_id` int(11) NOT NULL,
  `tindakan_id` int(11) NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekam_medis_tindakan`
--

INSERT INTO `rekam_medis_tindakan` (`id`, `rekam_medis_id`, `tindakan_id`, `jumlah`, `catatan`) VALUES
(1, 1, 1, 1, 'Pemeriksaan umum berjalan lancar'),
(2, 2, 2, 1, 'Penyuntikan anestesi 1 ampul (Pehacain)'),
(3, 3, 3, 1, 'Nebulizer dengan Ventolin 1 ampul');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep`
--

CREATE TABLE `resep` (
  `id` int(11) NOT NULL,
  `rekam_medis_id` int(11) NOT NULL,
  `tanggal_resep` datetime DEFAULT current_timestamp(),
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resep`
--

INSERT INTO `resep` (`id`, `rekam_medis_id`, `tanggal_resep`, `catatan`) VALUES
(1, 1, '2026-04-20 08:45:00', 'Bila demam sudah turun, obat bisa dihentikan'),
(2, 2, '2026-04-20 09:40:00', 'Minum obat nyeri sesudah makan'),
(3, 3, '2026-04-20 10:45:00', 'Kocok dahulu sebelum diminum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `resep_detail`
--

CREATE TABLE `resep_detail` (
  `id` int(11) NOT NULL,
  `resep_id` int(11) NOT NULL,
  `obat_id` int(11) NOT NULL,
  `dosis` varchar(100) NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `aturan_pakai` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `resep_detail`
--

INSERT INTO `resep_detail` (`id`, `resep_id`, `obat_id`, `dosis`, `jumlah`, `aturan_pakai`) VALUES
(1, 1, 1, '500mg', 10, '3 x sehari 1 tablet sesudah makan'),
(2, 2, 3, '500mg', 10, '3 x sehari 1 tablet sesudah makan (bila nyeri)'),
(3, 2, 2, '500mg', 10, '3 x sehari 1 kapsul sesudah makan (wajib habiskan)'),
(4, 3, 4, '15ml', 1, '3 x sehari 1 sendok takar sesudah makan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakan`
--

CREATE TABLE `tindakan` (
  `id` int(11) NOT NULL,
  `nama_tindakan` varchar(100) NOT NULL,
  `tarif` decimal(12,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tindakan`
--

INSERT INTO `tindakan` (`id`, `nama_tindakan`, `tarif`, `keterangan`) VALUES
(1, 'Pemeriksaan Dokter Umum', 50000.00, 'Jasa konsultasi dan pemeriksaan dasar'),
(2, 'Cabut Gigi Dewasa', 150000.00, 'Pencabutan gigi dengan anestesi lokal'),
(3, 'Nebulizer', 75000.00, 'Terapi uap untuk masalah pernapasan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','dokter') NOT NULL DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--
-- Catatan: password contoh di bawah akan otomatis di-upgrade menjadi hash
-- saat user berhasil login pertama kali.

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Maria', 'admin', 'admin', 'admin', '2026-04-20 14:56:55'),
(2, 'Rina Melati (Resepsionis)', 'petugas1', 'petugas123', 'petugas', '2026-04-23 16:56:00'),
(3, 'dr. Andi Saputra', 'dr_andi', 'dokter123', 'dokter', '2026-04-23 16:56:00');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_dokter` (`kode_dokter`),
  ADD KEY `poli_id` (`poli_id`);

--
-- Indeks untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `poli_id` (`poli_id`);

--
-- Indeks untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_kunjungan` (`kode_kunjungan`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `dokter_id` (`dokter_id`),
  ADD KEY `poli_id` (`poli_id`),
  ADD KEY `idx_kunjungan_tanggal_status` (`tanggal_kunjungan`,`status_kunjungan`);

--
-- Indeks untuk tabel `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_rm` (`no_rm`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `idx_pasien_nama` (`nama_pasien`);

--
-- Indeks untuk tabel `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kunjungan_id` (`kunjungan_id`);

--
-- Indeks untuk tabel `rekam_medis_tindakan`
--
ALTER TABLE `rekam_medis_tindakan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekam_medis_id` (`rekam_medis_id`),
  ADD KEY `tindakan_id` (`tindakan_id`);

--
-- Indeks untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rekam_medis_id` (`rekam_medis_id`);

--
-- Indeks untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resep_id` (`resep_id`),
  ADD KEY `obat_id` (`obat_id`);

--
-- Indeks untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `poli`
--
ALTER TABLE `poli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rekam_medis_tindakan`
--
ALTER TABLE `rekam_medis_tindakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `resep`
--
ALTER TABLE `resep`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tindakan`
--
ALTER TABLE `tindakan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `dokter`
--
ALTER TABLE `dokter`
  ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_dokter`
--
ALTER TABLE `jadwal_dokter`
  ADD CONSTRAINT `jadwal_dokter_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_dokter_ibfk_2` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD CONSTRAINT `kunjungan_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kunjungan_ibfk_2` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `kunjungan_ibfk_3` FOREIGN KEY (`poli_id`) REFERENCES `poli` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD CONSTRAINT `rekam_medis_ibfk_1` FOREIGN KEY (`kunjungan_id`) REFERENCES `kunjungan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekam_medis_tindakan`
--
ALTER TABLE `rekam_medis_tindakan`
  ADD CONSTRAINT `rekam_medis_tindakan_ibfk_1` FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekam_medis_tindakan_ibfk_2` FOREIGN KEY (`tindakan_id`) REFERENCES `tindakan` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`rekam_medis_id`) REFERENCES `rekam_medis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `resep_detail`
--
ALTER TABLE `resep_detail`
  ADD CONSTRAINT `resep_detail_ibfk_1` FOREIGN KEY (`resep_id`) REFERENCES `resep` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_detail_ibfk_2` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
