<?php
session_start(); // Memulai session
include "koneksi.php"; // Koneksi ke database

// Cek apakah user sudah login dan memiliki `userid`
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid']; // Mengambil userid dari session

    // Memastikan userid dalam session valid dengan memeriksa database
    $stmt = $conn->prepare("SELECT iduser FROM user WHERE iduser = ?");
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        die("User tidak valid.");
    }
} else {
    die("User belum login.");
}

// Mengambil nilai dari POST untuk id_booking dan status
$id_booking = $_POST['id_booking'] ?? null;
$status = $_POST['status'] ?? 'default_status'; // Set default value if not provided

// Pastikan id_booking telah ditentukan dan valid
if (!$id_booking || !is_numeric($id_booking)) {
    die("ID booking tidak valid.");
}

// Mengambil data dari tabel `booking` berdasarkan id_booking
$stmt = $conn->prepare("SELECT jenis_ruangan, ukuran_ruangan, jenis_layanan, tanggal_pembersihan, waktu_pembersihan FROM booking WHERE id_booking = ?");
$stmt->bind_param("i", $id_booking);
$stmt->execute();
$booking_result = $stmt->get_result();

if ($booking_result->num_rows > 0) {
    $booking_data = $booking_result->fetch_assoc();
    $jenis_ruangan = $booking_data['jenis_ruangan'];
    $ukuran_ruangan = $booking_data['ukuran_ruangan'];
    $jenis_layanan = $booking_data['jenis_layanan'];
    $tanggal_pembersihan = $booking_data['tanggal_pembersihan'];
    $waktu_pembersihan = $booking_data['waktu_pembersihan'];
} else {
    die("Booking tidak ditemukan.");
}

// Tentukan harga secara langsung jika tidak diambil dari `booking`
$harga = 1000000; // Contoh: harga tetap

// Cek apakah data sudah ada di tabel history_order untuk userid dan id_booking ini
$stmt = $conn->prepare("SELECT * FROM history_order WHERE id_user = ? AND id_booking = ?");
$stmt->bind_param("ii", $userid, $id_booking);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: history.php"); // Redirect jika data sudah ada
    exit();
}

// Query untuk menyimpan data ke tabel history_order
$stmt = $conn->prepare("INSERT INTO history_order (id_user, id_booking, nama, jenis_layanan, status, harga) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iisssi", $userid, $id_booking, $jenis_ruangan, $jenis_layanan, $status, $harga);

if ($stmt->execute()) {
    header("Location: history.php"); // Redirect ke halaman history setelah sukses
    exit();
} else {
    echo "Error: " . $stmt->error;
}
$query->close(); // Menutup prepared statement untuk user
$conn->close(); // Menutup koneksi setelah mengambil data
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

        .submit-btn {
            width: 100%;
            padding: 7px 15px;
            background-color: #ffc600;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        .profile-image .image {
    width: 50px;
    height: 50px;
    margin: 0 30px 0 0;
    border-radius: 50%;
    object-fit: cover; /* Menjaga gambar tidak gepeng */
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
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="user.php" class="nav-item nav-link">Beranda</a>
                            <a href="Tentang1.php" class="nav-item nav-link">Tentang</a>
                            <a href="Layanan1.php" class="nav-item nav-link">Layanan</a>
                            <a href="pesan.php" class="nav-item nav-link">Pemesanan</a>
                            <a href="history.php" class="nav-item nav-link active">Riwayat</a>
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
    <!-- Header End -->


    <body>
        <!-- Riwayat Pesanan Start -->
        <div class="container mt-5" style="margin-bottom: 10rem;">
            <h2>Riwayat Pesanan Anda</h2>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No. Pesanan</th>
                        <th>Jenis Layanan</th>
                        <th>Tanggal Pembersihan</th> <!-- Updated to match the field -->
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display data if query results exist
                    if ($result_booking->num_rows > 0) {
                        while ($row = $result_booking->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td># " . $row['id_booking'] . "</td>";
                            echo "<td>" . $row['jenis_layanan'] . "</td>";
                            echo "<td>" . $row['tanggal_pembersihan'] . "</td>";
                            echo "<td><span class='badge badge-" . strtolower($row['status']) . "'>" . $row['status'] . "</span></td>";
                            echo "<td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>";
                            echo "<td>
                <form action='process_booking.php' method='post'>
                    <input type='hidden' name='id_booking' value='" . $row['id_booking'] . "'>
                    <button type='submit' class='submit-btn'>Bayar</button>
                </form>
              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada riwayat pesanan.</td></tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <!-- Riwayat Pesanan End -->

        <!-- Footer Start -->
        <footer>
            <div class="container-fluid bg-dark text-white py-5 px-sm-3 px-md-5" style="margin-top:20rem;">
                <div class="row pt-5">
                    <div class="col-lg-3 col-md-6 mb-5">
                        <a href="index.html" class="navbar-brand">
                            <h1 class="m-0 mt-n3 display-5 text-primary">Glitz Cleaner</h1>
                        </a>
                        <p>Bersih, Rapi, dan Nyaman, Hanya untuk Anda!
                        </p>
                        <h5 class="font-weight-semi-bold text-white mb-2">Buka:</h5>
                        <p class="mb-1">Senin – Sabtu, 8pagi – 6sore</p>
                        <p class="mb-0">: Tutup</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-5">
                        <h4 class="font-weight-semi-bold text-primary mb-4">Get In Touch</h4>
                        <p><i class="fa fa-map-marker-alt text-primary mr-2"></i>Jl Bareng Raya IIN/538</p>
                        <p><i class="fa fa-phone-alt text-primary mr-2"></i>+62895422855755</p>
                        <p><i class="fa fa-envelope text-primary mr-2"></i>GlitzCleaner@gmail.com</p>
                        <div class="d-flex justify-content-start mt-4">
                            <a class="btn btn-light btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-light btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-light btn-social" href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-5">
                        <h4 class="font-weight-semi-bold text-primary mb-4">Quick Links</h4>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>About Us</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Services</a>
                            <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Our Projects</a>
                            <a class="text-white" href="#"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-5">
                        <h4 class="font-weight-semi-bold text-primary mb-4">Newsletter</h4>
                        <p>Kami senang dapat memperkenalkan layanan pembersihan kami yang dirancang untuk memenuhi semua
                            kebutuhan
                            kebersihan Anda. Dengan tim profesional dan berpengalaman, kami siap membantu Anda menjaga
                            rumah
                            atau
                            kantor Anda tetap bersih dan nyaman..</p>
                    </div>
                </div>
            </div>
            </div>
            <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5"
                style="border-color: #3E3E4E !important;">
                <div class="row">
                    <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                        <p class="m-0 text-white">&copy; <a href="#">Copyright</a>. GlitzCleaner</p>
                    </div>
                    <div class="col-lg-6 text-center text-md-right">
                        <ul class="nav d-inline-flex">
                            <li class="nav-item">
                                <a class="nav-link text-white py-0" href="#">Privacy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-0" href="#">Terms</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-0" href="#">FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white py-0" href="#">Help</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary px-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/isotope/isotope.pkgd.min.js"></script>
        <script src="lib/lightbox/js/lightbox.min.js"></script>

        <!-- Contact Javascript File -->
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

</html>