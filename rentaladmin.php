<?php

// Start session and include database connection (assume $pdo is the PDO connection object)
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $arena_name = $_POST['arena_name'];
    $arena_location = $_POST['arena_location'];
    $location_link = $_POST['location_link'];
    $availability = $_POST['availability'];
    $contact_info = $_POST['contact_info'];
    $rental_fee = $_POST['rental_fee'];

    // Handle the image upload
    if (isset($_FILES['arena_image']) && $_FILES['arena_image']['error'] == 0) {
        $image = $_FILES['arena_image'];
        
        // Set the target directory for image uploads
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
        }

        // Generate a unique name for the image file
        $imagePath = $targetDir . uniqid() . "_" . basename($image['name']);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $imagePath)) {
            // Image uploaded successfully, now insert data into the database
            $sql = "INSERT INTO arenas (arena_name, arena_location, location_link, arena_image, availability, contact_info, rental_fee) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$arena_name, $arena_location, $location_link, $imagePath, $availability, $contact_info, $rental_fee]);

            echo "Arena data and image uploaded successfully!";
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Please upload a valid image.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="form-container">
<form action="rentaladmin.php" method="POST" enctype="multipart/form-data">
    <label for="arena_name">Arena Name:</label>
    <input type="text" id="arena_name" name="arena_name" required>

    <label for="arena_location">Location:</label>
    <input type="text" id="arena_location" name="arena_location" required>

    <label for="location_link">Location Link:</label>
    <input type="text" id="location_link" name="location_link">

    <label for="arena_image">Arena Image:</label>
    <input type="file" id="arena_image" name="arena_image" accept="image/*" required>

    <label for="availability">Availability:</label>
    <select id="availability" name="availability">
        <option value="booked">Available</option>
        <option value="unbooked">Unavailable</option>
    </select>

    <label for="contact_info">Contact Info:</label>
    <input type="tel" id="contact_info" name="contact_info" required>

    <label for="rental_fee">Rental Fee ($):</label>
    <input type="number" id="rental_fee" name="rental_fee" min="0" step="0.01" required>

    <button type="submit">Submit</button>
</form>
</div>
    
</body>
</html>