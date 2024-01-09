<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];
$status = $_POST['status'];

// menginput data ke database
mysqli_query($koneksi,"update tb_transaksi set status='$status' where id='$id'");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");

?>