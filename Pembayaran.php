<?php

namespace Midtrans;

use Exception;

/**
 * Send request to Midtrans API
 * Better don't use this class directly, please use CoreApi, Snap, and Transaction instead
 */

class ApiRequestor
{

    /**
     * Send GET request
     *
     * @param string $url
     * @param string $server_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function get($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, 'GET');
    }

    /**
     * Send POST request
     *
     * @param string $url
     * @param string $server_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function post($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, 'POST');
    }

    /**
     * Send PATCH request
     *
     * @param string $url
     * @param string $server_key
     * @param mixed[] $data_hash
     * @return mixed
     * @throws Exception
     */
    public static function patch($url, $server_key, $data_hash)
    {
        return self::remoteCall($url, $server_key, $data_hash, 'PATCH');
    }

    /**
     * Actually send request to API server
     *
     * @param string $url
     * @param string $server_key
     * @param mixed[] $data_hash
     * @param bool $post
     * @return mixed
     * @throws Exception
     */
    public static function remoteCall($url, $server_key, $data_hash, $method)
    {
        $ch = curl_init();

        if (!$server_key) {
            throw new Exception(
                'The ServerKey/ClientKey is null, You need to set the server-key from Config. Please double-check Config and ServerKey key. ' .
                    'You can check from the Midtrans Dashboard. ' .
                    'See https://docs.midtrans.com/en/midtrans-account/overview?id=retrieving-api-access-keys ' .
                    'for the details or contact support at support@midtrans.com if you have any questions.'
            );
        } else {
            if ($server_key == "") {
                throw new Exception(
                    'The ServerKey/ClientKey is invalid, as it is an empty string. Please double-check your ServerKey key. ' .
                        'You can check from the Midtrans Dashboard. ' .
                        'See https://docs.midtrans.com/en/midtrans-account/overview?id=retrieving-api-access-keys ' .
                        'for the details or contact support at support@midtrans.com if you have any questions.'
                );
            } elseif (preg_match('/\s/', $server_key)) {
                throw new Exception(
                    'The ServerKey/ClientKey is contains white-space. Please double-check your API key. Please double-check your ServerKey key. ' .
                        'You can check from the Midtrans Dashboard. ' .
                        'See https://docs.midtrans.com/en/midtrans-account/overview?id=retrieving-api-access-keys ' .
                        'for the details or contact support at support@midtrans.com if you have any questions.'
                );
            }
        }


        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'User-Agent: midtrans-php-v2.6.1',
                'Authorization: Basic ' . base64_encode($server_key . ':')
            ),
            CURLOPT_RETURNTRANSFER => 1
        );

        // Set append notification to header
        if (Config::$appendNotifUrl) Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'X-Append-Notification: ' . Config::$appendNotifUrl;
        // Set override notification to header
        if (Config::$overrideNotifUrl) Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'X-Override-Notification: ' . Config::$overrideNotifUrl;
        // Set payment idempotency-key to header
        if (Config::$paymentIdempotencyKey) Config::$curlOptions[CURLOPT_HTTPHEADER][] = 'Idempotency-Key: ' . Config::$paymentIdempotencyKey;

        // merging with Config::$curlOptions
        if (count(Config::$curlOptions)) {
            // We need to combine headers manually, because it's array and it will no be merged
            if (Config::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeaders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeaders);
            } else {
                $mergedHeaders = array();
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeaders);
            }

            $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        }

        if ($method != 'GET') {

            if ($data_hash) {
                $body = json_encode($data_hash);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
            } else {
                $curl_options[CURLOPT_POSTFIELDS] = '';
            }

            if ($method == 'POST') {
                $curl_options[CURLOPT_POST] = 1;
            } elseif ($method == 'PATCH') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            }
        }

        curl_setopt_array($ch, $curl_options);

        // For testing purpose
        if (class_exists('\Midtrans\MT_Tests') && MT_Tests::$stubHttp) {
            $result = self::processStubed($curl_options, $url, $server_key, $data_hash, $method);
        } else {
            $result = curl_exec($ch);
            // curl_close($ch);
        }


        if ($result === false) {
            throw new Exception('CURL Error: ' . curl_error($ch), curl_errno($ch));
        } else {
            try {
                $result_array = json_decode($result);
            } catch (Exception $e) {
                throw new Exception("API Request Error unable to json_decode API response: " . $result . ' | Request url: ' . $url);
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (isset($result_array->status_code) && $result_array->status_code >= 401 && $result_array->status_code != 407) {
                throw new Exception('Midtrans API is returning API error. HTTP status code: ' . $result_array->status_code . ' API response: ' . $result, $result_array->status_code);
            } elseif ($httpCode >= 400) {
                throw new Exception('Midtrans API is returning API error. HTTP status code: ' . $httpCode . ' API response: ' . $result, $httpCode);
            } else {
                return $result_array;
            }
        }
    }

    private static function processStubed($curl, $url, $server_key, $data_hash, $method)
    {
        MT_Tests::$lastHttpRequest = array(
            "url" => $url,
            "server_key" => $server_key,
            "data_hash" => $data_hash,
            $method => $method,
            "curl" => $curl
        );

        return MT_Tests::$stubHttpResponse;
    }
}
?>

