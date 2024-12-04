<?php
session_start();
include 'db.php';
include 'CalculateNewElo.php';//divides elo according to the match result

// Check if referee is logged in
if (!isset($_SESSION['referee_id'])) {
    header("Location: refereeLogin.php");
    exit();
}

$referee_id = $_SESSION['referee_id'];
$match_id = $_GET['match_id'] ?? null; // Get the match ID passed via query parameter
$winning_team=$_GET['winning_team'] ?? null;
$team_a_name= $_GET['team_a_name'];
$team_b_name= $_GET['team_b_name'];
//echo $match_id;
//echo $winning_team;

function updatePlayerElo($user_id, $match_id) {
    global $pdo;

    // Fetch player stats
    $stats_query = "
        SELECT goals, assists, fouls
        FROM player_stats
        WHERE match_id = ? AND player_id = ?
    ";
    $stmt = $pdo->prepare($stats_query);
    $stmt->execute([$match_id, $user_id]);
    $player_stats = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$player_stats) {
        throw new Exception("Player stats not found for user_id: $user_id");
    }

    
    $elo_change = ($player_stats['goals'] * 10) + ($player_stats['assists'] * 5) - ($player_stats['fouls'] * 2);

    $current_elo_query = "
        SELECT elo
        FROM player_profiles
        WHERE user_id = ?
    ";
    $stmt = $pdo->prepare($current_elo_query);
    $stmt->execute([$user_id]);
    $current_elo = $stmt->fetchColumn();

    if ($current_elo === false) {
        throw new Exception("Player profile not found for user_id: $user_id");
    }

    // Update ELO
    $new_elo = max(0, $current_elo + $elo_change); // ELO cannot be negative
    $update_elo_query = "
        UPDATE player_profiles
        SET elo = ?
        WHERE user_id = ?
    ";
    $stmt = $pdo->prepare($update_elo_query);
    $stmt->execute([$new_elo, $user_id]);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $playerData = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL query for inserting/updating player stats
    $insert_query = "
        INSERT INTO player_stats(match_id, player_id, goals, assists, fouls)
        VALUES (?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            goals = VALUES(goals),
            assists = VALUES(assists),
            fouls = VALUES(fouls)
    ";

    $stmt = $pdo->prepare($insert_query);

    // Process each player's data
    foreach ($playerData as $player) {
        try {
            // Insert/update player stats
            $stmt->execute([
                $match_id,
                $player['playerId'],
                $player['goals'],
                $player['assists'],
                $player['fouls']
            ]);

            // Call updatePlayerElo function for the player
            updatePlayerElo($player['playerId'], $match_id);
        } catch (Exception $e) {
            // Handle errors and respond with a failure message
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            exit();
        }
    }

    // Respond with success
    echo json_encode(['success' => true]);
    exit();
}


// Fetch match participants
$participants_query = "
    SELECT p.user_id, u.username
    FROM completed_match_participants p
    JOIN users u ON p.user_id = u.id
    WHERE p.match_id = ?
";

$stmt = $pdo->prepare($participants_query);
$stmt->execute([$match_id]);
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referee - Add Match Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2, h3 {
            font-weight: 600;
        }
        #confirmSubmission {
            width: 100%;
            font-size: 1.2rem;
        }
        .table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4">
        <h2 class="text-center mb-4 text-primary">Add Match Details</h2>

        <!-- Form Section -->
        <form id="playerForm" action="calculateNewElo.php?match_id=<?php echo $match_id;?>&winning_team=<?php echo $winning_team;?>&team_a_name=<?php echo $team_a_name;?>&team_b_name=<?php echo $team_b_name;?>">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="player_id" class="form-label">Player</label>
                    <select class="form-select" name="player_id" id="player_id" required>
                        <option value="">Select a Player</option>
                        <?php foreach ($participants as $participant): ?>
                            <option value="<?= $participant['user_id'] ?>"><?= $participant['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="goals" class="form-label">Goals</label>
                    <input type="number" class="form-control" id="goals" name="goals" value="0" min="0">
                </div>
                <div class="col-md-2">
                    <label for="assists" class="form-label">Assists</label>
                    <input type="number" class="form-control" id="assists" name="assists" value="0" min="0">
                </div>
                <div class="col-md-2">
                    <label for="fouls" class="form-label">Fouls</label>
                    <input type="number" class="form-control" id="fouls" name="fouls" value="0" min="0">
                </div>
            </div>
            <div class="text-end">
                <button type="button" id="addPlayerData" class="btn btn-primary">Add Player Data</button>
            </div>
        </form>
    </div>

    <!-- Display Section -->
    <div class="card mt-5 p-4">
        <h3 class="text-center text-secondary">Player Match Details</h3>
        <table class="table table-bordered table-striped mt-3" id="playerDataTable">
            <thead class="table-primary">
                <tr>
                    <th>Player ID</th>
                    <th>Player Name</th>
                    <th>Goals</th>
                    <th>Assists</th>
                    <th>Fouls</th>
                </tr>
            </thead>
            <tbody>
                <!-- Player data will be appended here dynamically -->
            </tbody>
        </table>
    </div>

    <!-- Confirm Submission Section -->
    <div class="text-center mt-4">
        <button type="button" id="confirmSubmission" class="btn btn-success btn-lg" disabled>
            Confirm Submission
        </button>
    </div>
</div>

<script>
    // Variables to hold data
    const playerData = [];
    const playerForm = document.getElementById('playerForm');
    const playerDataTable = document.getElementById('playerDataTable').getElementsByTagName('tbody')[0];
    const confirmSubmissionBtn = document.getElementById('confirmSubmission');

    // Add player data
    document.getElementById('addPlayerData').addEventListener('click', () => {
        // Get form values
        const playerId = document.getElementById('player_id').value;
        const playerName = document.getElementById('player_id').options[document.getElementById('player_id').selectedIndex].text;
        const goals = document.getElementById('goals').value;
        const assists = document.getElementById('assists').value;
        const fouls = document.getElementById('fouls').value;

        // Check if player is already added
        if (playerData.some(player => player.playerId === playerId)) {
            alert('Player data is already added.');
            return;
        }

        // Add player data to the array
        playerData.push({
            playerId,
            playerName,
            goals,
            assists,
            fouls
        });

        // Add data to the table
        const row = playerDataTable.insertRow();
        row.innerHTML = `
            <td>${playerId}</td>
            <td>${playerName}</td>
            <td>${goals}</td>
            <td>${assists}</td>
            <td>${fouls}</td>
        `;

        // Enable Confirm Submission button
        confirmSubmissionBtn.disabled = false;

        // Reset the form
        playerForm.reset();
    });

    // Confirm submission
    confirmSubmissionBtn.addEventListener('click', () => {
        // Send data to the server via fetch
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(playerData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Player data submitted successfully!');
                // Clear the table and data array
                playerDataTable.innerHTML = '';
                playerData.length = 0;
                confirmSubmissionBtn.disabled = true;
                const matchId = <?= json_encode($match_id) ?>; 
    const winningTeam = '<?= $winning_team ?>';  
    const url = `nextPage.php?match_id=${matchId}&winning_team=${winningTeam}`; 
    window.location.href = url; 
            } else {
                alert('Error submitting data.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
