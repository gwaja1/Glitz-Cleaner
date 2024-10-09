<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Glitz Cleaner</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/setyle.css" rel="stylesheet">
    <link rel="icon" href="Img/Logo.png" type="image/png">
</head>

<body>
    <!-- Header Start -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 bg-secondary d-none d-lg-block">
                <a href="index.html"
                    class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
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
                            <a class="text-primary p-2" href="#">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-primary p-2" href="#">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-primary p-2" href="#">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a class="text-primary p-2" href="#">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <nav class="row navbar navbar-expand-lg bg-white navbar-light p-0">
                    <a href="index.html" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary">Glitz Cleaner</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link">Beranda</a>
                            <a href="Tentang1.html" class="nav-item nav-link">Tentang</a>
                            <a href="Layanan1.html" class="nav-item nav-link">Layanan</a>
                            <a href="Project.html" class="nav-item nav-link">Projek</a>
                            <a href="contact.html" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </nav>
    </div>
    </div>
    </div>
    <!-- Header End -->

    <!-- Form Start -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="form-container bg-white p-4 shadow">
                    <div class="logo-container">
                        <img src="Img/Logo1.png" class="logo-small">
                    </div>
                    <div class="form-wrapper">
                        <form id="register-form" class="form" action="register_process.php" method="post">
                            <h2 class="text-center">Create Account</h2>
                            <input type="text" class="form-control mb-3" placeholder="Username" name="name" required>
                            <input type="email" class="form-control mb-3" placeholder="Email" name="email" required>
                            <input type="password" class="form-control mb-3" placeholder="Password" name="password"
                                required>
                            <input type="submit" class="btn btn-primary btn-block" value="Register"
                                name="regis"></input>
                            <p class="text-center mt-3">Already have an account? <a href="Login.php">Login</span></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Form End -->



    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        function toggleForm(formType) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginToggle = document.getElementById('login-toggle');
            const registerToggle = document.getElementById('register-toggle');

            if (formType === 'login') {
                loginForm.classList.add('active-form');
                registerForm.classList.remove('active-form');
                loginToggle.classList.add('active');
                registerToggle.classList.remove('active');
                registerToggle.classList.add('btn-outline-primary');
                loginToggle.classList.remove('btn-outline-primary');
            } else {
                registerForm.classList.add('active-form');
                loginForm.classList.remove('active-form');
                registerToggle.classList.add('active');
                loginToggle.classList.remove('active');
                loginToggle.classList.add('btn-outline-primary');
                registerToggle.classList.remove('btn-outline-primary');
            }
        }
    </script>
</body>

</html>