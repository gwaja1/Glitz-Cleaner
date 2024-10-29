<?php
session_start();
include "koneksi.php";

// Check if the user is logged in and has the role 'cleaner'
if (isset($_SESSION['id_user'])) {
    $id_user = $_SESSION['id_user'];

    // Fetch the role of the logged-in user
    $check_role = $conn->query("SELECT role FROM user WHERE iduser = '$id_user'");
    $user_data = $check_role->fetch_assoc();

    if ($user_data['role'] !== 'cleaner') {
        die("Access denied. Only cleaners can access this page.");
    }
} else {
    die("User not logged in.");
}

// Fetch pending orders for cleaners
$orders = $conn->query("SELECT * FROM id_booking WHERE status = 'pending'");

// Handle "Terima" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Update the order status to 'accepted'
    $update_status = $conn->query("UPDATE booking SET status = 'accepted' WHERE id_booking = '$order_id'");
    if ($update_status) {
        echo "Order accepted successfully!";
    } else {
        echo "Failed to accept the order: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Glitz Cleaner Cleaning Services </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/setyle.css" rel="stylesheet">
    <link rel="icon" href="Img/Logo.png" type="image/png">
    <style>
        .profile-image .image {
            width: 50px;
            height: 50px;
            margin: 0 30px 0 0;
            border-radius: 50%;
        }

        .profile-image .image-list {
            position: absolute;
            max-height: 0;
            right: 30px;
            top: 100%;
            width: 100px;
            text-align: center;
            visibility: hidden;
            padding: 0;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 10;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s ease;
        }

        .profile-image:hover .image-list {
            max-height: 100%;
            visibility: visible;
            opacity: 1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h2>Daftar Pesanan untuk Diterima</h2>

    <?php if ($orders->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Service Type</th>
                <th>Cleaning Date</th>
                <th>Actions</th>
            </tr>
            <?php while ($order = $orders->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id_booking']) ?></td>
                    <td><?= htmlspecialchars($order['nama']) ?></td>
                    <td><?= htmlspecialchars($order['jenis_layanan']) ?></td>
                    <td><?= htmlspecialchars($order['tanggal_pembersihan']) ?></td>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="order_id" value="<?= $order['id_booking'] ?>">
                            <button type="submit">Terima</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No pending orders available for acceptance.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>

</html>