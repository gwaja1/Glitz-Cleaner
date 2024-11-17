// payment_token.php
<?php
include 'koneksi.php';

// Assuming you have data like the total price and booking information
$total_amount = 1000000; // replace with dynamic value
$order_id = uniqid('order_'); // generate a unique order ID for the transaction

// Midtrans API configuration
$server_key = 'YOUR_SERVER_KEY'; // Replace with your Midtrans server key
$client_key = 'YOUR_CLIENT_KEY'; // Replace with your Midtrans client key

// Prepare request data for the Midtrans API
$data = [
    'payment_type' => 'credit_card', // Or any other payment type
    'transaction_details' => [
        'order_id' => $order_id,
        'gross_amount' => $total_amount
    ]
];

// Set cURL options
$ch = curl_init('https://api.sandbox.midtrans.com/v2/charge');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($server_key . ':')
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Get the response
$response = curl_exec($ch);
curl_close($ch);

// Decode the response to extract the token
$response_data = json_decode($response, true);
if (isset($response_data['token'])) {
    echo json_encode(['transaction_token' => $response_data['token']]);
} else {
    echo json_encode(['error' => 'Unable to generate transaction token']);
}
?>
