<?php
session_start(); // Memulai session
include "koneksi.php"; // Koneksi ke database

// Cek apakah user sudah login dan memiliki `id_user`
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user']; // Pastikan Anda menyimpan id_user di session

    // Pastikan id_user yang tersimpan dalam session valid dengan memeriksa database
    $check_user = $conn->query("SELECT iduser FROM user WHERE iduser = '$id_user'");
    if ($check_user->num_rows == 0) {
        die("User tidak valid.");
    }
} else {
    die("User belum login.");
}

$id_booking = $_POST['id_booking'] ?? null;
$status = $_POST['status'] ?? null;
$harga = $_POST['harga'] ?? null;

if (!$id_user || !$id_booking || !$harga) {
    die("User belum login atau data tidak valid.");
}

// Cek apakah data sudah ada
$check_existing = $conn->query("SELECT * FROM history_order WHERE iduser = '$id_user' AND id_booking = '$id_booking'");
if ($check_existing->num_rows > 0) {
    header("Location: history.php"); // Redirect if data already exists
    exit();
}

// Query untuk menyimpan data ke tabel history_order
$sql = "INSERT INTO history_order (iduser, id_booking, status, harga)
        VALUES ('$id_user', '$id_booking', '$status', '$harga')";

if ($conn->query($sql) === TRUE) {
    header("Location: history.php"); // Redirect to history page after successful insertion
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>