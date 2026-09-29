<?php require 'auth.php'; izin('administrator'); $msg='';
if($_SERVER['REQUEST_METHOD']=='POST'){try{
 if(isset($_POST['hapus']))q("DELETE FROM fakultas WHERE kode_fakultas=?",'s',$_POST['hapus']);
 elseif($_POST['lama']!=='')q("UPDATE fakultas SET kode_fakultas=?,nama_fakultas=? WHERE kode_fakultas=?",'sss',$_POST['kode'],$_POST['nama'],$_POST['lama']);
 else q("INSERT INTO fakultas VALUES(?,?)",'ss',$_POST['kode'],$_POST['nama']);
 header('Location: fakultas.php');exit;}catch(mysqli_sql_exception $x){$msg='Gagal: kode duplikat atau fakultas masih dipakai program studi.';}}
$ed=isset($_GET['edit'])?(rows(q("SELECT * FROM fakultas WHERE kode_fakultas=?",'s',$_GET['edit']))[0]??null):null;
atas('Master Fakultas'); if($msg)echo '<p class="err">'.$msg.'</p>';?>
<form method="post" class="f"><input type="hidden" name="lama" value="<?=e($ed['kode_fakultas']??'')?>">
<input name="kode" placeholder="Kode" maxlength="10" required value="<?=e($ed['kode_fakultas']??'')?>">
<input name="nama" placeholder="Nama Fakultas" required value="<?=e($ed['nama_fakultas']??'')?>"><button><?=$ed?'Update':'Tambah'?></button></form>
<table><tr><th>Kode</th><th>Nama</th><th>Aksi</th></tr>
<?php foreach(rows(q("SELECT * FROM fakultas ORDER BY kode_fakultas")) as $r){?>
<tr><td><?=e($r['kode_fakultas'])?></td><td><?=e($r['nama_fakultas'])?></td><td><a href="?edit=<?=urlencode($r['kode_fakultas'])?>">Edit</a>
<form method="post" style="display:inline" onsubmit="return confirm('Hapus?')"><button name="hapus" value="<?=e($r['kode_fakultas'])?>" class="d">Hapus</button></form></td></tr><?php }?></table>
<?php bawah();
