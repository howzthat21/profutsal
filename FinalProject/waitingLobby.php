<?php

include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$user_id=$_SESSION['user_id'];

$fetch_waiting_lobby= "SELECT mp.match_id 
    FROM match_participants mp
    JOIN users u ON mp.user_id = u.id
    WHERE mp.match_id NOT IN (
        SELECT match_id FROM completed_matches
    ) AND mp.user_id = ?";
$fetch_waiting_lobby_stmt= $pdo->prepare($fetch_waiting_lobby);
$fetch_waiting_lobby_stmt->execute([$user_id]);
$waiting_lobby=$fetch_waiting_lobby_stmt->fetch(PDO::FETCH_ASSOC);
if(!$waiting_lobby){
    echo "you are not in a lobby";
    header("Location: index.php");

}

$match_id=$waiting_lobby['match_id'];

$fetch_info= "SELECT match_id, arena_id, booking_datetime, player_count from matchmaking where match_id = ? ";
$fetch_info_stmt=$pdo->prepare($fetch_info);
$fetch_info_stmt->execute([$match_id]);
$lobby_view= $fetch_info_stmt->fetch(PDO:: FETCH_ASSOC); 

$match_id_lobby=$lobby_view['match_id'];
$arena_id= $lobby_view['arena_id'];
$booking_datetime= $lobby_view['booking_datetime'];
$lobby_player_count = $lobby_view['player_count'];

echo $match_id_lobby;
echo $arena_id;
echo $booking_datetime;
echo $lobby_player_count;

$fetch_arena_details= "SELECT arena_name, arena_location from arenas where arena_id = ?";
$fetch_arena_details_stmt = $pdo->prepare($fetch_arena_details);
$fetch_arena_details_stmt->execute([$arena_id]);
$fetch_arena=$fetch_arena_details_stmt->fetch(PDO::FETCH_ASSOC);

$arena_name= $fetch_arena['arena_name'];
$arena_location = $fetch_arena['arena_location'];






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
    <nav>
        <a href="index.php" class="nav-link">Home</a>
    </nav>
    <div class="container">
        <h1 class="text-center my-4">Waiting Lobby</h1>
        
        <!-- Match Details -->
        <div class="lobby-card">
            <h2>Match ID: <?php echo $match_id_lobby?></h2>
            <p><strong>Arena Name:</strong> <?php echo $arena_name?></p>
            <p><strong>Location:</strong> <?php echo $arena_location?></p>
            <p><strong>Booked Time:</strong> <?php echo $booking_datetime?></p>
            <p><strong>Players:</strong> <span id="player-count"><?php echo $lobby_player_count?></span>/10</p>

            <!-- Player Boxes -->
            <div class="player-box-container" id="player-box-container">
                <!-- Boxes will be dynamically filled using JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Variables (replace with dynamic data from your backend)
        const totalPlayers = 10;
        const currentPlayers = <?php echo htmlspecialchars($lobby_player_count);?> // Example: 6 players joined out of 10

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
