
<?php
session_start(); 


if (!isset($_SESSION['user_id'])) { 
    
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