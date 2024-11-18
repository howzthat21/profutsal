<?php
session_start(); // Start the session

// Check if user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) { // Assuming 'user_id' is set when a user logs in
    // Redirect to login page if session is not set
    header("Location: login.php");
    exit();
}
include 'db.php';



// Fetch arena data from the database
$sql = "SELECT  arena_id, arena_name, arena_location, arena_image, location_link FROM arenas";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch()) {
    $loc_link = $row['location_link']; // Store location link

    // Display arena details
    echo "<div style='margin-bottom: 20px;'>";
    echo "<h3>" . htmlspecialchars($row['arena_name']) . "</h3>";
    echo "<p>Location: " . htmlspecialchars($row['arena_location']) . "</p>";
    echo "<img src='" . htmlspecialchars($row['arena_image']) . "' alt='Arena Image' width='200'>";

    // Display embedded Google Map for the location link
    if (!empty($loc_link)) {
        echo "<h4>Map Location:</h4>";
        echo "<iframe 
                src='" . htmlspecialchars($loc_link) . "' 
                width='400' 
                height='300' 
                style='border:0; margin-top: 10px;' 
                allowfullscreen='' 
                loading='lazy' 
                referrerpolicy='no-referrer-when-downgrade'>
              </iframe>";
    }
    
    // Add a "Select" link to redirect to arenabooking.php with the arena name as a parameter
    $arena_name = urlencode($row['arena_name']); // URL-encode arena name for safe passing in URL
    $arena_id = urldecode($row['arena_id']);
    $user_id = urldecode($_SESSION['user_id']);
    echo $_SESSION['username'];
    echo $arena_id;
    echo "<p><a href='arenabooking.php?arena_name=$arena_name&user_id=$user_id&arena_id=$arena_id'>Book Now</a></p>";

    echo "</div>";
}
?>
