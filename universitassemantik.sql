-- Server LOKAL (phpMyAdmin XAMPP). Tanda: >>> BARU / >>> DIGANTI
CREATE DATABASE IF NOT EXISTS universitassemantik CHARACTER SET utf8mb4;
USE universitassemantik;
DROP TABLE IF EXISTS pengguna;
DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS program_studi;
DROP TABLE IF EXISTS fakultas;
CREATE TABLE fakultas(
 kode_fakultas VARCHAR(10) PRIMARY KEY,
 nama_fakultas VARCHAR(100) NOT NULL) ENGINE=InnoDB;
CREATE TABLE program_studi(
 kode_prodi VARCHAR(10) PRIMARY KEY,
 nama_program_studi VARCHAR(100) NOT NULL,
 kode_fakultas VARCHAR(10) NOT NULL,
 FOREIGN KEY(kode_fakultas) REFERENCES fakultas(kode_fakultas) ON UPDATE CASCADE) ENGINE=InnoDB; -- >>> DIGANTI: ON UPDATE CASCADE
CREATE TABLE mahasiswa(
 npm VARCHAR(15) PRIMARY KEY,
 nama_mahasiswa VARCHAR(100) NOT NULL,
 jenis_kelamin ENUM('L','P') NOT NULL,
 tempat_lahir VARCHAR(50), tanggal_lahir DATE, tanggal_masuk DATE, alamat TEXT,
 password VARCHAR(255) NOT NULL,  -- >>> DIGANTI: 255 (untuk password_hash)
 kode_prodi VARCHAR(10) NOT NULL,
 FOREIGN KEY(kode_prodi) REFERENCES program_studi(kode_prodi) ON UPDATE CASCADE) ENGINE=InnoDB; -- >>> DIGANTI: ON UPDATE CASCADE
CREATE TABLE pengguna(
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) UNIQUE NOT NULL,
 email VARCHAR(100) NOT NULL DEFAULT '',                          -- >>> BARU
 password VARCHAR(255) NOT NULL,
 nama_lengkap VARCHAR(100) NOT NULL,
 role ENUM('administrator','prodi','mahasiswa') NOT NULL,          -- >>> DIGANTI: tambah 'mahasiswa'
 kode_prodi VARCHAR(10) NULL,
 npm VARCHAR(15) NULL UNIQUE,                                      -- >>> BARU: penghubung akun mahasiswa
 FOREIGN KEY(kode_prodi) REFERENCES program_studi(kode_prodi) ON UPDATE CASCADE,
 FOREIGN KEY(npm) REFERENCES mahasiswa(npm) ON UPDATE CASCADE ON DELETE CASCADE) ENGINE=InnoDB;
INSERT INTO fakultas VALUES('FT','Teknik');
INSERT INTO program_studi VALUES('TI','Teknik Informatika','FT');
INSERT INTO mahasiswa VALUES
('2355201169','Kevin Agustian','L','Bengkulu','2004-01-01','2023-09-01','Bengkulu',MD5('mhs123'),'TI'),
('2355201170','Contoh Mahasiswa','P','Palembang','2004-05-05','2023-09-01','Palembang',MD5('mhs123'),'TI');
INSERT INTO pengguna(username,email,password,nama_lengkap,role,kode_prodi,npm) VALUES
('admin','admin@contoh.com',MD5('admin123'),'Administrator','administrator',NULL,NULL),
('prodi_ti','prodi@contoh.com',MD5('prodi123'),'Admin Prodi TI','prodi','TI',NULL),
('mhs1','mhs1@contoh.com',MD5('mhs123'),'Kevin Agustian','mahasiswa','TI','2355201169'); -- >>> BARU: akun mahasiswa
