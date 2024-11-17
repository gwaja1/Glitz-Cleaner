<?php
// Konfigurasi Midtrans
require_once 'Midtrans/Config.php';
require_once 'Midtrans/Notification.php';
require_once 'config.php';  // Koneksi ke database

use Midtrans\Config;
use Midtrans\Notification;

// Konfigurasi Midtrans
Config::$serverKey = 'SB-Mid-server-3OAD1jjlXUHo_a2HKD1uvdGf'; // Ganti dengan Server Key Anda
Config::$isProduction = false; // false untuk sandbox

// Terima notifikasi dari Midtrans
$notification = new Notification();

$order_id = $notification->order_id;  // ID order dari notifikasi
$status = $notification->transaction_status;  // Status transaksi (success, pending, failed)
$payment_type = $notification->payment_type; // Jenis pembayaran yang digunakan (credit_card, bank_transfer, dll)
$snap_token = $notification->fraud_status; // Menyimpan status fraud atau informasi terkait transaksi (tergantung kebutuhan)

try {
    // Koneksi ke database
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Update status transaksi di database
    $stmt = $conn->prepare("UPDATE transaksi SET status = ?, payment_type = ?, snap_token = ? WHERE order_id = ?");
    $stmt->bind_param('ssss', $status, $payment_type, $snap_token, $order_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Status pembayaran berhasil diperbarui";
    } else {
        echo "Gagal memperbarui status pembayaran";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
