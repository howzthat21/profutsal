<?php
include 'db.php'; // Include the database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve match_id from the form
    $match_id = $_POST['match_id'];
    
    // Retrieve player stats arrays from the form
    $player_ids = $_POST['player_ids'];
    $ratings = $_POST['ratings'];
    $goals = $_POST['goals'];
    $assists = $_POST['assists'];
    $fouls = $_POST['fouls'];

    echo $player_ids;
    // Prepare SQL statement to insert player stats into player_match_stats table
    $insert_sql = "
        INSERT INTO player_match_stats (match_id, user_id, rating, goals, assists, fouls) 
        VALUES (:match_id, :user_id, :rating, :goals, :assists, :fouls)
    ";
    $stmt = $pdo->prepare($insert_sql);

    // Loop through each player's data
    for ($i = 0; $i < count($player_ids); $i++) {
        // Bind values and execute the insertion
        $stmt->execute([
            'match_id' => $match_id,
            'user_id' => $player_ids[$i],
            'rating' => $ratings[$i],
            'goals' => $goals[$i],
            'assists' => $assists[$i],
            'fouls' => $fouls[$i]
        ]);
    }

    // Redirect to a success page or display a success message
    echo "Player stats successfully saved!";
}
?>
