<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: AdminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Fetch the user to edit based on the id passed in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // If no user found, redirect back to view_users.php
        header('Location: view_users.php');
        exit;
    }
} else {
    // If no id is provided, redirect back to view_users.php
    header('Location: view_users.php');
    exit;
}

// Handle form submission for updating user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password if it's updated
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the update query
    $updateStmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $updateStmt->execute([$username, $email, $hashedPassword, $user_id]);

    // Redirect back to the view_users.php page after updating
    header('Location: view_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="edit_users.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>

        <!-- Button to go back to User Management -->
        <a href="view_users.php" class="btn back-btn">Back to Manage Users</a>

        <form method="POST" action="edit_user.php?id=<?= $user['id'] ?>">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password" required>
            </div>
            <button type="submit" class="btn">Update User</button>
        </form>
    </div>
</body>
</html>
