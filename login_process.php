<?php
// Include the database connection file
include "koneksi.php";

// Start the session
session_start();

// Check if form data is set
if (isset($_POST["email"]) && isset($_POST["password"])) {
    // Receive data from the login form
    $email = $_POST["email"];
    $pass = $_POST["password"];

    // Query to find the user by email using prepared statementsa
    $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email); // 's' indicates the parameter is a string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user was found
    if ($user = $result->fetch_assoc()) {
        // Verify the password with the hashed password in the database
        if (password_verify($pass, $user['password'])) {
            // If the password matches, login is successful
            $_SESSION['userid'] = $user['iduser']; // Store user ID in session
            $_SESSION['uname'] = $user['name'];    // Store user name in session
            $_SESSION['email'] = $user['email'];   // Store user email in session
            $_SESSION['role'] = $user['role'];     // Store user role in session

            // Redirect based on the user's role
            if ($user['role'] == 'admin') {
                header('Location: dashboard_admin.php');
                exit();
            } elseif ($user['role'] == 'user') {
                header('Location: user.php');
                exit();
            } elseif ($user['role'] == 'cleaner') {
                header('Location: cleaner.php');
                exit();
            } else {
                // If the role is not recognized
                echo "Role tidak valid!";
            }
        } else {
            // If the password does not match
            echo "Password salah!";
        }
    } else {
        // If the email was not found
        echo "Email tidak terdaftar!";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Silakan masukkan email dan password!";
}
?>
