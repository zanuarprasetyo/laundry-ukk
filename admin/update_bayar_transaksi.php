<?php
// koneksi ke database
include "../koneksi.php";

// Menangkap data yang dikirim dari form
$id = $_POST['id'];
$id_paket = $_POST['id_paket'];
$qty = $_POST['qty'];   

// Membuat function untuk mendapatkan tanggal dan waktu saat ini
function getTanggalWaktuSekarang() {
    return date('Y-m-d H:i:s');
}

// Mendapatkan tanggal dan waktu saat ini
$tgl_bayar = getTanggalWaktuSekarang();
 
// Menginput data ke database
mysqli_query($koneksi, "INSERT INTO tb_detail_transaksi VALUES ('', '$id', '$id_paket', '$qty', 'sudah dibayar')");
mysqli_query($koneksi, "UPDATE tb_transaksi SET dibayar='dibayar', tgl_bayar='$tgl_bayar' WHERE id='$id'");

// Code cadangan jika tidak bisa membayar 
// mysqli_query($koneksi, "INSERT INTO tb_detail_transaksi (id_transaksi, id_paket, qty) VALUES ('$id', '$id_paket', '$qty', 'sudah dibayar')");

// Mengalihkan halaman kembali ke index.php
header("location:transaksi.php?info=update");
?>
