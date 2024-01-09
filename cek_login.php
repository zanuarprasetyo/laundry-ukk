<?php
session_start();

include 'koneksi.php';



$username = $_POST['username'];
$password = md5($_POST['password']);


$login = mysqli_query($koneksi,"select * from tb_user where username='$username' and password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){
    $data = mysqli_fetch_assoc($login);
    if($data['role']=="admin"){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = "admin";
        header("location:admin");
    }else if ($data['role']=="kasir"){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = "kasir";
        header("location:kasir");
    }else if ($data['role']=="owner"){
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = "owner";
    header("location:owner");
    }else{
        header("location:index.php?info=gagal");
    }
}else{
    header("location:index.php?info=gagal");
}
?>