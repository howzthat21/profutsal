<?php
session_start();
include 'db.php';

//include '../matchmakingstatusupdate.php';


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


//checking if the user_id

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

        if($status_stmt){
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

    // Debug here. Most likely problem it has
//issues in the match_id, check if it gets valid match id from the url
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
        }

        $fetch_referee_details="SELECT * from referee where status = 'unassigned'";
        $fetch_referee_details_stmt= $pdo->prepare($fetch_referee_details);
        $fetch_referee_details_stmt->execute();
        $referee=$fetch_referee_details_stmt->fetch(PDO::FETCH_ASSOC);
        $referee_id=$referee['referee_id'];

        $assign_referee="INSERT INTO referee_matches(match_id, referee_id) VALUES(?,?)";
        $assign_referee_stmt= $pdo->prepare($assign_referee);
        $assign_referee_stmt->execute([$match_id, $referee_id ]);
        

        
    }
    header("Location: waitinglobby.php");

    echo "<p>Successfully joined the lobby!</p>";
    echo "<a href='matchmakingarena.php'>Back to lobbies</a>";
    exit();
} else {
    echo "<p>Lobby is full or no longer available.</p>";
}
?>
