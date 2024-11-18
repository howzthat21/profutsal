<?php
include 'db.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// arena haru fetch gareko
$query = "
    SELECT 
        matchmaking.match_id as match_id, 
        matchmaking.arena_id, 
        matchmaking.player_count as player_count, 
        matchmaking.max_players,
        matchmaking.booking_datetime as booking_datetime,
        matchmaking.status, 
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
        matchmaking.status IN ('pending') 
        AND matchmaking.player_count < matchmaking.max_players";

$stmt = $pdo->query($query);
$available_lobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join a Team - Futsal Matchmaking</title>
  <link rel="stylesheet" href="joinateam.css">
</head>
<body>
  <!-- Main Container -->
  <div class="join-team-page">
    
    <!-- Header with Logo -->
    <a href="joincreate.html" class="close-btn" title="Back to Home">&times;</a>
    <header class="header">
      <h1 class="logo">Futsal Matchmaking</h1>
    </header>

    <!-- Page Title -->
    <section class="title-section">
      <h2>Available Arenas</h2>
      <p>Browse and join a team at your favorite futsal arena!</p>
    </section>

    <!-- Lobby List -->
    <div class="lobby-container">
      <?php if (!empty($available_lobbies)): ?>
        <?php foreach ($available_lobbies as $lobby): ?>
          <div class="lobby-card">
            <img src="arena<?php echo htmlspecialchars($lobby['arena_id']); ?>.jpg" alt="Arena Image" class="arena-image">
            <div class="lobby-info">
              <h3>Arena Name: <?php echo htmlspecialchars($lobby['arena_name']); ?></h3>
              <h3>Arena Name: <?php echo htmlspecialchars($lobby['match_id']); ?></h3>
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

    <!-- Footer with Social Media Links -->
    <footer class="footer">
      <p>Connect with us on social media:</p>
      <div class="social-links">
        <a href="https://facebook.com" class="social-icon" target="_blank">
          <!-- Add Facebook Icon -->
        </a>
        <a href="https://instagram.com" class="social-icon" target="_blank">
          <!-- Add Instagram Icon -->
        </a>
        <a href="https://twitter.com" class="social-icon" target="_blank">
          <!-- Add Twitter Icon -->
        </a>
        <a href="https://twitch.tv" class="social-icon" target="_blank">
          <!-- Add Twitch Icon -->
        </a>
        <a href="https://store.steampowered.com" class="social-icon" target="_blank">
          <!-- Add Steam Icon -->
        </a>
      </div>
    </footer>
  </div>
</body>
</html>
