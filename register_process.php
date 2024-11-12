<?php
// memanggil file koneksi.php
include "koneksi.php";

// Menerima data dari form
$email = $_POST["email"];
$pass = $_POST["password"];
$name = $_POST["name"];
$role = "user"; // level otomatis diisi user pd saat registrasi
$kirim = $_POST['regis'];

// Meng-hash password
$hashedPassword = password_hash($pass, PASSWORD_BCRYPT);

// Proses kirim data ke database MySQL
if ($kirim) {
    $query = "INSERT INTO `user` (`iduser`, `name`, `email`, `password`, `role`) VALUES ('', '$name', '$email', '$hashedPassword', '$role')";

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
?>
