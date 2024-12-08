
<?php 
session_start(); // start session



// registered user haru lai matra enter garna dincha, ani register ko page maa fyalcha
if (!isset($_SESSION['user_id'])) { 
    
    header("Location: register.php");
    exit();
}
$user_id=$_SESSION['user_id'];
include 'db.php';

// form method post ko submit bhayo bhane condtion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $age = $_POST['age'];
    $location = $_POST['location'];
    
    $position = $_POST['position'];
    $bio = $_POST['bio'];
    
    // Validate the inputs
    if ($age >= 13 && !empty($location)  && !empty($position) && !empty($bio)) {
        try {
            // sql query to insert the values in player_profiles
            $sql = "INSERT INTO player_profiles (age, location, preferred_position, bio, user_id) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            
            $stmt->execute([$age, $location, $position, $bio, $user_id]);

            
            echo "<p>Profile successfully submitted!</p>";
            header("Location: joincreate.php");
        } catch (PDOException $e) {
            
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Please fill in all fields correctly and ensure the age is above 13.</p>";
    }
}

    $check_player="SELECT user_id from player_profiles where user_id=? limit 1";
    $check_player_stmt=$pdo->prepare($check_player);
    $check_player_stmt->execute([$user_id]);
    $check_player_stmt=$check_player_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($check_player_stmt){
      
      header("Location: index.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Player Registration - Futsal Matchmaking</title>
  <link rel="stylesheet" href="becomeaplayer.css">
</head>
<body>
  <div class="form-container">
    <h2>Register for Futsal Matchmaking</h2>
    <form id="registrationForm" action="becomeaplayer.php" method="post">
      
      <!-- Full Name -->
      <div class="form_group">
        <label for="user_id">User_id: <?php echo $user_id?></label>

      </div>

      <!-- Age -->
      <div class="form-group">
        <label for="age">Age</label>
        <input type="number" id="age" name="age" required placeholder="Enter your age" min="10" max="100">
      </div>

      <!-- Location -->
      <div class="form-group">
        <label for="location">Location</label>
        <input type="text" id="location" name="location" required placeholder="Enter your location">
      </div>

      <!-- Skill Level -->
      <div class="form-group">
        <label for="skill_level">Skill Level</label>
        <select id="skill_level" name="skill_level" required>
          <option value="">Select Skill Level</option>
          <option value="beginner">Beginner</option>
          <option value="intermediate">Intermediate</option>
          <option value="advanced">Advanced</option>
        </select>
      </div>

      <!-- Preferred Position -->
      <div class="form-group">
        <label for="preferred_position">Preferred Position</label>
        <select id="preferred_position" name="position" required>
          <option value="">Select Position</option>
          <option value="goalkeeper">Goalkeeper</option>
          <option value="defender">Defender</option>
          <option value="midfielder">Midfielder</option>
          <option value="forward">Forward</option>
        </select>
      </div>

      <!-- Availability -->
      <div class="form-group">
        <label for="availability">Availability</label>
        <input type="text" id="availability" name="availability" placeholder="e.g., Weekends, Evenings">
      </div>
      <div class="form-group">
        <label for="availability">Bio</label>
        <input type="text" id="availability" name="bio" placeholder="e.g., Weekends, Evenings">
      </div>

      <!-- Submit Button -->
      <button type="submit">Register</button>
    </form>
    <p id="successMessage" style="display:none; color: green;">Registration successful!</p>
  </div>

  <script src="script.js"></script>
</body>
</html>