<?php

namespace Midtrans;

use Exception;

/**
 * Create Snap payment page and return snap token
 */
class Snap
{
    /**
     * Create Snap payment page
     *
     * Example:
     *
     * ```php
     *   
     *   namespace Midtrans;
     * 
     *   $params = array(
     *     'transaction_details' => array(
     *       'order_id' => rand(),
     *       'gross_amount' => 10000,
     *     )
     *   );
     *   $paymentUrl = Snap::getSnapToken($params);
     * ```
     *
     * @param  array $params Payment options
     * @return string Snap token.
     * @throws Exception curl error or midtrans error
     */
    public static function getSnapToken($params)
    {
        return (Snap::createTransaction($params)->token);
    }

    /**
     * Create Snap URL payment
     *
     * Example:
     *
     * ```php
     *
     *   namespace Midtrans;
     *
     *   $params = array(
     *     'transaction_details' => array(
     *       'order_id' => rand(),
     *       'gross_amount' => 10000,
     *     )
     *   );
     *   $paymentUrl = Snap::getSnapUrl($params);
     * ```
     *
     * @param  array $params Payment options
     * @return string Snap redirect url.
     * @throws Exception curl error or midtrans error
     */
    public static function getSnapUrl($params)
    {
        return (Snap::createTransaction($params)->redirect_url);
    }

    /**
     * Create Snap payment page, with this version returning full API response
     *
     * Example:
     *
     * ```php
     *   $params = array(
     *     'transaction_details' => array(
     *       'order_id' => rand(),
     *       'gross_amount' => 10000,
     *     )
     *   );
     *   $paymentUrl = Snap::getSnapToken($params);
     * ```
     *
     * @param  array $params Payment options
     * @return object Snap response (token and redirect_url).
     * @throws Exception curl error or midtrans error
     */
    public static function createTransaction($params)
    {
        $payloads = array(
            'credit_card' => array(
                // 'enabled_payments' => array('credit_card'),
                'secure' => Config::$is3ds
            )
        );

        if (isset($params['item_details'])) {
            $gross_amount = 0;
            foreach ($params['item_details'] as $item) {
                $gross_amount += $item['quantity'] * $item['price'];
            }
            $params['transaction_details']['gross_amount'] = $gross_amount;
        }

        $params = array_replace_recursive($payloads, $params);

        return ApiRequestor::post(
            Config::getSnapBaseUrl() . '/transactions',
            Config::$serverKey,
            $params
        );
    }
}
?>

<?php

// Namespace untuk konfigurasi Midtrans
namespace Midtrans;

/**
 * Midtrans Configuration Class
 * Handles the configuration settings for Midtrans integration.
 */
class Config
{
    /**
     * Merchant's server key
     * Used to authenticate API requests.
     * @var string
     */
    public static $serverKey;

    /**
     * Merchant's client key
     * Used for client-side interactions.
     * @var string
     */
    public static $clientKey;

    /**
     * Determines the environment mode.
     * Set to `true` for production and `false` for sandbox mode.
     * @var bool
     */
    public static $isProduction = false;

