<?php
include 'db.php';

$query = "SELECT user_id, elo FROM player_profiles";
$query_stmt = $pdo->query($query);
$results = $query_stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $result) {
    $elo = $result['elo'];
    $user_id = $result['user_id'];
    if ($elo >= 0 && $elo <= 499) {
        $ranking = 'beginner';
    } elseif ($elo >= 500 && $elo <= 999) {
        $ranking = 'amateur';
    } elseif ($elo >= 1000) {
        $ranking = 'pro';
    }

    // Ensure the update is specific to the current user_id
    $update_ranking_query = "UPDATE player_profiles SET player_ranking = :ranking WHERE user_id = :user_id";
    $update_ranking_stmt = $pdo->prepare($update_ranking_query);
    $update_ranking_stmt->execute(['ranking' => $ranking, 'user_id' => $user_id]);

    
}
?>
