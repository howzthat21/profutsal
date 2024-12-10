<?php
session_start();
// harek code maa include db.php raakha haii natra db connect hunna, ani user logged in chaincha bhane add session_start at the top
include 'db.php';
if (!isset($_SESSION['user_id'])) { 
  header("Location: login.php");
  exit();
}
$user_id=$_SESSION['user_id']; 

$fetch_username="SELECT username from users where id = :user_id";
$fetch_username_stmt = $pdo->prepare($fetch_username);
$fetch_username_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$fetch_username_stmt->execute();
$result = $fetch_username_stmt->fetch(PDO::FETCH_ASSOC);


if ($result && isset($result['username'])) {
  $username = $result['username'];
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Match</title>
    <link rel="stylesheet" href="lineups.css">
    <!--<link rel="stylesheet" href="joincreate.css">-->
</head>
<body>
    <style>
        /* Profile Button Styling positioned in the top-right corner */
.profile-nav {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    background-color: rgba(16, 16, 16, 0.6);
    padding: 8px 12px;
    border-radius: 5px;
    z-index: 2;
}

.player-name {
    font-size: 1rem;
    font-weight: bold;
}
.header {
  position: absolute; /* Place the header at a fixed position */
  top: 0; /* Align it to the top */
  left: 0; /* Align it to the left */
  width: 100%; /* Make it span the full width of the page */
  display: flex;
  justify-content: flex-start; /* Align content to the left */
  align-items: center;
  background-color: rgba(0, 0, 0, 0.8); /* Optional: background color */
  padding: 10px 20px; /* Add padding for spacing */
  z-index: 1; /* Ensure it's above other content */
}

.logo {
  font-size: 2rem;
  color: #4CAF50; /* Green color */
  font-weight: bold;
}
.home-button {
  background-color: #4CAF50; /* Match logo color */
  color: white;
  padding: 10px 15px;
  text-decoration: none;
  border-radius: 5px;
  font-size: 1rem;
  font-weight: bold;
  transition: background-color 0.3s ease;
}

.home-button:hover {
  background-color: #45a049; /* Slightly darker green for hover */
}

.logolink{
    text-decoration: none;
}

    </style>
     <!-- Profile Navigation positioned in the top-right corner -->
  <nav class="profile-nav">
    <!-- Profile section with a link to the player's profile -->
    
      
      <span class="player-name"> <?php echo $username?></span>
    </a>
    
  </nav>
  
  <header class="header">
  
  <a href="index.php" class="logolink"><h1 class="logo">Futsal Matchmaking</h1></a>
</header>

 
    <figure class="card">
        <img src="https://www.shutterstock.com/image-illustration/vertical-image-3d-render-soccer-600nw-2521912969.jpg" alt="image">
        <figcaption>
            <div>
                <h2>Join a Lobby </h2>
            </div>
            <div>
                <p>Existing lobby created by other players.</p>
            </div>
            <a href="joinateam.php"></a>
        </figcaption>
    </figure>

    <figure class="card">
        <img src="uploads/connor-coyne-OgqWLzWRSaI-unsplash.jpg" alt="image">
        <figcaption>
            <div>
                <h2>Create New Lobby </h2>
            </div>
            <div>
                <p>Be a match Creator</p>
            </div>
            <a href="createteam.php"></a>
        </figcaption>
    </figure>

   
</body>
</html>