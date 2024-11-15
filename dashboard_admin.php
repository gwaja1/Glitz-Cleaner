<?php
session_start();
include "koneksi.php"; // Koneksi ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['userid'];

// Query untuk mengambil data pengguna terbaru berdasarkan ID terbesar
$query = "SELECT name, email, foto_profile, role FROM user ORDER BY iduser DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Ambil data pengguna
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();

    // Cek jika role pengguna adalah admin
    if ($user_data['role'] !== 'admin') {
        // Jika bukan admin, tampilkan halaman error (abort)
        include 'abort_page.php';
        exit();
    }
} else {
    echo "Data pengguna tidak ditemukan.";
    exit();
}

// Query untuk menghitung jumlah total pengguna, user, dan cleaner
$query_count = "SELECT 
                    COUNT(*) AS total_users,
                    (SELECT COUNT(*) FROM user WHERE role = 'user') AS user_count,
                    (SELECT COUNT(*) FROM user WHERE role = 'cleaner') AS cleaner_count
                FROM user";
$count_result = $conn->query($query_count);

if ($count_result && $count_row = $count_result->fetch_assoc()) {
    $total_users = $count_row['total_users'];
    $user_count = $count_row['user_count'];
    $cleaner_count = $count_row['cleaner_count'];
} else {
    $total_users = 0;
    $user_count = 0;
    $cleaner_count = 0;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pemesanan Jasa Cleaning Service</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
    <link rel="icon" href="Img/Logo.png" type="image/png">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #ffffff;
            display: block;
        }

        .sidebar a:hover {
            background-color: #007bff;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .content .header {
            padding: 20px;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h5 {
            font-size: 20px;
            color: #343a40;
        }

        .count-number {
            font-size: 36px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard_admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="manage_admin.php"><i class="fas fa-box"></i> Manajemen Pesanan</a>
        <a href="#services"><i class="fas fa-concierge-bell"></i> Manajemen Layanan</a>
        <a href="Panel_admin.php"><i class="fas fa-user"></i> Manajemen Pengguna</a>
        <a href="index.php" class="btn btn-primary mt-3 mx-3 d-block">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="header">
            <h1>Admin Panel - Glitz Cleaner</h1>
            <p>Kelola layanan, pesanan, pengguna, dan lain-lain dengan mudah.</p>
        </div>

        <!-- Cards showing counts of users and cleaners -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h5>Total Pengguna</h5>
                    <p class="count-number"><?php echo $total_users; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h5>Total User</h5>
                    <p class="count-number"><?php echo $user_count; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <h5>Total Cleaner</h5>
                    <p class="count-number"><?php echo $cleaner_count; ?></p>
                </div>
            </div>
        </div>

        <!-- Manajemen Pengguna -->
        <div class="card mt-4" id="users">
            <h3>Dashboard Admin</h3>

            <?php
            // Koneksi ke database
            include 'koneksi.php';

            // Query untuk mengambil data pengguna dari tabel user
            $sql = "SELECT iduser, name, email, role FROM user";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["iduser"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["role"] . "</td>
                      </tr>";
                }
            } else {
                echo "<p>Tidak ada pengguna ditemukan.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
