<?php
session_start();
require __DIR__.'/koneksi.php';
mysqli_report(MYSQLI_REPORT_ERROR|MYSQLI_REPORT_STRICT);
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8');}
function q($sql,$t='',...$p){global $koneksi;$s=$koneksi->prepare($sql);if($t)$s->bind_param($t,...$p);$s->execute();return $s;}
function rows($s){return $s->get_result()->fetch_all(MYSQLI_ASSOC);}
function role(){return $_SESSION['u']['role']??'';}
function izin(...$r){if(empty($_SESSION['u'])){header('Location: login.php');exit;}
 if(!in_array(role(),$r)){http_response_code(403);exit('Akses ditolak. <a href="dashboard.php">Kembali</a>');}}
function atas($judul){
 $m=basename($_SERVER['PHP_SELF']);$a=fn($f)=>$m==$f?' class="on"':'';
 echo '<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($judul).'</title><link rel="stylesheet" href="style.css"></head><body>
 <aside><h2>UM Bengkulu</h2><small>'.e($_SESSION['u']['nama']).' ('.e(role()).')</small>
 <a href="dashboard.php"'.$a('dashboard.php').'>Home</a>';
 if(role()=='administrator'||role()=='prodi'){
  echo '<details'.(in_array($m,['fakultas.php','prodi.php'])?' open':'').'><summary>Master</summary>';
  if(role()=='administrator')echo '<a class="sub" href="fakultas.php"'.$a('fakultas.php').'>Fakultas</a>';
  echo '<a class="sub" href="prodi.php"'.$a('prodi.php').'>Program Studi</a></details>';}
 echo '<a href="mahasiswa.php"'.$a('mahasiswa.php').'>Mahasiswa</a><a href="logout.php">Logout</a></aside><main><h1>'.e($judul).'</h1>';
}
function bawah(){echo '</main></body></html>';}
