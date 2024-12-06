<?php

include 'db.php';

$fetch_match_id= "SELECT match_id from matchmaking where status='lineups'";
$fetch_match_id_stmt= $pdo->query($fetch_match_id);



while($match=$fetch_match_id_stmt->fetch(PDO::FETCH_ASSOC)){
    $match_id=$match['match_id'];

    $participants_sql = "
        SELECT u.username 
        FROM match_participants mp
        JOIN users u ON mp.user_id = u.id
        WHERE mp.match_id = :match_id and mp.team_name='not assigned a team'";
    

    $participants_stmt = $pdo->prepare($participants_sql);
    $participants_stmt->execute(['match_id' => $match_id]);
    try{

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

    $_SESSION['teamAName'] = $teamAName;
    $_SESSION['teamBName'] = $teamBName;
    if(isset($_SESSION['teamAName']) && isset($_SESSION['teamBName'])){
        echo "Team A: " . $_SESSION['teamAName'];
        echo "Team B: " . $_SESSION['teamBName'];
    }
    else{
        echo "session not started";
    }
    
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


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}





/*if ($match) {
    $match_id = $match['match_id']; 

    // Fetch participants by match_id
    $participants_sql = "
        SELECT u.username 
        FROM match_participants mp
        JOIN users u ON mp.user_id = u.id
        WHERE mp.match_id = 68 and mp.team_name='not assigned a team'";
    

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

    $_SESSION['teamAName'] = $teamAName;
    $_SESSION['teamBName'] = $teamBName;
    if(isset($_SESSION['teamAName']) && isset($_SESSION['teamBName'])){
        echo "Team A: " . $_SESSION['teamAName'];
        echo "Team B: " . $_SESSION['teamBName'];
    }
    else{
        echo "session not started";
    }
    
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
else{
    echo "No match found for the player.";
}
?>
*/
?>
