
<?php
session_start(); // Start the session

// Check if user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) { // Assuming 'user_id' is set when a user logs in
    // Redirect to login page if session is not set
    header("Location: login.php");
    exit();
}
$user_id=$_SESSION['user_id'];
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
    <a href="selectarena.php">create a match</a>
    <a href="matchmakingarena.php">join lobby</a>

    
</body>
</html>