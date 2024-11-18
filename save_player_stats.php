<?php
include 'db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $match_id = $_POST['match_id'];
    
    
    $player_ids = $_POST['player_ids'];
    $ratings = $_POST['ratings'];
    $goals = $_POST['goals'];
    $assists = $_POST['assists'];
    $fouls = $_POST['fouls'];

    echo $player_ids;
    
    $insert_sql = "
        INSERT INTO player_match_stats (match_id, user_id, rating, goals, assists, fouls) 
        VALUES (:match_id, :user_id, :rating, :goals, :assists, :fouls)
    ";
    $stmt = $pdo->prepare($insert_sql);

    
    for ($i = 0; $i < count($player_ids); $i++) {
        
        $stmt->execute([
            'match_id' => $match_id,
            'user_id' => $player_ids[$i],
            'rating' => $ratings[$i],
            'goals' => $goals[$i],
            'assists' => $assists[$i],
            'fouls' => $fouls[$i]
        ]);
    }

    
    echo "Player stats successfully saved!";
}
?>
