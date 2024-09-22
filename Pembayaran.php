<?php
session_start(); // Memulai session

include "koneksi.php"; // Koneksi ke database

// Ambil id_user dari session
$id_user = $_SESSION['id_user'];

// Pastikan id_user disimpan di session
if (!$id_user) {
    die("User belum login atau session tidak valid.");
}

// Query untuk mendapatkan data booking terkait pengguna
$query = "SELECT * FROM booking WHERE id_user = '$id_user'"; // Pastikan kolom id_user ada di tabel booking

// Jalankan query
$hasil = mysqli_query($conn, $query);

// Periksa apakah query berhasil dijalankan
if ($hasil) {
    if (mysqli_num_rows($hasil) > 0) {
        // Ambil data booking pertama (atau sesuaikan jika ada lebih dari satu)
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
    <link rel="icon" href="Logo.png" type="image/png">
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
                            <a href="Tentang1.html" class="nav-item nav-link">Tentang</a>
                            <a href="Layanan1.html" class="nav-item nav-link">Layanan</a>
                            <a href="Keranjang.php" class="nav-item nav-link">Pemesanan</a>
                            <a href="contact1.html" class="nav-item nav-link">Contact</a>
                        </div>
                        <a href="index.php" class="btn btn-primary mr-3 d-none d-lg-block">Logout</a>
                    </div>
            </div>
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
                            <div class="d-flex justify-content-between">
                                <p>Biaya Pengiriman</p>
                                <p>Rp. 50.000</p>
                            </div>
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="font-weight-medium">Total</h6>
                                <h6 class="font-weight-medium">Rp. 1.050.000</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Lanjutkan
                                Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Payment Section End -->


</body>

</html>