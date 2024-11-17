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

// Pagination settings
$limit = 8; // Maksimal 8 data per halaman
$totalRowsQuery = "SELECT COUNT(*) FROM user"; // Total jumlah data di tabel user
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_row()[0]; // Jumlah total baris
$totalPages = ceil($totalRows / $limit); // Total halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini (default 1)
$offset = ($page - 1) * $limit; // Offset untuk query

// Query untuk mengambil data pengguna dengan limit dan offset
$query = "SELECT iduser, name, email, role FROM user ORDER BY iduser DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $limit); // Bind offset dan limit
$stmt->execute();
$result = $stmt->get_result();
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">

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
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #f8f9fa;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard_admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="manage_admin.php"><i class="fas fa-box"></i> Manajemen Pesanan</a>
        <a href="services.php"><i class="fas fa-concierge-bell"></i> Manajemen Layanan</a>
        <a href="customers.php"><i class="fas fa-users"></i> Manajemen Pelanggan</a>
        <a href="logout.php" class="btn btn-primary mt-3 mx-3 d-block">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="header">
            <h1>Admin Panel - Glitz Cleaner</h1>
            <p>Kelola layanan, pesanan, pengguna, dan lain-lain dengan mudah.</p>
        </div>

        <!-- Manajemen Pengguna -->
        <div class="card mt-4" id="users">
            <h3>Manajemen Pengguna</h3>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["iduser"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["role"] . "</td>
                        <td>
                            <button class='btn btn-primary' onclick='openEditModal(" . json_encode($row) . ")'>Edit</button>
                            <button class='btn btn-danger' onclick='confirmDelete(" . $row["iduser"] . ")'>Delete</button>
                        </td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada pengguna ditemukan.</p>";
            }

            // Pagination links
            echo "<div class='pagination'>";
            if ($page > 1) {
                echo "<a href='Panel_admin.php?page=" . ($page - 1) . "'>Prev</a>";
            }
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $page) {
                    echo "<a href='Panel_admin.php?page=$i' class='active'>$i</a>";
                } else {
                    echo "<a href='Panel_admin.php?page=$i'>$i</a>";
                }
            }
            if ($page < $totalPages) {
                echo "<a href='Panel_admin.php?page=" . ($page + 1) . "'>Next</a>";
            }
            echo "</div>";
            ?>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
</body>

</html>
