<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$player_id = $_SESSION['user_id'];
$match_id = $_GET['match_id'];

// Check if the player is already in the match
$check_query = "SELECT * FROM matchmaking WHERE match_id = ? AND player_count < max_players AND status IN ('pending')";
$check_stmt = $pdo->prepare($check_query);
$check_stmt->execute([$match_id]);
$match = $check_stmt->fetch();

if ($match) {
    // Update the player count
    $update_query = "UPDATE matchmaking SET player_count = player_count + 1 WHERE match_id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$match_id]);

    $participant_query = "INSERT INTO match_participants (match_id, user_id) VALUES (?, ?)";
    $participant_stmt = $pdo->prepare($participant_query);
    $participant_stmt->execute([$match_id, $player_id]);

    // Check if lobby is now full
    if ($match['player_count'] + 1 >= $match['max_players']) {
        // Update status to fulltime
        $status_query = "UPDATE matchmaking SET status = 'lineups' WHERE match_id = ?";
        $status_stmt = $pdo->prepare($status_query);
        $status_stmt->execute([$match_id]);
    }

    echo "<p>Successfully joined the lobby!</p>";
    echo "<a href='matchmakingarena.php'>Back to lobbies</a>";
} else {
    echo "<p>Lobby is full or no longer available.</p>";
}
?>
