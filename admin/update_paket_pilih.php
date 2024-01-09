<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];
$id_paket = $_POST['id_paket'];

// menginput data ke database
mysqli_query($koneksi,"update tb_transaksi set id_paket='$id_paket' where id='$id'");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");

?>