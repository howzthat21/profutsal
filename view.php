<?php
include 'db.php';


session_start();




$query = "SELECT username, email FROM users"; 
$stmt = $pdo->query($query);


if ($stmt->rowCount() > 0) {
    
    echo "<h2>User List:</h2>";
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>Username: " . htmlspecialchars($row['username']) . ", Email: " . htmlspecialchars($row['email']) . "</li>";
    }
    echo "</ul>";
} else {
    echo "No users found.";
}
?>