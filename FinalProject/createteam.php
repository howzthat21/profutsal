<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Check if the user is already in a lobby
$check_user_query = "SELECT participant_id FROM match_participants WHERE user_id = ?";
$check_user_query_stmt = $pdo->prepare($check_user_query);
$check_user_query_stmt->execute([$user_id]);
$user_exist = $check_user_query_stmt->fetchColumn();

if ($user_exist > 0) {
    header("Location: index.php");
    exit();
}

// Fetch all arenas
$fetch_arenas = "SELECT arena_id, arena_name, arena_location, arena_image, contact_info, rental_fee FROM arenas";
$fetch_arenas_stmt = $pdo->query($fetch_arenas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Booking</title>
    <link rel="stylesheet" href="createteam.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;600&family=Montserrat:wght@700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Create Your Team</h1>
        <p class="page-description">
            Welcome to the Futsal Booking platform! Select your preferred futsal arena, check its location, and book it instantly. 
            Gather your team, pick a time, and enjoy your game.
        </p>
    </header>
    <main class="container">
        <?php
        // Dynamically generate futsal cards
        while ($arena = $fetch_arenas_stmt->fetch(PDO::FETCH_ASSOC)) {
            $arena_id = htmlspecialchars($arena['arena_id']); // Prevent XSS
            $arena_name = htmlspecialchars($arena['arena_name']); // Prevent XSS
            $arena_location = htmlspecialchars($arena['arena_location']);
            $arena_image = htmlspecialchars($arena['arena_image']);
            $contact_info = htmlspecialchars($arena['contact_info']);
            $rental_fee = htmlspecialchars($arena['rental_fee']);
        ?>
        <section class="futsal-card">
            <div class="card-header">
                <h2><?php echo $arena_name; ?></h2>
                <p>🏠 <?php echo $arena_location; ?></p>
                <p>📞 <?php echo $contact_info; ?></p>
                <p>💰 Rental Fee: <?php echo $rental_fee; ?></p>
            </div>
            <div class="image-container">
                <img src="<?php echo $arena_image; ?>" alt="<?php echo $arena_name; ?>">
            </div>
            <div class="map-container">
                <!-- Add Google Map iframe here dynamically if needed -->
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('<?php echo $arena_name; ?>', '<?php echo $arena_id;?>')">Book Now</button>
        </section>
        <?php } ?>
    </main>

    <footer>
        <p>© 2024 Futsal Booking. All rights reserved.</p>
    </footer>

    <script>
        function selectFutsal(arenaName, arenaId) {
            window.location.href = `futsal_timing.php?arena_name=${arenaName}&arena_id=${arenaId}`;
        }
    </script>
</body>
</html>
