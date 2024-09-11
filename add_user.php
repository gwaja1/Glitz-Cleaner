<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password

    // Query untuk menambahkan pengguna baru
    $sql = "INSERT INTO user (name, email, role, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $role, $password);

    if ($stmt->execute()) {
        echo "User berhasil ditambahkan.";
        header("Location: Panel_admin.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Tambah Pengguna Baru</h2>
        <form method="POST" action="">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
        </form>
    </div>
</body>

</html>