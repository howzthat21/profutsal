<?php
include 'db.php';
include 'matchMakingStatusUpdate.php';
@session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['referee_id'])) {
    header("Location: refereeLogin.php");
    exit();
}

// Fetch referee details from session
$referee_id = $_SESSION['referee_id'];
$referee_name = $_SESSION['referee_name'];

// Fetch match details associated with the logged-in referee
$fetch_match_details = "
    SELECT 
        cm.match_id, 
        cm.arena_id, 
        m.booking_datetime, 
        a.arena_name
    FROM 
        completed_matches cm
    JOIN 
        referee_matches rm 
    ON 
        cm.match_id = rm.match_id
    JOIN 
        matchmaking m 
    ON 
        cm.match_id = m.match_id
    JOIN 
        arenas a 
    ON 
        cm.arena_id = a.arena_id
    JOIN 
        referee r 
    ON 
        r.referee_id = rm.referee_id
    WHERE 
        r.referee_id = ? and rm.match_review_status = 'pending'
    ORDER BY 
        m.booking_datetime DESC
";

$fetch_match_details_stmt = $pdo->prepare($fetch_match_details);
$fetch_match_details_stmt->execute([$referee_id]);
$matches = $fetch_match_details_stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Match Details for Referee: <?php echo htmlspecialchars($referee_name); ?></h2>
        
        <?php if (!empty($matches)): ?>
            <!-- Table for displaying match details -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Match ID</th>
                        <th scope="col">Arena ID</th>
                        <th scope="col">Arena Name</th>
                        <th scope="col">Booked Time/Date</th>
                        <th scope="col">Action</th> <!-- Column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($matches as $match): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($match['match_id']); ?></td>
                            <td><?php echo htmlspecialchars($match['arena_id']); ?></td>
                            <td><?php echo htmlspecialchars($match['arena_name']); ?></td>
                            <td><?php echo htmlspecialchars($match['booking_datetime']); ?></td>
                            <td>
                                <!-- Review Match Button -->
                                <a href="refereeMatchDetailsInput.php?match_id=<?php echo htmlspecialchars($match['match_id']); ?> &arena_id=<?php echo htmlspecialchars($match['arena_id']);?> &arena_name=<?php echo htmlspecialchars($match['arena_name']);?>& booking_datetime=<?php echo htmlspecialchars($match['booking_datetime'])?>  " class="btn btn-primary">
                                    Review Match
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- No matches found message -->
            <div class="alert alert-warning text-center">
                No match details found for this referee.
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (Optional, for interactivity like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
