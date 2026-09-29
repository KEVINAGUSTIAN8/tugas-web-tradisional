<?php require 'auth.php'; izin('administrator','prodi'); $adm=role()=='administrator'; $msg='';
if($adm&&$_SERVER['REQUEST_METHOD']=='POST'){try{
 if(isset($_POST['hapus']))q("DELETE FROM program_studi WHERE kode_prodi=?",'s',$_POST['hapus']);
 elseif($_POST['lama']!=='')q("UPDATE program_studi SET kode_prodi=?,nama_program_studi=?,kode_fakultas=? WHERE kode_prodi=?",'ssss',$_POST['kode'],$_POST['nama'],$_POST['fak'],$_POST['lama']);
 else q("INSERT INTO program_studi VALUES(?,?,?)",'sss',$_POST['kode'],$_POST['nama'],$_POST['fak']);
 header('Location: prodi.php');exit;}catch(mysqli_sql_exception $x){$msg='Gagal: kode duplikat atau prodi masih dipakai mahasiswa/pengguna.';}}
if(role()=='prodi'&&$_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['nama_prodi'])){ // prodi: hanya ubah NAMA prodinya sendiri
 q("UPDATE program_studi SET nama_program_studi=? WHERE kode_prodi=?",'ss',trim($_POST['nama_prodi']),$_SESSION['u']['kode_prodi']);header('Location: prodi.php');exit;}
$ed=($adm&&isset($_GET['edit']))?(rows(q("SELECT * FROM program_studi WHERE kode_prodi=?",'s',$_GET['edit']))[0]??null):null;
atas('Master Program Studi'); if($msg)echo '<p class="err">'.$msg.'</p>';
if($adm){?>
<form method="post" class="f"><input type="hidden" name="lama" value="<?=e($ed['kode_prodi']??'')?>">
<input name="kode" placeholder="Kode" maxlength="10" required value="<?=e($ed['kode_prodi']??'')?>">
<input name="nama" placeholder="Nama Program Studi" required value="<?=e($ed['nama_program_studi']??'')?>">
<select name="fak"><?php foreach(rows(q("SELECT * FROM fakultas")) as $f)echo '<option value="'.e($f['kode_fakultas']).'"'.(($ed['kode_fakultas']??'')==$f['kode_fakultas']?' selected':'').'>'.e($f['nama_fakultas']).'</option>';?></select>
<button><?=$ed?'Update':'Tambah'?></button></form><?php }
$w=$adm?'':' WHERE p.kode_prodi=?'; $s=$adm?q("SELECT p.*,f.nama_fakultas FROM program_studi p JOIN fakultas f USING(kode_fakultas)"):q("SELECT p.*,f.nama_fakultas FROM program_studi p JOIN fakultas f USING(kode_fakultas)$w",'s',$_SESSION['u']['kode_prodi']);?>
<table><tr><th>Kode</th><th>Program Studi</th><th>Fakultas</th><?=$adm?'<th>Aksi</th>':''?></tr>
<?php foreach(rows($s) as $r){?><tr><td><?=e($r['kode_prodi'])?></td><td><?php if($adm){echo e($r['nama_program_studi']);}else{?><form method="post" class="f" style="margin:0"><input name="nama_prodi" required value="<?=e($r['nama_program_studi'])?>"><button>Simpan</button></form><?php }?></td><td><?=e($r['nama_fakultas'])?></td>
<?php if($adm){?><td><a href="?edit=<?=urlencode($r['kode_prodi'])?>">Edit</a>
<form method="post" style="display:inline" onsubmit="return confirm('Hapus?')"><button name="hapus" value="<?=e($r['kode_prodi'])?>" class="d">Hapus</button></form></td><?php }?></tr><?php }?></table>
<?php bawah();
