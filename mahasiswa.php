<?php require 'auth.php'; izin('administrator','prodi','mahasiswa'); $u=$_SESSION['u'];
if($_SERVER['REQUEST_METHOD']=='POST'&&role()=='administrator'&&isset($_POST['hapus'])){q("DELETE FROM mahasiswa WHERE npm=?",'s',$_POST['hapus']);header('Location: mahasiswa.php');exit;}
$w=[];$t='';$p=[];
if(role()=='mahasiswa'){$w[]='m.npm=?';$t.='s';$p[]=$u['npm'];}
if(role()=='prodi'){$w[]='m.kode_prodi=?';$t.='s';$p[]=$u['kode_prodi'];}
if(role()=='administrator'&&($_GET['prodi']??'')!==''){$w[]='m.kode_prodi=?';$t.='s';$p[]=$_GET['prodi'];}
if(($_GET['npm']??'')!==''){$w[]='m.npm LIKE ?';$t.='s';$p[]='%'.$_GET['npm'].'%';}
$sql="SELECT m.*,ps.nama_program_studi FROM mahasiswa m JOIN program_studi ps USING(kode_prodi)".($w?' WHERE '.implode(' AND ',$w):'').' ORDER BY m.npm';
$d=rows(q($sql,$t,...$p)); atas('Data Mahasiswa');
if(role()!='mahasiswa'){?><form class="f" method="get"><input name="npm" placeholder="Cari NPM" value="<?=e($_GET['npm']??'')?>">
<?php if(role()=='administrator'){?><select name="prodi"><option value="">Semua Prodi</option><?php foreach(rows(q("SELECT * FROM program_studi")) as $r)echo '<option value="'.e($r['kode_prodi']).'"'.(($_GET['prodi']??'')==$r['kode_prodi']?' selected':'').'>'.e($r['nama_program_studi']).'</option>';?></select><?php }?>
<button>Filter</button><?php if(role()=='administrator')echo '<a class="btn" href="mahasiswa_form.php">+ Tambah</a>';?></form><?php }?>
<table><tr><th>NPM</th><th>Nama</th><th>JK</th><th>Prodi</th><th>Tempat/Tgl Lahir</th><th>Tgl Masuk</th><th>Alamat</th><?=role()!='prodi'?'<th>Aksi</th>':''?></tr>
<?php foreach($d as $r){?><tr><td><?=e($r['npm'])?></td><td><?=e($r['nama_mahasiswa'])?></td><td><?=e($r['jenis_kelamin'])?></td><td><?=e($r['nama_program_studi'])?></td>
<td><?=e($r['tempat_lahir'].', '.$r['tanggal_lahir'])?></td><td><?=e($r['tanggal_masuk'])?></td><td><?=e($r['alamat'])?></td>
<?php if(role()!='prodi'){?><td><a href="mahasiswa_form.php?npm=<?=urlencode($r['npm'])?>">Edit</a>
<?php if(role()=='administrator'){?><form method="post" style="display:inline" onsubmit="return confirm('Hapus?')"><button name="hapus" value="<?=e($r['npm'])?>" class="d">Hapus</button></form><?php }?></td><?php }?></tr><?php }?></table>
<?php bawah();
