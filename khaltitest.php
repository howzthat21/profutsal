<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Integration</title>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>
<body>
    <button id="payment-button">Pay with Khalti</button>

    <script>
        // Khalti configuration
        var config = {
            // Replace with your actual public key for production
            "publicKey": "test_public_key_dc74ebbbd29d4cb29f6e19a8b54c6d7a",
            "productIdentity": "1234567890",
            "productName": "Test Product",
            "productUrl": "http://localhost/test-product",
            "paymentPreference": [
                "KHALTI",
                "EBANKING",
                "MOBILE_BANKING",
                "CONNECT_IPS",
                "SCT",
            ],
            "eventHandler": {
                onSuccess(payload) {
                    console.log("Payload: ", payload);

                    // Send payload to backend for verification
                    fetch('http://localhost/projfutsal/khalti-verify.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                alert('Payment successful!');
                            } else {
                                alert('Payment verification failed.');
                            }
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                },
                onError(error) {
                    console.error("Error: ", error);
                    alert("Something went wrong.");
                },
                onClose() {
                    console.log("Payment widget closed.");
                },
            },
        };

        // Initialize Khalti Checkout
        var checkout = new KhaltiCheckout(config);

        // Attach event to the button
        document.getElementById("payment-button").onclick = function () {
            checkout.show({ amount: 1000 }); // Amount in paisa (1000 = Rs. 10)
        };
    </script>
</body>
</html>
