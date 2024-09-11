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