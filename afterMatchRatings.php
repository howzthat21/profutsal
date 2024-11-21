<?php
include 'db.php';

// Fetch match details and match_id
$query = "
    SELECT 
        cm.completed_match_id, 
        cm.match_id, 
        cm.match_date, 
        rm.referee_id 
    FROM 
        completed_matches cm
    INNER JOIN 
        referee_matches rm 
    ON 
        cm.match_id = rm.match_id
    WHERE 
        cm.match_id = :match_id
    ORDER BY 
        cm.match_date DESC
";
$match_id = $_GET['match_id'] ?? null; // Ensure $match_id is set
$matches_stmt = $pdo->prepare($query);
$matches_stmt->execute(['match_id' => $match_id]);
$matches = $matches_stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize match details if available


// Fetch players participating in the match
$fetch_player_sql = "
    SELECT completed_match_participants.*, users.username 
    FROM completed_match_participants 
    JOIN users ON completed_match_participants.user_id = users.id 
    WHERE completed_match_participants.match_id = :match_id
";
$fetch_player_stmt = $pdo->prepare($fetch_player_sql);
$fetch_player_stmt->execute(['match_id' => $match_id]);
$players = $fetch_player_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['player_ids']) && is_array($_POST['player_ids'])) {
        $player_ids = $_POST['player_ids'];
        $ratings = $_POST['ratings'];
        $goals = $_POST['goals'];
        $assists = $_POST['assists'];
        $fouls = $_POST['fouls'];

        // Validate input counts
        if (count($player_ids) === count($ratings) && count($ratings) === count($goals) &&
            count($goals) === count($assists) && count($assists) === count($fouls)) {

            $insert_sql = "
                INSERT INTO player_match_stats (completed_match_id, player_id, rating_id, goals, assists, fouls) 
                VALUES (:completed_match_id, :player_id, :rating_id, :goals, :assists, :fouls)
            ";
            $stmt = $pdo->prepare($insert_sql);

            // Insert each player's stats
            for ($i = 0; $i < count($player_ids); $i++) {
                $stmt->execute([
                    'completed_match_id' => $completed_match_id,
                    'player_id' => $player_ids[$i],
                    'rating_id' => $ratings[$i],
                    'goals' => $goals[$i],
                    'assists' => $assists[$i],
                    'fouls' => $fouls[$i],
                ]);
            }
        } else {
            echo "Input data mismatch. Please try again.";
        }
    } else {
        echo "Player IDs not found. Please try submitting the form again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Player Stats for Match <?php echo htmlspecialchars($match_id); ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Enter Player Stats for Match <?php echo htmlspecialchars($match_id); ?></h2>
    <form action="afterMatchRatings.php?match_id=<?php echo htmlspecialchars($match_id); ?>" method="POST">
        <!-- Match Selection -->
        <div class="form-group">
            <label for="match_id">Select Match:</label>
            <select name="match_id" id="match_id" class="form-control" required>
                <?php foreach ($matches as $match): ?>
                    <option value="<?php echo htmlspecialchars($match['match_id']); ?>" <?php echo $match['match_id'] == $match_id ? 'selected' : ''; ?>>
                        Match ID: <?php echo htmlspecialchars($match['match_id']); ?> - Date: <?php echo htmlspecialchars($match['match_date']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Player Stats Entry Section -->
        <div id="player-stats-section">
            <?php foreach ($players as $player): ?>
                <div class="player-stat-entry border p-3 mb-3">
                    <h5>Player Stat Entry</h5>
                    <div class="form-group">
                        <label for="player_id">Player ID:</label>
                        <input type="text" name="player_ids[]" class="form-control" value="<?php echo htmlspecialchars($player['user_id']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="player_name">Player Name:</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($player['username']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="rating">Rating (Beginner, Amateur, or Pro):</label>
                        <select name="ratings[]" class="form-control" required>
                            <option value="">Select Rating</option>
                            <option value="1">Beginner</option>
                            <option value="2">Amateur</option>
                            <option value="3">Pro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="goals">Goals:</label>
                        <input type="number" name="goals[]" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="assists">Assists:</label>
                        <input type="number" name="assists[]" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="fouls">Fouls:</label>
                        <input type="number" name="fouls[]" class="form-control" min="0" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-player-entry mt-2">Remove Player Entry</button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Add More Players Button -->
        <button type="button" class="btn btn-primary mt-3" id="add-player-button">Add Another Player</button>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success mt-3">Save Stats</button>
    </form>
</div>

<script>
    document.getElementById('add-player-button').addEventListener('click', function() {
        const playerEntry = document.querySelector('.player-stat-entry');
        const newPlayerEntry = playerEntry.cloneNode(true);
        newPlayerEntry.querySelectorAll('input').forEach(input => input.value = '');
        document.getElementById('player-stats-section').appendChild(newPlayerEntry);
    });

    document.querySelectorAll('.remove-player-entry').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.player-stat-entry').remove();
        });
    });
</script>
</body>
</html>
