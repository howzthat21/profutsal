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

        <!-- Arena Name -->
        <p class="arena-name">Played at: <span id="arenaName">Futsal Arena 1</span></p>

        <!-- Teams and Scores -->
        <div class="row">
            <!-- Team A -->
            <div class="col-md-5 team-box">
                <div class="team-header">Team A: <span id="teamAName">Warriors</span></div>
                <ul class="list-group mt-3" id="teamAPlayers">
                    <!-- Player Names -->
                    <li class="list-group-item">Player 1</li>
                    <li class="list-group-item">Player 2</li>
                    <li class="list-group-item">Player 3</li>
                    <li class="list-group-item">Player 4</li>
                    <li class="list-group-item">Player 5</li>
                </ul>
                <div class="text-center mt-3">
                    <span class="score" id="teamAScore">3</span> Points
                </div>
            </div>

            <!-- VS -->
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <h3 class="text-center">VS</h3>
            </div>

            <!-- Team B -->
            <div class="col-md-5 team-box">
                <div class="team-header">Team B: <span id="teamBName">Titans</span></div>
                <ul class="list-group mt-3" id="teamBPlayers">
                    <!-- Player Names -->
                    <li class="list-group-item">Player 6</li>
                    <li class="list-group-item">Player 7</li>
                    <li class="list-group-item">Player 8</li>
                    <li class="list-group-item">Player 9</li>
                    <li class="list-group-item">Player 10</li>
                </ul>
                <div class="text-center mt-3">
                    <span class="score" id="teamBScore">2</span> Points
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>

    <script>
        // Example dynamic data (Replace this with actual fetched data)
        const matchData = {
            arenaName: "Elite Futsal Court",
            teamAName: "Warriors",
            teamAScore: 3,
            teamAPlayers: ["Player 1", "Player 2", "Player 3", "Player 4", "Player 5"],
            teamBName: "Titans",
            teamBScore: 2,
            teamBPlayers: ["Player 6", "Player 7", "Player 8", "Player 9", "Player 10"]
        };

        // Populate the page with match data
        document.getElementById("arenaName").textContent = matchData.arenaName;
        document.getElementById("teamAName").textContent = matchData.teamAName;
        document.getElementById("teamAScore").textContent = matchData.teamAScore;
        document.getElementById("teamBName").textContent = matchData.teamBName;
        document.getElementById("teamBScore").textContent = matchData.teamBScore;

        const teamAPlayersList = document.getElementById("teamAPlayers");
        const teamBPlayersList = document.getElementById("teamBPlayers");

        teamAPlayersList.innerHTML = matchData.teamAPlayers
            .map(player => `<li class="list-group-item">${player}</li>`)
            .join("");

        teamBPlayersList.innerHTML = matchData.teamBPlayers
            .map(player => `<li class="list-group-item">${player}</li>`)
            .join("");
    </script>
</body>
</html>
