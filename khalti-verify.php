<?php
$data = json_decode(file_get_contents("php://input"), true);
file_put_contents('debug.txt', print_r($data, true)); // Logs payload to debug.txt

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Khalti API Key
    $secret_key = "test_secret_key_dc74ebbbd29d4cb29f6e19a8b54c6d7a";

    // Payload for verification
    $args = http_build_query([
        'token' => $data['token'],
        'amount' => $data['amount'], // Amount in paisa
    ]);

    // Khalti Verify Endpoint
    $url = "https://khalti.com/api/v2/payment/verify/";

    // cURL for API request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Key $secret_key",
    ]);

    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    file_put_contents('response_debug.txt', $response);
    // Handle response
    if ($status_code == 200) {
        $response_data = json_decode($response, true);
        echo json_encode(['success' => true, 'data' => $response_data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Payment verification failed.']);
    }
}
