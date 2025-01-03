<?php
session_start();
include "koneksi.php"; // Koneksi ke database

// Pastikan pengguna sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['userid'];

// Query untuk mengambil data user menggunakan prepared statement
$query = $conn->prepare("SELECT name, email, foto_profile FROM user WHERE iduser = ?");
$query->bind_param("i", $id_user); // Menyisipkan id_user sebagai parameter
$query->execute();

// Mengambil hasil query
$result = $query->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user_data = $result->fetch_assoc();
} else {
    // Handle the case when no user is found
    die("User tidak ditemukan.");
}

$query->close(); // Menutup prepared statement
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
                            <a href="Tentang1.php" class="nav-item nav-link active">Tentang</a>
                            <a href="Layanan1.php" class="nav-item nav-link">Layanan</a>
                            <a href="pesan.php" class="nav-item nav-link">Pemesanan</a>
                        </div>
                    </div>
                    <div class="profile-image">
                        <img src="<?php echo htmlspecialchars($user_data['foto_profile']); ?>" alt="" class="image">
                        <ul class="image-list">
                            <li class="list-item">
                                <a href="edit_profil.php">Edit Profil</a>
                            </li>
                            <li class="list-item">
                                <a href="Logout.php">Log Out</a>
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
                    <h1 class="display-4 mb-4 mb-md-0 text-secondary text-uppercase">Tentang</h1>
                </div>
                <div class="col-md-6 text-center text-md-right">
                    <div class="d-inline-flex align-items-center">
                        <a class="btn btn-sm btn-outline-light" href="user.php">Beranda</a>
                        <i class="fas fa-angle-double-right text-light mx-2"></i>
                        <a class="btn btn-sm btn-outline-light disabled" href="Tentang1.php">Tentang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div
                        class="d-flex flex-column align-items-center justify-content-center bg-about rounded h-100 py-5 px-3">
                        <i class="fa fa-5x fa-award text-primary mb-4"></i>
                        <h1 class="display-2 text-white mb-2" data-toggle="counter-up">25</h1>
                        <h2 class="text-white m-0">Tahun Pengalaman</h2>
                    </div>
                </div>
                <div class="col-lg-7 pt-5 pb-lg-5">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Pelajari Tentang Kami</h6>
                    <h1 class="mb-4 section-title">Kami Menyediakan Layanan Pembersihan Terbaik</h1>
                    <h5 class="text-muted font-weight-normal mb-3">Rasakan kebersihan yang sesungguhnya dengan layanan
                        cleaning service terbaik kami.</h5>
                    <p>Kami tidak hanya membersihkan, tetapi juga memberikan kenyamanan dan kepuasan maksimal. Setiap
                        sudut rumah dan tempat kerja Anda akan bersinar dengan perawatan penuh perhatian dari tim
                        profesional kami. Pilihlah kualitas dan kepercayaan, pilihlah kami untuk kebersihan yang tak
                        tertandingi.</p>
                    <div class="d-flex align-items-center pt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <!-- 16:9 aspect ratio -->
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->



    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-7 pt-lg-5 pb-3">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Kenapa Memilih Layanan Kami
                    </h6>
                    <h1 class="mb-4 section-title">25 Tahun Pengalaman di Industri Cleaning Service</h1>
                    <p class="mb-4">Dengan pengalaman yang kaya dan keahlian yang teruji, kami memahami setiap kebutuhan
                        dan tantangan dalam menjaga kebersihan. Kepercayaan Anda adalah motivasi kami untuk terus
                        memberikan hasil yang sempurna. Percayakan kebersihan Anda kepada para ahli yang telah terbukti
                        selama dua setengah dekade.</p>
                    <div class="row">
                        <div class="col-sm-4">
                            <h1 class="text-secondary mb-2" data-toggle="counter-up">225</h1>
                            <h6 class="font-weight-semi-bold mb-sm-4">Cleaner Kami</h6>
                        </div>
                        <div class="col-sm-4">
                            <h1 class="text-secondary mb-2" data-togglse="counter-up">1050</h1>
                            <h6 class="font-weight-semi-bold mb-sm-4">Klien Happy</h6>
                        </div>
                        <div class="col-sm-4">
                            <h1 class="text-secondary mb-2" data-toggle="counter-up">2500</h1>
                            <h6 class="font-weight-semi-bold mb-sm-4">Projek Selesai</h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 400px;">
                    <div class="position-relative h-100 rounded overflow-hidden">
                        <img class="position-absolute w-100 h-100" src="img/feature.jpg" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->


    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row align-items-end mb-4">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">TEMUI TIM KAMI</h6>
                    <h1 class="section-title mb-3">Temui Pembersih Kami yang Sangat Berpengalaman</h1>
                </div>
                <div class="col-lg-6">
                    <h5 class="font-weight-normal text-muted mb-3">Dengan pengalaman bertahun-tahun di industri, mereka
                        tidak hanya membersihkan, tetapi juga memahami setiap detail untuk memastikan kebersihan
                        optimal. Percayakan kebersihan Anda kepada para ahli kami dan rasakan hasil yang benar-benar
                        memuaskan.</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel team-carousel position-relative">
                        <div class="team d-flex flex-column text-center rounded overflow-hidden">
                            <div class="position-relative">
                                <div class="team-img">
                                    <img class="img-fluid w-100" src="img/team-1.jpg" alt="">
                                </div>
                                <div
                                    class="team-social d-flex flex-column align-items-center justify-content-center bg-primary">
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-secondary btn-social" href="#"><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column bg-primary text-center py-4">
                                <h5 class="font-weight-bold">Full Name</h5>
                                <p class="text-white m-0">Designation</p>
                            </div>
                        </div>
                        <div class="team d-flex flex-column text-center rounded overflow-hidden">
                            <div class="position-relative">
                                <div class="team-img">
                                    <img class="img-fluid w-100" src="img/team-2.jpg" alt="">
                                </div>
                                <div
                                    class="team-social d-flex flex-column align-items-center justify-content-center bg-primary">
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-secondary btn-social" href="#"><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column bg-primary text-center py-4">
                                <h5 class="font-weight-bold">Full Name</h5>
                                <p class="text-white m-0">Designation</p>
                            </div>
                        </div>
                        <div class="team d-flex flex-column text-center rounded overflow-hidden">
                            <div class="position-relative">
                                <div class="team-img">
                                    <img class="img-fluid w-100" src="img/team-3.jpg" alt="">
                                </div>
                                <div
                                    class="team-social d-flex flex-column align-items-center justify-content-center bg-primary">
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-secondary btn-social" href="#"><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column bg-primary text-center py-4">
                                <h5 class="font-weight-bold">Full Name</h5>
                                <p class="text-white m-0">Designation</p>
                            </div>
                        </div>
                        <div class="team d-flex flex-column text-center rounded overflow-hidden">
                            <div class="position-relative">
                                <div class="team-img">
                                    <img class="img-fluid w-100" src="img/team-4.jpg" alt="">
                                </div>
                                <div
                                    class="team-social d-flex flex-column align-items-center justify-content-center bg-primary">
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-twitter"></i></a>
                                    <a class="btn btn-secondary btn-social mb-2" href="#"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a class="btn btn-secondary btn-social" href="#"><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                            <div class="d-flex flex-column bg-primary text-center py-4">
                                <h5 class="font-weight-bold">Full Name</h5>
                                <p class="text-white m-0">Designation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


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
                <h4 class="font-weight-semi-bold text-primary mb-4">Tautan Cepat</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="user.php"><i class="fa fa-angle-right mr-2"></i>Beranda</a>
                    <a class="text-white mb-2" href="tentang1.php"><i class="fa fa-angle-right mr-2"></i>Tentang</a>
                    <a class="text-white mb-2" href="Layanan1.php"><i class="fa fa-angle-right mr-2"></i>Layanan</a>
                    <a class="text-white mb-2" href="pesan.php"><i class="fa fa-angle-right mr-2"></i>Pesan</a>
                    <a class="text-white" href="history.php"><i class="fa fa-angle-right mr-2"></i>Riwayat</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-semi-bold text-primary mb-4">Buletin</h4>
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