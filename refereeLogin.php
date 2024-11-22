<?php
session_start();

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection (update with your own db credentials)
require 'db.php';

$error = ''; // To store error messages

// Handle form submission for login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists in the database
    $stmt = $pdo->prepare("SELECT * FROM referee WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]); // Check by both username and email
    $referee = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($referee && password_verify($password, $referee['password'])) {
        // If password matches, set session variables
        $_SESSION['referee_id'] = $referee['referee_id'];
        $_SESSION['referee_name'] = $referee['username']; // Or use email if desired
        $_SESSION['status'] = $referee['status']; // 'assigned' or 'unassigned'

        // Redirect to the referee dashboard or another page
        header('Location: refereeDashboard.php');
        exit;
    } else {
        // If login fails, show error message
        $error = 'Invalid username, email, or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referee Login</title>
    <link rel="stylesheet" href="refereeLogin.css"> <!-- Include your CSS file here -->
</head>
<body>
    <div class="container">
        <h2>Referee Login</h2>

        <?php if ($error): ?>
            <p style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="refereeLogin.php">
            <div class="input-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <p style="text-align: center;">
            Not registered yet? <a href="refereeRegister.php" class="btn">Register as Referee</a>
        </p>
    </div>
</body>
</html>
