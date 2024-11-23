<?php
include 'db.php'; // Include database connection

// Fetch match ID from query parameter
$match_id = $_GET['match_id'] ?? null;

if (!$match_id) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Match ID is required."]);
    exit;
}

// Fetch match details (e.g., scores)
$match_query = "
    SELECT 
        m.team_a_score AS teamAScore, 
        m.team_b_score AS teamBScore 
    FROM completed_matches m
    WHERE m.match_id = ?
";
$stmt = $pdo->prepare($match_query);
$stmt->execute([$match_id]);
$match = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$match) {
    header('Content-Type: application/json');
    echo json_encode(["error" => "Match not found."]);
    exit;
}

// Fetch players grouped by team
$players_query = "
    SELECT 
        cmp.team_name, 
        u.username 
    FROM completed_match_participants cmp
    JOIN users u ON cmp.user_id = u.id
    WHERE cmp.match_id = ?
    ORDER BY cmp.team_name, u.username
";
$stmt = $pdo->prepare($players_query);
$stmt->execute([$match_id]);
$players = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_COLUMN);

// Prepare JSON response
$response = [
    'teamAName' => array_keys($players)[0] ?? "Team A",
    'teamAScore' => $match['teamAScore'],
    'teamAPlayers' => $players[array_keys($players)[0]] ?? [],
    'teamBName' => array_keys($players)[1] ?? "Team B",
    'teamBScore' => $match['teamBScore'],
    'teamBPlayers' => $players[array_keys($players)[1]] ?? []
];

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
