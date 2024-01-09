<!-- transaksi -->
<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];
$kode_invoice = $_POST['kode_invoice'];
$id_member = $_POST['id_member'];
$id_outlet = $_POST['id_outlet'];
$qty = $_POST['qty'];
$biaya_tambahan = $_POST['biaya_tambahan'];
$id_user = $_POST['id_user'];
$pajak = $_POST['pajak'];

// menginput data ke database
mysqli_query($koneksi,"update tb_transaksi set kode_invoice='$kode_invoice', id_member='$id_member', id_outlet='$id_outlet', qty='$qty', pajak='$pajak', id_user='$id_user' where id='$id'");

// mysqli_query($koneksi,"insert into tb_transaksi values('','$id_paket','$kode_invoice','$id_member','$tgl','$batas_waktu','','$biaya_tambahan','','','baru','belum_dibayar','$qty','','$id_user')");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");
?>