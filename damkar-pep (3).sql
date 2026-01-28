-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Jan 2026 pada 08.46
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
-- Database: `damkar-pep`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `folder_mekanisme`
--

CREATE TABLE `folder_mekanisme` (
  `id_folder_mek` varchar(10) NOT NULL,
  `id_parent` varchar(10) DEFAULT NULL,
  `nama_folder_mek` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `pemilik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `folder_monitoring`
--

CREATE TABLE `folder_monitoring` (
  `id_folder_mon` varchar(10) NOT NULL,
  `id_parent` varchar(10) DEFAULT NULL,
  `nama_folder_mon` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `pemilik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `folder_monitoring`
--

INSERT INTO `folder_monitoring` (`id_folder_mon`, `id_parent`, `nama_folder_mon`, `created`, `pemilik`) VALUES
('FLMON00001', NULL, 'Kumpulan Link2 Google Drive', '2025-10-15 22:03:40', 'Developer'),
('FLMON00002', NULL, 'LKPJ', '2025-10-29 14:27:46', 'Developer'),
('FLMON00003', 'FLMON00002', '2024', '2025-10-29 14:29:29', 'Developer'),
('FLMON00004', 'FLMON00002', '2025', '2025-10-29 14:29:34', 'Developer'),
('FLMON00005', NULL, 'LAKIP', '2025-10-29 14:30:53', 'Developer'),
('FLMON00006', NULL, 'SPM', '2025-10-29 14:35:49', 'Developer'),
('FLMON00007', 'FLMON00006', '2023', '2025-10-29 14:36:06', 'Developer'),
('FLMON00008', 'FLMON00006', '2024', '2025-10-29 14:37:06', 'Developer'),
('FLMON00009', 'FLMON00006', '2025', '2025-10-29 14:37:10', 'Developer'),
('FLMON00010', NULL, 'IKK', '2025-10-29 14:41:55', 'Developer'),
('FLMON00011', 'FLMON00010', '2023', '2025-10-29 14:42:10', 'Developer'),
('FLMON00012', 'FLMON00010', '2024', '2025-10-29 14:42:15', 'Developer'),
('FLMON00013', 'FLMON00010', '2025', '2025-10-29 14:42:20', 'Developer'),
('FLMON00014', NULL, 'SAKIP', '2025-10-29 14:47:21', 'Developer'),
('FLMON00015', 'FLMON00014', '2024', '2025-10-29 14:47:53', 'Developer'),
('FLMON00016', 'FLMON00014', 'LHE', '2025-10-29 14:49:06', 'Developer'),
('FLMON00018', 'FLMON00016', '2024', '2025-10-29 14:56:00', 'Developer'),
('FLMON00019', 'FLMON00016', '2023', '2025-10-29 15:08:13', 'Developer'),
('FLMON00020', 'FLMON00014', 'Lembar Evaluasi Mandiri', '2025-10-29 15:12:06', 'Developer'),
('FLMON00021', NULL, 'Surabi', '2025-10-29 15:14:08', 'Developer'),
('FLMON00022', NULL, 'MR', '2025-10-29 15:16:17', 'Developer'),
('FLMON00023', 'FLMON00022', '2024', '2025-10-29 15:17:19', 'Developer'),
('FLMON00024', 'FLMON00022', '2025', '2025-10-29 15:17:30', 'Developer'),
('FLMON00025', NULL, 'SPIP', '2025-10-29 15:21:44', 'Developer'),
('FLMON00026', 'FLMON00025', '2024', '2025-10-29 15:22:00', 'Developer'),
('FLMON00027', 'FLMON00025', '2025', '2025-10-29 15:22:08', 'Developer'),
('FLMON00028', NULL, 'RTP', '2025-10-29 15:24:39', 'Developer'),
('FLMON00029', 'FLMON00028', '2025', '2025-10-31 09:37:50', 'Dila'),
('FLMON00030', NULL, 'Review RKA', '2025-11-21 10:48:03', 'Developer'),
('FLMON00031', NULL, 'tes', '2026-01-09 01:18:42', 'Alfito');

-- --------------------------------------------------------

--
-- Struktur dari tabel `folder_perencanaan`
--

CREATE TABLE `folder_perencanaan` (
  `id_folder_per` varchar(10) NOT NULL,
  `id_parent` varchar(10) DEFAULT NULL,
  `nama_folder_per` varchar(255) NOT NULL,
  `drive_folder_id` varchar(255) DEFAULT NULL,
  `pemilik` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `folder_perencanaan`
--

INSERT INTO `folder_perencanaan` (`id_folder_per`, `id_parent`, `nama_folder_per`, `drive_folder_id`, `pemilik`, `created`) VALUES
('FLRPR00018', NULL, 'Renja', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00019', NULL, 'RKT', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00020', NULL, 'Paparan Dewan', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00021', NULL, 'DPA', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00022', NULL, 'Renstra Perubahan', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00023', NULL, 'Renstra Murni', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00024', NULL, 'Renaksi', NULL, 'Developer', '2025-10-29 10:57:40'),
('FLRPR00025', 'FLRPR00018', '2024', NULL, 'Developer', '2025-10-29 10:58:59'),
('FLRPR00026', 'FLRPR00018', '2025', NULL, 'Developer', '2025-10-29 10:58:59'),
('FLRPR00027', 'FLRPR00019', '2024', NULL, 'Developer', '2025-10-29 11:00:48'),
('FLRPR00028', 'FLRPR00020', '2024', NULL, 'Developer', '2025-10-29 11:03:07'),
('FLRPR00029', 'FLRPR00020', '2025', NULL, 'Developer', '2025-10-29 11:03:07'),
('FLRPR00030', 'FLRPR00021', '2024', NULL, 'Developer', '2025-10-29 11:08:09'),
('FLRPR00031', 'FLRPR00021', '2025', NULL, 'Developer', '2025-10-29 11:08:09'),
('FLRPR00032', 'FLRPR00022', '2021-2026', NULL, 'Developer', '2025-10-29 11:13:16'),
('FLRPR00033', 'FLRPR00023', '2021-2026', NULL, 'Developer', '2025-10-29 11:14:05'),
('FLRPR00034', 'FLRPR00024', '2024', NULL, 'Developer', '2025-10-29 11:14:50'),
('FLRPR00042', NULL, 'SK', NULL, 'Developer', '2025-10-29 14:24:54'),
('FLRPR00043', 'FLRPR00042', 'SK IKU', NULL, 'Developer', '2025-10-29 14:26:32'),
('FLRPR00044', NULL, 'RTP', NULL, 'Dila', '2025-11-17 11:51:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dasar_hukum`
--

CREATE TABLE `tbl_dasar_hukum` (
  `id_hukum` varchar(10) NOT NULL,
  `nama_hukum` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `pemilik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dasar_hukum`
--

INSERT INTO `tbl_dasar_hukum` (`id_hukum`, `nama_hukum`, `created`, `pemilik`) VALUES
('HUKUM00001', '1.	Undang-Undang Nomor 15 Tahun 1999 tentang Pembentukan Kotamadya Daerah Tingkat II Cilegon dan Kotamadya Daerah Tingkat II Depok (Lembaran Negara Republik Indonesia Tahun 1999 Nomor 49, Tambahan Lembaran Negara Republik Indonesia Nomor 3828);', '2025-10-17 10:30:12', 'Developer'),
('HUKUM00002', '2.	Undang-Undang Nomor 28 Tahun 1999, tentang Penyelenggaraan Negara yang Bersih dan Bebas dari Korupsi, Kolusi dan Nepotisme (Lembar  Negara Republik Indonesia Tahun 1999 Nomor 75, Tambahan Lembaran Negara Republik Indonesia Nomor 3851);', '2025-10-17 10:30:28', 'Developer'),
('HUKUM00003', '3.	Undang-Undang Nomor 17 Tahun 2003, tentang Keuangan Negara (Lembaran Negara Republik Indonesia Tahun 2003 Nomor 47, Tambahan Lembaran Negara Republik Indonesia Nomor 4286); ', '2025-10-17 10:30:40', 'Developer'),
('HUKUM00004', '4.	Undang-undang Nomor 25 Tahun 2004 tentang Sistem Perencanaan Pembangunan Nasional (Lembaran Negara Republik Indonesia Tahun 2004 Nomor 104, Tambahan Lembaran Negara Republik Indonesia Nomor 4421);', '2025-10-17 10:30:49', 'Developer'),
('HUKUM00005', '5.	Undang-Undang Nomor 23 Tahun 2014, tentang Pemerintahan Daerah (Lembaran Negara Republik Indonesia Tahun 2004 Nomor 125, Tambahan Lembaran Negara Republik Indonesia Nomor 4437) sebagaimana telah diubah terakhir dengan Undang-Undang Nomor 12 Tahun 2008 ', '2025-10-17 10:30:57', 'Developer'),
('HUKUM00006', '6.	Peraturan Pemerintah Nomor 72 Tahun 2019, yang juga mengatur tentang Perangkat Daerah tentang Perubahan Peraturan Pemerintah Nomor 18 Tahun 2016 tentang Perangkat Daerah;', '2025-10-17 10:31:08', 'Developer'),
('HUKUM00007', '7.	Peraturan Pemerintah Nomor 8 Tahun 2008 tentang Tahapan, Tata Cara Penyusunan, Pengendalian dan Evaluasi Pelaksanaan Rencana Pembangunan Daerah;', '2025-10-17 10:31:18', 'Developer'),
('HUKUM00008', '8. Peraturan Pemerintah Nomor 2 Tahun 2018 tentang Standar Pelayanan Minimal (Lembar Negara Republik Indonesia Tahun 2018 Nomor 2);', '2025-10-17 10:31:56', 'Developer'),
('HUKUM00009', '9.	Peraturan Presiden Nomor 12 Tahun 2025 tentang Rencana Pembangunan Jangka Menengah Nasional (RPJMN) Tahun 2025-2029;', '2025-10-17 10:32:09', 'Developer'),
('HUKUM00010', '10.	Peraturan Menteri Dalam Negeri Nomor 86 Tahun 2017 tentang Pelaksanaan Peraturan Pemerintah Nomor 8 Tahun 2008 tentang Tata Cara Perencanaan, Pengendalian dan Evaluasi Rancangan Peraturan Daerah tentang Rencana Pembangunan Jangka Panjang Daerah dan Re', '2025-10-17 10:32:20', 'Developer'),
('HUKUM00011', '11.	Permendagri Nomor 90 Tahun 2019 tentang Klasifikasi, Kodefikasi, dan Nomenklatur Perencanaan Pembangunan dan Keuangan Daerah.  ', '2025-10-17 10:32:29', 'Developer'),
('HUKUM00012', '12.	Permendagri Nomor 70 Tahun 2019 tentang Sistem Informasi Pemerintahan Daerah yang juga relevan dengan konteks perencanaan pembangunan daerah. ', '2025-10-17 10:32:45', 'Developer'),
('HUKUM00013', '13.	Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 100 Tahun 2018 tentang Penerapan Standar Pelayanan Minimal  ', '2025-10-17 10:32:55', 'Developer'),
('HUKUM00014', '14.	Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 114 Tahun 2018 tentang Standar Teknis Pelayanan Dasar Pada Standar Pelayanan Minimal Sub Urusan Kebakaran Daerah Kabupaten/Kota;', '2025-10-17 10:33:06', 'Developer'),
('HUKUM00015', '15.	Peraturan Menteri Dalam Negeri Republik Indonesia Nomor 101 Tahun 2018 tentang Standar Teknis Pelayanan Dasar Pada Standar Pelayanan Minimal Sub-Urusan Bencana Daerah Kabupaten/Kota', '2025-10-17 10:33:23', 'Developer'),
('HUKUM00016', '16.	Peraturan Daerah Provinsi Jawa Barat Nomor 6 Tahun 2009 tentang Sistem Perencanaan Pembangunan Daerah Provinsi Jawa Barat;', '2025-10-17 10:33:51', 'Developer'),
('HUKUM00017', '17.	Peraturan Daerah Provinsi Jawa Barat Nomor 12 Tahun 2024 tentang Rencana Pembangunan Jangka Panjang Daerah Tahun 2025-2045;', '2025-10-17 10:34:01', 'Developer'),
('HUKUM00018', '18.	Peraturan Daerah Provinsi Jawa Barat Nomor  … Tahun 2025 tentang Rencana Jangka Menengah Daerah Provinsi Jawa Barat Tahun 2025-2029;', '2025-10-17 10:34:12', 'Developer'),
('HUKUM00019', '19.	Peraturan Daerah Kota Depok Nomor 07 Tahun 2008 tentang Urusan Pemerintahan Wajib dan Pilihan yang Menjadi Kewenangan Pemerintah Kota Depok (Lembaran Daerah Kota Depok Tahun 2008 Nomor 07); diganti Peraturan Daerah Kota Depok Nomor 2 Tahun 2017 tentan', '2025-10-17 10:35:26', 'Developer'),
('HUKUM00020', '20.	Peraturan Daerah Kota Depok Nomor 06 Tahun 2010 tentang Perubahan atas Peraturan Daerah Kota Depok Nomor 08 Tahun 2008 tentang Organisasi Perangkat Daerah (Lembaran Daerah Kota Depok Tahun 2010 Nomor 06);', '2025-10-17 10:35:39', 'Developer'),
('HUKUM00021', '21.	Peraturan Daerah Kota Depok Nomor 10 Tahun 2016 tentang Pembentukan dan Susunan Perangkat Daerah Kota Depok (Lembaran Daerah Kota Depok Tahun 2016 Nomor 10);', '2025-10-17 10:35:47', 'Developer'),
('HUKUM00022', '22.	Peraturan Walikota Depok Nomor Nomor 19  Tahun 2019 tentang Perubahan atas Peraturan Walikota Depok Nomor Nomor 112  Tahun 2016 tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi serta Tata Kerja Dinas Pemadam Kebakaran dan Penyelamatan Kota Depo', '2025-10-17 10:35:55', 'Developer'),
('HUKUM00023', '23.	Peraturan Daerah Kota Depok Nomor 12 Tahun 2024 tentang tentang Rencana Pembangunan Jangka Panjang (RPJP) Daerah Kota Depok Tahun 2025-2045;', '2025-10-17 10:36:07', 'Developer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dokumentasi`
--

CREATE TABLE `tbl_dokumentasi` (
  `id_kegiatan` varchar(10) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `tanggal_kegiatan` date NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `ekstensi` varchar(10) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dokumentasi`
--

INSERT INTO `tbl_dokumentasi` (`id_kegiatan`, `nama_kegiatan`, `keterangan`, `tanggal_kegiatan`, `thumbnail`, `ekstensi`, `created`) VALUES
('DKMFD00001', 'Rapat Dewan', 'Rapat Dewan PPAS', '2025-10-27', 'https://drive.google.com/file/d/1hScWb_HS69Kf6uCHnik8S-49P1ohdYEn/view', 'jpeg', '2025-10-31 13:40:23'),
('DKMFD00002', 'Rapat implementasi output kegiatan Magang Mahasiswa BSI Lukman Bio sebagai Kenangan Indah di Damkar', 'Rapat implementasi output kegiatan Magang Mahasiswa BSI Lukman Bio sebagai Kenangan Indah di Damkar', '2025-10-31', 'https://drive.google.com/file/d/1pclJPxi_8z7vRKa-9t9sfyIBv_Gf9Gpp/view', 'jpg', '2025-10-31 13:44:13'),
('DKMFD00003', 'Rapat penetapan target UPT', 'Rapat penetapan target UPT', '2025-11-13', 'https://drive.google.com/file/d/10VbgjjhgFAcUtc5PBhanL9A8lCjiPHNP/view', 'jpg', '2025-11-17 11:44:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_dokumentasi_file`
--

CREATE TABLE `tbl_dokumentasi_file` (
  `id_file` varchar(10) NOT NULL,
  `id_kegiatan` varchar(10) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `ekstensi` varchar(10) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_dokumentasi_file`
--

INSERT INTO `tbl_dokumentasi_file` (`id_file`, `id_kegiatan`, `file_url`, `ekstensi`, `created`) VALUES
('DKMFL00001', 'DKMFD00001', 'https://drive.google.com/file/d/1hScWb_HS69Kf6uCHnik8S-49P1ohdYEn/view', 'jpeg', '2025-10-31 13:40:27'),
('DKMFL00002', 'DKMFD00001', 'https://drive.google.com/file/d/1LVGTKPsZLN7HRx8wUTnyB4LrFyDvMlZT/view', 'jpeg', '2025-10-31 13:40:30'),
('DKMFL00003', 'DKMFD00001', 'https://drive.google.com/file/d/1mSVAnxWU0JmWIlR3UWlS1-dbN9r1vf36/view', 'jpeg', '2025-10-31 13:40:34'),
('DKMFL00004', 'DKMFD00002', 'https://drive.google.com/file/d/1pclJPxi_8z7vRKa-9t9sfyIBv_Gf9Gpp/view', 'jpg', '2025-10-31 13:44:18'),
('DKMFL00005', 'DKMFD00003', 'https://drive.google.com/file/d/10VbgjjhgFAcUtc5PBhanL9A8lCjiPHNP/view', 'jpg', '2025-11-17 11:44:59'),
('DKMFL00006', 'DKMFD00003', 'https://drive.google.com/file/d/1wI57rW9h56mS1SmdEchOGFXIRVCGhXmq/view', 'jpg', '2025-11-17 11:45:06'),
('DKMFL00007', 'DKMFD00003', 'https://drive.google.com/file/d/1-0wsuxOf2ajcLfuBWNFYYC-iO2kua3TK/view', 'jpg', '2025-11-17 11:45:11'),
('DKMFL00008', 'DKMFD00003', 'https://drive.google.com/file/d/18hr8sgb_L9SFLqb58VggpXHMK1u5dcWQ/view', 'jpg', '2025-11-17 11:45:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_mekanisme`
--

CREATE TABLE `tbl_mekanisme` (
  `id_mekanisme` varchar(10) NOT NULL,
  `id_folder_mek` varchar(10) DEFAULT NULL,
  `nama_file` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `pemilik` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_mekanisme`
--

INSERT INTO `tbl_mekanisme` (`id_mekanisme`, `id_folder_mek`, `nama_file`, `link`, `pemilik`, `created`) VALUES
('FILEM00001', '', 'Alur Proses Rencana Strategis Dinas Pemadam Kebakaran dan Penyelamatan Kota Depok', 'https://drive.google.com/file/d/1wLMUFvUdVVrDijY5y2qEpr3rJMYDnlg8/view', 'Developer', '2025-10-31 11:04:56'),
('FILEM00002', '', 'Alur Perencanaan Dan Penganggaran Kota Depok', 'https://drive.google.com/file/d/1TZHMsK_ImI17pWUfBX6Ww81R_Pdvtm1Y/view', 'Developer', '2025-10-31 13:50:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_monitoring_pelaporan`
--

CREATE TABLE `tbl_monitoring_pelaporan` (
  `id_monitoring` varchar(10) NOT NULL,
  `id_folder_mon` varchar(10) DEFAULT NULL,
  `nama_file` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `pemilik` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_monitoring_pelaporan`
--

INSERT INTO `tbl_monitoring_pelaporan` (`id_monitoring`, `id_folder_mon`, `nama_file`, `link`, `pemilik`, `created`) VALUES
('FILMN00001', 'FLMON00001', 'Eviden Surabi RB Damkar', 'https://bitly.cx/j4y8Q', 'Developer', '2025-10-15 07:16:10'),
('FILMN00002', 'FLMON00001', 'Panduan SURABI', 'https://s.id/PanduanBuktiSurabi', 'Developer', '2025-10-15 07:16:32'),
('FILMN00003', 'FLMON00001', 'Paparan OPD pada pembahasan Rancangan APBD TA 202 ke Bag Anggaran BKD', 'https://forms.gle/86asycBGe15wmCa86', 'Developer', '2025-10-15 07:16:56'),
('FILMN00004', 'FLMON00001', 'Data Input PPE  PUG', 'https://drive.google.com/drive/folders/1x4PK08hNonZpuZIvO1YaQBI8C2NPvTCD', 'Developer', '2025-10-15 07:20:56'),
('FILMN00005', 'FLMON00001', 'Data SAKIP Depok 2024', 'https://drive.google.com/drive/folders/1izkRRamWHVBqo_AYgt1K02BkIVkIpvwZ', 'Developer', '2025-10-15 14:27:39'),
('FILMN00006', 'FLMON00001', 'Penilaian Kematangan Perangkat Daerah', 'https://drive.google.com/drive/folders/1-8DRW4ZFQrQ0ZqOi4tHxuH4ABQAtIyeg', 'Developer', '2025-10-15 14:28:23'),
('FILMN00007', 'FLMON00001', 'Rekapitulasi Progres  Kelembagaan', 'https://docs.google.com/spreadsheets/d/1ke-RXv_4zWS5HP7soeFPCzpqEOXjhL5-/edit?gid=2079094594#gid=2079094594', 'Developer', '2025-10-15 14:28:46'),
('FILMN00008', 'FLMON00001', 'Arsitektur Perangkat Daerah', 'https://drive.google.com/drive/folders/12OPNDp9Mhx4Tnf6K-a31YpyFpg6b_980', 'Developer', '2025-10-15 14:29:19'),
('FILMN00009', 'FLMON00001', 'SPIP 2024', 'https://linktr.ee/spiptkotadepok2024', 'Developer', '2025-10-15 14:35:20'),
('FILMN00010', 'FLMON00001', 'MR 2023', 'https://bit.ly/MROPD2023', 'Developer', '2025-10-15 14:37:47'),
('FILMN00011', 'FLMON00001', 'MR 2024', 'https://bit.ly/MROPD2024', 'Developer', '2025-10-15 14:38:05'),
('FILMN00012', 'FLMON00001', 'MR 2025', 'https://bit.ly/DokumenMR2025', 'Developer', '2025-10-15 14:40:17'),
('FILMN00013', 'FLMON00001', 'Metadata', 'https://drive.google.com/drive/u/0/folders/1nNPYCxAr-c6Rzpd8ULMhDCEgJHn1dACq', 'Developer', '2025-10-15 14:40:37'),
('FILMN00014', 'FLMON00001', 'e SOP', 'https://esop.depok.go.id/', 'Developer', '2025-10-15 14:42:08'),
('FILMN00015', 'FLMON00001', 'Reviu RKA request by Irda', 'https://s.id/DasarReviuRKA2025', 'Developer', '2025-10-15 14:42:50'),
('FILMN00016', 'FLMON00001', 'Evaluasi Kelembagaan Menpan', 'https://drive.google.com/drive/folders/1d-wmbKI2cfa9YkIieoDOhqwZUJPgLvkO', 'Developer', '2025-10-15 14:44:41'),
('FILMN00017', 'FLMON00001', 'Pengendalian dan Evaluasi Rumusan Kebijakan  Renja 2025', 'https://drive.google.com/drive/folders/1a-LFtcWtT0GHzVVm8LV7QqGuFbcIPKdP', 'Developer', '2025-10-15 14:45:18'),
('FILMN00018', 'FLMON00001', 'Pengendalian dan Evaluasi Pelaksanaan Perubahan Renja PD Tahun 2024', 'https://s.id/DalevPelaksanaanRenjaPerubahanPD-2024', 'Developer', '2025-10-15 14:45:50'),
('FILMN00019', 'FLMON00001', 'LPPD 2023', 'https://bit.ly/LPPDEPOK2023', 'Developer', '2025-10-15 14:46:18'),
('FILMN00020', 'FLMON00001', 'e SPM', 'https://spm.bangda.kemendagri.go.id/2021/home/login', 'Developer', '2025-10-15 14:47:18'),
('FILMN00021', 'FLMON00001', 'e Sakip Reviu Menpan', 'https://esr.menpan.go.id/', 'Developer', '2025-10-15 14:47:39'),
('FILMN00022', 'FLMON00001', 'Lakip', 'https://lakip.depok.go.id/login', 'Developer', '2025-10-15 14:48:02'),
('FILMN00023', 'FLMON00001', 'Bukti Dukung Pengajuan TPP Kota Depok Tahun 2025', 'http://bit.ly/Kematangan_Perangkat_Daerah_2024', 'Developer', '2025-10-15 14:48:48'),
('FILMN00024', 'FLMON00001', 'MR SPBE Perangkat Daerah', 'https://drive.google.com/drive/folders/1DXsy-ccRqzxAaPcUv-CfkMcB0w-7m5Ye', 'Developer', '2025-10-15 14:49:00'),
('FILMN00025', 'FLMON00001', 'Link Dokumen MR SPBE 2024 hasil Pemantauan', 'https://drive.google.com/drive/folders/1Cf0yT7DBdy-mIkIRV14lf9pDwcBlM_WM', 'Developer', '2025-10-15 14:49:13'),
('FILMN00026', 'FLMON00001', 'Link Kertas Kerja MR SPBE 2024', 'https://drive.google.com/drive/folders/15kVSm2mZiWNePF7z3_5Rp2I68olBKKpY', 'Developer', '2025-10-15 14:49:26'),
('FILMN00027', 'FLMON00001', 'Laporan Evaluasi Hasil Renja TW IV', 'https://s.id/LaporanEvaluasiHasilRenjaPD-TWIV-2024', 'Developer', '2025-10-15 14:49:41'),
('FILMN00028', 'FLMON00001', 'Aplikasi Melihat Aparatur yang tersertifikasi damkar', 'https://registrasi-sidamkar.kemendagri.go.id/', 'Developer', '2025-10-15 14:49:52'),
('FILMN00029', 'FLMON00001', 'Form Data LKPJ', 'https://bit.ly/LKPJDpk2024', 'Developer', '2025-10-15 14:50:09'),
('FILMN00030', 'FLMON00001', 'kelengkapan laporan evaluasi hasil Renja PD tw 4', 'https://s.id/LaporanEvaluasiHasilRenjaPD-TWIV-2024', 'Developer', '2025-10-15 14:50:26'),
('FILMN00031', 'FLMON00001', 'Dokumen MR SPBE 2025', 'https://drive.google.com/drive/u/0/folders/1jtbjPY6KTashk_hT56FQmxxDKapBTNkE', 'Developer', '2025-10-15 14:50:39'),
('FILMN00032', 'FLMON00001', 'Dokumen OPD Tahun 2020 s/d 2024', 'https://bit.ly/DokumenOPD_2020-2024', 'Developer', '2025-10-15 14:56:31'),
('FILMN00033', 'FLMON00001', 'SPBE Akses ke Kertas Kerja setiap PD', 'https://drive.google.com/drive/folders/12OPNDp9Mhx4Tnf6K-a31YpyFpg6b_980?usp=share_link', 'Developer', '2025-10-15 14:56:49'),
('FILMN00034', 'FLMON00001', 'Evaluasi Hasil Renstra', 'https://s.id/EvaluasiRenja2026_Renstra2021-2026', 'Developer', '2025-10-15 15:00:21'),
('FILMN00035', 'FLMON00001', 'Laporan akhir masa jabatan Walikota-permintaan Inspektorat Provinsi', 'https://docs.google.com/spreadsheets/d/1bFooFlRdfM5pvkIinRRdv8-9_gxL7CGHzK99kPAiWaw/edit?gid=1013340217#gid=1013340217', 'Developer', '2025-10-15 15:02:32'),
('FILMN00036', 'FLMON00001', 'RPJMD dan Penyusunan Renstra 2025 sd 2029', 'https://drive.google.com/drive/folders/152aOTKZ_9h8UWXlejxcBKS3wz8KQQWJb', 'Developer', '2025-10-15 15:02:52'),
('FILMN00037', 'FLMON00001', 'LAKIP 2024', 'https://drive.google.com/file/d/1dOhfvBYQxPWPnLXTl3kkuzwyNif8eIGR/view?usp=drive_link', 'Developer', '2025-10-15 15:03:19'),
('FILMN00038', 'FLMON00001', 'SAKIP 2023', 'https://bit.ly/dok_sakip_2023', 'Developer', '2025-10-15 15:03:30'),
('FILMN00039', 'FLMON00001', 'SAKIP 2024', 'https://bit.ly/SAKIPDEPOK2024', 'Developer', '2025-10-15 15:03:43'),
('FILMN00040', 'FLMON00001', 'Laporan Evaluasi Hasil Renja PD TW I Tahun 2025 diminta Bu Siti Bappeda', 'https://s.id/LaporanEvaluasiHasilRenjaPD-TWI-2025', 'Developer', '2025-10-15 15:03:54'),
('FILMN00041', 'FLMON00001', 'Laporan Evaluasi Hasil Renja PD TW II Tahun 2025', 'https://s.id/LaporanHasilEvaluasiRenjaPD-TWII-2025', 'Developer', '2025-10-15 15:04:05'),
('FILMN00042', 'FLMON00001', 'KUMPULAN DOKUMEN DAMKAR 2025', 'https://bit.ly/DokDamkar2025', 'Developer', '2025-10-15 15:04:19'),
('FILMN00043', 'FLMON00001', 'Dalev Kebijakan Renja 2026 dan Perubahan Renja 2025', 'https://s.id/DalevKebijakanRenja2026_PerubahanRenja2025D', 'Developer', '2025-10-15 15:04:29'),
('FILMN00044', 'FLMON00001', 'Data SADEPOK', 'https://drive.google.com/drive/folders/1v9vAxfdIc7jWcfHolEQN6e1MEl_ClIDL', 'Developer', '2025-10-15 15:04:40'),
('FILMN00045', 'FLMON00001', 'SPIP 2025', 'https://drive.google.com/drive/u/1/folders/1zSqzDGDcWo-yUYmnDA9fNQuOBEEltSY8', 'Developer', '2025-10-15 15:04:51'),
('FILMN00046', 'FLMON00001', 'Link lembar kontrol inputan sipd', 'https://docs.google.com/spreadsheets/d/1LkfpaPRtau5r_8fKBZ_709AACYin0qb8vaWA-jZm5Rg/edit?usp=sharing', 'Developer', '2025-10-15 15:05:03'),
('FILMN00047', 'FLMON00001', 'Data Dukungan RTLHE SAKIP 2024', 'https://drive.google.com/drive/folders/1A9LrDWGb2O4MtejlcpcapIKH2jeM53ll?usp=sharing', 'Developer', '2025-10-15 15:05:17'),
('FILMN00048', 'FLMON00001', 'SAKIP 2025', 'https://bit.ly/SAKIP_DEPOK_2025', 'Developer', '2025-10-15 15:05:25'),
('FILMN00049', 'FLMON00001', 'Data target dan realisasi indikator TPB/SDG’s tahun 2024', 'https://s.id/Monev_TPB_2024', 'Developer', '2025-10-15 15:05:44'),
('FILMN00050', 'FLMON00001', 'Eviden SURABI 2025', 'http://bit.ly/EVIDENSURABI2025', 'Developer', '2025-10-15 15:05:53'),
('FILMN00051', 'FLMON00001', 'E.68. Pengendalian dan Evaluasi Terhadap Kebijakan Renstra PD', 'https://drive.google.com/drive/folders/1bbXXtDzyhMG6ao-uJWXUsfLwfZIULtdv', 'Developer', '2025-10-15 15:06:02'),
('FILMN00052', 'FLMON00001', 'RENSTRA PD 2025-2029', 'https://drive.google.com/drive/folders/152aOTKZ_9h8UWXlejxcBKS3wz8KQQWJb', 'Developer', '2025-10-15 15:06:17'),
('FILMN00053', 'FLMON00001', 'RENSTRA 2025-2029', 'https://drive.google.com/drive/folders/1d0P6pDAaO0z-smc3S6lnk4fVYn2eZiCF', 'Developer', '2025-10-15 15:06:36'),
('FILMN00054', 'FLMON00001', 'Link Surabi 3.0 (Username: tofanillan@gmail.com Password: 12345)', 'https://surabi.jabarprov.go.id/login', 'Developer', '2025-10-15 15:06:56'),
('FILMN00055', 'FLMON00001', 'Form Monev Indikator Makro. IKU,IKD,IKK, TW III Tahun 2025', 'https://bit.ly/DokumenOPD_2020-2024', 'Developer', '2025-10-15 15:07:05'),
('FILMN00056', 'FLMON00003', 'LKPJ Damkar Tahun 2024.pdf', 'https://drive.google.com/file/d/17aPlfGgSgu3ZNPmhaPmIHmWYxYyn-Mf7/view', 'Developer', '2025-10-29 14:30:18'),
('FILMN00057', 'FLMON00003', 'PAPARAN LKPJ Wali Kota Depok Tahun 2024_Dinas Damkar 26042025.ppt', 'https://drive.google.com/file/d/1cUUaoxSmrpGS9lpx-nIg-uY5V_xKUEbb/view', 'Developer', '2025-10-29 14:30:24'),
('FILMN00058', 'FLMON00003', 'Catatan LKPJ 2024 Untuk Pak Kadis.docx', 'https://drive.google.com/file/d/1cMQo8ebHSuWeU4lTJFOcUUOsJoAx-dyl/view', 'Developer', '2025-10-29 14:30:27'),
('FILMN00059', 'FLMON00007', 'LAPORAN SPM 2023 (6).pdf', 'https://drive.google.com/file/d/153h-IgokU2JIBH6rtaoNEFh0AFXRNial/view', 'Developer', '2025-10-29 14:36:42'),
('FILMN00060', 'FLMON00007', 'LAPORAN SPM DAMKAR TAHUN 2023 (2).docx', 'https://drive.google.com/file/d/1z79w4lHOlBNqGaj5e_NpqvGb9ECrTbJH/view', 'Developer', '2025-10-29 14:36:46'),
('FILMN00061', 'FLMON00008', 'Laporan SPM kebakaran dan bencana  Tahun 2024.docx (1).pdf', 'https://drive.google.com/file/d/12wDjp7RLniTZ9GZxRY8OVUKjJgS5QUUa/view', 'Developer', '2025-10-29 14:37:33'),
('FILMN00062', 'FLMON00009', 'Lap spm  kebakaran dan bencana TW III Tahun 2025  dd  krm charles (13.19 17-10-2025).docx', 'https://drive.google.com/file/d/1ujsM1SUbwO8CKQmJfRN4VD2a_sTAirMB/view', 'Developer', '2025-10-29 14:40:34'),
('FILMN00063', 'FLMON00009', 'Lap spm  kebakaran dan bencana TW II Tahun 2025 Fix Komplet.pdf', 'https://drive.google.com/file/d/1LjyBnw8mPqIBuW8FhK5lMjH3C93cVqgv/view', 'Developer', '2025-10-29 14:40:45'),
('FILMN00064', 'FLMON00009', 'Lap spm  kebakaran dan bencana TW I Tahun 2025  dd pdf.pdf', 'https://drive.google.com/file/d/1xzvZC0fmC57J_P_0nbb5UcsePoXtQS1C/view', 'Developer', '2025-10-29 14:40:55'),
('FILMN00065', 'FLMON00011', 'IKK DAMKAR TAHUN 2023 (5).xlsx', 'https://drive.google.com/file/d/1EPcIDrl7-JaKwf7SwOkSIx_axKLVT7I8/view', 'Developer', '2025-10-29 14:42:49'),
('FILMN00066', 'FLMON00011', 'IKK DAMKAR.pdf', 'https://drive.google.com/file/d/1eA95REStUdR2iVb4Rgj1sYXaL9joOms2/view', 'Developer', '2025-10-29 14:42:54'),
('FILMN00067', 'FLMON00012', 'REKAP IKK DAMKAR REV REV REV 26 maret 2024.xlsx (2).pdf', 'https://drive.google.com/file/d/148oy5yUm92AfxcoaYcKlJk37f106vbsL/view', 'Developer', '2025-10-29 14:43:25'),
('FILMN00068', 'FLMON00012', 'IKK DAMKAR TAHUN 2024 FIX 16 JAN SORE.xlsx', 'https://drive.google.com/file/d/1cSoZZREY_piy4rayNZZdRtZw2jjoife-/view', 'Developer', '2025-10-29 14:44:01'),
('FILMN00069', 'FLMON00015', 'Matriks_Tindak_Lanjut_SAKIP_2024.xlsx', 'https://drive.google.com/file/d/1a6ejP5dGGcsrOMKgwhAIwxXxd56HxGUv/view', 'Developer', '2025-10-29 14:48:21'),
('FILMN00070', 'FLMON00015', 'KELENGKAPAN DATA SAKIP 2024_link bit.ly_11 Juni 2024.xlsx', 'https://drive.google.com/file/d/1KtA-PVuvaL2lIAvCwaEAV2Dwie16r5ty/view', 'Developer', '2025-10-29 14:48:24'),
('FILMN00071', 'FLMON00015', 'Penguatan SAKIP Kota Depok 190224 (2).pdf', 'https://drive.google.com/file/d/1g3vHqK8uBsG-5GTpXD8Isi-C-KfTZYmf/view', 'Developer', '2025-10-29 14:48:39'),
('FILMN00072', 'FLMON00018', '700-195-Evaluasi-Insp-2024, LHE atas Impelentasi SAKIP pada Damkar 2024-1.pdf', 'https://drive.google.com/file/d/1-iMyLxbUsoZgx5YinBp4uQNBLEFIojcX/view', 'Developer', '2025-10-29 15:08:00'),
('FILMN00073', 'FLMON00019', 'LHE 2023 Penilaian Thn 2024.pdf', 'https://drive.google.com/file/d/1K8Gg63pAocSF0Zs4g0dsMyIW7zIDgE8c/view', 'Developer', '2025-10-29 15:08:45'),
('FILMN00074', 'FLMON00020', 'Lembar Evaluasi Mandiri SAKIP Pak Ferry done(1).xlsx', 'https://drive.google.com/file/d/1ntBCiQ7TZCnSlYl0t7Z7B0JFRb34UHd8/view', 'Developer', '2025-10-29 15:13:05'),
('FILMN00075', 'FLMON00021', 'Kontak Evaluator Surabi Jabar', 'https://drive.google.com/file/d/1BSYDOIi9OWdk1UavyS6NepXjsxoLlJku/view', 'Developer', '2025-11-17 11:53:54'),
('FILMN00076', 'FLMON00021', 'PANDUAN DATA DUKUNG LINGKUP DINAS BADAN(1).xlsx', 'https://drive.google.com/file/d/1ooZx2ygJi1cSjzoqz_QUNEjm_uHRVToC/view', 'Developer', '2025-10-29 15:14:39'),
('FILMN00077', 'FLMON00021', 'Link Eviden Surabi Damkar', 'https://drive.google.com/drive/folders/11jABtR9wrQhYWqn1J_sY5ra0Hk0DfKH2', 'Developer', '2025-10-29 15:15:19'),
('FILMN00078', 'FLMON00023', 'MANAJEMEN RISIKO DAMKAR 2024 (1).pdf', 'https://drive.google.com/file/d/1wv3ZE298a-rZoPlpWC5dGm-BDn-c9ULV/view', 'Developer', '2025-10-29 15:18:01'),
('FILMN00079', 'FLMON00023', 'MR 2024_2.xlsx', 'https://drive.google.com/file/d/1lU_1eUHe-0PASoUNhS_b79TY93etsfnu/view', 'Developer', '2025-10-29 15:18:06'),
('FILMN00080', 'FLMON00024', 'MR Damkar 2025_06082025.xlsx', 'https://drive.google.com/file/d/16rC2eSKhiY75C7_T4CoNB8rrECgkrbs2/view', 'Developer', '2025-10-29 15:18:51'),
('FILMN00081', 'FLMON00024', 'MANAJEMEN RISIKO DAMKAR 2025 (3).doc', 'https://drive.google.com/file/d/1WXLrtYB7MM3KMLI_wZOXXezEUciduzW5/view', 'Developer', '2025-10-29 15:18:57'),
('FILMN00082', 'FLMON00024', 'Manajemen Resiko 2025.pdf', 'https://drive.google.com/file/d/1d9PPafF3NMGVpFLMLZWzt5x60J5li8mE/view', 'Developer', '2025-10-29 15:19:14'),
('FILMN00083', 'FLMON00027', 'KK PM SPIP Pemda_07052025 Damkar 8 Juli 2025 done (1).xlsx', 'https://drive.google.com/file/d/1mPkRp7ID0rPlO2LGC7eEyzEkrPDM85Ln/view', 'Developer', '2025-10-29 15:23:37'),
('FILMN00084', 'FLMON00027', 'Paparan Pendampingan SPIP PD 2025 (1).pptx', 'https://drive.google.com/file/d/16AN_ymAqh62WZLyFnf8uljtJMi4lRuXo/view', 'Developer', '2025-10-29 15:23:45'),
('FILMN00085', 'FLMON00027', 'surat pendampingan SPIP T Tahun 2025(signed) (2).pdf', 'https://drive.google.com/file/d/1AdHfOHDPDSHVzF0UAo_JSPxLZBHMDalY/view', 'Developer', '2025-10-29 15:23:49'),
('FILMN00086', 'FLMON00028', 'LAPORAN PEMANTAUAN RTP TW I_damkar2024 (1).docx', 'https://drive.google.com/file/d/1AvOjCij9Mn_hhGOa-zH-EaL5gqzpkR_5/view', 'Developer', '2025-10-29 15:24:58'),
('FILMN00087', 'FLMON00028', 'Laporan RTP Pengendalian Risiko Damkar 2024.pdf', 'https://drive.google.com/file/d/1gGBGXbCmSKOwKLyduwPl9OZMzaWnyzOP/view', 'Developer', '2025-10-29 15:25:08'),
('FILMN00088', 'FLMON00028', 'LAPORAN PEMANTAUAN RTP TW 2 DP3AP2KB.docx', 'https://drive.google.com/file/d/18mY6_pW2MhW_N5AF1tk3s--DhPhIsCAC/view', 'Developer', '2025-10-29 15:25:15'),
('FILMN00089', 'FLMON00029', 'Pemantauan Rencana Tindak Lanjut Pengendalian Manajemen Risiko TW III.pdf', 'https://drive.google.com/file/d/1cQtAf1jGW0rLqVHyP7ZwnuN4iwaIWe88/view', 'Dila', '2025-10-31 09:38:25'),
('FILMN00090', 'FLMON00029', 'Pemantauan RTP Manajemen Resiko TW 1.pdf', 'https://drive.google.com/file/d/1BuL51C9uLPzYF0wUlugv3QHggOP2QMLf/view', 'Dila', '2025-10-31 09:38:35'),
('FILMN00091', 'FLMON00029', 'Pemantauan Rencana Tindak Lanjut Pengendalian Manajemen Risiko TW II.pdf', 'https://drive.google.com/file/d/1iyRe4vEHuPBoO2p9cmdycB_-XDvmijMI/view', 'Dila', '2025-10-31 09:38:45'),
('FILMN00092', 'FLMON00001', 'Ewalidata UserID : admin.damkar Password : depok123', 'https://sipd.go.id/ewalidata/', 'Dila', '2025-10-31 09:41:32'),
('FILMN00093', 'FLMON00001', 'Dok Reviu RKA', 'https://drive.google.com/drive/folders/1ilu5uFhFqJC7sHk4op93crnPcjlWSMIh', 'sumarjo', '2025-11-07 09:20:03'),
('FILMN00094', 'FLMON00030', '700-95-Evaluasi-Insp-2025, LHE PPRG DAMKAR 2024.pdf', 'https://drive.google.com/file/d/1yWdwvyc3sAaZR1AzSlmdx-TC5nkenoCU/view', 'Developer', '2025-11-21 10:48:50'),
('FILMN00095', 'FLMON00030', '700-195-Evaluasi-Insp-2025, LHE atas Impelentasi SAKIP pada Damkar 2024.pdf', 'https://drive.google.com/file/d/1CZdOqHtUuFfuAWoPHMTNMkwJMBYzLtgb/view', 'Developer', '2025-11-21 10:50:33'),
('FILMN00096', 'FLMON00030', '700-429-Reviu-Insp-2025, LHR RKA Perubahan Damkar 2025.pdf', 'https://drive.google.com/file/d/1_7sjJDJodyQvdM6gcxSTSXcpXNz_EHip/view', 'Developer', '2025-11-21 10:57:46'),
('FILMN00097', 'FLMON00001', 'Link Dokumen Reviu RKA damkar 2026 : ', 'https://drive.google.com/drive/folders/1cJTaLSYPIsh_FZFoKEnF50HiVPnKkPYq?usp=sharing', 'Developer', '2025-11-26 10:48:16'),
('FILMN00098', 'FLMON00001', 'RKA 2026 seDepok', 'https://tinyurl.com/DokRKA2026', 'Developer', '2025-11-26 10:49:05'),
('FILMN00099', 'FLMON00001', 'SPM 2024', 'https://drive.google.com/drive/u/0/folders/1yD_Owjd7CgSqKErLXOFH-n80-pMXK8SK', 'Developer', '2025-12-03 11:40:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_perencanaan`
--

CREATE TABLE `tbl_perencanaan` (
  `id_perencanaan` varchar(10) NOT NULL,
  `id_folder_per` varchar(10) NOT NULL,
  `nama_file` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `pemilik` varchar(255) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tbl_perencanaan`
--

INSERT INTO `tbl_perencanaan` (`id_perencanaan`, `id_folder_per`, `nama_file`, `link`, `pemilik`, `created`) VALUES
('FILEP00051', 'FLRPR00025', 'Dokumen Renja 2024 New.pdf', 'https://drive.google.com/file/d/1oFHrS24CQGiV6BQtWysNwb2RIgLGQrdK/view', 'Developer', '2025-10-29 10:59:48'),
('FILEP00052', 'FLRPR00026', 'LAPORAN HASIL RENJA TW II th 2025.pdf', 'https://drive.google.com/file/d/1RuYCQeKjGF_MsH-zVaQ_ZkTQanRuzM7R/view', 'Developer', '2025-10-29 11:00:21'),
('FILEP00053', 'FLRPR00026', 'LAPORAN HASIL RENJA TW I th 2025_DAMKAR.pdf', 'https://drive.google.com/file/d/1DGDrbrN8eM2P9AB4eKr9IS6Eyp3xL1i1/view', 'Developer', '2025-10-29 11:00:27'),
('FILEP00054', 'FLRPR00027', 'RKT DAMKAR 2024.pdf', 'https://drive.google.com/file/d/1APIvu92_R-LhPnBhfX1hF7EHTL9h3loR/view', 'Developer', '2025-10-29 11:01:22'),
('FILEP00055', 'FLRPR00028', 'DAMKAR.pdf', 'https://drive.google.com/file/d/1tYVmjlOzgY8Wa_Oe7hKjC2cxnqMvRd3B/view', 'Developer', '2025-10-29 11:03:54'),
('FILEP00056', 'FLRPR00028', 'PERUBAHAN PERANGKAT DAERAH PADA PERUBAHAN APBD TA.2024_semester 1.pptx', 'https://drive.google.com/file/d/1_CxEI5SyKiBa8Aucncy-S29c9GtKlTD5/view', 'Developer', '2025-10-29 11:04:04'),
('FILEP00057', 'FLRPR00028', 'Rapat Komisi C DPRD Kota Depok_ Nov 2024.pptx', 'https://drive.google.com/file/d/1X0Eewe22hi1RJsFNYZoaBExfJYDB7uv0/view', 'Developer', '2025-10-29 11:04:10'),
('FILEP00058', 'FLRPR00028', 'Rekap Perubahan Belanja Daerah Damkar 2024-Fix.pdf', 'https://drive.google.com/file/d/1Z5CVZ91RzwxfUU-hUxb7qv14LBB8qCJy/view', 'Developer', '2025-10-29 11:04:35'),
('FILEP00059', 'FLRPR00028', 'Rekap Perubahan Belanja Daerah Detail Damkar_2024.pdf', 'https://drive.google.com/file/d/1Df1uwc9gXmSMaAHrbmvPX-TkZcDKZHOH/view', 'Developer', '2025-10-29 11:04:39'),
('FILEP00060', 'FLRPR00028', 'Rekapitulasi Perubahan Belanja Daerah (paparan Raperda)_2024.xlsx', 'https://drive.google.com/file/d/1b3k3Q2jzwAEfWCb_jQgNrKDSRbhFoNFk/view', 'Developer', '2025-10-29 11:04:43'),
('FILEP00061', 'FLRPR00028', 'RENCANA KERJA PERUBAHAN PERANGKAT DAERAH 2024_KUA PPAS.pptx', 'https://drive.google.com/file/d/1c9IhhUjMkJ3BNueLVtaDlhVU70O4jn-_/view', 'Developer', '2025-10-29 11:04:52'),
('FILEP00062', 'FLRPR00029', 'Contoh paparan SKPD pd pembahasan RAPBD TA 2025.pptx', 'https://drive.google.com/file/d/1IkkphaBYbdDIdHn8yr7fuZsnp_nkkeBa/view', 'Developer', '2025-10-29 11:05:32'),
('FILEP00063', 'FLRPR00029', 'DAMKAR Paparan 2025.pptx', 'https://drive.google.com/file/d/1l0UhI49zu9ULUTYjpLGf9OzSzR53ZyVL/view', 'Developer', '2025-10-29 11:05:37'),
('FILEP00064', 'FLRPR00029', 'DAMKAR_Komisi B_PAPARAN RAPAT KERJA PERUBAHAN 2025.pptx', 'https://drive.google.com/file/d/13-Vk8W3AdhxnV3vOI8WRjhqVHp5xBF4g/view', 'Developer', '2025-10-29 11:05:41'),
('FILEP00065', 'FLRPR00029', 'DAMKAR_Komisi C_PAPARAN RAPAT KERJA PERUBAHAN 2025.pptx', 'https://drive.google.com/file/d/1RXGgmPUJyA1bGdg2RNuwOYTX5pgmIOyU/view', 'Developer', '2025-10-29 11:05:45'),
('FILEP00066', 'FLRPR00029', 'DAMKAR_PAPARAN PERUBAHAN APBD TA.2025_Perubahan PPAS dgn Bangar DPRD Kota Depok.pptx', 'https://drive.google.com/file/d/10i6HXM-oImpB-B9e3wb7DwqL2ezyrh5z/view', 'Developer', '2025-10-29 11:05:52'),
('FILEP00067', 'FLRPR00029', 'DAMKAR_PAPARAN RAPAT RAPERDA Pertanggungjawaban Pelaksanaan APBD Kota Depok TA 2024.pptx', 'https://drive.google.com/file/d/1CoZCxSKN6rC9rW8IvIa9R_WW4qUwU6WM/view', 'Developer', '2025-10-29 11:05:55'),
('FILEP00068', 'FLRPR00029', 'new REVISI DAMKAR_Prioritas dan Plafon Anggaran Sementara TA 2025.pptx', 'https://drive.google.com/file/d/1Bgrbrn164zp3FC96H3uPKDTsIusd90mW/view', 'Developer', '2025-10-29 11:06:01'),
('FILEP00069', 'FLRPR00029', 'Paparan Lengkap Renstra Dinas Damkar final_1.pptx', 'https://drive.google.com/file/d/13Vf8jwDBwDNDyJWH6RxzR1V7QkTODFTu/view', 'Developer', '2025-10-29 11:06:08'),
('FILEP00070', 'FLRPR00029', 'PAPARAN LKPJ Wali Kota Depok Tahun 2024_Dinas Damkar 10042025.ppt', 'https://drive.google.com/file/d/1E4Vkmph-rcZLkmkRiCH3ywDebpI5ZHZi/view', 'Developer', '2025-10-29 11:06:15'),
('FILEP00071', 'FLRPR00029', 'PAPARAN PPAS DISDAGIN TA 2025(00001).pptx', 'https://drive.google.com/file/d/1bw7ylMqmydsVHpja7hFzU3uqm9CGB_By/view', 'Developer', '2025-10-29 11:06:30'),
('FILEP00072', 'FLRPR00029', 'PAPARAN RENSTRA 2025-2029 DAMKAR BAHAN RAPAT DEWAN 01082025_Rev Akhir.pptx', 'https://drive.google.com/file/d/1dnmTQ1ku5a5Fn7klyiZePElI_R_UU1-L/view', 'Developer', '2025-10-29 11:06:43'),
('FILEP00073', 'FLRPR00029', 'PAPARAN_PEMBAHASAN RAPBD TA 2025.pptx', 'https://drive.google.com/file/d/1dC17UaE6VNVzKbYHKUTJ9XYUDhsVYg6l/view', 'Developer', '2025-10-29 11:06:48'),
('FILEP00074', 'FLRPR00029', 'RAPERDA tentang pertanggungjawaban pelaksanaan APBD TA.2024.xlsx', 'https://drive.google.com/file/d/1uxGHuQXBHOsraQCmITnx53QlcXlvL9s9/view', 'Developer', '2025-10-29 11:06:51'),
('FILEP00075', 'FLRPR00029', 'Rekapitulasi Perubahan Belanja Daerah (paparan Raperda)_KUA PPAS TA 2025.xlsx', 'https://drive.google.com/file/d/1tmr1DUWFOpuymklUuAOwtTdvGcQ13WAT/view', 'Developer', '2025-10-29 11:06:55'),
('FILEP00076', 'FLRPR00029', 'Rencana Kerja RKPD Perubahan Tahun 2025 dan Penyampaian Hasil Reses DPRD_21 Mei 2025.xlsx', 'https://drive.google.com/file/d/1nqbZDSr8K4ukblTwCIO9Mc960GA6MoGH/view', 'Developer', '2025-10-29 11:06:58'),
('FILEP00077', 'FLRPR00029', 'Rencana Kerja SKPD (DAMKAR) TA 2025 (KUA 2025).pptx', 'https://drive.google.com/file/d/1JVmJEUy9slZsYYAp63p_ISchD3ne2NL7/view', 'Developer', '2025-10-29 11:07:06'),
('FILEP00078', 'FLRPR00029', 'RENJA Perubahan 2025_paparan dewan 21 Mei.pdf', 'https://drive.google.com/file/d/1bdoNgy6_8ivyG93Rawal1q-YmyfihQgQ/view', 'Developer', '2025-10-29 11:07:10'),
('FILEP00079', 'FLRPR00029', 'Rev2_KADIS DAMKAR_PAPARAN PERUBAHAN APBD TA.2025.pptx', 'https://drive.google.com/file/d/1BWsM9LgkSfcscRNquksHkDkewLbHas42/view', 'Developer', '2025-10-29 11:07:14'),
('FILEP00080', 'FLRPR00029', 'Rev2_PAPARAN PERUBAHAN APBD TA.2025.pptx', 'https://drive.google.com/file/d/1VfuzwIehk6o4jwWPqs_yACgXx7V22oN8/view', 'Developer', '2025-10-29 11:07:22'),
('FILEP00081', 'FLRPR00029', 'Rev2_PAPARAN PERUBAHAN APBD TA.2025_BKD.pptx', 'https://drive.google.com/file/d/1eFFnpisZAY_IV93xJqpf66CW0Arl7PBk/view', 'Developer', '2025-10-29 11:07:28'),
('FILEP00082', 'FLRPR00030', 'DPA 2024 DAMKAR PDF.pdf', 'https://drive.google.com/file/d/1wQJEb9nm8U8Q7S8MIgSteLTjJCApo9bT/view', 'Developer', '2025-10-29 11:09:23'),
('FILEP00083', 'FLRPR00030', 'DPA PERUBAHAN 2024.pdf', 'https://drive.google.com/file/d/1w3DOa_pX72s8d_j4c40YZ-uj6wOJoTGm/view', 'Developer', '2025-10-29 11:09:50'),
('FILEP00084', 'FLRPR00031', 'DPA Pergeseran 2025.pdf', 'https://drive.google.com/file/d/1n8lO0BIzQD4UrgQYzTuR6xm12_STokqT/view', 'Developer', '2025-10-29 11:12:11'),
('FILEP00085', 'FLRPR00031', 'DPA DAMKAR 2025.pdf', 'https://drive.google.com/file/d/1qo5PXlL10vEWjpvIdT3t4IGnQ_0F6np_/view', 'Developer', '2025-10-29 11:12:52'),
('FILEP00086', 'FLRPR00032', 'RANCANGAN PERUBAHAN RENSTRA 2021-2026 F.. .pdf', 'https://drive.google.com/file/d/1PuJVOXJE1m_zPwJBLPNejggwDC0IM_lD/view', 'Developer', '2025-10-29 11:13:42'),
('FILEP00087', 'FLRPR00033', 'RENSTRA MURNI 2021-2026.pdf', 'https://drive.google.com/file/d/17q_rVZO_DA-pSyKqJAXHtIUXzGU8Uw6m/view', 'Developer', '2025-10-29 11:14:28'),
('FILEP00088', 'FLRPR00034', 'Rencana Aksi Disdamkar Tahun 2024.pdf', 'https://drive.google.com/file/d/1QS4hgDnICk0_6i_DXokuHh7fRKBwpwKr/view', 'Developer', '2025-10-29 11:15:07'),
('FILEP00095', 'FLRPR00043', 'SK IKU 2025-2029.pdf', 'https://drive.google.com/file/d/1QGHQNthyOIJgRhUuktiAwjE4ognTvuoc/view', 'Developer', '2025-10-29 14:27:03'),
('FILEP00098', '', 'Data Damkar Gdrive', 'https://bit.ly/DokDamkar2025', 'Developer', '2025-10-29 14:45:47'),
('FILEP00099', 'FLRPR00044', 'LAPORAN PEMANTAUAN RTP TW I_damkar2024 (1).docx', 'https://drive.google.com/file/d/1q_Xd9y_PZO8AmVTQTN0jOmYV5unB9gSS/view', 'Dila', '2025-10-31 09:31:14'),
('FILEP00100', 'FLRPR00043', 'SK IKU 2021-2026.pdf', 'https://drive.google.com/file/d/1t04dCz49wuba0wUP6Xrb1rhPAj2vU2fw/view', 'Developer', '2025-10-31 14:03:42'),
('FILEP00101', 'FLRPR00042', '1.SK PPK 2025 (2 Januari).pdf', 'https://drive.google.com/file/d/1HVS6W-4HDJrb-j2cK-apUn3yLqgqUMGG/view', 'Developer', '2025-10-31 14:10:53'),
('FILEP00102', 'FLRPR00042', '2.SK KPA 2025 (2 Januari).pdf', 'https://drive.google.com/file/d/1sHPm_2C3wlUhkVOWFI07GJTdoTGfOLso/view', 'Developer', '2025-10-31 14:11:00'),
('FILEP00103', 'FLRPR00042', '3.SK PPTK 2025 (2 Januari).pdf', 'https://drive.google.com/file/d/1HAPhkLLzoMkz2wlR18_z_tOYWIB9Y541/view', 'Developer', '2025-10-31 14:11:07'),
('FILEP00104', 'FLRPR00042', '4.SK PPK Perubahan 2025 (10 April).pdf', 'https://drive.google.com/file/d/1EbanWCGBDQEIt7Aw-uHAI6sc_OiB2iuB/view', 'Developer', '2025-10-31 14:11:14'),
('FILEP00105', 'FLRPR00042', '5.SK PPTK Perubahan 2025 (Audi 22 mei).pdf', 'https://drive.google.com/file/d/1qOl1K02gB5HnDUClyUGGlLy8P7XW1UGc/view', 'Developer', '2025-10-31 14:11:21'),
('FILEP00106', 'FLRPR00042', '6.SK KPA Perubahan 2025 (2 Juni).pdf', 'https://drive.google.com/file/d/1SfoXKRZbW2hbvgVZI9IUrM1q85EB6Jm5/view', 'Developer', '2025-10-31 14:11:28'),
('FILEP00107', 'FLRPR00042', '7.SK PPTK Perubahan 2025 ( 2 Juni).pdf', 'https://drive.google.com/file/d/15xL2eP8WEmJBeLXq6GWL4bdlc0l7UtdR/view', 'Developer', '2025-10-31 14:11:34'),
('FILEP00108', 'FLRPR00042', '8..SK PPTK Perubahan (Cinere 7 Juli).pdf', 'https://drive.google.com/file/d/1ZKpc5s5KwtA9FJHotzUtAnsNVPRBdm8k/view', 'Developer', '2025-10-31 14:11:41'),
('FILEP00109', 'FLRPR00042', '9.SK KPA Perubahan (16 Sept).pdf', 'https://drive.google.com/file/d/1mkveK8G4qA8bWWdDpUcfBbd2Dw7hpdKv/view', 'Developer', '2025-10-31 14:11:50'),
('FILEP00110', 'FLRPR00042', '10.SK PPK Perubahan (16 Sept).pdf', 'https://drive.google.com/file/d/1iVZvJnSNvQRaF5fKT-So3rwX9VawP6-b/view', 'Developer', '2025-10-31 14:12:14'),
('FILEP00111', 'FLRPR00042', '11.SK PPTK Perubahan (16 Sept).pdf', 'https://drive.google.com/file/d/1nTioiCAdvIM39hVVIxOfpsiKpYrsj5JM/view', 'Developer', '2025-10-31 14:12:31'),
('FILEP00112', 'FLRPR00042', 'SK Pejabat Penatausahaan Keuangan 2025 (2 Januari).pdf', 'https://drive.google.com/file/d/1vQbMcKFW_ckli8WN3ryTicpufFZM3G2p/view', 'Developer', '2025-10-31 14:12:35'),
('FILEP00113', 'FLRPR00042', 'SK Standar Operasional Prosedur  Tahun 2025.pdf', 'https://drive.google.com/file/d/1PuQ8zasHycxIBLqQrn3GRu-LbJ7Oejtt/view', 'Developer', '2025-10-31 14:12:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_admin`
--

CREATE TABLE `t_admin` (
  `id_admin` varchar(6) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username_admin` varchar(20) NOT NULL,
  `password_admin` varchar(255) NOT NULL,
  `is_delete_admin` enum('0','1') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `t_admin`
--

INSERT INTO `t_admin` (`id_admin`, `nama_admin`, `username_admin`, `password_admin`, `is_delete_admin`, `created_at`, `update_at`) VALUES
('ADM000', 'Developer', 'developer', '$2y$10$BtHHWFXmLuhnP79ievN58O8EivCDmojcmNDivaVhmIlBQNSiqr9Ku', '0', '2024-05-30 21:57:33', '2024-05-30 21:57:33'),
('ADM001', 'Bio Abizar', 'bio', '$2y$10$yyoQyrGsDIBu8HWHMYkaw.wM11FEvK3KeJaBjJOfyDfQM0f5THhvq', '0', '2025-10-05 10:57:12', '2025-10-05 10:57:12'),
('ADM002', 'Luqman', 'Luqman123', '$2y$10$B9RIYraFk5xRzJLKIEp0ae/jSWHdHfwYv/YGNVy.cfUDGc7SWdlDu', '0', '2025-10-08 04:04:03', '2025-10-08 04:04:03'),
('ADM003', 'Bioqq', 'Bioqq', '$2y$10$AhIH0XNQW/3pchbe50enYuPgWlKp9MsaPxJ205S0l3T.zv9J5HLki', '0', '2025-10-08 04:07:00', '2025-10-08 04:07:00'),
('ADM004', 'LxsserVro', 'Qwerty98765', '$2y$10$LHxGgWklf9OdBWxo6aRRZ.QMZjkdd7pAttEWC4Y4bBVZk5ZBC7QJu', '0', '2025-10-08 04:07:33', '2025-10-08 04:07:33'),
('ADM005', 'bio321', 'bio321', '$2y$10$C7WnwAPKkaIPuhsjZZDA3uyYv6Y599DU889Lpi.hklTeR9pYncoka', '0', '2025-10-14 02:58:49', '2025-10-14 02:58:49'),
('ADM006', 'Luqman Abdulmajid', 'Luqman', '$2y$10$28dLdL8TxVcXFcAh7ep24O6EREvJ8KZuHB1BffvwAFD4BPgWFinOS', '0', '2025-10-15 06:59:15', '2025-10-15 06:59:15'),
('ADM007', 'test', 'kiana', '$2y$10$upVbxFPa2ecCQhWEugk9Su4anqq2hA1Vqp0/.GwizqBxFPVHOp.7W', '0', '2025-10-15 21:46:39', '2025-10-15 21:46:39'),
('ADM008', 'Yunie', 'Yunie', '$2y$10$VWh/qr7vS9hOLKYqT7n6D.YS/h1wsfgjB/2DtOWkAKTiCKAUHnW3i', '0', '2025-10-23 08:31:04', '2025-10-23 08:31:04'),
('ADM009', 'Dila', 'Dila', '$2y$10$ifnR6Uc6wXgcdZG7eJp4/etikCtjSg4msbakBJyP7y6B7ty6xp4Sy', '0', '2025-10-31 09:28:23', '2025-10-31 09:28:23'),
('ADM010', 'sumarjo', 'marjo', '$2y$10$fvMiibkJ4jYlVCji/GvurOJ1X3rE2xRQ8vuPs0bMGFSChKVF2fZzW', '0', '2025-10-31 10:40:24', '2025-10-31 10:40:24'),
('ADM011', 'Alfito', 'alfito', '$2y$10$KxpFX0Fh/.nXPWXZK4CAD.jjvrVzaYAMo3WnA0MiQ/7aHWMAyRO8q', '0', '2025-12-10 15:15:52', '2025-12-10 15:15:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `folder_mekanisme`
--
ALTER TABLE `folder_mekanisme`
  ADD PRIMARY KEY (`id_folder_mek`);

--
-- Indeks untuk tabel `folder_monitoring`
--
ALTER TABLE `folder_monitoring`
  ADD PRIMARY KEY (`id_folder_mon`);

--
-- Indeks untuk tabel `folder_perencanaan`
--
ALTER TABLE `folder_perencanaan`
  ADD PRIMARY KEY (`id_folder_per`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `tbl_dasar_hukum`
--
ALTER TABLE `tbl_dasar_hukum`
  ADD PRIMARY KEY (`id_hukum`);

--
-- Indeks untuk tabel `tbl_dokumentasi`
--
ALTER TABLE `tbl_dokumentasi`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `tbl_dokumentasi_file`
--
ALTER TABLE `tbl_dokumentasi_file`
  ADD PRIMARY KEY (`id_file`),
  ADD KEY `id_kegiatan` (`id_kegiatan`);

--
-- Indeks untuk tabel `tbl_mekanisme`
--
ALTER TABLE `tbl_mekanisme`
  ADD PRIMARY KEY (`id_mekanisme`),
  ADD KEY `id_folder_mek` (`id_folder_mek`);

--
-- Indeks untuk tabel `tbl_monitoring_pelaporan`
--
ALTER TABLE `tbl_monitoring_pelaporan`
  ADD PRIMARY KEY (`id_monitoring`),
  ADD KEY `id_folder` (`id_folder_mon`),
  ADD KEY `id_folder_mon` (`id_folder_mon`);

--
-- Indeks untuk tabel `tbl_perencanaan`
--
ALTER TABLE `tbl_perencanaan`
  ADD PRIMARY KEY (`id_perencanaan`),
  ADD KEY `id_folder_per` (`id_folder_per`);

--
-- Indeks untuk tabel `t_admin`
--
ALTER TABLE `t_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
