<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: adminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Fetch referees from the database
$query = "SELECT * FROM referee";
$stmt = $pdo->query($query);
$referees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
    // Handle referee deletion
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        $referee_id = $_POST['referee_id'];
        $deleteStmt = $pdo->prepare("DELETE FROM referee WHERE referee_id = ?");
        $deleteStmt->execute([$referee_id]);
        header('Location: viewReferees.php');
        exit;
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Referees</title>
    <link rel="stylesheet" href="viewReferees.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="container">
        <h2>Manage Referees</h2>
        <a href="refereeRegister.php" class="btn">Add Referee</a>
        <a href="adminDashboard.php" class="btn">Back to Dashboard</a>
        <table>
            <thead>
                <tr>
                    <th>Referee ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($referees as $referee): ?>
                    <tr>
                        <td><?= htmlspecialchars($referee['referee_id']) ?></td>
                        <td><?= htmlspecialchars($referee['username']) ?></td>
                        <td><?= htmlspecialchars($referee['email']) ?></td>
                        <td><?= htmlspecialchars($referee['status']) ?></td>
                        <td><?= htmlspecialchars($referee['created_at']) ?></td>
                        <td><?= htmlspecialchars($referee['updated_at']) ?></td>
                        <td>
                            <a href="edit_referee.php?id=<?= $referee['referee_id'] ?>" class="btn">Edit</a>
                            <form method="POST" action="viewReferees.php" style="display:inline;">
                                <input type="hidden" name="referee_id" value="<?= $referee['referee_id'] ?>">
                                <button type="submit" name="delete" class="btn delete" onclick="return confirm('Are you sure you want to delete this referee?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    

</body>
</html>
