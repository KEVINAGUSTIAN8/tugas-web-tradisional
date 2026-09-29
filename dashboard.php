<?php require 'auth.php'; izin('administrator','prodi','mahasiswa'); atas('Dashboard');
$kp=$_SESSION['u']['kode_prodi'];
if(role()=='administrator'){$s=[['Fakultas','fakultas'],['Program Studi','program_studi'],['Mahasiswa','mahasiswa'],['Pengguna','pengguna']];
 echo '<div class="g">';foreach($s as $x)echo '<div class="k"><b>'.rows(q("SELECT COUNT(*) n FROM $x[1]"))[0]['n'].'</b>'.$x[0].'</div>';echo '</div>';}
elseif(role()=='prodi'){$p=rows(q("SELECT nama_program_studi FROM program_studi WHERE kode_prodi=?",'s',$kp))[0]['nama_program_studi']??'-';
 echo '<div class="g"><div class="k"><b>'.e($p).'</b>Program Studi</div><div class="k"><b>'.rows(q("SELECT COUNT(*) n FROM mahasiswa WHERE kode_prodi=?",'s',$kp))[0]['n'].'</b>Mahasiswa</div></div>';}
else{echo '<p>Selamat datang, '.e($_SESSION['u']['nama']).'. Buka menu <a href="mahasiswa.php">Mahasiswa</a> untuk melihat dan mengubah data Anda.</p>';}
bawah();
