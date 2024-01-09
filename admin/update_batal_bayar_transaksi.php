<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];

// menginput data ke database
mysqli_query($koneksi,"update tb_transaksi set dibayar='belum_dibayar' where id='$id'");
mysqli_query($koneksi,"delete from tb_detail_transaksi where id_transaksi='$id'");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");

?>