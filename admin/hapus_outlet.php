<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_GET['id'];

// menghapus data dari database
mysqli_query($koneksi,"delete from tb_outlet where id='$id'");

// mengalihkan halaman kembali ke index.php
header("location:outlet.php?info=delete");
?>