<?php
session_start(); // Memulai session

include "koneksi.php"; // Koneksi ke database

// Ambil data dari form
$email = $_POST['email'];
$pass = $_POST['password'];

// Sanitasi dan escape input pengguna
$email = mysqli_real_escape_string($conn, $email);
$pass = mysqli_real_escape_string($conn, $pass);

// Query untuk memilih data pengguna berdasarkan email dan password
$query = "SELECT * FROM `user` WHERE email='$email' AND password='$pass'";

// Jalankan query
$hasil = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if ($hasil) {
    $cek = mysqli_num_rows($hasil);

    // Jika ada hasil
    if ($cek > 0) {
        // Ambil data hasil query
        $data = mysqli_fetch_array($hasil);

        // Simpan iduser ke dalam session
        $_SESSION['id_user'] = $data['iduser']; // Mengambil iduser dari hasil query

        // Cek peran pengguna
        if ($data['role'] == "admin") {
            // Buat session login dan role
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "admin";
            // Alihkan ke halaman dashboard admin
            header("location:panel_admin.php");
        } else if ($data['role'] == "user") {
            // Buat session login dan role
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "user";
            // Alihkan ke halaman dashboard user
            header("location:user.php");
        } else {
            echo "Anda Bukan Admin dan Bukan User";
            header("location:login.php");
        }
    } else {
        // Jika tidak ada hasil
        echo "GAGAL LOGIN!!!, Username dan Password tidak ditemukan";
    }
} else {
    // Jika query gagal dijalankan
    echo "Error: " . mysqli_error($conn);
}

// Tutup koneksi
mysqli_close($conn);
?>