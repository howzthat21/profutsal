<?php
include 'db.php';

function updatePlayerELO($player_id, $rating_category) {
    global $pdo;

    // 1. Fetch the current ELO of the player
    $player_elo_query = "SELECT elo FROM player_profiles WHERE player_id = :player_id";
    $player_elo_stmt = $pdo->prepare($player_elo_query);
    $player_elo_stmt->execute(['player_id' => $player_id]);
    $player = $player_elo_stmt->fetch(PDO::FETCH_ASSOC);
    $current_elo = $player['elo'];

    // 2. Get the points adjustment based on the referee rating
    $rating_query = "SELECT points_adjustment FROM rating_values WHERE rating_category = :rating_category";
    $rating_stmt = $pdo->prepare($rating_query);
    $rating_stmt->execute(['rating_category' => $rating_category]);
    $rating = $rating_stmt->fetch(PDO::FETCH_ASSOC);
    $points_adjustment = $rating['points_adjustment'];

    // 3. Calculate the new ELO, ensuring minimum 0 for Beginner range
    $new_elo = max(0, $current_elo + $points_adjustment);

    // 4. Update the player's ELO in the player_profiles table
    $update_elo_query = "UPDATE player_profiles SET elo = :new_elo WHERE player_id = :player_id";
    $update_elo_stmt = $pdo->prepare($update_elo_query);
    $update_elo_stmt->execute(['new_elo' => $new_elo, 'player_id' => $player_id]);
    

    // 5. Store the updated ELO in player_match_stats (or similar)
    $match_stats_query = "UPDATE player_match_stats SET updated_elo = :new_elo WHERE player_id = :player_id ORDER BY completed_match_id DESC LIMIT 1";
    $match_stats_stmt = $pdo->prepare($match_stats_query);
    $match_stats_stmt->execute(['new_elo' => $new_elo, 'player_id' => $player_id]);
}

// Example usage:
$player_id = 1; // Player ID
$rating_category = 'Amateur'; // Rating given by referee
updatePlayerELO($player_id, $rating_category);


function updatePlayerRanking($player_id) {
    global $pdo;

    // Fetch the player's current elo from the player_profiles table
    $elo_query = "SELECT elo FROM player_profiles WHERE player_id = :player_id";
    $elo_stmt = $pdo->prepare($elo_query);
    $elo_stmt->execute(['player_id' => $player_id]);
    $player = $elo_stmt->fetch(PDO::FETCH_ASSOC);

    // Check if player exists
    if ($player) {
        $elo = $player['elo'];

        // Set the player ranking based on the elo
        if ($elo >= 0 && $elo <= 499) {
            $ranking = 'beginner';
        } elseif ($elo >= 500 && $elo <= 999) {
            $ranking = 'amateur';
        } elseif ($elo >= 1000) {
            $ranking = 'pro';
        }

        // Update the player's ranking in the player_profiles table
        $update_ranking_query = "UPDATE player_profiles SET player_ranking = :ranking WHERE player_id = :player_id";
        $update_ranking_stmt = $pdo->prepare($update_ranking_query);
        $update_ranking_stmt->execute(['ranking' => $ranking, 'player_id' => $player_id]);

        echo "Player ranking updated successfully!";
    } else {
        echo "Player not found!";
    }
}

// Example usage - replace with the actual player ID
$player_id = 1; // Replace with the actual player ID
updatePlayerRanking($player_id);
?>
