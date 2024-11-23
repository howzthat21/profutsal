<?php
if (isset($_GET['oid'])) {
    $order_id = $_GET['oid']; // Your unique order ID
    $amount = $_GET['amt'];  // Amount paid
    $ref_id = $_GET['refId']; // eSewa reference ID

    // Verify the payment with eSewa UAT
    $url = "https://uat.esewa.com.np/epay/transrec";
    $data = [
        'amt' => $amount,
        'rid' => $ref_id,
        'pid' => $order_id,
        'scd' => 'EPAYTEST', // Testing Merchant Code
    ];

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    if (strpos($response, '<response_code>Success</response_code>') !== false) {
        echo "Payment verified successfully in UAT mode!";
    } else {
        echo "Payment verification failed in UAT mode!";
    }
} else {
    echo "No order ID provided!";
}
