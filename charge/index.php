<?php
// Endpoint Midtrans Snap Sandbox
$url = "https://app.sandbox.midtrans.com/snap/v1/transactions";

// Mengizinkan CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Ambil body permintaan yang dikirim dari aplikasi
$body = file_get_contents('php://input');

// Buat permintaan HTTP menggunakan curl
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode("SB-Mid-server-CZmZhyGxtAqSHo_0umwyRgcW:")
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

// Eksekusi permintaan dan dapatkan respons
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    // Mengembalikan pesan kesalahan
    http_response_code(500);
    echo json_encode(["error" => curl_error($ch)]);
    curl_close($ch);
    exit();
} else {
    // Kembalikan respons dari Midtrans ke aplikasi
    http_response_code($httpCode);
    echo $response;
}

curl_close($ch);
?>
