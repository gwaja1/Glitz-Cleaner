<?php
// update_user.php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['iduser'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if (!empty($password)) {
        // If password is provided, hash the password and update it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE user SET name=?, email=?, role=?, password=? WHERE iduser=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $role, $hashed_password, $id);
    } else {
        // If password is not provided, update other fields only
        $sql = "UPDATE user SET name=?, email=?, role=? WHERE iduser=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $role, $id);
    }

    var_dump($_POST['password']);

    if ($stmt->execute()) {
        echo "User updated successfully.";
    } else {
        echo "Error updating user.";
    }

    $stmt->close();
}

$conn->close();
header("Location: Panel_admin.php"); // Redirect back to users management
?>