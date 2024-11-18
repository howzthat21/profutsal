<?php
include 'db.php'; // Include your database connection

function updateMatchmakingStatus($pdo) {
    // Get the current time
    
    // Query to fetch matches that need to be updated to 'inprogress' or 'fulltime'
    $sql = "SELECT arena_id, match_id, booking_datetime, status 
            FROM matchmaking 
            WHERE status IN ('lineups', 'inprogress', 'fulltime')";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $matchId = $row['match_id'];
        $bookingDatetime = new DateTime($row['booking_datetime']);
        $status = $row['status'];
        $arenaId=$row['arena_id'];
        $currentDatetime = new DateTime();
        // Check if booking time has arrived to set to 'inprogress'
        if ($status === 'lineups' && $currentDatetime >= $bookingDatetime) {
            // Update to 'inprogress'
            $updateStatusSql = "UPDATE matchmaking SET status = 'inprogress' WHERE match_id = ?";
            $updateStmt = $pdo->prepare($updateStatusSql);
            $updateStmt->execute([$matchId]);
        }

        // Check if it has been 1 hour since booking time to set to 'fulltime'
        $oneHourAfterBooking = clone $bookingDatetime;
        $hour_late = $oneHourAfterBooking->modify('+1 hour');

        $hour_late->format('Y-m-d H:i:s');
        echo "<h1>" . $hour_late->format('Y-m-d H:i:s') . "</h1>";
        var_dump($bookingDatetime);

        $realCurrentDatetime = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));

        echo "<h2>" . $realCurrentDatetime->format('Y-m-d H:i:s') . "</h2>";


        echo "Current Time: " . $realCurrentDatetime->format('Y-m-d H:i:s') . "<br>";
echo "One Hour After Booking: " . $oneHourAfterBooking->format('Y-m-d H:i:s') . "<br>";




        //var_dump($realCurrentDatetime);

        if ($status === 'inprogress' && $realCurrentDatetime >= $hour_late) {
            // Update to 'fulltime'
           $updateStatusSql = "UPDATE matchmaking SET status = 'fulltime' WHERE match_id = ?";
           $updateStmt = $pdo->prepare($updateStatusSql);
          $updateStmt->execute([$matchId]);
       }

        

       try {
        if ($status === 'fulltime') {
            $insertCompletedMatches = "INSERT INTO completed_matches (arena_id, match_id) VALUES (?, ?)";
            $insertCompletedMatchesStmt = $pdo->prepare($insertCompletedMatches);
            $insertCompletedMatchesStmt->execute([$arenaId, $matchId]);
            echo "Match successfully inserted into completed_matches.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
       
        // Set current time to 10 seconds before booking time
        

    }
}
updateMatchmakingStatus($pdo);
?>
