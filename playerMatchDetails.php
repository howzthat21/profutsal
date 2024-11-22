<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

$player_id = $_SESSION['user_id'];

echo $player_id;
// this needs to be inside the if condition where matchmaking status set to lineups then execute else wait
//and the player count system would be added to the waiting lobby hence it does not need full players.



$fetch_match_sql = "SELECT match_id FROM match_participants WHERE user_id = :player_id";
$fetch_match_stmt = $pdo->prepare($fetch_match_sql);
$fetch_match_stmt->execute(['player_id' => $player_id]);


$match = $fetch_match_stmt->fetch(PDO::FETCH_ASSOC);
if ($match) {
    $match_id = $match['match_id']; 

    // Fetch participants by match_id
    $participants_sql = "
        SELECT u.username 
        FROM match_participants mp
        JOIN users u ON mp.user_id = u.id
        WHERE mp.match_id = :match_id
    ";

    $participants_stmt = $pdo->prepare($participants_sql);
    $participants_stmt->execute(['match_id' => $match_id]);

    // Store usernames in an array
    $participants = [];
    while ($participant = $participants_stmt->fetch(PDO::FETCH_ASSOC)) {
        $participants[] = $participant['username'];
    }

    // Shuffle and divide participants into two teams
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

    // Randomly select team names from usernames
    $teamAName = $teamA[array_rand($teamA)];
    $teamBName = $teamB[array_rand($teamB)];

    // Prepare the SQL query for updating team names
    $updateQuery = "
        UPDATE match_participants 
        SET team_name = CASE 
            WHEN user_id IN (
                SELECT u.id 
                FROM users u 
                WHERE u.username IN (" . implode(',', array_fill(0, count($teamA), '?')) . ")
            ) THEN ?
            WHEN user_id IN (
                SELECT u.id 
                FROM users u 
                WHERE u.username IN (" . implode(',', array_fill(0, count($teamB), '?')) . ")
            ) THEN ?
        END
        WHERE match_id = ?
    ";

    // Flatten the usernames and add team names and match_id to the data array
    $dataToBind = array_merge($teamA, [$teamAName], $teamB, [$teamBName], [$match_id]);

    // Prepare and execute the update statement
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute($dataToBind);

    echo "Team names updated successfully!";
}

?>
