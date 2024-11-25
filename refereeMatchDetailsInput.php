<?php
session_start();
include 'db.php';

if (!isset($_SESSION['referee_id'])) {
    header("Location: refereeLogin.php");
    exit();
}
if (isset($_SESSION['teamAName']) && isset($_SESSION['teamBName'])) {
    $teamAName = $_SESSION['teamAName'];
    $teamBName = $_SESSION['teamBName'];

    
}else{
    echo "session not started";
}
$match_id = $_GET['match_id'];
$arena_id= $_GET['arena_id'];
$arena_name = $_GET['arena_name'];
$booking_datetime= $_GET['booking_datetime'];

if($_SERVER["REQUEST_METHOD"]== "POST"){
    
    $team_a_score= $_POST['team_a_score'];
    $team_b_score= $_POST['team_b_score'];

    $insert_query = "UPDATE completed_matches SET team_a_score = ?, team_b_score = ? WHERE match_id = ?";

    $insert_query_stmt=$pdo->prepare($insert_query);
    $insert_query_stmt->execute([$team_a_score, $team_b_score, $match_id]);
    

    //update referee_matches table where referee_id=? match_id=?

    $update_query="UPDATE referee_matches SET match_review_status='completed' WHERE referee_id=? AND match_id=?";
    $update_query_stmt=$pdo->prepare($update_query);
    $update_query_stmt->execute([$_SESSION['referee_id'], $match_id]);
    
   

    header("Location: afterMatchRatings.php?match_id= $match_id");
    
}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Match Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Match Details</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="refereeMatchDetailsInput.php?match_id=<?php echo $match_id; ?> &arena_id=<?php echo $arena_id;?> &arena_name=<?php echo $arena_name;?>& booking_datetime=<?php echo $booking_datetime?>  " method="POST">
                    <!-- Match ID (Hidden or Read-Only) -->
                    <div class="mb-3">
                        <label for="matchId" class="form-label">Match ID</label>
                        <input type="text" class="form-control" id="matchId" name="match_id" value="<?php echo $match_id ?>" readonly>
                    </div>
                    
                    <!-- Arena Name (Read-Only) -->
                    <div class="mb-3">
                        <label for="arenaName" class="form-label">Arena Name</label>
                        <input type="text" class="form-control" id="arenaName" name="arena_name" value="<?php echo $arena_name?>" readonly>
                    </div>

                    <!--booking_datetime (Read-Only) -->
                    <div class="mb-3">
                        <label for="arenaName" class="form-label">Arena booked time</label>
                        <input type="text" class="form-control" id="arenaName" name="booked_timedate" value="<?php echo $booking_datetime;?>" readonly>
                    </div>
                    
                    <!-- Team A Name -->
                    <div class="mb-3">
                        <label for="teamAName" class="form-label">Team A Name</label>
                        <input type="text" class="form-control" id="teamAName" name="team_a_name" value="<?php echo $teamAName?>" readonly>
                    </div>
                    
                    <!-- Team A Goals -->
                    <div class="mb-3">
                        <label for="teamAGoals" class="form-label">Team A Goals</label>
                        <input type="number" class="form-control" id="teamAGoals" name="team_a_score" min="0" placeholder="Enter goals scored by Team A" >
                    </div>
                    
                    <!-- Team B Name -->
                    <div class="mb-3">
                        <label for="teamBName" class="form-label">Team B Name</label>
                        <input type="text" class="form-control" id="teamBName" name="team_b_name" value="<?php echo $teamBName?>" readonly>
                    </div>
                    
                    <!-- Team B Goals -->
                    <div class="mb-3">
                        <label for="teamBGoals" class="form-label">Team B Goals</label>
                        <input type="number" class="form-control" id="teamBGoals" name="team_b_score" min="0" placeholder="Enter goals scored by Team B" >
                    </div>
                    
                    <!-- Winning Team -->
                    <div class="mb-3">
                        <label for="winningTeam" class="form-label">Winning Team</label>
                        <select class="form-select" id="winningTeam" name="winning_team" >
                            <option value="" selected disabled>Select Winning Team</option>
                            <option value="Team A">Team A (Warriors)</option>
                            <option value="Team B">Team B (Titans)</option>
                            <option value="Draw">Draw</option>
                        </select>
                    </div>
                    
                    <!-- Additional Notes -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Enter any additional comments or details about the match (optional)"></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit Match Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
