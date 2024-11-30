<?php
session_start();
include 'db.php';

// Check if referee is logged in
if (!isset($_SESSION['referee_id'])) {
    header("Location: refereeLogin.php");
    exit();
}

$referee_id = $_SESSION['referee_id'];
$match_id = $_GET['match_id'] ?? null; // Match ID from URL
$winning_team = $_GET['winning_team'] ?? null;
$team_a_name=$_GET['team_a_name'];
$team_b_name=$_GET['team_b_name'];

// Function to calculate team average ELO
function getTeamAverageElo($team_name, $match_id) {
    global $pdo;

    $query = "
        SELECT AVG(pp.elo) AS avg_elo
        FROM completed_match_participants cmp
        JOIN player_profiles pp ON cmp.user_id = pp.user_id
        WHERE cmp.team_name = ? AND cmp.match_id = ?
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$team_name, $match_id]);
    return $stmt->fetchColumn();
}

// Function to update player ELO
function updateElo($user_id, $elo_change) {
    global $pdo;

    $query = "
        UPDATE player_profiles
        SET elo = GREATEST(0, elo + ?) -- ELO cannot be negative
        WHERE user_id = ?
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([$elo_change, $user_id]);
}

// Calculate new ELO ratings
if ($winning_team && $match_id) {
    try {
        // Fetch average ELO for both teams
        $team_a_elo = getTeamAverageElo('team_A', $match_id);
        $team_b_elo = getTeamAverageElo('team_B', $match_id);

        // Expected results using the ELO formula
        $expected_team_a = 1 / (1 + pow(10, ($team_b_elo - $team_a_elo) / 400));
        $expected_team_b = 1 / (1 + pow(10, ($team_a_elo - $team_b_elo) / 400));

        // Define actual results based on the winning team
        $result_team_a = $winning_team === 'team_A' ? 1 : ($winning_team === 'team_B' ? 0 : 0.5);
        $result_team_b = $winning_team === 'team_B' ? 1 : ($winning_team === 'team_A' ? 0 : 0.5);

        // K-factor for ELO adjustment
        $k_factor = 32;

        // ELO changes
        $elo_change_team_a = $k_factor * ($result_team_a - $expected_team_a);
        $elo_change_team_b = $k_factor * ($result_team_b - $expected_team_b);

        // Update ELO for all players in each team
        $participant_query = "
            SELECT user_id, team_name
            FROM completed_match_participants
            WHERE match_id = ?
        ";
        $stmt = $pdo->prepare($participant_query);
        $stmt->execute([$match_id]);
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($participants as $participant) {
            $elo_change = $participant['team_name'] === 'team_A' ? $elo_change_team_a : $elo_change_team_b;
            updateElo($participant['user_id'], $elo_change);
        }

        echo "ELO ratings updated successfully.";
    } catch (Exception $e) {
        echo "Error updating ELO ratings: " . $e->getMessage();
    }
}
?>
