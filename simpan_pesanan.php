<?php
session_start(); // Memulai session
include "koneksi.php"; // Koneksi ke database

// Cek apakah user sudah login dan memiliki `userid`
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid']; // Mengambil userid dari session

    // Memastikan userid dalam session valid dengan memeriksa database
    $stmt = $conn->prepare("SELECT iduser FROM user WHERE iduser = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("User tidak valid.");
    }
} else {
    die("User belum login.");
}

// Mengambil nilai dari POST untuk id_booking dan status
$id_booking = $_POST['id_booking'] ?? null;
$status = $_POST['status'] ?? 'default_status'; // Set default value if not provided

// Pastikan id_booking telah ditentukan dan valid
if (!$id_booking || !is_numeric($id_booking)) {
    die("ID booking tidak valid.");
}

// Mengambil data dari tabel `booking` berdasarkan id_booking
$stmt = $conn->prepare("SELECT jenis_ruangan, ukuran_ruangan, jenis_layanan, tanggal_pembersihan, waktu_pembersihan FROM booking WHERE id_booking = ?");
$stmt->bind_param("i", $id_booking);
$stmt->execute();
$booking_result = $stmt->get_result();

if ($booking_result->num_rows > 0) {
    $booking_data = $booking_result->fetch_assoc();
    $jenis_ruangan = $booking_data['jenis_ruangan'];
    $ukuran_ruangan = $booking_data['ukuran_ruangan'];
    $jenis_layanan = $booking_data['jenis_layanan'];
    $tanggal_pembersihan = $booking_data['tanggal_pembersihan'];
    $waktu_pembersihan = $booking_data['waktu_pembersihan'];
} else {
    die("Booking tidak ditemukan.");
}

// Tentukan harga secara langsung jika tidak diambil dari `booking`
$harga = 1000000; // Contoh: harga tetap

// Cek apakah data sudah ada di tabel history_order untuk userid dan id_booking ini
$stmt = $conn->prepare("SELECT * FROM nama_ruangan WHERE id_user = ? AND id_booking = ?");
$stmt->bind_param("ii", $userid, $id_booking);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: history.php"); // Redirect jika data sudah ada
    exit();
}

// Query untuk menyimpan data ke tabel history_order
$stmt = $conn->prepare("INSERT INTO history_order (id_user, id_booking, id_ruangan, status, harga) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiisi", $userid, $id_booking, $jenis_ruangan, $status, $harga);

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
