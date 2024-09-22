<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
if (isset($_SESSION['email']) && isset($_SESSION['id_user'])) {
    $email = $_SESSION['email'];
    $id_user = $_SESSION['id_user']; // Ambil ID user dari session

    // Pastikan id_user yang tersimpan dalam session valid dengan memeriksa database
    $check_user = $conn->query("SELECT iduser FROM user WHERE iduser = '$id_user'");
    if ($check_user->num_rows == 0) {
        die("User tidak valid.");
    }
} else {
    die("User belum login.");
}

// Ambil data dari form
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$service_type = $_POST['service_type'];
$date = $_POST['date'];
$time = $_POST['time'];
$notes = $_POST['notes'];

// Validasi data sederhana
if (!empty($name) && !empty($email) && !empty($phone) && !empty($address) && !empty($service_type) && !empty($date) && !empty($time)) {

    // Query untuk memasukkan data ke tabel booking termasuk id_user
    $sql = "INSERT INTO booking (id_user, nama, email, no_telpon, alamat, jenis_layanan, tanggal_pembersihan, waktu_pembersihan, catatan)
                VALUES ('$id_user', '$name', '$email', '$phone', '$address', '$service_type', '$date', '$time', '$notes')";

    if ($conn->query($sql) === TRUE) {
        echo "Pemesanan berhasil dilakukan!";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "Semua field harus diisi!";
}
?>