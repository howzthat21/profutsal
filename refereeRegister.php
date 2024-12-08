<?php
session_start();

// Enable error reporting (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: adminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

$error = '';

// Handle form submission for registering a new referee
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Validate the status
    if (!in_array($status, ['assigned', 'unassigned'])) {
        $error = 'Invalid status selected.';
    }

    // Hash the password before saving it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the insert query
    if (!$error) {
        $stmt = $pdo->prepare("INSERT INTO referee (username, email, password, status) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$username, $email, $hashedPassword, $status]);

        if ($result) {
            // Redirect to referee management page or display success message
            header('Location: viewReferees.php');
            exit;
        } else {
            $error = 'Failed to register referee. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Referee</title>
    <link rel="stylesheet" href="refereeRegister.css">
</head>
<body>
    <div class="container">
        <h2>Register Referee</h2>

        <!-- Button to go back to Referee Management -->
        <a href="viewReferees.php" class="btn back-btn">Back to Manage Referees</a>

        <!-- Registration Form -->
        <form method="POST" action="refereeRegister.php">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="unassigned">Unassigned</option>
                    <option value="assigned">Assigned</option>
                </select>
            </div>
            <button type="submit" class="btn">Register Referee</button>
            <a href="refereeLogin.php"><button type="button" class="btn">Already a Referee? Log In</button></a>
        </form>

        <!-- Display error message if registration fails -->
        <?php if ($error): ?>
            <p id="error-message" style="color: red; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
