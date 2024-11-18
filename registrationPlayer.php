<?php session_start(); // Start the session

// Check if user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) { // Assuming 'user_id' is set when a user logs in
    // Redirect to login page if session is not set
    header("Location: login.php");
    exit();
}
$user_id=$_SESSION['user_id'];
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $age = $_POST['age'];
    $location = $_POST['location'];
    //$skill_level = $_POST['skill_level'];
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
            header("Location: landingafterregistration.php");
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
    <title>Player Profile Form</title>
    <!-- Link to Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Player Profile Form <?php echo $user_id ?></h2>
        
        <form action="registrationplayer.php" method="POST">
            <!-- Age Input with Minimum Age Requirement -->
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" min="13" required>
            </div>

            <!-- Location Input -->
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" required>
            </div>

            <!-- Skill Level Dropdown -->
            <div class="mb-3">
                <label for="skill_level" class="form-label">Skill Level</label>
                <select class="form-select" id="skill_level" name="skill_level" required>
                    <option value="" disabled selected>Select your skill level</option>
                    <option value="beginner">Beginner</option>
                    <option value="amateur">Amateur</option>
                    <option value="pro">Pro</option>
                </select>
            </div>

            <!-- Preferred Position Dropdown -->
            <div class="mb-3">
                <label for="position" class="form-label">Preferred Position</label>
                <select class="form-select" id="position" name="position" required>
                    <option value="" disabled selected>Select your preferred position</option>
                    <option value="goalkeeper">Goalkeeper</option>
                    <option value="midfielder">Midfielder</option>
                    <option value="defender">Defender</option>
                    <option value="striker">Striker</option>
                </select>
            </div>

            <!-- Bio Textarea -->
            <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Write a brief bio about yourself" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Submit Profile</button>
        </form>
    </div>

    <!-- Optional JavaScript for Bootstrap (not required for CSS to work) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoYz1WIF5cO7xpg6FrZsSnRLu9E3sZ0D+l6LFNQ+8qD+4Mf" crossorigin="anonymous"></script>
</body>
</html>
