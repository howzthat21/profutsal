<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$player_id = $_SESSION['user_id'];


$fetch_match_sql = "SELECT match_id FROM match_participants WHERE user_id = :player_id";
$fetch_match_stmt = $pdo->prepare($fetch_match_sql);
$fetch_match_stmt->execute(['player_id' => $player_id]);


$match = $fetch_match_stmt->fetch(PDO::FETCH_ASSOC);
if ($match) {
    $match_id = $match['match_id']; 

    
    $participants_sql = "
        SELECT u.username 
        FROM match_participants mp
        JOIN users u ON mp.user_id = u.id
        WHERE mp.match_id = :match_id
    ";
    
    
    $participants_stmt = $pdo->prepare($participants_sql);
    $participants_stmt->execute(['match_id' => $match_id]);

    
    $participants = [];
    while ($participant = $participants_stmt->fetch(PDO::FETCH_ASSOC)) {
        $participants[] = $participant['username'];
    }

    
    shuffle($participants);

    
    $teamA = [];
    $teamB = [];
    foreach ($participants as $index => $username) {
        if ($index % 2 === 0) {
            $teamA[] = $username;
        } else {
            $teamB[] = $username;
        }
    }

    
    echo "<h2>Participants in Match ID: $match_id</h2>";
    echo "<p>Total Players: " . count($participants) . "</p>";

    echo "<h3>Team A</h3>";
    echo "<ul>";
    foreach ($teamA as $username) {
        echo "<li>" . htmlspecialchars($username) . "</li>";
    }
    echo "</ul>";

    echo "<h3>Team B</h3>";
    echo "<ul>";
    foreach ($teamB as $username) {
        echo "<li>" . htmlspecialchars($username) . "</li>";
    }
    echo "</ul>";
    
} else {
    echo "<p>You are not currently in any match.</p>";
}
?>
