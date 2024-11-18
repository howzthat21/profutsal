<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: login.php");
    exit();

}
if(isset($_GET['username'])){
  $username=$_GET['username'];
}

if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];
  $fetch_player_details = "SELECT age, preferred_position, games_played, wins, losses, bio, player_ranking
                         FROM player_profiles 
                         WHERE user_id = :user_id";

// Prepare the statement
$fetch_player_details_stmt = $pdo->prepare($fetch_player_details);

// Bind the user_id parameter to the query
$fetch_player_details_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

// Execute the query
$fetch_player_details_stmt->execute();

// Fetch the player profile details as an associative array
$player_details = $fetch_player_details_stmt->fetch(PDO::FETCH_ASSOC);

// Check if player details were found
if ($player_details) {
    // Extract individual values
    $age = $player_details['age'];
    $preferred_position = $player_details['preferred_position'];
    $games_played = $player_details['games_played'];
    $wins = $player_details['wins'];
    $losses = $player_details['losses'];
    $bio = $player_details['bio'];
    $player_ranking = $player_details['player_ranking'];

    // You can now use these values as needed in your application
} else {
    echo "Player profile not found!";
}

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Player Profile - Futsal Matchmaking</title>
  <link rel="stylesheet" href="profile.css">
</head>
<body>
  <!-- Navigation with Profile and Logout/Exit -->
  <nav class="profile-nav">
    <div class="player-info">
      <span class="player-name"><?php echo $username;?></span>
    </div>
    <div class="nav-buttons">
      <a href="joincreate.html" class="close-btn" title="Back to Home">&times;</a>
    </div>
  </nav>

  <!-- Main Profile Section -->
  <div class="profile-container">
    <h2>Player Profile</h2>
    
    <!-- Player Summary -->
    <div class="player-summary">
      <div class="stat">
        <h3>Wins</h3>
        <p><?php echo $wins;?></p>
      </div>
      <div class="stat">
        <h3>Losses</h3>
        <p><?php echo $losses;?></p>
      </div>
      <div class="stat">
        <h3>Matches Played</h3>
        <p><?php echo $games_played;?></p>
      </div>
      <div class="stat">
        <h3>Ranking</h3>
        <p><?php echo $player_ranking;?></p>
      </div>
    </div>

    <!-- Match History -->
    <div class="match-history">
      <h3>Recent Matches</h3>
      <div class="match-card">
        <p><strong>Match:</strong> Super Futsal Arena</p>
        <p><strong>Date:</strong> 2024-11-10</p>
        <p><strong>Time:</strong> 6:00 PM - 7:00 PM</p>
        <p><strong>Result:</strong> Win</p>
      </div>
      <div class="match-card">
        <p><strong>Match:</strong> Elite Futsal Hub</p>
        <p><strong>Date:</strong> 2024-11-08</p>
        <p><strong>Time:</strong> 8:00 PM - 9:00 PM</p>
        <p><strong>Result:</strong> Loss</p>
      </div>
      <!-- Additional match cards as needed -->
    </div>
  </div>
</body>
</html>
