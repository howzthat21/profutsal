<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: adminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Fetch referee data based on the referee_id passed in the URL
if (isset($_GET['id'])) {
    $referee_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM referee WHERE referee_id = ?");
    $stmt->execute([$referee_id]);
    $referee = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$referee) {
        echo "Referee not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

// Handle form submission to update referee data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Update referee data in the database
    $updateStmt = $pdo->prepare("UPDATE referee SET username = ?, email = ?, status = ? WHERE referee_id = ?");
    $updateStmt->execute([$username, $email, $status, $referee_id]);

    // Redirect to view referees page after successful update
    header('Location: viewReferees.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Referee</title>
    <link rel="stylesheet" href="edit_referee.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="container">
        <h2>Edit Referee</h2>
        <form method="POST" action="edit_referee.php?id=<?= htmlspecialchars($referee['referee_id']) ?>">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($referee['username']) ?>" required>
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($referee['email']) ?>" required>
            </div>
            <div class="input-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="unassigned" <?= $referee['status'] == 'unassigned' ? 'selected' : '' ?>>Unassigned</option>
                    <option value="assigned" <?= $referee['status'] == 'assigned' ? 'selected' : '' ?>>Assigned</option>
                </select>
            </div>
            <button type="submit" class="btn">Update Referee</button>
            <a href="viewReferees.php" class="btn cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
