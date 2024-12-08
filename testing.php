<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}
$player_id=$_SESSION['user_id'];


$fetch_my_rank_query="SELECT player_ranking from player_profiles where user_id=?";
$fetch_my_rank_stmt=$pdo->prepare($fetch_my_rank_query);
$fetch_my_rank_stmt->execute([$player_id]);
$fetch_rank=$fetch_my_rank_stmt->fetch();
$player_rank=$fetch_rank['player_ranking'];
echo $player_rank;


$query = "
    SELECT 
        matchmaking.match_id as match_id, 
        matchmaking.arena_id, 
        matchmaking.player_count as player_count, 
        matchmaking.max_players,
        matchmaking.booking_datetime as booking_datetime,
        matchmaking.status,
        matchmaking.player_ranking, 
        arenas.arena_name AS arena_name, 
        arenas.contact_info as contact_info,
        arenas.arena_image AS arena_image,
        arenas.arena_location as arena_location,
        arenas.location_link as location_link
        
    FROM 
        matchmaking
    JOIN 
        arenas 
    ON 
        matchmaking.arena_id = arenas.arena_id
    WHERE 
        matchmaking.player_ranking=?
        AND matchmaking.status IN ('pending') 
        AND matchmaking.player_count < matchmaking.max_players";

$stmt = $pdo->prepare($query);
$stmt->execute([$player_rank]);
$available_lobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="lobby-container">
      <?php if (!empty($available_lobbies)): ?>
        <?php foreach ($available_lobbies as $lobby): ?>
          <div class="lobby-card">
            <img src="arena<?php echo htmlspecialchars($lobby['arena_id']); ?>.jpg" alt="Arena Image" class="arena-image">
            <div class="lobby-info">
              <h3>Arena Name: <?php echo htmlspecialchars($lobby['arena_name']); ?></h3>
              <h3>Match_id: <?php echo htmlspecialchars($lobby['match_id']); ?></h3>
              <p>Status: <?php echo htmlspecialchars($lobby['status']); ?></p>
              <p>Players: <?php echo htmlspecialchars($lobby['player_count'] . '/' . $lobby['max_players']); ?></p>
              <p>Location: <?php echo htmlspecialchars($lobby['arena_location']); ?></p>
              <p>Contact Info: <?php echo htmlspecialchars($lobby['contact_info']); ?></p>
              <p class="match-time">Time: <strong><?php
$datetime = new DateTime($lobby['booking_datetime']);
echo htmlspecialchars($datetime->format('F j, Y, g:i A')); // Example: November 16, 2024, 2:30 PM
?></strong></p>
            </div>
            <form action="join_match.php?match_id=<?php echo htmlspecialchars($lobby['match_id'])?>" method="POST">
              <input type="hidden" name="match_id" value="<?php echo htmlspecialchars($lobby['match_id']); ?>">
              <button type="submit" class="join-button">Join</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No available lobbies at the moment. Please check back later.</p>
      <?php endif; ?>
    </div>
    
    
</body>
</html>