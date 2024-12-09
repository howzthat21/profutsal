<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$fetch_waiting_lobby = "SELECT mp.match_id 
    FROM match_participants mp
    JOIN users u ON mp.user_id = u.id
    WHERE mp.match_id NOT IN (
        SELECT match_id FROM completed_matches
    ) AND mp.user_id = ?";
$fetch_waiting_lobby_stmt = $pdo->prepare($fetch_waiting_lobby);
$fetch_waiting_lobby_stmt->execute([$user_id]);
$waiting_lobby = $fetch_waiting_lobby_stmt->fetch(PDO::FETCH_ASSOC);

if (!$waiting_lobby) {
    header("Location: index.php");
    exit();
}

$match_id = $waiting_lobby['match_id'];

$fetch_info = "SELECT arena_id, booking_datetime, player_count FROM matchmaking WHERE match_id = ?";
$fetch_info_stmt = $pdo->prepare($fetch_info);
$fetch_info_stmt->execute([$match_id]);
$lobby_view = $fetch_info_stmt->fetch(PDO::FETCH_ASSOC);

$arena_id = $lobby_view['arena_id'];
$booking_datetime = $lobby_view['booking_datetime'];
$lobby_player_count = $lobby_view['player_count'];

$fetch_arena_details = "SELECT arena_name, arena_location FROM arenas WHERE arena_id = ?";
$fetch_arena_details_stmt = $pdo->prepare($fetch_arena_details);
$fetch_arena_details_stmt->execute([$arena_id]);
$fetch_arena = $fetch_arena_details_stmt->fetch(PDO::FETCH_ASSOC);

