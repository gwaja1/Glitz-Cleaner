<?php
session_start(); // Start session

include "koneksi.php"; // Database connection

// Ensure `userid` is present in session
if (!isset($_SESSION['userid'])) {
    die("User belum login atau session tidak valid.");
}

// Retrieve `userid` from session
$userid = $_SESSION['userid'];

// 1. Query untuk mengambil data pengguna
$query = "SELECT name, email, foto_profile FROM user WHERE iduser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data pengguna
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// 2. Query untuk mengambil data booking terkait dengan pengguna
$query_orders = "SELECT id_booking, nama, jenis_layanan, tanggal_pembersihan 
                 FROM booking 
                 WHERE id_user = ?";
$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->bind_param("i", $userid);
$stmt_orders->execute();
$booking_data = $stmt_orders->get_result();

// Fetch all results into an array
$booking_results = $booking_data->fetch_all(MYSQLI_ASSOC);

// Close the statements
$stmt->close();
$stmt_orders->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Glitz Cleaner Cleaning Services</title>
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
    <!-- Header Start -->
    <div class="container-fluid">
        <div class="row">
            <div class=" bg-dark d-none d-lg-flex w-100 pr-5">
                <div class="col-lg-7 text-left text-white">
                    <div class="h-100 d-inline-flex align-items-center border-right border-primary py-2 px-3">
                        <i class="fa fa-envelope text-primary mr-2"></i>
                        <small>GlitzCleaner@gmail.com</small>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2 px-2">
                        <i class="fa fa-phone-alt text-primary mr-2"></i>
                        <small>+0895422855755</small>
                    </div>
                </div>
                <div class="col-lg-5 text-right">
                    <div class="d-inline-flex align-items-center pr-2">
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-5 text-primary">Glitz Cleaner</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <nav class="row navbar navbar-expand-lg bg-white navbar-light p-0">
                    <a href="" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary">Glitz Cleaner</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse"
                        data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="Cleaner.php" class="nav-item nav-link">Beranda</a>
                            <a href="Pesanan.php" class="nav-item nav-link active">Pesanan</a>
                            <a href="riwayat.php" class="nav-item nav-link">Riwayat</a>
                        </div>
                    </div>
                    <div class="profile-image">
                        <img src="<?php echo htmlspecialchars($user_data['foto_profile']); ?>" alt="" class="image">
                        <ul class="image-list">
                            <li class="list-item">
                                <a href="edit_profil.php">Edit Profil</a>
                            </li>
                            <li class="list-item">
                                <a href="index.php">Log Out</a>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <h2 style="margin-top: 70px; margin-left: 20px;">Daftar Pesanan untuk Diterima</h2>



    <?php if (!empty($booking_results)): ?>
        <table border="1">
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Service Type</th>
                <th>Cleaning Date</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($booking_results as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id_booking']) ?></td>
                    <td><?= htmlspecialchars($booking['nama']) ?></td>
                    <td><?= htmlspecialchars($booking['jenis_layanan']) ?></td>
                    <td><?= htmlspecialchars($booking['tanggal_pembersihan']) ?></td>
                    <td>
                        <form action="accept_booking.php" method="POST">
                            <input type="hidden" name="booking_id" value="<?= $booking['id_booking'] ?>">
                            <button type="submit">Terima</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p style="margin-left: 20px;">No pending bookings available for acceptance.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>

</body>

</html>
