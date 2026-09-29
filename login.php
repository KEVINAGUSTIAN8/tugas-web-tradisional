<?php require 'auth.php'; $err='';
if($_SERVER['REQUEST_METHOD']=='POST'){
 $r=rows(q("SELECT * FROM pengguna WHERE username=?",'s',trim($_POST['username'])));$u=$r[0]??null;$pw=$_POST['password'];
 if($u&&(password_verify($pw,$u['password'])||md5($pw)===$u['password'])){
  if(strlen($u['password'])==32)q("UPDATE pengguna SET password=? WHERE id=?",'si',password_hash($pw,PASSWORD_DEFAULT),$u['id']);
  session_regenerate_id(true);
  $_SESSION['u']=['id'=>$u['id'],'username'=>$u['username'],'nama'=>$u['nama_lengkap'],'role'=>$u['role'],'kode_prodi'=>$u['kode_prodi'],'npm'=>$u['npm']];
  header('Location: dashboard.php');exit;}
 $err='Username atau password salah.';}
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="style.css"></head><body class="c">
<form method="post" class="box"><h2>Login</h2><?php if($err)echo '<p class="err">'.e($err).'</p>';?>
<label>Username<input name="username" required></label><label>Password<input type="password" name="password" required></label>
<button>Masuk</button><p><a href="register.php">Daftar akun mahasiswa</a> · <a href="index.php">Beranda</a></p></form></body></html>
