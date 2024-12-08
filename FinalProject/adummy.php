<?php
include 'db.php';

   
    // SQL query to group players by team name
    $query = "SELECT team_name, GROUP_CONCAT(user_id SEPARATOR ', ') AS players 
              FROM completed_match_participants where match_id=59; 
              GROUP BY team_name";
    
    $stmt = $pdo->query($query);
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Players by Team</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Players by Team</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Players</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teams)): ?>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($team['team_name']); ?></td>
                            <td><?php echo htmlspecialchars($team['players']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No teams found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
