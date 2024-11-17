<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_booking = $_POST['id_booking'];
    $status = 'lunas'; // Sesuaikan statusnya

    $query = "UPDATE booking SET status_pembayaran = ? WHERE id_booking = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $id_booking);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Pembayaran berhasil disimpan.";
    } else {
        echo "Gagal menyimpan pembayaran.";
    }
}
