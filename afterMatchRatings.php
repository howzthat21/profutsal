<?php
include 'db.php';


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
    
    ORDER BY 
        cm.match_date DESC 
    LIMIT 1
";

$matches = $pdo->query($query);


$matches = $matches->fetch(PDO::FETCH_ASSOC);

if ($matches) {
    $completed_match_id = $matches['completed_match_id'];
    $match_date = $matches['match_date'];
    $match_id = $matches['match_id'];
    $match_referee_id = $matches['referee_id'];

    echo "Latest Match ID: $completed_match_id - Date: $match_date";
    
} else {
    echo "No matches found.";
}


$fetch_player_sql = "
    SELECT match_participants.*, users.username 
    FROM match_participants 
    JOIN users ON match_participants.user_id = users.id 
    WHERE match_participants.match_id = :match_id
";

$fetch_player_stmt = $pdo->prepare($fetch_player_sql); 
$fetch_player_stmt->execute(['match_id' => $match_id]); 
$players = $fetch_player_stmt->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (isset($_POST['player_ids']) && is_array($_POST['player_ids'])) {
        
        $player_ids = $_POST['player_ids'];  
        $ratings = $_POST['ratings'];  
        $goals = $_POST['goals'];  
        $assists = $_POST['assists'];  
        $fouls = $_POST['fouls'];  

        
        if (count($player_ids) === count($ratings) && count($ratings) === count($goals) && count($goals) === count($assists) && count($assists) === count($fouls)) {
        
            echo $match_id;
            $insert_sql = "
                INSERT INTO player_match_stats (completed_match_id, player_id, rating_id, goals, assists, fouls) 
                VALUES (:completed_match_id, :user_id, :rating_id, :goals, :assists, :fouls)
            ";
            $stmt = $pdo->prepare($insert_sql);
        

            for ($i = 0; $i < count($player_ids); $i++) {
                
                $stmt->execute([
                    'completed_match_id' => $completed_match_id,
                    'user_id' => $player_ids[$i],
                    'rating_id' => $ratings[$i], 
                    'goals' => $goals[$i],
                    'assists' => $assists[$i],
                    'fouls' => $fouls[$i]
                ]);
            }
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
    <title>Enter Player Stats for eted Match <?php echo $match_id;?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Enter Player Stats for Completed Match  <?php echo $match_id;?></h2>
    <form action="afterMatchRatings.php" method="POST">

        <!-- Match Selection -->
        <div class="form-group">
            <label for="match_id">Select Match:</label>
            <select name="match_id" id="match_id" class="form-control" required>
                <option value="<?php echo $match_id; ?>">Match ID: <?php echo $completed_match_id; ?> - Date: <?php echo $match_date; ?></option>
            </select>
        </div>

        <!-- Player Stats Entry Section -->
        <div id="player-stats-section">
            <!-- Loop through players dynamically -->
            <?php foreach ($players as $player): ?>
            <div class="player-stat-entry border p-3 mb-3">
                <h5>Player Stat Entry</h5>
                
                <div class="form-group">
    <label for="player_id">Player ID: <?php echo htmlspecialchars($player['user_id']); ?></label>
    <input type="text" name="player_ids[]" value="<?php echo htmlspecialchars($player['user_id']); ?>">
</div>

                <div class="form-group">
                    <label for="player_id">Player name:<?php echo htmlspecialchars($player['username']); ?></label>
                    
                </div>

                <div class="form-group">
    <label for="rating">Rating (Beginner, Amateur, or Pro):</label>
    <select name="ratings[]" class="form-control" required>
        <option value="">Select Rating</option>
        <option value="1">Beginner(1)</option>
        <option value="2">Amateur(2)</option>
        <option value="3">Pro(3)</option>
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

                <!-- Remove Entry Button -->
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
    // Add a new player stat entry when "Add Another Player" is clicked
    document.getElementById('add-player-button').addEventListener('click', function() {
        // Clone the first player stat entry
        const playerEntry = document.querySelector('.player-stat-entry');
        const newPlayerEntry = playerEntry.cloneNode(true);

        // Clear the values in the cloned inputs
        newPlayerEntry.querySelectorAll('input').forEach(input => input.value = '');

        // Add remove button event listener for the new entry
        newPlayerEntry.querySelector('.remove-player-entry').addEventListener('click', function() {
            newPlayerEntry.remove();
        });

        // Append the new player stat entry to the form
        document.getElementById('player-stats-section').appendChild(newPlayerEntry);
    });

    // Attach remove event listener to initial entry
    document.querySelector('.remove-player-entry').addEventListener('click', function() {
        this.closest('.player-stat-entry').remove();
    });
</script>
</body>
</html>