$arena_name = $fetch_arena['arena_name'];
$arena_location = $fetch_arena['arena_location'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delete_match_participant = "DELETE FROM match_participants WHERE match_id = ? AND user_id = ?";
    $delete_match_participant_stmt = $pdo->prepare($delete_match_participant);
    $delete = $delete_match_participant_stmt->execute([$match_id, $user_id]);

    if ($delete) {
        try {
            $update_query = "UPDATE matchmaking SET player_count = player_count - 1 WHERE match_id = ?";
            $update_stmt = $pdo->prepare($update_query);
            $update = $update_stmt->execute([$match_id]);
        } catch (PDOException $e) {
            echo "Error updating player count: " . $e->getMessage();
        }

        // Check if player count is zero, delete match from matchmaking table
        if ($update_stmt) {
            $current_players = "SELECT player_count FROM matchmaking WHERE match_id = ?";
            $current_players_stmt = $pdo->prepare($current_players);
            $current_players_stmt->execute([$match_id]);
            $current_players_result = $current_players_stmt->fetch(PDO::FETCH_ASSOC);
            $current_players_count = $current_players_result['player_count'];

            if ($current_players_count == 0) {
                $delete_match_query = "DELETE FROM matchmaking WHERE match_id = ?";
                $delete_match_stmt = $pdo->prepare($delete_match_query);
                $delete_match_stmt->execute([$match_id]);
            }
        }

        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Lobby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #1b1b1b; /* Dark background for the page */
            color: #ffffff; /* White text color for better contrast */
        }

        .waiting-lobby {
            background-color: rgba(42, 42, 42, 0.9); /* Dark background with slight transparency */
            border: 2px solid #4CAF50; /* Green border for consistency */
            border-radius: 10px;
            padding: 30px;
            margin: 20px auto;
            text-align: center;
            max-width: 600px; /* Max width for better layout */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            position: relative; /* Position relative for absolute positioning of the close button */
        }

        .waiting-lobby h2 {
            font-size: 2em; /* Larger font for the heading */
            color: #4CAF50; /* Green color */
            margin-bottom: 20px; /* Spacing below the heading */
        }

        .waiting-lobby p {
            font-size: 1.2em; /* Readable font size */
            color: #dcdcdc; /* Light gray for description */
            margin-bottom: 20px; /* Spacing between paragraphs */
        }

        .lobby-card {
            background-color: #2a2a2a; /* Darker card background */
            border: 1px solid #444; /* Slightly lighter border */
            border-radius: 8px;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Shadow for depth */
            transition: transform 0.3s, box-shadow 0.3s; /* Transition for hover effect */
            position: relative; /* Position relative for absolute positioning of the close button */
        }

        .lobby-card:hover {
            transform: scale(1.02); /* Slightly increase size on hover */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.7); /* Deeper shadow on hover */
        }

        .player-box-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }

        .player-box {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            background-color: gray;
            display: inline-block;
        }

        .player-box.filled {
            background-color: #4CAF50; /* Filled player box color */
        }

        .btn-custom {
            margin: 10px; /* Margin around buttons */
        }

        /* Cancel button styles */
        .close-btn {
            position: absolute; /* Position absolute to place it at the top right */
            top: 10px; /* Adjust top position */
            right: 10px; /* Adjust right position */
            width: 30px; /* Width of the button */
            height: 30px; /* Height of the button */
            background-color: red; /* Red background */
            color: white; /* White text */
            border: none; /* No border */
            border-radius: 50%; /* Circular shape */
            font-size: 16px; /* Font size for the "X" */
            cursor: pointer; /* Pointer cursor on hover */
            display: flex; /* Flexbox for centering "X" */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        .close-btn:hover {
            background-color: darkred; /* Darker red on hover */
        }
         /* Modal body text color */
    .modal-body {
        color: black; /* Change text color to black */
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">Futsal Matchmaking</a>
        </div>
    </nav>
    <div class="container mt-4">
        <section class="waiting-lobby">
            <h2>Waiting Lobby</h2>
            <button class="close-btn" onclick="location.href='index.php'">X</button>
            <p>Welcome to the waiting lobby! Please wait while we find your match.</p>
            <p>Lobby was created : <strong>2 minutes ago</strong></p>
            <p>Players in lobby: <strong>1</strong></p>
        </section>

        <!-- Match Details -->
        <div class="lobby-card">
            
            <h2>Match ID: <?php echo htmlspecialchars($match_id); ?></h2>
            <p><strong>Arena Name:</strong> <?php echo htmlspecialchars($arena_name); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($arena_location); ?></p>
            <p><strong>Booked Time:</strong> <?php echo htmlspecialchars($booking_datetime); ?></p>
            <p><strong>Players:</strong> <span id="player-count"><?php echo htmlspecialchars($lobby_player_count); ?></span>/10</p>

            <!-- Player Boxes -->
            <div class="player-box-container" id="player-box-container"></div>

            <!-- Cancel Button -->
            <div class="cancel-button-container">
                <button id="cancelButton" type="button" class="btn btn-danger btn-custom" onclick="redirectWithPopup()">Cancel Matching</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="homeModal" tabindex="-1" aria-labelledby="homeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="homeModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel your participation in this match?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelButton">Yes, Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamically create player boxes based on player count
            const playerCount = parseInt(document.getElementById('player-count').textContent);
            const playerBoxContainer = document.getElementById('player-box-container');

            for (let i = 0; i < 10; i++) {
                const playerBox = document.createElement('div');
                playerBox.className = 'player-box' + (i < playerCount ? ' filled' : '');
                playerBoxContainer.appendChild(playerBox);
            }

            // Cancel button confirmation
            const cancelButton = document.getElementById('cancelButton');
            const confirmCancelButton = document.getElementById('confirmCancelButton');
            const homeModal = new bootstrap.Modal(document.getElementById('homeModal'));

            cancelButton.addEventListener('click', function () {
                homeModal.show();
            });

            confirmCancelButton.addEventListener('click', function () {
                // Submit the form to cancel matching
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = window.location.href; // Send the request to the same page
                document.body.appendChild(form);
                form.submit();
            });
        });
    </script>
</body>
</html>
