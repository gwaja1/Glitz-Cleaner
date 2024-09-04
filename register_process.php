<?php
//memanggil file koneksi.php
include "koneksi.php";
$email = $_POST["email"];
$pass = $_POST["password"];
$name = $_POST["name"];
$role = "user";//level otomatis diisi user pd saat registrasi
//format acak password harus sama dengan proses_login.php
$kirim = $_POST['regis'];
//proses kirim data ke database MYSQL

// Proses kirim data ke database MySQL
if ($kirim) {
    $query = "INSERT INTO `user` (`iduser`, `name`, `email`, `password`, `role`) VALUES ('', '$name', '$email', '$pass', '$role')";

    // Mengeksekusi query dan mengecek apakah berhasil
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header('Location:login.php');
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header('Location:regis.php');
}