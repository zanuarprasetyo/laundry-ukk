<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];
$id_outlet = $_POST['id_outlet'];
$jenis = $_POST['jenis'];
$nama_paket = $_POST['nama_paket'];
$harga = $_POST['harga'];

// menginput data ke database
mysqli_query($koneksi,"update tb_paket set id_outlet='$id_outlet', jenis='$jenis', nama_paket='$nama_paket', harga='$harga' where id='$id'");

// mengalihkan halaman kembali ke index.php
header("location:paket.php?info=update");

?>