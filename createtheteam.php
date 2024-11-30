<?php
session_start();

if(!isset($_SESSION["user_id"])){
    header("Location: login.php");
}
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
        <!-- Futsal Lobby Card 1 -->
        <section class="futsal-card">
            <div class="card-header">
                <h2>Kumari Futsal</h2>
                <p>🏠 Kathmandu, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena1.jpg" alt="Kumari Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_one')">Book Now</button>
        </section>

        <!-- Futsal Lobby Card 2 -->
        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>

        <!-- Add more cards as needed -->
        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>


        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>


        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>


        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>


        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>


        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>

        <section class="futsal-card">
            <div class="card-header">
                <h2>Bajra Futsal</h2>
                <p>🏠 Bhaktapur, Nepal</p>
            </div>
            <div class="image-container">
                <img src="arena3.jpg" alt="Bajra Futsal">
            </div>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=..." 
                    frameborder="0" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
            <button onclick="selectFutsal('arena_two')">Book Now</button>
        </section>
        
    </main>

    <footer>
        <p>© 2024 Futsal Booking. All rights reserved.</p>
    </footer>

    <script>
        function selectFutsal(futsalId) {
            window.location.href = `futsal_timing.html?futsal=${futsalId}`;
        }
    </script>
</body>
</html>
