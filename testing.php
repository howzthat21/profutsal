<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Match Teams</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Futsal Match Teams</h1>

        <?php
        include 'db.php'; // Include your database connection

        $match_id = 59; // Replace with your match ID

        // Prepare and execute the query
        $query = "
            SELECT cmp.team_name, u.username 
            FROM completed_match_participants cmp
            JOIN users u ON cmp.user_id = u.id
            WHERE cmp.match_id = ?
            ORDER BY cmp.team_name, u.username
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$match_id]);

        // Fetch the results
        $teamData = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

        // Display the grouped results
        foreach ($teamData as $teamName => $players) {
            echo "
            <div class='bg-white shadow-md rounded-lg p-6 mb-6'>
                <h3 class='text-xl font-semibold text-gray-700 mb-4'>Team: $teamName</h3>
                <ul class='list-disc list-inside text-gray-600'>";
            foreach ($players as $player) {
                echo "<li class='mb-2'>{$player['username']}</li>";
            }
            echo "</ul>
            </div>";
        }
        ?>
    </div>
</body>
</html>
