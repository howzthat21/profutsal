<?php

session_start(); 


if (!isset($_SESSION['user_id'])) { 
    
    header("Location: login.php");
    exit();
}
include 'db.php';
include 'matchmakingstatusupdate.php';

$user_id= $_SESSION['user_id'];

$check_user_query="SELECT participant_id from match_participants where user_id =  ?";
$check_user_query_stmt= $pdo->prepare($check_user_query);
$check_user_query_stmt->execute([$user_id]);
$user_exist=$check_user_query_stmt->fetchColumn();

if($user_exist>0){
    header("Location: index.php");
    exit();
}


$query = "SELECT match_id, arena_id, player_count, max_players, status FROM matchmaking WHERE status IN ('pending') AND player_count < max_players";
$stmt = $pdo->query($query);
$available_lobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($available_lobbies) {
    foreach ($available_lobbies as $lobby) {
        echo "<div>";
        echo "<h4>Arena ID: " . htmlspecialchars($lobby['arena_id']) . "</h4>";
        echo "<p>Status: " . htmlspecialchars($lobby['status']) . "</p>";
        echo "<p>Players: " . htmlspecialchars($lobby['player_count']) . " / " . htmlspecialchars($lobby['max_players']) . "</p>";
        echo "<a href='joinmatch.php?match_id=" . urlencode($lobby['match_id']) . "'>Join Lobby</a>";
        echo "</div>";
    }
} else {
    echo "<p>No available lobbies at the moment.</p>";
}
updateMatchmakingStatus($pdo);

?>
