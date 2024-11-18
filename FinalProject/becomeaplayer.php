
<?php 
session_start(); // Start the session



// Check if user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) { // Assuming 'user_id' is set when a user logs in
    // Redirect to login page if session is not set
    header("Location: register.php");
    exit();
}
$user_id=$_SESSION['user_id'];
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $age = $_POST['age'];
    $location = $_POST['location'];
    
    $position = $_POST['position'];
    $bio = $_POST['bio'];
    
    // Validate the inputs
    if ($age >= 13 && !empty($location)  && !empty($position) && !empty($bio)) {
        try {
            // Prepare the SQL query to insert the data into the player_profiles table
            $sql = "INSERT INTO player_profiles (age, location, preferred_position, bio, user_id) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            // Execute the query with the form values
            $stmt->execute([$age, $location, $position, $bio, $user_id]);

            // Redirect or show success message
            echo "<p>Profile successfully submitted!</p>";
            header("Location: joincreate.php");
        } catch (PDOException $e) {
            // If there is an error, display the error message
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Please fill in all fields correctly and ensure the age is above 13.</p>";
    }
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
        <label for="user_id"><?php echo $user_id?></label>

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
