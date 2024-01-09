<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id_outlet = $_POST['id_outlet'];
$jenis = $_POST['jenis'];
$nama_paket = $_POST['nama_paket'];
$harga = $_POST['harga'];

// menginput data ke database
mysqli_query($koneksi,"insert into tb_paket values('','$id_outlet','$jenis','$nama_paket','$harga')");

// mengalihkan halaman kembali ke index.php
header("location:paket.php?info=simpan");

?>