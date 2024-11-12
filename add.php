<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['userid'])) {
    die("User belum login.");
}

$userid = $_SESSION['userid'];

// Persiapan query dan bind parameter
$stmt = $conn->prepare("INSERT INTO booking (id_user, nama, email, no_telpon, alamat, jenis_layanan, jenis_ruangan, ukuran_ruangan, tanggal_pembersihan, waktu_pembersihan, catatan) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind parameter sesuai tipe data yang sesuai
$stmt->bind_param(
    "issssssssss",
    $userid,
    $_POST['nama'],
    $_POST['email'],
    $_POST['no_telpon'],
    $_POST['alamat'],
    $_POST['jenis_layanan'],
    $_POST['jenis_ruangan'],
    $_POST['ukuran_ruangan'],
    $_POST['tanggal_pembersihan'],
    $_POST['waktu_pembersihan'],
    $_POST['catatan']
);

// Eksekusi dan cek keberhasilan
if ($stmt->execute()) {
    // Ambil ID booking yang baru saja dimasukkan
    $id_booking = $stmt->insert_id; 

    // Redirect ke halaman pembayaran dengan membawa ID booking
    header("Location: Pembayaran.php?id_booking=$id_booking"); 
    exit();
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
