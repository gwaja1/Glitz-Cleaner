<?php
// Konfigurasi Midtrans
require_once 'Midtrans/Config.php';
require_once 'Midtrans/Snap.php';

use Midtrans\Config;
use Midtrans\Snap;

Config::$serverKey = 'SB-Mid-server-3OAD1jjlXUHo_a2HKD1uvdGf'; // Ganti dengan Server Key Anda
Config::$isProduction = false; // false untuk sandbox

// Ambil data transaksi yang dibutuhkan
$order_id = 'ORDER123';  // Ganti dengan ID order dinamis
$gross_amount = 10000;  // Jumlah yang harus dibayar
$customer_name = 'Andi Sutanto';
$customer_email = 'andi@example.com';
$customer_phone = '08123456789';

// Data untuk transaksi
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => $gross_amount,
);

$item_details = array(
    array(
        'id' => 'item01',
        'price' => $gross_amount,
        'quantity' => 1,
        'name' => 'Test Item',
    ),
);

$customer_details = array(
    'first_name' => $customer_name,
    'last_name' => '',
    'email' => $customer_email,
    'phone' => $customer_phone,
);

$transaction = array(
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details,
);

try {
    // Membuat transaksi dan mendapatkan snap token
    $snapToken = Snap::getSnapToken($transaction);
    
    // Kirimkan snapToken ke frontend
    echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Gagal membuat transaksi']);
}
?>
