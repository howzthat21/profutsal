<?php
include 'db.php';
session_start();


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

$fetch_waiting_lobby = "SELECT mp.match_id 
    FROM match_participants mp
    JOIN users u ON mp.user_id = u.id
    WHERE mp.match_id NOT IN (
        SELECT match_id FROM completed_matches
    ) AND mp.user_id = ?";
$fetch_waiting_lobby_stmt = $pdo->prepare($fetch_waiting_lobby);
$fetch_waiting_lobby_stmt->execute([$user_id]);
$waiting_lobby = $fetch_waiting_lobby_stmt->fetch(PDO::FETCH_ASSOC);
if(!$waiting_lobby){
    echo "You are not in a lobby";
    header("Location: index.php");
    exit();
}

$match_id = $waiting_lobby['match_id'];

$fetch_info = "SELECT arena_id, booking_datetime, player_count FROM matchmaking WHERE match_id = ?";
$fetch_info_stmt = $pdo->prepare($fetch_info);
$fetch_info_stmt->execute([$match_id]);
$lobby_view = $fetch_info_stmt->fetch(PDO::FETCH_ASSOC);

$arena_id = $lobby_view['arena_id'];
$booking_datetime = $lobby_view['booking_datetime'];
$lobby_player_count = $lobby_view['player_count'];

$fetch_arena_details = "SELECT arena_name, arena_location FROM arenas WHERE arena_id = ?";
$fetch_arena_details_stmt = $pdo->prepare($fetch_arena_details);
$fetch_arena_details_stmt->execute([$arena_id]);
$fetch_arena = $fetch_arena_details_stmt->fetch(PDO::FETCH_ASSOC);

$arena_name = $fetch_arena['arena_name'];
$arena_location = $fetch_arena['arena_location'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delete_match_participant = "DELETE FROM match_participants WHERE match_id = ? AND user_id = ?";
    $delete_match_participant_stmt = $pdo->prepare($delete_match_participant);
    $delete = $delete_match_participant_stmt->execute([$match_id, $user_id]);

    if ($delete) {
        try {
            $update_query = "UPDATE matchmaking SET player_count = player_count - 1 WHERE match_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update = $update_stmt->execute([$match_id]);

            
        } catch (PDOException $e) {
            echo "Error updating player count: " . $e->getMessage();
        }

        // Check if player count is zero, delete match from matchmaking table
        if ($update_stmt) {
            $current_players = "SELECT player_count FROM matchmaking WHERE match_id = ?";
            $current_players_stmt = $pdo->prepare($current_players);
            $current_players_stmt->execute([$match_id]);
            $current_players_result = $current_players_stmt->fetch(PDO::FETCH_ASSOC);
            $current_players_count = $current_players_result['player_count'];

            if ($current_players_count == 0) {
                $delete_match_query = "DELETE FROM matchmaking WHERE match_id = ?";
                $delete_match_stmt = $pdo->prepare($delete_match_query);
                $delete_match_stmt->execute([$match_id]);
            }
        }

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Lobby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .player-box-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }
        .player-box {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background-color: gray;
            display: inline-block;
        }
        .player-box.filled {
            background-color: green;
        }
        .lobby-card {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php" class="nav-link">Home</a>
    </nav>
    <div class="container">
        <h1 class="text-center my-4">Waiting Lobby</h1>

        <!-- Match Details -->
        <div class="lobby-card">
            <h2>Match ID: <?php echo $match_id?></h2>
            <p><strong>Arena Name:</strong> <?php echo $arena_name?></p>
            <p><strong>Location:</strong> <?php echo $arena_location?></p>
            <p><strong>Booked Time:</strong> <?php echo $booking_datetime?></p>
            <p><strong>Players:</strong> <span id="player-count"><?php echo $lobby_player_count?></span>/10</p>

            <!-- Player Boxes -->
            <div class="player-box-container" id="player-box-container"></div>

            <!-- Cancel Button -->
            <div class="cancel-button-container">
                
                <button type="submit" id="successButton" class="btn btn-success" onclick="redirect()">Home</button>
                
            </div>

            <!-- Home Button -->
            <div class="cancel-button-container">
                <button id="cancelButton" type="button" class="btn btn-danger" onclick="redirectWithPopup()">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="homeModal" tabindex="-1" aria-labelledby="homeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="homeModalLabel">Are you sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Cancel Matchmaking
                </div>
                <div class="modal-footer">
                    <form method="POST">
                    <button type="submit" class="btn btn-danger" id="proceedButton">OK</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function redirectWithPopup() {
            // Show the Bootstrap modal
            const modal = new bootstrap.Modal(document.getElementById('homeModal'), {
                backdrop: 'static', // Disable outside click
                keyboard: false    // Disable escape key
            });
            modal.show();

            // Redirect after user clicks 'OK'
            document.getElementById('proceedButton').addEventListener('click', function () {
                window.location.href = 'index.php';
            });
        }

        function redirect(){
            window.location.href = 'index.php';
        }

       

        // Variables (replace with dynamic data from your backend)
        const totalPlayers = 10;
        const currentPlayers = <?php echo htmlspecialchars($lobby_player_count);?>; // Example: 6 players joined out of 10

        // DOM Elements
        const playerBoxContainer = document.getElementById('player-box-container');

        // Populate the player boxes
        for (let i = 1; i <= totalPlayers; i++) {
            const box = document.createElement('div');
            box.classList.add('player-box');
            if (i <= currentPlayers) {
                box.classList.add('filled');
            }
            playerBoxContainer.appendChild(box);
        }
    </script>
</body>
</html>
