<?php
// submit_booking.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_telpon = $_POST['no_telpon'];
    $alamat = $_POST['alamat'];
    $jenis_layanan = $_POST['jenis_layanan'];
    $tanggal_pembersihan = $_POST['tanggal_pembersihan'];
    $waktu_pembersihan = $_POST['waktu_pembersihan'];
    $catatan = $_POST['catatan'];

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
        $sql = "INSERT INTO booking (name, email, phone, address, service_type, date, time, notes)
        VALUES ('$name', '$email', '$phone', '$address', '$service_type', '$date', '$time', '$notes')";

        if ($conn->query($sql) === TRUE) {
            echo "Pemesanan berhasil dilakukan! Terima kasih telah menggunakan layanan kami.";
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