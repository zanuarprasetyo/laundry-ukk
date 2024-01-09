<?php
// koneksi ke database
include "../koneksi.php";

// menangkap data yang di kirim dari form
$id = $_POST['id'];
$id_paket = $_POST['id_paket'];
$qty = $_POST['qty'];   

// mendapatkan tanggal dan waktu saat ini
$tgl_bayar = date('Y-m-d H:i:s');
 
// menginput data ke database
mysqli_query($koneksi,"insert into tb_detail_transaksi values('','$id','$id_paket','$qty','sudah dibayar')");
mysqli_query($koneksi,"update tb_transaksi set dibayar='dibayar', tgl_bayar='$tgl_bayar' where id='$id'");

// code candangan jika tidak bisa membayar 
// mysqli_query($koneksi, "INSERT INTO tb_detail_transaksi (id_transaksi, id_paket, qty) VALUES ('$id', '$id_paket', '$qty','sudah dibayar')");

// mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");

?>