<?php
session_start(); // Memulai session
include "koneksi.php"; // Koneksi ke database

// Cek apakah user sudah login dan memiliki `id_user`
if (isset($_SESSION['userid'])) {
    $id_user = $_SESSION['userid']; // Pastikan Anda menyimpan id_user di session

    // Pastikan id_user yang tersimpan dalam session valid dengan memeriksa database
    $stmt = $conn->prepare("SELECT iduser FROM user WHERE iduser = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("User tidak valid.");
    }
} else {
    die("User belum login.");
}

$id_booking = $_POST['id_booking'] ?? null;
$status = $_POST['status'] ?? null;


// Cek apakah data sudah ada di tabel history_order
$stmt = $conn->prepare("SELECT * FROM history_order WHERE iduser = ? AND id_booking = ?");
$stmt->bind_param("ii", $id_user, $id_booking);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: history.php"); // Redirect jika data sudah ada
    exit();
}

// Query untuk menyimpan data ke tabel history_order menggunakan prepared statement
$stmt = $conn->prepare("INSERT INTO history_order (iduser, id_booking, status, harga) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iisi", $id_user, $id_booking, $status, $harga);

if ($stmt->execute()) {
    header("Location: history.php"); // Redirect ke halaman history setelah sukses
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
