<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Glitz Cleaner</title>

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link href="css/setyle.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="form-container bg-white p-4 shadow">
                    <div class="logo-container">
                        <img src="Img/Logo1.png" class="logo-small">
                    </div>
                    <?php
                    session_start();
                    if (isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }
                    ?>
                    <form id="login-form" class="form" action="login_process.php" method="post">
                        <h2 class="text-center">Login</h2>
                        <input type="email" class="form-control mb-3" placeholder="Email" name="email" required>
                        <input type="password" class="form-control mb-3" placeholder="Password" name="password" required>
                        <input type="submit" class="btn btn-primary btn-block" value="Login">
                        <p class="text-center mt-3">Don't have an account? <a href="regis.php">Register</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
