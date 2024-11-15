<?php
include 'koneksi.php';

// Check if the ID is passed in the URL
if (isset($_GET['id_booking'])) {
    $id_booking = $_GET['id_booking'];

    // Query to fetch booking details based on id_booking
    $query = "SELECT * FROM booking WHERE id_booking = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_booking); // Bind id_booking as an integer
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
} else {
    echo "ID Booking not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Panel - Pembayaran</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Admin Panel Header -->
    <div class="admin-header">
        <h1>Admin Panel - Payment Details</h1>
    </div>

    <!-- Admin Payment Details -->
    <div class="container">
        <h2>Payment Details for Booking ID: <?php echo $booking['id_booking']; ?></h2>
        <table class="table">
            <tr>
                <th>Nama Lengkap</th>
                <td><?php echo $booking['nama']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $booking['email']; ?></td>
            </tr>
            <tr>
                <th>No Telepon</th>
                <td><?php echo $booking['no_telpon']; ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo $booking['alamat']; ?></td>
            </tr>
            <tr>
                <th>Jenis Layanan</th>
                <td><?php echo $booking['jenis_layanan']; ?></td>
            </tr>
            <tr>
                <th>Tanggal Pembersihan</th>
                <td><?php echo $booking['tanggal_pembersihan']; ?></td>
            </tr>
            <tr>
                <th>Waktu Pembersihan</th>
                <td><?php echo $booking['waktu_pembersihan']; ?></td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td><?php echo $booking['catatan']; ?></td>
            </tr>
            <tr>
                <th>Subtotal</th>
                <td>Rp. 1.000.000</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>Rp. 1.000.000</td>
            </tr>
        </table>
    </div>

    <!-- Admin Footer -->
    <div class="admin-footer">
        <p>&copy; 2024 GlitzCleaner</p>
    </div>

</body>

</html>
