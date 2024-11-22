<?php

session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$player_id = $_SESSION['user_id'];
$match_id = $_GET['match_id'];


$check_query = "SELECT * FROM matchmaking WHERE match_id = ? AND player_count < max_players AND status IN ('pending')";
$check_stmt = $pdo->prepare($check_query);
$check_stmt->execute([$match_id]);
$match = $check_stmt->fetch();

if ($match) {
    
    $update_query = "UPDATE matchmaking SET player_count = player_count + 1 WHERE match_id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$match_id]);

    $participant_query = "INSERT INTO match_participants (match_id, user_id) VALUES (?, ?)";
    $participant_stmt = $pdo->prepare($participant_query);
    $participant_stmt->execute([$match_id, $player_id]);
    

    

    
    if ($match['player_count'] + 1 >= $match['max_players']) {
        
        $status_query = "UPDATE matchmaking SET status = 'lineups' WHERE match_id = ?";
        $status_stmt = $pdo->prepare($status_query);
        $status_stmt->execute([$match_id]);

        $fetch_referee = "SELECT * FROM referee WHERE status = 'unassigned'";
        $fetch_referee_stmt = $pdo->prepare($fetch_referee);
        $fetch_referee_stmt->execute();
        $referee = $fetch_referee_stmt->fetch(PDO::FETCH_ASSOC);
        $referee_id = $referee['referee_id'];
        
        $insert_query = "INSERT INTO referee_matches (match_id, referee_id) VALUES (?, ?)";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([$match_id, $referee_id]);

        if($insert_stmt->rowCount()> 0){
            $update_query = "UPDATE referee SET status = 'assigned' WHERE referee_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update_stmt->execute([$referee_id]);
        }

    }

    echo "<p>Successfully joined the lobby!</p>";
    echo "<a href='matchmakingarena.php'>Back to lobbies</a>";
} else {
    echo "<p>Lobby is full or no longer available.</p>";
}
?>
