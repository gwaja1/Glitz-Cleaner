<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
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

// Ambil data dari form
$nama = $_POST['name'] ?? ''; // Ganti dengan nama yang sesuai
$email = $_POST['email'] ?? ''; // Ganti dengan nama yang sesuai
$no_telpon = $_POST['phone'] ?? ''; // Ganti dengan nama yang sesuai
$alamat = $_POST['address'] ?? ''; // Ganti dengan nama yang sesuai
$jenis_layanan = $_POST['service_type'] ?? ''; // Ganti dengan nama yang sesuai
$tanggal_pembersihan = $_POST['date'] ?? ''; // Ganti dengan nama yang sesuai
$waktu_pembersihan = $_POST['time'] ?? ''; // Ganti dengan nama yang sesuai
$catatan = $_POST['notes'] ?? ''; // Ganti dengan nama yang sesuai

// Validasi data sederhana
if (!empty($name) && !empty($email) && !empty($phone) && !empty($address) && !empty($service_type) && !empty($date) && !empty($time)) {

    // Query untuk memasukkan data ke tabel booking termasuk id_user
    $insertQuery = "INSERT INTO booking (id_user, nama, email, no_telpon, alamat, jenis_layanan, tanggal_pembersihan, waktu_pembersihan, catatan) 
    VALUES ('$id_user', '$name', '$email', '$phone', '$address', '$service_type', '$date', '$time', '$note') 
    ON DUPLICATE KEY UPDATE 
        nama='$name', 
        email='$email', 
        no_telpon='$phone', 
        alamat='$address', 
        jenis_layanan='$service_type', 
        tanggal_pembersihan='$date', 
        waktu_pembersihan='$time', 
        catatan='$notes'";

    if (mysqli_query($conn, $insertQuery)) {
        echo "Data booking berhasil ditambahkan atau diperbarui.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "Semua field harus diisi!";
}
?>