    /**
     * Enable or disable 3D Secure.
     * Set to `true` to enable by default.
     * @var bool
     */
    public static $is3ds = false;

    /**
     * Append URL for notifications.
     * Additional endpoint for transaction updates.
     * @var string|null
     */
    public static $appendNotifUrl;

    /**
     * Override URL for notifications.
     * Replaces default notification URL.
     * @var string|null
     */
    public static $overrideNotifUrl;

    /**
     * Payment idempotency key.
     * Prevents duplicate transactions.
     * @var string|null
     */
    public static $paymentIdempotencyKey;

    /**
     * Enable request parameter sanitizer.
     * Validates and modifies charge request parameters.
     * @var bool
     */
    public static $isSanitized = false;

    /**
     * Default cURL options for requests.
     * Used to configure HTTP client behavior.
     * @var array
     */
    public static $curlOptions = [];

    /**
     * Sandbox base URL for Midtrans API.
     */
    const SANDBOX_BASE_URL = 'https://api.sandbox.midtrans.com';

    /**
     * Production base URL for Midtrans API.
     */
    const PRODUCTION_BASE_URL = 'https://api.midtrans.com';

    /**
     * Sandbox base URL for Snap API.
     */
    const SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';

    /**
     * Production base URL for Snap API.
     */
    const SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';

    /**
     * Get the base URL for Midtrans API.
     * Depends on the environment mode ($isProduction).
     *
     * @return string Midtrans API URL
     */
    public static function getBaseUrl()
    {
        return self::$isProduction ? self::PRODUCTION_BASE_URL : self::SANDBOX_BASE_URL;
    }

    /**
     * Get the base URL for Snap API.
     * Depends on the environment mode ($isProduction).
     *
     * @return string Snap API URL
     */
    public static function getSnapBaseUrl()
    {
        return self::$isProduction ? self::SNAP_PRODUCTION_BASE_URL : self::SNAP_SANDBOX_BASE_URL;
    }
}

?>

<?php
include 'koneksi.php';
require_once 'vendor/autoload.php';

// Mulai sesi untuk menyimpan Snap Token
session_start();


// Setup konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-3OAD1jjlXUHo_a2HKD1uvdGf';  // Ganti dengan server key Anda
\Midtrans\Config::$isProduction = false;  // Set ke true saat sudah siap produksi
\Midtrans\Config::$isSanitized = true;  // Aktifkan sanitasi untuk keamanan
\Midtrans\Config::$is3ds = true;  // Aktifkan 3D Secure untuk tambahan keamanan

// Ambil data booking dari database (contoh)
$id_booking = $_GET['id_booking'];  // Atau bisa dari sesi atau cara lain untuk mendapatkan id_booking

// Misalnya, mengambil data booking dari database menggunakan id_booking
$query = "SELECT * FROM booking WHERE id_booking = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id_booking);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();  // Ambil data booking sebagai array

// Pastikan data booking ada
if (!$booking) {
    echo "Booking not found!";
    exit();
}
$query = "SELECT name, email, foto_profile, role FROM user WHERE iduser = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Ambil informasi dari data booking
$nama = $booking['nama'];  // Nama lengkap
$email = $booking['email']; // Email
$no_telpon = $booking['no_telpon']; // Nomor telepon
$alamat = $booking['alamat']; // Alamat
$jenis_layanan = $booking['jenis_layanan']; // Jenis layanan
$harga = 1000000; // Ganti dengan perhitungan harga yang sesuai, jika ada

// ID pemesanan yang unik, dihasilkan dari ID booking atau custom
$order_id = uniqid('ORDER-' . $booking['id_booking']);

// Detail transaksi
$transactionDetails = [
    'order_id' => $order_id,
    'gross_amount' => $harga,  // Total pembayaran
];

// Data pelanggan
$customerDetails = [
    'first_name' => $nama,
    'email' => $email,
    'phone' => $no_telpon,
];

// Detail item (misalnya layanan yang dibeli)
$itemDetails = [
    [
        'id' => 'service_' . $booking['id_booking'],
        'price' => $harga,
        'quantity' => 1,
        'name' => $jenis_layanan,  // Nama layanan
    ]
];

