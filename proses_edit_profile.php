<?php
session_start();
include "koneksi.php"; // Include database connection

// Check if user is logged in
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Fetch logged-in user ID from session
$user_id = $_SESSION['id_user'];

// Retrieve user's role from the database
$query_role = "SELECT role FROM user WHERE iduser = ?";
$stmt_role = $conn->prepare($query_role);
$stmt_role->bind_param("i", $user_id);
$stmt_role->execute();
$stmt_role->bind_result($role);
$stmt_role->fetch();
$stmt_role->close();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_picture = $_FILES['profile_picture'];

    // Validate form data
    if (empty($name) || empty($email)) {
        echo "Name and email are required!";
        exit();
    }

    // Handle profile picture upload
    $target_file = '';
    if (!empty($profile_picture['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_picture["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size (max 2MB)
        if ($profile_picture["size"] > 2000000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        // Allow certain file formats
        $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit();
        }

        // Move uploaded file
        if (!move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    }

    // Hash password if not empty
    $hashed_password = '';
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Start building update query
    $query = "UPDATE user SET name = ?, email = ?";
    $params = [$name, $email];
    $types = "ss"; // for name and email

    // Add password update if provided
    if (!empty($hashed_password)) {
        $query .= ", password = ?";
        $params[] = $hashed_password;
        $types .= "s";
    }

    // Add profile picture update if a new one was uploaded
    if (!empty($target_file)) {
        $query .= ", foto_profile = ?";
        $params[] = $target_file;
        $types .= "s";
    }

    // Add the WHERE clause to target the specific user
    $query .= " WHERE iduser = ?";
    $params[] = $user_id;
    $types .= "i";

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bind_param($types, ...$params);

    // Execute and check for errors
    if ($stmt->execute()) {
        // Redirect based on user's role
        if ($role === 'user') {
            header("Location: user.php?msg=Profile updated successfully!");
        } elseif ($role === 'cleaner') {
            header("Location: cleaner.php?msg=Profile updated successfully!");
        }
        exit();
    } else {
        echo "Error updating profile: " . $stmt->error;
    }
}
?>