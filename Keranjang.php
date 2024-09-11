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

        // Koneksi ke database MariaDB
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

        // Query untuk memasukkan data ke tabel
        $sql = "INSERT INTO booking (name, email, phone, address, service_type, date, time, notes)
        VALUES ('$name', '$email', '$phone', '$address', '$service_type', '$date', '$time', '$notes')";

        if ($conn->query($sql) === TRUE) {
            echo "Pemesanan berhasil dilakukan!";
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }

        // Tutup koneksi
        $conn->close();
    } else {
        echo "Semua field harus diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Jasa Cleaning Service</title>

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="Logo.png" type="image/png">

    <style>
        /* Tambahkan gaya khusus untuk formulir di sini */
        .booking-container {
            padding: 40px;
            background-color: #d2d2d2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin: 50px auto;
            max-width: 600px;
        }

        .submit-btn {
            background-color: #007acc;
            border: none;
            padding: 10px 20px;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.3s;
        }

        .submit-btn:hover {
            background-color: #005f99;
            transform: scale(1.05);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #000000;
            border-radius: 5px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .booking-container h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }
    </style>
</head>

<body>
    <!-- Header Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 bg-secondary d-none d-lg-block">
                <a href="" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-5 text-primary">Glitz Cleaner</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <div class="row bg-dark d-none d-lg-flex">
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
                <nav class="navbar navbar-expand-lg bg-white navbar-light p-0">
                    <a href="" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary">Glitz Cleaner</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="user.php" class="nav-item nav-link">Beranda</a>
                            <a href="Tentang1.html" class="nav-item nav-link">Tentang</a>
                            <a href="Layanan1.html" class="nav-item nav-link">Layanan</a>
                            <a href="Keranjang.html" class="nav-item nav-link active">Pemesanan</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="blog.html" class="dropdown-item">Latest Blog</a>
                                    <a href="single.html" class="dropdown-item">Blog Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Booking Form Start -->
    <div class="container">
        <div class="booking-container">
            <h2>Pemesanan Jasa Cleaning Service</h2>
            <form action="submit_booking.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="no_telpon">Nomor Telepon:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="jenis_layanan">Jenis Layanan:</label>
                    <select id="service-type" name="service_type" required>
                        <option value="basic_cleaning">Pembersihan Dasar</option>
                        <option value="deep_cleaning">Pembersihan Menyeluruh</option>
                        <option value="move_in_out_cleaning">Pembersihan Pindahan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_pembersihan">Tanggal Pembersihan:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="waktu_pembersihan">Waktu Pembersihan:</label>
                    <input type="time" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="catatan">Catatan Tambahan:</label>
                    <textarea id="notes" name="notes" rows="4"></textarea>
                </div>
                <button type="submit" class="submit-btn">Pesan Sekarang</button>
            </form>
        </div>
    </div>
    <!-- Booking Form End -->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
</body>

</html>