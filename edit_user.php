<?php
// edit_user.php

include 'koneksi.php'; // Include the database connection

// Check if the user ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to get user data
    $sql = "SELECT * FROM user WHERE iduser = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Display the form with user data
        ?>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="iduser" value="<?php echo $row['iduser']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $row['email']; ?>"><br>
            <label for="role">Role:</label>
            <input type="text" name="role" value="<?php echo $row['role']; ?>"><br>
            <label for="password">New Password (leave empty to keep current):</label>
            <input type="password" name="password" placeholder="Enter new password"><br>
            <button type="submit">Update</button>
        </form>
        <?php
    } else {
        echo "User not found.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* CSS untuk form edit user */

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
        }

        form label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            color: #555;
            transition: border-color 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
        }

        form button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: #0056b3;
        }

        form button[type="submit"]:focus {
            outline: none;
        }

        form input[type="hidden"] {
            display: none;
        }

        form input::placeholder {
            color: #aaa;
            font-style: italic;
        }

        @media (max-width: 600px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>

<body>

</body>

</html>