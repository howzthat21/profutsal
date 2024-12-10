<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
$match_id=107;

$query = "SELECT DISTINCT(team_name) FROM completed_match_participants WHERE match_id = 107";
$query_stmt = $pdo->query($query);
$results = $query_stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($results) == 2) {
    $team1 = $results[0]['team_name'];
    $team2 = $results[1]['team_name'];

    // Output the team names
    echo "Team 1: " . htmlspecialchars($team1) . "<br>";
    echo "Team 2: " . htmlspecialchars($team2) . "<br>";
} else {
    echo "Unexpected number of teams found.";
}


$query_1="SELECT  u.id,u.username, ps.goals, ps.assists, ps.fouls, cmp.team_name
FROM users u 
JOIN player_stats ps ON ps.player_id = u.id
JOIN completed_match_participants cmp ON cmp.user_id = u.id
WHERE cmp.match_id = 107 and ps.match_id=107 and cmp.team_name= ?";

$query_1_stmt=$pdo->prepare($query_1);
$query_1_stmt->execute([$team1]);
$results_1=$query_1_stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($results_1 as $result_1){
    echo $result_1['id'];
    echo $result_1['username'];
    echo $result_1['goals'];
    echo $result_1['assists'];
    echo $result_1['fouls'];
    echo $result_1['team_name'];
}

$query_2="SELECT  u.id,u.username, ps.goals, ps.assists, ps.fouls, cmp.team_name
FROM users u 
JOIN player_stats ps ON ps.player_id = u.id
JOIN completed_match_participants cmp ON cmp.user_id = u.id
WHERE cmp.match_id = 107 and ps.match_id=107 and cmp.team_name= ?";
$query_2_stmt=$pdo->prepare($query_2);
$query_2_stmt->execute([$team2]);
$results_2=$query_2_stmt->fetchAll(PDO::FETCH_ASSOC);


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
            background-color: #000000;
            color: #333333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 30px;
            color: #287233;
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
            gap: 20px;
        }

        .team-section {
            background-color: #ffffff;
            border: 2px solid #287233;
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
                <div class="team-header">Team: <?php echo $team1 ?></div>
                <ul class="player-list">
                    <?php foreach($results_1 as $result_1):?>
                    <li><?php echo $result_1['username']; ?> goals(<?php echo $result_1['goals']?>) assists(<?php echo $result_1['assists']?>) fouls(<?php echo $result_1['fouls']?>)</li>
                    
                    <?php endforeach;?>
                </ul>
                <div class="score-display">Total Score: 3</div>
            </div>

            <!-- Team B -->
            <div class="team-section">
                <div class="team-header">Team:  <?php echo $team2 ?></div>
                <ul class="player-list">
                <?php foreach($results_2 as $result_2):?>
                    <li><?php echo $result_2['username']; ?> goals(<?php echo $result_2['goals']?>) assists(<?php echo $result_2['assists']?>) fouls(<?php echo $result_2['fouls']?>)</li>
                    <?php endforeach;?>
                    
                    
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
                <input type="hidden" name="pid" value="kjabfjdabcisffsfsddfdda"> <!-- Unique Payment ID -->
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
