<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$tlp = $_POST['tlp'];

// menginput data ke database
mysqli_query($koneksi,"insert into tb_outlet values('','$nama','$alamat','$tlp')");

// mengalihkan halaman kembali ke index.php
header("location:outlet.php?info=simpan");

?>