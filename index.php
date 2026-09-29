<?php require 'auth.php';
$n=fn($t)=>rows(q("SELECT COUNT(*) n FROM $t"))[0]['n'];
$pr=rows(q("SELECT p.kode_prodi,p.nama_program_studi nama,COUNT(m.npm) n FROM program_studi p LEFT JOIN mahasiswa m USING(kode_prodi) GROUP BY p.kode_prodi,p.nama_program_studi ORDER BY p.nama_program_studi LIMIT 8"));
$in=!empty($_SESSION['u']);?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Universitas Muhammadiyah Bengkulu</title><link rel="stylesheet" href="style.css"></head>
<body class="lp">
<header class="top"><div class="w"><a class="brand" href="index.php"><i>UMB</i><span><b>Universitas Muhammadiyah Bengkulu</b><small>Unggul, Islami, Berkemajuan</small></span></a>
<nav><a class="on" href="index.php">Beranda</a><a href="mahasiswa.php">Data Mahasiswa</a><a href="prodi.php">Program Studi</a><a href="#tentang">Tentang</a><a href="#kontak">Kontak</a></nav>
<a class="btn" href="<?=$in?'dashboard.php':'login.php'?>"><?=$in?'Dashboard':'Login'?></a></div></header>
<section class="hero"><div class="w"><div>
<h1>Data Mahasiswa <span>Per Program Studi</span></h1>
<p>Lihat, cari, dan kelola data mahasiswa Universitas Muhammadiyah Bengkulu secara rapi dan terstruktur, per program studi dan fakultas.</p>
<div class="cta"><a class="btn" href="mahasiswa.php">Lihat Data Mahasiswa</a><a class="btn o" href="#tentang">Tentang Kampus</a></div>
<q>Data yang tertata, layanan yang lebih cepat</q></div>
<div class="dia"><svg viewBox="0 0 400 260" role="img" aria-label="Diagram relasi tabel: Mahasiswa, Program Studi, Fakultas, Pengguna"><g stroke="#146c43" stroke-width="2" fill="none"><path d="M100 70L200 130M300 70L200 130M100 200L200 130M300 200L200 130"/></g>
<circle cx="200" cy="130" r="34" fill="#0b3a29"/><text x="200" y="135" fill="#fff" font-size="15" font-weight="700" text-anchor="middle">RDF</text>
<g font-size="13" font-weight="600" text-anchor="middle" fill="#1c2b23"><circle cx="100" cy="70" r="26" fill="#146c43"/><text x="100" y="118">Mahasiswa</text>
<circle cx="300" cy="70" r="26" fill="#d9a521"/><text x="300" y="118">Program Studi</text>
<circle cx="100" cy="200" r="26" fill="#2f7d6b"/><text x="100" y="248">Fakultas</text>
<circle cx="300" cy="200" r="26" fill="#7a5c14"/><text x="300" y="248">Pengguna</text></g></svg></div></div></section>
<section class="feat w"><div><i>🗄️</i><b>Data Terintegrasi</b><p>Data mahasiswa tersimpan dalam satu basis data bersama program studi dan fakultas.</p></div>
<div><i>🔗</i><b>Basis Data Relasional</b><p>Tiga tabel utama yang saling berelasi dan sudah dinormalisasi sampai 3NF.</p></div>
<div><i>📊</i><b>Mudah Diakses</b><p>Pencarian data mahasiswa berdasarkan NPM dan program studi.</p></div>
<div><i>🛡️</i><b>Hak Akses per Peran</b><p>Administrator, prodi, dan mahasiswa punya batas akses masing-masing.</p></div></section>
<section class="sec"><div class="w"><h2>Daftar Program Studi</h2><p>Pilih program studi untuk melihat data mahasiswa secara detail.</p>
<div class="pg"><?php foreach($pr as $r)echo '<a class="pc" href="mahasiswa.php?prodi='.urlencode($r['kode_prodi']).'"><i>'.e(mb_substr($r['nama'],0,1)).'</i><span><b>'.e($r['nama']).'</b><small>'.$r['n'].' Mahasiswa</small></span></a>';
if(!$pr)echo '<p>Belum ada program studi.</p>';?></div></div></section>
<section class="st"><div class="w"><div><b><?=$n('mahasiswa')?></b>Total Mahasiswa</div><div><b><?=$n('program_studi')?></b>Program Studi</div><div><b><?=$n('fakultas')?></b>Fakultas</div><div><b>3NF</b>Basis data ternormalisasi</div></div></section>
<section class="sec ab" id="tentang"><div class="w"><div><h2>Sistem Informasi Data Mahasiswa</h2><p>Aplikasi web tradisional berbasis PHP dan MySQL untuk mengelola data mahasiswa, program studi, dan fakultas, lengkap dengan login dan pembagian peran pengguna.</p><a class="btn" href="login.php">Masuk ke Sistem</a></div>
<blockquote>Unggul, Islami, Berkemajuan.</blockquote></div></section>
<footer class="ft" id="kontak"><div class="w"><div><b>Universitas Muhammadiyah Bengkulu</b><p>Unggul, Islami, Berkemajuan</p></div>
<div><b>Tautan Cepat</b><a href="index.php">Beranda</a><a href="mahasiswa.php">Data Mahasiswa</a><a href="prodi.php">Program Studi</a></div>
<div><b>Teknologi</b><a>HTML dan CSS</a><a>PHP</a><a>MySQL</a></div>
<div><b>Kontak</b><p>Jl. Pendidikan No. 1, Kota Bengkulu</p><p>info@umb.ac.id</p><p>&copy; 2026 Universitas Muhammadiyah Bengkulu</p></div></div></footer>
</body></html>
