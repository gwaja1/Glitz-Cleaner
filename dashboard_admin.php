<?php
session_start();
include "koneksi.php"; // Koneksi ke database

// Pastikan pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['userid']) || $_SESSION['role'] != 'admin') {
    header('Location: abort_page.php');
    exit();
}

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['userid'];

// Pagination settings
$limit = 8; // Maksimal 8 data per halaman
$totalRowsQuery = "SELECT COUNT(*) AS total FROM user"; // Total jumlah data di tabel user
$totalRowsResult = $conn->query($totalRowsQuery);
$totalRows = $totalRowsResult->fetch_assoc()['total']; // Jumlah total baris
$totalPages = ceil($totalRows / $limit); // Total halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini
$page = max($page, 1); // Pastikan halaman minimal 1
$offset = ($page - 1) * $limit; // Hitung offset untuk query

// Query dengan batasan halaman
$query = "SELECT iduser, name, email, role FROM user ORDER BY iduser DESC LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

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

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination li a {
            text-decoration: none;
            color: #007bff;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .pagination li a.active {
            background-color: #007bff;
            color: #fff;
        }

        .pagination li a:hover {
            background-color: #ddd;
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
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row["iduser"] . "</td>
                            <td>" . $row["name"] . "</td>
                            <td>" . $row["email"] . "</td>
                            <td>" . $row["role"] . "</td>
                          </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data.</td></tr>";
                }
                ?>
            </table>

            <!-- Pagination -->
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li>
                        <a href="?page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</body>
</html>
