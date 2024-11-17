<?php
// Include the Midtrans PHP SDK
require_once 'path/to/midtrans-php/Midtrans.php'; // Adjust the path to the Midtrans SDK

// Set your server key
\Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
\Midtrans\Config::$clientKey = 'YOUR_CLIENT_KEY';
\Midtrans\Config::$isProduction = false; // Set to true in production

// Read the notification
$notif = new \Midtrans\Notification();

// Retrieve transaction status
$transaction_status = $notif->transaction_status;
$order_id = $notif->order_id; // The order ID from Midtrans
$payment_type = $notif->payment_type;
$transaction_id = $notif->transaction_id; // The transaction ID from Midtrans

// Process the notification based on status
if ($transaction_status == 'capture') {
    // Payment successfully captured
    // Update the order status in the database to 'paid'
    $query = "UPDATE booking SET status = 'paid' WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
} elseif ($transaction_status == 'pending') {
    // Payment pending
    // You can handle pending payments as necessary
} elseif ($transaction_status == 'deny') {
    // Payment denied
    // Handle denied payments
    $query = "UPDATE booking SET status = 'denied' WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
} elseif ($transaction_status == 'cancel') {
    // Payment canceled
    // Handle canceled payments
    $query = "UPDATE booking SET status = 'canceled' WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
}

// Respond with a 200 OK to acknowledge receipt of the notification
http_response_code(200);
?>
