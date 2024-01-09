<?php
$koneksi = mysqli_connect("localhost","root","","laundry_ukk_web");

// check connection
if (mysqli_connect_error()){
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}
?>