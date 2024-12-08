<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Match Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        /* General Styles */
        body {
            background-color: white;
            color: #4caf50;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
            color:#4caf50;
            font-weight: bold;
        }

        .container {
            max-width: 1200px;
            
            margin: 0 auto;
        }

        /* Team Section Styles */
        .team-container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            gap: 200px;
            
        }

        .team-section {
            background-color: #000000;
            border: 2px solid white;
            
            border-radius: 10px;
            flex: 1;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .team-header {
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            color: #287233;
            margin-bottom: 15px;
            text-transform: uppercase;
            
        }

        .player-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .player-list li {
            padding: 10px;
            border-bottom: 1px solid #e6e6e6;
            font-size: 1rem;
        }

        .player-list li:last-child {
            border-bottom: none;
        }

        .score-display {
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            color: #287233;
            margin-top: 20px;
        }

        /* Payment Section Styles */
        .payment-section {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            border: 2px solid #287233;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .payment-section h2 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #287233;
            margin-bottom: 10px;
        }

        .payment-section p {
            font-size: 1rem;
            color: #666666;
            margin-bottom: 20px;
        }

        .esewa-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #287233;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .esewa-btn img {
            width: 25px;
            margin-right: 10px;
        }

        .esewa-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .team-container {
                flex-direction: column;
            }

            h1 {
                font-size: 2rem;
            }

            .team-header {
                font-size: 1.5rem;
            }

            .score-display {
                font-size: 1.8rem;
            }

            .esewa-btn {
                font-size: 0.9rem;
                padding: 8px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Match Heading -->
        <h1>Futsal Match Results</h1>

        <!-- Team Data Section -->
        <div class="team-container">
            <!-- Team A -->
            <div class="team-section">
                <div class="team-header">Team A: Warriors</div>
                <ul class="player-list">
                    <li>John (Goals: 2, Assists: 1, Fouls: 0)</li>
                    <li>Alex (Goals: 1, Assists: 2, Fouls: 1)</li>
                    <li>Mark (Goals: 0, Assists: 1, Fouls: 2)</li>
                </ul>
                <div class="score-display">Total Score: 3</div>
            </div>

            <!-- Team B -->
            <div class="team-section">
                <div class="team-header">Team B: Titans</div>
                <ul class="player-list">
                    <li>Sam (Goals: 1, Assists: 1, Fouls: 0)</li>
                    <li>Leo (Goals: 1, Assists: 0, Fouls: 1)</li>
                    <li>Mike (Goals: 0, Assists: 1, Fouls: 1)</li>
                </ul>
                <div class="score-display">Total Score: 2</div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="payment-section">
            <h2>Support the Teams</h2>
            <p>Contribute to organizing more matches by making a secure payment using eSewa.</p>
            <form action="https://uat.esewa.com.np/epay/main" method="POST">
                <input type="hidden" name="tAmt" value="120"> <!-- Total Amount -->
                <input type="hidden" name="amt" value="120"> <!-- Actual Amount -->
                <input type="hidden" name="txAmt" value="0">  <!-- Tax -->
                <input type="hidden" name="psc" value="0">    <!-- Service Charge -->
                <input type="hidden" name="pdc" value="0">    <!-- Delivery Charge -->
                <input type="hidden" name="scd" value="EPAYTEST"> <!-- Testing Merchant Code -->
                <input type="hidden" name="pid" value="TestPayment123"> <!-- Unique Payment ID -->
                <input type="hidden" name="su" value="http://localhost/projfutsal/esewa_success.php"> <!-- Success URL -->
                <input type="hidden" name="fu" value="http://localhost/projfutsal/esewa_failure.php"> <!-- Failure URL -->
                <button type="submit" class="esewa-btn">
                    <img src="https://cdn.esewa.com.np/ui/images/logos/esewa-icon-large.png" alt="eSewa Logo">
                    Pay with eSewa
                </button>
            </form>
        </div>
    </div>
</body>
</html>
