<?php
include 'db.php';


session_start();

// Include the database connection

// Example query: Fetch user details (adjust table and column names as needed)
$query = "SELECT username, email FROM users"; // Replace 'users' and columns with your table/columns
$stmt = $pdo->query($query);

// Check if any rows were returned
if ($stmt->rowCount() > 0) {
    // Loop through the results and display them
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