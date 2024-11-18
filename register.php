<?php
include 'db.php';
include 'errors.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare SQL statement
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    
    // Check if the statement executed successfully
    if ($stmt->execute([$username, $email, $password])) {
        // If registration is successful, redirect to index.php
        header("Location: index.php");
        exit(); // Ensure no further code is executed after the redirect
    } else {
        // If registration fails, display an error message
        
        handleSQLError($stmt->errorInfo()[2]);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
