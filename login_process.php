<?php
// Memanggil file koneksi.php
include "koneksi.php";

// Menerima data dari form
$email = $_POST["email"];
$pass = $_POST["password"];

// Query untuk mencari user berdasarkan email
$query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";

// Mengeksekusi query
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Mengecek apakah user ditemukan
if ($user) {
    // Verifikasi password dengan password yang ada di database
    if (password_verify($pass, $user['password'])) {
        // Jika password cocok, login sukses
        session_start();
        $_SESSION['userid'] = $user['iduser']; // Menyimpan ID user di session
        $_SESSION['uname'] = $user['name'];    // Menyimpan nama user di session
        $_SESSION['email'] = $user['email'];  // Menyimpan email user di session
        $_SESSION['role'] = $user['role'];    // Menyimpan role user di session

        // Redirect ke halaman sesuai dengan role
        if ($user['role'] == 'admin') {
            header('Location: Panel_admin.php');
        } elseif ($user['role'] == 'user') {
            header('Location: user.php');
        } elseif ($user['role'] == 'cleaner') {
            header('Location: cleaner.php');
        } else {
            // Jika role tidak dikenali
            echo "Role tidak valid!";
        }
    } else {
        // Jika password tidak cocok
        echo "Password salah!";
    }
} else {
    // Jika email tidak ditemukan
    echo "Email tidak terdaftar!";
}
?>
