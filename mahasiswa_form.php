<?php require 'auth.php'; izin('administrator','mahasiswa'); $adm=role()=='administrator'; $msg='';
$npm=$adm?($_GET['npm']??''):$_SESSION['u']['npm']; $baru=($npm==='');
$r=$baru?[]:(rows(q("SELECT m.*,ps.nama_program_studi,f.nama_fakultas,(SELECT email FROM pengguna WHERE npm=m.npm) email FROM mahasiswa m JOIN program_studi ps USING(kode_prodi) JOIN fakultas f USING(kode_fakultas) WHERE m.npm=?",'s',$npm))[0]??null);
if($r===null)exit('Data tidak ditemukan.');
if($_SERVER['REQUEST_METHOD']=='POST'){try{
 $P=$_POST;$pw=$P['password']!==''?password_hash($P['password'],PASSWORD_DEFAULT):null;
 if($adm){
  if($baru){q("INSERT INTO mahasiswa VALUES(?,?,?,?,?,?,?,?,?)",'sssssssss',$P['npm'],$P['nama'],$P['jk'],$P['tl'],$P['tgl'],$P['masuk'],$P['alamat'],$pw??'',$P['prodi']);}
  else{q("UPDATE mahasiswa SET npm=?,nama_mahasiswa=?,jenis_kelamin=?,tempat_lahir=?,tanggal_lahir=?,tanggal_masuk=?,alamat=?,kode_prodi=? WHERE npm=?",'sssssssss',$P['npm'],$P['nama'],$P['jk'],$P['tl'],$P['tgl'],$P['masuk'],$P['alamat'],$P['prodi'],$npm);$npm=$P['npm'];}
 }else{ // mahasiswa: TIDAK boleh ubah npm, jenis kelamin, prodi, fakultas, tanggal masuk
  q("UPDATE mahasiswa SET nama_mahasiswa=?,tempat_lahir=?,tanggal_lahir=?,alamat=? WHERE npm=?",'sssss',$P['nama'],$P['tl'],$P['tgl'],$P['alamat'],$npm);}
 if($pw&&!$baru){q("UPDATE mahasiswa SET password=? WHERE npm=?",'ss',$pw,$npm);q("UPDATE pengguna SET password=? WHERE npm=?",'ss',$pw,$npm);}
 if(!$baru){q("UPDATE pengguna SET nama_lengkap=?,email=?".($adm?",kode_prodi=?":"")." WHERE npm=?",$adm?'ssss':'sss',...($adm?[$P['nama'],$P['email'],$P['prodi'],$npm]:[$P['nama'],$P['email'],$npm]));}
 header('Location: mahasiswa.php');exit;}catch(mysqli_sql_exception $x){$msg='Gagal menyimpan: NPM duplikat atau data tidak valid.';}}
$v=fn($k)=>e($r[$k]??''); atas($baru?'Tambah Mahasiswa':'Edit Mahasiswa'); if($msg)echo '<p class="err">'.$msg.'</p>';
$ro=$adm?'':' readonly class="ro"';?>
<form method="post" class="box wide">
<label>NPM<input name="npm" required value="<?=$v('npm')?>"<?=$ro?>></label>
<label>Nama<input name="nama" required value="<?=$v('nama_mahasiswa')?>"></label>
<label>Jenis Kelamin<?php if($adm){?><select name="jk"><option value="L"<?=($r['jenis_kelamin']??'')=='L'?' selected':''?>>Laki-laki</option><option value="P"<?=($r['jenis_kelamin']??'')=='P'?' selected':''?>>Perempuan</option></select>
<?php }else echo '<input class="ro" readonly value="'.$v('jenis_kelamin').'">';?></label>
<label>Program Studi<?php if($adm){?><select name="prodi"><?php foreach(rows(q("SELECT * FROM program_studi")) as $p)echo '<option value="'.e($p['kode_prodi']).'"'.(($r['kode_prodi']??'')==$p['kode_prodi']?' selected':'').'>'.e($p['nama_program_studi']).'</option>';?></select>
<?php }else echo '<input class="ro" readonly value="'.$v('nama_program_studi').'">';?></label>
<?php if(!$adm){?><label>Fakultas<input class="ro" readonly value="<?=$v('nama_fakultas')?>"></label><?php }?>
<label>Tempat Lahir<input name="tl" value="<?=$v('tempat_lahir')?>"></label>
<label>Tanggal Lahir<input type="date" name="tgl" value="<?=$v('tanggal_lahir')?>"></label>
<label>Tanggal Masuk<input type="date" name="masuk" value="<?=$v('tanggal_masuk')?>"<?=$ro?>></label>
<label>Alamat<textarea name="alamat"><?=$v('alamat')?></textarea></label>
<?php if(!$baru){?><label>Email<input type="email" name="email" value="<?=$v('email')?>"></label><?php }?>
<label>Password <?=$baru?'':'(kosongkan jika tidak diubah)'?><input type="password" name="password" <?=$baru?'required':''?>></label>
<button>Simpan</button> <a href="mahasiswa.php">Batal</a></form>
<?php bawah();
