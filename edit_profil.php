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
$query = "SELECT * FROM user WHERE iduser = '$id_user'";
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
                            <a href="history.php" class="nav-item nav-link">History</a>
                        </div>
                </nav>
            </div>
        </div>

    </div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    <h3 class="text-center mb-4">Edit Profile</h3>
                    <form action="proses_edit_profile.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your full name"
                                value="<?php echo htmlspecialchars($user_data['name']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email"
                                value="<?php echo htmlspecialchars($user_data['email']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Enter a new password">
                            <small class="form-text text-muted">Leave empty if you don't want to change the
                                password.</small>
                        </div>

                        <!-- Bagian form upload gambar -->
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture</label>
                            <input type="file" class="form-control-file image-preview" id="image" name="profile_picture"
                                onchange="previewImageProfile()">

                            <?php if (!empty($user_data['foto_profile'])): ?>
                                <img src="<?php echo htmlspecialchars($user_data['foto_profile']); ?>" alt="Profile Picture"
                                    width="100" id="image-preview" class="image-preview user-image">
                            <?php else: ?>
                                <p>No profile picture uploaded.</p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImageProfile() {
            const fileInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');

            // Clear any previous preview
            imagePreview.src = '';

            // Check if a file is selected
            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    // Set the preview image source to the selected file
                    imagePreview.src = e.target.result;
                };

                // Read the selected file as a Data URL
                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Optionally reset the preview if no file is selected
                imagePreview.src = '';
            }
        }

    </script>
</body>

</html>