<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Match Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .team-header {
            text-align: center;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .team-box {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .score {
            font-size: 2rem;
            font-weight: bold;
        }
        .arena-name {
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <!-- Match Heading -->
        <h1 class="text-center mb-4">Futsal Match Results</h1>

        <!-- Teams and Scores -->
        <div class="row">
            <!-- Team A -->
            <div class="col-md-5 team-box">
                <div class="team-header">Team A: <span id="teamAName"></span></div>
                <div class="mt-3" id="teamAPlayers"></div>
                <div class="text-center mt-3">
                    <span class="score" id="teamAScore"></span> Points
                </div>
            </div>

            <!-- VS -->
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <h3 class="text-center">VS</h3>
            </div>

            <!-- Team B -->
            <div class="col-md-5 team-box">
                <div class="team-header">Team B: <span id="teamBName"></span></div>
                <div class="mt-3" id="teamBPlayers"></div>
                <div class="text-center mt-3">
                    <span class="score" id="teamBScore"></span> Points
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <script>
        // Fetch match data dynamically
        const matchId = new URLSearchParams(window.location.search).get('match_id') || 59;
        const endpoint = `getMatchDetails.php?match_id=${matchId}`;

        fetch(endpoint)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Populate match data
                document.getElementById("teamAName").textContent = data.teamAName;
                document.getElementById("teamAScore").textContent = data.teamAScore ?? "0";
                document.getElementById("teamBName").textContent = data.teamBName;
                document.getElementById("teamBScore").textContent = data.teamBScore ?? "0";

                // Populate team players
                const teamAPlayersDiv = document.getElementById("teamAPlayers");
                const teamBPlayersDiv = document.getElementById("teamBPlayers");

                teamAPlayersDiv.innerHTML = data.teamAPlayers
                    .map(player => `<div>${player}</div>`)
                    .join("");

                teamBPlayersDiv.innerHTML = data.teamBPlayers
                    .map(player => `<div>${player}</div>`)
                    .join("");
            })
            .catch(error => console.error("Error fetching match data:", error));
    </script>
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
    <input type="image" src="https://cdn.esewa.com.np/ui/images/logos/esewa-icon-large.png" alt="Pay with eSewa" style="border: none;">
</form>
</body>
</html>
