<?php
include  'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id= $_SESSION['user_id'];
/*things to display:
match_id from the matchmaking table
location from the arena table
booked time from the matchmaking table
player count from the matchmaking table
 */

 $fetch_match_participant_info="SELECT match_id from match_participants where user_id=?";
 $fetch_match_participant_info_stmt= $pdo->prepare($fetch_match_participant_info);
 $fetch_match_participant_info_stmt->execute([$user_id]);
 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Lobby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container">
        <h1 class="text-center my-4">Waiting Lobby</h1>
        
        <!-- Match Details -->
        <div class="lobby-card">
            <h2>Match ID: 12345</h2>
            <p><strong>Arena Name:</strong> Galaxy Futsal Arena</p>
            <p><strong>Location:</strong> New York City</p>
            <p><strong>Booked Time:</strong> November 21, 2024, 2:00 PM</p>
            <p><strong>Players:</strong> <span id="player-count">6</span>/10</p>

            <!-- Player Boxes -->
            <div class="player-box-container" id="player-box-container">
                <!-- Boxes will be dynamically filled using JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Variables (replace with dynamic data from your backend)
        const totalPlayers = 10;
        const currentPlayers = 6; // Example: 6 players joined out of 10

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
