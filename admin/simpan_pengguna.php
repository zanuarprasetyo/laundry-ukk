<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$nama = $_POST['nama'];
$username = $_POST['username'];
$password = md5($_POST['password']);
$id_outlet = $_POST['id_outlet'];
$role = $_POST['role'];

// menginput data ke database
mysqli_query($koneksi,"insert into tb_user values('','$nama','$username','$password','$id_outlet','$jk','$role')");

// mengalihkan halaman kembali ke index.php
header("location:pengguna.php?info=simpan");

?>