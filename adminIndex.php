<?php
// Start the session
session_start();

// Initialize error message
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted username and password
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hardcoded admin credentials (replace these with database authentication in production)
    $adminUsername = 'admin';
    $adminPassword = 'admin123';

    // Validate credentials
    if ($username === $adminUsername && $password === $adminPassword) {
        // Set admin session and redirect to dashboard
        $_SESSION['admin'] = $username;
        header('Location: adminDashboard.php');
        exit; // Ensure no further code is executed
    } else {
        // Set error message for invalid credentials
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="adminIndex.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
