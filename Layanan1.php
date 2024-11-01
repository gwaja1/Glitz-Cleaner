<?php
session_start();
include "koneksi.php"; // Koneksi ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Query untuk mengambil data user
$query = "SELECT name, email, foto_profile FROM user WHERE iduser = '$id_user'";
$result = $conn->query($query);

// Check if the user exists
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    // Handle the case when no user is found
    die("User tidak ditemukan.");
}

$conn->close(); // Close the connection after retrieving data
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
        .booking-container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #b38b00;
            outline: none;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #ffc600;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #b38b00;
        }

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
                            <a href="Layanan1.php" class="nav-item nav-link active">Layanan</a>
                            <a href="Keranjang.php" class="nav-item nav-link">Pemesanan</a>
                            <a href="history.php" class="nav-item nav-link">Riwayat</a>
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


    <!-- Page Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5">
        <div class="container py-5">
            <div class="row align-items-center py-4">
                <div class="col-md-6 text-center text-md-left">
                    <h1 class="display-4 mb-4 mb-md-0 text-secondary text-uppercase">Layanan</h1>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn btn-sm btn-outline-light" href="user.php">Beranda</a>
                        <i class="fas fa-angle-double-right text-light mx-2"></i>
                        <a class="btn btn-sm btn-outline-light disabled" href="Layanan1.php">Layanan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Services Start -->
    <div class="container-fluid bg-service py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Layanan</h6>
                    <h1 class="mb-4 section-title text-white">Layanan Pembersihan Luar Biasa untuk Anda</h1>
                    <p class="text-white">Kami hadir untuk menciptakan kebersihan sempurna di setiap sudut ruang
                        Anda.
                        Dengan perhatian penuh terhadap detail dan dedikasi tanpa kompromi, kami memastikan Anda
                        mendapatkan hasil terbaik. Nikmati kenyamanan dan kebersihan yang tak tertandingi—karena
                        Anda
                        layak mendapatkan yang terbaik!</p>
                </div>
                <div class="col-lg-6 pt-5 pt-lg-0">
                    <div class="owl-carousel service-carousel position-relative">
                        <div
                            class="d-flex flex-column align-items-center text-center bg-white rounded overflow-hidden pt-4">
                            <div class="icon-box bg-light text-secondary shadow mt-2 mb-4">
                                <i class="fa fa-2x fa-hotel"></i>
                            </div>
                            <h5 class="font-weight-bold mb-4 px-4">Pembersihan Rumah</h5>
                            <img src="img/blog-1.jpg" alt="">
                        </div>
                        <div
                            class="d-flex flex-column align-items-center text-center bg-white rounded overflow-hidden pt-4">
                            <div class="icon-box bg-light text-secondary shadow mt-2 mb-4">
                                <i class="fa fa-2x fa-city"></i>
                            </div>
                            <h5 class="font-weight-bold mb-4 px-4">Pembersihan Jendela</h5>
                            <img src="img/blog-3.jpg" alt="">
                        </div>
                        <div
                            class="d-flex flex-column align-items-center text-center bg-white rounded overflow-hidden pt-4">
                            <div class="icon-box bg-light text-secondary shadow mt-2 mb-4">
                                <i class="fa fa-2x fa-spa"></i>
                            </div>
                            <h5 class="font-weight-bold mb-4 px-4">Pembersihan Karpet</h5>
                            <img src="img/blog-2.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Contact Info Start -->
    <div class="container-fluid pb-5 contact-info">
        <div class="row">
            <div class="col-lg-4 p-0">
                <div
                    class="contact-info-item d-flex align-items-center justify-content-center bg-primary text-white py-4 py-lg-0">
                    <i class="fa fa-3x fa-map-marker-alt text-secondary mr-4"></i>
                    <div class="">
                        <h5 class="mb-2">Kantor Kami</h5>
                        <p class="m-0">Jl.Bareng Raya IIN/538</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-0">
                <div
                    class="contact-info-item d-flex align-items-center justify-content-center bg-secondary text-white py-4 py-lg-0">
                    <i class="fa fa-3x fa-envelope-open text-primary mr-4"></i>
                    <div class="">
                        <h5 class="mb-2">Email Kami</h5>
                        <p class="m-0">GlitzCleaner@gmail.com</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 p-0">
                <div
                    class="contact-info-item d-flex align-items-center justify-content-center bg-primary text-white py-4 py-lg-0">
                    <i class="fa fa-3x fa-phone-alt text-secondary mr-4"></i>
                    <div class="">
                        <h5 class="mb-2">Nomor Kami</h5>
                        <p class="m-0">+6289422855755</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Info End -->



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