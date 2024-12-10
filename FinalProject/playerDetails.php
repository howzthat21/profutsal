
<?php
include 'db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$player_id = $_SESSION['user_id'];

$fetch_match_sql = "SELECT mp.match_id, mp.user_id, u.username 
    FROM match_participants mp
    JOIN users u ON mp.user_id = u.id
    WHERE mp.match_id NOT IN (
        SELECT match_id FROM completed_matches
    ) AND mp.user_id = :player_id";
$fetch_match_stmt = $pdo->prepare($fetch_match_sql);
$fetch_match_stmt->execute(['player_id' => $player_id]);

$match = $fetch_match_stmt->fetch(PDO::FETCH_ASSOC);

$matchId=$match['match_id'];

$teamQuery = "
    SELECT 
        mp.team_name, 
        GROUP_CONCAT(u.username SEPARATOR ', ') AS team_members
    FROM 
        match_participants mp
    JOIN 
        users u ON mp.user_id = u.id
    WHERE 
        mp.match_id = :match_id
    GROUP BY 
        mp.team_name
";

// Prepare and execute the query
$teamStmt = $pdo->prepare($teamQuery);
$teamStmt->execute(['match_id' => $matchId]);

// Fetch the results
$teams = $teamStmt->fetchAll(PDO::FETCH_ASSOC);

// Display the teams and their members
/*foreach ($teams as $team) {
    echo "<h3>Team: " . htmlspecialchars($team['team_name']) . "</h3>";
    echo "<p>Members: " . htmlspecialchars($team['team_members']) . "</p>";
}
    */


//fetching arena details to display
$fetch_arena_id="SELECT arena_id, booking_datetime from matchmaking where match_id= ?";
$fetch_arena_id_stmt=$pdo->prepare($fetch_arena_id);
$fetch_arena_id_stmt->execute([$matchId]);
$arena_details=$fetch_arena_id_stmt->fetch(PDO::FETCH_ASSOC);
$arena_id=$arena_details['arena_id'];
$booking_datetime=$arena_details['booking_datetime'];

//creating object for the date
 $date_object= new DateTime($booking_datetime);
 $formatted_date = $date_object->format('l, F j, Y g:i A');


$fetch_arena_details="SELECT * from arenas where arena_id= ?";
$fetch_arena_details_stmt=$pdo->prepare($fetch_arena_details);
$fetch_arena_details_stmt->execute([$arena_id]);
$arena_details=$fetch_arena_details_stmt->fetch(PDO::FETCH_ASSOC);
$arena_name=$arena_details['arena_name'];
$arena_location=$arena_details['arena_location'];
$arena_image=$arena_details['arena_image'];
$arena_contact_info=$arena_details['contact_info'];



//fet

