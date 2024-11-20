<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$player_id = $_SESSION['user_id'];

$fetch_match_sql = "SELECT match_id FROM match_participants WHERE user_id = :player_id";
$fetch_match_stmt = $pdo->prepare($fetch_match_sql);
$fetch_match_stmt->execute(['player_id' => $player_id]);

$match = $fetch_match_stmt->fetch(PDO::FETCH_ASSOC);
if(!$match){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Lineup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .field {
            background-color: #4CAF50;
            width: 100%;
            height: 80vh;
            position: relative;
            border: 2px solid #fff;
            border-radius: 10px;
            margin: 20px auto;
        }
        .player {
            width: 70px;
            height: 70px;
            background: #FFD700;
            color: #000;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
        }
        .goalkeeper { top: 10%; left: 50%; transform: translate(-50%, -50%); }
        .defender { top: 40%; left: 50%; transform: translate(-50%, -50%); }
        .midfielder-left { top: 60%; left: 30%; transform: translate(-50%, -50%); }
        .midfielder-right { top: 60%; left: 70%; transform: translate(-50%, -50%); }
        .forward { top: 80%; left: 50%; transform: translate(-50%, -50%); }
    </style>
</head>
<body>
    <div class="container text-center">
        <h1 class="my-4">Futsal Lineup</h1>

        <?php if ($match): ?>
            <?php
            $match_id = $match['match_id'];

            $participants_sql = "
                SELECT u.username 
                FROM match_participants mp
                JOIN users u ON mp.user_id = u.id
                WHERE mp.match_id = :match_id
            ";
            $participants_stmt = $pdo->prepare($participants_sql);
            $participants_stmt->execute(['match_id' => $match_id]);

            $participants = [];
            while ($participant = $participants_stmt->fetch(PDO::FETCH_ASSOC)) {
                $participants[] = $participant['username'];
            }

            shuffle($participants);

            $teamA = [];
            $teamB = [];
            foreach ($participants as $index => $username) {
                if ($index % 2 === 0) {
                    $teamA[] = $username;
                } else {
                    $teamB[] = $username;
                }
            }
            ?>
            <h3>Team A</h3>
            <ul>
                <?php foreach ($teamA as $username): ?>
                    <li><?= htmlspecialchars($username) ?></li>
                <?php endforeach; ?>
            </ul>
             <h3>Team B</h3>
            <ul>
                <?php foreach ($teamB as $username): ?>
                    <li><?= htmlspecialchars($username) ?></li>
                <?php endforeach; ?>
            </ul>
            <div class="field">
                <div class="player goalkeeper"><?= htmlspecialchars($teamA[0] ?? 'GK') ?><br> Goalkeeper</div>
                <div class="player defender"><?= htmlspecialchars($teamA[1] ?? 'D') ?><br>Defense</div>
                <div class="player midfielder-left"><?= htmlspecialchars($teamA[2] ?? 'M1') ?><br>Mid</div>
                <div class="player midfielder-right"><?= htmlspecialchars($teamA[3] ?? 'M2') ?><br>Mid</div>
                <div class="player forward"><?= htmlspecialchars($teamA[4] ?? 'F') ?><br>Forward</div>
            </div>
            

            <div class="field">
                <div class="player goalkeeper"><?= htmlspecialchars($teamB[0] ?? 'GK') ?><br>Goalkeeper</div>
                <div class="player defender"><?= htmlspecialchars($teamB[1] ?? 'D') ?><br>Defense</div>
                <div class="player midfielder-left"><?= htmlspecialchars($teamB[2] ?? 'M1') ?><br>Mid</div>
                <div class="player midfielder-right"><?= htmlspecialchars($teamB[3] ?? 'M2') ?><br>Mid</div>
                <div class="player forward"><?= htmlspecialchars($teamB[4] ?? 'F') ?><br>Forward</div>
            </div>
           
        <?php else: ?>
            <p>You are not currently in any match.</p>
        <?php endif; ?>
    </div>
</body>
</html>
