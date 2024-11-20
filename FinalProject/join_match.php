<?php
session_start();
include 'db.php';

include '../matchmakingstatusupdate.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$player_id = $_SESSION['user_id'];
$match_id = $_GET['match_id'];

//fetch the available lobbies
$check_query = "SELECT * FROM matchmaking WHERE match_id = ? AND player_count < max_players AND status IN ('pending')";
$check_stmt = $pdo->prepare($check_query);
$check_stmt->execute([$match_id]);
$match = $check_stmt->fetch();

//if true then set the player and update garr
if ($match) {
    
    $update_query = "UPDATE matchmaking SET player_count = player_count + 1 WHERE match_id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$match_id]);

    $participant_query = "INSERT INTO match_participants (match_id, user_id) VALUES (?, ?)";
    $participant_stmt = $pdo->prepare($participant_query);
    $participant_stmt->execute([$match_id, $player_id]);

    //lobby full bhayo bhane available lobbies baata hatcha, full bhaisake pachi chai matchmaking ko status pending baata lineups maa send garcha
    if ($match['player_count'] + 1 >= $match['max_players']) {
        
        $status_query = "UPDATE matchmaking SET status = 'lineups' WHERE match_id = ?";
        $status_stmt = $pdo->prepare($status_query);
        $status_stmt->execute([$match_id]);

        $fetch_referee_details="SELECT * from referee where status = 'unassigned'";
        $fetch_referee_details_stmt= $pdo->prepare($fetch_referee_details);
        $fetch_referee_details_stmt->execute();
        $referee=$fetch_referee_details_stmt->fetch(PDO::FETCH_ASSOC);
        $referee_id=$referee['referee_id'];

        $assign_referee="INSERT INTO referee_matches(match_id, referee_id) VALUES(?,?)";
        $assign_referee_stmt= $pdo->prepare($assign_referee);
        $assign_referee_stmt->execute([$match_id, $referee_id ]);
        

        
    }

    echo "<p>Successfully joined the lobby!</p>";
    echo "<a href='matchmakingarena.php'>Back to lobbies</a>";
} else {
    echo "<p>Lobby is full or no longer available.</p>";
}
?>
