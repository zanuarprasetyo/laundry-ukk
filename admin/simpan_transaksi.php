<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$kode_invoice = $_POST['kode_invoice'];
$tgl = $_POST['tgl'];
$id_member = $_POST['id_member'];
$id_outlet = $_POST['id_outlet'];
$qty = $_POST['qty'];
$biaya_tambahan = $_POST['biaya_tambahan'];
$id_user = $_POST['id_user'];
$batas_waktu = date('Y-d-m H:i:s', strtotime('+2 days'));

// menginput data ke database
mysqli_query($koneksi,"insert into tb_transaksi values('','$id_outlet','','$kode_invoice','$id_member','$tgl','$batas_waktu','','','','baru','belum_dibayar','$qty','$id_user')");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=simpan");


?>