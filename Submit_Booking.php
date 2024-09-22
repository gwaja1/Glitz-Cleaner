<?php
// submit_booking.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Koneksi ke database 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gclean";

        // Buat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Periksa koneksi
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        // Query untuk memasukkan data ke tabel orders
        $sql = "INSERT INTO booking (nama, email, no_telpon, alamat, jenis_layanan, tanggal_pembersihan, waktu_pembersihan, catatan)
        VALUES ('$name', '$email', '$phone', '$address', '$service_type', '$date', '$time', '$notes')";

        if ($conn->query($sql) === TRUE) {
            header("location:Pembayaran.php");
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }

        // Tutup koneksi
        $conn->close();
    } else {
        echo "Semua field harus diisi!";
    }
} else {
    echo "Permintaan tidak valid.";
}
?>