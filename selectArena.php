<?php
session_start(); 


if (!isset($_SESSION['user_id'])) { 
    
    header("Location: login.php");
    exit();
}
include 'db.php';




$sql = "SELECT  arena_id, arena_name, arena_location, arena_image, location_link FROM arenas";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch()) {
    $loc_link = $row['location_link']; 

    
    echo "<div style='margin-bottom: 20px;'>";
    echo "<h3>" . htmlspecialchars($row['arena_name']) . "</h3>";
    echo "<p>Location: " . htmlspecialchars($row['arena_location']) . "</p>";
    echo "<img src='" . htmlspecialchars($row['arena_image']) . "' alt='Arena Image' width='200'>";

    
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
    
    
    $arena_name = urlencode($row['arena_name']); 
    $arena_id = urldecode($row['arena_id']);
    $user_id = urldecode($_SESSION['user_id']);
    echo $_SESSION['username'];
    echo $arena_id;
    echo "<p><a href='arenabooking.php?arena_name=$arena_name&user_id=$user_id&arena_id=$arena_id'>Book Now</a></p>";

    echo "</div>";
}
?>
