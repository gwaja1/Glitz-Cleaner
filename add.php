<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login dan memiliki `id_user`
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

// Cek apakah semua data form tersedia
if (
    isset($_POST['nama']) && isset($_POST['email']) && isset($_POST['phone']) &&
    isset($_POST['address']) && isset($_POST['service_type']) &&
    isset($_POST['room_type']) && isset($_POST['Room-size']) &&
    isset($_POST['date']) && isset($_POST['time'])
) {
    // Mengambil data dari form
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $service_type = $conn->real_escape_string($_POST['service_type']);
    $room_type = $conn->real_escape_string($_POST['room_type']);
    $room_size = $conn->real_escape_string($_POST['Room-size']);
    $date = $conn->real_escape_string($_POST['date']);

    // Format waktu menjadi hh:mm:ss untuk memastikan tidak ada milidetik
    $time = date("H:i:s", strtotime($_POST['time']));
    $time = $conn->real_escape_string($time);

    $notes = isset($_POST['notes']) ? $conn->real_escape_string($_POST['notes']) : '';

    // Query untuk memasukkan data ke tabel booking, termasuk id_user
    $sql = "INSERT INTO booking (id_user, nama, email, no_telpon, alamat, jenis_layanan, jenis_ruangan, ukuran_ruangan, tanggal_pembersihan, waktu_pembersihan, catatan)
            VALUES ('$id_user', '$nama', '$email', '$phone', '$address', '$service_type', '$room_type', '$room_size', '$date', '$time', '$notes')";

    // Get the last inserted ID
// After successful insertion
    if ($conn->query($sql) === TRUE) {
        // Get the last inserted ID
        $last_id = $conn->insert_id;
        // Store the booking ID in session
        $_SESSION['id_booking'] = $last_id; // Ensure this is set correctly
        header('Location:Pembayaran.php');
        exit(); // Make sure to exit after header redirection
    }

}

$conn->close();
?>