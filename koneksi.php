<?php
// LOKAL
$host="localhost"; $user="root"; $pass=""; $dbname="universitassemantik";
$koneksi=mysqli_connect($host,$user,$pass,$dbname);
if(!$koneksi){die("Koneksi gagal: ".mysqli_connect_error());}
mysqli_set_charset($koneksi,"utf8mb4");