// Gabungkan semua data untuk transaksi Midtrans
$transactionData = [
    'transaction_details' => $transactionDetails,
    'customer_details' => $customerDetails,
    'item_details' => $itemDetails,
];

try {
    // Mendapatkan Snap Token
    $snapToken = \Midtrans\Snap::getSnapToken($transactionData);

    // Simpan Snap Token dalam sesi untuk digunakan di frontend
    $_SESSION['snap_token'] = $snapToken;
} catch (\Exception $e) {  // Gunakan namespace global \Exception
    echo "Error: " . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Glitz Cleaner Cleaning Services </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/setyle.css" rel="stylesheet">
    <link rel="icon" href="Img/Logo.png" type="image/png">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-tncYhI_fGytUpZMW"></script>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-tncYhI_fGytUpZMW"></script>
    <style>
        .profile-image .image {
            width: 50px;
            height: 50px;
            margin: 0 30px 0 0;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-image .image-list {
            position: absolute;
            max-height: 0;
            right: 30px;
            top: 100%;
            width: 100px;
            text-align: center;
            visibility: hidden;
            padding: 0;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 10;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.4s ease;
        }

        .profile-image:hover .image-list {
            max-height: 100%;
            visibility: visible;
            opacity: 1;
        }
    </style>
</head>

<body>
    <!-- Header Start -->
    <div class="container-fluid">
        <div class="row">
            <div class=" bg-dark d-none d-lg-flex w-100 pr-5">
                <div class="col-lg-7 text-left text-white">
                    <div class="h-100 d-inline-flex align-items-center border-right border-primary py-2 px-3">
                        <i class="fa fa-envelope text-primary mr-2"></i>
                        <small>GlitzCleaner@gmail.com</small>
                    </div>
                    <div class="h-100 d-inline-flex align-items-center py-2 px-2">
                        <i class="fa fa-phone-alt text-primary mr-2"></i>
                        <small>+0895422855755</small>
                    </div>
                </div>
                <div class="col-lg-5 text-right">
                    <div class="d-inline-flex align-items-center pr-2">
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a class="text-primary p-2" href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 display-5 text-primary">Glitz Cleaner</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <nav class="row navbar navbar-expand-lg bg-white navbar-light p-0">
                    <a href="" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 display-4 text-primary">Glitz Cleaner</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="user.php" class="nav-item nav-link">Beranda</a>
                            <a href="Tentang1.php" class="nav-item nav-link">Tentang</a>
                            <a href="Layanan1.php" class="nav-item nav-link">Layanan</a>
                            <a href="Keranjang.php" class="nav-item nav-link">Pemesanan</a>
                            <a href="history.php" class="nav-item nav-link">Riwayat</a>
                        </div>
                    </div>
                    <div class="profile-image">
                        <img src="<?php echo htmlspecialchars($user_data['foto_profile']); ?>" alt="" class="image">
                        <ul class="image-list">
                            <li class="list-item">
                                <a href="edit_profil.php">Edit Profil</a>
                            </li>
                            <li class="list-item">
                                <a href="index.php">Log Out</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Payment Section Start -->
    <div class="container-fluid pt-5">
        <div class="container payment-section">
            <div class="text-center mb-5">
                <h2 class="section-title px-5"><span class="px-2">Pembayaran</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="font-weight-semi-bold mb-4">Detail Pembayaran</h4>
                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Nama Lengkap</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['nama'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email</label>
                                    <input class="form-control" type="email"
                                        value="<?php echo $booking['email'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>No Telepon</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['no_telpon'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Alamat</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['alamat'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Jenis Layanan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['jenis_layanan'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Tanggal Pembersihan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['tanggal_pembersihan'] ?? ''; ?>" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Waktu Pembersihan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo isset($booking['waktu_pembersihan']) ? date('H:i', strtotime($booking['waktu_pembersihan'])) : ''; ?>" readonly>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Catatan</label>
                                    <input class="form-control" type="text"
                                        value="<?php echo $booking['catatan'] ?? ''; ?>" readonly>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>


                <div class="col-lg-4">
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Ringkasan Pembayaran</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <p>Subtotal</p>
                                <p>Rp. <?php echo number_format($harga, 0, ',', '.'); ?></p>
                            </div>
                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3">
                                <h6 class="font-weight-medium">Total</h6>
                                <h6 class="font-weight-medium">Rp. <?php echo number_format($harga, 0, ',', '.'); ?></h6>
                            </div>
                        </div>
                        <!-- Tombol untuk memulai proses pembayaran -->
                        <button id="payButton" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Bayar</button>
                        <form id="handleback" action="" method="POST">
                            <input type="hidden" id="json_callback" name="json">
                        </form>


                        <!-- Sertakan Snap.js -->
                        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-tncYhI_fGytUpZMW"></script>

                        <!-- JavaScript untuk memanggil Snap modal -->
                        <script>
                            const snapToken = <?php echo json_encode($snapToken); ?>;

                            document.getElementById('payButton').addEventListener('click', function() {
                                // Gantilah 'SNAP_TOKEN' dengan Snap Token yang Anda dapatkan dari server
                                snap.pay(snapToken, {
                                    onSuccess: function(result) {
                                        document.getElementById('json_callback').value = JSON.stringify(result);
                                        document.getElementById('handleback').submit();
                                    },

                                    onPending: function(result) {
                                        alert('Waiting for payment...');
                                        console.log(result);
                                    },
                                    onError: function(result) {
                                        alert('Payment Failed!');
                                        console.log(result);
                                    },
                                });
                            });
                        </script>



                        <form action="simpan_pesanan.php" method="post">
                            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                            <input type="hidden" name="id_booking" value="<?php echo $booking['id_booking']; ?>">
                            <input type="hidden" name="status" value="belum bayar">
                            <input type="hidden" name="harga" value="1000000"> <!-- Ganti dengan harga yang sesuai -->
                            <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Bayar Nanti</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Payment Section End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white mt-5 py-5 px-sm-3 px-md-5">
        <div class="row pt-5">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="index.html" class="navbar-brand">
                    <h1 class="m-0 mt-n3 display-5 text-primary">Glitz Cleaner</h1>
                </a>
                <p>Bersih, Rapi, dan Nyaman, Hanya untuk Anda!
                </p>
                <h5 class="font-weight-semi-bold text-white mb-2">Buka:</h5>
                <p class="mb-1">Senin – Sabtu, 8pagi – 6sore</p>
                <p class="mb-0">: Tutup</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-semi-bold text-primary mb-4">Get In Touch</h4>
                <p><i class="fa fa-map-marker-alt text-primary mr-2"></i>Jl Bareng Raya IIN/538</p>
                <p><i class="fa fa-phone-alt text-primary mr-2"></i>+62895422855755</p>
                <p><i class="fa fa-envelope text-primary mr-2"></i>GlitzCleaner@gmail.com</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-light btn-social mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-light btn-social mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-light btn-social" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-semi-bold text-primary mb-4">Tautan Cepat</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="user.php"><i class="fa fa-angle-right mr-2"></i>Beranda</a>
                    <a class="text-white mb-2" href="tentang1.php"><i class="fa fa-angle-right mr-2"></i>Tentang</a>
                    <a class="text-white mb-2" href="Layanan1.php"><i class="fa fa-angle-right mr-2"></i>Layanan</a>
                    <a class="text-white mb-2" href="pesan.php"><i class="fa fa-angle-right mr-2"></i>Pesan</a>
                    <a class="text-white" href="history.php"><i class="fa fa-angle-right mr-2"></i>Riwayat</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-semi-bold text-primary mb-4">Buletin</h4>
                <p>Kami senang dapat memperkenalkan layanan pembersihan kami yang dirancang untuk memenuhi semua
                    kebutuhan
                    kebersihan Anda. Dengan tim profesional dan berpengalaman, kami siap membantu Anda menjaga rumah
                    atau
                    kantor Anda tetap bersih dan nyaman..</p>
            </div>
        </div>
    </div>
    </div>
    <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5"
        style="border-color: #3E3E4E !important;">
        <div class="row">
            <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                <p class="m-0 text-white">&copy; <a href="#">Copyright</a>. GlitzCleaner</p>
            </div>
            <div class="col-lg-6 text-center text-md-right">
                <ul class="nav d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Privacy</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">FAQs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white py-0" href="#">Help</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary px-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>