if(!$match){
    header("Location: index.php");
}
$booking_datetimetry = "2024-11-21 14:30:00";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="projfutsal/futsalground.css">
  <title>Futsal Ground</title>
  
    <script>
        // Booking datetime from PHP
        const bookingDatetime = new Date("<?=$booking_datetime?>").getTime();

        // Function to update the countdown
        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = bookingDatetime - now;

            if (timeLeft > 0) {
                // Calculate days, hours, minutes, and seconds
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Display the timer
                document.getElementById("timer").innerHTML =
                    `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                // Timer has reached zero
                document.getElementById("timer").innerHTML = "Time's up!";
                clearInterval(countdownInterval);
            }
        }

        // Update the countdown every second
        const countdownInterval = setInterval(updateCountdown, 1000);

        // Initialize the countdown immediately
        updateCountdown();
    </script>
</head>
<style>
    @keyframes pulse {
        0% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
    /* General Styles */
body {
    background-color: #000;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: #fff;
  }
  .timer{
    color:#ff0f0f;
    animation: pulse 3s infinite;
  }
  
  /* Referee Section */
  .referee {
    text-align: center;
    margin: 10px 0;
    font-size: 1.2em;
    color: #539A46;
    font-weight: bold;
  }
  
  /* Header Section */
  .header {
    text-align: center;
    color: #539A46;
    margin-bottom: 20px;
    padding: 20px;
  }
  
  .header h1 {
    margin: 0;
    font-size: 2.5em;
    color: #539A46;
  }
  
  .futsal-name, .location-time {
    margin: 5px 0;
    font-size: 1.2em;
    color: #fff;
  }
  
  .location-time {
    margin-top: 10px;
  }
  
  /* Futsal Ground */
  .container {
    width: 700px;
    height: 450px;
    margin: 50px auto;
    background-color: #539A46;
    position: relative;
    border-radius: 10px;
  }
  
  /* Ground Lines */
  .line {
    width: 700px;
    height: 450px;
    border: 3px solid #ffffff;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    border-radius: 10px;
  }
  
  .half {
    width: 350px;
    height: 450px;
    position: absolute;
    top: 0;
    border-right: 4px solid #fff;
    left: 0;
  }
  
  .panelty {
    width: 90px;
    height: 180px;
    border: 3px solid #ffffff;
    position: absolute;
    background-color: #539A46;
  }
  
  .panelty.left {
    left: 3px;
    top: 135px;
  }
  
  .panelty.right {
    right: 3px;
    top: 135px;
  }
  
  .p-spot.left:after, .p-spot.right:after {
    content: "\2022";
    position: absolute;
    color: #fff;
    font-size: 30px;
  }
  
  .p-spot.left:after {
    top: 208px;
    left: 70px;
  }
  
  .p-spot.right:after {
    top: 208px;
    right: 70px;
  }
  
  .center {
    position: absolute;
    width: 100px;
    height: 100px;
    border: 3px solid #ffffff;
    left: 300px;
    top: 175px;
    border-radius: 50%;
  }
  
  .player {
    position: absolute;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  .player-icon {
    width: 40px;
    height: 40px;
    background-color: #f9f8f7;
    color: #000;
    font-size: 14px;
    font-weight: bold;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #333;
    margin-bottom: 5px;
  }
  
  .player-name {
    font-size: 12px;
    color: #fff;
    text-align: center;
    font-weight: bold;
  }
  
  /* Player Details Table */
  .table-container {
    margin: 20px auto;
    max-width: 700px;
    overflow-x: auto;
  }
  
  .table-title {
    text-align: center;
    font-size: 1.5em;
    color: #539A46;
    margin-bottom: 10px;
  }
  
  .player-table {
    width: 100%;
    border-collapse: collapse;
    background-color: #222;
  }
  
  .player-table th,
  .player-table td {
    border: 1px solid #fff;
    text-align: center;
    padding: 10px;
    font-size: 1em;
    color: #fff;
  }
  
  .player-table th {
    background-color: #539A46;
    color: #fff;
    font-weight: bold;
  }
  
  .player-table tr:nth-child(even) {
    background-color: #333;
  }
  
  .player-table tr:nth-child(odd) {
    background-color: #444;
  }
  
</style>
<body>
<h1>Match Starts In: </h1>
<div id="timer" class="timer">Loading...</div>
  <!-- Referee Section -->
  <div class="referee">
    Referee: John Doe | Referee ID: 12345
  </div>

  <!-- Header Section -->
  <div class="header">
    <h1>Match Lineups</h1>
    <p class="futsal-name">Futsal Name: Sunshine Futsal</p>
    <p class="location-time">Location: City Center</p>
    <p class="location-time">Date: 2024-11-23 | Time: 10:00 AM</p>
  </div>

  <!-- Futsal Ground -->
  <div class="container">
    <div class="line"></div>
    <div class="half"></div>
    <div class="panelty left"></div>
    <div class="panelty right"></div>
    <div class="p-spot left"></div>
    <div class="p-spot right"></div>
    <div class="center"></div>
    <div class="p-place left"></div>
    <div class="p-place right"></div>

    <!-- Team A Players -->
    <div class="player player1" style="top: 80px; left: 120px;">
      <div class="player-icon">1</div>
      <div class="player-name">Player 1</div>
    </div>
    <div class="player player2" style="top: 200px; left: 10px;">
      <div class="player-icon">2</div>
      <div class="player-name">Player 2</div>
    </div>
    <div class="player player3" style="top: 280px; left: 120px;">
      <div class="player-icon">3</div>
      <div class="player-name">Player 3</div>
    </div>
    <div class="player player4" style="top: 140px; left: 200px;">
      <div class="player-icon">4</div>
      <div class="player-name">Player 4</div>
    </div>
    <div class="player player5" style="top: 220px; left: 200px;">
      <div class="player-icon">5</div>
      <div class="player-name">Player 5</div>
    </div>

    <!-- Team B Players -->
    <div class="player player6" style="top: 80px; right: 120px;">
      <div class="player-icon">6</div>
      <div class="player-name">Player 6</div>
    </div>
    <div class="player player7" style="top: 200px; right: 10px;">
      <div class="player-icon">7</div>
      <div class="player-name">Player 7</div>
    </div>
    <div class="player player8" style="top: 280px; right: 120px;">
      <div class="player-icon">8</div>
      <div class="player-name">Player 8</div>
    </div>
    <div class="player player9" style="top: 140px; right: 200px;">
      <div class="player-icon">9</div>
      <div class="player-name">Player 9</div>
    </div>
    <div class="player player10" style="top: 220px; right: 200px;">
      <div class="player-icon">10</div>
      <div class="player-name">Player 10</div>
    </div>
  </div>

  <!-- Player Table Section -->
  <div class="table-container">
  <h2 class="table-title">5v5 Team Player Details</h2>
<table class="player-table">
  <thead>
    <tr>
      <th><?php echo $teams[0]['team_name']?></th>
      <th><?php echo $teams[1]['team_name']?></th>
      
    </tr>
  </thead>
  <tbody>
    <?php
    // Split team members into arrays for each team
    $team_A = $teams[0]['team_name'];
$team_B = $teams[1]['team_name'];
    $teamA_members = explode(', ', $teams[0]['team_members']);
    $teamB_members = explode(', ', $teams[1]['team_members']);


    // Calculate the maximum rows needed
    $max_rows = max(count($teamA_members), count($teamB_members));

    for ($i = 0; $i < $max_rows; $i++) {
      echo '<tr>';
      // Display Team A member if exists, otherwise leave blank
      echo '<td>' . ($teamA_members[$i] ?? '') . '</td>';
      // Display Team B member if exists, otherwise leave blank
      echo '<td>' . ($teamB_members[$i] ?? '') . '</td>';
      echo '</tr>';
    }
    ?>
  </tbody>
</table>

  </div>
</body>
</html>
