<?php
// HOSTING: upload dengan nama koneksi.php, isi password sendiri
$host="sql301.infinityfree.com"; $user="if0_42968972"; $pass="ISI_PASSWORD_HOSTING"; $dbname="if0_42968972_universitassemantik";
$koneksi=mysqli_connect($host,$user,$pass,$dbname);
if(!$koneksi){die("Koneksi gagal: ".mysqli_connect_error());}
mysqli_set_charset($koneksi,"utf8mb4");
