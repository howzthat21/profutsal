<?php
session_start();

// Ensure that the admin is logged in
if (!isset($_SESSION['admin'])) {
    header('Location: AdminIndex.php');
    exit;
}

// Database connection (update with your own db credentials)
require 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $arena_name = $_POST['arena_name'];
    $arena_location = $_POST['arena_location'];
    $location_link = $_POST['location_link'];
    $arena_image = $_POST['arena_image'];
    $availability = $_POST['availability'];
    $contact_info = $_POST['contact_info'];
    $rental_fee = $_POST['rental_fee'];

    // Prepare and execute insert query
    $stmt = $pdo->prepare("INSERT INTO arenas (arena_name, arena_location, location_link, arena_image, availability, contact_info, rental_fee) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$arena_name, $arena_location, $location_link, $arena_image, $availability, $contact_info, $rental_fee]);

    // Redirect to the arena list after successful insertion
    header('Location: view_arenas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Arena</title>
    <link rel="stylesheet" href="add_arena.css"> <!-- Add your CSS file here -->
</head>
<body>
    <div class="container">
        <h2>Add New Arena</h2>
        <form method="POST" action="add_arena.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="arena_name">Arena Name</label>
                <input type="text" id="arena_name" name="arena_name" required>
            </div>

            <div class="form-group">
                <label for="arena_location">Arena Location</label>
                <input type="text" id="arena_location" name="arena_location" required>
            </div>

            <div class="form-group">
                <label for="location_link">Location Link</label>
                <input type="url" id="location_link" name="location_link">
            </div>

            <div class="form-group">
                <label for="arena_image">Arena Image URL</label>
                <input type="text" id="arena_image" name="arena_image">
            </div>

            <div class="form-group">
                <label for="availability">Availability</label>
                <input type="text" id="availability" name="availability">
            </div>

            <div class="form-group">
                <label for="contact_info">Contact Info</label>
                <input type="text" id="contact_info" name="contact_info">
            </div>

            <div class="form-group">
                <label for="rental_fee">Rental Fee</label>
                <input type="number" step="0.01" id="rental_fee" name="rental_fee" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Add Arena</button>
            </div>
        </form>
    </div>
</body>
</html>
