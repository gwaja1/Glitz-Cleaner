<?php
require_once 'vendor/autoload.php';

// Mulai sesi untuk menyimpan Snap Token
session_start();

// Setup konfigurasi untuk Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-3OAD1jjlXUHo_a2HKD1uvdGf'; // Ganti dengan server key Anda
\Midtrans\Config::$isProduction = false;  // Atur ke true saat sudah siap untuk mode produksi
\Midtrans\Config::$isSanitized = true;  // Aktifkan sanitasi untuk keamanan
\Midtrans\Config::$is3ds = true;  // Aktifkan 3D Secure untuk keamanan tambahan

// Ambil data booking dari database (contoh)
$id_booking = $_GET['id_booking'];  // Atau bisa dari sesi atau cara lain untuk mendapatkan id_booking

// Misalnya, mengambil data booking dari database menggunakan id_booking
$query = "SELECT * FROM booking WHERE id_booking = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_booking);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();  // Ambil data booking sebagai array

// Pastikan data booking ada
if (!$booking) {
    echo "Booking not found!";
    exit();
}

// Ambil informasi dari data booking
$nama = $booking['nama'];  // Nama lengkap
$email = $booking['email']; // Email
$no_telpon = $booking['no_telpon']; // Nomor telepon
$alamat = $booking['alamat']; // Alamat
$jenis_layanan = $booking['jenis_layanan']; // Jenis layanan
$harga = 1000000; // Ganti dengan perhitungan harga yang sesuai, jika ada

// ID pemesanan yang unik, dihasilkan dari ID booking atau custom
$order_id = uniqid('ORDER-' . $booking['id_booking']);

// Detail transaksi
$transactionDetails = [
    'order_id' => $order_id,
    'gross_amount' => $harga,  // Total pembayaran
];

// Data pelanggan
$customerDetails = [
    'first_name' => $nama,
    'email' => $email,
    'phone' => $no_telpon,
];

// Detail item (misalnya layanan yang dibeli)
$itemDetails = [
    [
        'id' => 'service_' . $booking['id_booking'],
        'price' => $harga,
        'quantity' => 1,
        'name' => $jenis_layanan,  // Nama layanan
    ]
];

// Gabungkan semua data untuk transaksi Midtrans
$transactionData = [
    'transaction_details' => $transactionDetails,
    'customer_details' => $customerDetails,
    'item_details' => $itemDetails,
];

// Generate Snap Token dari Midtrans
try {
    // Mendapatkan Snap Token
    $snapToken = \Midtrans\Snap::getSnapToken($transactionData);

    // Simpan Snap Token dalam sesi untuk digunakan di frontend
    $_SESSION['snap_token'] = $snapToken;

    // Tampilkan Snap Token
    echo "Snap Token ID: " . $snapToken;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
