<?php
session_start(); // Memulai session

include "koneksi.php"; // Koneksi ke database

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Pastikan id_user disimpan di session
if (!$id_user) {
    die("User belum login atau session tidak valid.");
}

// Ambil id_booking dari session
$id_booking = $_SESSION['id_booking']; // Ambil id_booking dari session

// Query untuk mendapatkan data booking terkait pengguna
$query = "SELECT * FROM booking WHERE id_booking = '$id_booking' AND id_user = '$id_user'"; // Pastikan kolom id_booking dan id_user ada di tabel booking

// Jalankan query
$hasil = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if ($hasil) {
    if (mysqli_num_rows($hasil) > 0) {
        // Ambil data booking pertama
        $booking = mysqli_fetch_assoc($hasil);
    } else {
        $booking = null; // Tidak ada data booking untuk pengguna ini
    }
} else {
    // Jika query gagal dijalankan
    echo "Error: " . mysqli_error($conn);
    $booking = null;
}

// Tutup koneksi
mysqli_close($conn);
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
                            <a href="Keranjang.php" class="nav-item nav-link">Pemesanan</a>
                            <a href="history.html" class="nav-item nav-link">History</a>
                        </div>
                    </div>
                    <div class="profile-image">
                        <img src="img/team-1.jpg" alt="" class="image">
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


    <!-- Payment Section Start -->
    <div class="container-fluid pt-5">
        <div class="container payment-section">
            <div class="text-center mb-5">
                <h2 class="section-title px-5"><span class="px-2">Pembayaran</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Detail Pembayaran</h4>
                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Nama Lengkap</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['nama'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="email"
                                        value="<?php echo $booking['email'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>No Telepon</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['no_telpon'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Alamat</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['alamat'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Jenis Layanan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['jenis_layanan'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tanggal Pembersihan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['tanggal_pembersihan'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Waktu Pembersihan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['waktu_pembersihan'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Catatan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['catatan'] ?? ''; ?>" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Ringkasan Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p>Subtotal</p>
                                <p>Rp. 1.000.000</p>
                            </div>
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="font-weight-medium">Total</h6>
                                <h6 class="font-weight-medium">Rp. 1.000.000</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Bayar
                                Sekarang</button>
                            <form action="simpan_pesanan.php" method="post">
                                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                                <input type="hidden" name="id_booking"
                                    value="<?php echo $booking['id_booking'] ?? ''; ?>">
                                <input type="hidden" name="status" value="belum bayar">
                                <!-- Asumsikan ada id_booking -->
                                <input type="hidden" name="harga" value="1000000"> <!-- Ganti sesuai logika harga -->

                                <button type="submit"
                                    class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Simpan
                                    Dulu</button>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white mt-5 py-5 px-sm-3 px-md-5">
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
                    kebersihan Anda. Dengan tim profesional dan berpengalaman, kami siap membantu Anda menjaga rumah
                    atau
                    kantor Anda tetap bersih dan nyaman..</p>
                <div class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control border-0" style="padding: 25px;"
                            placeholder="Your Email">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Sign Up</button>
                        </div>
                    </div>
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