<?php
include 'db.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="https://uat.esewa.com.np/epay/main" method="POST">
    <input type="hidden" name="tAmt" value="1000"> <!-- Total Amount -->
    <input type="hidden" name="amt" value="1000"> <!-- Actual Amount -->
    <input type="hidden" name="txAmt" value="0">  <!-- Tax -->
    <input type="hidden" name="psc" value="0">    <!-- Service Charge -->
    <input type="hidden" name="pdc" value="0">    <!-- Delivery Charge -->
    <input type="hidden" name="scd" value="EPAYTEST"> <!-- Testing Merchant Code -->
    <input type="hidden" name="pid" value="TestPayment123"> <!-- Unique Payment ID -->
    <input type="hidden" name="su" value="http://localhost/projfutsal/esewa_success.php"> <!-- Success URL -->
    <input type="hidden" name="fu" value="http://localhost/projfutsal/esewa_failure.php"> <!-- Failure URL -->
    <button type="submit">Pay with eSewa</button>
</form>

</body>
</html>