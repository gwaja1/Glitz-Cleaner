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

    <!-- Customized Bootstrap Stylesheet -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
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
            background-color: #ecf0f1;
            padding: 20px;
            width: 30%;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            font-size: 18px;
            color: #2980b9;
        }


        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #f8f9fa;
        }

        .btn-warning {
            color: #fff;
        }

        .btn-danger {
            color: #fff;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            background-color: #fff;
        }

        .main-area {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .main-area h2 {
            margin-bottom: 10px;
        }

        .dashboard-overview {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard_admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#orders"><i class="fas fa-box"></i> Manajemen Pesanan</a>
        <a href="#services"><i class="fas fa-concierge-bell"></i> Manajemen Layanan</a>
        <a href="#customers"><i class="fas fa-users"></i> Manajemen Pelanggan</a>
        <a href="#reports"><i class="fas fa-chart-line"></i> Laporan</a>
        <a href="Panel_admin.php"><i class="fas fa-user"></i> Manajemen Pengguna</a>
        <a href="#settings"><i class="fas fa-cogs"></i> Pengaturan</a>
        <a href="index.php" class="btn btn-primary mt-3 mx-3 d-block">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="header">
            <h1>Admin Panel - Glitz Cleaner</h1>
            <p>Kelola layanan, pesanan, pengguna, dan lain-lain dengan mudah.</p>
        </div>

        <div class="main-area mb-4" id="dashboard">
            <h3>Dashboard</h3>
            <p>Selamat datang di panel admin. Di sini Anda dapat mengelola semua aspek layanan cleaning service Anda.
            </p>
        </div>

        <!-- Dashboard Overview -->
        <section class="dashboard-overview">
            <div class="card">
                <h3>Users</h3>
                <p>500 Registered Users</p>
            </div>
            <div class="card">
                <h3>Orders</h3>
                <p>120 Orders Today</p>
            </div>
            <div class="card">
                <h3>Earnings</h3>
                <p>$5,000 Today</p>
            </div>
        </section>

        <!-- Main Content Area -->
        <section class="main-area">
            <h2>Recent Activity</h2>
            <p>This is the main content area where you can manage users, view orders, and update settings.</p>
        </section>

    </div>
    </div>

    </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>