<?php
session_start();
include 'koneksi.php';

$order_id = $_GET['order_id'] ?? null;

if ($order_id) {
    // Update status transaksi berdasarkan order_id
    $query = "UPDATE booking SET status = 'dibayar' WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $order_id);
    if ($stmt->execute()) {
        echo "Pembayaran berhasil dikonfirmasi.";
    } else {
        echo "Gagal memperbarui status pembayaran.";
    }
} else {
    echo "Order ID tidak ditemukan.";
}
?>
