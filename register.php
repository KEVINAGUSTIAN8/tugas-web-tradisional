<?php require 'auth.php'; $err='';$ok=false;
if($_SERVER['REQUEST_METHOD']=='POST'){
 $npm=trim($_POST['npm']);$em=trim($_POST['email']);$us=trim($_POST['username']);$pw=$_POST['password'];
 $m=rows(q("SELECT * FROM mahasiswa WHERE npm=?",'s',$npm))[0]??null;
 if(!$m)$err='NPM tidak terdaftar di data mahasiswa.';
 elseif(rows(q("SELECT id FROM pengguna WHERE npm=? OR username=?",'ss',$npm,$us)))$err='NPM atau username sudah dipakai.';
 elseif(strlen($pw)<6||!filter_var($em,FILTER_VALIDATE_EMAIL))$err='Email tidak valid atau password kurang dari 6 karakter.';
 else{q("INSERT INTO pengguna(username,email,password,nama_lengkap,role,kode_prodi,npm) VALUES(?,?,?,?,'mahasiswa',?,?)",'ssssss',$us,$em,password_hash($pw,PASSWORD_DEFAULT),$m['nama_mahasiswa'],$m['kode_prodi'],$npm);$ok=true;}}
?><!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="style.css"></head><body class="c">
<form method="post" class="box"><h2>Register Mahasiswa</h2>
<?php if($ok)echo '<p class="ok">Berhasil. <a href="login.php">Login sekarang</a></p>'; if($err)echo '<p class="err">'.e($err).'</p>';?>
<label>NPM<input name="npm" required></label><label>Email<input type="email" name="email" required></label>
<label>Username<input name="username" required></label><label>Password<input type="password" name="password" required></label>
<button>Daftar</button><p><a href="login.php">Kembali ke login</a></p></form></body></html>
