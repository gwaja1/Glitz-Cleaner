<?php
include "koneksi.php";
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['userid'])) {
    die("User belum login.");
}

$userid = $_SESSION['userid'];

// Ambil data user (nama dan email) berdasarkan userid
$query = $conn->prepare("SELECT name, email FROM user WHERE iduser = ?");
$query->bind_param("i", $userid);
$query->execute();
$result = $query->get_result();
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
    $name = $user_data['name'];
    $email = $user_data['email'];
} else {
    die("User tidak ditemukan.");
}
$query->close();

// Ambil harga jenis layanan
$queryLayanan = $conn->prepare("SELECT harga FROM layanan WHERE id_layanan = ?");
$queryLayanan->bind_param("s", $_POST['jenis_layanan']);
$queryLayanan->execute();
$resultLayanan = $queryLayanan->get_result();
if ($resultLayanan->num_rows > 0) {
    $layanan_data = $resultLayanan->fetch_assoc();
    $harga_layanan = $layanan_data['harga'];
} else {
    die("Jenis layanan tidak ditemukan.");
}
$queryLayanan->close();

// Ambil harga ukuran ruangan
$queryUkuran = $conn->prepare("SELECT harga FROM ukuran WHERE id_ukuran = ?");
$queryUkuran->bind_param("s", $_POST['ukuran_ruangan']);
$queryUkuran->execute();
$resultUkuran = $queryUkuran->get_result();
if ($resultUkuran->num_rows > 0) {
    $ukuran_data = $resultUkuran->fetch_assoc();
    $harga_ukuran = $ukuran_data['harga'];
} else {
    die("Ukuran ruangan tidak ditemukan.");
}
$queryUkuran->close();

// Menghitung total harga
$total_harga = $harga_layanan + $harga_ukuran;

// Persiapan query untuk memasukkan data ke dalam tabel history_order
$stmt = $conn->prepare("INSERT INTO history_order (id_user, alamat, id_layanan, id_ruangan, tanggal_bersih, waktu, catatan, total_harga) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

// Mengikat parameter sesuai dengan tipe data
$stmt->bind_param(
    "isiisssi",  // Tipe data untuk parameter
    $userid,  // id_user
    $_POST['alamat'], // alamat
    $_POST['jenis_layanan'], // jenis_layanan
    $_POST['ukuran_ruangan'], // ukuran_ruangan
    $_POST['tanggal_bersih'], // tanggal_bersihan
    $_POST['waktu'], // waktu_pembersihan
    $_POST['catatan'],  // catatan
    $total_harga   // total_harga
);

// Eksekusi query
if ($stmt->execute()) {
    $id_history_order = $stmt->insert_id; 
    echo "ID History Order: $id_history_order";  // Debugging
    header("Location: Pembayaran.php?id_history=$id_history_order"); 
    exit();
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
