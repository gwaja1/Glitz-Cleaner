<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pemesanan Jasa Cleaning Service</title>

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
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="Logo.png" type="image/png">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/Admin.css" rel="stylesheet">

</head>

<body>

    <div class="sidebar">
        <a href="#dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#orders"><i class="fas fa-box"></i> Manajemen Pesanan</a>
        <a href="#services"><i class="fas fa-concierge-bell"></i> Manajemen Layanan</a>
        <a href="#customers"><i class="fas fa-users"></i> Manajemen Pelanggan</a>
        <a href="#reports"><i class="fas fa-chart-line"></i> Laporan</a>
        <a href="Manage_user.php"><i class="fas fa-user"></i> Manajemen Pengguna</a> <!-- Tambahkan ini -->
        <a href="#settings"><i class="fas fa-cogs"></i> Pengaturan</a>
        <a href="index.php" class="btn btn-primary mr-3 d-none d-lg-block">Logout</a>
    </div>


    <div class="col-lg-9">
        <div class="content">
            <div class="header">
                <h1>Admin Panel - Glitz Cleaner</h1>
            </div>

            <div class="card" id="dashboard">
                <h3>Dashboard</h3>
                <p>Selamat datang di panel admin. Di sini Anda dapat mengelola semua aspek layanan cleaning service
                    Anda.</p>

                <!-- Tombol Add User -->
                <a href="add_user.php" class="btn btn-primary" style="margin-top: 20px;">Add User</a>
            </div>


            <!-- Manajemen Pengguna -->
            <div class="card" id="users">
                <h3>Manajemen Pengguna</h3>

                <?php
                // Koneksi ke database
                include 'koneksi.php'; // Pastikan jalur ini benar
                
                // Query untuk mengambil data pengguna dari tabel user
                $sql = "SELECT iduser, name, email, role FROM user";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>";
                    // Output data dari setiap baris
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
            <td>" . $row["iduser"] . "</td>
            <td>" . $row["name"] . "</td>
            <td>" . $row["email"] . "</td>
            <td>" . $row["role"] . "</td>
            <td>
                <a href='edit_user.php?id=" . $row["iduser"] . "' class='btn btn-warning'>Edit</a>
                <a href='delete_user.php?id=" . $row["iduser"] . "' class='btn btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pengguna ini?\")'>Delete</a>
            </td>
          </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>

</html>