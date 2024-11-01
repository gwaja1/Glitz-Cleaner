<?php
session_start();

// Check if booking ID is sent via POST
if (isset($_POST['id_booking'])) {
    // Set the booking ID in session
    $_SESSION['id_booking'] = $_POST['id_booking'];

    // Redirect to Pembayaran.php
    header("Location: Pembayaran.php");
    exit();
} else {
    // If no booking ID, redirect back to the history page with an error message
    header("Location: history.php?error=missing_id_booking");
    exit();
}
?>