<?php
session_start();
include 'db.php';

//user and player id has been all mixed up in development at least in this page

function updatePlayerELO($player_id, $rating_category) {
    global $pdo;
    

    
    $player_elo_query = "SELECT elo FROM player_profiles WHERE user_id = :player_id";
    $player_elo_stmt = $pdo->prepare($player_elo_query);
    $player_elo_stmt->execute(['player_id' => $player_id]);
    $player = $player_elo_stmt->fetch(PDO::FETCH_ASSOC);
    $current_elo = $player['elo'];

    
    $rating_query = "SELECT points_adjustment FROM rating_values WHERE rating_category = :rating_category";
    $rating_stmt = $pdo->prepare($rating_query);
    $rating_stmt->execute(['rating_category' => $rating_category]);
    $rating = $rating_stmt->fetch(PDO::FETCH_ASSOC);
    $points_adjustment = $rating['points_adjustment'];

    
    $new_elo = max(0, $current_elo + $points_adjustment);

    
    $update_elo_query = "UPDATE player_profiles SET elo = :new_elo WHERE player_id = :player_id";
    $update_elo_stmt = $pdo->prepare($update_elo_query);
    $update_elo_stmt->execute(['new_elo' => $new_elo, 'player_id' => $player_id]);
    

    
   // $match_stats_query = "UPDATE player_match_stats SET updated_elo = :new_elo WHERE player_id = :player_id ORDER BY completed_match_id DESC LIMIT 1";
   // $match_stats_stmt = $pdo->prepare($match_stats_query);
   // $match_stats_stmt->execute(['new_elo' => $new_elo, 'player_id' => $player_id]);
}





function updatePlayerRanking($player_id) {
    global $pdo;

    
    $elo_query = "SELECT elo FROM player_profiles WHERE player_id = :player_id";
    $elo_stmt = $pdo->prepare($elo_query);
    $elo_stmt->execute(['player_id' => $player_id]);
    $player = $elo_stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($player) {
        $elo = $player['elo'];

        
        if ($elo >= 0 && $elo <= 499) {
            $ranking = 'beginner';
        } elseif ($elo >= 500 && $elo <= 999) {
            $ranking = 'amateur';
        } elseif ($elo >= 1000) {
            $ranking = 'pro';
        }

        
        $update_ranking_query = "UPDATE player_profiles SET player_ranking = :ranking WHERE player_id = :player_id";
        $update_ranking_stmt = $pdo->prepare($update_ranking_query);
        $update_ranking_stmt->execute(['ranking' => $ranking, 'player_id' => $player_id]);

        echo "Player ranking updated successfully!";
    } else {
        echo "Player not found!";
    }
}


$player_id = 1; 
//updatePlayerRanking($player_id);
?>
