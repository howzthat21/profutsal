<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: adminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Fetch arena data from the database
$query = "SELECT * FROM arenas";
$stmt = $pdo->query($query);
$arenas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle deletion of arena
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $arena_id = $_POST['arena_id'];
    $deleteStmt = $pdo->prepare("DELETE FROM arenas WHERE arena_id = ?");
    $deleteStmt->execute([$arena_id]);
    header('Location: view_arenas.php'); // Redirect to avoid resubmitting
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Arenas</title>
    <link rel="stylesheet" href="view_arenas.css">
</head>
<body>
    <div class="container">
        <h2>Manage Arenas</h2>
        <a href="add_arena.php" class="btn">Add Arena</a>
        <a href="adminDashboard.php" class="btn back-btn">Back to Admin Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>Arena ID</th>
                    <th>Arena Name</th>
                    <th>Arena Location</th>
                    <th>Location Link</th>
                    <th>Arena Image</th>
                    <th>Availability</th>
                    <th>Contact Info</th>
                    <th>Rental Fee</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arenas as $arena): ?>
                    <tr>
                        <td><?= htmlspecialchars($arena['arena_id']) ?></td>
                        <td><?= htmlspecialchars($arena['arena_name']) ?></td>
                        <td><?= htmlspecialchars($arena['arena_location']) ?></td>
                        <td>
                            <?= !empty($arena['location_link']) ? "<a href='".htmlspecialchars($arena['location_link'])."' target='_blank'>Link</a>" : 'N/A' ?>
                        </td>
                        <td>
                            <?= !empty($arena['arena_image']) ? "<img src='".htmlspecialchars($arena['arena_image'])."' alt='Arena Image' width='100'>" : 'No Image' ?>
                        </td>
                        <td><?= htmlspecialchars($arena['availability']) ?></td>
                        <td><?= htmlspecialchars($arena['contact_info']) ?></td>
                        <td><?= !empty($arena['rental_fee']) ? '$' . number_format($arena['rental_fee'], 2) : 'N/A' ?></td>
                        <td><?= htmlspecialchars($arena['created_at']) ?></td>
                        <td><?= htmlspecialchars($arena['updated_at']) ?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="edit_arena.php?id=<?= $arena['arena_id'] ?>" class="btn">Edit</a>

                            <!-- Delete Button inside form -->
                            <form method="POST" action="view_arenas.php" style="display:inline;">
                                <input type="hidden" name="arena_id" value="<?= $arena['arena_id'] ?>">
                                <button type="submit" name="delete" class="btn delete" onclick="return confirm('Are you sure you want to delete this arena?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
