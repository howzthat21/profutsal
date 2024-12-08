<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: AdminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Fetch user data from the database
$query = "SELECT u.id, u.username, u.email, u.created_at, pp.elo from users u
        Join player_profiles pp on pp.user_id=u.id ";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for deleting users
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $deleteStmt->execute([$user_id]);
    header('Location: view_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="view_users.css">
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>

        <!-- Button to go back to Admin Dashboard -->
        <a href="adminDashboard.php" class="btn back-btn">Back to Admin Dashboard</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Latest Elo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['username']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                        <td><?= htmlspecialchars($user['elo']) ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn">Edit</a>
                            <form method="POST" action="view_users.php" style="display:inline;">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete" class="btn delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
