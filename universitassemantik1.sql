-- Dump SQL: universitassemantik (SERVER LOKAL / phpMyAdmin)
CREATE DATABASE IF NOT EXISTS `universitassemantik` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `universitassemantik`;

DROP TABLE IF EXISTS `pengguna`;
DROP TABLE IF EXISTS `mahasiswa`;
DROP TABLE IF EXISTS `program_studi`;
DROP TABLE IF EXISTS `fakultas`;

-- ------------------------------------------------------------
-- Tabel fakultas
-- >>> DIGANTI: id_fakultas (INT) -> kode_fakultas (VARCHAR), agar cocok dengan index.php
-- ------------------------------------------------------------
CREATE TABLE `fakultas` (
  `kode_fakultas` VARCHAR(10)  NOT NULL,
  `nama_fakultas` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`kode_fakultas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabel program_studi
-- >>> DIGANTI: id_prodi -> kode_prodi
-- >>> DIGANTI: nama_prodi -> nama_program_studi
-- >>> DIGANTI: id_fakultas -> kode_fakultas
-- ------------------------------------------------------------
CREATE TABLE `program_studi` (
  `kode_prodi`         VARCHAR(10)  NOT NULL,
  `nama_program_studi` VARCHAR(100) NOT NULL,
  `kode_fakultas`      VARCHAR(10)  NOT NULL,
  PRIMARY KEY (`kode_prodi`),
  KEY `fk_prodi_fakultas` (`kode_fakultas`),
  CONSTRAINT `fk_prodi_fakultas` FOREIGN KEY (`kode_fakultas`)
    REFERENCES `fakultas` (`kode_fakultas`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Tabel mahasiswa
-- >>> DIGANTI: id_prodi -> kode_prodi (FK ke program_studi.kode_prodi)
-- ------------------------------------------------------------
CREATE TABLE `mahasiswa` (
  `npm`             VARCHAR(15)  NOT NULL,
  `nama_mahasiswa`  VARCHAR(100) NOT NULL,
  `jenis_kelamin`   ENUM('L','P') NOT NULL,
  `tempat_lahir`    VARCHAR(50)  NOT NULL,
  `tanggal_lahir`   DATE         NOT NULL,
  `tanggal_masuk`   DATE         NOT NULL,
  `alamat`          TEXT         NOT NULL,
  `password`        VARCHAR(255) NOT NULL,
  `kode_prodi`      VARCHAR(10)  NOT NULL,
  PRIMARY KEY (`npm`),
  KEY `fk_mhs_prodi` (`kode_prodi`),
  CONSTRAINT `fk_mhs_prodi` FOREIGN KEY (`kode_prodi`)
    REFERENCES `program_studi` (`kode_prodi`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- >>> BARU: Tabel pengguna (user backend: administrator & prodi)
-- role 'administrator' -> hak tertinggi, kode_prodi dikosongkan (NULL)
-- role 'prodi'         -> wajib diisi kode_prodi (hanya kelola prodinya sendiri)
-- ------------------------------------------------------------
CREATE TABLE `pengguna` (
  `id_pengguna`  INT(11)      NOT NULL AUTO_INCREMENT,
  `username`     VARCHAR(50)  NOT NULL,
  `password`     VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `role`         ENUM('administrator','prodi') NOT NULL,
  `kode_prodi`   VARCHAR(10)  DEFAULT NULL,
  `dibuat_pada`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `uq_username` (`username`),
  KEY `fk_pengguna_prodi` (`kode_prodi`),
  CONSTRAINT `fk_pengguna_prodi` FOREIGN KEY (`kode_prodi`)
    REFERENCES `program_studi` (`kode_prodi`) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Data contoh
-- ------------------------------------------------------------
INSERT INTO `fakultas` (`kode_fakultas`, `nama_fakultas`) VALUES
('FT', 'Teknik');

INSERT INTO `program_studi` (`kode_prodi`, `nama_program_studi`, `kode_fakultas`) VALUES
('TI', 'Teknik Informatika', 'FT');

INSERT INTO `mahasiswa`
(`npm`, `nama_mahasiswa`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `tanggal_masuk`, `alamat`, `password`, `kode_prodi`) VALUES
('2026001', 'Contoh Mahasiswa Satu', 'L', 'Bengkulu', '2005-03-14', '2024-09-01', 'Jl. Contoh No. 1, Bengkulu', MD5('mhs001'), 'TI'),
('2026002', 'Contoh Mahasiswa Dua',  'P', 'Curup',    '2005-07-21', '2024-09-01', 'Jl. Contoh No. 2, Bengkulu', MD5('mhs002'), 'TI');

-- >>> BARU: akun contoh (GANTI password setelah login pertama)
INSERT INTO `pengguna` (`username`, `password`, `nama_lengkap`, `role`, `kode_prodi`) VALUES
('admin',   MD5('admin123'),  'Administrator',        'administrator', NULL),
('prodi_ti', MD5('prodi123'), 'Admin Prodi Informatika', 'prodi',     'TI');
